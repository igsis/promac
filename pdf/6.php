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
   $pdf->Cell(180,5,utf8_decode("DECLARAÇÃO DE INSCRIÇÃO DE PROPONENTE"),0,1,'C');
   
   $pdf->Ln();
   $pdf->Ln();
   
  
   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("Eu, "."$Nome".", RG nº"."$RG".", CPF nº "."$CPF".", residente no endereço "."$Endereco".", "."$Numero".", bairro "."$Bairro".", CEP "."$Cep".", município de "."$Cidade"."."));

   $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("a) Tenho ciência e concordo com os termos da Lei nº 15.948/2013, do Decreto nº 58.041/2017 e desta portaria;"));

   $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("b) As informações prestadas são verídicas;"));

   $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("c) Sou residente / sediado no Município de São Paulo há no mínimo 02 (dois) anos;"));

   $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("d) Não possuo qualquer associação ou vínculo direto ou indireto com empresas de serviços de radiodifusão de som e imagem ou operadoras de comunicação eletrônica aberta ou por assinatura;"));

   $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("e) Não possuo qualquer associação ou vínculo direto ou indireto com o contribuinte incentivador do projeto apresentado, ressalvadas as hipóteses a que aludem o inciso XX do artigo 4º e o inciso III do artigo 7º da Lei nº15.948, de 2013;"));

   $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("f) Estou em situação regular perante a Administração Pública;"));
   $pdf->Ln();

   $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("g) Não estou cadastrado e não possuo débitos junto à Fazenda do Município de São Paulo;"));
   $pdf->Ln();

   $pdf->Ln();

   $pdf->SetX($x);
   $pdf->SetFont('Arial','', 11);
   $pdf->MultiCell(170,$l,utf8_decode("h) O projeto apresentado não recebeu e nem recebe recursos de editais da Secretaria Municipal de Cultura."));

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