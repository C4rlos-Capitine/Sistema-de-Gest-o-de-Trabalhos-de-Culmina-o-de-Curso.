<?php

require_once "core/init.php";

$cursos = Faculdade::getCursos($_GET['id_faculdade']);

echo json_encode($cursos);