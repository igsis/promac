<?php
$con = bancoMysqli();
$idPf = $_SESSION['idUser'];
$enviado = 0;
$tipoPessoa = 3;

$pf = recuperaDados("incentivador_pessoa_fisica", "idPf", $idPf);
$etapaArray = recuperaDados("etapas_incentivo", "idIncentivador", $idPf);

$liberado = $pf['liberado'];
$etapa = $etapaArray['etapa'];

switch ($liberado) {
    case '4':
        $statusIncentivador = "Em análise";
        break;
    case '5':
        $statusIncentivador = "APTO - Incentivador não possui irregularidades fiscais, estando apto para incentivar projetos do PROMAC";
        break;
    case '6':
        $statuIncentivador = "INAPTO";
        break;
}


if (isset($_POST['enviarSMC'])) {
    $sqlLiberado = "UPDATE incentivador_pessoa_fisica SET liberado = 4 WHERE idPf = $idPf";
    $sqlEtapa = "UPDATE etapas_incentivo SET etapa = 2 WHERE idIncentivador = $idPf";

    if (mysqli_query($con, $sqlLiberado) && mysqli_query($con, $sqlEtapa)) {
        $enviado = 1;
        $mensagem = "<font color='#01DF3A'><strong>Suas certidões de regularidade fiscal foram enviadas à SMC!</strong></font>";
        gravarLog($sqlLiberado);
        gravarLog($sqlEtapa);
    }
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
        ?>
        <?php
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

                </div>
                <div class="tab-pane fade" id="resumo">
                    <?php
                    echo "<br><div class='alert alert-warning'>
	                    <strong>Aviso!</strong> Seus dados já foram aceitos, portanto, não podem ser alterados.</div>";
                    include 'resumo_dados_incentivador_pf.php';
                    ?>
                </div>
            </div>

            <?php
            echo "<h5>" . $mensagem . "</h5>";
        }
        ?>
        <br>
        <ul class="list-group">
            <li class="list-group-item list-group-item-success">
                <strong>Status da Análise de Regularidade Fiscal do Incentivador: <?= $statusIncentivador ?>
                    .</strong>
            </li>
        </ul>

        <div class="well">
            <div class="form-group">
                <table class='table table-condensed table-striped text-center'>
                    <thead>
                    <tr class='list_menu' style="font-weight: bold;">
                        <td>Tipo de arquivo</td>
                        <td>Nome do arquivo</td>
                        <td width="10%">Data do envio</td>
                        <td width='10%'>Status</td>
                        <td>Observações</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = "SELECT *
                                        FROM lista_documento as list
                                        INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
                                        WHERE arq.idPessoa = '$idPf'
                                        AND list.idListaDocumento IN (39, 40, 41, 42, 43, 53)
                                        AND arq.idTipo = '$tipoPessoa'
                                        AND arq.publicado = '1'";
                    $query = mysqli_query($con, $sql);
                    $linhas = mysqli_num_rows($query);
                    $count = 0;
                    while ($arquivo = mysqli_fetch_array($query)) {
                        echo "<tr>
                                <td class='list_description'>(" . $arquivo['documento'] . ")</td>
                                <td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>
                                <td class='list_description'>" . exibirDataBr($arquivo['dataEnvio']) . "</td>";
                        $queryy = "SELECT idStatusDocumento FROM upload_arquivo WHERE idUploadArquivo = '" . $arquivo['idUploadArquivo'] . "'";
                        $send = mysqli_query($con, $queryy);
                        $row = mysqli_fetch_array($send);

                        $idStatus = $row['idStatusDocumento']; // == '' ? 'Em análise' : $row['idStatusDocumento'];

                        switch ($idStatus) {
                            case '':
                                $status = "Em análise";
                                $cor = "orange";
                                break;
                            case 1:
                                $status = "Aceito";
                                $cor = "green";
                                break;
                            case 3:
                                $status = "Negado";
                                $cor = "red";
                                break;
                        }

                        echo "<td class='list_description'>                                   
                                        <input class='form-control text-center' style='color: $cor' type='text' value='$status' disabled>
                                    </td>";
                        $queryOBS = "SELECT observacoes FROM upload_arquivo WHERE idUploadArquivo = '" . $arquivo['idUploadArquivo'] . "'";
                        $send = mysqli_query($con, $queryOBS);
                        $row = mysqli_fetch_array($send);
                        echo "<td class='list_description'>
                                    <input  class='form-control text-center' type='text' maxlength='100' disabled id='observ' value='" . $row['observacoes'] . "'/> 
                                </td>";
                        $count++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
        </section>

        <?php
        break;
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