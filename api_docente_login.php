<?php
require_once "core/init.php";
//print_r($_REQUEST);
//$docente2 = [];
$response = [];
$docente = Docente::find($_REQUEST['codigo_docente']);
if($docente->count2() > 0){
    $docente2 = $docente->results()[0];
    $docente2->success = "true";
   // print($docente2->id_curso);
    $curso = Curso::find($docente2->id_curso)->first();
    $docente2->designacao = $curso->designacao;
    $query = Docente::findInfo_adicional($_REQUEST['codigo_docente']);
    if($query->count2()){
        $docente2->docente_tcc = "true";
    }else{
        $docente2->docente_tcc = "false";
    }
    //var_dump($curso);
    print(json_encode($docente2));
    //return;
}else{
    $response["success"] = "false";
    print(json_encode($response));
}


//$estudante = [];
//$response = [];
/*
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
        
        //print_r($informacoes_curso);
        print(json_encode($estudante));
        return;
    }
}
$response["success"] = "false";
print(json_encode($response));*/