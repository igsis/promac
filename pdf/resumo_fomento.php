<?php
require_once "../config/configGeral.php";

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once "../views/plugins/fpdf/fpdf.php";
// ACESSO AO BANCO
$pedidoAjax = true;
require_once "../config/configAPP.php";

// CONSULTA
$id = $_GET['id'];
require_once "../controllers/ProjetoController.php";
$projObj = new ProjetoController();
$projeto = $projObj->recuperaProjetoCompleto($id);

if ($projeto['pessoa_tipos_id'] == 2):
    require_once "../controllers/PessoaJuridicaController.php";
    $pjObj = new PessoaJuridicaController();
    $pj = $pjObj->recuperaPessoaJuridica(MainModel::encryption($projeto['pessoa_juridica_id']));

    require_once "../controllers/RepresentanteController.php";
    $repObj = new RepresentanteController();
    $rl = $repObj->recuperaRepresentante(MainModel::encryption($pj['representante_legal1_id']))->fetch(PDO::FETCH_ASSOC);
else:
    require_once "../controllers/PessoaFisicaController.php";
    $pfObj = new PessoaFisicaController();
    $pf = $pfObj->recuperaPessoaFisicaFom(MainModel::encryption($projeto['pessoa_fisica_id']));
    $pfDados = $pfObj->recuperaPfDados($pf['id'])->fetch(PDO::FETCH_ASSOC);
    $subpref = $pfObj->dadosAdcFom(['subprefeitura',$pf['subprefeitura_id']]);
endif;

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
$pdf->SetFont('Arial', 'B', 14);
$pdf->MultiCell(170, $l, utf8_decode($projeto['titulo']), 0, 'C');

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(120, $l, utf8_decode(""), '0', 0, 'L');
$pdf->Cell(50, $l, utf8_decode("Protocolo"), 'TLR', 1, 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(120, $l, utf8_decode(""), '0', 0, 'L');
$pdf->Cell(50, $l, utf8_decode($projeto['protocolo']), 'BLR', 1, 'C');

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(34, $l, utf8_decode("Nome do projeto:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(136, $l, utf8_decode($projeto['nome_projeto']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(54, $l, utf8_decode("Responsável pela inscrição:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(60, $l, utf8_decode($projeto['nome']), 0, 1, 'L');

if ($projeto['pessoa_tipos_id'] == 2) {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(46, $l, utf8_decode("Instituição responsável:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($projeto['instituicao']), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(10, $l, utf8_decode("Site:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($projeto['site']), 0, 1, 'L');
}

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(33, $l, utf8_decode("Valor do projeto:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(120, $l, utf8_decode("R$ {$projObj->dinheiroParaBr($projeto['valor_projeto'])} ({$projObj->valorPorExtenso($projeto['valor_projeto'])})"), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(41, $l, utf8_decode("Duração (em meses):"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($projeto['duracao'] . " mes(es)"), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(65, $l, utf8_decode("Nome do núcleo/coletivo artístico:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($projeto['nome_nucleo']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(65, $l, utf8_decode("Nome do representante do núcleo:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($projeto['representante_nucleo']), 0, 1, 'L');

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(63, $l, utf8_decode("Nome do produtor independente:"), 0, 0, 'L');
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(20, $l, utf8_decode($projeto['coletivo_produtor']), 0, 1, 'L');

if ($projeto['pessoa_tipos_id'] == 1) {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(32, $l, utf8_decode("Núcleo artístico:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(170, $l, utf8_decode($projeto['nucleo_artistico']), 0, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(23, $l, utf8_decode("Linguagem:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(147, $l, utf8_decode($projeto['linguagem']), 0, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(19, $l, utf8_decode("Temática:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(151, $l, utf8_decode($projeto['tematica']), 0, 1, 'L');
}

$pdf->Ln(10);

if ($projeto['pessoa_tipos_id'] == 1) {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(14, $l, utf8_decode("Nome:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($pf['nome']), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(11, $l, utf8_decode("CPF:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($pf['cpf']), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(16, $l, utf8_decode("Gênero:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($pfDados['genero']), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(25, $l, utf8_decode("Raça ou cor:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($pfDados['descricao']), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(39, $l, utf8_decode("Data de nascimento:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, date("d/m/Y", strtotime($pf['data_nascimento'])), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(25, $l, utf8_decode("Rede Social:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($pf['rede_social']), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(27, $l, utf8_decode("Escolaridade:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($pfDados['grau_instrucao']), 0, 1, 'L');

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
    $pdf->Cell(21, $l, utf8_decode("Endereço:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(150, $l, utf8_decode($pf['logradouro'] . ", " . $pf['numero'] . " " . $pf['complemento'] . " " . $pf['bairro'] . " - " . $pf['cidade'] . "-" . $pf['uf'] . " CEP: " . $pf['cep']));

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(28, $l, utf8_decode("Subprefeitura:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(150, $l, utf8_decode($subpref));
}

if ($projeto['pessoa_tipos_id'] == 2) {
    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(26, $l, utf8_decode("Razão social:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($pj['razao_social']), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(13, $l, utf8_decode("CNPJ:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($pj['cnpj']), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(14, $l, utf8_decode("E-mail:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($pj['email']), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(20, $l, utf8_decode("Telefones:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode(isset($pj['telefones']) ? implode(" | ", $pj['telefones']) : ""), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(20, $l, utf8_decode("Endereço:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->MultiCell(150, $l, utf8_decode($pj['logradouro'] . ", " . $pj['numero'] . " " . $pj['complemento'] . " " . $pj['bairro'] . " - " . $pj['cidade'] . "-" . $pj['uf'] . " CEP: " . $pj['cep']));

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(62, $l, utf8_decode("Representante legal da empresa:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($rl['nome']), 0, 1, 'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(8, $l, utf8_decode("RG:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(40, $l, utf8_decode($rl['rg']), 0, 0, 'L');
    $pdf->SetFont('Arial', 'B', $f);
    $pdf->Cell(10, $l, utf8_decode("CPF:"), 0, 0, 'L');
    $pdf->SetFont('Arial', '', $f);
    $pdf->Cell(20, $l, utf8_decode($rl['cpf']), 0, 1, 'L');
}
$pdf->Ln(20);

$pdf->SetX($x);
$pdf->SetFont('Arial', 'B', $f);
$pdf->Cell(170, $l, utf8_decode("Cadastro enviado em:"), 0, 1, 'C');

$pdf->SetX($x);
$pdf->SetFont('Arial', '', $f);
$pdf->Cell(170, $l, date("d/m/Y H:i:s", strtotime($projeto['data_inscricao'])), 0, 1, 'C');

$pdf->Output();