<?php declare(strict_types=1);
include_once("vendor/autoload.php"); // No incluimos nada más
use Dwes\ProyectoVideoclub\Videoclub;

if(isset($_POST["usuario"])){
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    $vc = new Videoclub("");
    $vc->incluirSocio("Amancio Ortega","amancio","ortega")->incluirSocio("Pablo Picasso","pablo", "picasso", 2);

    $login = [];

    foreach($vc->getSocios() as $socio){
        $login[$socio->getUsuario()] = $socio->getPassword();  
    }

    if(empty($usuario) or empty($password)){
        echo "Error: debes introducir usuario y password: ";
        include_once("index.php");    
    }
    
    else if($login[$usuario] == $password){
        session_start();
        $_SESSION["usuario"] = $usuario;
        include_once("mainCliente.php");
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