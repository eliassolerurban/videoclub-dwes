<?php

declare(strict_types=1);
include_once("vendor/autoload.php"); // No incluimos nada más

use Dwes\ProyectoVideoclub\Util\VideoclubException;
use Dwes\ProyectoVideoclub\Videoclub;

if (!isset($_SESSION)) {
    session_start();
}

if ($_SESSION["usuario"] != "admin") {
    die("Debes de ser administrador para acceder a este recurso. <a href='index.php'>Volver al login</a>");
}

$vc = new Videoclub("Severo 8A");

try {
    //voy a incluir unos cuantos soportes de prueba 
    $vc->incluirJuego("God of War", 19.99, "PS4", 1, 1)
        ->incluirJuego("The Last of Us Part II", 49.99, "PS4", 1, 1)
        ->incluirDvd("Torrente", 4.5, "es", "16:9")
        ->incluirDvd("Origen", 4.5, "es,en,fr", "16:9")
        ->incluirDvd("El Imperio Contraataca", 3, "es,en", "16:9")
        ->incluirCintaVideo("Los cazafantasmas", 3.5, 107)
        ->incluirCintaVideo("El nombre de la Rosa", 1.5, 140);

    //mismo para socios 
    $vc->incluirSocio("Amancio Ortega",3,"amancio","ortega")->incluirSocio("Pablo Picasso", 2,"pablo", "picasso");
} catch (VideoclubException $e) {
    echo "Se ha producido un error: " . $e->getMessage();
}

$_SESSION["listaSocios"] = $vc->listarSocios();
$_SESSION["listaProductos"] = $vc->listarProductos();


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
    <?= $_SESSION["listaSocios"]?>
    <h2>Lista de productos:</h2>
    <?= $_SESSION["listaProductos"]?>
    <a href="logout.php">Cerrar sesión</a>
</body>

</html>