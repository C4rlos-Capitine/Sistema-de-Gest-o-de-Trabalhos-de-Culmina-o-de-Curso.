<?php

class Area_cientifica{
    public static function cadastrar($fields){
        //print_r($fields);
        $_db = DB2::getInstance();
       // die();
        if(!$_db->insert('area_cientifica', $fields)){
            //throw new Exception('There was a problem creating an account');
            return true;
        }
        return false;
    }

    public static function associar_docente($fields){
        //print_r($fields);
        $_db = DB2::getInstance();
       // die();
        if(!$_db->insert('actua_em_area', $fields)){
            //throw new Exception('There was a problem creating an account');
            return true;
        }
        return false;
    }

    public static function get(){
        $_db = DB2::getInstance();
        return $_db->getAll('area_cientifica');
    }

    public static function find($id_curso){
        $_db = DB2::getInstance();
        return $_db->get(array('curso', 'area_cientifica'), array(array('curso.id_curso', '=', $id_curso), array('area_cientifica.id_curso', '=', $id_curso)))->results();
    }
    public static function getAreaCientifica($id_docente){
        $_db = DB2::getInstance();
        return $_db->getFromMany(array('area_cientifica', 'actua_em_area'), array(array('area_cientifica.id_area_cientifica', '=', 'actua_em_area.id_area'), array('actua_em_area.codigo_docente', '=', "'$id_docente'")));
    
    }
}