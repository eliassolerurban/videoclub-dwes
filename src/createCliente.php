<?php declare(strict_types=1);
include_once("vendor/autoload.php"); // No incluimos nada más
use Dwes\ProyectoVideoclub\Cliente;

if(!isset($_SESSION)){
    session_start();
}

if(isset($_POST)){

    $nombre = $_POST["nombre"];
    if(filter_var($_POST["numero"], FILTER_VALIDATE_INT)){
        $numero = intval($_POST["numero"]);        
    }
    else{
        $error = "Error: el campo número no es válido";
        include("formCreateCliente.php");
    }
    if(in_array($numero, array_keys($_SESSION["socios"]))){
        $error = "Error: el número no es único";
        include("formCreateCliente.php");
        die();
    }

    if(!in_array($_POST["user"], $_SESSION["usuarios"])){
        $usuario = $_POST["user"]; 
    }
    else{
        $error = "Error: el usuario no es único";
        include("formCreateCliente.php");
        die();
    }
    $password = $_POST["password"];
    
    if(filter_var($_POST["maxAlquileres"], FILTER_VALIDATE_INT)){
        $maxAlquileres = intval($_POST["maxAlquileres"]);        }
    else{
        $error = "Error: el campo maxAlquileres no es válido";
        include("formCreateCliente.php");
        die();
    }

    $cl = new Cliente($nombre, $numero, $usuario, $password, $maxAlquileres);
    
}

    $_SESSION["socios"][$numero] = $cl;
    $_SESSION["usuarios"][] = $usuario;
    
    header("Location: mainAdmin.php");

