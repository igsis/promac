<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'prmc']);
    require_once "../controllers/ProponentePfController.php";
    $pfObj = new ProponentePfController();

    switch ($_POST['_method']) {
        case "cadastrarPf":
            echo $pfObj->insereProponentePf($_POST['pagina']);
            break;
        case "editarPf":
            echo $pfObj->editaProponentePf($_POST['id'],$_POST['pagina']);
            break;
    }
} else {
    include_once "../config/destroySession.php";
}