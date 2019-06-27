<?php
$con = bancoMysqli();
$idIncentivador = $_SESSION['idUser'];
$tipoPessoa = $_POST['tipoPessoa'] ?? $_GET['tipoPessoa'];


if (isset($_POST['idProjeto'])) {
    $idProjeto = $_POST['idProjeto'];
} else {
    $sqlProject = "SELECT idProjeto FROM etapas_incentivo WHERE tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador' AND etapa = 7";
    $queryProject = mysqli_query($con, $sqlProject);
    $arr = mysqli_fetch_assoc($queryProject);
    $idProjeto = $arr['idProjeto'];
}

if (isset($_POST['avancar_etapa7'])) {
    $sqlEtapa = "UPDATE etapas_incentivo SET etapa = 7 WHERE idProjeto = '$idProjeto' AND tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador'";
    mysqli_query($con, $sqlEtapa);

}

$envioArq = "none";

if (isset($_POST["enviar"])) {
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
                            $envioArq = "block";
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
                <?php
                if (isset($mensagem)) {
                    echo "<h5>" . $mensagem . "</h5>";
                }

                ?>
                <div id="etapa7">
                    <h6><b>7 - Impressão do Contrato de Incentivo</b></h6>
                    <div class="well">
                        <strong style="color: red">ATENÇÃO</strong>
                        <p>Após a impressão desta carta de incentivo, você deve colher as assinaturas do proponente e
                            do incentivador (ou de seus respectivos responsáveis legais, em caso de pessoas jurídicas),
                            digitalizar a carta assinada em pdf e subir o arquivo aqui neste sistema, na próxima etapa. Em
                            seguida, você deve
                            encaminhar a Carta de Intenção ORIGINAL para a Secretaria Municipal de Cultura – PROMAC,
                            pessoalmente, via portador ou Correios, no seguinte endereço: Rua Líbero Badaró, 346 – 3º andar
                            –
                            PROMAC. Recebimento das 9h às 17h.</p>

                        <hr width="50%">

                        <div class="row">
                            <form action="../pdf/pdf_incentivar_projeto.php" method="post" class="form-group">
                                <div class='col-md-12'>
                                    <button type="button" onclick="loadOtherPage()"
                                            class="btn btn-theme">CLIQUE AQUI PARA GERAR PDF DA CARTA DE
                                        INCENTIVO PREENCHIDA PARA IMPRESSÃO <!-- href='< ?php echo "../pdf/pdf_incentivar_projeto.php?tipoPessoa=$tipoPessoa&idPessoa=$idIncentivador&idProjeto=$idProjeto"; ?>'
                                   target='_blank' --></button><br/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="etapa8" style="display: none">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-offset-2 col-md-8 text-center">
                                <h6><b>8 - Upload do Contrato de Incentivo assinada</b></h6>
                            </div>
                            <div class="col-md-2">
                                <form action="../pdf/pdf_incentivar_projeto.php" method="post" class="form-group">
                                    <button type="button" onclick="loadOtherPage()" class="btn btn-theme" style="margin-top: 5px;"><span class="glyphicon glyphicon-download"></span> <!-- href='< ?php echo "../pdf/pdf_incentivar_projeto.php?tipoPessoa=$tipoPessoa&idPessoa=$idIncentivador&idProjeto=$idProjeto"; ?>'
                               target='_blank' --></button><br/>
                                </form>
                            </div>

                        </div>

                    </div>
                    <div class="well">
                        <strong style="color: red">ATENÇÃO</strong>
                        <p>Neste campo, é permitido o envio de apenas 1 arquivo em PDF de tamanho máximo de XMB.
                            Certifique-se de que a Carta de Incentivo está assinada pelo Proponente e pelo Incentivador,
                            ou pelos responsáveis legais pelos CNPJs, em caso de Pessoas Jurídicas. Em caso de utilização de ISS e IPTU para incentivo do mesmo projeto,
                            favor juntar os dois Contratos de Incentivo em um único pdf, através do site <a href="https://www.ilovepdf.com/pt" target="_blank">I love pdf</a>. </p>

                    </div>

                    <hr width="50%">

                        <div class="row">
                            <div class="form-group" id="uploadDocs">
                                <div class="col-md-offset-2 col-md-8">
                                    <div class="table-responsive list_info"><h6>Upload da Contrato de Incentivo assinada</h6>
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
                                            }
                                            ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Exibir arquivos -->
                            <div class="form-group" style="display: <?=$envioArq?>">
                                <div class="col-md-12">
                                    <div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
                                        <?php

                                        $arqsEnviados = listaArquivosPessoa($idPf, $tipoPessoa, "includes/documentos_fiscais_incentivador_pf", "39, 40, 41, 42, 43, 54");

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>

<script>
    let envioArq = "<?=$envioArq?>";

    function loadOtherPage() {
        let idProjeto = "<?=$idProjeto?>";
        let tipoPessoa = "<?=$tipoPessoa?>";
        let idIncentivador = "<?=$idIncentivador?>";

        let link = "../pdf/pdf_incentivar_projeto.php?tipoPessoa=" + tipoPessoa + "&idPessoa=" + idIncentivador + "&idProjeto=" + idProjeto +"";

        $("<iframe>")                             // create a new iframe element
            .hide()                               // make it invisible
            .attr("src", link) // point the iframe to the page you want to print
            .appendTo("body");                    // add iframe to the DOM to cause it to load the page

        let print = 1;

        if (print == 1 || envioArq == 'block') {
            $('#etapa8').show();
            $('#etapa7').hide();
        }

    }


</script>