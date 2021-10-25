<?php declare(strict_types=1);

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

    public function muestraResumen(){

        echo "<i>" . $this->titulo . "</i>";
        echo "<br>";
        echo $this->getPrecio() . "€ (IVA no incluido)";
        echo "<br>";
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