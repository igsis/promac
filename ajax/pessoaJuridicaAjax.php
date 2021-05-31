<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'prmc']);
    require_once "../controllers/ProponentePjController.php";
    $insPessoaJuridica = new ProponentePjController();

    if ($_POST['_method'] == "cadastrar") {
        echo $insPessoaJuridica->insereProponentePj($_POST['pagina']);
    } elseif ($_POST['_method'] == "editar") {
        echo $insPessoaJuridica->editaProponentePj($_POST['id'], $_POST['pagina']);
    }
} else {
    include_once "../config/destroySession.php";
}