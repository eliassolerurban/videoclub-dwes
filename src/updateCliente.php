<?php declare(strict_types=1);
include __DIR__ ."/vendor/autoload.php";
use Dwes\ProyectoVideoclub\Cliente;

if(!isset($_SESSION)){
    session_start();
}

if(isset($_POST)){

    if(filter_var($_POST["numero"], FILTER_VALIDATE_INT)){
        $numero = intval($_POST["numero"]);        
    }
    else{
        $error = "Error: el campo número no es válido";
        include("formUpdateCliente.php");
    }

    
    if(!in_array($numero, array_keys($_SESSION["socios"]))){
        $error = "Error: el número no existe";
        include("formUpdateCliente.php");
        die();
    }
    else{
        $cl = $_SESSION["socios"][$numero];
    }
    
    $nombre = $_POST["nombre"];
    
    if(!in_array($_POST["user"], $_SESSION["usuarios"]) or $_POST["user"] == $cl->getUsuario()){
        $usuario = $_POST["user"]; 
    }
    else{
        $error = "Error: el usuario no es único";
        include("formUpdateCliente.php");
        die();
    }
    $password = $_POST["password"];
    
    if(filter_var($_POST["maxAlquileres"], FILTER_VALIDATE_INT)){
        $maxAlquileres = intval($_POST["maxAlquileres"]);        }
    else{
        $error = "Error: el campo maxAlquileres no es válido";
        include("formUpdateCliente.php");
        die();
    }

    unset($_SESSION["usuarios"][$cl->getUsuario()]);

    $cl->setNombre($nombre);
    $cl->setUsuario($usuario);
    $cl->setPassword($password);
    $cl->setMaxAlquilerConcurrente($maxAlquileres);
    
    //$cl = new Cliente($nombre, $numero, $usuario, $password, $maxAlquileres);
    
}

    //$_SESSION["socios"][] = $cl;
    $_SESSION["usuarios"][] = $usuario;
    
    header("Location: mainAdmin.php");

