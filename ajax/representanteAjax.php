<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/RepresentanteController.php";
    $insRepresentante = new RepresentanteController();

    if ($_POST['_method'] == "cadastrar") {
        echo $insRepresentante->insereRepresentante($_POST['pagina']);
    } elseif ($_POST['_method'] == "editar") {
        echo $insRepresentante->editaRepresentante($_POST['id'], $_POST['pagina']);
    } elseif ($_POST['_method'] == "remover"){
        echo $insRepresentante->removeRepresentante($_POST['pagina']);
    }

} else {
    include_once "../config/destroySession.php";
}