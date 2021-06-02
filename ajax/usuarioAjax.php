<?php
$pedidoAjax = true;
require_once "../config/configGeral.php";

if (isset($_POST['_method'])) {
    require_once "../controllers/UsuarioController.php";
    $insUsuario = new UsuarioController();

    if ($_POST['_method'] == "insereNovoUsuario"){
        if (isset($_POST['nome']) && (isset($_POST['senha'])) && (isset($_POST['token']))) {
            echo $insUsuario->insereUsuario();
        }
    }
    elseif ($_POST['_method'] == "editaUsuario"){
        echo $insUsuario->editaUsuario($_POST, $_POST['id']);
    }
    elseif ($_POST['_method'] == "trocaSenhaUsuario"){
        echo $insUsuario->trocaSenha($_POST, $_POST['id']);
    }
    elseif ($_POST['_method'] == "insereLoginPf"){
        echo $insUsuario->insereLoginPf($_POST['tipo_cadastro']);
    }
    elseif ($_POST['_method'] == "insereLoginPj"){
        echo $insUsuario->insereLoginPj($_POST['tipo_cadastro']);
    }
} else {
    include_once "../config/destroySession.php";
}