<?php
require_once "core/init.php";
$success = [];
//print_r($_REQUEST);
//die();
if(isset($_REQUEST['codigo_estudante']) && isset($_REQUEST['tema']) && isset($_REQUEST['descricao'])){
    if(Trabalho::actualizar($_REQUEST['codigo_estudante'], 'codigo_estudante', array('tema' => $_REQUEST['tema'], 'descricao' => $_REQUEST['descricao'], 'ficheiro' => NULL, 'estado'=>0)))
    {
        $success["success"] = "true";
        print(json_encode($success));
    }else{
        $success["success"] = "false";
        print(json_encode($success));
    }
}else{
    $success["success"] = "false";
    print(json_encode($success));
}