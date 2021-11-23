<?php
include __DIR__ ."/vendor/autoload.php";
use PHPUnit\Framework\TestCase;
use Dwes\ProyectoVideoclub\CintaVideo;

class CintaVideoTest extends TestCase {
    public function testConstructor()
    {
        $cinta = new CintaVideo("Los cazafantasmas", 23, 3.5, 107); 
        $this->assertSame( $cinta->getNumero(), 23);
    }

    public function testMuestraResumen()
    {
        $cinta = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);
        $resultado = "<br>Película en VHS:";
        $resultado .= "<br>Los cazafantasmas<br>3.5 (IVA no incluido)";
        $resultado .= "<br>Duración: 107 minutos";
        // definimos la expectativa
        $this->expectOutputString($resultado);
        // invocamos al método que hará echo
        echo $cinta->muestraResumen();
    }
}
