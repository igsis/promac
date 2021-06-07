<?php
if ($pedidoAjax) {
    require_once "../models/RepresentanteModel.php";
} else {
    require_once "./models/RepresentanteModel.php";
}

class RepresentanteController extends RepresentanteModel
{
    /**
     * <p>Função para inserir Representante Legal</p>
     * @param $pagina
     * @param $tabela <p>proponente_pjs ou incentivador_pjs</p>
     * @param false $retornaId
     * @return string
     */
    public function insereRepresentante($pagina, $tabela, bool $retornaId = false):string
    {
        $idPj = MainModel::decryption($_POST['idPj']);
        unset($_POST['idPj']);
        $dadosLimpos = RepresentanteModel::limparStringRepresentante($_POST);

        /* cadastro */
        $insere = DbModel::insert('representante_legais', $dadosLimpos['pf']);
        if ($insere->rowCount()>0) {
            $id = DbModel::connection()->lastInsertId();

            if (isset($dadosLimpos['en'])) {
                if (count($dadosLimpos['en']) > 0) {
                    $dadosLimpos['en']['representante_legal_id'] = $id;
                    DbModel::insert('representante_enderecos', $dadosLimpos['en']);
                }
            }

            if (count($dadosLimpos['telefones'])>0){
                foreach ($dadosLimpos['telefones'] as $telefone){
                    $telefone['representante_legal_id'] = $id;
                    DbModel::insert('representante_telefones', $telefone);
                }
            }

            if (isset($dadosLimpos['lei'])){
                if (count($dadosLimpos['lei']) > 0) {
                    $dadosLimpos['lei']['representante_legal_id'] = $id;
                    DbModel::insert('representante_leis', $dadosLimpos['lei']);
                }
            }

            $pj_dados = ['representante_legal_id' => $id];
            DbModel::update($tabela,$pj_dados,$idPj);

            if($retornaId){
                return $id;
            } else{
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Representante Legal',
                    'texto' => 'Representante Legal cadastrado com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL.$pagina.'&idPj='.MainModel::encryption($idPj).'&id='.MainModel::encryption($id)
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
                'location' => SERVERURL.$pagina
            ];
        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /**
     * <p>Função para editar Representante Legal</p>
     * @param int|string $id
     * @param $pagina
     * @param $tabela <p>proponente_pjs ou incentivador_pjs</p>
     * @param false $retornaId
     * @return string
     */
    public function editaRepresentante($id, $pagina, $tabela, $retornaId = false):string
    {
        $idDecryp = MainModel::decryption($id);
        $idPj = MainModel::decryption($_POST['idPj']);
        unset($_POST['idPj']);
        $dadosLimpos = RepresentanteModel::limparStringRepresentante($_POST);

        $edita = DbModel::update('representante_legais', $dadosLimpos['pf'], $idDecryp);
        if ($edita) {
            if (isset($dadosLimpos['en'])) {
                if (count($dadosLimpos['en']) > 0) {
                    $endereco_existe = DbModel::consultaSimples("SELECT * FROM representante_enderecos WHERE representante_legal_id = '$idDecryp'");
                    if ($endereco_existe->rowCount() > 0) {
                        DbModel::updateEspecial('representante_enderecos', $dadosLimpos['en'], "representante_legal_id", $idDecryp);
                    } else {
                        $dadosLimpos['en']['representante_legal_id'] = $idDecryp;
                        DbModel::insert('representante_enderecos', $dadosLimpos['en']);
                    }
                }
            }

            if (isset($dadosLimpos['telefones'])){
                if (count($dadosLimpos['telefones'])>0){
                    $telefone_existe = DbModel::consultaSimples("SELECT * FROM representante_telefones WHERE representante_legal_id = '$idDecryp'");

                    if ($telefone_existe->rowCount()>0){
                        DbModel::deleteEspecial('representante_telefones', "representante_legal_id",$idDecryp);
                    }
                    foreach ($dadosLimpos['telefones'] as $telefone){
                        $telefone['representante_legal_id'] = $idDecryp;
                        DbModel::insert('representante_telefones', $telefone);
                    }
                }
            }

            if (isset($dadosLimpos['lei'])){
                if (count($dadosLimpos['lei']) > 0) {
                    $detalhe_existe = DbModel::consultaSimples("SELECT * FROM representante_leis WHERE representante_legal_id = '$idDecryp'");
                    if ($detalhe_existe->rowCount() > 0) {
                        DbModel::updateEspecial('representante_leis', $dadosLimpos['lei'], "representante_legal_id", $idDecryp);
                    } else {
                        $dadosLimpos['lei']['representante_legal_id'] = $idDecryp;
                        DbModel::insert('representante_leis', $dadosLimpos['lei']);
                    }
                }
            }

            $pj_dados = ['representante_legal_id' => $id];
            DbModel::update($tabela,$pj_dados,$idPj);

            if($retornaId){
                return $idDecryp;
            } else{
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Representante Legal',
                    'texto' => 'Representante Legal editado com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL.$pagina.'&idPj='.MainModel::encryption($idPj).'&id='.$id
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
                'location' => SERVERURL.$pagina[0]
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    /**
     * <p>Remove o Representante da Pessoa Jurídica</p>
     * @param $pagina
     * @param $tabela
     * @return string
     */
    public function removeRepresentante($pagina,$tabela):string
    {
        unset($_POST['_method']);
        unset($_POST['pagina']);

        $idPj = MainModel::decryption($_POST['idPj']);
        $pj_dados = ['representante_legal_id' => NULL];
        $remove_rep = DbModel::update($tabela,$pj_dados,$idPj);
        if ($remove_rep){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Representante Legal',
                'texto' => 'Representante Legal removido com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.$pagina.'&idPj='.MainModel::encryption($idPj)
            ];
        }
        else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao remover!',
                'tipo' => 'error',
                'location' => SERVERURL.$pagina.'&idPj='.MainModel::encryption($idPj)
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    /**
     * <p>Recupera os dados do Representante Legal</p>
     * @param $id
     * @return array|mixed
     */
    public function recuperaRepresentante($id)
    {
        $id = MainModel::decryption($id);
        $pf = DbModel::consultaSimples(
            "SELECT pf.*, ge.genero, et.etnia, pe.*, pl.lei 
            FROM representante_legais AS pf
            LEFT JOIN generos ge on pf.genero_id = ge.id
            LEFT JOIN etnias et on pf.etnia_id = et.id
            LEFT JOIN representante_enderecos pe on pf.id = pe.representante_legal_id
            LEFT JOIN representante_leis pl on pf.id = pl.representante_legal_id
            WHERE pf.id = '$id'");

        $pf = $pf->fetch(PDO::FETCH_ASSOC);
        $telefones = DbModel::consultaSimples("SELECT * FROM proponente_pf_telefones WHERE proponente_pf_id = '$id'")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $pf['telefones']['tel_'.$key] = $telefone['telefone'];
        }
        return (object)$pf;
    }

    /**
     * <p>Recupera o id do Representante através do CPF</p>
     * @param $cpf
     * @return false|PDOStatement
     */
    public function getCPF($cpf)
    {
        return DbModel::consultaSimples("SELECT id, cpf FROM representante_legais WHERE cpf = '$cpf'")->fetchObject();
    }

}