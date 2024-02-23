<?php
require_once "core/init.php";

$estudante = Estudante::getByRegime($_GET['id_minor'], $_GET['regime']);
print(json_encode($estudante));