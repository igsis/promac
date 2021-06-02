<?php
if ($pedidoAjax) {
    require_once "../models/ArquivoModel.php";
    define('UPLOADDIR', "../pdf/");
} else {
    require_once "./models/ArquivoModel.php";;
    define('UPLOADDIR', "./pdf/");
}

class NormativoController extends ArquivoModel
{
    public function listaTipoNormativo()
    {
        return DbModel::consultaSimples("SELECT * FROM normativo_tipos ORDER BY ordem")->fetchAll(PDO::FETCH_OBJ);
    }

    public function listaNormativos($normativo_tipo_id)
    {
        return DbModel::consultaSimples("SELECT * FROM normativos WHERE publicado = 1 AND normativo_tipo_id = '$normativo_tipo_id' ORDER BY ordem")->fetchAll(PDO::FETCH_OBJ);
    }
}