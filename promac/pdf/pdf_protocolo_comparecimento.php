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
setlocale(LC_TIME, 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$idProjeto = $_POST['idProjeto'];

$dateNow = date('Y-m-d');
$cabecalho = strftime('%d de %B de %Y', strtotime($dateNow));

$queryProjeto = "SELECT protocolo, nomeProjeto, tipoPessoa,idPf,idPj, idAreaAtuacao, valorAprovado, dataPublicacaoDoc FROM projeto WHERE idProjeto = '$idProjeto' AND publicado = 1";
$row = $con->query($queryProjeto)->fetch_assoc();
$protocolo = $row['protocolo'];
$nomeProjeto = $row['nomeProjeto'];
$tipoPessoa  = $row['tipoPessoa'];
$valorAprovado = number_format($row['valorAprovado'], 2, ',', '.');
$idPf = $row['idPf'];
$idPj = $row['idPj'];
$idAreaAtuacao = $row['idAreaAtuacao'];
$dataPublicacaoDoc = $row['dataPublicacaoDoc'];

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
$pdf->Cell(170,8,utf8_decode("PREFEITURA DO MUNICÍPIO DE SÃO PAULO"),0,1,'C');
$pdf->SetX($x);
$pdf->Cell(170,8,utf8_decode("SECRETARIA MUNICIPAL DE CULTURA"),0,1,'C');
$pdf->SetX($x);
$pdf->Cell(170,8,utf8_decode("Coordenadoria de Incetivo à Cultura - Pro-Mac"),0,1,'C');

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 14);
$pdf->Cell(170,9,utf8_decode("PROTOCOLO DE COMPARECIMENTO"),0,1,'C');

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(25,$l,utf8_decode("Proponente:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode($proponente));

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(16,$l,utf8_decode("Projeto:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode($nomeProjeto));

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(22,$l,utf8_decode("CPF/CNPJ:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(170,$l,utf8_decode($documento),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(76,$l,utf8_decode("Data de aprovação do projeto no D.O.C.:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(170,$l,exibirDataBr($dataPublicacaoDoc),0,1,'L');

$pdf->Ln(20);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->Cell(5,5,utf8_decode(""),'TBLR',0,'L');
$pdf->Cell(76,$l,utf8_decode(" Não apresentou nenhuma irregularidade fiscal."),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->Cell(5,5,utf8_decode(""),'TBLR',0,'L');
$pdf->Cell(165,$l,utf8_decode(" Apresentou irregularidade fiscal."),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->Cell(10,10,utf8_decode("Qual: "),0,0,'L');
$pdf->Cell(160,$l,utf8_decode(""),'B',1,'L');

$pdf->Ln(15);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->Cell(170,$l,utf8_decode("De acordo com a Portaria de Procedimento do Pro-Mac n°69, em seu item 4.1:"),0,1,'L');

$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Arial','I', 10);
$pdf->Cell(8,5,utf8_decode('"4.1:'),0,0,'L');
$pdf->MultiCell(162,5,utf8_decode('A Secretaria Municipal de Cultura convocará os proponentes que tiveram o projeto aprovado para assinar o Termo de Responsabilidade de Realização de Projeto Cultural (Anexo V) em até 15 (quinze) dias corridos após a publicação da aprovação do projeto no Diário Oficial da Cidade - D.O.C."'));

$pdf->Ln(12);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode("Compareceu na Secretaria Municipal de Cultural no dia ".date('d/m/Y').", recebendo os seguintes documentos:"));

$pdf->Ln(5);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->Cell(5,5,utf8_decode(""),'TBLR',0,'L');
$pdf->Cell(165,$l,utf8_decode(" Certificado de Captação de Recursos entregue, uma via;"),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->Cell(5,5,utf8_decode(""),'TBLR',0,'L');
$pdf->Cell(165,$l,utf8_decode(" Ofício de abertura de Contas no Banco do Brasil, uma via;"),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->Cell(5,5,utf8_decode(""),'TBLR',0,'L');
$pdf->Cell(165,$l,utf8_decode(" Termo de Responsabilidade de Realização de Projeto Cultural, uma via."),0,1,'L');

$pdf->Ln(20);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->Cell(70,$l,utf8_decode("Equipe Pro-Mac"),'T',0,'C');
$pdf->Cell(30,$l,utf8_decode(""),'',0,'L');
$pdf->Cell(70,$l,utf8_decode("Proponente"),'T',0,'C');


$pdf->Output();