<?php declare(strict_types=1);

namespace Dwes\ProyectoVideoclub;
include_once("Soporte.php");

class CintaVideo extends Soporte{

    public function __construct(

        string $titulo,
        int $numero,
        float $precio,
        private int $duracion

    ) {
        
        parent::__construct($titulo, $numero, $precio);

    }
    
    
    public function muestraResumen(): void{
        
        echo "<br>";
        echo "Película en VHS: <br>";
        parent::muestraResumen();
        echo "<br>";
        echo "Duración: " . $this->duracion . " minutos <br>";
    
    }





}