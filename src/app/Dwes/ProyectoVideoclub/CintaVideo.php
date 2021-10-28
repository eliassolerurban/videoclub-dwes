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
    
    
    public function muestraResumen(): string{
        $cadena =  "<br>";
        $cadena .=  "Película en VHS: <br>";
        $cadena .= parent::muestraResumen();
        $cadena .= "Duración: " . $this->duracion . " minutos <br>";
        
        return $cadena;
    }





}