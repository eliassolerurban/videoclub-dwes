<?php declare(strict_types=1);

namespace Dwes\ProyectoVideoclub;

use Dwes\ProyectoVideoclub\Util\CupoSuperadoException;
use Dwes\ProyectoVideoclub\Util\SoporteNoEncontradoException;
use Dwes\ProyectoVideoclub\Util\SoporteYaAlquiladoException;
use Dwes\ProyectoVideoclub\Util\VideoclubException;
use Exception;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

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
    private Logger $log;

    public function __construct(
        private string $nombre,
    ) {
        $this->productos = [];
        $this->numProductos = 0;

        $this->socios = [];
        $this->numSocios = 0;

        $this->numProductosAlquilados = 0; 
        $this->numTotalAlquileres = 0;
        
        $this->log = new Logger("VideoclubLogger");
        $this->log->pushHandler(new StreamHandler("logs/videoclub.log", Logger::DEBUG));
    }

    public function getProductos(){
        return $this->productos;
    }


    public function getSocios(){
        return $this->socios;
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

    public function incluirSocio(string $nombre, string $usuario, string $password, int $maxAlquiler=3): Videoclub {
        $c = new Cliente($nombre, $this->numSocios, $usuario, $password, $maxAlquiler);
        $this->socios[$c->getNumero()] = $c;
        $this->numSocios++;
        return $this;
   
    }

    public function listarProductos(): string{
        $cadena = "<ol>";
        foreach($this->productos as $producto){
            $cadena .= "<li>" . $producto->muestraResumen() . "</li>";
        }
        $cadena .= "</ol>";

        $cadenaLog = str_replace("<ol>","[ ", str_replace("</ol>"," ]",str_replace("<li>", " ", str_replace("</li>",", ",$cadena))));
        $this->log->info($cadenaLog, $this->productos);
        
        return $cadena;
    }

    public function listarSocios(): string{
        $cadena = "<ol>";
        foreach($this->socios as $socio){
            $cadena .= "<li>" . $socio->muestraResumen() . "</li>";
        }
        $cadena .= "</ol>";

        $cadenaLog = str_replace("<ol>","[ ", str_replace("</ol>"," ]",str_replace("<li>", " ", str_replace("</li>",", ",$cadena))));
        $this->log->info($cadenaLog);

        return $cadena;
    }

    public function alquilaSocioProducto(int $numeroCliente, int $numeroSoporte): Videoclub {
        if(isset($this->socios[$numeroCliente])){
            try {
                $cliente = $this->socios[$numeroCliente];
                $soporte = $this->productos[$numeroSoporte];

                $cliente->alquilar($soporte);
                
            }
            catch (SoporteNoEncontradoException $e){
                $this->log->warning( "Alerta: " . $e->getMessage(), $cliente, $soporte);

            } 
            catch (CupoSuperadoException $e){
                $this->log->warning( "Alerta: " . $e->getMessage(), $cliente, $soporte);

            }
            catch (SoporteYaAlquiladoException $e){
                $this->log->warning( "Alerta: " . $e->getMessage(), $cliente, $soporte);

            }
            catch (VideoclubException $e){
                $this->log->warning( "Alerta: " . $e->getMessage(), $cliente, $soporte);

            }
            catch (Exception $e){
                $this->log->warning( "Alerta: " . $e->getMessage(), $cliente, $soporte);
            }
        }
        return $this;
    }

    public function alquilarSocioProductos(int $numSocio, array $numerosProducto): Videoclub{        
        foreach ($numerosProducto as $numeroProducto) {
            if($this->productos[$numeroProducto]->getAlquilado()){
                $this->log->warning("No puedes alquilar el pack de soportes porque ya tienes alquilado el soporte " . $this->productos[$numeroProducto]);
                throw new SoporteYaAlquiladoException("No puedes alquilar el pack de soportes porque ya tienes alquilado el soporte " . $this->productos[$numeroProducto]);
            }
        }

        foreach ($numerosProducto as $numeroProducto) {
            $this->alquilaSocioProducto($numSocio, $numeroProducto);
        }
        return $this;
    }

    public function devolverSocioProducto(int $numeroCliente, int $numeroProducto): Videoclub{
        if(isset($this->socios[$numeroCliente])){
            try {
                $cliente = $this->socios[$numeroCliente];
                $soporte = $this->productos[$numeroProducto];

                $cliente->devolver($soporte);
                
            }
            catch (SoporteNoEncontradoException $e){
                $this->log->warning( "Alerta: " . $e->getMessage(), $cliente, $soporte);

            } 
            catch (CupoSuperadoException $e){
                $this->log->warning( "Alerta: " . $e->getMessage(), $cliente, $soporte);

            }
            catch (SoporteYaAlquiladoException $e){
                $this->log->warning( "Alerta: " . $e->getMessage(), $cliente, $soporte);

            }
            catch (VideoclubException $e){
                $this->log->warning( "Alerta: " . $e->getMessage(), $cliente, $soporte);

            }
            catch (Exception $e){
                $this->log->warning( "Alerta: " . $e->getMessage(), $cliente, $soporte);

            }
        }
        return $this;
    }

    public function devolverSocioProductos(int $numSocio, array $numerosProducto): Videoclub{        
        foreach ($numerosProducto as $numeroProducto) {
            if(!$this->productos[$numeroProducto]->getAlquilado()){
                throw new SoporteYaAlquiladoException("No puedes devolver el pack de soportes porque no tienes alquilado el soporte " . $this->productos[$numeroProducto]);
            }
        }

        foreach ($numerosProducto as $numeroProducto) {
            $this->devolverSocioProducto($numSocio, $numeroProducto);
        }
        return $this;
    }

}