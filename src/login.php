<?php declare(strict_types=1);
include_once("vendor/autoload.php"); // No incluimos nada más
use Dwes\ProyectoVideoclub\Videoclub;

if(isset($_POST["usuario"])){
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    //comprobar de forma dinámica
    $vc = new Videoclub("Severo 8A");
    $vc->incluirSocio("Amancio Ortega","amancio","ortega")->incluirSocio("Pablo Picasso","pablo", "picasso", 2);

    if(empty($usuario) or empty($password)){
        echo "Error: debes introducir usuario y password: ";
        include_once("index.php");    
    }

    else if($usuario=="usuario" and $password=="usuario"){
        session_start();
        $_SESSION["usuario"] = $usuario;
        include_once("main.php");    
    }

    else if($usuario=="admin" and $password=="admin"){
        session_start();
        $_SESSION["usuario"] = $usuario;
        include_once("mainAdmin.php");    
    }

    else{
        $error = "Acceso incorrecto.";
        include_once("index.php");
    }
}

?>