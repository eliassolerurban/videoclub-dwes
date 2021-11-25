<?php declare(strict_types=1);

namespace Dwes\ProyectoVideoclub;
include_once("Soporte.php");
namespace Dwes\ProyectoVideoclub;
include_once("Soporte.php");

/**
* Clase que representa un juego.
* 
* Los juegos son un tipo de soporte
* 
* @package Dwes\Videoclub\
* @author Elías Soler <solerurban.elias@gmail.com>
*/

class Juego extends Soporte{


    public function __construct(
        string $metacritic,
        string $titulo,
        int $numero,
        float $precio,
        /**
        * Cadena que indica la consola que soporta el juego
        * @var consola
        */    
        public string $consola,
        private int $minJugadores,
        private int $maxJugadores,
    
    )
    {
        parent::__construct($metacritic, $titulo, $numero, $precio);
    }
  /**
  * Muestra los datos del juego, aplicando polimorfismo al método de Soporte
  * @return cadena como resumen del juego
  */    
    public function muestraResumen(): string{
        $cadena =  "<br>";
        $cadena .= "Juego para: $this->consola<br>";
        $cadena .= "<br>";
        $cadena .= parent::muestraResumen();
        $cadena .= $this->muestraJugadoresPosibles();
        
        return $cadena;
    }
  /**
  * Indica la cantidad de jugadores para el juego, devolviendo la cadena correspondiente
  */    
    public function muestraJugadoresPosibles(): string{
        if($this->minJugadores == $this->maxJugadores ){
            if($this->minJugadores == 1){
                return "Para un jugador";
            }
            else{
                return "Para $this->minJugadores jugadores";
            }
        }
        else{
            return "De $this->minJugadores a $this->maxJugadores jugadores";
        }
    }

}