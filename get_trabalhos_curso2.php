<?php

require_once "core/init.php";

$trabalhos = (array)Trabalho::find2($_GET['id_curso']);
$trabalhos_iniciados = array();
$index = 0;
for($i=0; $i<sizeof($trabalhos); $i++){
    if($trabalhos[$i]->tema != null && $trabalhos[$i]->descricao != null){
        $trabalhos_iniciados[$index] = $trabalhos[$i];
        $index++;
    }
}
//var_dump($trabalhos);
echo json_encode($trabalhos_iniciados);