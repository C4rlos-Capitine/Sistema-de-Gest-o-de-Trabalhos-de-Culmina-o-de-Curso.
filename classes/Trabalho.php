<?php

class Trabalho{
    public static function cadastrar($fields){
        print_r($fields);
        $_db = DB2::getInstance();
       // die();
        if(!$_db->insert('trabalho', $fields)){
            throw new Exception('There was a problem creating an account');
      }
    }

    public static function get(){
        $_db = DB2::getInstance();
        return $_db->getAll('trabalho');
    }

    public static function actualizar($id, $onde, $fields){
        $_db = DB2::getInstance();
        return $_db->update('trabalho', $id, $onde, $fields);
   }

   public static function find($id_curso){
    $_db = DB2::getInstance();
    //, array('codigo_docente', '=', NULL)
    return $_db->getFromMany(array('curso, trabalho, minor'), array(array('curso.id_curso', '=', $id_curso), array('trabalho.id_minor', '=', 'minor.id_minor'), array('curso.id_curso', '=', 'minor.id_curso'), array('minor.id_curso', '=', $id_curso)));
    //return $_db->get(array('curso, trabalho'), array(array('curso.id_curso', '=', $id_curso), array('trabalho.id_curso', '=', $id_curso)))->results();
   }
   public static function find2($id_curso){
    $_db = DB2::getInstance();
    //, array('codigo_docente', '=', NULL)
    return $_db->getFromMany(array('curso, trabalho, minor, estudante'), array(array('curso.id_curso', '=', $id_curso), array('trabalho.id_minor', '=', 'minor.id_minor'), array('curso.id_curso', '=', 'minor.id_curso'), array('minor.id_curso', '=', $id_curso), array('estudante.codigo_estudante', '=', 'trabalho.codigo_estudante'), array('estudante.id_minor', '=', 'minor.id_minor')));
    //return $_db->get(array('curso, trabalho'), array(array('curso.id_curso', '=', $id_curso), array('trabalho.id_curso', '=', $id_curso)))->results();
   }
   public static function find3($id_curso){
    $_db = DB2::getInstance();
    //, array('codigo_docente', '=', NULL)
    return $_db->getFromMany(array('curso, trabalho, minor, estudante, docente'), array(array('curso.id_curso', '=', $id_curso), array('trabalho.id_minor', '=', 'minor.id_minor'), array('curso.id_curso', '=', 'minor.id_curso'), array('minor.id_curso', '=', $id_curso), array('estudante.codigo_estudante', '=', 'trabalho.codigo_estudante'), array('estudante.id_minor', '=', 'minor.id_minor'), array('docente.id_curso', '=', 'curso.id_curso'), array('docente.codigo_docente', '=', 'trabalho.codigo_docente')));
    //return $_db->get(array('curso, trabalho'), array(array('curso.id_curso', '=', $id_curso), array('trabalho.id_curso', '=', $id_curso)))->results();
   }
   public static function findTrabalho($cod_est){
    $_db = DB2::getInstance();
    return $_db->get(array('trabalho'), array(array('codigo_estudante', '=', $cod_est)));
   }
   public static function getTrabalhosDocente($id_docente){
    $_db = DB2::getInstance();
    return $_db->getFromMany(array('trabalho', 'estudante'), array(array('codigo_docente', '=', "'${id_docente}'"), array('estudante.codigo_estudante', '=', 'trabalho.codigo_estudante')));
   }
   public static function getCountTrabalhos($id_docente){
    $_db = DB2::getInstance();
    return $_db->getCount(array('trabalho'),$id_docente, array(array('codigo_docente', '=', $id_docente)));
   }
   public static function getByMinor($id_minor){
    $_db = DB2::getInstance();
    //, array('codigo_docente', '=', NULL)
    return $_db->getFromMany(array('curso, trabalho, minor, estudante'), array(array('trabalho.id_minor', '=', 'minor.id_minor'), array('curso.id_curso', '=', 'minor.id_curso'), array('minor.id_minor', '=', $id_minor), array('estudante.codigo_estudante', '=', 'trabalho.codigo_estudante'), array('estudante.id_minor', '=', 'minor.id_minor')));
    //return $_db->get(array('curso, trabalho'), array(array('curso.id_curso', '=', $id_curso), array('trabalho.id_curso', '=', $id_curso)))->results();
   }
   public static function getByRegime($id_minor, $regime){
    $_db = DB2::getInstance();
    //, array('codigo_docente', '=', NULL)
    return $_db->getFromMany(array('curso, trabalho, minor, estudante'), array(array('trabalho.id_minor', '=', 'minor.id_minor'), array('curso.id_curso', '=', 'minor.id_curso'), array('minor.id_minor', '=', $id_minor), array('estudante.codigo_estudante', '=', 'trabalho.codigo_estudante'), array('estudante.id_minor', '=', 'minor.id_minor'), array('estudante.regime', '=', "'$regime'")));
   }
   
}