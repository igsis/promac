<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
} else {
    require_once "./models/ValidacaoModel.php";
}

class ProponentePfModel extends ValidacaoModel
{
    protected function limparStringPF($dados)
    {
        unset($dados['_method']);
        unset($dados['pagina']);

        if (isset($dados['projeto_id'])) {
            unset($dados['projeto_id']);
        }

        /* executa limpeza nos campos */

        foreach ($dados as $campo => $post) {
            $dig = explode("_", $campo)[0];
            if (!empty($dados[$campo]) || ($dig == "pf")) {
                switch ($dig) {
                    case "pf":
                        $campo = substr($campo, 3);
                        $dadosLimpos['pf'][$campo] = MainModel::limparString($post);
                        break;
                    case "en":
                        $campo = substr($campo, 3);
                        $dadosLimpos['en'][$campo] = MainModel::limparString($post);
                        break;
                    case "te":
                        if ($dados[$campo] != '') {
                            $dadosLimpos['telefones'][$campo]['telefone'] = MainModel::limparString($post);
                        }
                        break;
                    case "le":
                        $campo = substr($campo, 3);
                        $dadosLimpos['lei'][$campo] = MainModel::limparString($post);
                        break;
                }
            }
        }

        return $dadosLimpos;
    }
    
    /**
     * @param int $pessoa_fisica_id
     * @param int $validacaoTipo
     * <p>1 - Proponente<br>
     * 2 - Líder<br>
     * 3 - Formação</p>
     * @return array|bool
     */
    protected function validaPfModel($cadastro_id, $tipo_cadastro)
    {
        switch ($tipo_cadastro) {
            case 1:
                $naoObrigatorios = [
                    'data_inscricao',
                    'cooperado',
                ];
                $dados = DbModel::getInfo("proponente_pfs", $cadastro_id)->fetchObject();
                break;

            case 2:
                $naoObrigatorios = [
                    'data_inscricao',
                ];
                $dados = DbModel::getInfo("proponente_pjs", $cadastro_id)->fetchObject();
                break;

            case 3:
                $naoObrigatorios = [
                    'data_inscricao',
                ];
                $dados = DbModel::getInfo("incentivador_pfs", $cadastro_id)->fetchObject();
                break;

            case 4:
                $naoObrigatorios = [
                    'data_inscricao',
                ];
                $dados = DbModel::getInfo("incentivador_pjs", $cadastro_id)->fetchObject();
                break;
        }

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