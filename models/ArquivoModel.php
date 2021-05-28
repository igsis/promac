<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}


class ArquivoModel extends MainModel
{
    protected function separaArquivosComProd($lista_documento_id) {
        foreach ($_FILES as $file) {
            $numArquivos = count($file['error']);
            foreach ($file as $key => $dados) {
                for ($i = 0; $i < $numArquivos; $i++) {
                    $arquivos[$i][$key] = $file[$key][$i];
                }
            }
        }
        foreach ($arquivos as $key => $arquivo) {
            $arquivos[$key]['lista_documento_id'] = $lista_documento_id;
        }
        return $arquivos;
    }

    /**
     * @param $arquivos
     * @param $origem_id
     * @param $tamanhoMaximo
     * @param $validaPDF
     * @return mixed
     */
    protected function enviaArquivos($arquivos, $origem_id, $tamanhoMaximo, $validaPDF = false, $fomento = false, $formacao = false) {
        foreach ($arquivos as $key => $arquivo) {
            $erros[$key]['bol'] = false;
            if ($arquivo['error'] != 4) {
                $nomeArquivo = $arquivo['name'];
                $tamanhoArquivo = $arquivo['size'];
                $arquivoTemp = $arquivo['tmp_name'];
                $lista_documento_id = $arquivo['lista_documento_id'];
                $explode = explode('.', $nomeArquivo);
                $extensao = strtolower(end($explode));

                if ($validaPDF && $extensao != 'pdf') {
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
                        if ($fomento) {
                            $tabela = "fom_arquivos";
                            $dadosInsertArquivo = [
                                'fom_projeto_id' => $origem_id,
                                'fom_lista_documento_id' => $lista_documento_id,
                            ];
                        } elseif ($formacao){
                            $tabela = "form_arquivos";
                            $dadosInsertArquivo = [
                                'form_cadastro_id' => $origem_id,
                                'form_lista_documento_id' => $lista_documento_id,
                            ];
                        }
                        else {
                            $tabela = "arquivos";
                            $dadosInsertArquivo = [
                                'origem_id' => $origem_id,
                                'lista_documento_id' => $lista_documento_id,
                            ];
                        }

                        $dadosInsertArquivo['arquivo'] = $novoNome;
                        $dadosInsertArquivo['data'] = $dataAtual;

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

    protected function listaArquivosFomentos($tipo_contratacao_id) {
        $sql = "SELECT fld.id, fld.sigla, fld.documento, tc.tipo_contratacao, cd.anexo, cd.obrigatorio
                FROM contratacao_documentos AS cd
                INNER JOIN fom_lista_documentos AS fld ON fld.id = cd.fom_lista_documento_id
                INNER JOIN tipos_contratacoes AS tc ON cd.tipo_contratacao_id = tc.id
                WHERE cd.tipo_contratacao_id = '$tipo_contratacao_id' AND fld.publicado = 1 ORDER BY ordem";
        $arquivos = DbModel::consultaSimples($sql);

        return $arquivos;
    }
}