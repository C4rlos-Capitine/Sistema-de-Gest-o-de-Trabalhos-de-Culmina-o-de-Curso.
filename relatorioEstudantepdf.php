<?php
require_once "classes/pdf2/fpdf.php";
require_once "core/init.php";
$util = (array)Estudante::get();
$user = new User();
/*if (!$user->isLoggedIn()) {
    Redirect::to('index.php');
}*/

$db = DB::getInstance();
//$obj = new Distribuicao();

$pdf = new FPDF("P");
$pdf->AddPage();
$arquivo = "relatorio-geralAlunos.pdf";

$fonte = "Arial";
$estilo = "B";
$border = "1";
$alinhaC = "C";
//$alinhal = "L"; 


//$pdf->WriteHTML($pagina);

$tipo_pdf = "I";
$pdf->SetFont($fonte, $estilo,10);
$pdf->Cell(24, 10, 'ID_estudante', $border, 0, $alinhaC);
$pdf->SetFont($fonte, $estilo,10);
$pdf->Cell(24, 10, 'N_estudante', $border, 0, $alinhaC);
$pdf->SetFont($fonte, $estilo,10);
$pdf->Cell(24, 10, 'Apelido', $border, 0, $alinhaC);
$pdf->SetFont($fonte, $estilo,10);
$pdf->Cell(24, 10, 'id_curso', $border, 0, $alinhaC);
$pdf->SetFont($fonte, $estilo,10);
$pdf->Cell(24, 10, 'ano_ingresso', $border, 0, $alinhaC);
$pdf->SetFont($fonte, $estilo,10);
$pdf->Cell(24, 10, 'Genero', $border, 0, $alinhaC);
$pdf->SetFont($fonte, $estilo,10);
$pdf->Cell(24, 10, 'id_minor', $border, 0, $alinhaC);
$pdf->SetFont($fonte, $estilo,10);
$pdf->Cell(24, 10, 'Regime', $border, 1, $alinhaC);

foreach ($util as $rat) {
	$f=0;

	foreach($rat as $k=>$l){
		
    if($f<7){

    
	$pdf->SetFont($fonte, $estilo,9);
	$pdf->Cell(24, 10, $l, $border, 0, $alinhaC);
	$f++;
	}else
	{   
		$pdf->SetFont($fonte,$estilo,9);
		$pdf->Cell(24, 10, $l, $border, 1, $alinhaC);
	$f=0;
	}
  }
}

$pdf->Output($arquivo, $tipo_pdf); 

?>