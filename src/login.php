<?php declare(strict_types=1);
include_once("vendor/autoload.php"); // No incluimos nada más
use Dwes\ProyectoVideoclub\Videoclub;

if(isset($_POST["usuario"])){
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    $vc = new Videoclub("");
    $vc->incluirSocio("Amancio Ortega","amancio","ortega")->incluirSocio("Pablo Picasso","pablo", "picasso", 2);

    if(empty($usuario) or empty($password)){
        echo "Error: debes introducir usuario y password: ";
        header("Location: index.php");    
    }
    else{

        if($usuario=="admin" and $password=="admin"){
            session_start();
            $usuarios = [];
            foreach($vc->getSocios() as $socio){
                $usuarios[] = $socio->getUsuario();
            }
            $_SESSION["usuarios"] = $usuarios;
            $_SESSION["usuario"] = $usuario;
            $_SESSION["videoclub"] = $vc;
            header("Location: mainAdmin.php");    
        }
    
        else{
            foreach($vc->getSocios() as $socio){
                if($socio->getUsuario() == $usuario and $socio->getPassword() == $password){
                    session_start();
                    $_SESSION["usuario"] = $usuario;
                    $_SESSION["socio"] = $socio;
                    $_SESSION["videoclub"] = $vc;  
                    header("Location: mainCliente.php");
                }
            }
            
            $error = "Acceso incorrecto.";
            include("index.php");
            
        }
            
    }
}

?>