<?php declare(strict_types=1);

namespace Dwes\ProyectoVideoclub;
include_once("Soporte.php");

/**
* Clase que representa una cinta de vídeo.
* 
* Las cintas de vídeo son un tipo de soporte
* 
* @package Dwes\Videoclub\
* @author Elías Soler <solerurban.elias@gmail.com>
*/

class CintaVideo extends Soporte{

    public function __construct(

        string $titulo,
        int $numero,
        float $precio,
  /**
  * Entero que indica la duración de la cinta en minutos
  * @var int<duracion>
  */
        private int $duracion

    ) {
        
        parent::__construct($titulo, $numero, $precio);

    }
    
  /**
  * Muestra los datos de la cinta de vídeo, aplicando polimorfismo al método de Soporte
  * @return cadena como resumen de la cinta de vídeo
  */    
    public function muestraResumen(): string{
        $cadena =  "<br>";
        $cadena .=  "Película en VHS: <br>";
        $cadena .= parent::muestraResumen();
        $cadena .= "Duración: " . $this->duracion . " minutos <br>";
        
        return $cadena;
    }





}