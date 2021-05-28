<?php
require_once "../config/configGeral.php";
require_once "../config/configAPP.php";
$pedidoAjax = true;
require_once "../models/MainModel.php";
$db = new MainModel();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Content-Type: application/json');



if(isset($_GET['busca'])){
    if ($_GET['busca'] == 1) {
        $programa_id = $_GET['programa_id'];
        $sql = "SELECT cp.formacao_cargo_id AS 'id', fc.cargo AS 'cargo' FROM cargo_programas AS cp
                INNER JOIN formacao_cargos AS fc ON cp.formacao_cargo_id = fc.id
                WHERE cp.programa_id = '$programa_id' ORDER BY fc.cargo";
        $res = $db->consultaSimples($sql,true)->fetchAll();
        $cargos = json_encode($res);
        print_r($cargos);
    }
    elseif ($_GET['busca'] == 2) {
        $programa_id = $_GET['programa_id'];
        $cargo1 = $_GET['cargo1_id'];

        $sql = "SELECT DISTINCT cp.formacao_cargo_id AS 'id', fc.cargo AS 'cargo' FROM cargo_programas AS cp
                INNER JOIN siscontrat.formacao_cargos AS fc ON cp.formacao_cargo_id = fc.id
                WHERE cp.programa_id = '$programa_id' AND cp.formacao_cargo_id NOT IN ($cargo1, 4, 5) ORDER BY fc.cargo";
        $res = $db->consultaSimples($sql,true)->fetchAll();

        $cargos = json_encode($res);

        print_r($cargos);
    }elseif ($_GET['busca'] == 3) {
        $programa_id = $_GET['programa_id'];
        $cargo1 = $_GET['cargo1_id'];
        $cargo2 = $_GET['cargo2_id'];
        
        $sql = "SELECT DISTINCT cp.formacao_cargo_id AS 'id', fc.cargo AS 'cargo' FROM cargo_programas AS cp
                INNER JOIN siscontrat.formacao_cargos AS fc ON cp.formacao_cargo_id = fc.id
                WHERE cp.programa_id = '$programa_id' AND cp.formacao_cargo_id NOT IN ($cargo1, $cargo2, 4, 5) ORDER BY fc.cargo";
        $res = $db->consultaSimples($sql,true)->fetchAll();

        $cargos = json_encode($res);

        print_r($cargos);
    }
}