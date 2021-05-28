<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'cpc']);
    require_once "../controllers/PessoaJuridicaController.php";
    $insPessoaJuridica = new PessoaJuridicaController();

    if ($_POST['_method'] == "cadastrar") {
        echo $insPessoaJuridica->inserePessoaJuridica($_POST['pagina']);
    } elseif ($_POST['_method'] == "editar") {
        echo $insPessoaJuridica->editaPessoaJuridica($_POST['id'], $_POST['pagina']);
    }
} else {
    include_once "../config/destroySession.php";
}