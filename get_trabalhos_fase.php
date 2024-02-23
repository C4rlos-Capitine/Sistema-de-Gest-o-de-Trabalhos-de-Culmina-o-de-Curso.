<?php
require_once "core/init.php";

//if(isset($_GET['id_minor']))

$trabalhos = Trabalho::getByRegime($_GET['id_minor'], $_GET['regime']);
$trabalhos_iniciados = array();
$index = 0;
for($i=0; $i<sizeof($trabalhos); $i++){
    if($trabalhos[$i]->tema != null && $trabalhos[$i]->descricao != null){
        if(($_GET['estado'] == 2) && ($trabalhos[$i]->estado == 1 || $trabalhos[$i]->estado == 2)){
            $trabalhos_iniciados[$index] = $trabalhos[$i];
            $index++;
        }
        else if(($_GET['estado'] == 3) && ($trabalhos[$i]->estado == 3 || $trabalhos[$i]->estado == 4)){
            $trabalhos_iniciados[$index] = $trabalhos[$i];
            $index++;
        }
        else if(($_GET['estado'] == 5) && ($trabalhos[$i]->estado == 5)){
            $trabalhos_iniciados[$index] = $trabalhos[$i];
            $index++;
        }
        else if(($_GET['estado'] == 6) && ($trabalhos[$i]->estado == 6)){
            $trabalhos_iniciados[$index] = $trabalhos[$i];
            $index++;
        }
    }
}
//var_dump($trabalhos);
echo json_encode($trabalhos_iniciados);
