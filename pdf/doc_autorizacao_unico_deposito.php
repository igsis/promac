<?php
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

session_start();

$con = bancoMysqli();

$idProjeto = $_GET['idProjeto'];


setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
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


$incentivador_projeto = $con->query("SELECT * FROM `incentivador_projeto` WHERE idProjeto ='$idProjeto'")->fetch_assoc();

if ($incentivador_projeto != null){
    if ($incentivador_projeto['tipoPessoa'] == 1){
        $incentivador = $con->query('SELECT `nome`, `cpf` FROM `incentivador_pessoa_fisica` WHERE `idPf` = '.$incentivador_projeto['idPessoa'])->fetch_assoc();
        $docIncentivador = $incentivador['cpf'];
        $nomeIncentivador = $incentivador['nome'];
    }else{
        $incentivador = $con->query('SELECT `razaoSocial`, `cnpj` FROM `incentivador_pessoa_juridica` WHERE `idPj` = '.$incentivador_projeto['idPessoa'])->fetch_assoc();
        $docIncentivador = $incentivador['cpf'];
        $nomeIncentivador = $incentivador['nome'];
    }
}

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=doc_autorizacao_unico_deposito.doc");
setlocale(LC_TIME, 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

?>
<html lang="pt-BR">
<meta http-equiv="Content-Type" charset="UTF-8">
<head>
    <style>
        .sansSerif {
            font-family: sans-serif;
        }
        #header {
            display: flex;
            flex-direction: column;
        }
        #header div{
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
<div class="sansSerif">
    <div id="header">
        <img src="../visual/images/brasao.jpg" alt="Prefeitura de São Paulo">
        <div>
            <p align="center"><strong>PREFEITURA DO MUNICÍPIO DE SÃO PAULO</strong></p>
            <p align="center"><strong>SECRETARIA MUNICIPAL DE CULTURA</strong></p>
            <p align="center"><strong>NÚCLEO DE INCENTIVO À CULTURA (PRO-MAC)</strong></p>
        </div>
    </div>
    <br>
    <br>
    <p align='center'><strong>AUTORIZAÇÃO ÚNICA DE DEPÓSITO</strong></p>
    <br><br>

    <p style="text-align: justify">A Secretaria Municipal de Cultura, representada pelo Programa Municipal de Apoio a Projetos Culturais – Pro-Mac, autoriza o contribuinte incentivador <strong><?= $incentivador_projeto != null ? $nomeIncentivador : 'XXXXXXXXXXXX' ?></strong>, inscrito no CPF/CNPJ sob o nº <strong><?= $incentivador_projeto != null ? $docIncentivador : 'XXXXXXXXXX' ?> </strong>, estando este com a documentação de acordo com o edital Pro-Mac 2020, a efetuar os depósitos dos valores de incentivo fiscal provenientes do imposto <strong>XXX</strong> para o projeto cultural aprovado denominado <strong>“<?= $nomeProjeto ?>”</strong>, conforme fora firmado no Contrato de Incentivo entre o incentivador acima e o proponente <?= $proponente ?>, <b>CNPJ n° <?= $documento ?></b>.</p>
    <p style="text-align: justify">De acordo com o item 106 do Edital Pro-Mac 2020, reiteramos que é de responsabilidade integral do incentivador o cálculo do valor a ser depositado mensalmente no projeto e que deverá ser levado em conta para a sua definição o limite de abatimento de 20% (vinte por cento) do total do imposto devido no mês.</p>
    <p style="text-align: justify">Conforme o item 108 do edital Pro-Mac 2020, tanto o <b>comprovante de depósito/transferência</b>, quanto o <b>extrato da conta corrente do projeto</b> deverão ser enviados <b>em conjunto</b> via e-mail para o endereço incentivopromac@prefeitura.sp.gov.br com no mínimo <b>5 (cinco) dias úteis de antecedência da data de vencimento do imposto</b>. O e-mail deverá ter obrigatoriamente como título o padrão abaixo:</p>
    <p style="text-align: justify"><b>“DEPÓSITO N° X (a depender do número de depósitos que o incentivador já tenha feito para o projeto) – NOME DO INCENTIVADOR + NOME DO PROJETO”.</b></p>
    <p style="text-align: justify">Caso os documentos mencionados não sejam enviados até o prazo estabelecido, o Núcleo de Incentivo à Cultura da SMC <b>não se responsabilizará pela não realização do abatimento fiscal do imposto no mês desejado</b>, conforme expresso no item 109 do mesmo edital.</p>
    <br><br>
    <br><br>
    <p></p>

    <p align="center"><b>São Paulo, <?= $cabecalho ?></b></p>

    <p>&nbsp;</p>
    <br><br>
</div>
</body>
</html>