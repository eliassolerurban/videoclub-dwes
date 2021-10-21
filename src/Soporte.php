<?php

declare(strict_types=1);


class Soporte {
    
  private static float $iva = 1.21;

  public function __construct(


    public string $titulo,
    protected string $numero,
    private float $precio
  ) {
  
  }
  
  public function getPrecio() : float {

    return  $this->precio;
  
  }
  
  public function getPrecioConIVA(): float {
    
    return  $this->precio * self::$iva;
    
  }

  public function getNumero(): string{

    return $this->numero;

  }

  public function muestraResumen() {
    
    echo "<i>" . $this->titulo . "</i>";
    echo "<br>";
    echo $this->precio . " (IVA no incluido)";
    
  }
  
}
