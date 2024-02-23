<?php
require_once "core/init.php";

$estudante = Estudante::getByAno($_GET['id_minor'], $_GET['regime'], $_GET['ano_ingresso']);
print(json_encode($estudante));