<?php

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once("../include/lib/fpdf/fpdf.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

//CONEXÃO COM BANCO DE DADOS
$conexao = bancoMysqli();

session_start();

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
$idPf = $_SESSION['idUser'];
$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
$idProjeto = $_GET['projeto'];

$ano=date('Y');

//Pessoa Física
$Nome = $pf["nome"];
$RG = $pf["rg"];
$CPF = $pf["cpf"];
$Endereco = $pf ["logradouro"];
$Numero = $pf["numero"];
$Bairro = $pf["bairro"];
$Cidade = $pf["cidade"];
$Cep = $pf["cep"];


//GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

   
$x=20;
$l=6; //DEFINE A ALTURA DA LINHA   
   
$pdf->SetXY( $x , 15 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA


   
   $pdf->SetX($x);
   $pdf->SetFont('Arial','B', 14);
   $pdf->Cell(180,5,utf8_decode("DECLARAÇÃO DE RESPONSABILIDADE POR DIREITOS AUTORAIS"),0,1,'C');
   
   $pdf->Ln();
   $pdf->Ln();
   
  
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("Eu, "."$Nome".", RG nº"."$RG".", CPF nº "."$CPF".", residente no endereço "."$Endereco".", "."$Numero".", bairro "."$Bairro".", CEP "."$Cep".", município de "."$Cidade".", proponente do projeto denominado xxxx me comprometo a obter as autorizações necessárias dos eventuais detentores de direitos autorais de qualquer bem envolvido no projeto, cuja execução demande direito autoral ou patrimonial, ficando sobre responsabilidade integral do proponente quaisquer obrigações decorrentes da execução do projeto."));

   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode("_______________________________"),0,1,'L');
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->Cell(128,$l,utf8_decode(""."$Nome".""),0,1,'L');
  

   $pdf->Ln();
   $pdf->Ln();
   $pdf->Ln();


$pdf->Output();


?>