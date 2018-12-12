<?php
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once("../include/lib/fpdf/fpdf.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

//CONEXÃO COM BANCO DE DADOS
$con = bancoMysqli();

setlocale(LC_TIME, 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

session_start();

class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        $this->Image('../visual/images/brasao.jpg',20,15,15);
        $this->Ln(3);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,8,utf8_decode("PREFEITURA DO MUNICÍCIO DE SÃO PAULO"),0,1,'C');
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,8,utf8_decode("SECRETARIA MUNICIPAL DE CULTURA"),0,1,'C');
        $this->Cell(80);
        // Title
        $this->Cell(30,8,utf8_decode("Coordenadoria de Incentivo à Cultura - Pro-Mac"),0,1,'C');
        // Line break
        $this->Ln(10);
    }
}
$tipoPessoa = $_SESSION['tipoPessoa'];
$idPf  = $_SESSION['idUser'];
$idPj  = $_POST['idPj'];

$dateNow = date('Y-m-d');
$rodape = strftime('%d de %B de %Y', strtotime($dateNow));

if($tipoPessoa == 1) {
    $pf = $con->query("SELECT * FROM pessoa_fisica WHERE idPf = '$idPf'")->fetch_assoc();
}
else{
    $pj = $con->query("SELECT * FROM pessoa_juridica WHERE idPj = '$idPj'")->fetch_assoc();
    $idRepresentante = $pj['idRepresentanteLegal'];
    $rep = $con->query("SELECT * FROM representante_legal WHERE idRepresentanteLegal = '$idRepresentante'")->fetch_assoc();
}


//GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

$x=20;
$l=6; //DEFINE A ALTURA DA LINHA


$pdf->SetXY( $x , 35 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->Ln(15);

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(170,$l,utf8_decode("Anexo I"),0,1,'C');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(170,$l,utf8_decode("DECLARAÇÃO DE INSCRIÇÃO DE PROPONENTE"),0,1,'C');

$pdf->Ln();

if($tipoPessoa == 1) {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 11);
    $pdf->MultiCell(170, $l, utf8_decode("Eu, ".$pf['nome'].", RG n° ".$pf['rg'].", CPF nº ".$pf['cpf'].", residente no endereço ".$pf['logradouro'].", ".$pf['numero']." ".$pf['complemento'].", bairro ".$pf['bairro'].", CEP ".$pf['cep']. ", no município de ".$pf['cidade'].", venho declarar que:"));
}
else{
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 11);
    $pdf->MultiCell(170, $l, utf8_decode("Eu, ".$rep['nome'].", RG n° ".$rep['rg'].", CPF nº ".$rep['cpf'].", representante legal da pessoa jurídica, ".$pj['razaoSocial'].",  residente no endereço ".$pf['logradouro'].", ".$pf['numero']." ".$pf['complemento'].", bairro ".$pf['bairro'].", CEP ".$pf['cep']. ", no município de ".$pf['cidade'].", venho declarar que:"));
}


$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(5,$l,utf8_decode("a)"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Tenho ciência e concordo com os termos da Lei nº 15.948/2013, do Decreto nº 58.041/2017 e desta portaria;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(5,$l,utf8_decode("b)"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("As informações prestadas são verídicas;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("c)"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Sou residente / sediado no Município de São Paulo há no mínimo 02 (dois) anos;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("d)"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Não possuo qualquer associação ou vínculo direto ou indireto com empresas de serviços de radiodifusão de som e imagem ou operadoras de comunicação eletrônica aberta ou por assinatura;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("e)"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Não possuo qualquer associação ou vínculo direto ou indireto com o contribuinte incentivador do projeto apresentado, ressalvadas as hipóteses a que aludem o inciso XX do artigo 4º e o inciso III do artigo 7º da Lei nº15.948/2013;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("f)"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Estou em situação regular perante a Administração Pública;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("g)"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Não estou cadastrado e não possuo débitos junto à Fazenda do Município de São Paulo;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("h)"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("O projeto apresentado não recebeu e nem recebe recursos de editais da Secretaria Municipal de Cultura."));

if($tipoPessoa == 2) {
    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(6,$l,utf8_decode("i)"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->MultiCell(165,$l,utf8_decode("Não emprego menor de dezoito anos em trabalho noturno, perigoso ou insalubre e não emprego menor de 16 anos, salvo na condição de aprendiz;"));

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(6,$l,utf8_decode("i)"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->MultiCell(165,$l,utf8_decode("Não tenho entre os dirigentes pessoa cujas contas relativas a parcerias tenham sido julgadas irregulares ou rejeitadas por Tribunal ou Conselho de Contas de qualquer esfera da Federação, em decisão irrecorrível, nos últimos 8 (oito) anos; julgada responsável por falta grave e inabilitada para o exercício de cargo em comissão ou função de confiança, enquanto durar a inabilitação; ou considerada responsável por ato de improbidade, enquanto durarem os prazos estabelecidos nos incisos I, II e III do art. 12 da Lei nº 8.429/1992."));
}

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->Cell(170,$l,utf8_decode("Em São Paulo, $rodape."),0,1,'C');

$pdf->Ln(20);

$pdf->SetX($x);
$pdf->Cell(40,$l,"",0,0,'L');
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(90,$l,utf8_decode("Proponente"),'T',1,'C');

$pdf->Output();