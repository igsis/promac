<?php
if ($pedidoAjax) {
    require_once "../models/FormacaoModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/FormacaoModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class FormacaoController extends FormacaoModel
{
    public function listaAbertura()
    {
        return MainModel::consultaSimples("SELECT * FROM form_aberturas WHERE publicado = 1 ORDER BY data_publicacao DESC;")->fetchAll(PDO::FETCH_OBJ);
    }

    public function cadastroEncerrado($ano)
    {
        $now = date('Y-m-d H:i:s');

        $sql = "SELECT data_encerramento FROM form_aberturas WHERE data_abertura IS NOT NULL AND ano_referencia = '$ano' LIMIT 0,1";
        $dataEncerramento = MainModel::consultaSimples($sql)->fetchColumn();

        if ($now <= $dataEncerramento) {
            return false;
        } else {
            return true;
        }
    }

    public function verificaCadastroNoAno($usuario_id, $ano)
    {
        return DbModel::consultaSimples("SELECT id FROM form_cadastros WHERE usuario_id = '$usuario_id' AND ano = '$ano' AND publicado = '1'")->rowCount();
    }

    public function recuperaFormacaoId($pessoa_fisica_id, $ano)
    {
        $idPf = MainModel::decryption($pessoa_fisica_id);
        $form_cadastro_id = DbModel::consultaSimples("SELECT id FROM form_cadastros WHERE pessoa_fisica_id = '$idPf' AND ano = '$ano' AND publicado = '1'")->fetchColumn();

        if ($form_cadastro_id) {
            return MainModel::encryption($form_cadastro_id);
        } else {
            return false;
        }
    }

    public function inserePfCadastro($pagina)
    {
        $idPf = (new PessoaFisicaController)->inserePessoaFisica($pagina, true);
        if ($idPf) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '&id=' . MainModel::encryption($idPf)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/pf_busca'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaPfCadastro($id,$pagina)
    {
        $idPf = (new PessoaFisicaController)->editaPessoaFisica($id,$pagina,true);
        if ($idPf) {
            $_SESSION['origem_id_c'] = $id;
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Pessoa Física editada com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.$pagina.'&id='.$id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/pf_cadastro&id='.$id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function insereFormacao()
    {
        /* executa limpeza nos campos */
        unset($_POST['_method']);
        $dados['pessoa_fisica_id'] = MainModel::decryption($_SESSION['origem_id_c']);
        $cargosAdicionais = ['form_cargo2_id', 'form_cargo3_id'];

        foreach ($_POST as $campo => $post) {
            if (!in_array($campo, $cargosAdicionais)) {
                $dados[$campo] = MainModel::limparString($post);
            } else {
                $dadosAdicionais[$campo] = MainModel::limparString($post);
            }
        }
        /* ./limpeza */
        DbModel::insert("form_cadastros",$dados);
        if (DbModel::connection()->errorCode() == 0) {
            $id = DbModel::connection()->lastInsertId();
            $_SESSION['formacao_id_c'] = MainModel::encryption($id);
            if ((isset($dadosAdicionais)) && ($dadosAdicionais['form_cargo2_id'] != "")) {
                $dadosAdicionais['form_cadastro_id'] = $id;
                if (isset($dadosAdicionais['form_cargo3_id'])) {
                    $dadosAdicionais['form_cargo3_id'] = $dadosAdicionais['form_cargo3_id'] == "" ? null : $dadosAdicionais['form_cargo3_id'];
                }
                DbModel::insert("form_cargos_adicionais",$dadosAdicionais);
            }
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Detalhes do programa',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/formacao_cadastro&idC=' . $_SESSION['formacao_id_c']
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                //@todo: verificar se este location não gera erro
                'location' => SERVERURL . 'formacao/formacao_cadastro'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaFormacao($id)
    {
        unset($_POST['_method']);
        unset($_POST['id']);

        $cargosAdicionais = ['form_cargo2_id', 'form_cargo3_id'];
        $dados = [];

        $idDecrypt = MainModel::decryption($id);
        $dados['id'] = $idDecrypt;

        $cargo2 = self::recuperaFormacao($_SESSION['ano_c'], false, $id)->form_cargo2_id;

        /* executa limpeza nos campos */
        foreach ($_POST as $campo => $post) {
            if (!in_array($campo, $cargosAdicionais)) {
                $dados[$campo] = MainModel::limparString($post);
            } else {
                $dadosAdicionais[$campo] = MainModel::limparString($post);
            }
        }

        /* ./limpeza */
        DbModel::update("form_cadastros",$dados,$idDecrypt);
        if (DbModel::connection()->errorCode() == 0) {
            if ((isset($dadosAdicionais)) && ($dadosAdicionais['form_cargo2_id'] != "")) {
                if ($cargo2) {
                    if (isset($dadosAdicionais['form_cargo3_id'])) {
                        $dadosAdicionais['form_cargo3_id'] = $dadosAdicionais['form_cargo3_id'] == "" ? null : $dadosAdicionais['form_cargo3_id'];
                    }
                    DbModel::updateEspecial("form_cargos_adicionais", $dadosAdicionais, 'form_cadastro_id', $idDecrypt);
                } else {
                    $dadosAdicionais['form_cadastro_id'] = $idDecrypt;
                    if (isset($dadosAdicionais['form_cargo3_id'])) {
                        $dadosAdicionais['form_cargo3_id'] = $dadosAdicionais['form_cargo3_id'] == "" ? null : $dadosAdicionais['form_cargo2_id'];
                    }
                    DbModel::insert("form_cargos_adicionais", $dadosAdicionais);
                }
            } else {
                if ($cargo2) {
                    DbModel::deleteEspecial("form_cargos_adicionais", "form_cadastro_id", $idDecrypt);
                }
            }
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Detalhes do programa',
                'texto' => 'Cadastro editado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'formacao/formacao_cadastro&idC=' . $id
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . 'formacao/formacao_cadastro&idC=' . $id
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function listaFormacao($idUsuario)
    {
        $sqlFormacao = "SELECT fc.*, pf.nome FROM form_cadastros fc
                        INNER JOIN pessoa_fisicas pf on fc.pessoa_fisica_id = pf.id
                        WHERE fc.usuario_id = '$idUsuario' AND fc.publicado = 1";

        $formacoes = MainModel::consultaSimples($sqlFormacao)->fetchAll(PDO::FETCH_OBJ);

        foreach ($formacoes as $key => $formacao) {
            $formacoes[$key]->cargo = parent::getCargo($formacao->form_cargo_id);
            $formacoes[$key]->programa = parent::getPrograma($formacao->programa_id);
            $formacoes[$key]->linguagem = parent::getLinguagem($formacao->linguagem_id);
        }
        return $formacoes;
    }

    public function recuperaFormacao($ano, $idPf = false, $formacao_id = false)
    {
        if ($idPf) {
            $idPf = MainModel::decryption($idPf);
            $busca = "fcad.pessoa_fisica_id = '$idPf' AND fcad.ano = '$ano'";
        } elseif ($formacao_id) {
            $formacao_id = MainModel::decryption($formacao_id);
            $busca = "fcad.id = '$formacao_id'";
        }

        $sql = "SELECT
                    fcad.id,
                    fcad.protocolo,
                    fcad.pessoa_fisica_id,
                    fcad.ano,
                    fcad.regiao_preferencial_id,
                    fcad.data_envio,
                    frp.regiao,
                    fcad.programa_id,
                    fcad.linguagem_id,
                    fcad.form_cargo_id,
                    fcad.usuario_id,
                    fca.form_cargo2_id,
                    fca.form_cargo3_id
                FROM capac_new.form_cadastros AS fcad
                LEFT JOIN form_regioes_preferenciais frp on fcad.regiao_preferencial_id = frp.id
                LEFT JOIN form_cargos_adicionais fca on fcad.id = fca.form_cadastro_id
                WHERE fcad.publicado = 1 AND $busca";
        $formacao = DbModel::consultaSimples($sql)->fetchObject();

        if ($formacao) {
            $formacao->programa = parent::getPrograma($formacao->programa_id);
            $formacao->linguagem = parent::getLinguagem($formacao->linguagem_id);
            $formacao->cargo1 = parent::getCargo($formacao->form_cargo_id);
            $formacao->cargo2 = ($formacao->form_cargo2_id) ? parent::getCargo($formacao->form_cargo2_id) : NULL;
            $formacao->cargo3 = ($formacao->form_cargo3_id) ? parent::getCargo($formacao->form_cargo3_id) : NULL;
        }

        return $formacao;
    }

    public function recuperaAnoReferenciaAtual($idEdital)
    {
        $idEdital = MainModel::decryption($idEdital);
        return MainModel::consultaSimples("SELECT ano_referencia FROM form_aberturas WHERE id='$idEdital'")->fetchColumn();
    }

    public function apagaFormacao($id){
        $apaga = DbModel::apaga("form_cadastros", $id);
        if ($apaga){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto',
                'texto' => 'Projeto apagado com sucesso!',
                'tipo' => 'danger',
                'location' => SERVERURL.'formacao'
            ];
        }else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function apagaDadosBancarios($pessoa_fisica_id, $pagina)
    {
        $apaga = (new PessoaFisicaController)->apagaDadosBancarios($pessoa_fisica_id);
        if ($apaga){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Dados Bancários',
                'texto' => 'Dados Bancários removidos com sucesso',
                'tipo' => 'success',
                'location' => SERVERURL.$pagina.'&id='.$pessoa_fisica_id
            ];
        }else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao apagar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function validaForm($form_cadastro_id, $pessoa_fisica_id, $cargo) {
        $form_cadastro_id = MainModel::decryption($form_cadastro_id);

        $erros['Proponente'] = (new PessoaFisicaController)->validaPf($pessoa_fisica_id, 3);
        $erros['Formação'] = ValidacaoModel::validaFormacao($pessoa_fisica_id);
        $erros['Arquivos'] = ValidacaoModel::validaArquivosFormacao($form_cadastro_id, $cargo);

        return MainModel::formataValidacaoErros($erros);
    }

    public function enviarCadastro($id)
    {
        $id = MainModel::decryption($id);
        $f = MainModel::encryption("F");
        $formacao['protocolo'] = MainModel::gerarProtocolo($id,$f);
        $formacao['data_envio'] = date("Y-m-d H:i:s");

        $update = DbModel::update('form_cadastros',$formacao,$id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Cadastro Enviado',
                'texto' => 'Cadastro enviado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'formacao/inicio',
                'redirecionamento' => SERVERURL.'pdf/resumo_formacao.php?id='.MainModel::encryption($id).'&ano='.$_SESSION['ano_c']
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao enviar o projeto!',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }
}