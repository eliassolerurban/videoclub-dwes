<?php declare(strict_types=1);

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

    public function muestraResumen(): void{

        echo "<br>";
        echo "Película en DVD: <br>";
        parent::muestraResumen();
        echo "Idiomas: $this->idiomas <br>";
        echo "Formato Pantalla: " . $this->formaPantalla . "<br>";
        
    }



}