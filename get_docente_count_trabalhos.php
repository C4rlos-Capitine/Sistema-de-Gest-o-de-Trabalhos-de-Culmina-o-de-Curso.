<?php
require_once "core/init.php";

$count = Trabalho::getCountTrabalhos($_GET['id_docente']);
print(json_encode($count->results()[0]));