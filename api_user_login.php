<?php
require_once "core/init.php";
$estudantes = (array)Estudante::get();
$estudante = [];
$response = [];
for($i=0; $i<sizeof($estudantes); $i++){
    if($estudantes[$i]->codigo_estudante == $_REQUEST['codigo']){
        $estudante = $estudantes[$i];
        $estudante->success = "true";
        //$response["success"] = "true";
        //print(json_encode($estudante));
        
        $informacoes_curso = (array)Estudante::getCursoMinor($estudante->codigo_estudante);
        $estudante->designacao = $informacoes_curso[0]->designacao;
        $estudante->designacao_minor = $informacoes_curso[0]->designacao_minor;
        //$estudante->id_faculdade = $informacoes_curso[0]->id_faculdade;
        //$estudante->faculdade = $informacoes_curso[0]->nome;
        $trabalho = Trabalho::findTrabalho($estudante->codigo_estudante);
        if($trabalho->count2() > 0){
            $trabalho = $trabalho->results()[0];
            $estudante->estado = $trabalho->estado;
            $estudante->tema = $trabalho->tema;
        }else{
            $estudante->tema = "sem tema";
        }
        //print_r($informacoes_curso);
        print(json_encode($estudante));
        return;
    }
}
$response["success"] = "false";
print(json_encode($response));