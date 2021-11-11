<?php declare(strict_types=1);

if (!isset($_SESSION)) {
    session_start();
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
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>