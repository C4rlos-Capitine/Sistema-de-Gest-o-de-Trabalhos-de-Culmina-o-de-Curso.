<?php
require_once "core/init.php";

$docentes = (array)Docente::getDocentes();
print(json_encode($docentes));