<?php
if ($pedidoAjax) {
    require_once "../models/PedidoModel.php";
    require_once "../controllers/PessoaJuridicaController.php";
    require_once "../controllers/PessoaFisicaController.php";
    require_once "../controllers/ProdutorController.php";
    require_once "../controllers/AtracaoController.php";
    require_once "../controllers/LiderController.php";
    require_once "../controllers/RepresentanteController.php";
} else {
    require_once "./models/PedidoModel.php";
    require_once "./controllers/PessoaJuridicaController.php";
    require_once "./controllers/PessoaFisicaController.php";
    require_once "./controllers/ProdutorController.php";
    require_once "./controllers/AtracaoController.php";
    require_once "./controllers/LiderController.php";
    require_once "./controllers/RepresentanteController.php";
}

class PedidoController extends PedidoModel
{
    public function inserePedidoJuridica($pagina, $origem_tipo)
    {
        $idPj = PessoaJuridicaController::inserePessoaJuridica($pagina, true);
        $pedido = PedidoModel::inserePedido($origem_tipo, 2, $idPj);
        if ($pedido) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Jurídica',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/pj_cadastro&id=' . MainModel::encryption($idPj)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaPedidoJuridica($idPj, $pagina, $origem_tipo)
    {
        $pj = PessoaJuridicaController::editaPessoaJuridica($idPj, $pagina, true);
        $pedido = PedidoModel::inserePedido($origem_tipo, 2, $pj);
        if ($pedido) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Jurídica',
                'texto' => 'Cadastro alterado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/pj_cadastro&id=' . $idPj
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function inserePedidoFisica($pagina, $origem_tipo)
    {
        $idPf = PessoaFisicaController::inserePessoaFisica($pagina, true);
        $pedido = PedidoModel::inserePedido($origem_tipo, 1, $idPf);
        if ($pedido) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/pf_cadastro&id=' . MainModel::encryption($idPf)
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaPedidoFisica($idPf, $pagina, $origem_tipo)
    {
        $pf = PessoaFisicaController::editaPessoaFisica($idPf, $pagina, true);
        $pedido = PedidoModel::inserePedido($origem_tipo, 1, $pf);
        if ($pedido) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Pessoa Física',
                'texto' => 'Cadastro alterado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/pf_cadastro&id=' . $idPf
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/proponente'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaPedido($origem_tipo, $oficina = false)
    {
        $origem_id = MainModel::decryption($_SESSION['origem_id_c']);
        $pedido = DbModel::consultaSimples(
            "SELECT * FROM pedidos WHERE origem_tipo_id = '$origem_tipo' AND origem_id = '$origem_id'"
        )->fetchObject();

        if ($pedido->pessoa_tipo_id == 1) {
            $pedido->proponente = PedidoModel::buscaProponente(1, $pedido->pessoa_fisica_id);
            if ($oficina) {
                $atracao = (new AtracaoController)->recuperaAtracao($_SESSION['atracao_id_c']);
                if ($atracao->produtor_id == null) {
                    $dadosProdutor = [
                        'nome' => $pedido->proponente->nome,
                        'email' => $pedido->proponente->email,
                        'telefone1' => $pedido->proponente->telefone1,
                        'telefone2' => $pedido->proponente->telefone2 ?? ""
                    ];
                    (new ProdutorController)->insereProdutor($dadosProdutor, $_SESSION['atracao_id_c'], "", true);
                }
            }
        } else {
            $pedido->proponente = PedidoModel::buscaProponente(2, $pedido->pessoa_juridica_id);

            if ($oficina) {
                $atracao = (new AtracaoController)->recuperaAtracao($_SESSION['atracao_id_c']);
                $liderCadastrado = DbModel::consultaSimples("SELECT * FROM lideres WHERE pedido_id = '$pedido->id' AND atracao_id = '$atracao->id'");
                if ($liderCadastrado->rowCount() > 0) {
                    $lider = (new LiderController)->recuperaLider($_SESSION['pedido_id_c'], $_SESSION['atracao_id_c']);
                    if ($atracao->produtor_id == null) {
                        $dadosProdutor = [
                            'nome' => $lider->nome,
                            'email' => $lider->email,
                            'telefone1' => $lider->telefone1,
                            'telefone2' => $lider->telefone2 ?? ""
                        ];
                        (new ProdutorController)->insereProdutor($dadosProdutor, $_SESSION['atracao_id_c'], "", true);
                    }
                    $dadosRepresentante = [
                        'nome' => $lider->nome,
                        'rg' => $lider->rg,
                        'cpf' => $lider->cpf
                    ];
                    (new RepresentanteController)->insereRepresentanteOficina($dadosRepresentante, $pedido->proponente->id);
                }
            }
        }

        return $pedido;
    }

    public function getPedido($id)
    {
        $id = MainModel::decryption($id);
        return $id;
    }

    public function startPedido()
    {
        $idEvento = $_SESSION['origem_id_c'];
        $idEvento = MainModel::decryption($idEvento);
        $consulta = DbModel::consultaSimples("SELECT id FROM pedidos WHERE origem_tipo_id = 1 AND origem_id = $idEvento AND publicado = 1");
        if ($consulta->rowCount() > 0) {
            $consulta = $consulta->fetch(PDO::FETCH_ASSOC);
            $resultado = $consulta['id'];
            if ($resultado != null) {
                $_SESSION['pedido_id_c'] = MainModel::encryption($resultado);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function recuperaProponente($pedido_id) {
        $pedido_id = MainModel::decryption($pedido_id);
        $sql = "SELECT pessoa_tipo_id, pessoa_juridica_id, pessoa_fisica_id FROM pedidos WHERE id = '$pedido_id'";
        $proponente = DbModel::consultaSimples($sql)->fetchObject();

        return $proponente;
    }
}