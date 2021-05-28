<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
} else {
    require_once "./models/ValidacaoModel.php";
}

class PessoaFisicaModel extends ValidacaoModel
{
    protected function limparStringPF($dados)
    {
        unset($dados['_method']);
        unset($dados['pagina']);

        if (isset($dados['atracao_id'])) {
            unset($dados['atracao_id']);
        }

        if (isset($dados['pedido_id_c'])) {
            unset($dados['pedido_id_c']);
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
                    case "bc":
                        $campo = substr($campo, 3);
                        $dadosLimpos['bc'][$campo] = MainModel::limparString($post);
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
                    case "ni":
                        $campo = substr($campo, 3);
                        $dadosLimpos['ni'][$campo] = MainModel::limparString($post);
                        break;
                    case "dr":
                        $campo = substr($campo, 3);
                        $dadosLimpos['dr'][$campo] = MainModel::limparString($post);
                        break;
                    case "of":
                        $campo = substr($campo, 3);
                        $dadosLimpos['of'][$campo] = MainModel::limparString($post);
                        break;
                    case "dt":
                        $campo = substr($campo, 3);
                        $dadosLimpos['dt'][$campo] = MainModel::limparString($post);
                        break;
                    case "fm":
                        $campo = substr($campo, 3);
                        $dadosLimpos['fm'][$campo] = MainModel::limparString($post);
                        break;
                }
            }
        }

        return $dadosLimpos;
    }

    protected function getDadosAdcFom($dados)
    {
        if (count($dados) < 3):
            $sql = "SELECT `{$dados[0]}` FROM `{$dados[0]}s` WHERE id = '{$dados[1]}'";
        else:
            $sql = "SELECT {$dados[0]} FROM `{$dados[1]}` WHERE id = '{$dados[2]}'";
        endif;

            return $this->consultaSimples($sql)->fetch(PDO::FETCH_COLUMN);
        }

    protected function getFomDados($id)
    {
        $sql = "SELECT
                    pf.id,
                    pf.nome,
                    pf.rg,
                    pf.cpf,
                    pf.data_nascimento,
                    pf.email,
                    pe.*,
                    fpd.rede_social,
                    fpd.subprefeitura_id,
                    fpd.genero_id,
                    fpd.etnia_id,
                    fpd.grau_instrucao_id
                FROM pessoa_fisicas AS pf
                LEFT JOIN pf_enderecos pe on pf.id = pe.pessoa_fisica_id
                LEFT JOIN fom_pf_dados AS fpd on pf.id = fpd.pessoa_fisicas_id
                WHERE pf.id = '$id'";

        $dados = DbModel::consultaSimples($sql)->fetch(PDO::FETCH_ASSOC);

        $telefones = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$id'")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $dados['telefones']['tel_' . $key] = $telefone['telefone'];
        }

        return $dados;
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