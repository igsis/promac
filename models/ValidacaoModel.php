<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class ValidacaoModel extends MainModel
{
    protected function validaBanco($tipoProponente, $id) {
        if ($tipoProponente == 1) {
            $proponente = DbModel::consultaSimples("SELECT * FROM pf_bancos WHERE pessoa_fisica_id = '$id'");
        } else {
            $proponente = DbModel::consultaSimples("SELECT * FROM pj_bancos WHERE pessoa_juridica_id = '$id'");
        }
        if ($proponente->rowCount() == 0) {
            $erros['bancos']['bol'] = true;
            $erros['bancos']['motivo'] = "Proponente não possui conta bancária cadastrada";

            return $erros;
        } else {
            $proponente = $proponente->fetchObject();
            $erros = ValidacaoModel::retornaMensagem($proponente);
        }
        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaBancoFormacao($id) {
        $proponente = DbModel::consultaSimples("SELECT banco_id FROM pf_bancos WHERE pessoa_fisica_id = '$id' AND publicado = '1'");

        if ($proponente->rowCount()) {
            $proponente = $proponente->fetchObject();

            if ($proponente->banco_id != 32) {
                $erros['bancos']['bol'] = true;
                $erros['bancos']['motivo'] = "Para o cadastro, é aceito somente contas no Banco do Brasil";
            }
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaEndereco($tipo_cadastro, $id) {
        switch ($tipo_cadastro) {
            case 1:
                $proponente = DbModel::consultaSimples("SELECT * FROM proponente_pf_enderecos WHERE proponente_pf_id = '$id'");
                break;

            case 2:
                $proponente = DbModel::consultaSimples("SELECT * FROM proponente_pj_enderecos WHERE proponente_pj_id = '$id'");
                break;

            case 3:
                $proponente = DbModel::consultaSimples("SELECT * FROM incentivador_pf_enderecos WHERE incentivador_pf_id = '$id'");
                break;

            case 4:
                $proponente = DbModel::consultaSimples("SELECT * FROM incentivador_pj_enderecos WHERE incentivador_pj_id = '$id'");
                break;
        }

        $naoObrigatorios = [
            'complemento'
        ];
        if ($proponente->rowCount() == 0) {
            $erros['enderecos']['bol'] = true;
            $erros['enderecos']['motivo'] = "Proponente não possui endereço cadastrado";

            return $erros;
        } else {
            $proponente = $proponente->fetchObject();
            $erros = ValidacaoModel::retornaMensagem($proponente, $naoObrigatorios);
        }
        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaTelefone($tipo_cadastro, $id) {
        switch ($tipo_cadastro) {
            case 1:
                $proponente = DbModel::consultaSimples("SELECT * FROM proponente_pf_telefones WHERE proponente_pf_id = '$id'");
                break;

            case 2:
                $proponente = DbModel::consultaSimples("SELECT * FROM proponente_pj_telefones WHERE proponente_pj_id = '$id'");
                break;

            case 3:
                $proponente = DbModel::consultaSimples("SELECT * FROM incentivador_pf_telefones WHERE incentivador_pf_id = '$id'");
                break;

            case 4:
                $proponente = DbModel::consultaSimples("SELECT * FROM incentivador_pj_telefones WHERE incentivador_pj_id = '$id'");
                break;
        }

        if ($proponente->rowCount() == 0) {
            $erros['telefones']['bol'] = true;
            $erros['telefones']['motivo'] = "Proponente não possui telefone cadastrado";

            return $erros;
        } else {
            $proponente = $proponente->fetchObject();
            $erros = ValidacaoModel::retornaMensagem($proponente);
        }
        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaDetalhes($idPf)
    {
        $proponente = DbModel::consultaSimples("SELECT * FROM pf_detalhes WHERE pessoa_fisica_id = '$idPf'");

        $naoObrigatorios = [
            'curriculo'
        ];
        if ($proponente->rowCount() == 0) {
            $erros['detalhes']['bol'] = true;
            $erros['detalhes']['motivo'] = "Cadastro de pesssoa física incompleto";

            return $erros;
        } else {
            $proponente = $proponente->fetchObject();
            $erros = ValidacaoModel::retornaMensagem($proponente, $naoObrigatorios);
        }
        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaRepresentante($id)
    {
        $representante = DbModel::getInfo('representante_legais', $id)->fetchObject();

        $erros = ValidacaoModel::retornaMensagem($representante);

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    /**
     * @param array $dados
     * @param bool|array $camposNaoObrigatorios
     * @return bool|array
     */
    protected function retornaMensagem($dados, $camposNaoObrigatorios = false){
        $mensagens = [
            'representante_legal_id' => "Empresa não possui Representante Legal cadastrado",
            'rg' => 'Campo <strong>RG</strong> não foi preenchido',
            'genero_id' => '<strong>Gênero</strong> não selecionado',
            'etnia_id' => '<strong>Etnia</strong> não selecionada',
        ];

        if ($camposNaoObrigatorios) {
                foreach ($dados as $coluna => $valor) {
                    if (!in_array($coluna, $camposNaoObrigatorios)) {
                        if ($valor == "") {
                        $erros[$coluna]['bol'] = true;
                        $erros[$coluna]['motivo'] = $mensagens[$coluna];
                    }
                }
            }
        } else {
            foreach ($dados as $coluna => $valor) {
                if ($valor == "") {
                    $erros[$coluna]['bol'] = true;
                    $erros[$coluna]['motivo'] = $mensagens[$coluna];
                }
            }

        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaArquivos($tipo_cadastro, $origem_id){
        $sql = "SELECT ld.id, ld.documento, a.arquivo
                FROM arquivo_cadastros AS ac
                INNER JOIN lista_documentos AS ld ON ac.lista_documento_id = ld.id
                LEFT JOIN (SELECT * FROM arquivos WHERE publicado = 1 AND cadastro_id = '$origem_id' AND tipo_cadastro_id = '$tipo_cadastro') AS a on ld.id = a.lista_documento_id
                WHERE ac.tipo_cadastro_id = '$tipo_cadastro' AND ld.publicado = '1' AND ac.obrigatorio = '1'";
        $arquivos = DbModel::consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);

        foreach ($arquivos as $arquivo) {
            if ($arquivo->arquivo == null) {
                $erros[$arquivo->documento]['bol'] = true;
                $erros[$arquivo->documento]['motivo'] = "Arquivo <strong>". $arquivo->documento."</strong> não enviado";
            }
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaArquivosFomentos($projeto_id, $tipo_contratacao_id){
        $sql = "SELECT * FROM capac_new.contratacao_documentos AS cd
                INNER JOIN capac_new.fom_lista_documentos AS fld ON cd.fom_lista_documento_id = fld.id
                LEFT JOIN (SELECT fom_lista_documento_id, arquivo FROM capac_new.fom_arquivos WHERE publicado = 1 AND fom_projeto_id = '$projeto_id') as fa ON fld.id = fa.fom_lista_documento_id
                WHERE tipo_contratacao_id = '$tipo_contratacao_id' AND cd.obrigatorio = '1'
                ORDER BY cd.ordem";
        $arquivos = DbModel::consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);

        foreach ($arquivos as $arquivo) {
            if ($arquivo->arquivo == null) {
                $erros[$arquivo->documento]['bol'] = true;
                $erros[$arquivo->documento]['motivo'] = "$arquivo->anexo - $arquivo->documento não enviado";
            }
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    /**
     * @param int $pessoa_fisica_id
     * @param int $validacaoTipo
     * <p>1 - Proponente<br>
     * 2 - Líder<br>
     * 3 - Formação</p>
     * @return array|bool
     */
    protected function validaCadastroModel($cadastro_id, $tipo_cadastro)
    {
        switch ($tipo_cadastro) {
            case 1:
                $naoObrigatorios = [
                    'cooperado',
                ];
                $dados = DbModel::getInfo("proponente_pfs", $cadastro_id)->fetchObject();
                break;

            case 2:
                $dados = DbModel::getInfo("proponente_pjs", $cadastro_id)->fetchObject();
                break;

            case 3:
                $dados = DbModel::getInfo("incentivador_pfs", $cadastro_id)->fetchObject();
                break;

            case 4:
                $dados = DbModel::getInfo("incentivador_pjs", $cadastro_id)->fetchObject();
                break;
        }

        $naoObrigatorios[] = 'data_inscricao';

        $validaEndereco = ValidacaoModel::validaEndereco($tipo_cadastro, $cadastro_id);
        $validaTelefone = ValidacaoModel::validaTelefone($tipo_cadastro, $cadastro_id);
        $erros = ValidacaoModel::retornaMensagem($dados, $naoObrigatorios);

        if ($validaEndereco) {
            if (!isset($erros) || $erros == false) {
                $erros = [];
            }
            $erros = array_merge($erros, $validaEndereco);
        }


        if ($validaTelefone) {
            if (!isset($erros) || $erros == false) {
                $erros = [];
            }
            $erros = array_merge($erros, $validaTelefone);
        }

        $validaArquivos = ValidacaoModel::validaArquivos(intval($tipo_cadastro), $cadastro_id);
        if ($validaArquivos) {
            if (!isset($erros) || $erros == false) {
                $erros = [];
            }
            $erros = array_merge($erros, $validaArquivos);
        }

        if (isset($erros)) {
            return $erros;
        } else {
            return false;
        }
    }
}