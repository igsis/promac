<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class ProdutorController extends MainModel
{
    public function insereProdutor($post, $atracao_id, $modulo, $oficina = false){
        /* executa limpeza nos campos */
        $atracao_id = MainModel::decryption($atracao_id);
        unset($post['_method']);
        unset($post['modulo']);
        unset($post['atracao_id']);
        $dados = [];
        foreach ($post as $campo => $valor) {
            if ($campo != "modulo") {
                $dados[$campo] = MainModel::limparString($valor);
            }
        }
        /* ./limpeza */

        /* cadastro */
        $insere = DbModel::insert('produtores', $dados);
        if ($insere->rowCount() >= 1) {
            $produtor_id = DbModel::connection()->lastInsertId();
            $dadosUpdate = ["produtor_id" => $produtor_id];
            $atracao = DbModel::update('atracoes', $dadosUpdate, $atracao_id);
            if ($atracao->rowCount() >= 1) {
                if ($oficina) {
                    return true;
                }
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Produtor Cadastrado!',
                    'texto' => 'Produtor cadastrado com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL . $modulo.'/produtor_cadastro&key=' . MainModel::encryption($produtor_id)
                ];
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Oops! Algo deu Errado!',
                    'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                    'tipo' => 'error',
                ];
            }
        } else {
            if ($oficina) {
                return false;
            }
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaProdutor($post, $produtor_id){
        $modulo = $post['modulo'];
        unset($post['_method']);
        unset($post['modulo']);
        unset($post['produtor_id']);
        unset($post['pagina']);
        $dados = [];
        foreach ($post as $campo => $valor) {
            if ($campo != "pagina") {
                $dados[$campo] = MainModel::limparString($valor);
            }
        }

        $edita = DbModel::update('produtores', $dados, $produtor_id);
        if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Produtor Atualizado',
                'texto' => 'Produtor editado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.$modulo.'/produtor_cadastro&key='.MainModel::encryption($produtor_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.$modulo.'/produtor_cadastro&key='.MainModel::encryption($produtor_id)
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaProdutor($id) {
        $id = MainModel::decryption($id);
        return DbModel::getInfo('produtores',$id);
    }
}