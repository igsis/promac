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

}

//CONSULTA
$idProjeto = $_SESSION["idProjeto"];
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$NomeProjeto = $projeto["nomeProjeto"];

if($projeto['tipoPessoa'] == 1)//Pessoa Física
{
  $pf = recuperaDados("pessoa_fisica","idPf",$projeto['idPf']);
  $Nome = $pf["nome"];
  $RG = $pf["rg"];
  $CPF = $pf["cpf"];
  $Endereco = $pf ["logradouro"];
  $Numero = $pf["numero"];
  $Bairro = $pf["bairro"];
  $Cidade = $pf["cidade"];
  $Cep = $pf["cep"];
}
else //Pessoa Jurídica
{
  $pj = recuperaDados("pessoa_juridica","idPj",$projeto['idPj']);
  $representante1 = recuperaDados("representante_legal","idRepresentanteLegal",$pj['idRepresentanteLegal']);
  //Pessoa Jurídica
  $RazaoSocial = $pj["razaoSocial"];
  $CNPJ = $pj["cnpj"];
  $Endereco = $pj["logradouro"];
  $Numero = $pj["numero"];
  $Bairro = $pj["bairro"];
  $Cidade = $pj["cidade"];
  $Cep = $pj["cep"];
  //Representante Legal
  $Nome = $representante1["nome"];
  $RG = $representante1["rg"];
  $CPF = $representante1["cpf"];
}


//GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

$x=20;
$l=7; //DEFINE A ALTURA DA LINHA

$pdf->SetXY( $x , 40 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 14);
$pdf->Cell(180,5,utf8_decode("DECLARAÇÃO DE RESPONSABILIDADE POR DIREITOS AUTORAIS"),0,1,'C');

$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);

if($projeto['tipoPessoa'] == 1)//Pessoa Física
{
  $pdf->MultiCell(180,$l,utf8_decode("Eu, ".$Nome.", RG nº ".$RG.", CPF nº ".$CPF.", residente no endereço ".$Endereco.", ".$Numero.", bairro ".$Bairro.", CEP ".$Cep.", município de ".$Cidade.", proponente do projeto denominado ".$NomeProjeto." me comprometo a obter as autorizações necessárias dos eventuais detentores de direitos autorais de qualquer bem envolvido no projeto, cuja execução demande direito autoral ou patrimonial, ficando sobre responsabilidade integral do proponente quaisquer obrigações decorrentes da execução do projeto."));
}
else
{
  $pdf->MultiCell(170,$l,utf8_decode("Eu, "."$Nome".", RG nº"."$RG".", CPF nº "."$CPF".", representante legal da pessoa jurídica "."$RazaoSocial".", CNPJ nº "."$CNPJ".", sediada no endereço "."$Endereco".", "."$Numero".", bairro "."$Bairro".", CEP "."$Cep".", município de "."$Cidade".", proponente do projeto denominado "."$NomeProjeto"." me comprometo a obter as autorizações necessárias dos eventuais detentores de direitos autorais de qualquer bem envolvido no projeto, cuja execução demande direito autoral ou patrimonial, ficando sobre responsabilidade integral do proponente quaisquer obrigações decorrentes da execução do projeto."));
}

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->Cell(180,$l,utf8_decode("_________________________________________"),0,1,'C');
$pdf->SetX($x);
$pdf->Cell(180,$l,utf8_decode($Nome),0,1,'C');

$pdf->Output();
?>