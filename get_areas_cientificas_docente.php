<?php
require_once "core/init.php";

$areas = Area_cientifica::getAreaCientifica($_GET['id_docente']);
//var_dump($areas);
echo json_encode($areas);