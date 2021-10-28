<?php declare(strict_types=1);

namespace Dwes\ProyectoVideoclub;

use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\VideoclubException;
use Exception;

include_once("Juego.php");
include_once("Dvd.php");
include_once("CintaVideo.php");
include_once("Cliente.php");

class Videoclub {
    
    private array $productos;
    private int $numProductos;
    private array $socios;
    private int $numSocios;
    private int $numProductosAlquilados;
    private int $numTotalAlquileres;

    public function __construct(
        private string $nombre,
    ) {
        $this->productos = [];
        $this->numProductos = 0;

        $this->socios = [];
        $this->numSocios = 0;

        $this->numProductosAlquilados = 0; 
        $this->numTotalAlquileres = 0; 
    }

    public function getNumProductosAlquilados(){
        return $this->numProductosAlquilados;
    }


    public function getNumTotalAlquileres(){
        return $this->numTotalAlquileres;
    }

    private function incluirProducto(Soporte $s): Videoclub {
        $this->productos[$s->getNumero()] = $s;
        $this->numProductos++;
        return $this;
    }
    
    public function incluirCintaVideo(string $titulo, float $precio, int $duracion): Videoclub {
        $c = new CintaVideo($titulo, $this->numProductos, $precio, $duracion);
        $this->incluirProducto($c);
        return $this;
    }

    public function incluirDvd(string $titulo, float $precio, string $idiomas, string $pantalla): Videoclub {
        $d = new Dvd($titulo, $this->numProductos, $precio, $idiomas, $pantalla);
        $this->incluirProducto($d);
        return $this;

    }

    public function incluirJuego(string $titulo, float $precio, string $consola, int $minJ, int $maxJ): Videoclub {
        $j = new Juego($titulo, $this->numProductos, $precio, $consola, $minJ, $maxJ);
        $this->incluirProducto($j);
        return $this;

    }

    public function incluirSocio(string $nombre, int $maxAlquiler=3): Videoclub {
        $c = new Cliente($nombre, $this->numSocios, $maxAlquiler);
        $this->socios[$c->getNumero()] = $c;
        $this->numSocios++;
        return $this;
   
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

    public function alquilaSocioProducto(int $numeroCliente, int $numeroSoporte): Videoclub {
        if(isset($this->socios[$numeroCliente])){
            try {
                $c = $this->socios[$numeroCliente];
                $s = $this->productos[$numeroSoporte];

                $c->alquilar($s);
                
            }
            catch (SoporteNoEncontradoException $e){
                echo "Alerta: " . $e->getMessage() . "\n";

            } 
            catch (CupoSuperadoException $e){
                echo "Alerta: " . $e->getMessage() . "\n";

            }
            catch (SoporteYaAlquiladoException $e){
                echo "Alerta: " . $e->getMessage() . "\n";

            }
            catch (VideoclubException $e){
                echo "Alerta: " . $e->getMessage() . "\n";

            }
            catch (Exception $e){
                echo "Alerta: " . $e->getMessage . "\n";

            }
        }
        return $this;
    }

    public function alquilarSocioProductos(int $numSocio, array $numerosProducto): Videoclub{        
        foreach ($numerosProducto as $numeroProducto) {
            if($this->productos[$numeroProducto]->getAlquilado()){
                throw new SoporteYaAlquiladoException("No puedes alquilar el pack de soportes porque ya tienes alquilado el soporte " . $this->productos[$numeroProducto]);
            }
        }

        foreach ($numerosProducto as $numeroProducto) {
            $this->alquilaSocioProducto($numSocio, $numeroProducto);
        }
        return $this;
    }

}