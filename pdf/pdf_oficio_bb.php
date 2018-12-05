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

}
$idProjeto = 110;

$dateNow = date('d/m/Y');

$queryProjeto = "SELECT nomeProjeto, tipoPessoa,idPf,idPj FROM projeto WHERE idProjeto = '$idProjeto' AND publicado = 1";
$enviaP = mysqli_query($con, $queryProjeto);
$row = mysqli_fetch_array($enviaP);
$nomeProjeto = $row['nomeProjeto'];
$tipoPessoa  = $row['tipoPessoa'];
$idPf  = $row['idPf'];
$idPj  = $row['idPj'];

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
$pdf->Cell(170,9,utf8_decode("PREFEITURA DO MUNICÍCIO DE SÃO PAULO"),0,1,'C');
$pdf->SetX($x);
$pdf->Cell(170,9,utf8_decode("SECRETARIA MUNICIPAL DE CULTURA"),0,1,'C');

$pdf->SetX($x);
$pdf->SetFont('Arial','', 16);
$pdf->Cell(170,9,utf8_decode("COORDENAÇÃO GERAL"),0,1,'C');

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(170,$l,utf8_decode("OFÍCIO PARA ABERTURA DE CONTAS NO BANCO DO BRASIL"),0,1,'C');

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->Cell(170,$l,utf8_decode("Sr(a). Gerente do Banco do Brasil,"),0,1,'L');

$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode("A Secretaria Municipal de Cultura da Cidade de São Paulo encaminha o proponente, $proponente CPF/CNPJ nº $documento aprovado com o projeto $nomeProjeto no Programa Municipal de Incentivo à Cultura - ProMac, instituído pela Lei nº 15.948/2013 e regulamentado pelo Decreto nº 58.041/2017, para efetuar a abertura de duas contas para depósito e movimentação exclusivos dos recursos do projeto aprovado: conta de captação e conta de movimentação."));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode("A conta de captação será destinada apenas para recebimento dos recursos depositados pelo incentivador. O proponente deverá solicitar à Secretaria autorização para transferência dos recursos para a conta de movimentação quando a captação houver atingido ao menos 35% do valor aprovado do projeto. O proponente se responsabiliza por movimentar apenas a conta de movimentação, após expressa autorização da Secretaria."));

$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(170,$l,utf8_decode("Em São Paulo, $dateNow."),0,0,'C');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Image('../visual/images/assinatura_tati.jpg',60,230,90);

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();


$pdf->Output();