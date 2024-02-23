<?php 

require_once "core/init.php";
//$pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
//print_r($_REQUEST);

if(isset($_REQUEST['codigo_estudante']) && isset($_FILES['file'])){

    $return["error"] = false;
    $return["msg"] = "";
    $return["success"] = false;
    //array to return
    //print_r($_FILES);
    if(isset($_FILES["file"])){
        //directory to upload file
        $target_dir = "arquivos/monografias"; //create folder files/ to save file
        $filename = $_FILES["file"]["name"]; 

        $novo_nome = uniqid();

        $filePath = "$target_dir/$novo_nome";
        //complete path to save file

        if(move_uploaded_file($_FILES["file"]["tmp_name"], $filePath)) {
            $return["error"] = false;
            //$sql = "UPDATE trabalho SET ficheiro = ";
            if(Trabalho::actualizar($_REQUEST['codigo_estudante'], 'codigo_estudante', array('ficheiro_monografia' => $filePath, 'estado'=>5, 'data_submissao2'=>date("y-m-d")))){
                $return['msg'] = 'trabalho submetido com sucesso';
            }else{
                $return['msg'] = 'trabalho nao submetido [DB]';
            }
        }else{
            $return["error"] = true;
            $return["msg"] =  "Erro ao enviar o ficheiro.";
        }
        }else{
            $return["error"] = true;
            $return["msg"] =  "No file is sublitted.";
        }

    header('Content-Type: application/json');
    // tell browser that its a json data
    echo json_encode($return);
    //converting array to JSON string
    
}


?>