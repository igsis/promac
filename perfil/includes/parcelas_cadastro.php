<?php
$con = bancoMysqli();

$idIncentivador = $_SESSION['idUser'];
$idProjeto = $_POST['idProjeto'];
$tipoPessoa = $_POST['tipoPessoa'];

$parcelas = $_POST['parcelas'];
$arrayValor = $_POST['arrayValor'];
$arrayDatas = $_POST['arrayData'];


for ($i = 1; $i <= $parcelas; $i++) {
    $valor = dinheiroDeBr($arrayValor[$i]);
    $sql = "INSERT INTO parcelas_incentivo (idProjeto, tipoPessoa, idIncentivador, numero_parcela, valor, data_pagamento, publicado) 
                                    VALUES ('$idProjeto', '$tipoPessoa', '$idIncentivador', '$i', '$valor', ' $arrayDatas[$i]', 1)";

    if (mysqli_query($con, $sql)) {
        gravarLog($sql);

        $update = "UPDATE incentivador_projeto SET numero_parcelas = '$parcelas' WHERE tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador' AND idProjeto = '$idProjeto'";

        if(mysqli_query($con, $update)){
            gravarLog($update);
        }
    }
}




