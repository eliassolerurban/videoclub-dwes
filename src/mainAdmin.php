<?php declare(strict_types=1);

session_start();

if($_SESSION["usuario"]!="admin"){
    die("Debes de ser administrador para acceder a este recurso. <a href='index.php'>Volver al login</a>");
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
    <p>Bienvenido, <?php if(isset($_SESSION["usuario"])){
        echo $_SESSION["usuario"];
    } ?></p> 
    <? include_once("inicioVideoclub.php"); ?>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>