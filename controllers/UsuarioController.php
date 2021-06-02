<?php

if ($pedidoAjax) {
    require_once "../models/UsuarioModel.php";
} else {
    require_once "./models/UsuarioModel.php";
}


class UsuarioController extends UsuarioModel
{

    public function iniciaSessao($tipo_acesso) {
        $login = MainModel::limparString($_POST['login']);
        $senha = MainModel::limparString($_POST['senha']);
        $senha = MainModel::encryption($senha);

        $dadosLogin = [
            'tabela' => $tipo_acesso,
            'login' => $login,
            'senha' => $senha
        ];

        if (($tipo_acesso == 'proponente_pfs') || ($tipo_acesso == 'incentivador_pfs')) {
            $campo = "cpf";
            $coluna = "nome";
        } elseif (($tipo_acesso == 'proponente_pjs') || ($tipo_acesso == 'incentivador_pjs')) {
            $campo = "cnpj";
            $coluna = "razao_social";
        } else {
            $campo = "email";
            $coluna = "nome";
        }

        $usuarioExiste = UsuarioModel::usuarioExiste($dadosLogin, $campo);

        if ($usuarioExiste){
            $consultaUsuario = UsuarioModel::getUsuario($dadosLogin, $campo, $coluna);

            if ($consultaUsuario->rowCount() == 1) {
                $usuario = $consultaUsuario->fetch();

                session_start(['name' => 'prmc']);
                $_SESSION['usuario_id_p'] = $usuario['id'];
                $_SESSION['nome_p'] = $usuario['nome'];

                MainModel::gravarLog('Fez Login');
            } else {
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Usuário / Senha incorreto',
                    'tipo' => 'error'
                ];

                return MainModel::sweetAlert($alerta);
            }
        }
        else{
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Usuário não existe',
                'tipo' => 'error'
            ];
            return MainModel::sweetAlert($alerta);
        }
    }

    public function forcarFimSessao() {
        session_destroy();
        return header("Location: ".SERVERURL);
    }

    public function insereUsuario() {
        $erro = false;

        $token = $_POST['token'];
        unset($_POST['token']);

        $dados = [];
        foreach ($_POST as $campo => $post) {
            if (($campo != "senha2") && ($campo != "_method")) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }

        // Valida Senha
        if ($_POST['senha'] != $_POST['senha2']) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "As senhas inseridas não conferem. Tente novamente",
                'tipo' => "error"
            ];
        }

        // Valida email unique
        $nivel_acesso = DbModel::consultaSimples("SELECT id FROM nivel_acessos WHERE token = '$token'")->fetchColumn();
        if (!$nivel_acesso) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "Código de acesso inválido. Tente novamente.",
                'tipo' => "error"
            ];
        } else {
            $dados['nivel_acesso_id'] = $nivel_acesso;
        }

        // Valida token de cadastro
        $consultaEmail = DbModel::consultaSimples("SELECT email FROM usuarios WHERE email = '{$dados['email']}'");
        if ($consultaEmail->rowCount() >= 1) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "Email inserido já cadastrado. Tente novamente.",
                'tipo' => "error"
            ];
        }

        if (!$erro) {
            $dados['senha'] = MainModel::encryption($dados['senha']);
            $insere = DbModel::insert('usuarios', $dados);
            if ($insere) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Usuário Cadastrado!',
                    'texto' => 'Usuário cadastrado com Sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL
                ];
            }
        }
        return MainModel::sweetAlert($alerta);
    }

    /* edita */
    public function editaUsuario($dados, $id){
        unset($dados['_method']);
        unset($dados['id']);
        $dados = MainModel::limpaPost($dados);
        $edita = DbModel::update('usuarios', $dados, $id);
        if ($edita) {
            $alerta = [
                'alerta' => 'sucesso',
                'titulo' => 'Usuário',
                'texto' => 'Informações alteradas com sucesso!',
                'tipo' => 'success',
                'location' => SERVERURL.'inicio/edita'
            ];
        } else {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => 'Erro!',
                'texto' => 'Erro ao salvar!',
                'tipo' => 'error',
                'location' => SERVERURL.'inicio/edita'
            ];
        }
        return MainModel::sweetAlert($alerta);
    }

    public function trocaSenha($dados,$id){
        // Valida Senha
        if ($_POST['senha'] != $_POST['senha2']) {
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "As senhas inseridas não conferem. Tente novamente",
                'tipo' => "error"
            ];
        }
        else{
            unset($dados['_method']);
            unset($dados['id']);
            unset($dados['senha2']);
            $dados = MainModel::limpaPost($dados);
            $dados['senha'] = MainModel::encryption($dados['senha']);
            $edita = DbModel::update('usuarios', $dados, $id);
            if ($edita) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Usuário',
                    'texto' => 'Senha alterada com sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL.'inicio/edita'
                ];
            }
            else{
                $alerta = [
                    'alerta' => 'simples',
                    'titulo' => 'Erro!',
                    'texto' => 'Erro ao salvar!',
                    'tipo' => 'error',
                    'location' => SERVERURL.'inicio/edita'
                ];
            }
        }
        return MainModel::sweetAlert($alerta);
    }

    public function recuperaUsuario($id) {
        $usuario = DbModel::getInfo('usuarios',$id);
        return $usuario;
    }

    public function recuperaEmail($email){
        return UsuarioModel::getExisteEmail($email);;
    }

    public function insereLoginPf($tipo_cadastro)
    {
        unset($_POST['tipo_cadastro']);

        $tabela = $tipo_cadastro;

        $erro = false;
        $dados = [];
        foreach ($_POST as $campo => $post) {
            if (($campo != "senha2") && ($campo != "_method")) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }

        // Valida Senha
        if ($_POST['senha'] != $_POST['senha2']) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "As senhas inseridas não conferem. Tente novamente",
                'tipo' => "error"
            ];
        }

        // Valida email unique
        $consultaEmail = DbModel::consultaSimples("SELECT email FROM $tabela WHERE email = '{$dados['email']}'");
        if ($consultaEmail->rowCount() >= 1) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "Email inserido já cadastrado. Tente novamente.",
                'tipo' => "error"
            ];
        }

        // Valida cpf unique
        $consultaEmail = DbModel::consultaSimples("SELECT cpf FROM $tabela WHERE cpf = '{$dados['cpf']}'");
        if ($consultaEmail->rowCount() >= 1) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "CPF inserido já cadastrado. Tente novamente.",
                'tipo' => "error"
            ];
        }

        if (!$erro) {
            $dados['senha'] = MainModel::encryption($dados['senha']);
            $insere = DbModel::insert($tabela, $dados);
            if ($insere) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Usuário Cadastrado!',
                    'texto' => 'Usuário cadastrado com Sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL
                ];
            }
        }
        return MainModel::sweetAlert($alerta);
    }

    public function insereLoginPj($tipo_cadastro)
    {
        unset($_POST['tipo_cadastro']);

        $tabela = $tipo_cadastro;

        $erro = false;
        $dados = [];
        foreach ($_POST as $campo => $post) {
            if (($campo != "senha2") && ($campo != "_method")) {
                $dados[$campo] = MainModel::limparString($post);
            }
        }

        // Valida Senha
        if ($_POST['senha'] != $_POST['senha2']) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "As senhas inseridas não conferem. Tente novamente",
                'tipo' => "error"
            ];
        }

        // Valida email unique
        $consultaEmail = DbModel::consultaSimples("SELECT email FROM $tabela WHERE email = '{$dados['email']}'");
        if ($consultaEmail->rowCount() >= 1) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "Email inserido já cadastrado. Tente novamente.",
                'tipo' => "error"
            ];
        }

        // Valida cpf unique
        $consultaEmail = DbModel::consultaSimples("SELECT cnpj FROM $tabela WHERE cnpj = '{$dados['cnpj']}'");
        if ($consultaEmail->rowCount() >= 1) {
            $erro = true;
            $alerta = [
                'alerta' => 'simples',
                'titulo' => "Erro!",
                'texto' => "CNPJ inserido já cadastrado. Tente novamente.",
                'tipo' => "error"
            ];
        }

        if (!$erro) {
            $dados['senha'] = MainModel::encryption($dados['senha']);
            $insere = DbModel::insert($tabela, $dados);
            if ($insere) {
                $alerta = [
                    'alerta' => 'sucesso',
                    'titulo' => 'Usuário Cadastrado!',
                    'texto' => 'Usuário cadastrado com Sucesso!',
                    'tipo' => 'success',
                    'location' => SERVERURL
                ];
            }
        }
        return MainModel::sweetAlert($alerta);
    }
}
