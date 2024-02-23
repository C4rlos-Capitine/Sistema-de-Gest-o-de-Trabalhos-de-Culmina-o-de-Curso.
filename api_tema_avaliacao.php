<?php
require_once "core/init.php";

//print_r($_REQUEST);
//print(json_encode($_REQUEST['codigo_estudante']));

//$pdo = require_once 'connect.php';
$response = [];
if(isset($_REQUEST['codigo_estudante']) || isset($_REQUEST['estado']))
{
    $pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
    $codigo_estudante = $_REQUEST['codigo_estudante'];
    $estado = $_REQUEST['estado'];
    $sql = "UPDATE trabalho SET estado = $estado WHERE codigo_estudante = '{$codigo_estudante}'";
    
    $statement = $pdo->prepare($sql);
    
    if($statement->execute()){
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
