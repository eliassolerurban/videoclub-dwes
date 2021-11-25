<?php
require "vendor/autoload.php";

use Dwes\ProyectoVideoclub\Util\VideoclubException;
use Dwes\ProyectoVideoclub\Videoclub;
$vc = new Videoclub("Severo 8A"); 

//voy a incluir unos cuantos soportes de prueba 
$vc->incluirJuego("https://www.metacritic.com/game/playstation-4/god-of-war", "God of War", 19.99, "PS4", 1, 1)
    ->incluirJuego("https://www.metacritic.com/game/playstation-4/the-last-of-us-part-ii", "The Last of Us Part II", 49.99, "PS4", 1, 1)
    ->incluirDvd("https://www.metacritic.com/game/pc/torrente", "Torrente", 4.5, "es","16:9")
    ->incluirDvd("https://www.metacritic.com/movie/inception", "Origen", 4.5, "es,en,fr", "16:9")
    ->incluirDvd("https://www.metacritic.com/movie/star-wars-episode-v---the-empire-strikes-back", "El Imperio Contraataca", 3, "es,en","16:9")
    ->incluirCintaVideo("https://www.metacritic.com/movie/ghostbusters", "Los cazafantasmas", 3.5, 107)
    ->incluirCintaVideo("https://www.metacritic.com/movie/the-name-of-the-rose", "El nombre de la Rosa", 1.5, 140); 

try{
    //listo los productos 
    $vc->listarProductos(); 

    //voy a crear algunos socios 
    //$vc->incluirSocio("Amancio Ortega")->incluirSocio("Pablo Picasso", 2); 

    $vc->alquilaSocioProducto(1,2)->alquilaSocioProducto(1,3); 
    //alquilo otra vez el soporte 2 al socio 1. 
    // no debe dejarme porque ya lo tiene alquilado 
    $vc->alquilaSocioProducto(1,2); 
    //alquilo el soporte 6 al socio 1. 
    //no se puede porque el socio 1 tiene 2 alquileres como máximo 
    $vc->alquilaSocioProducto(1,6); 

    //listo los socios 
    $vc->listarSocios();
}
catch(VideoclubException $e){
    echo "Se ha producido un error: " . $e->getMessage();
}
