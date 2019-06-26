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

if ($tipoPessoa == "4") {
    $pf = recuperaDados("pessoa_fisica", "idPf", $projeto['idPf']);
} else {
    $pj = recuperaDados("pessoa_juridica", "idPj", $projeto['idPj']);
    $rep = recuperaDados("representante_legal","idRepresentanteLegal",$pj['idRepresentanteLegal']);
}
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
        $(function () {
            window.print();
            window.close();
        });
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
            width: 100%;
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
        <img src="../visual/images/cabecalho_carta_incentivo.png">
        <br>
        <h1 style="margin-left: 20%">CARTA DE INTENÇÃO DE INCENTIVO </h1>
        <br>

        <div class="row">
            <h3><?php echo primeiraEstofreContrato($idProjeto); ?>  </h3>
        </div>


    </div>
</body>
</html>