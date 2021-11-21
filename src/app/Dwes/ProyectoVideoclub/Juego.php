<?php declare(strict_types=1);

namespace Dwes\ProyectoVideoclub;
include_once("Soporte.php");

class Juego extends Soporte{


    public function __construct(

        string $titulo,
        int $numero,
        float $precio,
        public string $consola,
        private int $minJugadores,
        private int $maxJugadores,
    
    )
    {
        parent::__construct($titulo, $numero, $precio);
    }

    public function muestraResumen(): string{
        $cadena =  "<br>";
        $cadena .= "Juego para: $this->consola<br>";
        $cadena .= "<br>";
        $cadena .= parent::muestraResumen();
        $cadena .= $this->muestraJugadoresPosibles();
        
        return $cadena;
    }

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