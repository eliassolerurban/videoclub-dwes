<?php
require "vendor/autoload.php";

use Dwes\ProyectoVideoclub\CintaVideo;
use Dwes\ProyectoVideoclub\Cliente;
use Dwes\ProyectoVideoclub\Juego;
use Dwes\ProyectoVideoclub\Dvd;
use Dwes\ProyectoVideoclub\Util\VideoclubException;

//instanciamos un par de objetos cliente
$cliente1 = new Cliente("Bruce Wayne", 23, "", "");
$cliente2 = new Cliente("Clark Kent", 33, "", "");

//mostramos el número de cada cliente creado 
echo "<br>El identificador del cliente 1 es: " . $cliente1->getNumero();
echo "<br>El identificador del cliente 2 es: " . $cliente2->getNumero();

//instancio algunos soportes 
$soporte1 = new CintaVideo("https://www.metacritic.com/movie/ghostbusters", "Los cazafantasmas", 23, 3.5, 107);
$soporte2 = new Juego("https://www.metacritic.com/game/playstation-4/the-last-of-us-part-ii", "The Last of Us Part II", 26, 49.99, "PS4", 1, 1);  
$soporte3 = new Dvd("https://www.metacritic.com/movie/inception", "Origen", 24, 15, "es,en,fr", "16:9");
$soporte4 = new Dvd("https://www.metacritic.com/movie/star-wars-episode-v---the-empire-strikes-back", "El Imperio Contraataca", 4, 3, "es,en","16:9");

try{
    //alquilo algunos soportes
    $cliente1->alquilar($soporte1)->alquilar($soporte2)->alquilar($soporte3);
    
    //voy a intentar alquilar de nuevo un soporte que ya tiene alquilado
    $cliente1->alquilar($soporte1);
    //el cliente tiene 3 soportes en alquiler como máximo
    //este soporte no lo va a poder alquilar
    $cliente1->alquilar($soporte4);
    //este soporte no lo tiene alquilado
    $cliente1->devolver(4);
    //devuelvo un soporte que sí que tiene alquilado
    $cliente1->devolver(2);
    //alquilo otro soporte
    $cliente1->alquilar($soporte4);
    //listo los elementos alquilados
    $cliente1->listarAlquileres();
    //este cliente no tiene alquileres
    $cliente2->devolver(2);
}
catch(VideoclubException $e){
    echo "Hay un error: " . $e->getMessage();
}

foreach ($cliente1->getAlquileres() as $alquiler){
    echo $alquiler->muestraResumen();
    echo "Puntuación: " . $alquiler->getPuntuacion();
    echo "<br>";
    echo "<br>";
    echo "<br>";
}


foreach ($cliente2->getAlquileres() as $alquiler){
    echo $alquiler->muestraResumen();
    echo "Puntuación: " . $alquiler->getPuntuacion();
    echo "<br>";
    echo "<br>";
    echo "<br>";

}