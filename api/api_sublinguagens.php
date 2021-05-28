<?php
require_once "../config/configGeral.php";
require_once "../config/configAPP.php";
$pedidoAjax = true;
require_once "../models/MainModel.php";
$db = new MainModel();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');



if(isset($_GET['linguagem_id'])){
    $id = $_GET['linguagem_id'];

    $sql = "SELECT id, sublinguagem FROM oficina_sublinguagens WHERE oficina_linguagem_id = '$id' ORDER BY sublinguagem";
    $res = $db->consultaSimples($sql)->fetchAll();

    $sublinguagens =  json_encode($res);

    print_r($sublinguagens);

}