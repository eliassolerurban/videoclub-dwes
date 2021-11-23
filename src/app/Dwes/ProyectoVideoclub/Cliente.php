<?php

declare(strict_types=1);
namespace Dwes\ProyectoVideoclub;

use Dwes\ProyectoVideoclub\Cliente as ProyectoVideoclubCliente;
use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
* Clase que representa un cliente
* 
* El cliente se encarga de almacenar los soportes que tiene alquilado,
* de manera que podemos alquilar y devolver productos mediante las operaciones
* homónimas.
* 
* @package Dwes\Videoclub\
* @author Elías Soler <solerurban.elias@gmail.com>
*/

class Cliente
{
    /**
    * Array que almacena los soportes alquilados por el cliente
    * @var soportesAlquilados
    */    
    public array $soportesAlquilados;
    /**
    * Cantidad de soportes alquilados por el cliente
    * @var numSoportesAlquilados
    */
    private int $numSoportesAlquilados;
    /**
    * Logger para los registros en logs/videoclub.log
    * @var log
    */
    private Logger $log;

    public function __construct(
        public string $nombre,
        /**
        * Número identidicador del cliente
        * @var numero
        */
        private int $numero,
        private string $usuario,
        private string $password,
        /**
        * Máximo de alquileres que se le permite realizar al cliente
        * @var numero
        */
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
    
    /**
    * Muestra los datos del cliente, además escribe también éstos datos en el log
    * @return cadena como resumen del cliente
    */    
    public function muestraResumen(): string {
        $cadena = "Nombre: " . $this->nombre;
        $cadena .= "<br>Usuario: " . $this->usuario;
        $cadena .= "<br>Id: " . $this->numero;
        $cadena .= "<br>Número de alquileres: " . count($this->soportesAlquilados);

        $this->log->info(str_replace("<br>",", ",$cadena));

        return $cadena;
    }
    
    /**
    * Comprueba si el soporte recibido ya lo tiene alquilado el cliente
    * @param Soporte $soporte Soporte a comprobar
    * @return bool true si lo tiene alquilado
    */
    public function tieneAlquilado(Soporte $s): bool
    {
        return isset($this->soportesAlquilados[$s->getNumero()]);
    }

    /**
    * Alquila el soporte recibido si no lo tiene alquilado y no ha superado su máximo de alquileres
    * @param Soporte $soporte Soporte a alquilar
    * @throws SoporteYaAlquiladoException en caso de tenerlo ya alquilado
    * @throws CupoSuperadoException en caso de haber superado su máximo de alquileres
    * @return this para poder encadenar operaciones
    */
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

    /**
    * Devuelve el soporte recibido si lo tiene alquilado
    * @param Soporte $soporte Soporte a alquilar
    * @throws SoporteNoEncontradoException en caso de no tenerlo alquilado
    * @return this para poder encadenar operaciones
    */
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
