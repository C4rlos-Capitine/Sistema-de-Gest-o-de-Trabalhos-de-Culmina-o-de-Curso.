<?php
require_once "core/init.php";
$trabalho = Trabalho::findTrabalho($_GET['codigo_estudante'])->results()[0];
//var_dump($trabalho);
print(json_encode($trabalho));