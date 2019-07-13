<?php
$con = bancoMysqli();
$idIncentivador = $_SESSION['idUser'];
$idIncentivadorProjeto = $_SESSION['idIncentivadorProjeto'];
$tipoPessoa = $_POST['tipoPessoa'] ?? $_GET['tipoPessoa'];

$incentivador_projeto = recuperaDados('incentivador_projeto', 'idIncentivadorProjeto', $idIncentivadorProjeto);

if (isset($_POST['idProjeto'])) {
    $idProjeto = $_POST['idProjeto'];

} else {
    $idProjeto = $incentivador_projeto['idProjeto'];
}

$etapa = $incentivador_projeto['etapa'];

if ($etapa == 8) {
    $etapa8 = 'block';
    $etapa7 = 'none';
} else {
    $etapa8 = 'none';
    $etapa7 = 'block';
}


if (isset($_POST['avancar_etapa7'])) {
    $sqlEtapa = "UPDATE incentivador_projeto SET etapa = 7 WHERE idIncentivadorProjeto = '$idIncentivadorProjeto'";
    mysqli_query($con, $sqlEtapa);
}

$printed = "<script> document.write(printed); </script>";

if (isset($printed)) {
    $sqlEtapa = "UPDATE etapas_incentivo SET etapa = 8 WHERE idIncentivadorProjeto = '$idIncentivadorProjeto'";
    mysqli_query($con, $sqlEtapa);
}

$arqAnexado = "none";
$enviarArqs = "block";

if (isset($_POST["enviar"])) {
    if (!verificaArquivosExistentesIncentivador($idIncentivador, 18)) {
        $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '3' AND idListaDocumento IN (18)";
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
        }
    } else {
        echo "<script> swal('Você já anexou uma carta de incentivo, aguarde pelas proximas etapas', '', 'warning') </script>";
    }
}

if (isset($_POST['apagar'])) {
    $idArquivo = $_POST['apagar'];
    $sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE idUploadArquivo = '$idArquivo'";
    if (mysqli_query($con, $sql_apagar_arquivo)) {
        $mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
        gravarLog($sql_apagar_arquivo);
        $etapa6 = 1;
    } else {
        $etapa6 = 0;
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
    }
}


if (verificaArquivosExistentesIncentivador($idIncentivador, 18)) {
    $uploadArq = 'none';
    $arqAnexado = 'block';
} else {
    $uploadArq = 'block';
    $arqAnexado = 'none';
}


?>

<style>
    .table > tbody > tr > td {
        vertical-align: middle;
    }

    .table > thead > tr > td {
        vertical-align: middle;
    }
</style>

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
                <?php
                if (isset($mensagem)) {
                    echo "<h5>" . $mensagem . "</h5>";
                }

                ?>
              
                <div id="etapa7" style="display: <?= $etapa7 ?>">
                    <h6><b>7 - Impressão do Contrato de Incentivo</b></h6>
                    <div class="well">
                        <strong style="color: red">ATENÇÃO</strong>
                        <p>Após a impressão desta carta de incentivo, você deve colher as assinaturas do proponente e
                            do incentivador (ou de seus respectivos responsáveis legais, em caso de pessoas jurídicas),
                            digitalizar a carta assinada em pdf e subir o arquivo aqui neste sistema, na próxima etapa.
                            Em
                            seguida, você deve
                            encaminhar a Carta de Intenção ORIGINAL para a Secretaria Municipal de Cultura – PROMAC,
                            pessoalmente, via portador ou Correios, no seguinte endereço: Rua Líbero Badaró, 346 – 3º
                            andar
                            –
                            PROMAC. Recebimento das 9h às 17h.</p>

                        <hr width="50%">

                        <div class="row">
                            <form action="../pdf/pdf_incentivar_projeto.php" method="post" class="form-group">
                                <div class='col-md-12'>
                                    <button type="button" onclick="loadOtherPage()"
                                            class="btn btn-theme">CLIQUE AQUI PARA GERAR PDF DA CARTA DE
                                        INCENTIVO PREENCHIDA PARA IMPRESSÃO <!-- href='< ?php echo "../pdf/pdf_incentivar_projeto.php?tipoPessoa=$tipoPessoa&idPessoa=$idIncentivador&idProjeto=$idProjeto"; ?>'
                                   target='_blank' --></button>
                                    <br/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="etapa8" style="display: <?= $etapa8 ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-offset-2 col-md-8 text-center">
                                <h6><b>8 - Upload do Contrato de Incentivo assinada</b></h6>
                            </div>
                            <div class="col-md-2">
                                <form action="../pdf/pdf_incentivar_projeto.php" method="post" class="form-group">
                                    <button type="button" onclick="loadOtherPage()" class="btn btn-theme"
                                            style="margin-top: 5px;"><span class="glyphicon glyphicon-download"></span> </button>
                                    <br/>
                                </form>
                            </div>

                        </div>

                    </div>
                    <div class="well">
                        <strong style="color: red">ATENÇÃO</strong>
                        <p>Neste campo, é permitido o envio de apenas 1 arquivo em PDF de tamanho máximo de XMB.
                            Certifique-se de que a Carta de Incentivo está assinada pelo Proponente e pelo Incentivador,
                            ou pelos responsáveis legais pelos CNPJs, em caso de Pessoas Jurídicas. Em caso de
                            utilização de ISS e IPTU para incentivo do mesmo projeto,
                            favor juntar os dois Contratos de Incentivo em um único pdf, através do site <a
                                    href="https://www.ilovepdf.com/pt" target="_blank">I love pdf</a>. </p>

                    </div>

                    <hr width="50%">
                    <div class="row">
                        <div class="form-group" id="uploadDocs" style="display: <?= $uploadArq ?>">
                            <div class="col-md-offset-2 col-md-8">
                                <div class="table-responsive list_info"><h6>Upload do Contrato de Incentivo assinado</h6>
                                    <form method="POST" action="?perfil=includes/incentivador_etapa7_gerarContrato"
                                          enctype="multipart/form-data">
                                        <?php
                                        $documentos = [];
                                        $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '3' AND idListaDocumento IN (18)";
                                        $query_arquivos = mysqli_query($con, $sql_arquivos);
                                        while ($arq = mysqli_fetch_array($query_arquivos)) {
                                            $doc = $arq['documento'];
                                            $query = "SELECT idListaDocumento FROM lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='3'";
                                            $envio = $con->query($query);
                                            $row = $envio->fetch_array(MYSQLI_ASSOC);

                                            if (!verificaArquivosExistentesIncentivador($idPf, $row['idListaDocumento'], 3)) {
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
                                                    echo "<td class='list_description'><label>Carta de Intenção de Incentivo</label></td>";
                                                    echo "<td class='list_description'><input type='file' name='arquivo[$documento->sigla]'></td>";
                                                    echo "<tr>";
                                                }
                                                ?>
                                            </table>
                                            <input type="hidden" name="idPessoa" value="<?php echo $idPf; ?>"/>
                                            <input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"/>
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
                                        AND list.idListaDocumento IN (18)
                                        AND arq.idTipo = '3'
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
                                                $etapa6 = 1;
                                                break;
                                        }

                                        echo "<tr>
                                                <td class='list_description'>(Carta de Intenção de Incentivo)</td>
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
                                                    <form id='apagarArq' method='POST' action='?perfil=includes/incentivador_etapa7_gerarContrato'>
                                                        <input type='hidden' name='idPessoa' value='$idIncentivador' />
                                                        <input type='hidden' name='tipoPessoa' value='" . $tipoPessoa . "' />
                                                        <input type='hidden' name='apagar' value='" . $arquivo['idUploadArquivo'] . "' />
                                                        <input type='hidden' name='idListaDocumento' value='" . $arquivo['idListaDocumento'] . "' />
                                                        <button class='btn btn-theme' style='margin-top: 11px;' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Remover Arquivo?' data-message='Deseja realmente excluir o arquivo Carta de Intenção de Incentivo?'>Remover
                                                        </button>
                                                    </form></td>";
                                    }

                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- Fim do exibir arquivo -->
                        </div>
                        <div style="display: none;" id="buttonEtapa6">
                            <a href='?perfil=includes/incentivador_etapa6_incentivarProjeto&tipoPessoa=<?=$tipoPessoa?>&retornando=etapa6'>
                                <button class='btn btn-warning'> <span class="glyphicon glyphicon-arrow-left"></span>&nbsp; Retornar ao item 6.</button></a>
                        </div>
                    </div>
                </div>
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
    let envioArq = "<?=$arqAnexado?>";

    function loadOtherPage() {
        let idProjeto = "<?=$idProjeto?>";
        let tipoPessoa = "<?=$tipoPessoa?>";
        let idIncentivador = "<?=$idIncentivador?>";

        console.log("idProjeto" + idProjeto);

        let link = "../pdf/pdf_incentivar_projeto.php?tipoPessoa=" + tipoPessoa + "&idPessoa=" + idIncentivador + "&idProjeto=" + idProjeto + "";

        $("<iframe>")                             // create a new iframe element
            .hide()                               // make it invisible
            .attr("src", link) // point the iframe to the page you want to print
            .appendTo("body");                    // add iframe to the DOM to cause it to load the page

        let printed = 1;

        if (printed == 1 || envioArq == 'block') {
            $('#etapa8').show();
            $('#etapa7').hide();
        }
    };


</script>

<script>
    let etapa6 = "<?=$etapa6?>";

    if (etapa6 == 1) {
        $('#buttonEtapa6').slideDown();
    }
</script>