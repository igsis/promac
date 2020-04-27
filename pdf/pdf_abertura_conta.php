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

$dateNow = date('Y-m-d');
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

$sqlHistEtapa = "SELECT * FROM historico_etapa WHERE idProjeto = '$idProjeto' AND idEtapaProjeto = 5 AND data < '2019-01-01 00:00:00'";
$queryHistEtapa = mysqli_query($con, $sqlHistEtapa);
$numRowHist = mysqli_num_rows($queryHistEtapa);
$nomeCoordenadora = "Paula Carolina Rocha de Oliveira";
$dataCoordenadoria = "31 de dezembro de 2020";

if ($numRowHist > 0){
    $nomeCoordenadora = "Tatiana Solimeo";
    $dataCoordenadoria = "31 de dezembro de 2019";
}

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
$pdf->Cell(170,8,utf8_decode("NÚCLEO DE INCENTIVO À CULTURA (PRO-MAC)"),0,1,'C');

$pdf->ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 13);
$pdf->Cell(170,9,utf8_decode("OFÍCIO PARA ABERTURA DE CONTA CORRENTE NO BANCO DO BRASIL "),0,1,'C');

$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode("Sr(a). Gerente do Banco do Brasil,"));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode("A Secretaria Municipal de Cultura da Cidade de São Paulo encaminha o proponente $proponente, CPF/CNPJ nº $documento, aprovado com o projeto ''$nomeProjeto'' no Programa Municipal de Incentivo à Cultura - Pro-Mac, instituído pela Lei nº 15.948/2013 e regulamentado pelo Decreto nº 59.119/2019, para efetuar a abertura de uma conta corrente dirigida ao projeto cultural supramencionado."));

$pdf->ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode('Tal conta será destinada ao recebimento de recursos financeiros depositados por um ou mais incentivadores e só poderá ser movimentada após ter atingido o montante equivalente a 50% do valor total aprovado do projeto (cabendo ao proponente cumprir esta responsabilidade), bem como ter sido autorizada expressamente por esta pasta mediante a emissão de uma “Autorização de Movimentação de Recursos”.'));


$pdf->ln();
$pdf->ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(170,$l,utf8_decode("Em São Paulo, ".$cabecalho),0,0,'C');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Image('../visual/images/Assinatura_PaulaRocha.png',60,230,90);

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();

$pdf->Output();