<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'prmc']);
    require_once "../controllers/IncentivadorPfController.php";
    $pfObj = new IncentivadorPfController();

    switch ($_POST['_method']) {
        case "cadastrarPf":
            echo $pfObj->insereIncentivadorPf($_POST['pagina']);
            break;
        case "editarPf":
            echo $pfObj->editaIncentivadorPf($_POST['id'],$_POST['pagina']);
            break;
        case "envioCadastro":
            echo $pfObj->enviarCadastro($_POST['id']);
            break;
    }
} else {
    include_once "../config/destroySession.php";
}