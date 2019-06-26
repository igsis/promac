<?php
$con = bancoMysqli();
$idPf = $_SESSION['idUser'];
$tipoPessoa = '4';

if (isset($_POST['iniciar_incentivo'])) {
    $sqlEtapa = "INSERT INTO etapas_incentivo (tipoPessoa, idIncentivador, etapa) VALUES ($tipoPessoa, $idPf, 1)";
    if (mysqli_query($con, $sqlEtapa)) {
        $mensagemInicial = "<font color='#01DF3A'><strong>Você iniciou o processo de incentivar um projeto.<br>Por favor, siga as etapas seguintes preenchendo corretamente todas as informações solicitadas.</strong></font>";
    } else {
        echo $sqlEtapa;
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
    $sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE idUploadArquivo = '$idArquivo'";
    if (mysqli_query($con, $sql_apagar_arquivo)) {
        $mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
        gravarLog($sql_apagar_arquivo);
    } else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
    }
}

$pf = recuperaDados("incentivador_pessoa_fisica", "idPf", $idPf);

?>
<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'menu_interno_pf.php' ?>
        <ul class="nav nav-tabs">
            <li class="nav active"><a href="#admIncentivador" data-toggle="tab">Administrativo</a></li>
            <li class="nav"><a href="#resumo" data-toggle="tab">Resumo do projeto</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade" id="resumo">
                <?php
                echo "<br><div class='alert alert-warning'>
	                    <strong>Aviso!</strong> Seus dados já foram aceitos, portanto, não podem ser alterados.</div>";
                include 'resumo_dados_incentivador_pf.php';
                ?>
            </div>
        <div class="tab-pane fade in active" id="admIncentivador">


        <br>
        <h5><?php if (isset($mensagemInicial)) {
                echo $mensagemInicial;
            }; ?></h5>
        <div class="form-group">
            <h4>2 - Certidões de Regularidade Fiscal: <br>
                <small>(Para incentivar projetos do PROMAC, você deve estar em dia com suas obrigações fiscais).</small>
            </h4>
            <h5><?php if (isset($mensagem)) {
                    echo $mensagem;
                }; ?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <?php
                if ($pf['liberado'] >= 3)
                {
                ?>
                <!-- Exibir arquivos -->
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
                            <?php

                            $arqsEnviados = listaArquivosPessoa($idPf, $tipoPessoa, "includes/documentos_fiscais_incentivador_pf", "39, 40, 41, 42, 43, 54");
                            if ($arqsEnviados == 6) {
                                echo "
                                      <form method='POST' action='?perfil=includes/incentivadorPF_etapa3_visualiza_docs' enctype='multipart/form-data'>
                                      <input type='hidden' name='idPf' value='$idPf'>                                   
                                          <input type='submit' name='enviarSMC' class='btn btn-theme btn-lg btn-block'
                                               value='Enviar à SMC'>                                     
                                        
                                      </form>  ";
                            } else {

                            ?>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="uploadDocs">
                    <div class="col-md-12">
                        <div class="table-responsive list_info"><h6>Upload de Arquivo(s) Somente em PDF</h6>
                            <form method="POST" action="?perfil=includes/documentos_fiscais_incentivador_pf"
                                  enctype="multipart/form-data">
                                <?php
                                $documentos = [];
                                $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '3' AND idListaDocumento IN (39, 40, 41, 42, 43, 54)";
                                $query_arquivos = mysqli_query($con, $sql_arquivos);
                                while ($arq = mysqli_fetch_array($query_arquivos)) {
                                    $doc = $arq['documento'];
                                    $query = "SELECT idListaDocumento FROM lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='3'";
                                    $envio = $con->query($query);
                                    $row = $envio->fetch_array(MYSQLI_ASSOC);

                                    if (!verificaArquivosExistentesIncentivador($idPf, $row['idListaDocumento'])) {
                                        $documento = (object)
                                        [
                                            'nomeDocumento' => $arq['documento'],
                                            'sigla' => $arq['sigla']
                                        ];
                                        array_push($documentos, $documento);
                                    }
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
                                    <input type="hidden" name="idPessoa" value="<?php echo $idPf; ?>"/>
                                    <input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"/>
                                    <input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block"
                                           value='upload'>
                                    <?php
                                }
                            }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
                <!-- Fim Upload de arquivo -->

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
            </div>
        </div>
        <?php } ?>
    </div>
</section>


<script>
    function verificaResposta() {
        if ($('#nao').is(':checked')) {
            location.href = '?perfil=cadastro_incentivador_pf'
        } else if ($('#sim').is(':checked')) {
            //$('#aviso').css('display', 'none');
            location.href = '?perfil=includes/documentos_fiscais_incentivador_pf'
        }
    }
</script>
