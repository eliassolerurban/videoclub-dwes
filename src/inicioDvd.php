<?php
require "vendor/autoload.php";
use Dwes\ProyectoVideoclub\Dvd;


$miDvd = new Dvd("https://www.metacritic.com/movie/inception", "Origen", 24, 15, "es,en,fr", "16:9"); 
echo "<strong>" . $miDvd->titulo . "</strong>"; 
echo "<br>Precio: " . $miDvd->getPrecio() . " euros"; 
echo "<br>Precio IVA incluido: " . $miDvd->getPrecioConIva() . " euros";
$miDvd->muestraResumen();