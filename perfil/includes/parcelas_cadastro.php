<?php
$con = bancoMysqli();

$idIncentivador = $_SESSION['idUser'];
$idIncentivadorProjeto = $_POST['idIncentivadorProjeto'];

$parcelas = $_POST['parcelas'];
$valores = $_POST['valores'];
$datas = $_POST['datas'];

for ($i = 1; $i <= $parcelas; $i++) {
    $valor = dinheiroDeBr($valores[$i]);
    $data = exibirDataMysql($datas[$i]);
    $sql = "INSERT INTO parcelas_incentivo (idIncentivadorProjeto, numero_parcela, valor, data_pagamento, publicado) 
                                    VALUES ('$idIncentivadorProjeto', '$i', '$valor', ' $data', 1)";

    if (mysqli_query($con, $sql)) {
        gravarLog($sql);

        $update = "UPDATE incentivador_projeto SET numero_parcelas = '$parcelas' WHERE idIncentivadorProjeto = '$idIncentivadorProjeto'";

        if(mysqli_query($con, $update)){
            gravarLog($update);
        }
    }
}




