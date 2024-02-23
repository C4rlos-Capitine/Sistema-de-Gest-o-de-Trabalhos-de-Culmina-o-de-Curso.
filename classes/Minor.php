<?php

class Minor{
    public static function cadastrar($fields){
        print_r($fields);
        $_db = DB2::getInstance();
       // die();
        return $_db->insert('minor', $fields);
    }

    public static function get(){
        $_db = DB2::getInstance();
        return $_db->getAll('minor');
    }

    public function actualizar($id, $onde, $fields){
        if(!$this->_db->update('minor', $id, $onde, $fields)){
            throw new Exception ("erro no update");
        }
   }
}