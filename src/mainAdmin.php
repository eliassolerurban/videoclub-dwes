<?php

declare(strict_types=1);

if (!isset($_SESSION)) {
    session_start();
    echo "<br>se inicia la sesión";
}

if ($_SESSION["usuario"] != "admin") {
    die("Debes de ser administrador para acceder a este recurso. <a href='index.php'>Volver al login</a>");
}

$vc->incluirJuego("God of War", 19.99, "PS4", 1, 1)
    ->incluirJuego("The Last of Us Part II", 49.99, "PS4", 1, 1)
    ->incluirDvd("Torrente", 4.5, "es", "16:9")
    ->incluirDvd("Origen", 4.5, "es,en,fr", "16:9")
    ->incluirDvd("El Imperio Contraataca", 3, "es,en", "16:9")
    ->incluirCintaVideo("Los cazafantasmas", 3.5, 107)
    ->incluirCintaVideo("El nombre de la Rosa", 1.5, 140);

if(!isset($_SESSION["socios"])){
    $_SESSION["socios"] = $vc->getSocios();
    echo "<br>se setean socios";
}

if(!isset($_SESSION["productos"])){
    $_SESSION["productos"] = $vc->getProductos();
    echo "<br>se setean productos";

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
    <h1>
        Bienvenido,
        <?php if (isset($_SESSION["usuario"])) {
            echo $_SESSION["usuario"];
        } ?>
    </h1>
    <h2>Lista de socios:</h2>
    <ul>
    <?php foreach($_SESSION["socios"] as $socio){ ?>    
        <li><?= $socio->muestraResumen() ?></li>
    <?php } ?>
    </ul>
    <h2>Lista de productos:</h2>
    <ul>
    <?php foreach($_SESSION["productos"] as $producto){ ?>    
        <li><?= $producto->muestraResumen() ?></li>
    <?php } ?>
    </ul>
    <a href="logout.php">Cerrar sesión</a>
</body>

</html>