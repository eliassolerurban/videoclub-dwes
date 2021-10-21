<?php

declare(strict_types=1);


class Soporte
{
    private static float $iva = 1.21;

    public function __construct(


        public string $titulo,
        protected string $numero,
        private float $precio
    ) {
    }
    public function getPrecio() : float
    {

        return  $this->precio;
    }
    public function getPrecioConIva(): float
    {

    
    return  $this->$this->precio * self::iva;
    }
}
