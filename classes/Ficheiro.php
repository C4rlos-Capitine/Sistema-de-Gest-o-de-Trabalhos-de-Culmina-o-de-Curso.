<?php

class Ficheiro{
    public static function cadastrar($fields){
        print_r($fields);
        $_db = DB2::getInstance();
       // die();
        if(!$_db->insert('arquivo', $fields)){
            throw new Exception('There was a problem creating an account');
      }
    }

    public static function get(){
        $_db = DB2::getInstance();
        return $_db->getAll('arquivo');
    }

    public function actualizar($id, $onde, $fields){
        if(!$this->_db->update('arquivo', $id, $onde, $fields)){
            throw new Exception ("erro no update");
        }
   }
}