<?php
require "vendor/autoload.php";
use Dwes\ProyectoVideoclub\Soporte;

//https://github.com/eliassolerurban/videoclub-dwes
$soporte1 = new Soporte("https://www.metacritic.com/movie/tenet", "Tenet", 22, 3); 
echo "<strong>" . $soporte1->titulo . "</strong>"; 
echo "<br>Precio: " . $soporte1->getPrecio() . " euros"; 
echo "<br>Precio IVA incluido: " . $soporte1->getPrecioConIVA() . " euros";
$soporte1->muestraResumen();
