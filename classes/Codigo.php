<?php
class Codigo{
    public static function gerarCodigo(){
        $_db = DB2::getInstance();
        $codigos = $_db->getAll('codigo')[0];
        $codigos->cod += 1;
        if(!$_db->update('codigo', $codigos->id, 'id', array('cod' => $codigos->cod))){
            throw new Exception ("erro no update");
        }
        return $codigos->cod;
    }
}