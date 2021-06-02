<?php
if ($pedidoAjax) {
    require_once "../models/ProponentePfModel.php";
} else {
    require_once "./models/ProponentePfModel.php";
}

class ProponentePfController extends ProponentePfModel
{
    /**
     * <p>Função para inserir Proponente Pessoa Física</p>
     * @param $pagina
     * @param false $retornaId
     * @return string
     */
    public function insereProponentePf($pagina, bool $retornaId = false):string
    {
        $dadosLimpos = ProponentePfModel::limparStringpf($_POST);

        /* cadastro */
        $insere = DbModel::insert('proponente_pfs', $dadosLimpos['pf']);
        if ($insere->rowCount()>0) {
            $id = DbModel::connection()->lastInsertId();

            if (isset($dadosLimpos['en'])) {
                if (count($dadosLimpos['en']) > 0) {
                    $dadosLimpos['en']['proponente_pf_id'] = $id;
                    DbModel::insert('proponente_pf_enderecos', $dadosLimpos['en']);
                }
            }

            if (count($dadosLimpos['telefones'])>0){
                foreach ($dadosLimpos['telefones'] as $telefone){
                    $telefone['proponente_pf_id'] = $id;
                    DbModel::insert('proponente_pf_telefones', $telefone);
                }
            }

            if (isset($dadosLimpos['lei'])){
                if (count($dadosLimpos['lei']) > 0) {
                    $dadosLimpos['lei']['proponente_pf_id'] = $id;
                    DbModel::insert('proponente_pf_leis', $dadosLimpos['lei']);
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
                'location' => SERVERURL.$pagina[0].'/proponente'
            ];
        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /**
     * @param int|string $id
     * @param $pagina
     * @param false $retornaId
     * @return string
     */
    public function editaProponentePf($id, $pagina, $retornaId = false):string
    {
        $idDecryp = MainModel::decryption($id);

        $dadosLimpos = ProponentePfModel::limparStringPF($_POST);

        $edita = DbModel::update('proponente_pfs', $dadosLimpos['pf'], $idDecryp);
        if ($edita) {

            if (isset($dadosLimpos['en'])) {
                if (count($dadosLimpos['en']) > 0) {
                    $endereco_existe = DbModel::consultaSimples("SELECT * FROM proponente_pf_enderecos WHERE proponente_pf_id = '$idDecryp'");
                    if ($endereco_existe->rowCount() > 0) {
                        DbModel::updateEspecial('proponente_pf_enderecos', $dadosLimpos['en'], "proponente_pf_id", $idDecryp);
                    } else {
                        $dadosLimpos['en']['proponente_pf_id'] = $idDecryp;
                        DbModel::insert('proponente_pf_enderecos', $dadosLimpos['en']);
                    }
                }
            }

            if (isset($dadosLimpos['telefones'])){
                if (count($dadosLimpos['telefones'])>0){
                    $telefone_existe = DbModel::consultaSimples("SELECT * FROM proponente_pf_telefones WHERE proponente_pf_id = '$idDecryp'");

                    if ($telefone_existe->rowCount()>0){
                        DbModel::deleteEspecial('proponente_pf_telefones', "proponente_pf_id",$idDecryp);
                    }
                    foreach ($dadosLimpos['telefones'] as $telefone){
                        $telefone['proponente_pf_id'] = $idDecryp;
                        DbModel::insert('proponente_pf_telefones', $telefone);
                    }
                }
            }

            if (isset($dadosLimpos['lei'])){
                if (count($dadosLimpos['lei']) > 0) {
                    $detalhe_existe = DbModel::consultaSimples("SELECT * FROM proponente_pf_leis WHERE proponente_pf_id = '$idDecryp'");
                    if ($detalhe_existe->rowCount() > 0) {
                        DbModel::updateEspecial('proponente_pf_leis', $dadosLimpos['lei'], "proponente_pf_id", $idDecryp);
                    } else {
                        $dadosLimpos['lei']['proponente_pf_id'] = $idDecryp;
                        DbModel::insert('proponente_pf_leis', $dadosLimpos['lei']);
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
                'location' => SERVERURL.$pagina[0].'/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    /**
     * <p>Recupera dados do Proponente</p>
     * @param $id
     * @return array|mixed
     */
    public function recuperaProponentePf($id)
    {
        $id = MainModel::decryption($id);
        $pf = DbModel::consultaSimples(
            "SELECT pf.*, n2.nacionalidade, ec.estado_civil, ge.genero, et.etnia, pe.*, pl.lei 
            FROM proponente_pfs AS pf
            LEFT JOIN nacionalidades n2 on pf.nacionalidade_id = n2.id
            LEFT JOIN estado_civis ec on pf.estado_civil_id = ec.id
            LEFT JOIN generos ge on pf.genero_id = ge.id
            LEFT JOIN etnias et on pf.etnia_id = et.id
            LEFT JOIN proponente_pf_enderecos pe on pf.id = pe.proponente_pf_id
            LEFT JOIN proponente_pf_leis pl on pf.id = pl.proponente_pf_id
            WHERE pf.id = '$id'");

        $pf = $pf->fetch(PDO::FETCH_ASSOC);
        $telefones = DbModel::consultaSimples("SELECT * FROM proponente_pf_telefones WHERE proponente_pf_id = '$id'")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $pf['telefones']['tel_'.$key] = $telefone['telefone'];
        }
        return (object)$pf;
    }

    /**
     * <p>Recupera o id do Proponente através do CPF</p>
     * @param $cpf
     * @return false|PDOStatement
     */
    public function getCPF($cpf){
        return DbModel::consultaSimples("SELECT id, cpf FROM proponente_pfs WHERE cpf = '$cpf'");
    }

    /**
     * @param int|string $proponente_pf_id
     * @param int $validacaoTipo <p>Deve conter o valor 1 para validação de pessoa física, 2 para validação de líder e 3 para formação</p>
     * @param int|null $evento_id
     * @return array|bool
     */
    public function validaPf($proponente_pf_id, $validacaoTipo, $evento_id = null, $tipo_documentos = null){
        $tipo = gettype($proponente_pf_id);
        if ($tipo == "string") {
            $proponente_pf_id = MainModel::decryption($proponente_pf_id);
        }
        return ProponentePfModel::validaPfModel($proponente_pf_id, $validacaoTipo, $evento_id,$tipo_documentos);
    }

}