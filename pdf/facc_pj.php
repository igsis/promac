<?php
require_once "../config/configGeral.php";

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../views/plugins/fpdf/fpdf.php";
// ACESSO AO BANCO
$pedidoAjax = true;
require_once "../config/configAPP.php";

require_once "../controllers/PessoaJuridicaController.php";
$pjObj = new PessoaJuridicaController();
$id = $_GET['id'];
$pj = $pjObj->recuperaPessoaJuridica($id);
$idRep1 = MainModel::encryption($pj['representante_legal1_id']);

require_once "../controllers/RepresentanteController.php";
$repObj = new RepresentanteController();
$rep = $repObj->recuperaRepresentante($idRep1)->fetch();


class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        $this->Image('../pdf/img/facc_pj.jpg', 15, 10, 180);
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

$pdf->SetXY(112, 43);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(10, $l, utf8_decode('X'), 0, 0, 'L');

$pdf->SetXY($x, 45);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(53, $l, utf8_decode($pj['cnpj']), 0, 0, 'L');

$pdf->SetXY(150, 43);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(53, $l, utf8_decode($pj['ccm']), 0, 0, 'L');

$pdf->SetXY($x, 60);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(160, $l, utf8_decode($pj['razao_social']), 0, 0, 'L');

$pdf->SetXY($x, 75);
$pdf->SetFont('Arial', '', 10);
if ($pj['complemento'] != NULL) {
    $pdf->Cell(160, $l, utf8_decode($pj['logradouro'].", ".$pj['numero']." ".$pj['complemento']), 0, 0, 'L');
} else {
    $pdf->Cell(160, $l, utf8_decode($pj['logradouro'].", ".$pj['numero']), 0, 0, 'L');
}

$pdf->SetXY($x, 90);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(68, $l, utf8_decode($pj['bairro']), 0, 0, 'L');
$pdf->Cell(88, $l, utf8_decode($pj['cidade']), 0, 0, 'L');
$pdf->Cell(5, $l, utf8_decode($pj['uf']), 0, 0, 'L');

$pdf->SetXY($x, 107);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(33, $l, utf8_decode($pj['cep']), 0, 0, 'L');
$pdf->Cell(47, $l, utf8_decode($pj['telefones']['tel_0']), 0, 0, 'L');
$pdf->Cell(15, $l, utf8_decode($pj['codigo']), 0, 0, 'L');
$pdf->Cell(37, $l, utf8_decode($pj['agencia']), 0, 0, 'L');
$pdf->Cell(37, $l, utf8_decode($pj['conta']), 0, 0, 'L');

$pdf->SetXY($x, 127);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(80, $l, utf8_decode($rep['nome']), 0, 0, 'L');
$pdf->Cell(50, $l, utf8_decode($rep['rg']), 0, 0, 'L');

$pdf->Output();