<?php
if ($pedidoAjax) {
    require_once "../models/ProponentePjModel.php";
} else {
    require_once "./models/ProponentePjModel.php";
}

class ProponentePjController extends ProponentePjModel
{
    /**
     * <p>Função para editar Proponente Pessoa Jurídica</p>
     * @param $id
     * @param $pagina
     * @param false $retornaId
     * @return string
     */
    public function editaProponentePj($id, $pagina, $retornaId = false):string
    {
        $idDecryp = MainModel::decryption($_POST['id']);

        $dadosLimpos = ProponentePjModel::limparStringPJ($_POST);
        $dadosLimpos['pj']['cooperativa'] = $dadosLimpos['pj']['cooperativa'] ?? 0;
        $dadosLimpos['pj']['mei'] = $dadosLimpos['pj']['mei'] ?? 0;

        $edita = DbModel::update('proponente_pjs', $dadosLimpos['pj'], $idDecryp);
        if ($edita) {

            if (isset($dadosLimpos['en'])) {
                if (count($dadosLimpos['en']) > 0) {
                    $endereco_existe = DbModel::consultaSimples("SELECT * FROM proponente_pj_enderecos WHERE proponente_pj_id = '$idDecryp'");
                    if ($endereco_existe->rowCount() > 0) {
                        DbModel::updateEspecial('proponente_pj_enderecos', $dadosLimpos['en'], "proponente_pj_id", $idDecryp);
                    } else {
                        $dadosLimpos['en']['proponente_pj_id'] = $idDecryp;
                        DbModel::insert('proponente_pj_enderecos', $dadosLimpos['en']);
                    }
                }
            }

            if (count($dadosLimpos['telefones'])>0){
                $telefone_existe = DbModel::consultaSimples("SELECT * FROM proponente_pj_telefones WHERE proponente_pj_id = '$idDecryp'");

                if ($telefone_existe->rowCount()>0){
                    DbModel::deleteEspecial('proponente_pj_telefones', "proponente_pj_id",$idDecryp);
                }

                foreach ($dadosLimpos['telefones'] as $telefone){
                    $telefone['proponente_pj_id'] = $idDecryp;
                    DbModel::insert('proponente_pj_telefones', $telefone);
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
     * @param $id
     * @return object
     */
    public function recuperaProponentePj($id)
    {
        $id = MainModel::decryption($id);
        $pj = DbModel::consultaSimples(
            "SELECT pj.*, pe.*, z.zonas, d.distrito, s.subprefeitura FROM proponente_pjs AS pj
            LEFT JOIN proponente_pj_enderecos pe on pj.id = pe.proponente_pj_id
            LEFT JOIN zonas z on pe.zona_id = z.id
            LEFT JOIN distritos d on pe.distrito_id = d.id
            LEFT JOIN subprefeituras s on pe.subprefeitura_id = s.id
            WHERE pj.id = '$id'
        ");
        $pj = $pj->fetch(PDO::FETCH_ASSOC);
        $telefones = DbModel::consultaSimples("SELECT * FROM proponente_pj_telefones WHERE proponente_pj_id = '$id'")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $pj['telefones']['tel_' . $key] = $telefone['telefone'];
        }

        return (object)$pj;
    }

    /**
     * @param $cnpj
     * @return false|PDOStatement
     */
    public function getCNPJ($cnpj)
    {
        return DbModel::consultaSimples("SELECT id, cnpj FROM proponente_pjs WHERE cnpj = '$cnpj'");
    }

    /**
     * @param $proponente_pj_id
     * <p>Recebe o ID do proponente PJ já decriptado</p>
     * @return array|bool
     */
    public function validaPj($cadastro_id, $tipo_cadastro_id){
        return ProponentePjModel::validaCadastroModel($cadastro_id, $tipo_cadastro_id);
    }
}