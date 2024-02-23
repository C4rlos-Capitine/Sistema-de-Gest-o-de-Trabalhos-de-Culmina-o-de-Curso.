<?php
require_once "classes/pdf2/fpdf.php";
require_once "core/init.php";


class Relatorio extends fpdf{

    function Header()
    {
        // GFG logo image
       // $this->Image('upLogo.png', 30, 8, 20);
          
        // GFG logo image
       // $this->Image('upLogo.png', 400, 8, 20);
          
        // Set font-family and font-size
        $this->SetFont('Times','B',11);
          
        // Move to the right
        $this->Cell(80);
          
        // Set the title of pages.
        $this->Cell(310, 20, 'UNIVERSIDADE PEDAGÓGICA', 0, 2, 'C');
        
          
        // Break line with given space
        $this->Ln(5);
    }

    public function gerarRel($id_curso){
        //print_r($dados);
        $estudante = $util = (array)Estudante::getEstudantesDoCurso($id_curso);
        ob_start();
        $this->AliasNbPages('p', 'A4');
        $this->AddPage();
        $this->SetFont('Times','',11);
        $cellW = 50;
        $cellH = 15; 
        $pos = 0;
        $this->ln(0);
        $this->Cell($cellW, $cellH, 'Nome', 1, 0, 'C');
        $this->Cell(25, $cellH, 'Codigo', 1, 0, 'C');
        $this->Cell(70, $cellH, 'Minor', 1, 0, 'C');
        $this->Cell(20, $cellH, 'Regime', 1, 0, 'C');
        $this->Cell(25, $cellH, 'Ano de Ingresso', 1, 0, 'C');
        $this->Ln();
        for($i=0; $i<sizeof($estudante); $i++){

            $this->Cell($cellW, $cellH, $estudante[$i]->nome_estudante.' '.$estudante[$i]->apelido,1);
            $this->Cell(25, $cellH, $estudante[$i]->codigo_estudante,1);
            $this->Cell(70, $cellH, $estudante[$i]->designacao_minor,1);
            $this->Cell(20, $cellH, $estudante[$i]->regime,1);
            $this->Cell(25, $cellH, $estudante[$i]->ano_ingresso,1);
                //$this->write(5, ' '.$val.' ');
            
            $this->Ln();
         
            $pos++;
        }
        $this->Output();
        ob_end_flush();
    }
}