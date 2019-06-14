<?php
$con = bancoMysqli();
$idPf = $_SESSION['idUser'];
$tipoPessoa = '4';

if (isset($_POST['enviarSMC'])) {
    $sqlLiberado = "UPDATE incentivador_pessoa_fisica SET liberado = 4 WHERE idPf = $idPf";
    $sqlEtapa = "UPDATE etapas_incentivo SET etapa = 2 WHERE idIncentivador = $idPf";

    if (mysqli_query($con, $sqlLiberado) && mysqli_query($con, $sqlEtapa)) {
        $mensagem = "<font color='#01DF3A'><strong>Suas certidões de regularidade fiscal foram enviadas à SMC!</strong></font>";
        gravarLog($sqlLiberado);
        gravarLog($sqlEtapa);
    }
}

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

                    if (verificaArquivosExistentesPF($idPf,$y)){

                        if ($mensagem != '') {

                            $mensagem .= '<div class="alert alert-warning">O arquivo ' . $arq['documento'] . ' já foi enviado.</div>';

                        } else {

                            $mensagem = '<div class="alert alert-warning">O arquivo ' . $arq['documento'] . ' já foi enviado.</div>';
                        }

                    } else {

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

?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include '../includes/menu_interno_pf.php' ?>
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
                <?php
                if (isset($mensagem)) {
                   echo "<h5>" . $mensagem . "</h5>";
                }
                ?>
                <ul class="list-group">
                    <li class="list-group-item list-group-item-<?= $cor_status ?>">
                        <strong><?= $statusIncentivador ?>.</strong>
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
                            $arqsIncentivar = array(39, 40, 41, 42, 43, 54);
                            $arqsPublicados = array();
                            //print_r($arqsIncentivar);
                            $sql = "SELECT *
                                        FROM lista_documento as list
                                        INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
                                        WHERE arq.idPessoa = '$idPf'
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

                                $arqsPublicados[$count] = $arquivo['idListaDocumento'];

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

                            $apagados = array_diff($arqsIncentivar, $arqsPublicados);
                            $apagados = implode(", ", $apagados);

                            ?>
                            </tbody>
                        </table>
                    </div>
                    <?php

                    if ($linhas == 6 && $liberado != 4 && $negados == '') {
                        ?>

                        <form method="POST" action="?perfil=includes/incentivadorPF_etapa3_visualiza_docs"
                              enctype="multipart/form-data">
                            <input type="submit" name="enviarSMC" class="btn btn-theme btn-lg btn-block"
                                   value='Reenviar à SMC'>
                        </form>

                        <?php
                    } ?>
                </div>


                <div class='form-group'>
                    <ul class='list-group'>
                        <li class='list-group-item list-group-item-success'>Notas</li>
                        <?php listaNota($idPf, 3, 1) ?>
                    </ul>
                </div>

                <?php
                if ($negados != '') {
                    $negados = substr($negados, 0, -2);
                    ?>
                    <br>
                    <div class="form-group">
                        <div class="table-responsive list_info"><h6>Arquivo(s) Negado(s)</h6>
                            <?php
                            listaArquivosPessoa($idPf, $tipoPessoa, "includes/incentivadorPF_etapa3_visualiza_docs", $negados, 'table-striped');
                            ?>
                        </div>
                    </div>
                    <?php
                }
                if ($apagados != '') {
                ?>
                <div class="form-group" id="uploadDocs">
                    <div class="table-responsive list_info"><h6>Upload de Arquivo(s) Somente em PDF</h6>
                        <form method="POST" action="?perfil=includes/incentivadorPF_etapa3_visualiza_docs"
                              enctype="multipart/form-data">
                            <?php
                            $i = 0;
                            $documentos = [];
                            $sql_arquivos = "SELECT * FROM lista_documento AS lista 
                                            INNER JOIN upload_arquivo AS uploads ON uploads.idListaDocumento = lista.idListaDocumento 
                                            WHERE uploads.idPessoa = $idPf 
                                            AND uploads.idStatusDocumento = 3 
                                            AND uploads.publicado = 0 
                                            AND lista.idListaDocumento IN ($apagados)
                                            GROUP BY lista.idListaDocumento";

                            $query_arquivos = mysqli_query($con, $sql_arquivos);

                            while ($arq = mysqli_fetch_array($query_arquivos)) {
                                $doc = $arq['documento'];
                                $query = "SELECT idListaDocumento FROM lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='3'";
                                $envio = $con->query($query);
                                $row = $envio->fetch_array(MYSQLI_ASSOC);
                                $sigla = $arq['sigla'];

                                $documento =
                                    [
                                        'nomeDocumento' => $arq['documento'],
                                        'sigla' => $arq['sigla']
                                    ];
                                array_push($documentos, $documento);
                            }

                            if ($documentos) {
                            ?>
                            <table class='table table-condensed'>
                                <tr class='list_menu'>
                                    <td>Tipo de Arquivo</td>
                                    <td></td>
                                </tr>
                                <?php
                                foreach ($documentos as $documento) {
                                    $nomeDoc = $documento['nomeDocumento'];
                                    $sigla = $documento['sigla'];
                                    echo "<tr>";
                                    echo "<td class='list_description'><label>$nomeDoc</label></td>";
                                    echo "<td class='list_description'><input type='file' name='arquivo[$sigla]'></td>";
                                    echo "<tr>";
                                }
                                ?>
                            </table>
                            <input type="hidden" name="idPessoa" value="<?php echo $idPf; ?>"/>
                            <input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"/>
                            <input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block"
                                   value='upload'>

                        </form>
                    </div>
                    <?php
                    }
                    }
                    ?>
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
</section>