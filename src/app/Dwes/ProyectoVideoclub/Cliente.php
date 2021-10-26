<?php

declare(strict_types=1);

namespace Dwes\ProyectoVideoclub;

use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;

class Cliente
{

    public array $soportesAlquilados;
    private int $numSoportesAlquilados;

    public function __construct(
        public string $nombre,
        private int $numero,
        private int $maxAlquilerConcurrente = 3,
    ) {
        $this->soportesAlquilados = [];
        $this->numSoportesAlquilados = 0;
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

    public function muestraResumen()
    {
        echo $this->nombre;
        echo count($this->soportesAlquilados);
    }

    public function tieneAlquilado(Soporte $s): bool
    {
        return isset($this->soportesAlquilados[$s->getNumero()]);
    }

    public function alquilar(Soporte $s): Cliente
    {

        if (!$this->tieneAlquilado($s)) {
            if ($this->numSoportesAlquilados < $this->maxAlquilerConcurrente) {
                $this->soportesAlquilados[$s->getNumero()] = $s;
                $this->numSoportesAlquilados++;

                echo "<br>";
                echo "<br>";
                echo "<strong>Alquilado soporte a: </strong> $this->nombre";
                echo "<br>";
                echo $s->muestraResumen();
                return $this;
            } else {
                throw new CupoSuperadoException("CupoSuperadoException: El cliente tiene $this->numSoportesAlquilados elementos alquilados.");
            }
        } else {
            throw new SoporteYaAlquiladoException("SoporteYaAlquiladoException: El cliente ya tiene alquilado el soporte <strong>$s->titulo</strong>");
        }

        return $this;
    }

    public function devolver(int $numSoporte): bool
    {
        if ($this->numSoportesAlquilados != 0) {
            unset($this->soportesAlquilados[$numSoporte]);
            $this->numSoportesAlquilados--;

            echo "El soporte se ha devueldo correctamente";
            return true;
        }
        throw new SoporteNoEncontradoException("SoporteNoEncontradoException: No se ha encontrado el soporte en los alquileres de este cliente.");
        return false;
    }

    public function listarAlquileres(): void
    {
        echo "$this->nombre cuenta con $this->numSoportesAlquilados alquileres";
        echo "";
        echo "Los alquileres son:";
        foreach ($this->soportesAlquilados as $soportesAlquilado) {
            echo $soportesAlquilado->titulo;
        }
    }
}
