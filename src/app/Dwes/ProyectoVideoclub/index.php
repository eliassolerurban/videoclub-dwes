<?php declare(strict_types=1);

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
    <form action='411login.php' method='post'>
        <fieldset>
            <legend>Login</legend>
            <div>
                <label for='usuario'>Usuario:</label>
                <input type='text' name='usuario' id='usuario' maxlength="50" required>
            </div>
            <div>
                <label for='password'>Contraseña:</label>
                <input type='password' name='password' id='password' maxlength="50" required>
            </div>
            <div>
                <input type='submit' name='enviar' value='Enviar' />
            </div>
        </fieldset>
    </form>
</body>
</html>