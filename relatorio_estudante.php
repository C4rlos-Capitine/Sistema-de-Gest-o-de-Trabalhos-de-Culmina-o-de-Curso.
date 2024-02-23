<?php
require_once "core/init.php";

$rel = new Relatorio();
$rel->gerarRel($_GET['id_curso']);
