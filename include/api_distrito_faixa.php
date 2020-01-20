<?php
require_once '../funcoes/funcoesConecta.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');

$con = bancoMysqli();

if(isset($_GET['distrito'])){
    $distrito_id = $_GET['distrito'];

    $sql = "SELECT faixa FROM distrito WHERE idDistrito = '$distrito_id'";
    $res = $con->query($sql)->fetch_all();

    $faixa =  json_encode($res);
    print_r($faixa);
}