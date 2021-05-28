<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'cpc']);
    require_once "../controllers/OficinaController.php";
    $insOficina = new OficinaController();

    switch ($_POST['_method']) {
        case "cadastrarOficina":
            echo $insOficina->insereOficina($_POST);
            break;
        case "editarOficina";
            echo $insOficina->editaOficina($_POST, $_POST['evento_id'], $_POST['atracao_id']);
            break;
        case "apagaOficina":
            echo $insOficina->apagaOficina($_POST['id']);
            break;
        case "cadastraComplemento":
            echo $insOficina->insereComplementosOficina($_POST);
            break;
        case "editaComplemento":
            echo $insOficina->editaComplementosOficina($_POST, $_POST['id']);
            break;
    }
} else {
    include_once "../config/destroySession.php";
}