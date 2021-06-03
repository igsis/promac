<?php

$pedidoAjax = true;

require_once "../config/configGeral.php";
require_once "../config/configAPP.php";
require_once "../models/MainModel.php";

$db = new MainModel();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');

if (isset($_GET['zona_id']) || isset($_POST['zona_id'])){
    $zona_id = $_GET['zona_id'] ?? $_POST['zona_id'];

    $distritos = $db->consultaSimples("SELECT id, distrito FROM distritos WHERE zona_id = '$zona_id' order by distrito")->fetchAll();

    print_r(json_encode($distritos));
}

if (isset($_GET['subprefeitura_id'])){
    $subprefeitura_id = $_GET['subprefeitura_id'];

    $subs = $db->consultaSimples("SELECT id, subprefeitura FROM subprefeituras WHERE id = '$subprefeitura_id'")->fetchAll();

    print_r(json_encode($subs));
}