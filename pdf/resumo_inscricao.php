<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
$pedidoAjax = true;

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../config/configGeral.php";
require_once "../views/plugins/fpdf/fpdf.php";

$modulo = $_GET['modulo'];
$id = $_GET['id'];

switch ($modulo){
    case 1: //proponente pf
        require_once "../controllers/ProponentePfController.php";
        $pfObj = new ProponentePfController();
        $pessoa = $pfObj->recuperaProponentePf($id);
        $sigla = "PPF-";
        break;
    case 2: //proponente pj
        require_once "../controllers/ProponentePjController.php";
        require_once "../controllers/RepresentanteController.php";
        $pjObj = new ProponentePjController();
        $repObj = new RepresentanteController();
        $pessoa = $pjObj->recuperaProponentePj($id);
        $representante = $repObj->recuperaRepresentante($pessoa->representante_legal_id);
        $sigla = "PPJ-";
        break;
    case 3: //incentivador pf
        require_once "../controllers/IncentivadorPfController.php";
        $pfObj = new IncentivadorPfController();
        $pessoa = $pfObj->recuperaIncentivadorPf($id);
        $sigla = "IPF-";
        break;
    case 4: //incentivador pj
        require_once "../controllers/IncentivadorPjController.php";
        require_once "../controllers/RepresentanteController.php";
        $pjObj = new IncentivadorPjController();
        $repObj = new RepresentanteController();
        $pessoa = $pjObj->recuperaIncentivadorPj($id);
        $representante = $repObj->recuperaRepresentante($pessoa->representante_legal_id);
        $sigla = "IPJ-";
        break;
}

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('../views/dist/img/CULTURA_HORIZONTAL_pb_positivo.png', 20, 10);
        $this->Ln(20);
    }
}

// GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

$x=20; //DEFINE A MARGEM SUPERIOR
$l=7; //DEFINE A ALTURA DA LINHA
$f=12; //DEFINE TAMANHO DA FONTE

$pdf->SetXY( $x , 30 );// SetXY - DEFINE O X (altura) E O Y (largura) NA

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 14);
$pdf->MultiCell(180, $l, utf8_decode("INSCRIÇÃO PROMAC"), 0, 'C');

$pdf->Ln(10);

if ($modulo == 1 | $modulo == 3){
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(14, $l, 'Nome:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(120, $l, utf8_decode($pessoa->nome), 0, 'L', 0);

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(9, $l, utf8_decode('RG:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(50, $l, utf8_decode($pessoa->rg == NULL ? "Não cadastrado" : $pessoa->rg), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(11, $l, utf8_decode('CPF:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(45, $l, utf8_decode($pessoa->cpf), 0, 1, 'L');

    if ($modulo == 1 ){
        $pdf->SetX($x);
        $pdf->SetFont('Arial', 'B', $f);
        $pdf->Cell(17, $l, utf8_decode('Gênero:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(50, $l, utf8_decode($pessoa->genero), 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', $f);
        $pdf->Cell(13, $l, utf8_decode('Etnia:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(45, $l, utf8_decode($pessoa->etnia), 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', $f);
        $pdf->Cell(25, $l, utf8_decode('Cooperado:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(45, $l, utf8_decode((new MainModel)->simNao($pessoa->cooperado)), 0, 1, 'L');

        if (isset($pessoa->lei)){
            $pdf->SetX($x);
            $pdf->SetFont('Arial','B', $f);
            $pdf->Cell(9,$l,utf8_decode('Lei:'),0,0,'L');
            $pdf->SetFont('Arial','', $f);
            $pdf->Cell(171,$l,utf8_decode($pessoa->lei),0,1,'L');
        }
    }
} else{
    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', $f);
    $pdf->Cell(29,$l,utf8_decode('Razão Social:'),0,0,'L');
    $pdf->SetFont('Arial','', $f);
    $pdf->Cell(150,$l,utf8_decode($pessoa->razao_social),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', $f);
    $pdf->Cell(14,$l,utf8_decode('CNPJ:'),0,0,'L');
    $pdf->SetFont('Arial','', $f);
    $pdf->Cell(150,$l,utf8_decode($pessoa->cnpj),0,1,'L');

    if ($modulo == 2){
        $pdf->SetX($x);
        $pdf->SetFont('Arial', 'B', $f);
        $pdf->Cell(10, $l, utf8_decode('MEI:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(45, $l, utf8_decode((new MainModel)->simNao($pessoa->mei)), 0, 0, 'L');
        $pdf->SetFont('Arial', 'B', $f);
        $pdf->Cell(27, $l, utf8_decode('Cooperativa:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(45, $l, utf8_decode((new MainModel)->simNao($pessoa->cooperativa)), 0, 1, 'L');
    } else{
        $pdf->SetX($x);
        $pdf->SetFont('Arial', 'B', $f);
        $pdf->Cell(19, $l, utf8_decode('Imposto:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', $f);
        $pdf->Cell(45, $l, utf8_decode($pessoa->imposto), 0, 1, 'L');
    }
}

if(isset($pessoa->logradouro)) {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(22, $l, utf8_decode("Endereço:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(158, $l, utf8_decode($pessoa->logradouro . ", " . $pessoa->numero . " " . $pessoa->complemento . " " . $pessoa->bairro . ", " . $pessoa->cidade . " - " . $pessoa->uf . " CEP: " . $pessoa->cep));

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(12, $l, utf8_decode("Zona:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($pessoa->zonas), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(17, $l, utf8_decode("Distrito:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(35, $l, utf8_decode($pessoa->distrito), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(30, $l, utf8_decode("Subprefeitura:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(25, $l, utf8_decode($pessoa->subprefeitura), 0, 1, 'L');
}

if (isset($pessoa->telefones)){
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(25, $l, 'Telefone(s):', '0', '0', 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(165, $l, utf8_decode($pessoa->telefones['tel_0'] ?? null . " " .$pessoa->telefones['tel_1'] ?? null. " ".$pessoa->telefones['tel_2'] ?? null));
}

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(14, $l, 'Email:', 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->MultiCell(166, $l, utf8_decode($pessoa->email), 0, 'L', 0);

$pdf->Ln();

if ($modulo == 2 | $modulo == 4){
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(180, $l, 'Representante Legal', 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(14, $l, 'Nome:', 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(120, $l, utf8_decode($representante->nome), 0, 'L', 0);

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(9, $l, utf8_decode('RG:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(50, $l, utf8_decode($representante->rg == NULL ? "Não cadastrado" : $representante->rg), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(11, $l, utf8_decode('CPF:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(45, $l, utf8_decode($representante->cpf), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(17, $l, utf8_decode('Gênero:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(50, $l, utf8_decode($representante->genero), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(13, $l, utf8_decode('Etnia:'), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(45, $l, utf8_decode($representante->etnia), 0, 1, 'L');

    if (isset($representante->lei)){
        $pdf->SetX($x);
        $pdf->SetFont('Arial','B', $f);
        $pdf->Cell(9,$l,utf8_decode('Lei:'),0,0,'L');
        $pdf->SetFont('Arial','', $f);
        $pdf->Cell(171,$l,utf8_decode($representante->lei),0,1,'L');
    }

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(22, $l, utf8_decode("Endereço:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(158, $l, utf8_decode($representante->logradouro . ", " . $representante->numero . " " . $representante->complemento . " " . $representante->bairro . ", " . $representante->cidade . " - " . $representante->uf . " CEP: " . $representante->cep));

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(12, $l, utf8_decode("Zona:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($representante->zonas), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(17, $l, utf8_decode("Distrito:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(35, $l, utf8_decode($representante->distrito), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(30, $l, utf8_decode("Subprefeitura:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(25, $l, utf8_decode($representante->subprefeitura), 0, 1, 'L');
}

$pdf->Ln(20);

$pdf->SetX($x);
$pdf->Cell(180, $l, "", 'T', 1, 'L');
$pdf->SetFont('Arial', '', $f-1);
$pdf->SetTextColor(70,70,70);

$pdf->SetX($x);
$pdf->Cell(25, $l, $pdf->Image('../views/dist/img/pin_promac_negativo.png',$x,$pdf->GetY(),15), 0, 0, 'L');
$pdf->Cell(155, $l, utf8_decode("Inscrição realizada em ".date('d/m/Y - H:i:s', strtotime($pessoa->data_inscricao))), 0, 1, 'L');

$pdf->SetX($x+25);
$pdf->Cell(50, $l, utf8_decode($sigla.$id), 0, 1, 'L');

$pdf->SetX($x+25);
$pdf->Cell(155, $l, utf8_decode("https://promac.prefeitura.sp.gov.br"), 0, 1, 'L',false,"https://promac.prefeitura.sp.gov.br");

$pdf->Output("resumo_inscricao","I");