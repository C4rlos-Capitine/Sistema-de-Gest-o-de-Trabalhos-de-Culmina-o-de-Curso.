<?php
require_once "core/init.php";

$trabalhos = (array)Trabalho::getTrabalhosDocente($_REQUEST['codigo_docente']);
//print_r($trabalhos);

//$trabalhos = (array)Trabalho::find2($_GET['id_curso']);
//var_dump($trabalhos);
print(json_encode($trabalhos));