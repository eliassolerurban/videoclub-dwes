<?php declare(strict_types=1);

if(!isset($_SESSION)){
    session_start();
}

if ($_SESSION["usuario"] != "admin") {
    die("Debes de ser administrador para acceder a este recurso. <a href='index.php'>Volver al login</a>");
}

if(isset($_GET["id"])){
    $id = $_GET["id"];
    unset($_SESSION["socios"][$id]);

    header("Location: mainAdmin.php");
}

