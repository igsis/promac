<?php
$con = bancoMysqli();
$idPj = $_SESSION['idUser'];
$enviado = 0;
$tipoPessoa = 4;

$pj = recuperaDados("incentivador_pessoa_juridica", "idPj", $idPj);
$etapaArray = recuperaDados("etapas_incentivo", "idIncentivador", $idPj);

$liberado = $pj['liberado'];
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
    $sqlLiberado = "UPDATE incentivador_pessoa_juridica SET liberado = 4 WHERE idPj = $idPj";
    $sqlEtapa = "UPDATE etapas_incentivo SET etapa = 2 WHERE idIncentivador = $idPj";

    if (mysqli_query($con, $sqlLiberado) && mysqli_query($con, $sqlEtapa)) {
        $enviado = 1;
        $mensagem = "<font color='#01DF3A'><strong>Suas certidões de regularidade fiscal foram enviadas à SMC!</strong></font>";
        gravarLog($sqlLiberado);
        gravarLog($sqlEtapa);
    }
}

$apagados = '';

if (isset($_POST['apagar'])) {
    $idArquivo = $_POST['apagar'];
    $idListaDoc = $_POST['idListaDocumento'];
    $sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE idUploadArquivo = '$idArquivo'";
    if (mysqli_query($con, $sql_apagar_arquivo)) {
        $apagados .= $idListaDoc . ", ";
        $mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
        gravarLog($sql_apagar_arquivo);
    } else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
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
            <form method="post" action="?perfil=includes/documentos_fiscais_incentivador_pj" class="form-group">
                <input type="submit" name="iniciar_incentivo" value="Iniciar incentivo" class="btn btn-success">
            </form>
        </div>
    </div>
    <?php
    break;
case '1':
    echo "<script>location.href = '?perfil=includes/documentos_fiscais_incentivador_pj'</script>";
    break;

case '2':
?>
<?php
if (isset($mensagem)) {
?>
<div class="container"><?php include 'menu_interno_pj.php' ?>
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
                                        WHERE arq.idPessoa = '$idPj'
                                        AND list.idListaDocumento IN (39, 40, 41, 42, 43, 54)
                                        AND arq.idTipo = '$tipoPessoa'
                                        AND arq.publicado = '1'";
                        $query = mysqli_query($con, $sql);
                        $linhas = mysqli_num_rows($query);
                        $count = 0;
                        $negados = '';

                        while ($arquivo = mysqli_fetch_array($query)) {

                            $queryStatusDoc = "SELECT idStatusDocumento FROM upload_arquivo WHERE idUploadArquivo = '" . $arquivo['idUploadArquivo'] . "'";
                            $send = mysqli_query($con, $queryStatusDoc);
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
                                    $negados .= $arquivo['idListaDocumento'] . ", ";
                                    break;
                            }

                            echo "<tr>
                                <td class='list_description'>(" . $arquivo['documento'] . ")</td>
                                <td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>
                                <td class='list_description'>" . exibirDataBr($arquivo['dataEnvio']) . "</td>";

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
            <?php
            if ($negados != '') {
                $negados = substr($negados, 0, -2);
                ?>
                <div class="well">
                    <div class="form-group ">
                        <hr>
                        <div class="table-responsive list_info"><h6>Arquivo(s) Negado(s)</h6>
                            <?php
                            listaArquivosPessoa($idPj, $tipoPessoa, "includes/incentivador_adm_pj", $negados);
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            if ($apagados != '') {
                $apagados = substr($apagados, 0, -2);
                ?>
                <div class="well">
                <div class="form-group" id="uploadDocs">
                <hr>
                <div class="table-responsive list_info"><h6>Upload de Arquivo(s) Somente em PDF</h6>
                <form method="POST" action="?perfil=includes/documentos_fiscais_incentivador_pj"
                      enctype="multipart/form-data">
                <?php
                $documentos = [];
                $sql_arquivos = "SELECT * FROM lista_documento AS lista 
                                            INNER JOIN upload_arquivo AS uploads ON uploads.idListaDocumento = lista.idListaDocumento 
                                            WHERE uploads.idPessoa = $idPj 
                                            AND uploads.idStatusDocumento = 3 
                                            AND uploads.publicado = 0 
                                            AND lista.idListaDocumento IN (39, 40, 41, 42, 43, 54)";

                $query_arquivos = mysqli_query($con, $sql_arquivos);
                while ($arq = mysqli_fetch_array($query_arquivos)) {
                    $doc = $arq['documento'];
                    $query = "SELECT idListaDocumento FROM lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='3'";
                    $envio = $con->query($query);
                    $row = $envio->fetch_array(MYSQLI_ASSOC);

                    $documento = (object)
                    [
                        'nomeDocumento' => $arq['documento'],
                        'sigla' => $arq['sigla']
                    ];
                    array_push($documentos, $documento);

                }

                if ($documentos) {
                    ?>
                    <table class='table table-condensed table-striped'>
                        <tr class='list_menu'>
                            <td>Tipo de Arquivo</td>
                            <td></td>
                        </tr>
                        <?php
                        foreach ($documentos as $documento) {
                            echo "<tr>";
                            echo "<td class='list_description'><label>$documento->nomeDocumento</label></td>";
                            echo "<td class='list_description'><input type='file' name='arquivo[$documento->sigla]'></td>";
                            echo "<tr>";
                        }
                        ?>
                    </table>
                    <input type="hidden" name="idPessoa" value="<?php echo $idPj; ?>"/>
                    <input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"/>
                    <input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block"
                           value='upload'>

                    </form>
                    </div>
                    </div>
                    </div>
                    <?php
                }
            }
            ?>
    </div>
            <div class="tab-pane fade" id="resumo">
                <?php
                echo "<br><div class='alert alert-warning'>
                                <strong>Aviso!</strong> Seus dados já foram aceitos, portanto, não podem ser alterados.</div>";
                include 'resumo_dados_incentivador_pj.php';
                ?>
            </div>
    </div>
    </div>

    <?php
    break;
    }
    ?>


    <!-- Confirmação de Exclusão -->
    <div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h4 class="modal-title">Excluir Arquivo?</h4>
                </div>
                <div class="modal-body">
                    <p>Confirma?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirm">Remover</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim Confirmação de Exclusão -->

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
            }
        }
    </script>