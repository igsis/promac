<?php
$con = bancoMysqli();

$idProjeto = $_GET['idProjeto'];

// Gerar documentos
$server = "http://".$_SERVER['SERVER_NAME']."/promac";
$http = $server."/pdf/";

function listaCartasIncentivo ($idProjeto) {
    $con = bancoMysqli();
    $projeto = recuperaDados("projeto","idProjeto",$idProjeto);

    $sqlCarta = "SELECT * FROM upload_arquivo WHERE idPessoa = '$idProjeto' AND idListaDocumento = 18 ORDER BY dataEnvio";
    $queryCarta = mysqli_query($con, $sqlCarta);
    $linhas = mysqli_num_rows($queryCarta);
    if ($linhas > 0) {
        echo "
            <table class='table table-condensed'>
               <thead>
                <tr class='list_menu'>
				    <td>Tipo de arquivo</td>
					<td>Data do Envio</td>
				</tr>
			   </thead>";
        echo "<tbody>";

        while ($item = mysqli_fetch_array($queryCarta))
        {
            echo "<tr>";
            echo "<td class='list_description'>Carta de incentivo</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $item['arquivo'] . "' target='_blank'>" . mb_strimwidth($item['dataEnvio'], 0, 25, "...") . "</a></td>";
            echo "</tr>";
        }
        echo "</tbody>
			</table>";
    }else
    {
        echo "<p>Ainda não há carta(s) inserida(s).<p/><br/>";
    }
}

if(isset($_POST['enviar'])) {

    $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '3' AND idListaDocumento = 18";
    $query_arquivos = mysqli_query($con, $sql_arquivos);

    // echo $sql_arquivos;

    $new_status = "UPDATE `promac`.`projeto` SET `idEtapaProjeto` = '35' WHERE `idProjeto`= '$idProjeto'";
    $query_status = mysqli_query($con, $new_status);

    foreach($query_arquivos as $arq) {

        $y = $arq['idListaDocumento'];
        $x = $arq['sigla'];
        $nome_arquivo = $_FILES['carta_incentivo']['name'] ?? null;
        $f_size = $_FILES['carta_incentivo']['size'] ??  null;

        //Extensões permitidas
        $ext = array("PDF", "pdf");

        if ($f_size > 5242880) // 5MB em bytes
        {
            $mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></font>";
        } else {
            if ($nome_arquivo != "") {
                $nome_temporario = $_FILES['carta_incentivo']['tmp_name'];
                $new_name = date("YmdHis") . "_" . semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
                $hoje = date("Y-m-d H:i:s");
                $dir = '../uploadsdocs/'; //Diretório para uploads
                $allowedExts = array(".pdf", ".PDF"); //Extensões permitidas
                $ext = strtolower(substr($nome_arquivo, -4));

                if (in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas
                {
                    if (move_uploaded_file($nome_temporario, $dir . $new_name)) {
                        $sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipo`, `idPessoa`, `idListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('3', '$idProjeto', '$y', '$new_name', '$hoje', '1'); ";

                        $query = mysqli_query($con, $sql_insere_arquivo);

                        if ($query) {

                            $mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
                            // gravarLog($sql_insere_arquivo);

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

?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php

        if ($_SESSION['tipoPessoa'] == 1) {
            $idPf = $_SESSION['idUser'];
            include '../perfil/includes/menu_interno_pf.php';
        } else {
            $idPj = $_SESSION['idUser'];
            include '../perfil/includes/menu_interno_pj.php';
        }

        ?>

        <div class="form-group">
            <h4>Anexos</h4>
            <h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <!-- Exibir arquivos -->
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="table-responsive list_info"><h6>Carta(s) Anexada(s)</h6>
                            <?php listaCartasIncentivo($idProjeto); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="table-responsive list_info"><h6>Upload de Arquivo(s) Somente em PDF com tamanho máximo de 5MB.</h6>
                            <form method="POST" enctype="multipart/form-data" action="?perfil=carta_incentivo&idProjeto=<?= $idProjeto ?>" class="form-group" role="form">
                                <table class="table table-condensed">
                                    <thead>
                                    <tr class="list_menu">
                                        <td width="50%">Tipo de arquivo</td>
                                        <td></td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="list_description">Carta de incentivo</td>
                                        <td class="list_description"><input type="file" name="carta_incentivo" id="carta_incentivo" size="75"></center></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <br><input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value="Fazer Upload">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-6">
                        <form method="post" action="?perfil=projeto_visualizacao" class="form-group" role="form">
                            <br><input type="submit" value="Voltar" class="btn btn-theme btn-md btn-block">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


