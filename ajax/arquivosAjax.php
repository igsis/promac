<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/ArquivoController.php";
    $arquivoObj = new ArquivoController();

    if ($_POST['_method'] == "enviarArquivo") {
        echo $arquivoObj->enviarArquivo($_POST['tipo_cadastro_id'], $_POST['cadastro_id'], $_POST['pagina']);
    } elseif ($_POST['_method'] == "removerArquivo") {
        echo $arquivoObj->apagarArquivo($_POST['arquivo_id'], $_POST['pagina']);
    }
} else {
    include_once "../config/destroySession.php";
}