<?php declare(strict_types=1);
require "vendor/autoload.php";
use Dwes\ProyectoVideoclub\Cliente;

if (!isset($_SESSION)) {
    session_start();
}

if($_SESSION["usuario"] == "admin"){
    die("Tienes que ser un cliente para acceder a esta página. <a href='index.php'>Volver al login</a>");
}

if(isset($_SESSION["socio"])){
    $socio = $_SESSION["socio"];
    $alquileres = $socio->getAlquileres();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Bienvenido, <?= $_SESSION["usuario"] ?></p>
    <ul>
    <?php foreach($alquileres as $alquiler){ ?>
            <li><?= $alquiler ?></li>
    <?php } ?>
    </ul>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>