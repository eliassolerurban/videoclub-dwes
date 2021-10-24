<?php

declare(strict_types=1);

class Cliente {

    private array $soportesAlquilados;
    private int $numSoportesAlquilados;

    public function __construct(
        public string $nombre,
        private int $numero,
        private int $maxAlquilerConcurrente = 3,
    ) {
        $soportesAlquilados = [];
        $numSoportesAlquilados = 0;
    }

    public function setNumero(int $numero) {
        $this->numero = $numero;
    }

    public function getNumero(): int {
        return $this->numero;
    }

    public function getNumSoportesAlquilados(): int {
        return $this-> numSoportesAlquilados;
    }

     public function muestraResumen(){
         echo $this->nombre;
         echo count($this->soportesAlquilados);
     }

     public function tieneAlquilado(Soporte $s): bool {
        return isset($this->soportesAlquilados[$s->getNumero()]); //falta revisar
     }

     public function alquilar(Soporte $s): bool {
        if(!$this->tieneAlquilado($s) and count($this->soportesAlquilados) < $this->maxAlquilerConcurrente){
            $this->soportesAlquilados[] = $s;
            $this->numSoportesAlquilados++;
            
            echo "El soporte se ha alquilado correctamente";
            return true;
        }

        echo "No se ha podido alquilar el soporte";
        return false;
    }

    public function devolver(int $numSoporte): bool {
        if($this->tieneAlquilado($this->soportesAlquilados[$numSoporte])){
            unset($this->soportesAlquilados[$numSoporte]);
            $this->numSoportesAlquilados--;

            echo "El soporte se ha devueldo correctamente";
            return true;
        }

        echo "El soporte no se ha podido devolver";
        return false;
    }

    public function listarAlquileres(): void{
        echo "$this->nombre cuenta con $this->numSoportesAlquilados alquileres";
        echo "";
        echo "Los alquileres son:";
        foreach($this->soportesAlquilados as $soportesAlquilado){
            echo $soportesAlquilado->titulo;
        }
    }
}
