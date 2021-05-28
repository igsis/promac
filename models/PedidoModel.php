<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}


class PedidoModel extends MainModel
{
    public function inserePedido($origem_tipo,$pessoa_tipo,$pessoa_id){
        $origem_id = MainModel::decryption($_SESSION['origem_id_c']);

        $dados = [
            'origem_tipo_id' => $origem_tipo,
            'origem_id' => $origem_id,
            'pessoa_tipo_id' => $pessoa_tipo
        ];

        if ($pessoa_tipo == 1){
            $dados['pessoa_fisica_id'] = $pessoa_id;
            $dados['pessoa_juridica_id'] = null;
        }
        else{
            $dados['pessoa_juridica_id'] = $pessoa_id;
            $dados['pessoa_fisica_id'] = null;
        }

        $consulta = DbModel::consultaSimples("SELECT id FROM pedidos WHERE origem_tipo_id = $origem_tipo AND origem_id = $origem_id AND publicado = 1");
        if ($consulta ->rowCount()<1){
            $pedido = DbModel::insert("pedidos",$dados);
            if($pedido->rowCount()>0){
                $_SESSION['pedido_id_c'] = MainModel::encryption(DbModel::connection()->lastInsertId());
                return true;
            } else{
                return false;
            }
        }
        else{
            $idPedido = $consulta->fetch()['id'];
            $pedido = DbModel::update("pedidos",$dados,$idPedido);
            if($pedido->rowCount() >= 1 || DbModel::connection()->errorCode() == 0){
                $_SESSION['pedido_id_c'] = MainModel::encryption($idPedido);
                return true;
            } else{
                return false;
            }
        }
    }

    protected function buscaProponente($pessoa_tipo, $id) {
        if ($pessoa_tipo == 1) {
            $proponentePf = DbModel::consultaSimples(
                "SELECT id, nome, cpf, passaporte, email FROM pessoa_fisicas WHERE id = '$id'"
            )->fetch(PDO::FETCH_ASSOC);

            $dadosProponente = new stdClass();

            foreach ($proponentePf as $key => $proponente) {
                if ($key == 'cpf' || $key == 'passaporte') {
                    $dadosProponente->documento = $proponentePf['cpf'] ? $proponentePf['cpf'] : $proponentePf['passaporte'];
                } else {
                    $dadosProponente->$key = $proponente;
                }
            }
            $telefones = DbModel::consultaSimples("SELECT telefone FROM pf_telefones WHERE pessoa_fisica_id = '$id'")->fetchAll(PDO::FETCH_COLUMN);
            foreach ($telefones as $key => $telefone) {
                $index = "telefone".($key+1);
                $dadosProponente->$index = $telefone;
            }
        } else {
            $dadosProponente = DbModel::consultaSimples(
                "SELECT id, razao_social AS 'nome', cnpj AS 'documento', email, representante_legal1_id FROM pessoa_juridicas WHERE id = '$id'"
            )->fetchObject();
        }

        return $dadosProponente;
    }
}