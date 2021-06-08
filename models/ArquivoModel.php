<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}


class ArquivoModel extends MainModel
{
    /**
     * @param $arquivos
     * @param $origem_id
     * @param int $tamanhoMaximo
     * @param bool $validaPDF
     * @return mixed
     */
    protected function enviaArquivos($arquivos, $tipo_cadastro_id, $cadastro_id, $tamanhoMaximo, $validaPDF = false) {
        foreach ($arquivos as $key => $arquivo) {
            $erros[$key]['bol'] = false;
            if ($arquivo['error'] != 4) {
                $nomeArquivo = $arquivo['name'];
                $tamanhoArquivo = $arquivo['size'];
                $arquivoTemp = $arquivo['tmp_name'];
                $lista_documento_id = $arquivo['lista_documento_id'];
                $explode = explode('.', $nomeArquivo);
                $extensao = strtolower(end($explode));
                $extensoes_permitidas = ["doc", "docx", "pdf", "jpg", "jpeg", "png", "pdf"];

                if ($validaPDF && $extensao != 'pdf') {
                    $erros[$key]['bol'] = true;
                    $erros[$key]['motivo'] = "Arquivo em formato não aceito";
                    $erros[$key]['arquivo'] = $nomeArquivo;
                    continue;
                } elseif (!in_array($extensao, $extensoes_permitidas)) {
                    $erros[$key]['bol'] = true;
                    $erros[$key]['motivo'] = "Arquivo em formato não aceito";
                    $erros[$key]['arquivo'] = $nomeArquivo;
                    continue;
                }

                $dataAtual = date("Y-m-d H:i:s");
                $novoNome = date('YmdHis')."_".MainModel::retiraAcentos($nomeArquivo);
                $maximoPermitido = $tamanhoMaximo*1048576;

                if ($tamanhoArquivo <= $maximoPermitido) {
                    if (move_uploaded_file($arquivoTemp, UPLOADDIR . $novoNome)) {

                        $tabela = "arquivos";
                        $dadosInsertArquivo = [
                            'tipo_cadastro_id' => $tipo_cadastro_id,
                            'cadastro_id' => $cadastro_id,
                            'lista_documento_id' => $lista_documento_id,
                        ];

                        $dadosInsertArquivo['arquivo'] = $novoNome;
                        $dadosInsertArquivo['data_envio'] = $dataAtual;

                        $insertArquivo = DbModel::insert($tabela, $dadosInsertArquivo);
                        if ($insertArquivo->rowCount() == 0) {
                            $erros[$key]['bol'] = true;
                            $erros[$key]['motivo'] = "Falha ao salvar na base de dados";
                            $erros[$key]['arquivo'] = $nomeArquivo;
                        }
                    } else {
                        $erros[$key]['bol'] = true;
                        $erros[$key]['motivo'] = "Falha ao enviar o arquivo ao servidor";
                        $erros[$key]['arquivo'] = $nomeArquivo;
                    }
                } else {
                    $erros[$key]['bol'] = true;
                    $erros[$key]['motivo'] = "Arquivo maior que o tamanho máximo permitido";
                    $erros[$key]['arquivo'] = $nomeArquivo;
                }
            }
        }
        return $erros;
    }
}