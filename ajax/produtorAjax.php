<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {

    require_once "../controllers/ProdutorController.php";
    $insProdutor = new ProdutorController();

    if ($_POST['_method'] == "cadastrarProdutor") {
        echo $insProdutor->insereProdutor($_POST, $_POST['atracao_id'], $_POST['modulo']);
    } elseif ($_POST['_method'] == "editarProdutor") {
        echo $insProdutor->editaProdutor($_POST, $_POST['produtor_id']);
    }
} else {
    include_once "../config/destroySession.php";
}