<?php declare(strict_types=1);

include_once("Soporte.php");

class CintaVideo extends Soporte{

    public function __construct(

        string $titulo,
        string $numero,
        float $precio,
        private int $duracion

    ) {
        
        parent::__construct($titulo, $numero, $precio);

    }
    
    
    public function muestraResumen(){

        echo "Película en VHS<br>";
        echo $this->titulo . "<br>";
        echo $this->precio . "(IVA no incluido) <br>";
        echo "Duración: " . $this->duracion . "<br>";
    
    }





}