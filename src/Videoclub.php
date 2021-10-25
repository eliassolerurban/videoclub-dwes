<?php declare(strict_types=1);

class Videoclub {
    
    private array $productos;
    private int $numProductos;
    private array $socios;
    private int $numSocios;

    public function __construct(
        private string $nombre,
    ) {
        $productos = [];
        $numProductos = 0;

        $socios = [];
        $numSocios = 0;
    }

    private function incluirProducto 

}