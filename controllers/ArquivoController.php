<?php
if ($pedidoAjax) {
    require_once "../models/ArquivoModel.php";
    define('UPLOADDIR', "../uploads/");
} else {
    require_once "./models/ArquivoModel.php";
    define('UPLOADDIR', "./uploads/");
}

class ArquivoController extends ArquivoModel
{
    public function listarArquivos($tipo_contratacao_id){
        $sql = "SELECT ld.id, ld.sigla, ld.documento, ac.obrigatorio
                FROM arquivo_cadastros AS ac
                INNER JOIN lista_documentos AS ld ON ld.id = ac.lista_documento_id
                INNER JOIN tipo_cadastros AS tc ON ac.tipo_cadastro_id = tc.id
                WHERE ac.tipo_cadastro_id = '$tipo_contratacao_id' AND ld.publicado = 1";
        return DbModel::consultaSimples($sql);
    }

    public function listarArquivosEnviados($tipo_cadastro_id, $cadastro_id) {
        $cadastro_id = MainModel::decryption($cadastro_id);
        $lista_documentos_ids = DbModel::consultaSimples("SELECT lista_documento_id FROM arquivo_cadastros WHERE tipo_cadastro_id = '$tipo_cadastro_id'")->fetchAll(PDO::FETCH_COLUMN);;

        $documentos = implode(", ", $lista_documentos_ids);
        $sql = "SELECT a.id, a.arquivo, a.data_envio, a.status_documento_id, ld.documento FROM arquivos AS a
                INNER JOIN lista_documentos AS ld on a.lista_documento_id = ld.id
                WHERE tipo_cadastro_id = '$tipo_cadastro_id' AND `cadastro_id` = '$cadastro_id' AND lista_documento_id IN ($documentos) AND a.publicado = '1'";

        return DbModel::consultaSimples($sql);
    }

    public function listarObservacoesArquivo($arquivo_id) {
        return DbModel::consultaSimples("SELECT observacao FROM arquivo_observacoes WHERE arquivo_id = '$arquivo_id'")->fetchAll(PDO::FETCH_COLUMN);
    }

    public function recuperaIdListaDocumento($tipo_documento_id, $fomento = false) {
        if (!$fomento) {
            $sql = "SELECT id FROM lista_documentos WHERE tipo_documento_id = '$tipo_documento_id'";
        } else {
            $tipo_documento_id = MainModel::decryption($tipo_documento_id);
            $tipo_documento_id = (new FomentoController())->recuperaTipoContratacao((int) $tipo_documento_id);
            $sql = "SELECT fld.id FROM fom_lista_documentos AS fld
                INNER JOIN contratacao_documentos AS cd on fld.id = cd.fom_lista_documento_id
                WHERE cd.tipo_contratacao_id = '$tipo_documento_id'";
        }

        return DbModel::consultaSimples($sql);
    }

    public function enviarArquivo($tipo_cadastro_id, $cadastro_id, $pagina) {
        unset($_POST['pagina']);
        $cadastro_id = MainModel::decryption($cadastro_id);
        foreach ($_FILES as $key => $arquivo){
            $_FILES[$key]['lista_documento_id'] = $_POST[$key];
        }
        $erros = ArquivoModel::enviaArquivos($_FILES, $tipo_cadastro_id, $cadastro_id,5, true);
        $erro = MainModel::in_array_r(true, $erros, true);

        if ($erro) {
            foreach ($erros as $erro) {
                if ($erro['bol']){
                    $lis[] = "'<li>" . $erro['arquivo'] . ": " . $erro['motivo'] . "</li>'";
                }
            }
            $alerta = [
                'alerta' => 'arquivos',
                'titulo' => 'Oops! Tivemos alguns Erros!',
                'texto' => $lis,
                'tipo' => 'error',
                'location' => SERVERURL . $pagina
            ];
        } else {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Arquivos Enviados!',
                'texto' => 'Arquivos enviados com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    public function apagarArquivo ($arquivo_id, $pagina){
        $arquivo_id = MainModel::decryption($arquivo_id);
        $remover = DbModel::apaga('arquivos', $arquivo_id);
        if ($remover->rowCount() > 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Arquivo Apagado!',
                'texto' => 'Arquivo apagado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao remover o arquivo do servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }

        return MainModel::sweetAlert($alerta);
    }

    public function consultaArquivoEnviado($lista_documento_id, $tipo_cadastro_id, $cadastro_id) {
        $cadastro_id = MainModel::decryption($cadastro_id);

        $sql = "SELECT * FROM arquivos
                WHERE lista_documento_id = '$lista_documento_id'
                AND tipo_cadastro_id = '$tipo_cadastro_id' AND cadastro_id = '$cadastro_id' AND publicado = '1'";

        $arquivo = DbModel::consultaSimples($sql)->rowCount();
        return $arquivo > 0 ? true : false;
    }
}