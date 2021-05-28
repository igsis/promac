<?php
if ($pedidoAjax) {
    require_once "../models/IntegranteModel.php";
} else {
    require_once "./models/IntegranteModel.php";
}

class IntegranteController extends IntegranteModel
{
    public function recuperaIntegranteCpf($cpf)
    {
        return DbModel::getInfoEspecial('integrantes', 'cpf', $cpf)->fetch();
    }

    public function recuperaIntegrante($id)
    {
        $id = MainModel::decryption($id);
        return DbModel::getInfo('integrantes', $id)->fetch();
    }

    public function listaNucleo($projeto_id)
    {
        $projeto_id = MainModel::decryption($projeto_id);
        return DbModel::consultaSimples("SELECT fna.id, fna.nome, fna.rg, fna.cpf FROM fom_projeto_nucleo_artistico fpna INNER JOIN integrantes fna ON fpna.integrante_id = fna.id WHERE fpna.fom_projeto_id = '$projeto_id'")->fetchAll(PDO::FETCH_OBJ);
    }

    public function cadastraIntegrante($fomentos = false)
    {
        unset($_POST['_method']);
        $dados = [];

        foreach ($_POST as $campo => $dado) {
            $dados[$campo] = MainModel::limparString($dado);
        }

        $insere = DbModel::insert("integrantes", $dados);
        if ($insere->rowCount() >= 1) {
            $integrante_id = DbModel::connection()->lastInsertId();
            if($fomentos) {
                $alerta = parent::cadastraIntegranteProjeto($integrante_id);
            }
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaIntegrante($id, $fomentos = false)
    {
        $dados=[];
        $integrante_id = MainModel::decryption($id);
        unset($_POST['_method']);
        unset($_POST['id']);

        foreach ($_POST as $campo => $dado) {
            $dados[$campo] = MainModel::limparString($dado);
        }

        $edita = DbModel::update('integrantes', $dados, $integrante_id);
        if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            if($fomentos) {
                $alerta = parent::cadastraIntegranteProjeto($integrante_id);
            }
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'fomentos/nucleo_artistico_cadastro&id='.MainModel::encryption($integrante_id)
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function apagaIntegrante($id, $fomentos = false)
    {
        $integrante_id = MainModel::decryption($id);

        if ($fomentos) {
            $tabela = 'fom_projeto_nucleo_artistico';
            $coluna = 'fom_projeto_id';
            $origem_id = MainModel::decryption($_SESSION['projeto_c']);
            $pagina = 'fomentos/nucleo_artistico_lista';
        }

        $sql = "DELETE FROM $tabela WHERE $coluna = '$origem_id' AND integrante_id = '$integrante_id'";

        $delete = DbModel::consultaSimples($sql);
        if ($delete->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            if ($fomentos) {
                parent::atualizaColunaNucleo($origem_id);
            }
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Núcleo artístico',
                'texto' => 'Integrante excluído com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.$pagina
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.$pagina
            ];
        }
        return MainModel::sweetAlert($alerta);
    }
}