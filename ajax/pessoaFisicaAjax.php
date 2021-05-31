<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'prmc']);
    require_once "../controllers/ProponentePfController.php";
    $insPessoaFisica = new ProponentePfController();

    if ($_POST['_method'] == "cadastrar") {
        echo $insPessoaFisica->insereProponentePf($_POST['pagina']);
    } elseif ($_POST['_method'] == "editar") {
        echo $insPessoaFisica->editaProponentePf($_POST['id'], $_POST['pagina']);
    }
} else {
    include_once "../config/destroySession.php";
}