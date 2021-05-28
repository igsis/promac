<?php
if ($pedidoAjax) {
    require_once "../models/PessoaFisicaModel.php";
} else {
    require_once "./models/PessoaFisicaModel.php";
}

class PessoaFisicaController extends PessoaFisicaModel
{
    public function inserePessoaFisica($pagina,$retornaId = false){

        $dadosLimpos = PessoaFisicaModel::limparStringPF($_POST);

        /* cadastro */
        $insere = DbModel::insert('pessoa_fisicas', $dadosLimpos['pf']);
        if ($insere->rowCount()>0) {
            $id = DbModel::connection()->lastInsertId();

            if(isset($dadosLimpos['bc'])){
                if (count($dadosLimpos['bc']) > 0) {
                    $dadosLimpos['bc']['pessoa_fisica_id'] = $id;
                    DbModel::insert('pf_bancos', $dadosLimpos['bc']);
                }
            }

            if (isset($dadosLimpos['en'])) {
                if (count($dadosLimpos['en']) > 0) {
                    $dadosLimpos['en']['pessoa_fisica_id'] = $id;
                    DbModel::insert('pf_enderecos', $dadosLimpos['en']);
                }
            }

            if (isset($dadosLimpos['dr'])) {
                if (count($dadosLimpos['dr']) > 0) {
                    $dadosLimpos['dr']['pessoa_fisica_id'] = $id;
                    DbModel::insert('drts', $dadosLimpos['dr']);
                }
            }

            if (isset($dadosLimpos['ni'])) {
                if (count($dadosLimpos['ni']) > 0) {
                    $dadosLimpos['ni']['pessoa_fisica_id'] = $id;
                    DbModel::insert('nits', $dadosLimpos['ni']);
                }
            }

            if (count($dadosLimpos['telefones'])>0){
                foreach ($dadosLimpos['telefones'] as $telefone){
                    $telefone['pessoa_fisica_id'] = $id;
                    DbModel::insert('pf_telefones', $telefone);
                }
            }

            if (isset($dadosLimpos['of'])){
                if (count($dadosLimpos['of']) > 0) {
                    $dadosLimpos['of']['pessoa_fisica_id'] = $id;
                    DbModel::insert('pf_oficinas', $dadosLimpos['of']);
                }
            }

            if (isset($dadosLimpos['dt'])){
                if (count($dadosLimpos['dt']) > 0) {
                    $dadosLimpos['dt']['pessoa_fisica_id'] = $id;
                    DbModel::insert('pf_detalhes', $dadosLimpos['dt']);
                }
            }

            if(isset($dadosLimpos['fm'])){
                if (count($dadosLimpos['fm']) > 0) {
                    $dadosLimpos['fm']['pessoa_fisicas_id'] = $id;
                    DbModel::insert('fom_pf_dados', $dadosLimpos['fm']);
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

    /* edita */
    public function editaPessoaFisica($id,$pagina,$retornaId = false){
        $idDecryp = MainModel::decryption($id);

        $dadosLimpos = PessoaFisicaModel::limparStringPF($_POST);

        $edita = DbModel::update('pessoa_fisicas', $dadosLimpos['pf'], $idDecryp);
        if ($edita) {

            if (isset($dadosLimpos['bc'])) {
                if (count($dadosLimpos['bc']) > 0) {
                    $banco_existe = DbModel::consultaSimples("SELECT * FROM pf_bancos WHERE pessoa_fisica_id = '$idDecryp' AND publicado = 1");
                    if ($banco_existe->rowCount() > 0) {
                        DbModel::updateEspecialPublicado('pf_bancos', $dadosLimpos['bc'], "pessoa_fisica_id", $idDecryp);
                    } else {
                        $dadosLimpos['bc']['pessoa_fisica_id'] = $idDecryp;
                        DbModel::insert('pf_bancos', $dadosLimpos['bc']);
                    }
                }
            }

            if (isset($dadosLimpos['en'])) {
                if (count($dadosLimpos['en']) > 0) {
                    $endereco_existe = DbModel::consultaSimples("SELECT * FROM pf_enderecos WHERE pessoa_fisica_id = '$idDecryp'");
                    if ($endereco_existe->rowCount() > 0) {
                        DbModel::updateEspecial('pf_enderecos', $dadosLimpos['en'], "pessoa_fisica_id", $idDecryp);
                    } else {
                        $dadosLimpos['en']['pessoa_fisica_id'] = $idDecryp;
                        DbModel::insert('pf_enderecos', $dadosLimpos['en']);
                    }
                }
            }

            if (isset($dadosLimpos['telefones'])){
                if (count($dadosLimpos['telefones'])>0){
                    $telefone_existe = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$idDecryp'");

                    if ($telefone_existe->rowCount()>0){
                        DbModel::deleteEspecial('pf_telefones', "pessoa_fisica_id",$idDecryp);
                    }
                    foreach ($dadosLimpos['telefones'] as $telefone){
                        $telefone['pessoa_fisica_id'] = $idDecryp;
                        DbModel::insert('pf_telefones', $telefone);
                    }
                }
            }

            if (isset($dadosLimpos['ni'])) {
                if (isset($dadosLimpos['ni'])) {
                    if (count($dadosLimpos['ni']) > 0) {
                        $nit_existe = DbModel::consultaSimples("SELECT * FROM nits WHERE pessoa_fisica_id = '$idDecryp'");
                        if ($nit_existe->rowCount() > 0) {
                            DbModel::updateEspecial('nits', $dadosLimpos['ni'], "pessoa_fisica_id", $idDecryp);
                        } else {
                            $dadosLimpos['ni']['pessoa_fisica_id'] = $idDecryp;
                            DbModel::insert('nits', $dadosLimpos['ni']);
                        }
                    }
                }
            }

            if (isset($dadosLimpos['dr'])) {
                if (count($dadosLimpos['dr']) > 0) {
                    $drt_existe = DbModel::consultaSimples("SELECT * FROM drts WHERE pessoa_fisica_id = '$idDecryp'");
                    if ($drt_existe->rowCount() > 0) {
                        DbModel::updateEspecial('drts', $dadosLimpos['dr'], "pessoa_fisica_id", $idDecryp);
                    } else {
                        $dadosLimpos['dr']['pessoa_fisica_id'] = $idDecryp;
                        DbModel::insert('drts', $dadosLimpos['dr']);
                    }
                }
            }

            if (isset($dadosLimpos['of'])){
                if (count($dadosLimpos['of']) > 0) {
                    $oficina_existe = DbModel::consultaSimples("SELECT * FROM pf_oficinas WHERE pessoa_fisica_id = '$idDecryp'");
                    if ($oficina_existe->rowCount() > 0) {
                        DbModel::updateEspecial('pf_oficinas', $dadosLimpos['of'], "pessoa_fisica_id", $idDecryp);
                    } else {
                        $dadosLimpos['of']['pessoa_fisica_id'] = $idDecryp;
                        DbModel::insert('pf_oficinas', $dadosLimpos['of']);
                    }
                }
            }

            if (isset($dadosLimpos['dt'])){
                if (count($dadosLimpos['dt']) > 0) {
                    $detalhe_existe = DbModel::consultaSimples("SELECT * FROM pf_detalhes WHERE pessoa_fisica_id = '$idDecryp'");
                    if ($detalhe_existe->rowCount() > 0) {
                        $dadosLimpos['dt']['trans'] = isset($dadosLimpos['dt']['trans']) ? $dadosLimpos['dt']['trans'] : 0;
                        $dadosLimpos['dt']['pcd'] = isset($dadosLimpos['dt']['pcd']) ? $dadosLimpos['dt']['pcd'] : 0;
                        DbModel::updateEspecial('pf_detalhes', $dadosLimpos['dt'], "pessoa_fisica_id", $idDecryp);
                    } else {
                        $dadosLimpos['dt']['pessoa_fisica_id'] = $idDecryp;
                        DbModel::insert('pf_detalhes', $dadosLimpos['dt']);
                    }
                }
            }

            if (isset($dadosLimpos['fm'])) {
                if (count($dadosLimpos['fm']) > 0) {
                    $banco_existe = DbModel::consultaSimples("SELECT * FROM fom_pf_dados WHERE pessoa_fisicas_id = '$idDecryp'");
                    if ($banco_existe->rowCount() > 0) {
                        DbModel::updateEspecial('fom_pf_dados', $dadosLimpos['fm'], "pessoa_fisicas_id", $idDecryp);
                    } else {
                        $dadosLimpos['fm']['pessoa_fisicas_id'] = $idDecryp;
                        DbModel::insert('fom_pf_dados', $dadosLimpos['fm']);
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

    public function recuperaPessoaFisica($id) {
        $id = MainModel::decryption($id);
        $pf = DbModel::consultaSimples(
            "SELECT pf.*, pe.*, pb.*, po.*, d.*, n.*, n2.nacionalidade, b.banco, b.codigo, pd.*, e.descricao, gi.grau_instrucao
            FROM pessoa_fisicas AS pf
            LEFT JOIN pf_enderecos pe on pf.id = pe.pessoa_fisica_id
            LEFT JOIN (SELECT * FROM pf_bancos WHERE publicado = 1) pb on pf.id = pb.pessoa_fisica_id
            LEFT JOIN pf_oficinas po on pf.id = po.pessoa_fisica_id
            LEFT JOIN drts d on pf.id = d.pessoa_fisica_id
            LEFT JOIN nits n on pf.id = n.pessoa_fisica_id
            LEFT JOIN nacionalidades n2 on pf.nacionalidade_id = n2.id
            LEFT JOIN bancos b on pb.banco_id = b.id
            LEFT JOIN pf_detalhes pd on pf.id = pd.pessoa_fisica_id
            LEFT JOIN etnias e on pd.etnia_id = e.id
            LEFT JOIN grau_instrucoes gi on pd.grau_instrucao_id = gi.id
            WHERE pf.id = '$id'");

        $pf = $pf->fetch(PDO::FETCH_ASSOC);
        $telefones = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$id'")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $pf['telefones']['tel_'.$key] = $telefone['telefone'];
        }
        return $pf;
    }

    public function getCPF($cpf){
        return DbModel::consultaSimples("SELECT id, cpf FROM pessoa_fisicas WHERE cpf = '$cpf'");
    }

    public function getPassaporte($passaporte){
        return DbModel::consultaSimples("SELECT id, passaporte FROM pessoa_fisicas WHERE passaporte = '$passaporte'");
    }

    public function recuperaPessoaFisicaFom($id) {
        $id = MainModel::decryption($id);
        return parent::getFomDados($id);
    }

    public function recuperaPfDados($pessoafisica_id)
    {
        return DbModel::consultaSimples("SELECT pfd.rede_social, g.genero, s.subprefeitura, e.descricao, gi.grau_instrucao FROM `fom_pf_dados` AS pfd
            INNER JOIN generos g on pfd.genero_id = g.id
            INNER JOIN subprefeituras s on pfd.subprefeitura_id = s.id
            INNER JOIN etnias e on pfd.etnia_id = e.id
            INNER JOIN grau_instrucoes gi on pfd.grau_instrucao_id = gi.id
            WHERE pessoa_fisicas_id = '$pessoafisica_id'");
    }


    public function dadosAdcFom($dados){
        return parent::getDadosAdcFom($dados);
    }

    public function recuperaPfDetalhes($id)
    {
        $sql = "SELECT e.descricao, g.genero, gi.grau_instrucao, trans, pcd FROM pf_detalhes AS pd
                INNER JOIN etnias AS e on pd.etnia_id = e.id
                INNER JOIN generos AS g on pd.genero_id = g.id
                INNER JOIN grau_instrucoes AS gi on pd.grau_instrucao_id = gi.id
                WHERE pessoa_fisica_id = '$id'";

        return DbModel::consultaSimples($sql);
    }

    /**
     * @param int|string $pessoa_fisica_id
     * @param int $validacaoTipo <p>Deve conter o valor 1 para validação de pessoa física, 2 para validação de líder e 3 para formação</p>
     * @param int|null $evento_id
     * @return array|bool
     */
    public function validaPf($pessoa_fisica_id, $validacaoTipo, $evento_id = null, $tipo_documentos = null){
        $tipo = gettype($pessoa_fisica_id);
        if ($tipo == "string") {
            $pessoa_fisica_id = MainModel::decryption($pessoa_fisica_id);
        }
        return PessoaFisicaModel::validaPfModel($pessoa_fisica_id, $validacaoTipo, $evento_id,$tipo_documentos);
    }

    public function apagaDadosBancarios($id)
    {
        $idDecrypt = MainModel::decryption($id);
        $apaga = DbModel::apagaEspecial('pf_bancos', 'pessoa_fisica_id', $idDecrypt);
        if ($apaga){
            return true;
        } else {
            return false;
        }
    }
}