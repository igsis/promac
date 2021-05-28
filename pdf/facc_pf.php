<?php
require_once "../config/configGeral.php";

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../views/plugins/fpdf/fpdf.php";
// ACESSO AO BANCO
$pedidoAjax = true;
require_once "../config/configAPP.php";

require_once "../controllers/PessoaFisicaController.php";
$pfObj = new PessoaFisicaController();
$id = $_GET['id'];
$pf = $pfObj->recuperaPessoaFisica($id);

class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        $this->Image(SERVERURL.'pdf/img/facc_pf.jpg', 15, 10, 180);
        // Line break
        $this->Ln(20);
    }
}

// GERANDO O PDF:
$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

$x = 20;
$l = 7; //DEFINE A ALTURA DA LINHA

$pdf->SetXY($x, 40);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetXY(113, 40);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, $l, utf8_decode('X'), 0, 0, 'L');

$pdf->SetXY($x, 40);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(53, $l, utf8_decode($pf['cpf']), 0, 0, 'L');

$pdf->SetXY(155, 40);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(53, $l, utf8_decode($pf['ccm']), 0, 0, 'L');

$pdf->SetXY($x, 55);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(160, $l, utf8_decode($pf['nome']), 0, 0, 'L');

$pdf->SetXY($x, 68);
$pdf->SetFont('Arial', '', 10);
if ($pf['complemento'] != NULL) {
    $pdf->Cell(160, $l, utf8_decode($pf['logradouro'].", ".$pf['numero']." ".$pf['complemento']), 0, 0, 'L');
} else {
    $pdf->Cell(160, $l, utf8_decode($pf['logradouro'].", ".$pf['numero']), 0, 0, 'L');
}

$pdf->SetXY($x, 82);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(68, $l, utf8_decode($pf['bairro']), 0, 0, 'L');
$pdf->Cell(88, $l, utf8_decode($pf['cidade']), 0, 0, 'L');
$pdf->Cell(5, $l, utf8_decode($pf['uf']), 0, 0, 'L');

$pdf->SetXY($x, 96);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(33, $l, utf8_decode($pf['cep']), 0, 0, 'L');
$pdf->Cell(57, $l, utf8_decode($pf['telefones']['tel_0']), 0, 0, 'L');
$pdf->Cell(15, $l, utf8_decode($pf['codigo']), 0, 0, 'L');
$pdf->Cell(35, $l, utf8_decode($pf['agencia']), 0, 0, 'L');
$pdf->Cell(37, $l, utf8_decode($pf['conta']), 0, 0, 'L');

$pdf->SetXY($x, 107);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(87, $l, utf8_decode($pf['nit']), 0, 0, 'L');
$pdf->Cell(52, $l, utf8_decode(MainModel::dataParaBR($pf['data_nascimento'])), 0, 0, 'L');

$pdf->SetXY($x, 122);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(87, $l, utf8_decode($pf['nome']), 0, 0, 'L');
$pdf->Cell(50, $l, utf8_decode($pf['rg']), 0, 0, 'L');

$pdf->Output();