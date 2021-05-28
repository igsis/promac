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

    protected function validaEndereco($tipoProponente, $id) {
        if ($tipoProponente == 1) {
            $proponente = DbModel::consultaSimples("SELECT * FROM pf_enderecos WHERE pessoa_fisica_id = '$id'");
        } else {
            $proponente = DbModel::consultaSimples("SELECT * FROM pj_enderecos WHERE pessoa_juridica_id = '$id'");
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

    protected function validaTelefone($tipoProponente, $id) {
        if ($tipoProponente == 1) {
            $proponente = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$id'");
        } else {
            $proponente = DbModel::consultaSimples("SELECT * FROM pj_telefones WHERE pessoa_juridica_id = '$id'");
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

    protected function validaFormacao($idPf)
    {
        $idPf = MainModel::decryption($idPf);
        $formacao = DbModel::consultaSimples("SELECT * FROM form_cadastros WHERE pessoa_fisica_id = '$idPf'");

         if ($formacao->rowCount() == 0) {
            $erros['detalhes']['bol'] = true;
            $erros['detalhes']['motivo'] = "Detalhes do programa não inseridos!";

            return $erros;
        } else {
             $naoObrigatorios = [
                 'protocolo',
                 'data_envio'
             ];
            $formacao = $formacao->fetchObject();
            $erros = ValidacaoModel::retornaMensagem($formacao, $naoObrigatorios);
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
            'nome_evento' => "Nome do evento não preenchido",
            'sinopse' => "Sinopse do evento não preenchida",
            'representante_legal1_id' => "Empresa não possui Representante Legal cadastrado",
            'produtor_id' => "Atração não possui Produtor cadastrado",
            'instituicao' => "Instituição não foi preenchido",
            'site' => "Site não foi preenchido",
            'valor_projeto' => "Valor do projeto não foi preenchido",
            'duracao' => "Duração não foi preenchido",
            'nucleo_artistico' => "Nucleo Artistico não foi preenchido",
            'representante_nucleo' => "Representante do Nucleo Artistico não foi preenchido",
            'rg' => 'RG não foi preenchido',
            'nacionalidade_id' => 'A nacionalidade não foi selecionada'
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

    protected function validaArquivos($tipoDocumento, $origem_id){
        $sql = "SELECT ld.id, ld.documento, a.arquivo
                FROM lista_documentos AS ld
                LEFT JOIN (SELECT * FROM arquivos WHERE publicado = 1 AND origem_id = '$origem_id') AS a on ld.id = a.lista_documento_id
                WHERE ld.tipo_documento_id = '$tipoDocumento' AND ld.publicado = '1'";
        $arquivos = DbModel::consultaSimples($sql)->fetchAll(PDO::FETCH_OBJ);

        foreach ($arquivos as $arquivo) {
            if ($arquivo->arquivo == null) {
                $erros[$arquivo->documento]['bol'] = true;
                $erros[$arquivo->documento]['motivo'] = $arquivo->documento." não enviado";
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

    protected function validaArquivosFormacao($form_cadastro_id, $cargo){
        $cargos = [4, 5];
        if (in_array($cargo, $cargos)) {
            $busca = "AND fld.documento NOT LIKE '%Coordenação%'";
        } else {
            $busca = "";
        }
        $sql = "SELECT * FROM formacao_lista_documentos AS fld
                WHERE fld.publicado = 1 AND fld.obrigatorio = '1' ". $busca ." ORDER BY fld.id";
        $arquivos = DbModel::consultaSimples($sql, true)->fetchAll(PDO::FETCH_OBJ);
        foreach ($arquivos as $arquivo) {
            $idsArquivos[] = $arquivo->id;
        }

        $arquivosEnviados = DbModel::consultaSimples("SELECT form_lista_documento_id FROM form_arquivos WHERE form_cadastro_id = '$form_cadastro_id' AND publicado = 1")->fetchAll(PDO::FETCH_COLUMN);

        foreach ($idsArquivos as $key => $valor) {
            if (!in_array($valor, $arquivosEnviados)) {
                $erros[$arquivos[$key]->documento]['bol'] = true;
                $erros[$arquivos[$key]->documento]['motivo'] = $arquivos[$key]->documento." não enviado";
            }
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }
}