<?php declare(strict_types=1);
require "vendor/autoload.php";
use Dwes\ProyectoVideoclub\Cliente;
if(!isset($_SESSION)){
    session_start();
}

if ($_SESSION["usuario"] != "admin") {
    die("Debes de ser administrador para acceder a este recurso. <a href='index.php'>Volver al login</a>");
}

if(isset($_GET["id"])){
    $id = $_GET["id"];
    $cl = $_SESSION["socios"][$id];
    unset($_SESSION["usuarios"][$cl->getUsuario()]);
    unset($_SESSION["socios"][$id]);
    header("Location: mainAdmin.php");
}

