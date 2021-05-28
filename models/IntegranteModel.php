<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}

class IntegranteModel extends MainModel
{
    protected function atualizaColunaNucleo($projeto_id)
    {
        $sql = "SELECT fna.nome, fna.rg, fna.cpf FROM fom_projeto_nucleo_artistico fpna INNER JOIN integrantes fna ON fpna.integrante_id = fna.id WHERE fpna.fom_projeto_id = '$projeto_id' ORDER BY fna.nome";
        $integrantes = DbModel::consultaSimples($sql);

        if ($integrantes->rowCount() > 0) {
            $dados['nucleo_artistico'] = '';
            foreach ($integrantes->fetchAll(PDO::FETCH_OBJ) as $integrante) {
                $dados['nucleo_artistico'] .= "$integrante->nome CPF: $integrante->cpf RG: $integrante->rg \n";
            }
        } else {
            $dados['nucleo_artistico'] = 'Não há integrantes de núcleo cadastrados';
        }

        DbModel::update('fom_projetos', $dados, $projeto_id);
    }
    protected function cadastraIntegranteProjeto($integrante_id)
    {
        $projeto_id = MainModel::decryption($_SESSION['projeto_c']);

        $integrantes = DbModel::consultaSimples("SELECT integrante_id FROM fom_projeto_nucleo_artistico WHERE fom_projeto_id = '$projeto_id' AND integrante_id = '$integrante_id'")->rowCount();
        $dados = [
            'fom_projeto_id' => $projeto_id,
            'integrante_id' => $integrante_id
        ];
        if ($integrantes == 0) {
            $insert = DbModel::insert('fom_projeto_nucleo_artistico', $dados);
            if ($insert) {
                $this->atualizaColunaNucleo($projeto_id);
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Núcleo artístico',
                    'texto' => 'Integrante cadastrado com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL . 'fomentos/nucleo_artistico_lista'
                ];
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Erro ao salvar!',
                    'tipo' => 'error',
                ];
            }
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Integrante já inserido!',
                'texto' => 'Integrante com este CPF já está inserido no projeto',
                'tipo' => 'error',
            ];
        }

        return $alerta;
    }
}