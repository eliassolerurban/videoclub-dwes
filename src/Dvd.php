<?php declare(strict_types=1);

include_once("Soporte.php");

class Dvd extends Soporte{

    public array $idiomas;

    public function __construct(

        string $titulo,
        string $numero,
        float $precio,
        private string $formaPantalla,
    
    )
    {
     
        parent::__construct($titulo, $numero, $precio);
        $idiomas = [];
    }

    public function muestraResumen(){

        echo "<br>";
        echo "Película en DVD: <br>";
        parent::muestraResumen();
        echo "Idiomas: " . implode(", ", $this->idiomas) . "<br>";
        echo "Formato Pantalla: " . $this->formaPantalla . "<br>";
        
    }



}