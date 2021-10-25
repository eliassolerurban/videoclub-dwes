<?php declare(strict_types=1);

interface Resumible{
    public function muestraResumen(): void;
}

/*
Soporte implementará esta interfaz y a su vez sus hijos lo harán al heredar de ésta,
por lo tanto no tendremos ni que hacer el include ni volver a escribir el implements en sus hijos
*/

?>