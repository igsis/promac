<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
    require_once "../controllers/FomentoController.php";
} else {
    require_once "./models/ValidacaoModel.php";
    require_once "./controllers/FomentoController.php";
}


class ProjetoModel extends ValidacaoModel
{
    public function updatePjProjeto($pessoa_tipo_id)
    {
        $idProjeto = MainModel::decryption($_SESSION['projeto_c']);
        $id_pessoa = MainModel::decryption($_SESSION['origem_id_c']);
        if ($pessoa_tipo_id == 2) {
            $dados = [
                "pessoa_juridica_id" => $id_pessoa
            ];
        } else {
            $dados = [
                "pessoa_fisica_id" => $id_pessoa
            ];
        }
        $projeto = MainModel::update('fom_projetos', $dados, $idProjeto);
        if ($projeto) {
            return true;
        } else {
            return false;
        }
//        MainModel::updateEspecial("fom_projetos","$dados","id",$idProjeto);
    }

    protected function validaProjetoModal($idProjeto){
        $proj = DbModel::getInfo('fom_projetos',$idProjeto)->fetchObject();
        $naoObrigados = [
          'pessoa_fisica_id',
          'pessoa_juridica_id',
          'protocolo',
          'data_inscricao'
        ];

        $erros = ValidacaoModel::retornaMensagem($proj,$naoObrigados);

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaArquivosProjeto($projeto_id, $edital_id) {
        $tipo_contratacao_id = (new FomentoController)->recuperaTipoContratacao((int) $edital_id);
        $validaArquivos = ValidacaoModel::validaArquivosFomentos($projeto_id, $tipo_contratacao_id);
        if ($validaArquivos) {
            if (!isset($erros) || $erros == false) { $erros = []; }
            $erros = array_merge($erros, $validaArquivos);
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    private function validaPf($pessoa_fisica_id)
    {
        $pf = DbModel::getInfo('pessoa_fisicas', $pessoa_fisica_id)->fetchObject();
        $naoObrigatorios = [
            'nome_artistico',
            'rg',
            'passaporte',
            'ccm',
            'nacionalidade_id',
        ];

        $erros = ValidacaoModel::retornaMensagem($pf, $naoObrigatorios);

        $validaEndereco = ValidacaoModel::validaEndereco(1, $pessoa_fisica_id);
        $validaTelefone = ValidacaoModel::validaTelefone(1, $pessoa_fisica_id);

        if ($validaEndereco) {
            if (!isset($erros) || $erros == false) { $erros = []; }
            $erros = array_merge($erros, $validaEndereco);
        }
        if ($validaTelefone) {
            if (!isset($erros) || $erros == false) { $erros = []; }
            $erros = array_merge($erros, $validaTelefone);
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    private function validaPj($pessoa_juridica_id)
    {
        $pj = DbModel::getInfo('pessoa_juridicas', $pessoa_juridica_id)->fetchObject();
        $naoObrigatorios = [
            'ccm',
            'representante_legal2_id'
        ];

        $erros = ValidacaoModel::retornaMensagem($pj, $naoObrigatorios);

        $validaEndereco = ValidacaoModel::validaEndereco(2, $pessoa_juridica_id);
        $validaTelefone = ValidacaoModel::validaTelefone(2, $pessoa_juridica_id);

        if ($validaEndereco) {
            if (!isset($erros) || $erros == false) { $erros = []; }
            $erros = array_merge($erros, $validaEndereco);
        }
        if ($validaTelefone) {
            if (!isset($erros) || $erros == false) { $erros = []; }
            $erros = array_merge($erros, $validaTelefone);
        }


        if ($pj->representante_legal1_id != null){
            $representanteLegal1 = ValidacaoModel::validaRepresentante($pj->representante_legal1_id);
            if ($representanteLegal1) {
                if (!isset($erros) || $erros == false) { $erros = []; }
                $erros = array_merge($erros, $representanteLegal1);
            }
        }

        if ($pj->representante_legal2_id != null){
            $representanteLegal2 = ValidacaoModel::validaRepresentante($pj->representante_legal2_id);
            if ($representanteLegal2) {
                if (!isset($erros) || $erros == false) { $erros = []; }
                $erros = array_merge($erros, $representanteLegal2);
            }
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }

    protected function validaProponenteProjeto($projeto_id) {
        $projeto = DbModel::getInfo('fom_projetos', $projeto_id)->fetchObject();

        if ($projeto->pessoa_tipo_id == 1) {
            $proponente = DbModel::getInfo('pessoa_fisicas', $projeto->pessoa_fisica_id)->fetchObject();
            $erros = self::validaPf($proponente->id);
        } else {
            $proponente = DbModel::getInfo('pessoa_juridicas', $projeto->pessoa_juridica_id)->fetchObject();
            $erros = self::validaPj($proponente->id);
        }

        return $erros;
    }

    protected function getTipoPessoa($edital_id) {
        return DbModel::consultaSimples("SELECT pessoa_tipos_id FROM fom_editais WHERE id = '$edital_id'")->fetchColumn();
    }
}