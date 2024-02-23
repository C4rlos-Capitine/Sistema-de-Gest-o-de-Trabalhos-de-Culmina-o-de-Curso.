<?php

require_once "core/init.php";

$trabalhos = Trabalho::find($_GET['id_curso']);
//var_dump($trabalhos);
echo json_encode($trabalhos);