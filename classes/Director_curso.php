<?php

class Director_curso{
    public static function cadastrar($fields){
        print_r($fields);
        $_db = DB2::getInstance();
       // die();
        if(!$_db->insert('dir_curso', $fields)){
            throw new Exception('There was a problem creating an account');
      }
    }
    
    public static function get(){
        $_db = DB2::getInstance();
        return $_db->getAll('dir_curso');
    }
    
    public static function getCursos($id_faculdade){
        //echo $id_curso;
        $_db = DB2::getInstance();
    
        //return $_db->getFromMany(array('curso', 'disciplina', 'lecionado_em'), array(array('curso.id_curso', '=', 'lecionado_em.id_curso'), array('curso.id_curso', '=', $id_curso), array('disciplina.id_disciplina', '=', 'lecionado_em.id_disciplina')));
        return $_db->get(array('curso', 'faculdade'), array(array('curso.id_faculdade', '=', $id_faculdade), array('faculdade.id_faculdade', '=', $id_faculdade)))->results();
    }

    public static function getDadosDirector($id_user){
        $_db = DB2::getInstance();
        $dir_curso = $_db->get(array('dir_curso', 'user'), array(array('dir_curso.user_id', '=', $id_user), array('user.id', '=', $id_user)))->results()[0];
        //var_dump($dir_curso->id_curso);
        return $_db->get(array('curso'), array( array('curso.id_curso', '=', $dir_curso->id_curso)))->results()[0];
        // $inf_cursos;
    }

    public static function getUserId($username){
        $_db = DB2::getInstance();
        $field = (is_numeric($username)) ? 'id' : 'username';
        return $_db->get(array('user'), array(array($field, '=', $username)))->first();
    }
    
    public function actualizar($id, $onde, $fields){
        if(!$this->_db->update('dir_curso', $id, $onde, $fields)){
            throw new Exception ("erro no update");
        }
    }
}
