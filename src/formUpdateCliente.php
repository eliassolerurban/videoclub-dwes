<?php declare(strict_types=1);

if ($_SESSION["usuario"] != "admin") {
    die("Debes de ser administrador para acceder a este recurso. <a href='index.php'>Volver al login</a>");
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="updateCliente.php" method="post">
        <p><?php if(isset($error)) echo $error ?></p>
        <div>
            <label for="numero">Número del cliente a modificar:</label>
            <input type="number" name="numero" id="numero" required>
        </div>
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>
        <div>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" required>
        </div>
        <div>
            <label for="password">password:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <label for="maxAlquileres">maxAlquileres:</label>
            <input type="number" name="maxAlquileres" id="maxAlquileres" required>
        </div>
        <input type="submit" value="enviar">
    </form>