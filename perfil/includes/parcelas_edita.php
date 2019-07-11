<?php
$con = bancoMysqli();
$conn = bancoPDO();

$idIncentivador = $_SESSION['idUser'];
$idProjeto = $_POST['idProjeto'];
$tipoPessoa = $_POST['tipoPessoa'];

$parcelas = $_POST['parcelas'] ?? NULL;
$arrayValor = $_POST['valores'] ?? [];
$arrayDatas = $_POST['datas'] ?? [];

$sqlVerifica = "SELECT id FROM parcelas_incentivo WHERE tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador' AND idProjeto = '$idProjeto'";
$queryVerifica = mysqli_query($con, $sqlVerifica);
$nums = mysqli_num_rows($queryVerifica);

if ($nums < $parcelas) {
    for ($i = 1; $i <= $nums; $i++) {
        $valor = dinheiroDeBr($arrayValor[$i]);
        $dataPagamento = exibirDataMysql($arrayDatas[$i]);

        $sqlUpdate = "UPDATE parcelas_incentivo SET valor = '$valor', data_pagamento = '$dataPagamento' WHERE tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador' AND idProjeto = '$idProjeto' AND numero_parcela = $i";

        if (mysqli_query($con, $sqlUpdate)) {
            gravarLog($sqlUpdate);
        } else {
            echo $sqlUpdate;
            echo "Erro ao editar!";
        }
    }

    $faltando = (intval($parcelas) - $nums);
    $count = $nums + 1;

    for ($i = 1; $i <= $faltando; $i++) {

        $valor = dinheiroDeBr($arrayValor[$count]);
        $dataPagamento = exibirDataMysql($arrayDatas[$count]);

        $sqlInsert = "INSERT INTO parcelas_incentivo (idProjeto, tipoPessoa, idIncentivador, numero_parcela, valor, data_pagamento, publicado) 
                                    VALUES ('$idProjeto', '$tipoPessoa', '$idIncentivador', '$count', '$valor', '$dataPagamento', 1)";

        if (mysqli_query($con, $sqlInsert)) {

            $sqlUpdate = "UPDATE incentivador_projeto SET numero_parcelas = '$parcelas' WHERE tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador' AND idProjeto = '$idProjeto'";

            if (mysqli_query($con, $sqlUpdate)) {
                gravarLog($sqlInsert);
                gravarLog($sqlUpdate);
            } else {
                echo "Erro ao editar!";
            }
        }
        $count++;
    }

} elseif ($nums > $parcelas) {

    $sobrando = $nums - $parcelas;

    echo "caiu no if nums > parcelas -- nums: " . $nums . " parcelas = " . $parcelas;

    for ($i = 1; $i <= $parcelas; $i++) {

        $valor = dinheiroDeBr($arrayValor[$i]);
        $dataPagamento = exibirDataMysql($arrayDatas[$i]);

        $sqlUpdate = "UPDATE parcelas_incentivo SET valor = '$valor', data_pagamento = '$dataPagamento' WHERE tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador' AND idProjeto = '$idProjeto' AND numero_parcela = $i";

        if (mysqli_query($con, $sqlUpdate)) {
            gravarLog($sqlUpdate);
        } else {
            echo "Erro ao editar!";
        }
    }

    $count = $parcelas + 1;

    for ($i = 1; $i <= $sobrando; $i++) {
        $valor = dinheiroDeBr($arrayValor[$i]);
        $dataPagamento = exibirDataMysql($arrayDatas[$i]);

        $sqlDelete = "DELETE FROM parcelas_incentivo WHERE tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador' AND idProjeto = '$idProjeto' AND numero_parcela = $count";

        if (mysqli_query($con, $sqlDelete)) {
            $sqlUpdate = "UPDATE incentivador_projeto SET numero_parcelas = '$parcelas' WHERE tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador' AND idProjeto = '$idProjeto'";

            if (mysqli_query($con, $sqlUpdate)) {
                gravarLog($sqlDelete);
                gravarLog($sqlUpdate);
            } else {
                echo "Erro ao editar!";
            }
        }

        $count++;
    }

} else {

    for ($i = 1; $i <= $parcelas; $i++) {

        $valor = dinheiroDeBr($arrayValor[$i]);
        $dataPagamento = exibirDataMysql($arrayDatas[$i]);

        $sqlUpdate = "UPDATE parcelas_incentivo SET valor = '$valor', data_pagamento = '$dataPagamento' WHERE tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador' AND idProjeto = '$idProjeto' AND numero_parcela = $i";

        if (mysqli_query($con, $sqlUpdate)) {
            gravarLog($sqlUpdate);
        } else {
            echo $sqlUpdate;
            echo "Erro ao editar!";
        }
    }
}




