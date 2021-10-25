<?php declare(strict_types=1);

include_once("Juego.php");
include_once("Dvd.php");
include_once("CintaVideo.php");
include_once("Cliente.php");

class Videoclub {
    
    private array $productos;
    private int $numProductos;
    private array $socios;
    private int $numSocios;

    public function __construct(
        private string $nombre,
    ) {
        $this->productos = [];
        $this->numProductos = 0;

        $this->socios = [];
        $this->numSocios = 0;
    }

    private function incluirProducto(Soporte $s): void {
        $this->productos[$s->getNumero()] = $s;
        $this->numProductos++;
    }
    
    public function incluirCintaVideo(string $titulo, float $precio, int $duracion): void {
        $c = new CintaVideo($titulo, $this->numProductos, $precio, $duracion);
        $this->incluirProducto($c);
    }

    public function incluirDvd(string $titulo, float $precio, string $idiomas, string $pantalla): void {
        $d = new Dvd($titulo, $this->numProductos, $precio, $idiomas, $pantalla);
        $this->incluirProducto($d);
    }

    public function incluirJuego(string $titulo, float $precio, string $consola, int $minJ, int $maxJ): void {
        $j = new Juego($titulo, $this->numProductos, $precio, $consola, $minJ, $maxJ);
        $this->incluirProducto($j);
    }

    public function incluirSocio(string $nombre, int $maxAlquiler=3): void {
        $c = new Cliente($nombre, $this->numSocios, $maxAlquiler);
        $this->socios[$c->getNumero()] = $c;
        $this->numSocios++;   
    }

    public function listarProductos(): void{
        echo "<ol>";
        foreach($this->productos as $producto){
            echo "<li>" . $producto->muestraResumen() . "</li>";
        }
        echo "</ol>";
    }

    public function listarSocios(): void{
        echo "<ol>";
        foreach($this->socios as $socio){
            echo "<li>" . $socio->muestraResumen() . "</li>";
        }
        echo "</ol>";
    }

    public function alquilaSocioProducto(int $numeroCliente, int $numeroSoporte): void {
        if(isset($this->socios[$numeroCliente])){
            if(isset($this->productos[$numeroSoporte])){
                $c = $this->socios[$numeroCliente];
                $s = $this->productos[$numeroSoporte];

                $c->alquilar($s);
                
            }
        }
    }

}