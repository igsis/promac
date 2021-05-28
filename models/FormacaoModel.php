<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
} else {
    require_once "./models/ValidacaoModel.php";
}

class FormacaoModel extends ValidacaoModel
{
    protected function getCargo($cargo_id)
    {
        $cargo = MainModel::getInfo('formacao_cargos', $cargo_id, true)->fetchObject();
        return $cargo->cargo;
    }

    protected function getPrograma($programa_id)
    {
        $programa = MainModel::getInfo('programas', $programa_id, true)->fetchObject();
        return $programa->programa;
    }

    protected function getLinguagem($linguagem_id)
    {
        $linguagem = MainModel::getInfo('linguagens', $linguagem_id, true)->fetchObject();
        return $linguagem->linguagem;
    }
}