<?php
class Curso{

    public static function cadastrar($fields){
        //print_r($fields);
        $_db = DB2::getInstance();
       // die();
        $_db->insert('curso', $fields);
        return $_db;

    }

    public static function cadastrar_docente_tcc($fields){
        $_db = DB2::getInstance();
        // die();
         return $_db->insert('docente_tcc', $fields);
         }

    public static function get(){
        $_db = DB2::getInstance();
        return $_db->getAll('curso');
    }

    public function actualizar($id, $onde, $fields){
        if(!$this->_db->update('curso', $id, $onde, $fields)){
            throw new Exception ("erro no update");
        }
   }

   public static function find($id_curso){
    $_db = DB2::getInstance();
    return $_db->get(array('curso'), array(array('id_curso', '=', $id_curso)));
   }

   public static function getDocentes($id_curso){
        $_db = DB2::getInstance();
        return $_db->get(array('curso', 'docente'), array(array('curso.id_curso', '=', $id_curso), array('docente.id_curso', '=', $id_curso)))->results();
   }
   public static function getMinor($id_curso){
    $_db = DB2::getInstance();
    return $_db->getFromMany(array('minor', 'curso'), array(array('curso.id_curso', '=', 'minor.id_curso'), array('curso.id_curso', '=', $id_curso), array('minor.id_curso', '=', $id_curso)));
   
   }
}