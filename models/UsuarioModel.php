<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class UsuarioModel extends MainModel
{
    protected function getUsuario($dados, $campo, $coluna) {
        $pdo = parent::connection();
        $sql = "SELECT id, $coluna AS 'nome' FROM {$dados['tabela']} WHERE $campo = :login AND senha = :senha";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":login", $dados['login']);
        $statement->bindParam(":senha", $dados['senha']);
        $statement->execute();
        return $statement;
    }

    protected function usuarioExiste($dados, $campo) {
        $pdo = parent::connection();
        $sql = "SELECT id FROM {$dados['tabela']} WHERE $campo = :login";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":login", $dados['login']);
        $statement->execute();
        if ($statement->rowCount() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    protected function getExisteEmail($email){
        $query = "SELECT id, email  FROM usuarios WHERE email = '$email'";
        $resultado = DbModel::consultaSimples($query);
        return $resultado;
    }
}