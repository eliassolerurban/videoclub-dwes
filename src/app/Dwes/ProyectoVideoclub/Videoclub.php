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

/**
* Clase que representa un videoclub
* 
* El videoclub se encarga de almacenar los cluentes así como los soportes,
* además de funcionar como punto de encuentro entre los distintos tipos de soporte
* y los clientes, gestionando los alquileres y devoluciones.
* @package Dwes\Videoclub\
* @author Elías Soler <solerurban.elias@gmail.com>
*/

class Videoclub {
    /**
    * Array que almacena los soportes disponibles
    * @var productos
    */    
    private array $productos;
    /**
    * Entero que nos indica la cantidad de productos de los que dispone el videoclub
    * @var numProductos
    */
    private int $numProductos;
    /**
    * Array que almacena los clientes del videoclub
    * @var socios
    */
    private array $socios;
    /**
    * Entero que nos indica la cantidad de productos de los que dispone el videoclub
    * @var numSocios
    */
    private int $numSocios;
    /**
    * Entero que nos indica la cantidad de productos alquilados por algún cliente
    * @var numSocios
    */
    private int $numProductosAlquilados;
    /**
    * Entero que nos indica la cantidad de productos alquilados por algún cliente
    * @var numSocios
    */
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

   /**
    * Incluye el soporte recibido a la colección de productos del videoclub
    * @param s soporte a incluir
    * @return this para poder encadenar operaciones
    */

    private function incluirProducto(Soporte $s): Videoclub {
        $this->productos[$s->getNumero()] = $s;
        $this->numProductos++;
        return $this;
    }
    
   /**
    * Incluye una cinta de vídeo que se crea a partir de los parámetros que se reciben 
    * @param titulo
    * @param precio
    * @param duracion
    * @return this para poder encadenar operaciones
    */

    public function incluirCintaVideo(string $metacritic, string $titulo, float $precio, int $duracion): Videoclub {
        $c = new CintaVideo($metacritic, $titulo, $this->numProductos, $precio, $duracion);
        $this->incluirProducto($c);
        return $this;
    }

   /**
    * Incluye un DVD que se crea a partir de los parámetros que se reciben 
    * @param titulo
    * @param precio
    * @param idiomas
    * @param pantalla
    * @return this para poder encadenar operaciones
    */

    public function incluirDvd(string $metacritic,string $titulo, float $precio, string $idiomas, string $pantalla): Videoclub {
        $d = new Dvd($metacritic, $titulo, $this->numProductos, $precio, $idiomas, $pantalla);
        $this->incluirProducto($d);
        return $this;

    }

   /**
    * Incluye un juego que se crea a partir de los parámetros que se reciben 
    * @param titulo
    * @param precio
    * @param consola
    * @param minJ
    * @param maxJ
    * @return this para poder encadenar operaciones
    */

    public function incluirJuego(string $metacritic, string $titulo, float $precio, string $consola, int $minJ, int $maxJ): Videoclub {
        $j = new Juego($metacritic, $titulo, $this->numProductos, $precio, $consola, $minJ, $maxJ);
        $this->incluirProducto($j);
        return $this;

    }

   /**
    * Incluye un socio que se crea a partir de los parámetros que se reciben 
    * @param nombre
    * @param usuario
    * @param password
    * @param maxAlquiler
    * @return this para poder encadenar operaciones
    */

    public function incluirSocio(string $nombre, string $usuario, string $password, int $maxAlquiler=3): Videoclub {
        $c = new Cliente($nombre, $this->numSocios, $usuario, $password, $maxAlquiler);
        $this->socios[$c->getNumero()] = $c;
        $this->numSocios++;
        return $this;
   
    }

    /**
    * Lista los productos de este videoclub
    * @return cadena con los productos
    */

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

    /**
    * Lista los socios de este videoclub
    * @return cadena con los socios
    */


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

    /**
    * Alquila el soporte recibido al cliente recibido si no lo tiene alquilado y el cliente no ha superado su máximo de alquileres
    * @param numeroCliente como identificador del cliente
    * @param numeroSoporte como identificador del soporte
    * @throws SoporteNoEncontradoException en caso no encontrar el soporte en el videoclub
    * @throws CupoSuperadoException en caso de haber superado su máximo de alquileres
    * @throws SoporteYaAlquiladoException en caso de tenerlo ya alquilado
    * @throws VideoclubException en caso de ser otra excepción de Videoclub
    * @throws Exception en caso de ser otra excepción
    * @return this para poder encadenar operaciones
    */

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

    /**
    * Alquila el pack de soportes recibido al cliente recibido si no tiene alquilado alguno
    * de esos soportes alquilados
    * @param numeroSocio como identificador del socio
    * @param numerosProducto como colección de identificadores de los soportes
    * @throws SoporteYaAlquiladoException en caso de tenerlo ya alquilado
    * @return this para poder encadenar operaciones
    */

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

    
    /**
    * El cliente que corresponde al numeroCliente recibido devuelve el producto que corresponde al numeroSoporte recibido si lo tiene alquilado
    * @param numeroCliente como identificador del cliente
    * @param numeroProducto como identificador del producto
    * @throws SoporteNoEncontradoException en caso no encontrar el soporte en el videoclub
    * @throws CupoSuperadoException en caso de haber superado su máximo de alquileres
    * @throws SoporteYaAlquiladoException en caso de tenerlo ya alquilado
    * @throws VideoclubException en caso de ser otra excepción de Videoclub
    * @throws Exception en caso de ser otra excepción
    * @return this para poder encadenar operaciones
    */
    
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

    /**
    * Devuelve el pack de soportes recibido al cliente recibido si tiene alquilado todos
    * esos soportes
    * @param numeroSocio como identificador del socio
    * @param numerosProducto como colección de identificadores de los soportes
    * @throws SoporteNoEncontradoException en caso de no tenerlo alquilado
    * @return this para poder encadenar operaciones
    */

    public function devolverSocioProductos(int $numSocio, array $numerosProducto): Videoclub{        
        foreach ($numerosProducto as $numeroProducto) {
            if(!$this->productos[$numeroProducto]->getAlquilado()){
                throw new SoporteNoEncontradoException("No puedes devolver el pack de soportes porque no tienes alquilado el soporte " . $this->productos[$numeroProducto]);
            }
        }

        foreach ($numerosProducto as $numeroProducto) {
            $this->devolverSocioProducto($numSocio, $numeroProducto);
        }
        return $this;
    }

}