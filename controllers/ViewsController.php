<?php
require_once "./models/ViewsModel.php";

class ViewsController extends ViewsModel
{
    public function exibirTemplate() {
        include "views/template/master.php";
    }

    public function navbar() {
        include "views/template/navbar.php";
    }

    public function sidebar() {
        return "views/template/sidebar.php";
    }

    public function footer() {
        include "views/template/footer.php";
    }

    public function exibirViewController() {
        if (isset($_GET['views'])) {
            $url = explode("/", $_GET['views']);

            $rota = [
                "view" => $url[1] ?? "",
                "modulo" => $url[0] ?? ""
            ];

            $resposta = ViewsModel::exibirViewModel($rota['view'], $rota['modulo']);
        } else {
            $resposta = "index";
        }
        return $resposta;
    }

    public function exibirMenuController() {
        if (isset($_GET['views'])) {
            $url = explode("/", $_GET['views']);

            $rota = [
                "view" => $url[1] ?? "",
                "modulo" => $url[0] ?? ""
            ];

            $resposta = ViewsModel::exibirMenuModel($rota['modulo']);
        } else {
            $resposta = "menuPadrao";
        }
        return $resposta;
    }
}