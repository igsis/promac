<?php
$con = bancoMysqli();
$idIncentivador = $_SESSION['idUser'];
$idIncentivadorProjeto = $_SESSION['idIncentivadorProjeto'];
$tipoPessoa = $_POST['tipoPessoa'] ?? $_GET['tipoPessoa'];

if (isset($_POST['idProjeto'])) {
    $idProjeto = $_POST['idProjeto'];

} else {
    $sqlProject = "SELECT idProjeto FROM incentivador_projeto WHERE idIncentivadorProjeto = '$idIncentivadorProjeto' AND (etapa = 9 || etapa = 10 || etapa = 11)";
    $queryProject = mysqli_query($con, $sqlProject);
    $arr = mysqli_fetch_assoc($queryProject);
    $idProjeto = $arr['idProjeto'];
}

$sqlIP = "SELECT * FROM incentivador_projeto WHERE idIncentivadorProjeto = '$idIncentivadorProjeto'";
$queryIP = mysqli_query($con, $sqlIP);
$infos = mysqli_fetch_assoc($queryIP);
$data_recebimento = new DateTime($infos['data_recebimento_carta']);


$sqlUltimaParcela = "SELECT * FROM parcelas_incentivo WHERE idIncentivadorProjeto = '$idIncentivadorProjeto' ORDER BY 'numero_parcela' ASC LIMIT 1";
$queryUltima = mysqli_query($con, $sqlUltimaParcela);
$parcelas = mysqli_fetch_assoc($queryUltima);
$data_pagamento = new DateTime($parcelas['data_pagamento']);

//echo $sqlUltimaParcela;

$intervalo = $data_pagamento->diff($data_recebimento);

if ($intervalo->days < 15) {
    /* $sqlEtapa = "UPDATE etapas_incentivo SET etapa = 6 WHERE idProjeto = '$idProjeto' AND idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa'";
     $sqlCarta = "UPDATE upload_arquivo SET idStatusDocumento = NULL WHERE idListaDocumento = 18 and idTipo = '$tipoPessoa' AND idPessoa = '$idIncentivador'";*/
    $mensagem = "<div style='color: red'>
                        <strong>PRAZO EXCEDIDO!</strong><br>
                        O recebimento da Carta de Incentivo original na SMC deve ocorrer antes de 15 dias do vencimento do tributo a ser utilizado para incentivo do projeto cultural. 
                        <br>Exigimos esse prazo para que a Secretaria possa executar o procedimento necessário para o abatimento do tributo. <hr width='30%'>
                        <a href='?perfil=includes/incentivador_etapa6_incentivarProjeto&tipoPessoa=$tipoPessoa&retornando=etapa6'>
                        <button class='btn btn-danger'>Por favor, retorne ao item 6 e preencha novamente a Carta de Incentivo com a data atualizada e repita os passos seguintes.</button></a>
                    </div>";

    $prazoExcedido = 1;

} else {

    $sqlEtapa = "UPDATE incentivador_projeto SET etapa = 10 WHERE idProjeto = '$idProjeto' AND idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa'";
    if (mysqli_query($con, $sqlEtapa)) {
        $mensagem = "<div class='text-success'>
                    <strong>Certo!</strong><br>
                    Como recebemos a Carta de Incentivo original com mais de 15 dias de antecedência para o vencimento do tributo da 1ª parcela do aporte, podemos prosseguir com o procedimento de incentivo.
                </div>";
    }
}

if (isset($_POST["enviar"])) {
    $parcelaAtual = $_POST['parcelaSolicitar'];
    $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '3' AND idListaDocumento IN (55,56)";
    $query_arquivos = mysqli_query($con, $sql_arquivos);
    while ($arq = mysqli_fetch_array($query_arquivos)) {
        if (!verificaArquivosExistentesIncentivador($idIncentivador, $arq['idListaDocumento'])) {
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
                                if ($y == 55) {
                                    $sqlUpdateParcelas = "UPDATE parcelas_incentivo SET comprovante_deposito = 0 WHERE idProjeto = '$idProjeto' AND idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa' AND numero_parcela = $parcelaAtual";
                                    mysqli_query($con, $sqlUpdateParcelas);
                                } else {
                                    $sqlUpdateParcelas = "UPDATE parcelas_incentivo SET extrato_conta_projeto = 0 WHERE idProjeto = '$idProjeto' AND idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa' AND numero_parcela = $parcelaAtual";
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
    $sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE idUploadArquivo = '$idArquivo'";
    if (mysqli_query($con, $sql_apagar_arquivo)) {
        $idListaDoc = $_POST['idListaDocumento'];
        if ($idListaDoc == 55) {
            $doc = "comprovante_deposito";
        } else {
            $doc = "extrato_conta_projeto";
        }
        $sqlParcela = "UPDATE parcelas_incentivo SET $doc = NULL WHERE idProjeto = '$idProjeto' AND idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa' AND numero_parcela = $parcelaAtual";
        $mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
        gravarLog($sql_apagar_arquivo);
    } else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
    }
}

$etapa11 = "none";


if (verificaArquivosExistentesIncentivador($idIncentivador, 55) && verificaArquivosExistentesIncentivador($idIncentivador, 56)) {
    $uploadArq = 'none';
    $arqAnexado = 'block';
    $etapa11 = 'block';
    $sqlEtapa = "UPDATE etapas_incentivo SET etapa = 11 WHERE idProjeto = '$idProjeto' AND idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa'";
    /*$sqlUpdateParcelas = "UPDATE parcelas_incentivo SET comprovante_deposito = 0, extrato_conta_projeto = 0 WHERE idProjeto = '$idProjeto' AND idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa' AND numero_parcela = $parcelaAtual";*/

    if (mysqli_query($con, $sqlEtapa)) {
        $mensagem = '';

    }

} elseif (verificaArquivosExistentesIncentivador($idIncentivador, 55) || verificaArquivosExistentesIncentivador($idIncentivador, 56)) {
    $uploadArq = 'block';
    $arqAnexado = 'block';
    $etapa11 = 'block';
} else {
    $uploadArq = 'block';
    $arqAnexado = 'none';
}


$sqlEtapa = "SELECT etapa FROM incentivador_projeto WHERE idIncentivadorProjeto = '$idIncentivadorProjeto'";
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
                    $projeto = recuperaDados('projeto', 'idProjeto', $idProjeto);
                    $nomeProjeto = $projeto['nomeProjeto'];
                        echo "<h4 class='text-info'>Voce esta incentivando o projeto: $nomeProjeto</h4>";

                    ?>
                </div>
                <hr width="50%">
                <div class="row" id="etapa10">
                    <div class="col-md-12">
                        <h6><b>10 - Solicite a autorização de depósito</b></h6>
                        <div class="col-md-offset-2 col-md-8 form-group">
                            <table class="table bg-white text-center table-hover table-responsive table-condensed table-bordered table-parcelas">
                                <thead class="bg-success">
                                <tr class="list_menu" style="font-weight: bold;">
                                    <td width="5%">Parcela</td>
                                    <td width="15%">Data</td>
                                    <td width="15">Valor</td>
                                    <td width="60%">Ação</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                //verificando parcelas
                                $sqlParcelas = "SELECT * FROM parcelas_incentivo WHERE idProjeto = '$idProjeto' AND tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador'";
                                $queryParcelas = mysqli_query($con, $sqlParcelas);
                                $numRows = mysqli_num_rows($queryParcelas);
                                $i = 1;
                                $x = 1;
                                while ($parcela = mysqli_fetch_array($queryParcelas)) {
                                ?>
                                <tr style="height: 45px;" id="linhasTabela">
                                    <td style="vertical-align: middle;"
                                        class="list_description"><?= $parcela['numero_parcela'] ?></td>
                                    <td style="vertical-align: middle;"
                                        class="list_description"><?= exibirDataBr($parcela['data_pagamento']) ?></td>
                                    <td style="vertical-align: middle;"
                                        class="list_description">R$ <?= dinheiroParaBr($parcela['valor']) ?></td>
                                    <?php
                                    if ($parcela['comprovante_deposito'] == '' && $parcela['extrato_conta_projeto'] == '' && $x == 1){
                                        $botaoSolicitar = "<button class='btn' style='background-color: white; color: green;'
                                                                onmouseover=\"$(this).css('background-color', '#f5f5f5'); $(this).css('font-style', 'italic')\"
                                                                onmouseout=\"$(this).css('background-color', 'white'); $(this).css('font-style', '')\"
                                                                onclick=\"mostrarDiv('etapa11')\">
                                                                <span class='glyphicon glyphicon-arrow-left'
                                                                      style='font-size: 13px;'></span>
                                                            &nbsp;Solicitar autorização de depósito desta parcela
                                                        </button>";
                                        $parcelaSolicitar = $i;
                                        $x = 0;
                                    } elseif ($parcela['comprovante_deposito'] == 0 && $parcela['extrato_conta_projeto'] == 0 && $x == 1) {
                                        $botaoSolicitar = "<b class='text-warning'><i>Autorização de depósito da parcela solicitada. <br>
                                                                <span class='glyphicon glyphicon-info-sign text-warning' style='margin-left: 30px;font-size: 17px; float: left;  margin-top: -8px;'></span> </i><i style='margin-left: -50px;'> 
                                                              Acompanhe a análise da SMC pelo sistema. </i></b>";
                                        $parcelaSolicitar = $i;
                                        $x = 0;
                                    }
                                    if ($parcelaSolicitar == $i):
                                        ?>
                                        <td style="border: none; vertical-align: middle;" class="list_description">
                                            <?= $botaoSolicitar ?>
                                        </td>
                                        </tr>
                                    <?php
                                    else:
                                        echo "<td style='border: none;'></td>";
                                    endif;
                                    $i++;
                                }
                                ?>

                                </tbody>
                            </table>
                        </div>
                        <br>
                        <!--<div class="col-md-2 pull-left">
                            < ?/*= $botaoSolicitar */?>
                        </div>-->
                    </div>
                </div>
                <div class="row" id="etapa11" style="display: <?= $etapa11 ?>">
                    <h6><b>11- Faça o upload dos documentos que comprovam que o aporte foi realizado na conta do
                            projeto: </b></h6><br>
                    <div class="form-group" id="uploadDocs" style="display: <?= $uploadArq ?>">
                        <div class="col-md-offset-1 col-md-10">
                            <div class="table-responsive list_info">
                                <h6>Upload do comprovante de depósito e extrato da conta</h6>
                                <form method="POST" action="?perfil=includes/incentivador_etapa9_verificaData"
                                      enctype="multipart/form-data">
                                    <?php
                                    $documentos = [];
                                    $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '3' AND idListaDocumento IN (55, 56)";
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
                                                echo "<td class='list_description'><input type='file' name='arquivo[$documento->sigla]'></td>";
                                                echo "<tr>";
                                            }
                                            ?>
                                        </table>
                                        <input type="hidden" name="idPessoa" value="<?php echo $idPf; ?>"/>
                                        <input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"/>
                                        <input type="hidden" name="parcelaSolicitar" value="<?php echo $parcelaSolicitar; ?>"/>
                                        <input type="submit" name="enviar" class="btn btn-theme"
                                               value='upload'>
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
                                        WHERE arq.idPessoa = '$idIncentivador'
                                        AND list.idListaDocumento IN (55,56)
                                        AND arq.idTipo = '$tipoPessoa'
                                        AND arq.publicado = '1'";
                                $query = mysqli_query($con, $sql);
                                $linhas = mysqli_num_rows($query);

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
                                                    <form id='apagarArq' method='POST' action='?perfil=includes/incentivador_etapa9_verificaData'>
                                                        <input type='hidden' name='idPessoa' value='$idIncentivador' />
                                                        <input type='hidden' name='tipoPessoa' value='" . $tipoPessoa . "' />
                                                        <input type='hidden' name='apagar' value='" . $arquivo['idUploadArquivo'] . "' />
                                                        <input type='hidden' name='idListaDocumento' value='" . $arquivo['idListaDocumento'] . "' />
                                                        <button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Remover Arquivo?' data-message='Deseja realmente excluir o arquivo " . $arquivo['documento'] . "?'>Remover
                                                        </button>
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


<script>
    function mostrarDiv(divId) {
        if ($('#' + divId).is(':visible')) {
            $('#' + divId).hide();
            $('.table-parcelas').find('tr').each(function () {
                $(this).show();
            });
            // $('#icon_' + divId).html("<span class='glyphicon glyphicon-chevron-right'></span>");
        } else {
            $('#' + divId).show();
            var count = 0;
            $('.table-parcelas').find('tr').each(function () {
                count++;
                if (count > 2) {
                    $(this).hide();
                }
            });
            // $('#icon_' + divId).html("<span class='glyphicon glyphicon-chevron-down'></span>");
        }
    }
</script>

<script>

    let prazo = "<?=$prazoExcedido?>";

    if (prazo == 1) {
        $('#etapa10').hide();
    }
</script>