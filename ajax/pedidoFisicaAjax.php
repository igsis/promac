<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'cpc']);
    require_once "../controllers/PedidoController.php";
    $insPedidoFisica = new PedidoController();

    if ($_POST['_method'] == "cadastrar") {
        echo $insPedidoFisica->inserePedidoFisica($_POST['pagina'], $_POST['origem_tipo']);
    }elseif ($_POST['_method'] == "editar") {
        echo $insPedidoFisica->editaPedidoFisica($_POST['id'],$_POST['pagina'], $_POST['origem_tipo']);
    }
} else {
    include_once "../config/destroySession.php";
}