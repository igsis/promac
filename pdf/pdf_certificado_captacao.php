<?php
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once("../include/lib/fpdf/fpdf.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

//CONEXÃO COM BANCO DE DADOS
$con = bancoMysqli();


session_start();

class PDF extends FPDF
{
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-20);
        // Arial italic 8
        $this->SetFont('Arial','',8);
        // Page number
        $this->Cell(0,10,utf8_decode('Rua Libero Badaró, 340 - 3º andar - Telefone: 3397-0063/0228 - E-mail: admpromac@prefeitura.sp.gov.br'),0,0,'C');
    }
}
setlocale(LC_TIME, 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$idProjeto = $_POST['idProjeto'];

$dateNow = date('d/m/Y');
$cabecalho = strftime('%d de %B de %Y', strtotime($dateNow));

$queryProjeto = "SELECT protocolo, nomeProjeto, tipoPessoa,idPf,idPj, idAreaAtuacao, valorAprovado FROM projeto WHERE idProjeto = '$idProjeto' AND publicado = 1";
$row = $con->query($queryProjeto)->fetch_assoc();
$protocolo = $row['protocolo'];
$nomeProjeto = $row['nomeProjeto'];
$tipoPessoa  = $row['tipoPessoa'];
$valorAprovado = number_format($row['valorAprovado'], 2, ',', '.');
$idPf = $row['idPf'];
$idPj = $row['idPj'];
$idAreaAtuacao = $row['idAreaAtuacao'];

if($tipoPessoa == 1) {
    $sql_pf = "SELECT * FROM pessoa_fisica WHERE idPf = '$idPf'";
    $query_pf = mysqli_query($con, $sql_pf);
    $pf = mysqli_fetch_array($query_pf);
    $proponente = $pf["nome"];
    $documento = $pf["cpf"];
}
else{
    $sql_pj = "SELECT * FROM pessoa_juridica WHERE idPj = '$idPj'";
    $query_pj = mysqli_query($con, $sql_pj);
    $pj = mysqli_fetch_array($query_pj);
    $proponente = $pj["razaoSocial"];
    $documento = $pj["cnpj"];
}

$atuacao = $con->query("SELECT `areaAtuacao` FROM `area_atuacao` WHERE `idArea` = '$idAreaAtuacao'")->fetch_assoc();
$areaAtuacao = $atuacao['areaAtuacao'];

//GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

$x=20;
$l=7; //DEFINE A ALTURA DA LINHA

$pdf->SetXY( $x , 15 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Image('../visual/images/brasao.jpg',$x,15,15);

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 16);
$pdf->Cell(170,8,utf8_decode("PREFEITURA DO MUNICÍCIO DE SÃO PAULO"),0,1,'C');
$pdf->SetX($x);
$pdf->Cell(170,8,utf8_decode("SECRETARIA MUNICIPAL DE CULTURA"),0,1,'C');
$pdf->SetX($x);
$pdf->Cell(170,8,utf8_decode("PRO-MAC"),0,1,'C');

$pdf->ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 16);
$pdf->Cell(170,9,utf8_decode("AUTORIZAÇÃO DE CAPTAÇÃO"),0,1,'C');

$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode("A SECRETARIA MUNICIPAL DE CULTURA representada pela Sr.ª Coordenadora Tatiana Solimeo, nos termos da Portaria nº 69/2018-SMC-G e do Decreto, nº 58.041 de 20 de Dezembro de 2017 DECLARA o projeto especificado abaixo APROVADO, estando seu proponente apto a pleitear o incentivo fiscal, previsto na Lei nº 15.948 de 26 de Dezembro de 2013, no valor de R$ $valorAprovado tendo este certificado validade para o período restante do exercício fiscal deste ano, podendo ser prorrogável por 1 (um) ano, conforme o art.º 45 do Decreto nº 58.041/2017."));

$pdf->ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(28, $l, utf8_decode("PROTOCOLO: "));
$pdf->SetFont('Arial',null, 11);
$pdf->Cell(0, $l, $protocolo);

$pdf->ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(41, $l, utf8_decode("NOME DO PROJETO: "));
$pdf->SetFont('Arial',null, 11);
$pdf->Cell(0, $l, utf8_decode($nomeProjeto));

$pdf->ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(26, $l, utf8_decode("LINGUAGEM: "));
$pdf->SetFont('Arial',null, 11);
$pdf->MultiCell(0, $l, utf8_decode($areaAtuacao));

$pdf->ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(30, $l, utf8_decode("PROPONENTE: "));
$pdf->SetFont('Arial',null, 11);
$pdf->Cell(0, $l, utf8_decode($proponente));

$pdf->ln();
$pdf->ln();

$pdf->SetX($x);
$pdf->MultiCell(170,$l,utf8_decode("Este documento tem caráter meramente declaratório, não podendo ser utilizado para abatimentos de TRIBUTOS. O documento hábil para tanto, o CERTIFICADO DE INCENTIVO, somente será expedido após a comprovação de transferência de recursos para o projeto cultural, obedecendo rigorosamente às instruções constantes na legislação e no edital."));

$pdf->ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(170,$l,utf8_decode("Em São Paulo, ".$cabecalho),0,0,'C');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Image('../visual/images/assinatura_tati.jpg',60,230,90);


$pdf->Ln();
$pdf->Ln();
$pdf->Ln();


$pdf->Output();