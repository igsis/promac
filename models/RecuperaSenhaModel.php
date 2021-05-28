<?php

if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class RecuperaSenhaModel extends MainModel
{
    protected function tokenExiste($email)
    {
        $query = "SELECT * FROM resete_senhas WHERE email = '$email'";
        return DbModel::consultaSimples($query);
    }

    protected function setToken($email, $token)
    {
        $dados = array(
            'email' => $email,
            'token' => $token
        );
        $verifica = $this->tokenExiste($email);
        if ($verifica->rowCount() == 0) {
            return DbModel::insert('resete_senhas', $dados);
        } else {
            $resultado = $verifica->fetch(PDO::FETCH_ASSOC);
            return DbModel::update('resete_senhas', $dados, $resultado['id']);
        }
    }

    protected function validaToken($__token)
    {

    }

    protected function limpezaToken($token){
        return str_replace("==","",$token);
    }

}