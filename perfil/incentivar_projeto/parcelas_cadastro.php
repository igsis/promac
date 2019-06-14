<?php
$con = bancoMysqli();

$idIncentivador = $_SESSION['idUser'];
$idProjeto = $_POST['idProjeto'];
$tipoPessoa = $_POST['tipoPessoa'];

$parcelas = $_POST['parcelas'];
$arrayValor = $_POST['arrayValor'];
$arrayData = $_POST['arrayData'];


for ($i = 1; $i <= $parcelas; $i++) {
    $valor = dinheiroDeBr($arrayValor[$i]);
    $sql = "INSERT INTO parcelas_incentivo (idProjeto, tipoPessoa, idIncentivador, numero_parcela, valor, data_pagamento, publicado) 
                                    VALUES ('$idProjeto', '$tipoPessoa', '$idIncentivador', '$i', '$valor', ' $arrayData[$i]', 1)";

    echo $sql;

    if (mysqli_query($con, $sql)) {
        gravarLog($sql);

        $update = "UPDATE incentivador_projeto SET numero_parcelas = '$parcelas' WHERE tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador' AND idProjeto = '$idProjeto'";
        mysqli_query($con, $update);
        gravarLog($update);

        echo $sql . $update;

    } else {

    }
}




