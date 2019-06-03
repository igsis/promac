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


if (isset($_POST['enviarSMC'])) {
    $sqlLiberado = "UPDATE incentivador_pessoa_fisica SET liberado = 4 WHERE idPf = $idPf";
    $sqlEtapa = "UPDATE etapas_incentivo SET etapa = 2 WHERE idIncentivador = $idPf";

    if (mysqli_query($con, $sqlLiberado) && mysqli_query($con, $sqlEtapa)) {
        $mensagem = "<font color='#01DF3A'><strong>Suas certidões de regularidade fiscal foram enviadas à SMC!</strong></font>";
        gravarLog($sqlLiberado);
        gravarLog($sqlEtapa);
    }
}

if (isset($_POST["enviar"])) {
    $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '3' AND idListaDocumento IN (39, 40, 41, 42, 43, 54)";
    $query_arquivos = mysqli_query($con, $sql_arquivos);
    while ($arq = mysqli_fetch_array($query_arquivos)) {
        $y = $arq['idListaDocumento'];
        $x = $arq['sigla'];
        $nome_arquivo = isset($_FILES['arquivo']['name'][$x]) ? $_FILES['arquivo']['name'][$x] : null;
        $f_size = isset($_FILES['arquivo']['size'][$x]) ? $_FILES['arquivo']['size'][$x] : null;

        //Extensões permitidas
        $ext = array("PDF", "pdf");

        if ($f_size > 6242880) // 6MB em bytes
        {
            $mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 06 MB.</strong></font>";
        } else {
            if ($nome_arquivo != "") {
                $nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
                $new_name = date("YmdHis") . "_" . semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
                $hoje = date("Y-m-d H:i:s");
                $dir = '../uploadsdocs/'; //Diretório para uploads
                $allowedExts = array(".pdf", ".PDF"); //Extensões permitidas
                $ext = strtolower(substr($nome_arquivo, -4));

                if (in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas
                {
                    if (move_uploaded_file($nome_temporario, $dir . $new_name)) {
                        $sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipo`, `idPessoa`, `idListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPf', '$y', '$new_name', '$hoje', '1'); ";
                        $query = mysqli_query($con, $sql_insere_arquivo);

                        if ($query) {
                            $mensagem = "<font color='#01DF3A'><strong>Arquivo(s) recebido(s) com sucesso!</strong></font>";
                            gravarLog($sql_insere_arquivo);
                        } else {
                            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco.</strong></font>";
                        }
                    } else {
                        $mensagem = "<font color='#FF0000'><strong>Erro no upload! Tente novamente.</strong></font>";
                    }
                } else {
                    $mensagem = "<font color='#FF0000'><strong>Erro no upload! Anexar documentos somente no formato PDF.</strong></font>";
                }
            }
        }
    }
}


if (isset($_POST['apagar'])) {
    $idArquivo = $_POST['apagar'];
    $idListaDoc = $_POST['idListaDocumento'];
    $sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE idUploadArquivo = '$idArquivo'";
    if (mysqli_query($con, $sql_apagar_arquivo)) {
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
                                // location.href = '?perfil=includes/documentos_fiscais_incentivador_pf'
                            }
                        }
                    </script>