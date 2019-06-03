<?php
$con = bancoMysqli();
$idPf = $_SESSION['idUser'];
$tipoPessoa = 3;

$pf = recuperaDados("incentivador_pessoa_fisica", "idPf", $idPf);
$etapaArray = recuperaDados("etapas_incentivo", "idIncentivador", $idPf);

$liberado = $pf['liberado'];
$etapa = $etapaArray['etapa'];

switch ($liberado) {
    case '4':
        $statusIncentivador = "Status da Análise de Regularidade Fiscal do Incentivador: Em análise";
        $cor_status = "warning";
        break;
    case '5':
        $statusIncentivador = "APTO - Incentivador não possui irregularidades fiscais, estando apto para incentivar projetos do PROMAC";
        $cor_status = "success";
        break;
    case '6':
        $statusIncentivador = "INAPTO - Incentivador possui irregularidades fiscais, não estando apto para incentivar projetos do <b>PROMAC</b>. <br> Regularize suas pendências para que possamos dar continuidade ao processo de incentivo fiscal";
        $cor_status = "danger";
        break;
}


switch ($etapa) {
case '':
    ?>
    <div class="well">
        <label for="admResposta">Você deseja incentivar um projeto agora?</label><br>
        <input type="radio" name="admResposta" value="1" class="resposta" id="sim"> Sim
        <input type="radio" name="admResposta" value="0" class="resposta" id="nao" checked> Não

        <div id="aviso" style="display: none;">
            <hr>
            <div class='alert alert-warning'>
                Para encontrar um projeto para incentivar, continue buscando os projetos aprovados semanalmente na
                Consulta Pública disponível na Home do site PROMAC.<br> Depois de escolher o projeto que deseja
                incentivar, retorne a essa página, por gentileza.
            </div>
        </div>
        <div id="incentivar" style="display: none;">
            <br>
            <form method="post" action="?perfil=includes/documentos_fiscais_incentivador_pf" class="form-group">
                <input type="submit" name="iniciar_incentivo" value="Iniciar incentivo" class="btn btn-success">
            </form>
        </div>
    </div>
    <?php
    break;
case '1':
    echo "<script>location.href = '?perfil=includes/documentos_fiscais_incentivador_pf'</script>";
    break;

case '2':
case '3':
    echo "<script>location.href = '?perfil=includes/incentivador_etapa3_visuliza_docs'</script>";
    break;

    case '4':
    if (isset($mensagem)) {
    ?>
    <section id="list_items" class="home-section bg-white">
        <div class="container"><?php include 'menu_interno_pf.php' ?>
            <ul class="nav nav-tabs">
                <li class="nav active"><a href="#admIncentivador" data-toggle="tab">Administrativo</a></li>
                <li class="nav"><a href="#resumo" data-toggle="tab">Resumo do projeto</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="admIncentivador">
                    <?php
                    echo "<h5>" . $mensagem . "</h5>";
                    }
                    ?>
                    <br>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-<?= $cor_status ?>">
                            <strong><?= $statusIncentivador ?>.</strong>
                        </li>
                    </ul>

                    <div class="well">
                        <form method="POST" action="?perfil=includes/incentivador_adm_pf" enctype="multipart/form-data">
                            <div class="form-group">
                                <h4><b>4 - Qual projeto você deseja incentivar? </b><br>
                                </h4>
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-6">
                                        <div class="input-group">
                                            <input type="text" name="projeto" class="form-control"
                                                   placeholder="Busque aqui o nome do projeto">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-default" style="font-size: 20px"><span
                                                            class="glyphicon glyphicon-search"></span></button>
                                            </div>
                                        </div><!-- /input-group -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php

                    }
                    ?>

                    <script>

                        var resposta = $('.resposta');
                        resposta.on("click", verificaResposta);
                        $(document).ready(verificaResposta());

                        function verificaResposta() {
                            if ($('#nao').is(':checked')) {
                                $('#aviso').css('display', 'block');
                                $('#incentivar').css('display', 'none');
                            } else if ($('#sim').is(':checked')) {
                                $('#aviso').css('display', 'none');
                                $('#incentivar').css('display', 'block');
                                // location.href = '?perfil=includes/documentos_fiscais_incentivador_pf'
                            }
                        }
                    </script>