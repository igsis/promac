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

if (isset($_GET['distrito_id'])){
    $distrito_id = $_GET['distrito_id'];

    $subs = $db->consultaSimples("SELECT s.id, s.subprefeitura FROM subprefeituras s INNER JOIN distritos d on s.id = d.subprefeitura_id WHERE d.id = '$distrito_id'")->fetchAll();

    print_r(json_encode($subs));
}