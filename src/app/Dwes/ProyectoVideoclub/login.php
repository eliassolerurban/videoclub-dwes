<?php declare(strict_types=1);

if(isset($_POST["usuario"])){
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    if(empty($usuario) or empty($password)){
        echo "Error: debes introducir usuario y password: ";
        include_once("index.php");
    }
    else{
        if($usuario=="usuario" and $password=="usuario"){
            /*session_start();
            $_SESSION["usuario"] = $usuario;
            include_once("412peliculas.php");*/
        }
        else{
            $error = "Acceso incorrecto.";
            include_once("index.php");
        }
    }
}

?>