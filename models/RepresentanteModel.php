<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
} else {
    require_once "./models/ValidacaoModel.php";
}

class RepresentanteModel extends ValidacaoModel
{
    protected function limparStringRepresentante($dados)
    {
        unset($dados['_method']);
        unset($dados['pagina']);

        if (isset($dados['projeto_id'])) {
            unset($dados['projeto_id']);
        }

        /* executa limpeza nos campos */

        foreach ($dados as $campo => $post) {
            $dig = explode("_", $campo)[0];
            if (!empty($dados[$campo]) || ($dig == "rep")) {
                switch ($dig) {
                    case "rep":
                        $campo = substr($campo, 3);
                        $dadosLimpos['rep'][$campo] = MainModel::limparString($post);
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
                    case "lei":
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
    protected function validaPfModel($pessoa_fisica_id, $validacaoTipo, $evento_id, $tipo_documentos = null)
    {
        $pf = DbModel::getInfo("pessoa_fisicas", $pessoa_fisica_id)->fetchObject();

        switch ($validacaoTipo) {
            case 1:
                $naoObrigatorios = [
                    'nome_artistico',
                    'ccm',
                    'cpf',
                    'passaporte',
                ];

                $validaBanco = ValidacaoModel::validaBanco(1, $pessoa_fisica_id);
                $validaEndereco = ValidacaoModel::validaEndereco(1, $pessoa_fisica_id);
                break;

            case 2:
                $naoObrigatorios = [
                    'nome_artistico',
                    'passaporte',
                    'ccm',
                    'data_nascimento',
                    'nacionalidade_id',
                ];
                break;

            case 3: //formação
                $naoObrigatorios = [
                    'nome_artistico',
                    'ccm',
                    'passaporte',
                ];

                $validaBanco = ValidacaoModel::validaBancoFormacao($pessoa_fisica_id);
                $validaEndereco = ValidacaoModel::validaEndereco(1, $pessoa_fisica_id);
                $validaDetalhes = ValidacaoModel::validaDetalhes($pessoa_fisica_id);
                break;
            default:
                $naoObrigatorios = [];
                break;
        }

        $validaTelefone = ValidacaoModel::validaTelefone(1, $pessoa_fisica_id);

        if ($pf->passaporte != null) {
            array_push($naoObrigatorios, 'rg');
        }


        $erros = ValidacaoModel::retornaMensagem($pf, $naoObrigatorios);

        if ($validacaoTipo == 3) {
            if ($validaDetalhes) {
                if (!isset($erros) || $erros == false) {
                    $erros = [];
                }
                $erros = array_merge($erros, $validaDetalhes);
            }
        }

        if ($validacaoTipo == 1 || $validacaoTipo == 3) {
            if ($validaEndereco) {
                if (!isset($erros) || $erros == false) {
                    $erros = [];
                }
                $erros = array_merge($erros, $validaEndereco);
            }
        }

        if (($validacaoTipo == 1) || $validacaoTipo == 3) {
            if ($validaBanco) {
                if (!isset($erros) || $erros == false) {
                    $erros = [];
                }
                $erros = array_merge($erros, $validaBanco);
            }
        }

        if ($validaTelefone) {
            if (!isset($erros) || $erros == false) {
                $erros = [];
            }
            $erros = array_merge($erros, $validaTelefone);
        }

        if ($evento_id != null) {
            if (MainModel::verificaCenica(MainModel::encryption($evento_id))) {
                if (!isset($erros) || $erros == false) {
                    $erros = [];
                }
                $erros['drt']['bol'] = true;
                $erros['drt']['motivo'] = 'Proponente não possui DRT cadastrado';
            };
        }

        $validaArquivos = ValidacaoModel::validaArquivos(intval($tipo_documentos), $pessoa_fisica_id);
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