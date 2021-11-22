<?php

declare(strict_types=1);
namespace Dwes\ProyectoVideoclub;

use Dwes\ProyectoVideoclub\Cliente as ProyectoVideoclubCliente;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class Cliente
{

    public array $soportesAlquilados;
    private int $numSoportesAlquilados;
    private Logger $log;

    public function __construct(
        public string $nombre,
        private int $numero,
        private string $usuario,
        private string $password,
        private int $maxAlquilerConcurrente = 3,

    ) {
        $this->soportesAlquilados = [];
        $this->numSoportesAlquilados = 0;
        
        $this->log = new Logger("VideoclubLogger");
        $this->log->pushHandler(new StreamHandler("logs/videoclub.log", Logger::DEBUG));
        
    }

    
    public function setMaxAlquilerConcurrente(int $maxAlquilerConcurrente){
        $this->maxAlquilerConcurrente = $maxAlquilerConcurrente;
    }
    
    public function setPassword(string $password){
        $this->password = $password;
    }

    public function setNombre(string $nombre){
        $this->nombre = $nombre;
    }

    public function setUsuario(string $usuario){
        $this->usuario = $usuario;
    }

    public function getUsuario(){
        return $this->usuario;
    }
    
    public function getPassword(){
        return $this->password;
    }

    public function setNumero(int $numero): Cliente
    {
        $this->numero = $numero;
        return $this;
    }

    public function getNumero(): int
    {
        return $this->numero;
    }

    public function getNumSoportesAlquilados(): int
    {
        return $this->numSoportesAlquilados;
    }

    public function getAlquileres(): array
    {
        return $this->soportesAlquilados;
    }

    public function muestraResumen(): string {
        $cadena = "Nombre: " . $this->nombre;
        $cadena .= "<br>Usuario: " . $this->usuario;
        $cadena .= "<br>Id: " . $this->numero;
        $cadena .= "<br>Número de alquileres: " . count($this->soportesAlquilados);

        $this->log->info(str_replace("<br>",", ",$cadena));

        return $cadena;
    }
    

    public function tieneAlquilado(Soporte $s): bool
    {
        return isset($this->soportesAlquilados[$s->getNumero()]);
    }

    public function alquilar(Soporte $s): Cliente
    {
        if ($this->tieneAlquilado($s)) {
            $this->log->warning("El cliente $this->numero ya tiene alquilado el soporte $s->titulo");
            throw new SoporteYaAlquiladoException("El cliente ya tiene alquilado el soporte <strong>$s->titulo</strong><br>");
        }

        if ($this->numSoportesAlquilados >= $this->maxAlquilerConcurrente) {
            $this->log->warning("El cliente $this->numero ha superado su máximos de alquileres ($this->numSoportesAlquilados)");
            throw new CupoSuperadoException("El cliente tiene $this->numSoportesAlquilados elementos alquilados.<br>");
        }

        $this->soportesAlquilados[$s->getNumero()] = $s;
            $this->numSoportesAlquilados++;
            $this->log->info("<strong>Alquilado soporte a: </strong> $this->nombre");
            $this->log->info($s->muestraResumen());

            $s->setAlquilado(true);

            return $this;

    }

    public function devolver(int $numSoporte): Cliente
    {
        if ($this->numSoportesAlquilados == 0) {
            throw new SoporteNoEncontradoException("No se ha encontrado el soporte en los alquileres de este cliente.<br>");
        }

        unset($this->soportesAlquilados[$numSoporte]);
        $this->numSoportesAlquilados--;
        $this->log->info("El soporte se ha devueldo correctamente");
        
        $this->soportesAlquilados[$numSoporte]->setAlquilado(false);
        
        return $this;
    }

    public function listarAlquileres(): string
    {
        $cadena= "$this->nombre cuenta con $this->numSoportesAlquilados alquileres";
        $cadena .= "";
        $cadena .= "Los alquileres son:";
        foreach ($this->soportesAlquilados as $soportesAlquilado) {
            $cadena .= $soportesAlquilado->titulo;
        }

        $this->log->info(str_replace("<br>","\n",$cadena));
        
        return $cadena;
    }
}
