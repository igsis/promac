<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    session_start(['name' => 'cpc']);
    //$idPf = $_SESSION['origem_id_c'];
    require_once "../controllers/FormacaoController.php";
    $formacaoObj = new FormacaoController();

    switch ($_POST['_method']) {
        case "cadastrar":
            echo $formacaoObj->insereFormacao();
            break;
        case "editar":
            echo $formacaoObj->editaFormacao($_POST['id']);
            break;
        case "cadastrarPf":
            echo $formacaoObj->inserePfCadastro($_POST['pagina']);
            break;
        case "editarPf":
            echo $formacaoObj->editaPfCadastro($_POST['id'],$_POST['pagina']);
            break;
        case "apagarFormacao":
            echo $formacaoObj->apagaFormacao($_POST['id']);
            break;
        case "apagarDadosBancarios":
            echo $formacaoObj->apagaDadosBancarios($_POST['id'], $_POST['pagina']);
            break;
        case "envioFormacao":
            echo $formacaoObj->enviarCadastro($_POST['id']);
            break;
    }
} else {
    include_once "../config/destroySession.php";
}