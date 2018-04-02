<?php

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once("../include/lib/fpdf/fpdf.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

session_start();

//CONEXÃO COM BANCO DE DADOS
$con = bancoMysqli();

class PDF extends FPDF
{
  // Simple table
  function BasicTable($header, $data)
  {
     // Header
     foreach($header as $col)
         $this->Cell(40,7,$col,1);
     $this->Ln();
     // Data
     foreach($data as $row)
     {
         foreach($row as $col)
             $this->Cell(40,6,$col,1);
         $this->Ln();
     }
  }

  // Simple table
  function Cabecalho($header, $data)
  {
     // Header
     foreach($header as $col)
         $this->Cell(40,7,$col,1);
     $this->Ln();
     // Data
  }

  // Simple table
  function Tabela($header, $data)
  {
     //Data
     foreach($data as $col)
         $this->Cell(40,7,$col,1);
     $this->Ln();
     // Data
  }
}

//CONSULTA
$idProjeto = $_SESSION["idProjeto"];
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$NomeProjeto = $projeto["nomeProjeto"];



//GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

$x=20;
$l=7; //DEFINE A ALTURA DA LINHA

$pdf->SetXY( $x , 40 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 14);
$pdf->Cell(180,5,utf8_decode("CARTA(S) DE ANUÊNCIA DO(S) PRINCIPAL(IS) PARTICIPANTE(S)"),0,1,'C');

$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("Os profissionais listados abaixo declaram ter ciência e concordam em participar do projeto denominado “".$nomeProjeto."”, caso seja contemplado."));

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

// Column headings
$header = array('NOME', 'RG', 'CONTATO', 'CPF','ASSINATURA');
$data = array($grupo);

$pdf->SetX($x);
$pdf->SetFont('Arial','',8);

$pdf->Cabecalho($header,$data);

for($i = 0;$i < $grupo['numero']; $i++){
  $data = array(utf8_decode($grupo[$i]['nome']), $grupo[$i]['rg'],$grupo[$i]['cpf'],""); 
  $pdf->SetX($x);
  $pdf->Tabela($header,$data);
}

$pdf->Output();
?>