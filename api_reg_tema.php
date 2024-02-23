<?php
require_once "core/init.php";

//print_r($_REQUEST);
//print(json_encode($_REQUEST['codigo_estudante']));

//$pdo = require_once 'connect.php';
$response = [];
if(isset($_REQUEST['codigo_estudante']) || isset($_REQUEST['tema']) || isset($_REQUEST['descricao']) || isset($_REQUEST['id_minor']))
{
    //$pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
    $codigo_estudante = $_REQUEST['codigo_estudante'];
    $tema = $_REQUEST['tema'];
    $descricao = $_REQUEST['descricao'];
    $id_minor = $_REQUEST['id_minor'];
    $data = date('y-m-d');
    //$sql = "INSERT INTO trabalho (codigo_estudante, tema, descricao, data_submissao, id_minor) VALUES('{$codigo_estudante}', '{$tema}', '{$descricao}', '{$data}', {$id_minor})";
    $query = Trabalho::actualizar($_REQUEST['codigo_estudante'], 'codigo_estudante', array('tema'=>$tema, 'descricao'=>$descricao, 'data_submissao'=>$data, 'estado'=>1, 'ano_registo'=>date("Y")));
    
    if($query){
        $response['success'] = "true";
        print(json_encode($response));
    }else{
        $response['success'] = "false";
        print(json_encode($response));
    }
    //var_dump($statement);
}else{
    $response['success'] = "false";
    print(json_encode($response));
}
