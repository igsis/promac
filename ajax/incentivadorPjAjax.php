<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'prmc']);
    require_once "../controllers/IncentivadorPjController.php";
    $pjObj = new IncentivadorPjController();

    switch ($_POST['_method']) {
        case "editarPj":
            echo $pjObj->editaIncentivadorPj($_POST['id'],$_POST['pagina']);
            break;
        case "envioCadastro":
            echo $pjObj->enviarCadastro($_POST['id']);
            break;
    }
} else {
    include_once "../config/destroySession.php";
}