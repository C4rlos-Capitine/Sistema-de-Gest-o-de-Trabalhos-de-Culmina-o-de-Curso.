<?php
class Estudante{
    public static function cadastrar($fields){
        //print_r($fields);
        $_db = DB2::getInstance();
       // die();
        return $_db->insert('estudante', $fields);
            
    }

    public static function get(){
        $_db = DB2::getInstance();
        return $_db->getAll('estudante');
    }

    public static function actualizar($id, $onde, $fields){
        if(!$this->_db->update('estudante', $id, $onde, $fields)){
            throw new Exception ("erro no update");
        }
   }

   public static function getEstudantesDoCurso($id_curso){
    $_db = DB2::getInstance();
    return $_db->getFromMany(array('estudante', 'minor', 'curso'), array(array('estudante.id_curso', '=', $id_curso), array('minor.id_curso', '=', $id_curso), array('curso.id_curso', '=', $id_curso), array('estudante.id_minor', '=', 'minor.id_minor')));
   }
   
   public static function getCursoMinor($id_est){
    $_db = DB2::getInstance();
    return $_db->getFromMany(array('estudante', 'minor', 'curso'), array(array('curso.id_curso', '=', 'minor.id_curso'), array('minor.id_minor', '=', 'estudante.id_minor'), array('estudante.codigo_estudante', '=', "'{$id_est}'"), array('estudante.id_curso', '=', 'curso.id_curso')));
   
   }

   public static function getByMinor($id_minor){
    $_db = DB2::getInstance();
    return $_db->getFromMany(array('estudante', 'minor'), array(array('minor.id_minor', '=', 'estudante.id_minor'), array('estudante.id_minor', '=', $id_minor)));
   
   }
   public static function getByRegime($id_minor, $regime){
    $_db = DB2::getInstance();
    return $_db->getFromMany(array('estudante', 'minor'), array(array('minor.id_minor', '=', 'estudante.id_minor'), array('estudante.id_minor', '=', $id_minor), array('estudante.regime', '=', "'{$regime}'")));
   
   }
   public static function getByAno($id_minor, $regime, $ano){
    $_db = DB2::getInstance();
    return $_db->getFromMany(array('estudante', 'minor'), array(array('minor.id_minor', '=', 'estudante.id_minor'), array('estudante.id_minor', '=', $id_minor), array('estudante.regime', '=', "'{$regime}'"), array('estudante.ano_ingresso', '=', "'{$ano}'")));
   
   }
}