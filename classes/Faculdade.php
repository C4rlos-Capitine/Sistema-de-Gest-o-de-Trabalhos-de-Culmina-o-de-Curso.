<?php
class Faculdade{
    public static function cadastrar($fields){
        print_r($fields);
        $_db = DB2::getInstance();
       // die();
        return $_db->insert('faculdade', $fields);
    }

    public static function get(){
        $_db = DB2::getInstance();
        return $_db->getAll('faculdade');
    }

    public static function getCursos($id_faculdade){
        //echo $id_curso;
        $_db = DB2::getInstance();

        //return $_db->getFromMany(array('curso', 'disciplina', 'lecionado_em'), array(array('curso.id_curso', '=', 'lecionado_em.id_curso'), array('curso.id_curso', '=', $id_curso), array('disciplina.id_disciplina', '=', 'lecionado_em.id_disciplina')));
        return $_db->get(array('curso', 'faculdade'), array(array('curso.id_faculdade', '=', $id_faculdade), array('faculdade.id_faculdade', '=', $id_faculdade)))->results();
    }

    public function actualizar($id, $onde, $fields){
        if(!$this->_db->update('faculdade', $id, $onde, $fields)){
            throw new Exception ("erro no update");
        }
   }
}