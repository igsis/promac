<?php
require_once "../config/configGeral.php";
require_once "../config/configAPP.php";
$pedidoAjax = true;
require_once "../models/MainModel.php";
$db = new MainModel();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');

if (isset($_POST['email'])){
    $emailPostado = $_POST['email'];

    $sql = "SELECT * FROM usuarios WHERE email = '$emailPostado'";

    $res = $db->consultaSimples($sql)->rowCount();

    if($res > 0)
        $email = json_encode(array('email' => 'Email em uso!', 'ok' => 0));
    else
        $email = json_encode(array('email' => 'Email ok', 'ok' => 1));

    print_r($email);
}