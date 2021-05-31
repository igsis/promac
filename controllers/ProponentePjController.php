<?php
if ($pedidoAjax) {
    require_once "../models/ProponentePjModel.php";
} else {
    require_once "./models/ProponentePjModel.php";
}

class ProponentePjController extends ProponentePjModel
{
    /**
     * <p>Função para inserir Proponente Pessoa Jurídica</p>
     * @param $pagina
     * @param false $retornaId
     * @return string
     */
    public function insereProponentePj($pagina, $retornaId = false):string
    {
        $dadosLimpos = ProponentePjModel::limparStringPJ($_POST);

        /* cadastro */
        $insere = DbModel::insert('proponente_pjs', $dadosLimpos['pj']);
        if ($insere->rowCount()>0) {
            $id = DbModel::connection()->lastInsertId();

            if (count($dadosLimpos['en'])>0){
                $dadosLimpos['en']['proponente_pj_id'] = $id;
                DbModel::insert('proponente_pj_enderecos', $dadosLimpos['en']);
            }

            if (count($dadosLimpos['telefones'])>0){
                foreach ($dadosLimpos['telefones'] as $telefone){
                    $telefone['proponente_pj_id'] = $id;
                    DbModel::insert('proponente_pj_telefones', $telefone);
                }
            }

            if($retornaId){
                return $id;
            } else{
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Pessoa Jurídica',
                    'texto' => 'Pessoa Jurídica cadastrada com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL.$pagina.'/pj_cadastro&id='.MainModel::encryption($id)
                ];
                return MainModel::sweetAlert($alerta);
            }
        }
        else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.$pagina.'/proponente'
            ];
            return MainModel::sweetAlert($alerta);
        }
        /* ./cadastro */
    }

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
                    'location' => SERVERURL.$pagina.'/pj_cadastro&id='.$id
                ];
                return MainModel::sweetAlert($alerta);
            }
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.$pagina.'/proponente'
            ];
            return MainModel::sweetAlert($alerta);
        }
    }

    public function recuperaPessoaJuridica($id)
    {
        $id = MainModel::decryption($id);
        $pj = DbModel::consultaSimples(
            "SELECT * FROM proponente_pjs AS pj
            LEFT JOIN proponente_pj_enderecos pe on pj.id = pe.proponente_pj_id
            WHERE pj.id = '$id'
        ");
        $pj = $pj->fetch(PDO::FETCH_ASSOC);
        $telefones = DbModel::consultaSimples("SELECT * FROM proponente_pj_telefones WHERE proponente_pj_id = '$id'")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $pj['telefones']['tel_' . $key] = $telefone['telefone'];
        }

        return $pj;
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
    public function validaPj($proponente_pj_id) {
        return ProponentePjModel::validaPjModel($proponente_pj_id);
    }
}