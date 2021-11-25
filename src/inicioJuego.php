<?php
require "vendor/autoload.php";
use Dwes\ProyectoVideoclub\Juego;


$miJuego = new Juego("https://www.metacritic.com/game/playstation-4/the-last-of-us-part-ii", "The Last of Us Part II", 26, 49.99, "PS4", 1, 1); 
echo "<strong>" . $miJuego->titulo . "</strong>"; 
echo "<br>Precio: " . $miJuego->getPrecio() . " euros"; 
echo "<br>Precio IVA incluido: " . $miJuego->getPrecioConIva() . " euros";
$miJuego->muestraResumen();