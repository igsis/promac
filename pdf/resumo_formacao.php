<?php
require_once "../config/configGeral.php";

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../views/plugins/fpdf/fpdf.php";
// ACESSO AO BANCO
$pedidoAjax = true;
require_once "../config/configAPP.php";

// CONSULTA
$id = $_GET['id'];
$ano = $_GET['ano'];
require_once "../controllers/FormacaoController.php";
$formacaoObj = new FormacaoController();
$formacao = $formacaoObj->recuperaFormacao($ano, false, $id);

require_once "../controllers/PessoaFisicaController.php";
$pfObj = new PessoaFisicaController();
$pf = $pfObj->recuperaPessoaFisica((new MainModel)->encryption($formacao->pessoa_fisica_id));
$pfDados = $pfObj->recuperaPfDetalhes($pf['id'])->fetch(PDO::FETCH_ASSOC);
if ($pfDados['trans'] == 1){
    $trans = "sim";
} else {
    $trans = "não";
}
if ($pfDados['pcd'] == 1){
    $pcd = "sim";
} else {
    $pcd = "não";
}

class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Cell(80);
        $this->Image('../views/dist/img/logo_cultura.jpg', 20, 10);
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
$f = 11; //tamanho da fonte

$pdf->SetXY($x, 25);// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(120, $l, utf8_decode(""), '0', 0, 'L');
$pdf->Cell(50, $l, utf8_decode("Protocolo"), 'TLR', 1, 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(120, $l, utf8_decode(""), '0', 0, 'L');
$pdf->Cell(50, $l, utf8_decode($formacao->protocolo), 'BLR', 1, 'C');

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 14);
$pdf->MultiCell(170, $l, utf8_decode("Dados Pessoais"), "B", 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(14, $l, utf8_decode("Nome:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($pf['nome']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(29, $l, utf8_decode("Nome artístico:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($pf['nome_artistico']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(8, $l, utf8_decode("RG:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(50, $l, utf8_decode($pf['rg']), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(10, $l, utf8_decode("CPF:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(50, $l, utf8_decode($pf['cpf']), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(10, $l, utf8_decode("CCM:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($pf['ccm']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(39, $l, utf8_decode("Data de nascimento:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(55, $l, date("d/m/Y", strtotime($pf['data_nascimento'])), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(29, $l, utf8_decode("Nacionalidade:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($pf['nacionalidade']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(14, $l, utf8_decode("E-mail:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($pf['email']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(21, $l, utf8_decode("Telefones:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode(isset($pf['telefones']) ? implode(" | ", $pf['telefones']) : ""), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(9, $l, utf8_decode("NIT:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(50, $l, utf8_decode($pf['nit']), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(11, $l, utf8_decode("DRT:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($pf['drt']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(36, $l, utf8_decode("Grau de instrução:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($pfDados['grau_instrucao']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(12, $l, utf8_decode("Etnia:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(35, $l, utf8_decode($pfDados['descricao']), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(16, $l, utf8_decode("Gênero:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(40, $l, utf8_decode($pfDados['genero']), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(13, $l, utf8_decode("Trans:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(30, $l, utf8_decode($trans), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(11, $l, utf8_decode("PCD:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($trans), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(21, $l, utf8_decode("Endereço:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->MultiCell(150, $l, utf8_decode($pf['logradouro'] . ", " . $pf['numero'] . " " . $pf['complemento'] . " " . $pf['bairro'] . " - " . $pf['cidade'] . "-" . $pf['uf'] . " CEP: " . $pf['cep']));

if ($pf['banco']) {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(14, $l, utf8_decode("Banco:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($pf['banco']), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(17, $l, utf8_decode("Agência:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($pf['agencia']), 0, 1, 'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(13, $l, utf8_decode("Conta:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($pf['conta']), 0, 1, 'L');
}

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', 14);
$pdf->MultiCell(170, $l, utf8_decode("Dados Complementares"), "B", 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(55, $l, utf8_decode("Ano de execução do serviço:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($formacao->ano), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(38, $l, utf8_decode("Região preferencial:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($formacao->regiao), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(20, $l, utf8_decode("Programa:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($formacao->programa), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(23, $l, utf8_decode("Linguagem:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($formacao->linguagem), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(36, $l, utf8_decode("Função (1º opção):"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($formacao->cargo1), 0, 1, 'L');

if ($formacao->cargo2) {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(36, $l, utf8_decode("Função (2º opção):"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($formacao->cargo2), 0, 1, 'L');
}

if ($formacao->cargo3) {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(36, $l, utf8_decode("Função (3º opção):"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($formacao->cargo3), 0, 1, 'L');
}

$pdf->Ln(20);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(170, $l, utf8_decode("Cadastro enviado em:"), 0, 1, 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(170, $l, date("d/m/Y H:i:s", strtotime($formacao->data_envio)), 0, 1, 'C');

$pdf->Output();