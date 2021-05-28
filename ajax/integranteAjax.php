<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'cpc']);
    require_once "../controllers/IntegranteController.php";
    $integranteObj = new IntegranteController();

    if ($_POST['_method'] == "cadastraIntegranteFomento") {
        echo $integranteObj->cadastraIntegrante(true);
    }elseif ($_POST['_method'] == "editaIntegranteFomento") {
        echo $integranteObj->editaIntegrante($_POST['id'], true);
    }elseif ($_POST['_method'] == "apagaIntegranteFomento") {
        echo $integranteObj->apagaIntegrante($_POST['id'], true);
    }
} else {
    include_once "../config/destroySession.php";
}