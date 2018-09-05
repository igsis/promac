<?php
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once("../include/lib/fpdf/fpdf.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

//CONEXÃO COM BANCO DE DADOS
$con = bancoMysqli();

$tipoPessoa = $_GET['tipo'];
$idProjeto = $_GET['projeto'];
$idPessoa = $_GET['pessoa'];

session_start();

class PDF extends FPDF
{
    // Simple table
    function Tabela($header, $data)
    {
        //Data
        foreach($data as $col)
            $this->Cell(40,7,$col,1);
        $this->Ln();
        // Data
    }
}

$ano=date('Y');

$queryProjeto = "SELECT * FROM projeto WHERE idProjeto = '$idProjeto' AND publicado = 1";
$enviaP = mysqli_query($con, $queryProjeto);
/*
  Dados gerais do projeto.
*/
while($row = mysqli_fetch_array($enviaP))
{
    $protocoloP = $row['protocolo'];
    $nomeProjeto = $row['nomeProjeto'];
    $idAreaAtuacao = $row['idAreaAtuacao']; //search it
    $vProjeto = $row['valorProjeto'];
    $vIncentivo = $row['valorIncentivo'];
    $vFinanciamento = $row['valorFinanciamento'];
    $idRenunciaFiscal = $row['idRenunciaFiscal']; //search it
    $exposicaoMarca = $row['exposicaoMarca'];
    $resumoProjeto = $row['resumoProjeto'];
    $curriculo = $row['curriculo'];
    $descricao = $row['descricao'];
    $justificativa = $row['justificativa'];
    $objetivo = $row['objetivo'];
    $metodologia = $row['metodologia'];
    $contrapartida = $row['contrapartida'];
    $publicoAlvo = $row['publicoAlvo'];
    $planoDivulgacao = $row['planoDivulgacao'];
    $inicioCronograma = $row['inicioCronograma'];
    $fimCronograma = $row['fimCronograma'];
    $idCronograma = $row['idCronograma']; //search it
    $totalPreProducao = $row['totalPreProducao'];
    $totalProducao = $row['totalProducao'];
    $totalImprensa = $row['totalImprensa'];
    $totalAdministrativos = $row['totalCustosAdministrativos'];
    $totalImpostos = $row['totalImpostos'];
    $totalAgenciamento = $row['totalAgenciamento'];
    $totalOutrosFinanciamentos = $row['totalOutrosFinanciamentos'];
    $video1 = $row['video1'];
    $video2 = $row['video2'];
    $video3 = $row['video3'];
    $valorAProvado = $row['valorAprovado'];
    $idStatus = $row['idStatus'];
}

/*
  Dados dos locais de realização.
*/
$queryLocal = "SELECT * FROM locais_realizacao AS LOC
                LEFT JOIN zona ON LOC.idZona =  zona.idZona
                LEFT JOIN subprefeitura ON LOC.idSubprefeitura = subprefeitura.idSubprefeitura
                LEFT JOIN distrito ON LOC.idDistrito = distrito.idDistrito
                WHERE idProjeto = '$idProjeto' AND publicado = 1";
$enviaLocal = mysqli_query($con, $queryLocal);
$rowLocal = mysqli_fetch_array($enviaLocal);

/*
  Dados de renúncia fiscal.
*/
$queryRen = "SELECT renunciaFiscal from renuncia_fiscal where idRenuncia = '$idRenunciaFiscal'";
$enviaRen = mysqli_query($con, $queryRen);
$rows = mysqli_fetch_array($enviaRen);
$renunciaFiscal = $rows['renunciaFiscal'];

/*
  Dados do cronograma.
*/
$queryCrono = "SELECT * FROM cronograma WHERE idCronograma = '$idCronograma'";
$enviaCrono = mysqli_query($con, $queryCrono);
while($rowCron = mysqli_fetch_array($enviaCrono))
{
    $captacaoRecurso = $rowCron['captacaoRecurso'];
    $preProducao = $rowCron['preProducao'];
    $producao = $rowCron['producao'];
    $posProducao = $rowCron['posProducao'];
    $prestacaoContas = $rowCron['prestacaoContas'];
}

/*
  Dados da área de atuação.
*/
$queryAreaAt = "SELECT areaAtuacao FROM area_atuacao WHERE idArea = '$idAreaAtuacao'";
$enviaAreaAt = mysqli_query($con, $queryAreaAt);
$rowArea = mysqli_fetch_array($enviaAreaAt);
$areaAtuacao = $rowArea['areaAtuacao'];

/*
  Dados de orçamento.
*/
$queryOrca = "SELECT * FROM orcamento AS ORC
              LEFT JOIN etapa ON ORC.idEtapa = etapa.idEtapa
              LEFT JOIN unidade_medida ON ORC.idUnidadeMedida = unidade_medida.idUnidadeMedida
              WHERE idProjeto = '$idProjeto' AND publicado = 1 ORDER BY idOrcamento ASC";
$enviaOrca = mysqli_query($con, $queryOrca);
$rowOrca = mysqli_fetch_array($enviaOrca);


/*
  Ficha técnica
*/
$queryFicha = "SELECT * FROM ficha_tecnica WHERE idProjeto = '$idProjeto' AND publicado = 1";
$enviaFicha = mysqli_query($con,$queryFicha);
while($rowFicha = mysqli_fetch_array($enviaFicha))
{
    $nomeFicha = $rowFicha['nome'];
    $cpfFicha = $rowFicha['cpf'];
    $funcaoFicha = $rowFicha['funcao'];
}

/*
  Dados das notas.
*/
$queryNota = "SELECT * FROM notas WHERE idProjeto = '$idProjeto'";
$enviaNota = mysqli_query($con, $queryNota);
while($rowNota = mysqli_fetch_array($enviaNota))
{
    $dataNota = $rowNota['data'];
    $notaN = $rowNota['nota'];
}

//GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

$x=20;
$l=6; //DEFINE A ALTURA DA LINHA

$pdf->SetXY( $x , 15 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 16);
$pdf->MultiCell(170,$l,utf8_decode(strtoupper("Projeto: $nomeProjeto")));

$pdf->Ln();
$pdf->Ln();

if($tipoPessoa == 1)
{
    $pf = recuperaDados("pessoa_fisica","idPf",$idPessoa);
    $NomePF = $pf["nome"];
    $RGPF = $pf["rg"];
    $CPF = $pf["cpf"];
    $EnderecoPF = $pf ["logradouro"];
    $NumeroPF = $pf["numero"];
    $BairroPF = $pf["bairro"];
    $CidadePF = $pf["cidade"];
    $estadoPF = $pf['estado'];
    $CepPF = $pf["cep"];
    $numeroPF = $pf['numero'];
    $complementoPF = $pf['complemento'];
    $telefonePF = $pf['telefone'];
    $celularPF = $pf['celular'];
    $emailPF = $pf['email'];

    if($pf['cooperado'] == 1)
    {
        $cooperadoPF = "sim";
    }
    else if($pf['cooperado'] == 2)
    {
        $cooperadoPF = "não";
    }

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 14);
    $pdf->Cell(180,5,utf8_decode("Dados de pessoa física"),0,1,'C');

    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(14,$l,utf8_decode("Nome:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->MultiCell(162,$l,utf8_decode($NomePF));

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(8,$l,utf8_decode("RG:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->MultiCell(170,$l,utf8_decode($RGPF));

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(10,$l,utf8_decode("CPF:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->MultiCell(170,$l,utf8_decode($CPF));

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(20,$l,utf8_decode("Endereço:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->MultiCell(180,$l,utf8_decode($EnderecoPF.", ".$numeroPF." ".$complementoPF." - ".$CidadePF." - ".$estadoPF));

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(20,$l,utf8_decode("Telefone:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(150,$l,utf8_decode($telefonePF." | ".$celularPF),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(13,$l,utf8_decode("Email:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(157,$l,utf8_decode($emailPF),0,1,'L');
}
else if($tipoPessoa == 2)
{
    $pj = recuperaDados("pessoa_juridica","idPj",$idPessoa);
    $razaoSocial = $pj['razaoSocial'];
    $cnpj = $pj['cnpj'];
    $logradouroPJ = $pj['logradouro'];
    $bairroPJ = $pj['bairro'];
    $cidadePJ = $pj['cidade'];
    $estadoPJ = $pj['estado'];
    $cepPJ = $pj['cep'];
    $numeroPJ = $pj['numero'];
    $complementoPJ = $pj['complemento'];
    $telefonePJ = $pj['telefone'];
    $celularPJ = $pj['celular'];
    $emailPJ = $pj['email'];

    if($pj['cooperativa'] == 1)
    {
        $cooperativa = "sim";
    } else if($pj['cooperativa'] == 2){
        $cooperativa = "não";
    }

    $idRepresentante = $pj['idRepresentanteLegal'];

    $queryRep = "SELECT * FROM representante_legal WHERE idRepresentanteLegal = '$idRepresentante'";
    $enviaRep = mysqli_query($con, $queryRep);
    while($rowRep = mysqli_fetch_array($enviaRep))
    {
        $nomeRep = $rowRep['nome'];
        $cpfRep = $rowRep['cpf'];
        $rgRep = $rowRep['rg'];
        $logradouroRep = $rowRep['logradouro'];
        $bairroRep = $rowRep['bairro'];
        $cidadeRep = $rowRep['cidade'];
        $estadoRep = $rowRep['estado'];
        $cepRep = $rowRep['cep'];
        $numeroRep = $rowRep['numero'];
        $complementoRep = $rowRep['complemento'];
        $telefoneRep = $rowRep['telefone'];
        $celularRep = $rowRep['celular'];
        $emailRep = $rowRep['email'];
    }

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 14);
    $pdf->Cell(180,5,utf8_decode("Dados de pessoa jurídica"),0,1,'C');

    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(27,$l,utf8_decode("Razão Social:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(143,$l,utf8_decode($razaoSocial),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(13,5,utf8_decode("CNPJ:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(155,$l,utf8_decode($cnpj),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(20,$l,utf8_decode("Endereço:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->MultiCell(180,$l,utf8_decode($logradouroPJ.", ".$numeroPJ." ".$complementoPJ." - ".$bairroPJ." - ".$cidadePJ." - ".$estadoPJ));

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(20,$l,utf8_decode("Telefone:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(150,$l,utf8_decode($telefonePJ." | ".$celularPJ),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(13,$l,utf8_decode("Email:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(157,$l,utf8_decode($emailPJ),0,1,'L');

    $pdf->Ln();
    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 14);
    $pdf->Cell(180,5,utf8_decode("Dados do representante legal"),0,1,'C');

    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(14,$l,utf8_decode("Nome:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->MultiCell(162,$l,utf8_decode($nomeRep));

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(8,$l,utf8_decode("RG:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->MultiCell(170,$l,utf8_decode($rgRep));

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(10,$l,utf8_decode("CPF:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->MultiCell(170,$l,utf8_decode($cpfRep));

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(20,$l,utf8_decode("Endereço:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->MultiCell(180,$l,utf8_decode($logradouroRep.", ".$numeroRep." ".$complementoRep." - ".$bairroRep." - ".$cidadeRep." - ".$estadoRep." CEP: ".$cepRep));

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(20,$l,utf8_decode("Telefone:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(150,$l,utf8_decode($telefoneRep." | ".$celularRep),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(13,$l,utf8_decode("Email:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(157,$l,utf8_decode($emailRep),0,1,'L');
}

$pdf->Ln();
$pdf->Ln();

/*
  DADOS DO PROJETO
*/
$pdf->SetX($x);
$pdf->SetFont('Arial','B', 14);
$pdf->Cell(180,$l,utf8_decode("Dados do projeto"),0,1,'C');

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(21,$l,utf8_decode("Protocolo:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(60,$l,utf8_decode(substr($protocoloP, 0, 4).".".substr($protocoloP, 4, 2).".".substr($protocoloP, 6, 2).".".substr($protocoloP, -5)),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(32,$l,utf8_decode("Área de atuação:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(138,$l,utf8_decode($areaAtuacao),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(42,$l,utf8_decode("Valor total do projeto:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(60,$l,utf8_decode("R$ ".dinheiroParabr($vProjeto)),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(78,$l,utf8_decode("Valor do Incentivo solicitado no Pro-Mac:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(60,$l,utf8_decode("R$ ".dinheiroParabr($vIncentivo)),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(61,$l,utf8_decode("Valor de outros financiamentos:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(60,$l,utf8_decode("R$ ".dinheiroParabr($vFinanciamento)),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(66,$l,utf8_decode("Enquadramento da renúncia fiscal:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(60,$l,utf8_decode($renunciaFiscal),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(31,$l,utf8_decode("Descrição da exposição da marca e indicação do valor do ingresso:"),0,1,'L');
$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode($exposicaoMarca));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(170,$l,utf8_decode("Resumo do projeto:"),'B',1,'L');
$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode($resumoProjeto));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(170,$l,utf8_decode("Curriculo:"),'B',1,'L');
$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode($curriculo));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(170,$l,utf8_decode("Descrição do objeto e atividades:"),'B',1,'L');
$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode($descricao));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(170,$l,utf8_decode("Justificativa do projeto:"),'B',1,'L');
$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode($justificativa));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(170,$l,utf8_decode("Objetivos e metas:"),'B',1,'L');
$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode($objetivo));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(170,$l,utf8_decode("Metodologia e parâmetros a serem utilizados para aferição do cumprimento de metas:"),'B',1,'L');
$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode($metodologia));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(170,$l,utf8_decode("Descrição da contrapartida:"),'B',1,'L');
$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode($contrapartida));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(170,$l,utf8_decode("Locais:"),'B',1,'L');

foreach ($enviaLocal as $loc)
{
    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(13,$l,utf8_decode("Local:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(149,$l,utf8_decode($loc['local']),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(35,$l,utf8_decode("Público estimado:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(149,$l,utf8_decode($loc['estimativaPublico']),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(12,$l,utf8_decode("Zona:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(149,$l,utf8_decode($loc['zona']),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(38,$l,utf8_decode("Prefeitura Regional:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(149,$l,utf8_decode($loc['subprefeitura']),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(16,$l,utf8_decode("Distrito:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(149,$l,utf8_decode($loc['distrito']),0,1,'L');

    $pdf->Ln();
}

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(170,$l,utf8_decode("Público alvo:"),'B',1,'L');
$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode($publicoAlvo));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(170,$l,utf8_decode("Plano de divulgação:"),'B',1,'L');
$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode($planoDivulgacao));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(170,$l,utf8_decode("Ficha técnica:"),'B',1,'L');

foreach ($enviaFicha as $fic)
{
    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(13,$l,utf8_decode("Nome:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(157,$l,utf8_decode($fic['nome']),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(12,$l,utf8_decode("CPF:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(149,$l,utf8_decode($fic['cpf']),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(17,$l,utf8_decode("Função:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(153,$l,utf8_decode($fic['funcao']),0,1,'L');

    $pdf->Ln();
}

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(170,$l,utf8_decode("Cronograma"),'B',1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(67,$l,utf8_decode("Data estimada de início do projeto:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(69,$l,utf8_decode($inicioCronograma),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(65,$l,utf8_decode("Data estimada do final do projeto:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(80,$l,utf8_decode($fimCronograma),0,1,'L');

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(170,$l,utf8_decode("Etapas do cronograma"),'B',1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(43,$l,utf8_decode("Captação de recursos:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(127,$l,utf8_decode($captacaoRecurso),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(28,$l,utf8_decode("Pré produção:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(142,$l,utf8_decode($preProducao),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(20,$l,utf8_decode("Produção:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(150,$l,utf8_decode($producao),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(29,$l,utf8_decode("Pós produção:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(141,$l,utf8_decode($posProducao),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(41,$l,utf8_decode("Prestação de contas:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(129,$l,utf8_decode($prestacaoContas),0,1,'L');

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(180,$l,utf8_decode("Orçamento"),'B',1,'L');

foreach ($enviaOrca as $orc)
{
    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(14,$l,utf8_decode("Etapa:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(80,$l,utf8_decode($orc['etapa']),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(23,$l,utf8_decode("Obs. etapa:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->MultiCell(147,$l,utf8_decode($orc['observacoesEtapa']));

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(22,$l,utf8_decode("Descrição:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(80,$l,utf8_decode($orc['descricao']),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(24,$l,utf8_decode("Quantidade:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(80,$l,utf8_decode($orc['quantidade']),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(38,$l,utf8_decode("Unidade de medida:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(80,$l,utf8_decode($orc['unidadeMedida']),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(32,$l,utf8_decode("Obs. unid. med.:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(80,$l,utf8_decode($orc['observacoes']),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(41,$l,utf8_decode("Quantidade Unidade:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(80,$l,utf8_decode($orc['quantidadeUnidade']),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(28,$l,utf8_decode("Valor unitário:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(80,$l,utf8_decode("R$ ".dinheiroParaBr($orc['valorUnitario'])),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(22,$l,utf8_decode("Valor total:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(80,$l,utf8_decode("R$ ".dinheiroParaBr($orc['valorTotal'])),0,1,'L');

    $pdf->Ln();
}

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(180,$l,utf8_decode("Totais"),'B',1,'L');

for ($i = 1; $i <= 7; $i++)
{
    $sql_etapa = "SELECT SUM(valorTotal) AS tot FROM orcamento
				  WHERE publicado > 0 AND idEtapa = '$i' AND idProjeto ='$idProjeto' 
				  ORDER BY idOrcamento";
    $query_etapa = mysqli_query($con,$sql_etapa);
    $lista = mysqli_fetch_array($query_etapa);
    $etapa = recuperaDados("etapa","idEtapa",$i);

    $pdf->SetX($x);
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(30,$l,utf8_decode($etapa['etapa'].": R$ ".dinheiroParaBr($lista['tot'])),0,1,'L');
}
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(180,$l,utf8_decode("Link do Youtube"),'B',1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode("Link 1: " . $video1));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode("Link 2: " . $video2));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode("Link 3: " . $video3));

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();


$pdf->Output();


?>