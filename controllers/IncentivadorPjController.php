<?php
if ($pedidoAjax) {
    require_once "../models/IncentivadorPjModel.php";
} else {
    require_once "./models/IncentivadorPjModel.php";
}

class IncentivadorPjController extends IncentivadorPjModel
{
    /**
     * <p>Função para editar Incentivador Pessoa Jurídica</p>
     * @param $id
     * @param $pagina
     * @param false $retornaId
     * @return string
     */
    public function editaIncentivadorPj($id, $pagina, bool $retornaId = false):string
    {
        $idDecryp = MainModel::decryption($_POST['id']);

        $dadosLimpos = IncentivadorPjModel::limparStringPJ($_POST);

        $edita = DbModel::update('incentivador_pjs', $dadosLimpos['pj'], $idDecryp);
        if ($edita) {

            if (isset($dadosLimpos['en'])) {
                if (count($dadosLimpos['en']) > 0) {
                    $endereco_existe = DbModel::consultaSimples("SELECT * FROM incentivador_pj_enderecos WHERE incentivador_pj_id = '$idDecryp'");
                    if ($endereco_existe->rowCount() > 0) {
                        DbModel::updateEspecial('incentivador_pj_enderecos', $dadosLimpos['en'], "incentivador_pj_id", $idDecryp);
                    } else {
                        $dadosLimpos['en']['incentivador_pj_id'] = $idDecryp;
                        DbModel::insert('incentivador_pj_enderecos', $dadosLimpos['en']);
                    }
                }
            }

            if (count($dadosLimpos['telefones'])>0){
                $telefone_existe = DbModel::consultaSimples("SELECT * FROM incentivador_pj_telefones WHERE incentivador_pj_id = '$idDecryp'");

                if ($telefone_existe->rowCount()>0){
                    DbModel::deleteEspecial('incentivador_pj_telefones', "incentivador_pj_id",$idDecryp);
                }

                foreach ($dadosLimpos['telefones'] as $telefone){
                    $telefone['incentivador_pj_id'] = $idDecryp;
                    DbModel::insert('incentivador_pj_telefones', $telefone);
                }
            }

            if($retornaId){
                return $idDecryp;
            } else{
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Pessoa Jurídica',
                    'texto' => 'Pessoa Jurídica editada com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL.$pagina.'&id='.$id
                ];
                return MainModel::sweetAlert($alerta);
            }
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.$pagina
            ];
            return MainModel::sweetAlert($alerta);
        }
    }

    /**
     * <p>Recupera os dados do Incentivador</p>
     * @param $id
     * @return array|mixed
     */
    public function recuperaIncentivadorPj($id)
    {
        $id = MainModel::decryption($id);
        $pj = DbModel::consultaSimples(
            "SELECT pj.*, pe.*, im.imposto, z.zonas, d.distrito, s.subprefeitura FROM incentivador_pjs AS pj
            LEFT JOIN incentivador_pj_enderecos pe on pj.id = pe.incentivador_pj_id
            LEFT JOIN zonas z on pe.zona_id = z.id
            LEFT JOIN distritos d on pe.distrito_id = d.id
            LEFT JOIN subprefeituras s on pe.subprefeitura_id = s.id
            LEFT JOIN impostos im on pj.imposto_id = im.id
            WHERE pj.id = '$id'
        ");
        $pj = $pj->fetch(PDO::FETCH_ASSOC);
        $telefones = DbModel::consultaSimples("SELECT * FROM incentivador_pj_telefones WHERE incentivador_pj_id = '$id'")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $pj['telefones']['tel_' . $key] = $telefone['telefone'];
        }

        return (object)$pj;
    }

    /**
     * Recupera o id do Incentivador através do CNPJ</p>
     * @param $cnpj
     * @return false|PDOStatement
     */
    public function getCNPJ($cnpj)
    {
        return DbModel::consultaSimples("SELECT id, cnpj FROM incentivador_pjs WHERE cnpj = '$cnpj'");
    }

    /**
     * @param $incentivador_pj_id
     * <p>Recebe o ID do incentivador PJ já decriptado</p>
     * @return array|bool
     */
    public function validaPj($incentivador_pj_id) {
        return IncentivadorPjModel::validaPjModel($incentivador_pj_id);
    }
}