<?php 
require_once 'core/init.php';
class Filtro{
    public $campo;
    public $operador;
    public $valor;

    public function __construct($campo, $operador, $valor){
        $this->campo = $campo;
        $this->operador = $operador;
        $this->valor = $valor;
    }
}