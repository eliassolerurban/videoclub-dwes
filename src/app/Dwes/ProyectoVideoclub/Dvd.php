<?php declare(strict_types=1);

namespace Dwes\ProyectoVideoclub;
include_once("Soporte.php");

class Dvd extends Soporte{


    public function __construct(

        string $titulo,
        int $numero,
        float $precio,
        public string $idiomas,
        private string $formaPantalla,
    
    )
    {
        parent::__construct($titulo, $numero, $precio);
    }

    public function muestraResumen(): string{
        $cadena =  "<br>";
        $cadena .= "Película en DVD: <br>";
        $cadena .= parent::muestraResumen();
        $cadena .= "Idiomas: $this->idiomas <br>";
        $cadena .= "Formato Pantalla: " . $this->formaPantalla . "<br>";
        
        return $cadena;
    }



}