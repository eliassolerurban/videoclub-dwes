<?php

declare(strict_types=1);
namespace Dwes\ProyectoVideoclub;
include_once("Resumible.php");
/**
* Clase que representa un soporte.
* 
* Los soportes son aquellos formatos de productos que se encuentran en el videoclub, ésta es una clase abstracta
* 
* @package Dwes\Videoclub\
* @author Elías Soler <solerurban.elias@gmail.com>
*/
abstract class Soporte implements Resumible{
    
  private static float $iva = 1.21;

  public function __construct(


    public string $titulo, 
    protected int $numero, 
    private float $precio, 
  /**
  * Booleano que indica si el soporte está alquilado por un cliente
  * @var alquilado
  */
    private bool $alquilado = false 
  ) {
  
    $precio = round($precio, 2);

  }
  
  public function setAlquilado(bool $alquilado) {

    $this->alquilado = $alquilado;
  
  }

  public function getPrecio() : float {

    return  $this->precio;
  
  }
  
  public function getPrecioConIVA(): float {
    
    return  round($this->precio * self::$iva, 2);
    
  }

  public function getNumero(): int{

    return $this->numero;

  }
  
  /**
  * Muestra los datos del soporte
  * @return cadena como resumen del soporte
  */
  public function muestraResumen(): string{
    $cadena = "<i>" . $this->titulo . "</i>";
    $cadena .= $this->getPrecio() . "€ (IVA no incluido) <br>";
    
    return $cadena;
  }
}