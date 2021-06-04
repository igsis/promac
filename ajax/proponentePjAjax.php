<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'prmc']);
    require_once "../controllers/ProponentePjController.php";
    $pjObj = new ProponentePjController();

    switch ($_POST['_method']) {
        case "editarPj":
            echo $pjObj->editaProponentePj($_POST['id'],$_POST['pagina']);
            break;
    }
} else {
    include_once "../config/destroySession.php";
}