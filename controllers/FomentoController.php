<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class FomentoController extends MainModel
{
    public function listaFomentos()
    {
        return DbModel::listaPublicado("fom_editais");
    }

    public function recuperaEdital($edital_id){
        $edital_id = MainModel::decryption($edital_id);
        return DbModel::getInfo('fom_editais', $edital_id)->fetchObject();
    }

    public function recuperaTipoContratacao($edital_id) {
        $tipo = gettype($edital_id);
        if ($tipo == "string") {
            $edital_id = MainModel::decryption($edital_id);
        }
        $sql = "SELECT tipo_contratacao_id FROM fom_editais WHERE id = '$edital_id'";
        return DbModel::consultaSimples($sql)->fetchColumn();
    }

    public function recuperaNomeEdital($edital_id) {
        $edital_id = MainModel::decryption($edital_id);
        $edital = DbModel::getInfo('fom_editais', $edital_id)->fetchObject();
        return $edital->titulo;
    }

    public function recuperaTipoPessoaEdital($edital_id) {
        $edital_id = MainModel::decryption($edital_id);
        $edital = DbModel::getInfo('fom_editais', $edital_id)->fetchObject();
        return $edital->pessoa_tipos_id;
    }
}