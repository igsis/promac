<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'cpc']);
    require_once "../controllers/EventoController.php";
    $insEvento = new EventoController();

    switch ($_POST['_method']) {
        case "cadastrarEvento":
            echo $insEvento->insereEvento($_POST);
            break;
        case "editarEvento":
            echo $insEvento->editaEvento($_POST, $_POST['id']);
            break;
        case "envioEvento":
            echo $insEvento->envioEvento($_POST['id'], $_POST['modulo']);
            break;
        case "apagaEvento":
            echo $insEvento->apagaEvento($_POST['id']);
            break;
    }
} else {
    include_once "../config/destroySession.php";
}