<?php
require_once "../config/configGeral.php";
require_once "../config/configAPP.php";
$pedidoAjax = true;
require_once "../models/MainModel.php";
$db = new MainModel();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');



if(isset($_GET['cpf'])){

    $cpf = $_GET['cpf'];
    $ano = $_GET['ano'];

    $pessoa_fisica_id = $db->consultaSimples("SELECT id FROM pessoa_fisicas WHERE cpf = '$cpf'")->fetchColumn();

    $sql = "SELECT id FROM form_cadastros WHERE pessoa_fisica_id = '$pessoa_fisica_id' AND ano = '$ano'";
    $res = $db->consultaSimples($sql)->rowCount();

    $cadastros = json_encode($res);

    print_r($cadastros);
}