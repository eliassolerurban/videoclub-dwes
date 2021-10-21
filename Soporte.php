<?php 
declare(strict_types=1);


class soporte {
    private static float $iva=1.21;

    public function __construct(

       
        public string $titulo,
        protected string $numero,
        private float $precio
    ) {
  } 

}
