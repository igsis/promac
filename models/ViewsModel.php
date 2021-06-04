<?php


class ViewsModel
{
    protected function verificaModulo ($mod) {
        $modulos = [
            "inicio",
            "inscricao",
            "projeto",
            "coordenadoria",
            "smc",
            "consulta"
        ];

        if (in_array($mod, $modulos)) {
            if (is_dir("./views/modulos/" . $mod)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    protected function exibirViewModel($view, $modulo = "") {
        $whitelist = [
            'cadastro_pf',
            'cadastro_pj',
            'finalizar',
            'inicio',
            'login',
            'logout',
            'normativos',
            'recupera_senha',
            'resete_senha',
            'incentivador_pf_cadastro',
            'incentivador_pf_documentos',
            'incentivador_pj_cadastro',
            'incentivador_pj_documentos',
            'proponente_pf_cadastro',
            'proponente_pf_documentos',
            'proponente_pj_cadastro',
            'proponente_pj_documentos',
            'representante',
            'representante_cadastro'
        ];
        if (self::verificaModulo($modulo)) {
            if (in_array($view, $whitelist)) {
                if (is_file("./views/modulos/$modulo/$view.php")) {
                    $conteudo = "./views/modulos/$modulo/$view.php";
                } else {
                    $conteudo = "./views/modulos/$modulo/inicio.php";
                }
            } else {
                $conteudo = "./views/modulos/$modulo/inicio.php";
            }
        } elseif ($modulo == "login") {
            $conteudo = "login";
        } elseif ($modulo == "cadastro") {
            $conteudo = "cadastro";
        } elseif ($modulo == "cadastro_pf") {
            $conteudo = "cadastro_pf";
        } elseif ($modulo == "cadastro_pj") {
            $conteudo = "cadastro_pj";
        } elseif ($modulo == "index") {
            $conteudo = "login";
        } elseif ($modulo == "normativos") {
            $conteudo = "normativos";
        } elseif ($modulo == "recupera_senha") {
            $conteudo = "recupera_senha";
        } elseif ($modulo == "resete_senha") {
            $conteudo = "resete_senha";
        }
        else {
            $conteudo = "login";
        }

        return $conteudo;
    }

    protected function exibirMenuModel ($modulo) {
        if (self::verificaModulo($modulo)) {
            if (is_file("./views/modulos/$modulo/include/menu.php")) {
                $menu = "./views/modulos/$modulo/include/menu.php";
            } else {
                switch ($_SESSION['modulo_p']) {
                    case "proponente_pf":
                        $menu = "./views/modulos/inscricao/include/menu_proponente_pf.php";
                        break;
                    case "proponente_pj":
                        $menu = "./views/modulos/inscricao/include/menu_proponente_pj.php";
                        break;
                    case "incentivador_pf":
                        $menu = "./views/modulos/inscricao/include/menu_incentivador_pf.php";
                        break;
                    case "incentivador_pj":
                        $menu = "./views/modulos/inscricao/include/menu_incentivador_pj.php";
                        break;
                    default:
                        $menu = "./views/template/menuExemplo.php";
                        break;
                }
            }
        } else {
            $menu = "./views/template/menuExemplo.php";
        }

        return $menu;
    }
}