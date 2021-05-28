<?php
if ($pedidoAjax) {
    require_once "../models/LiderModel.php";
    require_once "../controllers/PessoaFisicaController.php";
} else {
    require_once "./models/LiderModel.php";
    require_once "./controllers/PessoaFisicaController.php";
}

class LiderController extends LiderModel
{
    public function insereLider($pagina)
    {
        $idPf = PessoaFisicaController::inserePessoaFisica($pagina, true);
        $idAtracao = $_POST['atracao_id'];
        $idPedido = MainModel::decryption($_SESSION['pedido_id_c']);
        $insere = LiderModel::insere($idPedido,$idAtracao,$idPf);
        if ($insere){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Líder',
                'texto' => 'Cadastro realizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/lider'
            ];
        } else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/lider'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function editaLider($idPf, $pagina)
    {
        $idPf = MainModel::decryption($idPf);
        $idPedido = MainModel::decryption($_SESSION['pedido_id_c']);
        PessoaFisicaController::editaPessoaFisica($idPf, $pagina, true);
        $idAtracao = $_POST['atracao_id'];
        $insere = LiderModel::insere($idPedido,$idAtracao,$idPf);
        if ($insere){
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Líder',
                'texto' => 'Cadastro atualizado com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL . $pagina . '/lider'
            ];
        } else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL . $pagina . '/lider'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function listaAtracaoLider()
    {
        $idEvento = MainModel::decryption($_SESSION['origem_id_c']);
        $atracao = DbModel::consultaSimples("
            SELECT atr.id as atracao_id, atr.evento_id, atr.nome_atracao, pf.nome, lid.pessoa_fisica_id 
            FROM atracoes AS atr
            LEFT JOIN lideres lid on atr.id = lid.atracao_id
            LEFT JOIN pessoa_fisicas AS pf ON lid.pessoa_fisica_id = pf.id
            WHERE atr.publicado = 1 AND atr.evento_id = $idEvento
        ")->fetchAll(PDO::FETCH_OBJ);
        return $atracao;
    }

    public function getLider($idAtracao)
    {
        $idPedido = MainModel::decryption($_SESSION['pedido_id_c']);
        $pf = DbModel::consultaSimples("
            SELECT l.atracao_id, l.pessoa_fisica_id, pf.nome, pf.nome_artistico, pf.rg, pf.cpf, pf.passaporte, pf.email,d.drt
            FROM lideres AS l
            INNER JOIN pessoa_fisicas pf on l.pessoa_fisica_id = pf.id
            LEFT JOIN drts d on pf.id = d.pessoa_fisica_id
            WHERE atracao_id = '$idAtracao'");
        $pf = $pf->fetch(PDO::FETCH_ASSOC);
        $idPf = $pf['pessoa_fisica_id'];
        $telefones = DbModel::consultaSimples("SELECT * FROM pf_telefones WHERE pessoa_fisica_id = '$idPf'")->fetchAll(PDO::FETCH_ASSOC);

        foreach ($telefones as $key => $telefone) {
            $pf['telefones']['tel_'.$key] = $telefone['telefone'];
        }
        return $pf;
    }

    public function recuperaLider($pedido_id, $atracao_id) {
        $pedido_id = MainModel::decryption($pedido_id);
        $atracao_id = MainModel::decryption($atracao_id);
        $lider = DbModel::consultaSimples("SELECT l.pessoa_fisica_id AS 'id', pf.nome, pf.email, pf.cpf, pf.rg FROM lideres AS l INNER JOIN pessoa_fisicas pf on l.pessoa_fisica_id = pf.id WHERE l.pedido_id = '$pedido_id' AND l.atracao_id = '$atracao_id'")->fetchObject();

        $telefones = DbModel::consultaSimples("SELECT telefone FROM pf_telefones WHERE pessoa_fisica_id = '$lider->id'")->fetchAll(PDO::FETCH_COLUMN);
        foreach ($telefones as $key => $telefone) {
            $index = "telefone".($key+1);
            $lider->$index = $telefone;
        }

        return $lider;
    }
}