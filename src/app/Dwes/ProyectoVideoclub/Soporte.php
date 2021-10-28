<?php

declare(strict_types=1);
namespace Dwes\ProyectoVideoclub;
include_once("Resumible.php");

/*
Ahora es una clase abstracta e implementamos de forma distinta muestraResumen() en cada hijo
*/
abstract class Soporte implements Resumible{
    
  private static float $iva = 1.21;

  public function __construct(


    public string $titulo,
    protected int $numero,
    private float $precio,
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

  public function muestraResumen(): void{
    echo "<i>" . $this->titulo . "</i>";
    echo $this->getPrecio() . "€ (IVA no incluido)";echo "<br>";
  }
}