<?php
$con = bancoMysqli();
$idIncentivador = $_SESSION['idUser'];
$idIncentivadorProjeto = $_SESSION['idIncentivadorProjeto'];
$tipoPessoa = $_POST['tipoPessoa'] ?? $_GET['tipoPessoa'];


if (isset($_POST['avancar_etapa12'])) {
    $sqlEtapa = "UPDATE incentivador_projeto SET etapa = 12 WHERE idIncentivadorProjeto = '$idIncentivadorProjeto'";
    mysqli_query($con, $sqlEtapa);
}


if (isset($_POST['idProjeto'])) {
    $idProjeto = $_POST['idProjeto'];

} else {
    $sqlProject = "SELECT idProjeto FROM incentivador_projeto WHERE idIncentivadorProjeto = '$idIncentivadorProjeto' AND (etapa = 12)";
    $queryProject = mysqli_query($con, $sqlProject);
    $arr = mysqli_fetch_assoc($queryProject);
    $idProjeto = $arr['idProjeto'];
}

if (isset($_POST['editarValorDAMSP'])) {
    $valorDAM = dinheiroDeBr($_POST['valor_DAMSP']);
    $sqlUp = "UPDATE incentivador_projeto SET valor_damsp = '$valorDAM' WHERE idIncentivadorProjeto = '$idIncentivadorProjeto'";

    if (mysqli_query($con, $sqlUp)) {
        $mensagem = "<font color='#01DF3A'><strong>Valor atualizado com sucesso!</strong></font>";
    } else {
        echo "erro : " . $sqlUp;
    }
}



if (isset($_POST["enviar"])) {
    $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '3' AND idListaDocumento IN (57)";
    $query_arquivos = mysqli_query($con, $sql_arquivos);
    while ($arq = mysqli_fetch_array($query_arquivos)) {
        if (!verificaArquivosExistentesIncentivador($idIncentivadorProjeto, $arq['idListaDocumento'])) {
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
                            $sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipo`, `idPessoa`, `idListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('3', '$idIncentivadorProjeto', '$y', '$new_name', '$hoje', '1'); ";
                            $query = mysqli_query($con, $sql_insere_arquivo);
                            if ($query) {
                                $idUploadDoc = recuperaUltimo('upload_arquivo');
                                $today = date('Y-m-d');
                                if ($y == 55) {
                                    $sqlUpdateParcelas = "UPDATE parcelas_incentivo SET comprovante_deposito = $idUploadDoc, data_solicitacao_autorizacao = '$today', status_solicitacao = 0 WHERE idIncentivadorProjeto = '$idIncentivadorProjeto' AND numero_parcela = $parcelaAtual";
                                    mysqli_query($con, $sqlUpdateParcelas);
                                } else {
                                    $sqlUpdateParcelas = "UPDATE parcelas_incentivo SET extrato_conta_projeto = $idUploadDoc, data_solicitacao_autorizacao = '$today', status_solicitacao = 0 WHERE idIncentivadorProjeto = '$idIncentivadorProjeto' AND numero_parcela = $parcelaAtual";
                                    mysqli_query($con, $sqlUpdateParcelas);
                                }
                                $mensagem = "<font color='#01DF3A'><strong>Arquivo(s) recebido(s) com sucesso!</strong></font>";
                                gravarLog($sql_insere_arquivo);
                                $arqAnexado = "block";
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
        } else {
            echo "<script> swal('Você já anexou o " . $arq['documento'] . "', '', 'warning') </script>";
        }
    }
}

if (isset($_POST['apagar'])) {
    $idArquivo = $_POST['apagar'];
    $parcelaAtual = $_POST['parcelaAtual'];
    $sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE idUploadArquivo = '$idArquivo'";
    if (mysqli_query($con, $sql_apagar_arquivo)) {
        $idListaDoc = $_POST['idListaDocumento'];
        if ($idListaDoc == 55) {
            $doc = "comprovante_deposito";
        } else {
            $doc = "extrato_conta_projeto";
        }
        $sqlParcela = "UPDATE parcelas_incentivo SET $doc = NULL WHERE idIncentivadorProjeto = '$idIncentivadorProjeto' AND numero_parcela = $parcelaAtual";
        mysqli_query($con, $sqlParcela);
        $mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
        gravarLog($sql_apagar_arquivo);
    } else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
    }
}

$sqlConsultaArqs = "SELECT * FROM upload_arquivo WHERE idPessoa = '$idIncentivadorProjeto' AND idListaDocumento IN (57) AND publicado = '1'";
$queryConsulta = mysqli_query($con, $sqlConsultaArqs);
$numArqs = mysqli_num_rows($queryConsulta);

if ($numArqs > 0) {
    $mensagem = '';
    while ($arqs = mysqli_fetch_array($queryConsulta)) {
        if ($arqs['idStatusDocumento'] == '' || $arqs['idStatusDocumento'] == 3) {
            $sqlEtapa = "UPDATE incentivador_projeto SET etapa = 12 WHERE idIncentivadorProjeto = '$idIncentivadorProjeto'";
            if (mysqli_query($con, $sqlEtapa)) {
                $uploadArq = 'none';
                $arqAnexado = 'block';
                $etapa11 = 'block';
            }
        }
    }



} else {
    $uploadArq = 'block';
    $arqAnexado = 'none';
}

$incentivadorProjeto = recuperaDados("incentivador_projeto", 'idIncentivadorProjeto', $idIncentivadorProjeto);
$etapa = $incentivadorProjeto['etapa'];

$valorDAM = $incentivadorProjeto['valor_damsp'] != '' ? dinheiroParaBr($incentivadorProjeto['valor_damsp']) : '';

?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include "menu_interno_pf.php"; ?>
        <ul class="nav nav-tabs">
            <li class="nav active"><a href="#admIncentivador" data-toggle="tab">Administrativo</a></li>
            <li class="nav"><a href="#resumo" data-toggle="tab">Resumo do cadastro</a></li>
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
                    $projeto = recuperaDados('projeto', 'idProjeto', $idProjeto);
                    $nomeProjeto = $projeto['nomeProjeto'];
                    echo "<h4 class='text-info'>Você está incentivando o projeto: $nomeProjeto</h4>";

                    ?>
                </div>
                <hr width="50%">

                <div class="row" id="etapa12" style="display: <?= $etapa11 ?>">
                    <h6><b>12 - Insira a sua DAMSP/Guia de IPTU: </b></h6>
                    <form method="POST" action="?perfil=includes/incentivador_etapa12_DAMSP" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-3 text-center" style="margin-left: 37%;">
                            <label for="valorDAMSP">a) Qual o valor total da sua DAMSP?
                                <div class="input-group">
                                    <input type="text" name="valor_DAMSP"
                                           onkeypress="return(moeda(this, '.', ',', event))"
                                           class="form-control" placeholder="Ex.: R$ 100.000,00" value="<?= $valorDAM ?? ''?>">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default" name="editarValorDAMSP"
                                                style="font-size: 20px">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </button>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                        <br>
                    <div class="form-group" id="uploadDocs" style="display: <?= $uploadArq ?>">
                        <div class="col-md-7 text-center" style="margin-left: 20%;">
                            <div class="table-responsive list_info">
                                <h6>Upload de arquivos</h6>
                                    <?php
                                    $documentos = [];
                                    $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '3' AND idListaDocumento IN (57)";
                                    $query_arquivos = mysqli_query($con, $sql_arquivos);
                                    while ($arq = mysqli_fetch_array($query_arquivos)) {
                                        $doc = $arq['documento'];
                                        $query = "SELECT idListaDocumento FROM lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='3'";
                                        $envio = $con->query($query);
                                        $row = $envio->fetch_array(MYSQLI_ASSOC);

                                        $idDoc = $row['idListaDocumento'];

                                        $sqlVerifica = "SELECT * FROM upload_arquivo WHERE idPessoa = '$idIncentivadorProjeto' AND idListaDocumento = $idDoc AND publicado = '1' AND (idStatusDocumento IS NULL OR idStatusDocumento = 3)";
                                        $queryVerifica = mysqli_query($con, $sqlVerifica);
                                        $num = mysqli_num_rows($queryVerifica);

                                        if ($num == 0) {
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
                                        <table class='table table-condensed table-striped text-center'>
                                            <thead class="bg-success">
                                            <tr class='list_menu'>
                                                <td>Tipo de Arquivo</td>
                                                <td></td>
                                            </tr>
                                            </thead>

                                            <?php
                                            foreach ($documentos as $documento) {
                                                echo "<tr>";
                                                echo "<td class='list_description'><label>" . $documento->nomeDocumento . "</label></td>";
                                                echo "<td class='list_description pull-right'><input type='file' name='arquivo[$documento->sigla]'></td>";
                                                echo "<tr>";
                                            }
                                            ?>
                                        </table>
                                        <input type="hidden" name="idPessoa" value="<?php echo $idPf; ?>"/>
                                        <input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"/>
                                        <input type="submit" name="enviar" class="btn btn-theme" value='upload'>
                                        <?php
                                    } else {
                                        $arqAnexado = 'block';
                                    }
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Exibir arquivos -->
                    <div class="form-group" style="display: <?= $arqAnexado ?>">
                        <div class="col-md-12">
                            <table class='table table-responsive table-condensed table-striped text-center table-bordered'>
                                <thead class="bg-success">
                                <tr class='list_menu' style="font-weight: bold; height: 50px;">
                                    <td>Tipo de arquivo</td>
                                    <td>Nome do arquivo</td>
                                    <td width="15%">Data do envio</td>
                                    <td width='13%'>Status</td>
                                    <td width='20%'>Observação</td>
                                    <td></td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = "SELECT *
                                        FROM lista_documento as list
                                        INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
                                        WHERE arq.idPessoa = '$idIncentivadorProjeto'
                                        AND list.idListaDocumento IN (57)
                                        AND arq.idTipo = '3'
                                        AND arq.publicado = '1'";
                                $query = mysqli_query($con, $sql);
                                $linhas = mysqli_num_rows($query);

                                //echo $sql;

                                while ($arquivo = mysqli_fetch_array($query)) {
                                    $queryStatusDoc = "SELECT idStatusDocumento FROM upload_arquivo WHERE idUploadArquivo = '" . $arquivo['idUploadArquivo'] . "'";
                                    $send = mysqli_query($con, $queryStatusDoc);
                                    $row = mysqli_fetch_array($send);

                                    $idStatus = $row['idStatusDocumento']; // == '' ? 'Em análise' : $row['idStatusDocumento'];

                                    $btnRemover = "<button class='btn btn-danger' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Remover Arquivo?' data-message='Deseja realmente excluir o arquivo " . $arquivo['documento'] . "?'>Remover
                                                        </button>";

                                    switch ($idStatus) {
                                        case '':
                                            $status = "Em análise";
                                            $cor = "orange";
                                            $btnRemover = "<button class='text-center' type='button' style='background: gray'><span style='font-size: 17px; color: #ec971f  ' class='glyphicon glyphicon-question-sign'></span>&nbsp;&nbsp;<b style='color: white'>Aguarde</b></button>";
                                            break;
                                        case 1:
                                            $status = "Aceito";
                                            $cor = "green";
                                            $btnRemover = "<button class='text-center' type='button' style='background: gray'><span style='font-size: 17px; color: #01DF3A' class='glyphicon glyphicon-ok'></span>&nbsp;&nbsp;<b style='color: white'>Aceito</b></button>";
                                            break;
                                        case 3:
                                            $status = "Negado";
                                            $cor = "red";
                                            break;
                                    }

                                    echo "<tr>
                                                <td class='list_description'>(" . $arquivo['documento'] . ")</td>
                                                <td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>
                                                <td class='list_description'>" . exibirDataBr($arquivo['dataEnvio']) . "</td>";

                                    echo "<td class='list_description text-center'>                                   
                                                    <input class='form-control text-center' style='color: $cor; width: 100px; margin-left: 18px;' type='text' value='$status' disabled>
                                                </td>";
                                    echo "<td class='list_description text-center'>                                   
                                                    <input class='form-control text-center' type='text' value='" . $arquivo['observacoes'] . "' disabled>
                                                </td>";
                                    $queryOBS = "SELECT observacoes FROM upload_arquivo WHERE idUploadArquivo = '" . $arquivo['idUploadArquivo'] . "'";
                                    $send = mysqli_query($con, $queryOBS);
                                    $row = mysqli_fetch_array($send);
                                    echo "
                                                <td class='list_description'>
                                                    <form id='apagarArq' method='POST' action='?perfil=includes/incentivador_etapa12_DAMSP'>
                                                        <input type='hidden' name='idPessoa' value='$idIncentivador' />
                                                        <input type='hidden' name='tipoPessoa' value='" . $tipoPessoa . "' />
                                                        <input type='hidden' name='apagar' value='" . $arquivo['idUploadArquivo'] . "' />
                                                        <input type='hidden' name='idListaDocumento' value='" . $arquivo['idListaDocumento'] . "' />
                                                        $btnRemover
                                                    </form></td>";
                                }

                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Fim do exibir arquivo -->
                </div>
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
    </div>
</section>