<?php
spl_autoload_register( function($nombreClase) {
    $nombreClase = str_replace("\\","/",$nombreClase);
    include_once "app/" . $nombreClase . ".php";
} );


?>