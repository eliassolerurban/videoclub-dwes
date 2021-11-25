<?php declare(strict_types=1);

namespace Dwes\ProyectoVideoclub;
include_once("Soporte.php");
/**
* Clase que representa un DVD.
* 
* Los DVDs son un tipo de soporte
* 
* @package Dwes\Videoclub\
* @author Elías Soler <solerurban.elias@gmail.com>
*/

class Dvd extends Soporte{


    public function __construct(
        
        string $metacritic,
        string $titulo,
        int $numero,
        float $precio,
 /**
  * Cadena que indica los idiomas disponibles en el DVD
  * @var dvd
  */
        public string $idiomas,
 /**
  * Cadena que indica las dimensiones de la pantalla
  * @var formaPantalla
  */
        private string $formaPantalla,
    
    )
    {
        parent::__construct($metacritic, $titulo, $numero, $precio);
    }

  /**
  * Muestra los datos del DVD, aplicando polimorfismo al método de Soporte
  * @return cadena como resumen del DVD
  */    
    public function muestraResumen(): string{
        $cadena =  "<br>";
        $cadena .= "Película en DVD: <br>";
        $cadena .= parent::muestraResumen();
        $cadena .= "Idiomas: $this->idiomas <br>";
        $cadena .= "Formato Pantalla: " . $this->formaPantalla . "<br>";
        
        return $cadena;
    }



}