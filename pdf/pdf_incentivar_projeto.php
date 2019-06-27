<?php
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

//CONEXÃO COM BANCO DE DADOS

$con = bancoMysqli();

$idIncentivador = $_GET['idPessoa'];
$idProjeto = $_GET['idProjeto'];
$tipoPessoa = $_GET['tipoPessoa'];

$ano = date('Y');

$projeto = recuperaDados("projeto", "idProjeto", $idProjeto);
$renuncia = recuperaDados("renuncia_fiscal", "idRenuncia", $projeto['idRenunciaFiscal']);

if ($tipoPessoa == "4") {
    $pf = recuperaDados("pessoa_fisica", "idPf", $projeto['idPf']);
} else {
    $pj = recuperaDados("pessoa_juridica", "idPj", $projeto['idPj']);
    $rep = recuperaDados("representante_legal", "idRepresentanteLegal", $pj['idRepresentanteLegal']);
}

$sqlIncentivar = "SELECT * FROM incentivador_projeto WHERE idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa' AND idProjeto = '$idProjeto'";
$queryIncentivar = mysqli_query($con, $sqlIncentivar);
$infoIncentivar = mysqli_fetch_assoc($queryIncentivar);


?>
<html lang="br">
<head>
    <title>SMC / Pro-Mac - Programa Municipal de Apoio a Projetos Culturais</title>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- JQUEY Mask -->
    <script src="../visual/dist/js/jquery-1.12.4.min.js"></script>
    <script src="../visual/dist/js/jquery.mask.js"></script>
    <!-- JQuery -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="../visual/js/jquery.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            window.print();
        });

        $(window).bind('beforeunload', function() {
            alert("certeza qeu gostaria de fechar a pag");
        });

/*        $(function () {
            window.print();

            if (window.close()) {
                let teste = 1;
            };
        }); */
    </script>
    <!-- CSS -->
    <style>

        body {
            font-size: 15px;
            font-family: Arial;
            margin-top: 10px;
        }

        table {
            border-collapse: collapse;
            width: 70%;
        }

        table, th, td {
            border: 1px solid #9e9e9e;
        }

        @page {
            margin: 20mm;
            margin-left: 70px;
            margin-right: 70px;
            page-break-inside: avoid;
            size: A4;
        }
    </style>
</head>
<body>
<section id='list_items' class='home-section bg-white'>
    <div class='container' style='height: 800px;'>
        <img src="../visual/images/carta_incentivo.png">
        <br>
        <h1 style="margin-left: 20%">CARTA DE INTENÇÃO DE INCENTIVO </h1>
        <div class="row">
            <p style="font-size: 14px;"><?php echo primeiraEstrofeContrato($idProjeto); ?>  </p>
        </div>

        <div class="row">
            <p style="font-size: 14px;"><?php echo segundaEstrofeContrato($idIncentivador, $tipoPessoa); ?>  </p>
        </div>

        <div class="row">
            <p style="font-size: 14px;">1.1. O objeto da presente Carta de Incentivo referente ao projeto inscrito no
                Edital nº. 001/<?= $infoIncentivar['edital'] ?>
                do Pro-Mac denominado <?= $projeto['nomeProjeto'] ?>, aprovado com (<?= $renuncia['renunciaFiscal'] ?>)
                de renúncia fiscal devidamente aprovado pela municipalidade. </p>
        </div>

        <div class="row">
            <p style="font-size: 14px;">1.2. O imposto a ser utilizado para dedução do incentivo
                será: <?= $infoIncentivar['imposto'] ?>.
            </p>
        </div>

        <div class="row">
            <p style="font-size: 14px;">1.3. O incentivo acordado entre as partes cobrirá o projeto e será no valor total
                de R$ <?= dinheiroParaBr($infoIncentivar['valor_aportado']) . " (". trim(valorPorExtenso($infoIncentivar['valor_aportado'])) . ")"  ?>, a ser repassado conforme
                cronograma de distribuição abaixo descrito cabendo ao Contribuinte Incentivador à adoção das
                providências de que trata o Decreto Municipal nº. 58.041, de 20 de dezembro de 2017.
            </p>
        </div>

        <div style="margin-left: 160px">
            <table>
                <thead>
                <tr style="font-weight: bold; text-align: center; height: 35px">
                    <td>Parcela</td>
                    <td>Data</td>
                    <td>Valor</td>
                </tr>
                </thead>
                <tbody>
                <?php
                $sqlParcelas = "SELECT * FROM parcelas_incentivo WHERE idProjeto = '$idProjeto' AND tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador'";
                $queryParcelas = mysqli_query($con, $sqlParcelas);
                while ($parcela = mysqli_fetch_array($queryParcelas)) {
                    ?>
                    <tr style="text-align: center; height: 30px">
                        <td><?= $parcela['numero_parcela'] ?></td>
                        <td><?= exibirDataBr($parcela['data_pagamento']) ?></td>
                        <td>R$ <?= dinheiroParaBr($parcela['valor']) ?></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>

        <div class="row">
            <p style="font-size: 14px;">SOBRE A VIGÊNCIA </p>

                <p style="font-size: 14px;">2.1. A presente carta entrará em vigor na data de sua assinatura e vigerá até o exercício fiscal deste ano, podendo ser prorrogável.</p>

                <p style="font-size: 14px;">O presente Certificado é intransferível. </p>
        </div>

        <div class="row">
            <?php
            $dia = date("d");
            $mes = date('m');
            $ano = date('Y');

            switch ($mes){
                case 1: $mes = "JANEIRO"; break;
                case 2: $mes = "FEVEREIRO"; break;
                case 3: $mes = "MARÇO"; break;
                case 4: $mes = "ABRIL"; break;
                case 5: $mes = "MAIO"; break;
                case 6: $mes = "JUNHO"; break;
                case 7: $mes = "JULHO"; break;
                case 8: $mes = "AGOSTO"; break;
                case 9: $mes = "SETEMBRO"; break;
                case 10: $mes = "OUTUBRO"; break;
                case 11: $mes = "NOVEMBRO"; break;
                case 12: $mes = "DEZEMBRO"; break;
            }

            $mes = strtolower($mes);

            ?>
            <p style="font-size: 14px;">São Paulo, <?=$dia . " de " .ucfirst($mes) . " de " . $ano; ?>.
            </p>
        </div>
        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <p style="font-size: 14px;"> ____________________________________ <br> Nome completo <br> PROPONENTE            </p>
                </div>
                <br>
                <div class="col-md-6">
                    <p style="font-size: 14px;"> ____________________________________ <br> Nome completo do representante legal
                        <br> CONTRIBUINTE INCENTIVADOR
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>