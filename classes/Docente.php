<?php
class Docente{

    public static function cadastrar($fields){
        print_r($fields);
        $_db = DB2::getInstance();
       // die();
        if(!$_db->insert('docente', $fields)){
            //throw new Exception('There was a problem creating an account');
            return true;
        }
        return false;
    }

    public static function cadastrar2($fields){
        print_r($fields);
        $_db = DB2::getInstance();
       // die();
        if(!$_db->insert('docente_tcc', $fields)){
            //throw new Exception('There was a problem creating an account');
            return true;
        }
        return false;
    }

    public static function actualizar_funcao($id, $onde, $fields){
        $_db = DB2::getInstance();
        return $_db->update('docente_tcc', $id, $onde, $fields);
   }
    public static function getDocentes(){
        $_db = DB2::getInstance();
        return $_db->getAll('docente');
    }

    public static function find($codigo){
        $_db = DB2::getInstance();
        return $_db->get(array('docente'), array(array('codigo_docente', '=', $codigo)));
    }
    public static function findInfo_adicional($codigo){
        $_db = DB2::getInstance();
        return $_db->get(array('docente_tcc'), array(array('codigo_docente', '=', $codigo)));
    }
    //public static function getTrabalhos()
 }

 
