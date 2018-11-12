<?php
//require '../include/';
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

$con = bancoMysqli();

$idProjeto = $_GET['idProjeto'];

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=termo-de-responsabilidade.doc");
setlocale(LC_TIME,'portuguese');
date_default_timezone_set('America/Sao_Paulo');



?>

<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
    </head>
    <body>

        <?= "<h3 style='text-align: center;font-family: sans-serif;'>TERMO DE RESPONSABILIDADE DE REALIZAÇÃO DE PROJETO CULTURAL</h3>
         </br>" ?>

        <?php

            $sql = "SELECT * FROM promac.`pessoa_fisica` 
                    WHERE idPf = (SELECT projeto.`idPf` FROM projeto WHERE idProjeto = '$idProjeto')";
        ?>


    </body>
</html>
