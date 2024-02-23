<?php
require_once "core/init.php";

$docentes = Curso::getDocentes($_GET['id_curso']);
//var_dump($docentes);
echo json_encode($docentes);

