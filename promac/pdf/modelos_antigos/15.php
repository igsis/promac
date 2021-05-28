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

}

//CONSULTA
$idPj = $_SESSION['idUser'];
$pj = recuperaDados("pessoa_juridica","idPj",$idPj);
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


//GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

$x=20;
$l=7; //DEFINE A ALTURA DA LINHA

$pdf->SetXY( $x , 30 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 14);
$pdf->Cell(180,5,utf8_decode("DECLARAÇÃO DE INSCRIÇÃO DE PROPONENTE"),0,1,'C');

$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("Eu, ".$Nome.", RG nº ".$RG.", CPF nº ".$CPF.", representante legal da pessoa jurídica ".$RazaoSocial.", CNPJ nº ".$CNPJ.", sediada no endereço ".$Endereco.", ".$Numero.", bairro ".$Bairro.", CEP ".$Cep.", município de ".$Cidade."."));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("a) Tenho ciência e concordo com os termos da Lei nº 15.948/2013, do Decreto nº 58.041/2017 e desta portaria;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("b) As informações prestadas são verídicas;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("c) Sou residente / sediado no Município de São Paulo há no mínimo 02 (dois) anos;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("d) Não possuo qualquer associação ou vínculo direto ou indireto com empresas de serviços de radiodifusão de som e imagem ou operadoras de comunicação eletrônica aberta ou por assinatura;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("e) Não possuo qualquer associação ou vínculo direto ou indireto com o contribuinte incentivador do projeto apresentado, ressalvadas as hipóteses a que aludem o inciso XX do artigo 4º e o inciso III do artigo 7º da Lei nº 15.948, de 2013;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("f) Estou em situação regular perante a Administração Pública;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("g) Não estou cadastrado e não possuo débitos junto à Fazenda do Município de São Paulo;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("h) O projeto apresentado não recebeu e nem recebe recursos de editais da Secretaria Municipal de Cultura."));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("i) Não emprego menor de dezoito anos em trabalho noturno, perigoso ou insalubre e não emprego menor de 16 anos, salvo na condição de aprendiz;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("j) Não tenho entre os dirigentes pessoa cujas contas relativas a parcerias tenham sido julgadas irregulares ou rejeitadas por Tribunal ou Conselho de Contas de qualquer esfera da Federação, em decisão irrecorrível, nos últimos 8 (oito) anos; julgada responsável por falta grave e inabilitada para o exercício de cargo em comissão ou função de confiança, enquanto durar a inabilitação; ou considerada responsável por ato de improbidade, enquanto durarem os prazos estabelecidos nos incisos I, II e III do art. 12 da Lei nº 8.429, de 2 de junho de 1992."));

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