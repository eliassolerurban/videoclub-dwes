<?php
require "vendor/autoload.php";
use Dwes\ProyectoVideoclub\CintaVideo;

$miCinta = new CintaVideo( "https://www.metacritic.com/movie/ghostbusters", "Los cazafantasmas", 23, 3.5, 107); 
echo "<strong>" . $miCinta->titulo . "</strong>"; 
echo "<br>Precio: " . $miCinta->getPrecio() . " euros"; 
echo "<br>Precio IVA incluido: " . $miCinta->getPrecioConIva() . " euros";
$miCinta->muestraResumen();