<?php declare(strict_types=1);

namespace Dwes\ProyectoVideoclub;
/**
*Soporte implementará esta interfaz y a su vez sus hijos lo harán al heredar de ésta,
*por lo tanto no tendremos ni que hacer el include ni volver a escribir el implements en sus hijos 
*
*@package Dwes\Videoclub\
* @author Elías Soler <solerurban.elias@gmail.com>
*/

/**
* Este método será sobreescrito por la clase Soporte
*/    
interface Resumible{
    public function muestraResumen(): string;
}
?>