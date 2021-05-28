<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
} else {
    require_once "./models/ValidacaoModel.php";
}

class EventoModel extends ValidacaoModel
{
    protected function recuperaEventoFomento($id) {
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

    protected function recuperaEventoPublico($id) {
        $pdo = DbModel::connection();
        $sql = "SELECT ep.publico_id FROM evento_publico AS ep
                INNER JOIN publicos AS p on ep.publico_id = p.id
                WHERE ep.evento_id = :eventoId";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(':eventoId', $id);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    protected function getEvento($id) {
        $evento = DbModel::getInfo('eventos', $id)->fetchObject();
        if ($evento) {
            $evento->fomento_id = $this->recuperaEventoFomento($id)['fomento_id'];
            $evento->fomento_nome = $this->recuperaEventoFomento($id)['fomento'];
            $evento->publicos = (object) $this->recuperaEventoPublico($id);
        }
        return $evento;
    }

    protected function validaEventoModel($evento_id, $pedido_id)
    {
        $evento = DbModel::getInfo('eventos', $evento_id)->fetch(PDO::FETCH_ASSOC);

        $erros = ValidacaoModel::retornaMensagem($evento);

        if ($evento['fomento'] == 1) {
            $fomento = DbModel::consultaSimples("SELECT * FROM evento_fomento WHERE evento_id = '$evento_id'");
            if ($fomento->rowCount() == 0) {
                $erros['fomento']['bol'] = true;
                $erros['fomento']['motivo'] = "O evento será fomentado, porém nenhum fomento foi selecionado";
            }
        }

        $publicos = DbModel::consultaSimples("SELECT * FROM evento_publico WHERE evento_id = '$evento_id'");
        if ($publicos->rowCount() == 0) {
            $erros['publicos']['bol'] = true;
            $erros['publicos']['motivo'] = "Nenhuma Representatividade e Visibilidade Sócio-cultural selecionada para este evento";
        }

        $atracoes = DbModel::consultaSimples("SELECT * FROM atracoes WHERE evento_id = '$evento_id'");
        if ($atracoes->rowCount() == 0) {
            $erros['atracoes']['bol'] = true;
            $erros['atracoes']['motivo'] = "Nenhuma atração cadastrada para este evento";
        }

        $validaArquivos = ValidacaoModel::validaArquivos(3, $pedido_id);
        if ($validaArquivos) {
            if (!isset($erros) || $erros == false) { $erros = []; }
            $erros = array_merge($erros, $validaArquivos);
        }

        if (isset($erros)){
            return $erros;
        } else {
            return false;
        }
    }
}