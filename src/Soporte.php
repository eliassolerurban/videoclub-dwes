<?php

declare(strict_types=1);


class Soporte {
    
  private static float $iva = 1.21;

  public function __construct(


    public string $titulo,
    protected int $numero,
    private float $precio
  ) {
  
    $precio = round($precio, 2);

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

  public function muestraResumen() {
    
    echo "<i>" . $this->titulo . "</i>";
    echo "<br>";
    echo $this->precio . "€ (IVA no incluido)";
    
  }
  
}
