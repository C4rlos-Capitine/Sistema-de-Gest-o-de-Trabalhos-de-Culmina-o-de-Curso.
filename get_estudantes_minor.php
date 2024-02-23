<?php
require_once "core/init.php";

$estudantes = Estudante::getByMinor($_GET['id_minor']);

print(json_encode($estudantes));