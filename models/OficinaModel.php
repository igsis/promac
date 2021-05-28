<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
} else {
    require_once "./models/ValidacaoModel.php";
}

class OficinaModel extends ValidacaoModel
{
    protected function limparStringOficina($dados)
    {
        unset($dados['_method']);

        foreach ($dados as $campo => $post) {
            $dig = explode("_",$campo)[0];
            switch ($dig) {
                case "ev":
                    $campo = substr($campo, 3);
                    if (($campo != "publicos") && ($campo != "fomento_id")) {
                        $dadosLimpos['ev'][$campo] = MainModel::limparString($post);
                    } else {
                        $dadosLimpos['ev'][$campo] = $post;
                    }
                    break;
                case "at":
                    $campo = substr($campo, 3);
                    if ($campo == 'valor_individual'){
                        $post = MainModel::dinheiroDeBr($post);
                        $dadosLimpos['at'][$campo] = MainModel::limparString($post);
                    } else {
                        $dadosLimpos['at'][$campo] = MainModel::limparString($post);
                    }
                    break;
            }
        }
        $dadosLimpos['at']['nome_atracao'] = $dadosLimpos['ev']['nome_evento'];
        $dadosLimpos['at']['release_comunicacao'] = $dadosLimpos['ev']['sinopse'];
        return $dadosLimpos;
    }

    protected function recuperaOficinaFomento($id) {
        $pdo = DbModel::connection();
        $sql = "SELECT ef.fomento_id, f.fomento FROM evento_fomento AS ef
                INNER JOIN fomentos AS f on ef.fomento_id = f.id
                WHERE ef.evento_id = :eventoId";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':eventoId', $id);
        $statement->execute();
        $fomento = $statement->fetch();
        return $fomento;
    }

    protected function recuperaOficinaPublico($id) {
        $pdo = DbModel::connection();
        $sql = "SELECT ep.publico_id FROM evento_publico AS ep
                INNER JOIN publicos AS p on ep.publico_id = p.id
                WHERE ep.evento_id = :eventoId";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':eventoId', $id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }


    protected function getOficina($id) {
        $sql = "SELECT e.*, a.ficha_tecnica, a.integrantes, a.classificacao_indicativa_id, a.links, a.valor_individual, a.id AS 'atracao_id' FROM eventos AS e INNER JOIN atracoes AS a ON e.id = a.evento_id WHERE e.id = '$id'";
        $oficina = DbModel::consultaSimples($sql)->fetchObject();
        if ($oficina) {
            $oficina->fomento_id = $this->recuperaOficinaFomento($id)['fomento_id'];
            $oficina->fomento_nome = $this->recuperaOficinaFomento($id)['fomento'];
            $oficina->publicos = (object) $this->recuperaOficinaPublico($id);
        }
        return $oficina;
    }
}