<?php
if ($pedidoAjax) {
    require_once "../models/IncentivadorPfModel.php";
} else {
    require_once "./models/IncentivadorPfModel.php";
}

class IncentivadorPfController extends IncentivadorPfModel
{
    /**
     * <p>Função para inserir Incentivador Pessoa Física</p>
     * @param $pagina
     * @param false $retornaId
     * @return string
     */
    public function insereIncentivadorPf($pagina, bool $retornaId = false):string
    {
        $dadosLimpos = IncentivadorPfModel::limparStringPf($_POST);

        /* cadastro */
        $insere = DbModel::insert('incentivador_pfs', $dadosLimpos['pf']);
        if ($insere->rowCount()>0) {
            $id = DbModel::connection()->lastInsertId();

            if (isset($dadosLimpos['en'])) {
                if (count($dadosLimpos['en']) > 0) {
                    $dadosLimpos['en']['incentivador_pf_id'] = $id;
                    DbModel::insert('incentivador_pf_enderecos', $dadosLimpos['en']);
                }
            }

            if (count($dadosLimpos['telefones'])>0){
                foreach ($dadosLimpos['telefones'] as $telefone){
                    $telefone['incentivador_pf_id'] = $id;
                    DbModel::insert('incentivador_pf_telefones', $telefone);
                }
            }

            if($retornaId){
                return $id;
            } else{
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Pessoa Física',
                    'texto' => 'Pessoa Física cadastrada com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL.$pagina.'&id='.MainModel::encryption($id)
                ];
                return MainModel::sweetAlert($alerta);
            }
        }
        else {
            $pagina = explode("/",$pagina);
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.$pagina[0].'/incentivador'
            ];
        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /**
     * <p>Função para editar Incentivador Pessoa Física</p>
     * @param int|string $id
     * @param $pagina
     * @param false $retornaId
     * @return string
     */
    public function editaIncentivadorPf($id, $pagina, bool $retornaId = false):string
    {
        $idDecryp = MainModel::decryption($id);

        $dadosLimpos = IncentivadorPfModel::limparStringPF($_POST);

        $edita = DbModel::update('incentivador_pfs', $dadosLimpos['pf'], $idDecryp);
        if ($edita) {

            if (isset($dadosLimpos['en'])) {
                if (count($dadosLimpos['en']) > 0) {
                    $endereco_existe = DbModel::consultaSimples("SELECT * FROM incentivador_pf_enderecos WHERE incentivador_pf_id = '$idDecryp'");
                    if ($endereco_existe->rowCount() > 0) {
                        DbModel::updateEspecial('incentivador_pf_enderecos', $dadosLimpos['en'], "incentivador_pf_id", $idDecryp);
                    } else {
                        $dadosLimpos['en']['incentivador_pf_id'] = $idDecryp;
                        DbModel::insert('incentivador_pf_enderecos', $dadosLimpos['en']);
                    }
                }
            }

            if (isset($dadosLimpos['telefones'])){
                if (count($dadosLimpos['telefones'])>0){
                    $telefone_existe = DbModel::consultaSimples("SELECT * FROM incentivador_pf_telefones WHERE incentivador_pf_id = '$idDecryp'");

                    if ($telefone_existe->rowCount()>0){
                        DbModel::deleteEspecial('incentivador_pf_telefones', "incentivador_pf_id",$idDecryp);
                    }
                    foreach ($dadosLimpos['telefones'] as $telefone){
                        $telefone['incentivador_pf_id'] = $idDecryp;
                        DbModel::insert('incentivador_pf_telefones', $telefone);
                    }
                }
            }

            if($retornaId){
                return $idDecryp;
            } else{
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Pessoa Física',
                    'texto' => 'Pessoa Física editada com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL.$pagina.'&id='.$id
                ];
                return MainModel::sweetAlert($alerta);
            }

        } else {
            $pagina = explode("/",$pagina);
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.$pagina[0].'/incentivador'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaIncentivadorPf($id)
    {
        $id = MainModel::decryption($id);
        $pf = DbModel::consultaSimples(
            "SELECT pf.*, n2.nacionalidade, ec.estado_civil, ge.genero, et.etnia, pe.*
            FROM incentivador_pfs AS pf
            LEFT JOIN nacionalidades n2 on pf.nacionalidade_id = n2.id
            LEFT JOIN estado_civis ec on pf.estado_civil_id = ec.id
            LEFT JOIN generos ge on pf.genero_id = ge.id
            LEFT JOIN etnias et on pf.etnia_id = et.id
            LEFT JOIN incentivador_pf_enderecos pe on pf.id = pe.incentivador_pf_id
            WHERE pf.id = '$id'");

        $pf = $pf->fetch(PDO::FETCH_ASSOC);
        $telefones = DbModel::consultaSimples("SELECT * FROM incentivador_pf_telefones WHERE incentivador_pf_id = '$id'")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $pf['telefones']['tel_'.$key] = $telefone['telefone'];
        }
        return (object)$pf;
    }

    /**
     * <p>Recupera o id do Incentivador através do CPF</p>
     * @param $cpf
     * @return false|PDOStatement
     */
    public function getCPF($cpf){
        return DbModel::consultaSimples("SELECT id, cpf FROM incentivador_pfs WHERE cpf = '$cpf'");
    }

    /**
     * @param int|string $incentivador_pf_id
     * @param int $validacaoTipo <p>Deve conter o valor 1 para validação de pessoa física, 2 para validação de líder e 3 para formação</p>
     * @param int|null $evento_id
     * @return array|bool
     */
    public function validaPf($incentivador_pf_id, $validacaoTipo, $evento_id = null, $tipo_documentos = null){
        $tipo = gettype($incentivador_pf_id);
        if ($tipo == "string") {
            $incentivador_pf_id = MainModel::decryption($incentivador_pf_id);
        }
        return IncentivadorPfModel::validaPfModel($incentivador_pf_id, $validacaoTipo, $evento_id,$tipo_documentos);
    }

}