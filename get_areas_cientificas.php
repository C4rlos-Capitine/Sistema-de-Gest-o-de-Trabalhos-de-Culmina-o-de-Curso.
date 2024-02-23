<?php
require_once "core/init.php";

$areas = (array)Area_cientifica::find($_GET['id_curso']);
echo json_encode($areas);
//var_dump($areas);