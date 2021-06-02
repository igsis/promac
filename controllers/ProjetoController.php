<?php
if ($pedidoAjax) {
    require_once "../models/ProjetoModel.php";
    require_once '../controllers/ProponentePjController.php';
    require_once '../controllers/ProponentePfController.php';
    require_once '../controllers/FomentoController.php';
} else {
    require_once "./models/ProjetoModel.php";
    require_once './controllers/ProponentePjController.php';
    require_once './controllers/ProponentePfController.php';
    require_once './controllers/FomentoController.php';
}

class ProjetoController extends ProjetoModel
{
    public function inserePjProjeto(): string
    {
        session_start(['name' => 'prmc']);
        if (!isset($_SESSION['origem_id_c'])){
            if (isset($_POST['id'])) {
                $idPj = $_POST['id'];
                $idPj = (new ProponentePjController)->editaProponentePj($idPj,"",true);
            } else {
                $idPj = (new ProponentePjController)->insereProponentePj("", true);
            }
            if ($idPj) {
                $_SESSION['origem_id_c'] = MainModel::encryption($idPj);
                $projeto = ProjetoModel::updatePjProjeto(2);
                if ($projeto) {
                    $alerta = [
                        'alerta' => 'sucesso',
                        'titulo' => 'Pessoa Jurídica',
                        'texto' => 'Cadastrada com sucesso!',
                        'tipo' => 'success',
                        'location' => SERVERURL . "fomentos/pj_cadastro&id={$_SESSION['origem_id_c']}"
                    ];
                } else {
                    $alerta = [
                        'alerta' => 'simples',
                        'titulo' => 'Erro!',
                        'texto' => 'Erro ao salvar!',
                        'tipo' => 'error',
                        'location' => SERVERURL . 'fomentos/pj_cadastro'
                    ];
                }
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Erro ao salvar!',
                    'tipo' => 'error',
                    'location' => SERVERURL . 'fomentos/pj_cadastro'
                ];
            }
        } else {
            $idPj = MainModel::decryption($_SESSION['origem_id_c']);
            (new ProponentePjController)->editaProponentePj($idPj,"",true);
            if ($idPj) {
                $projeto = ProjetoModel::updatePjProjeto(2);
                if ($projeto) {
                    $alerta = [
                        'alerta' => 'sucesso',
                        'titulo' => 'Pessoa Jurídica',
                        'texto' => 'Cadastrada com sucesso!',
                        'tipo' => 'success',
                        'location' => SERVERURL . "fomentos/pj_cadastro&id={$_SESSION['origem_id_c']}"
                    ];
                } else {
                    $alerta = [
                        'alerta' => 'simples',
                        'titulo' => 'Erro!',
                        'texto' => 'Erro ao salvar!',
                        'tipo' => 'error',
                        'location' => SERVERURL . 'fomentos/pj_cadastro'
                    ];
                }
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Erro ao salvar!',
                    'tipo' => 'error',
                    'location' => SERVERURL . 'fomentos/pj_cadastro'
                ];
            }
        }
        return MainModel::sweetAlert($alerta);
    }

    public function removePjProjeto(): string
    {
        session_start(['name' => 'prmc']);
        $id = MainModel::decryption($_SESSION['projeto_c']);
        $dados = [
            'pessoa_juridica_id' => NULL
        ];
        $projeto = DbModel::update("fom_projetos",$dados,$id);
        if ($projeto) {
            unset($_SESSION['origem_id_c']);
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Jurídica',
                'texto' => 'Empresa removida com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "fomentos/proponente"
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao remover!',
                'tipo' => 'error',
                'location' => SERVERURL . 'fomentos/pj_cadastro'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function inserePfProjeto(): string
    {
        session_start(['name' => 'prmc']);
        if (!isset($_SESSION['origem_id_c'])){
            if (isset($_POST['id'])) {
                $idPf = $_POST['id'];
                $idPf = (new ProponentePfController)->editaProponentePf($idPf,"",true);
            } else {
                $idPf = (new ProponentePfController)->insereProponentePf("", true);
            }
            if ($idPf) {
                $_SESSION['origem_id_c'] = MainModel::encryption($idPf);
                $projeto = ProjetoModel::updatePjProjeto(1);
                if ($projeto) {
                    $alerta = [
                        'alerta' => 'sucesso',
                        'titulo' => 'Pessoa Física',
                        'texto' => 'Cadastrada com sucesso!',
                        'tipo' => 'success',
                        'location' => SERVERURL . "fomentos/pf_cadastro&id={$_SESSION['origem_id_c']}"
                    ];
                } else {
                    $alerta = [
                        'alerta' => 'simples',
                        'titulo' => 'Erro!',
                        'texto' => 'Erro ao salvar!',
                        'tipo' => 'error',
                        'location' => SERVERURL . 'fomentos/pf_cadastro'
                    ];
                }
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Erro ao salvar!',
                    'tipo' => 'error',
                    'location' => SERVERURL . 'fomentos/pf_cadastro'
                ];
            }
        } else {
            $idPf = MainModel::decryption($_SESSION['origem_id_c']);
            (new ProponentePfController)->editaProponentePf($_SESSION['origem_id_c'],"",true);
            if ($idPf) {
                $projeto = ProjetoModel::updatePjProjeto(1);
                if ($projeto) {
                    $alerta = [
                        'alerta' => 'sucesso',
                        'titulo' => 'Pessoa Física',
                        'texto' => 'Cadastrada com sucesso!',
                        'tipo' => 'success',
                        'location' => SERVERURL . "fomentos/pf_cadastro&id={$_SESSION['origem_id_c']}"
                    ];
                } else {
                    $alerta = [
                        'alerta' => 'simples',
                        'titulo' => 'Erro!',
                        'texto' => 'Erro ao salvar!',
                        'tipo' => 'error',
                        'location' => SERVERURL . 'fomentos/pf_cadastro'
                    ];
                }
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Erro ao salvar!',
                    'tipo' => 'error',
                    'location' => SERVERURL . 'fomentos/pf_cadastro'
                ];
            }
        }
        return MainModel::sweetAlert($alerta);
    }

    public function removePfProjeto(): string
    {
        session_start(['name' => 'prmc']);
        $id = MainModel::decryption($_SESSION['projeto_c']);
        $dados = [
            'pessoa_fisica_id' => NULL
        ];
        $projeto = DbModel::update("fom_projetos",$dados,$id);
        if ($projeto) {
            unset($_SESSION['origem_id_c']);
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Inscrito removido com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . "fomentos/proponente"
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao remover!',
                'tipo' => 'error',
                'location' => SERVERURL . 'fomentos/pf_cadastro'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function listaProjetos(): array
    {
        $usuario_id = $_SESSION['usuario_id_p'];
        $edital_id = MainModel::decryption($_SESSION['edital_c']);
        $sql = "SELECT fe.titulo, fp.* FROM fom_projetos AS fp
                INNER JOIN  fom_editais AS fe ON fp.fom_edital_id = fe.id
                WHERE fom_edital_id = '$edital_id' AND usuario_id = '$usuario_id' AND (fp.publicado = 1 OR fp.publicado = 2 OR fp.publicado = 3)";
        $consultaEvento = DbModel::consultaSimples($sql);
        return $consultaEvento->fetchAll(PDO::FETCH_OBJ);
    }

    public function insereProjeto($post): string
    {
        session_start(['name' => 'prmc']);

        /* executa limpeza nos campos */
        unset($post['_method']);
        unset($post['modulo']);
        unset($post['pagina']);

        $edital_id = MainModel::decryption($_SESSION['edital_c']);
        $dados['fom_edital_id'] = $edital_id;
        $dados['fom_status_id'] = 1;

        $camposCompPj = ['instituicao', 'site'];
        $dadosCompPj = [];
        $camposCompPf = ['fom_linguagem_projeto_id', 'fom_tematica_projeto_id'];
        $dadosCompPf = [];
        $camposCompPeriferias = ['fom_area_id'];
        $dadosCompPeriferias = [];

        foreach ($post as $campo => $valor) {
            if ($campo != "modulo") {
                if ($campo == 'valor_projeto'){
                    $valor = MainModel::dinheiroDeBr($valor);
                }
                $dado = MainModel::limparString($valor);
                if (in_array($campo, $camposCompPj)) {
                    $dadosCompPj[$campo] = $dado;
                } elseif (in_array($campo, $camposCompPf)) {
                    $dadosCompPf[$campo] = $dado;
                } elseif (in_array($campo, $camposCompPeriferias)){
                    $dadosCompPeriferias[$campo] = $dado;
                } else {
                    $dados[$campo] = $dado;
                }
            }
        }
        /* ./limpeza */
        /* cadastro */
        $insere = DbModel::insert('fom_projetos', $dados);
        if ($insere->rowCount() >= 1) {
            $projeto_id = DbModel::connection()->lastInsertId();

            if (count($dadosCompPj)) {
                $dadosCompPj['fom_projeto_id'] = $projeto_id;
                DbModel::insert('fom_projeto_dado_pjs', $dadosCompPj);
            }
            if (count($dadosCompPf)) {
                $dadosCompPf['fom_projeto_id'] = $projeto_id;
                DbModel::insert('fom_projeto_dado_pfs', $dadosCompPf);
            }
            if (count($dadosCompPf)) {
                $dadosCompPeriferias['fom_projeto_id'] = $projeto_id;
                DbModel::insert('fom_edital_periferias', $dadosCompPeriferias);
            }

            $_SESSION['projeto_c'] = MainModel::encryption($projeto_id);
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto Cadastrado!',
                'texto' => 'Projeto cadastrado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . 'fomentos/projeto_cadastro&id=' . MainModel::encryption($projeto_id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        /* ./cadastro */
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaProjeto($post, $id): string
    {
        $id = MainModel::decryption($id);

        unset($post['_method']);
        unset($post['modulo']);
        unset($post['id']);
        unset($post['pagina']);
        $dados = [];

        $camposCompPj = ['instituicao', 'site'];
        $dadosCompPj = [];
        $camposCompPf = ['fom_linguagem_projeto_id', 'fom_tematica_projeto_id'];
        $dadosCompPf = [];
        $camposCompPeriferias = ['fom_area_id'];
        $dadosCompPeriferias = [];

        foreach ($post as $campo => $valor) {
            if ($campo != "pagina") {
                if ($campo == 'valor_projeto'){
                    $valor = MainModel::dinheiroDeBr($valor);
                }
                $dado = MainModel::limparString($valor);
                if (in_array($campo, $camposCompPj)) {
                    $dadosCompPj[$campo] = $dado;
                } elseif (in_array($campo, $camposCompPf)) {
                    $dadosCompPf[$campo] = $dado;
                } elseif (in_array($campo, $camposCompPeriferias)) {
                    $dadosCompPeriferias[$campo] = $dado;
                } else {
                    $dados[$campo] = $dado;
                }
            }
        }

        $edita = DbModel::update('fom_projetos', $dados, $id);
        if ($edita->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            if (count($dadosCompPj)) {
                $dadosCompPj['fom_projeto_id'] = $id;
                DbModel::updateEspecial('fom_projeto_dado_pjs', $dadosCompPj, 'fom_projeto_id', $id);
            }
            if (count($dadosCompPf)) {
                $dadosCompPf['fom_projeto_id'] = $id;
                DbModel::updateEspecial('fom_projeto_dado_pfs', $dadosCompPf, 'fom_projeto_id', $id);
            }
            if (count($dadosCompPeriferias)) {
                $dadosCompPeriferias['fom_projeto_id'] = $id;
                DbModel::updateEspecial('fom_edital_periferias', $dadosCompPeriferias, 'fom_projeto_id', $id);
            }
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto Atualizado',
                'texto' => 'Projeto editado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'fomentos/projeto_cadastro&id='.MainModel::encryption($id)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'fomentos/projeto_cadastro&id='.MainModel::encryption($id)
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaProjeto($id): array
    {
        $id = MainModel::decryption($id);

        $sql = "SELECT fp.*, fpdj.instituicao, fpdj.site, fpdf.fom_linguagem_projeto_id, flp.linguagem, fpdf.fom_tematica_projeto_id, ftp.tematica, fep.fom_area_id 
                FROM fom_projetos AS fp
                LEFT JOIN fom_projeto_dado_pjs fpdj on fp.id = fpdj.fom_projeto_id
                LEFT JOIN fom_projeto_dado_pfs fpdf on fp.id = fpdf.fom_projeto_id
                LEFT JOIN fom_linguagem_projetos flp on fpdf.fom_linguagem_projeto_id = flp.id
                LEFT JOIN fom_tematica_projetos ftp on fpdf.fom_tematica_projeto_id = ftp.id 
                LEFT JOIN fom_edital_periferias fep on fp.id = fep.fom_projeto_id 
                WHERE fp.id = '$id'";
        $projeto = DbModel::consultaSimples($sql)->fetch(PDO::FETCH_ASSOC);

        if ($projeto['pessoa_tipo_id'] == 1) {
            if ($projeto['pessoa_fisica_id'] != null) {
                $_SESSION['origem_id_c'] = MainModel::encryption($projeto['pessoa_fisica_id']);
            }
        } elseif ($projeto['pessoa_tipo_id'] == 2) {
            if ($projeto['pessoa_juridica_id'] != null) {
                $_SESSION['origem_id_c'] = MainModel::encryption($projeto['pessoa_juridica_id']);
            }
        }
        return $projeto;
    }

    public function recuperaProjetoCompleto($id) {
        $id = MainModel::decryption($id);
        return DbModel::consultaSimples("SELECT * 
            FROM fom_projetos fp
            INNER JOIN fom_editais fe on fp.fom_edital_id = fe.id
            INNER JOIN fom_status fs on fp.fom_status_id = fs.id
            LEFT JOIN fom_projeto_dado_pjs fpd on fp.id = fpd.fom_projeto_id
            LEFT JOIN fom_projeto_dado_pfs fpdpf on fp.id = fpdpf.fom_projeto_id
            LEFT JOIN fom_linguagem_projetos flp on fpdpf.fom_linguagem_projeto_id = flp.id
            LEFT JOIN fom_tematica_projetos ftp on fpdpf.fom_tematica_projeto_id = ftp.id
            LEFT JOIN pessoa_juridicas pj on fp.pessoa_juridica_id = pj.id
            LEFT JOIN pessoa_fisicas pf on fp.pessoa_fisica_id = pf.id
            INNER JOIN usuarios u on fp.usuario_id = u.id
            WHERE fp.id = '$id'
        ")->fetch(PDO::FETCH_ASSOC);
    }

    public function recuperaStatusProjeto($id){
        return DbModel::consultaSimples("SELECT status
        FROM fom_status
        WHERE id = '$id'")->fetchColumn();
    }

    public function recuperaValorMax()
    {
        $idEdital = MainModel::decryption($_SESSION['edital_c']);
        return DbModel::consultaSimples("SELECT valor_max_projeto FROM fom_editais WHERE id = '$idEdital'")->fetchColumn();
    }

    public function finalizarProjeto($id): string
    {
        session_start(['name' => 'prmc']);

        $projetoId = MainModel::encryption($id);
//        $projeto = $this->recuperaProjeto($projetoId);
        $projeto['protocolo'] = MainModel::gerarProtocolo($id,$_SESSION['edital_c']);
        $projeto['data_inscricao'] = date("Y-m-d H:i:s");
        $projeto['fom_status_id'] = 2;

        $update = DbModel::update('fom_projetos',$projeto,$id);
        if ($update->rowCount() >= 1 || DbModel::connection()->errorCode() == 0) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto Enviado',
                'texto' => 'Projeto enviado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'fomentos/inicio',
                'redirecionamento' => SERVERURL.'pdf/resumo_fomento.php?id='.$projetoId
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao enviar o projeto!',
                'tipo' => 'error'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function apagaProjeto($id): string
    {
        $apaga = DbModel::apaga("fom_projetos", $id);
        if ($apaga){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Projeto',
                'texto' => 'Projeto apagado com sucesso!',
                'tipo' => 'danger',
                'location' => SERVERURL.'fomentos/projeto_lista'
            ];
        }else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Oops! Algo deu Errado!',
                'texto' => 'Falha ao salvar os dados no servidor, tente novamente mais tarde',
                'tipo' => 'error',
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function validaProjeto($projeto_id, $edital_id) {
        $edital_id = MainModel::decryption($edital_id);
        $projeto_id = MainModel::decryption($projeto_id);

        $erros['Proponente'] = ProjetoModel::validaProponenteProjeto($projeto_id);
        $erros['Arquivos'] = ProjetoModel::validaArquivosProjeto($projeto_id, $edital_id);

        return MainModel::formataValidacaoErros($erros);
    }

    private function insereDadosPeriferias($dados) {

    }
}