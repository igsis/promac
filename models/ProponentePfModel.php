<?php
if ($pedidoAjax) {
    require_once "../models/ValidacaoModel.php";
} else {
    require_once "./models/ValidacaoModel.php";
}

class ProponentePfModel extends ValidacaoModel
{
    protected function limparStringPF($dados)
    {
        unset($dados['_method']);
        unset($dados['pagina']);

        if (isset($dados['projeto_id'])) {
            unset($dados['projeto_id']);
        }

        /* executa limpeza nos campos */

        foreach ($dados as $campo => $post) {
            $dig = explode("_", $campo)[0];
            if (!empty($dados[$campo]) || ($dig == "pf")) {
                switch ($dig) {
                    case "pf":
                        $campo = substr($campo, 3);
                        $dadosLimpos['pf'][$campo] = MainModel::limparString($post);
                        break;
                    case "en":
                        $campo = substr($campo, 3);
                        $dadosLimpos['en'][$campo] = MainModel::limparString($post);
                        break;
                    case "te":
                        if ($dados[$campo] != '') {
                            $dadosLimpos['telefones'][$campo]['telefone'] = MainModel::limparString($post);
                        }
                        break;
                    case "le":
                        $campo = substr($campo, 3);
                        $dadosLimpos['lei'][$campo] = MainModel::limparString($post);
                        break;
                }
            }
        }

        return $dadosLimpos;
    }
}