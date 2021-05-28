<?php
require_once "../config/configGeral.php";

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../views/plugins/fpdf/fpdf.php";
// ACESSO AO BANCO
$pedidoAjax = true;
require_once "../config/configAPP.php";

// CONSULTA
require_once "../controllers/EventoController.php";
$eventoObj = new EventoController();
session_start(['name' => 'cpc']);
$idEvento = $eventoObj->descriptografia($_SESSION['origem_id_c']);
$eventos = $eventoObj->consultaSimples("
    SELECT pf.nome AS lider_nome, pf.rg AS lider_rg, pf.cpf AS lider_cpf, a.integrantes, a.nome_atracao
    FROM eventos AS eve
        INNER JOIN pedidos AS ped ON eve.id = ped.origem_id
        INNER JOIN atracoes a on eve.id = a.evento_id
        INNER JOIN lideres l on a.id = l.atracao_id
        INNER JOIN pessoa_fisicas pf on l.pessoa_fisica_id = pf.id
    WHERE ped.origem_tipo_id = 1 AND ped.publicado = 1 AND eve.id = '$idEvento';
")->fetchAll(PDO::FETCH_ASSOC);

class PDF extends FPDF
{

}

// GERANDO O PDF:
$pdf = new PDF('P', 'mm', 'A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();

foreach ($eventos as $evento){

    $pdf->AddPage();

    $x = 20;
    $l = 6; //DEFINE A ALTURA DA LINHA
    $f = 9; //tamanho da fonte

    $pdf->SetXY($x, 15);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(180, 5, utf8_decode("DECLARAÇÃO DE EXCLUSIVIDADE"), 0, 1, 'C');

    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(180, $l, utf8_decode("Eu, " . $evento['lider_nome'] . ", RG " . $evento['lider_rg'] . ", CPF " . $evento['lider_cpf'] . ", sob penas da lei, declaro que sou líder da atração " . $evento['nome_atracao'] . " que possui os integrantes abaixo listados, e que o mesmo é representado exclusivamente por mim."));

    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(180, $l, utf8_decode("Declaro, sob as penas da Lei, que não sou servidor público municipal e que não me encontro em impedimento para contratar com a Prefeitura do Município de São Paulo / Secretaria Municipal de Cultura, mediante recebimento de cachê e/ou bilheteria, quando for o caso."));

    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(180, $l, utf8_decode("Declaro, sob as penas da lei, dentre os integrantes abaixo listados não há crianças e adolescentes. Quando houver, estamos cientes que é de nossa responsabilidade a adoção das providências de obtenção  de  decisão judicial  junto à Vara da Infância e Juventude."));

    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(180, $l, utf8_decode("Declaro, ainda, neste ato, que autorizo, a título gratuito, por prazo indeterminado, a Municipalidade de São Paulo, através da SMC, o uso da nossa imagem, voz e performance nas suas publicações em papel e qualquer mídia digital, streaming ou internet existentes ou que venha a existir como também para os fins de arquivo e material de pesquisa e consulta."));

    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(180, $l, utf8_decode("Declaro, ainda, neste ato, que autorizo, a título gratuito, por prazo indeterminado, a Municipalidade de São Paulo, através da SMC, o uso da nossa imagem, voz e performance nas suas publicações em papel e qualquer mídia digital, streaming ou internet existentes ou que venha a existir como também para os fins de arquivo e material de pesquisa e consulta."));

    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(180, $l, utf8_decode("Fico autorizado a celebrar contrato, inclusive receber cachê e/ou bilheteria quando for o caso, outorgando quitação."));

    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(180, $l, utf8_decode("Estou ciente de que o pagamento dos valores decorrentes dos serviços é de minha responsabilidade, não cabendo pleitear à Prefeitura quaisquer valores eventualmente não repassados."));

    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(128, $l, utf8_decode("Integrantes:"), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', 9);
    $pdf->MultiCell(180, 5, utf8_decode($evento['integrantes']));

    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(128, $l, utf8_decode("São Paulo, _______ / _______ / " . date('Y') . "."), 0, 1, 'L');

    $pdf->Ln(20);

    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(120, 4, utf8_decode("Nome do Líder do Grupo: " . $evento['lider_nome']), 'T', 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(128, 4, utf8_decode("RG: " . $evento['lider_rg'] . ""), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(128, 4, utf8_decode("CPF: " . $evento['lider_cpf'] . ""), 0, 1, 'L');

}
$pdf->Output();