<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/RepresentanteController.php";
    $repObj = new RepresentanteController();

    session_start(['name' => 'prmc']);
    if ($_SESSION['modulo_p'] == "proponente_pj"){
        $tabela = "proponente_pjs";
    } else{
        $tabela = "incentivador_pjs";
    }

    switch ($_POST['_method']){
        case "cadastrarRep":
            echo $repObj->insereRepresentante($_POST['pagina'],$tabela);
            break;
        case "editarRep":
            echo $repObj->editaRepresentante($_POST['id'], $_POST['pagina'], $tabela);
            break;
        case "removerRep":
            echo $repObj->removeRepresentante("inscricao/representante",$tabela);
    }

} else {
    include_once "../config/destroySession.php";
}