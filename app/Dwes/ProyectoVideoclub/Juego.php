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

    public function muestraResumen(): void{

        parent::muestraResumen();
        echo "Juego para: $this->consola<br>";
        echo "<br>";
        $this->muestraJugadoresPosibles();
    }

    public function muestraJugadoresPosibles(){
        if($this->minJugadores == $this->maxJugadores ){
            if($this->minJugadores == 1){
                echo "Para un jugador";
            }
            else{
                echo "Para $this->minJugadores jugadores";
            }
        }
        else{
            echo "De $this->minJugadores a $this->maxJugadores jugadores";
        }
    }

}