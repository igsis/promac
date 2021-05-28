<?php
if ($pedidoAjax) {
    require_once "../models/PessoaJuridicaModel.php";
    require_once "../controllers/PedidoController.php";
} else {
    require_once "./models/PessoaJuridicaModel.php";
    require_once "./controllers/PedidoController.php";
}

class PessoaJuridicaController extends PessoaJuridicaModel
{
    public function inserePessoaJuridica($pagina,$retornaId = false){

        $dadosLimpos = PessoaJuridicaModel::limparStringPJ($_POST);

        /* cadastro */
        $insere = DbModel::insert('pessoa_juridicas', $dadosLimpos['pj']);
        if ($insere->rowCount()>0) {
            $id = DbModel::connection()->lastInsertId();

            if (isset($dadosLimpos['bc'])) {
                if (count($dadosLimpos['bc']) > 0) {
                    $dadosLimpos['bc']['pessoa_juridica_id'] = $id;
                    DbModel::insert('pj_bancos', $dadosLimpos['bc']);
                }
            }

            if (isset($dadosLimpos['of'])) {
                if (count($dadosLimpos['of']) > 0) {
                    $dadosLimpos['of']['pessoa_juridica_id'] = $id;
                    DbModel::insert('pj_oficinas', $dadosLimpos['of']);
                }
            }

            if (count($dadosLimpos['en'])>0){
                $dadosLimpos['en']['pessoa_juridica_id'] = $id;
                DbModel::insert('pj_enderecos', $dadosLimpos['en']);
            }

            if (count($dadosLimpos['telefones'])>0){
                foreach ($dadosLimpos['telefones'] as $telefone){
                    $telefone['pessoa_juridica_id'] = $id;
                    DbModel::insert('pj_telefones', $telefone);
                }
            }

            /*if ($_SESSION['modulo_c'] >= 8){ //fomento
                $_SESSION['origem_id_c'] = MainModel::encryption($id);
            }*/

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

    /* edita */
    public function editaPessoaJuridica($id,$pagina,$retornaId = false){
        $idDecryp = MainModel::decryption($_POST['id']);

        $dadosLimpos = PessoaJuridicaModel::limparStringPJ($_POST);

        $edita = DbModel::update('pessoa_juridicas', $dadosLimpos['pj'], $idDecryp);
        if ($edita) {

            if (isset($dadosLimpos['bc'])) {
                if (count($dadosLimpos['bc']) > 0) {
                    $banco_existe = DbModel::consultaSimples("SELECT * FROM pj_bancos WHERE pessoa_juridica_id = '$idDecryp'");
                    if ($banco_existe->rowCount() > 0) {
                        DbModel::updateEspecial('pj_bancos', $dadosLimpos['bc'], "pessoa_juridica_id", $idDecryp);
                    } else {
                        $dadosLimpos['bc']['pessoa_juridica_id'] = $idDecryp;
                        DbModel::insert('pj_bancos', $dadosLimpos['bc']);
                    }
                }
            }

            if (isset($dadosLimpos['en'])) {
                if (count($dadosLimpos['en']) > 0) {
                    $endereco_existe = DbModel::consultaSimples("SELECT * FROM pj_enderecos WHERE pessoa_juridica_id = '$idDecryp'");
                    if ($endereco_existe->rowCount() > 0) {
                        DbModel::updateEspecial('pj_enderecos', $dadosLimpos['en'], "pessoa_juridica_id", $idDecryp);
                    } else {
                        $dadosLimpos['en']['pessoa_juridica_id'] = $idDecryp;
                        DbModel::insert('pj_enderecos', $dadosLimpos['en']);
                    }
                }
            }

            if (count($dadosLimpos['telefones'])>0){
                $telefone_existe = DbModel::consultaSimples("SELECT * FROM pj_telefones WHERE pessoa_juridica_id = '$idDecryp'");

                if ($telefone_existe->rowCount()>0){
                    DbModel::deleteEspecial('pj_telefones', "pessoa_juridica_id",$idDecryp);
                }

                foreach ($dadosLimpos['telefones'] as $telefone){
                    $telefone['pessoa_juridica_id'] = $idDecryp;
                    DbModel::insert('pj_telefones', $telefone);
                }
            }

            /*if ($_SESSION['modulo_c'] == 8 || $_SESSION['modulo_c'] == 9){ //fomento
                $_SESSION['origem_id_c'] = $id;
            }*/

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
            "SELECT * FROM pessoa_juridicas AS pj
            LEFT JOIN pj_enderecos pe on pj.id = pe.pessoa_juridica_id
            LEFT JOIN pj_bancos pb on pj.id = pb.pessoa_juridica_id
            LEFT JOIN bancos bc on pb.banco_id = bc.id
            LEFT JOIN pj_oficinas po on pj.id = po.pessoa_juridica_id
            WHERE pj.id = '$id'
        ");
        $pj = $pj->fetch(PDO::FETCH_ASSOC);
        $telefones = DbModel::consultaSimples("SELECT * FROM pj_telefones WHERE pessoa_juridica_id = '$id'")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $pj['telefones']['tel_' . $key] = $telefone['telefone'];
        }

        return $pj;
    }


    public function getCNPJ($cnpj)
    {
        $consulta_cnpj = DbModel::consultaSimples("SELECT id, cnpj FROM pessoa_juridicas WHERE cnpj = '$cnpj'");
        return $consulta_cnpj;
    }

    /**
     * @param $pessoa_juridica_id
     * <p>Recebe o ID do proponente PJ já decriptado</p>
     * @return array|bool
     */
    public function validaPj($pessoa_juridica_id) {
        return PessoaJuridicaModel::validaPjModel($pessoa_juridica_id);
    }
}