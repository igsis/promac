<?php
$con = bancoMysqli();

$idProjeto = $_GET['idProjeto'];

// Gerar documentos
$server = "http://".$_SERVER['SERVER_NAME']."/promac";
$http = $server."/pdf/";

if ($_SESSION['tipoPessoa'] == 1) {
    $idPf = $_SESSION['idUser'];
    include '../perfil/includes/menu_interno_pf.php';
} else {
    $idPj = $_SESSION['idUser'];
    include '../perfil/includes/menu_interno_pj.php';
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
        <div class="form-group">
            <h4>Carta de incentivo</h4>
            <h5></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form method="POST" action="?perfil=projeto_visualizacao" class="form-group" role="form">

                    <hr/>

                    <label for="carta_incentivo">Upload da carta de incentivo</label><br><br>
                    <?php if(isset($mensagem)){echo $mensagem;};

                    ?>

                    <hr/>

                    <label for="carta_incentivo">Upload da carta de incentivo</label><br><br>
                    <center><input type="file" name="carta_incentivo" id="carta_incentivo" size="75"></center>

                    <hr/>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value="Enviar">

                    <hr/>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="submit" name="voltar" class="btn btn-theme btn-lg btn-block" value="Voltar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
