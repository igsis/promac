<?php
if ($pedidoAjax) {
    require_once "../models/MainModel.php";
} else {
    require_once "./models/MainModel.php";
}


class LiderModel extends MainModel
{
    public function insere($idPedido,$idAtracao,$idPf){
        $dados = [
            'pedido_id' => $idPedido,
            'atracao_id' => $idAtracao,
            'pessoa_fisica_id' => $idPf
        ];

        $consulta = DbModel::consultaSimples("SELECT id FROM lideres WHERE pedido_id = '$idPedido' AND atracao_id = '$idAtracao'");
        if ($consulta ->rowCount()<1){
            DbModel::insert("lideres",$dados);
            if(DbModel::connection()->errorCode() == 0){
                return true;
            } else{
                return false;
            }
        }
        else{
            $idLider = $consulta->fetch()['id'];
            DbModel::update("lideres",$dados,$idLider);
            if(DbModel::connection()->errorCode() == 0){
                return true;
            } else{
                return false;
            }
        }
    }
}