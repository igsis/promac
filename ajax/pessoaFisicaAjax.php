<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'cpc']);
    require_once "../controllers/PessoaFisicaController.php";
    $insPessoaFisica = new PessoaFisicaController();

    if ($_POST['_method'] == "cadastrar") {
        echo $insPessoaFisica->inserePessoaFisica($_POST['pagina']);
    } elseif ($_POST['_method'] == "editar") {
        echo $insPessoaFisica->editaPessoaFisica($_POST['id'], $_POST['pagina']);
    }
} else {
    include_once "../config/destroySession.php";
}