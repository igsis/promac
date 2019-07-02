<?php
$con = bancoMysqli();
$idIncentivador = $_SESSION['idUser'];
$tipoPessoa = $_POST['tipoPessoa'] ?? $_GET['tipoPessoa'];

if (isset($_POST['idProjeto'])) {
    $idProjeto = $_POST['idProjeto'];

} else {
    $sqlProject = "SELECT idProjeto FROM etapas_incentivo WHERE tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador' AND (etapa = 9 || etapa = 10)";
    $queryProject = mysqli_query($con, $sqlProject);
    $arr = mysqli_fetch_assoc($queryProject);
    $idProjeto = $arr['idProjeto'];
}

$sqlIP = "SELECT * FROM incentivador_projeto WHERE idProjeto = '$idProjeto' AND idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa'";
$queryIP = mysqli_query($con, $sqlIP);
$infos = mysqli_fetch_assoc($queryIP);
$data_recebimento = new DateTime($infos['data_recebimento_carta']);


$sqlUltimaParcela = "SELECT * FROM parcelas_incentivo WHERE idProjeto = '$idProjeto' AND idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa' ORDER BY 'numero_parcela' ASC LIMIT 1";
$queryUltima = mysqli_query($con, $sqlUltimaParcela);
$parcelas = mysqli_fetch_assoc($queryUltima);
$data_pagamento = new DateTime($parcelas['data_pagamento']);

//echo $sqlUltimaParcela;

$intervalo = $data_pagamento->diff($data_recebimento);

echo $intervalo->d;

if ($intervalo->d < 15) {
    $mensagem = "<div style='color: red'>
                    <strong>PRAZO EXCEDIDO!</strong><br>
                    O recebimento da Carta de Incentivo original na SMC deve ocorrer antes de 15 dias do vencimento do tributo a ser utilizado para incentivo do projeto cultural. 
                    <br>Exigimos esse prazo para que a Secretaria possa executar o procedimento necessário para o abatimento do tributo. 
                    <br>Por favor, retorne ao item 6 e preencha novamente a Carta de Incentivo com a data atualizada e repita os passos seguintes.
                </div>";

} else {

    $sqlEtapa = "UPDATE etapas_incentivo SET etapa = 10 WHERE idProjeto = '$idProjeto' AND idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa'";
    if (mysqli_query($con, $sqlEtapa)) {
        $mensagem = "<div class='text-success'>
                    <strong>Certo!</strong><br>
                    Como recebemos a Carta de Incentivo original com mais de 15 dias de antecedência para o vencimento do tributo da 1ª parcela do aporte, podemos prosseguir com o procedimento de incentivo.
                </div>";
    }
}


$sqlEtapa = "SELECT etapa FROM etapas_incentivo WHERE idProjeto = '$idProjeto' AND idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa'";
$queryEtapa = mysqli_query($con, $sqlEtapa);
$etapaArray = mysqli_fetch_assoc($queryEtapa);
$etapa = $etapaArray['etapa'];


?>


<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include "menu_interno_pf.php"; ?>
        <ul class="nav nav-tabs">
            <li class="nav active"><a href="#admIncentivador" data-toggle="tab">Administrativo</a></li>
            <li class="nav"><a href="#resumo" data-toggle="tab">Resumo do projeto</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade" id="resumo">
                <?php
                echo "<br><div class='alert alert-warning'>
                                <strong>Aviso!</strong> Seus dados já foram aceitos, portanto, não podem ser alterados.</div>";
                include "resumo_dados_incentivador_pf.php";
                ?>
            </div>
            <div class="tab-pane fade in active" id="admIncentivador">
                <br>
                <div id="etapa9">
                    <?php
                    if (isset($mensagem)) {
                        echo "<h5>" . $mensagem . "</h5>";
                    }
                    ?>
                </div>
                <hr width="50%">
                <div id="etapa10">
                        <h6><b>10 - Solicite a autorização de depósito</b></h6>
                        <div class="col-md-offset-2 col-md-6 form-group">
                            <table class="table bg-white text-center table-hover table-responsive table-condensed table-bordered">
                                <thead class="bg-success">
                                <tr class="list_menu" style="font-weight: bold;">
                                    <td>Parcela</td>
                                    <td>Data</td>
                                    <td>Valor</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                //verificando parcelas
                                $sqlParcelas = "SELECT * FROM parcelas_incentivo WHERE idProjeto = '$idProjeto' AND tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador'";
                                $queryParcelas = mysqli_query($con, $sqlParcelas);
                                $numRows = mysqli_num_rows($queryParcelas);

                                while ($parcela = mysqli_fetch_array($queryParcelas)) {
                                    ?>
                                    <tr>
                                        <td class="list_description"><?= $parcela['numero_parcela'] ?></td>
                                        <td class="list_description"><?= exibirDataBr($parcela['data_pagamento']) ?></td>
                                        <td class="list_description"><?= dinheiroParaBr($parcela['valor']) ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="col-md-2 pull-left">
                            <button class="btn" style="background-color: white; margin-top: 10px; color: green;" onclick="mostrarDiv('etapa11')">
                                <span class="glyphicon glyphicon-arrow-left" style="margin-left: -20px; font-size: 13px;"></span>
                                &nbsp;Solicitar autorização de depósito desta parcela
                                <!--<span style="color: green;"></span>-->
                            </button>
                        </div>


                        <div class="row">
                            <form action="../pdf/pdf_incentivar_projeto.php" method="post" class="form-group">
                                <div class='col-md-12'>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="etapa11" style="display: none">
                    <div class="well">
                        <h6><b>11- Faça o upload dos documentos que comprovam que o aporte foi realizado na conta do projeto: </b></h6><br>

                    </div>

                </div>

            </div>
        </div>
    </div>
</section>


<script>
    function mostrarDiv(divId) {
        if ($('#' + divId).is(':visible')) {
            $('#' + divId).slideUp();
           // $('#icon_' + divId).html("<span class='glyphicon glyphicon-chevron-right'></span>");
        } else {
            $('#' + divId).slideDown('slow');
           // $('#icon_' + divId).html("<span class='glyphicon glyphicon-chevron-down'></span>");
        }
    }
</script>