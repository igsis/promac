<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class UsuarioModel extends MainModel
{
    protected function getUsuario($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":email", $dados['email']);
        $statement->bindParam(":senha", $dados['senha']);
        $statement->execute();
        return $statement;
    }

    protected function getEmail($dados) {
        $pdo = parent::connection();
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":email", $dados['email']);
        $statement->execute();
        return $statement;
    }

    protected function getExisteEmail($email){
        $query = "SELECT id, email  FROM usuarios WHERE email = '$email'";
        $resultado = DbModel::consultaSimples($query);
        return $resultado;
    }
}