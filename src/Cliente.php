<?php

declare(strict_types=1);

class Cliente
{

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
    public function getNumero(): int
    {

        return $this->numero;
    }



    public function setNumero(int $numero)
    {

        $this->numero = $numero;
    }

    public function getNumSoportesAlquilados() :int {

        return $this-> numSoportesAlquilados;
    }

     public function muestraResumen(){
         echo $this->nombre;
         echo count($this->soportesAlquilados);
         
     }

     public function tieneAlquilado(Soporte $s)  : bool
     {

    return isset($this->soportesAlquilados[$s->getNumero()]); //falta revisar

     }

     public function alquilar(Soporte $s) : bool
     {

        if(!tieneAlquilado($s) and count($this->countsoportesAlquilados)-$this->maxAlquilerConcurrente){
// avisar acesso maxAlquilerconcurrente
         foreach($this->soportesAlquilados as $soportesAlquilado){
             if(!tieneAlquilado($s))
         }
     }
    }
}
