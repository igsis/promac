<?php
include "visual/cabecalho_index.php";
include "funcoes/funcoesConecta.php";
include "funcoes/funcoesGerais.php";
$con = bancoMysqli();

if (isset($_POST['enviarSenha'])) {
    $idUsuario = $_POST['id'];
    $tipoPessoa = $_POST['tipoPessoa'];

    if (strripos($tipoPessoa, "pessoa_fisica") === false) {
        $campo = 'idPj';
    } else {
        $campo = 'idPf';
    }

    if (($_POST['senha01'] != "") and (strlen($_POST['senha01']) >= 5)) {
        if ($_POST['senha01'] == $_POST['senha02']) {
            $senha01 = md5($_POST['senha01']);
            $sql_senha = "UPDATE `{$tipoPessoa}` SET `senha` = '$senha01' WHERE `{$campo}` = '{$idUsuario}';";
            $query_senha = mysqli_query($con, $sql_senha);

            if ($query_senha) {
                $mensagem = "<font color='#33cc33'><strong>Senha alterada com sucesso! Aguarde que você será redirecionado para a página de login</strong></font>";
                gravarLogSenha($sql_senha, $idUsuario);
                echo "<script type=\"text/javascript\">
						  window.setTimeout(\"location.href='index.php';\", 4000);
						</script>";
            } else {
                $mensagem = "<font color='#FF0000'><strong>Não foi possível mudar a senha! Tente novamente.</strong></font>";
                echo "<script type=\"text/javascript\">
						  window.setTimeout(\"location.href='reset_senha.php?tipoPessoa={$_GET['tipoPessoa']}&token={$_GET['token']}';\", 3000);
						</script>";
            }
        } else {
            $mensagem = "<font color='#FF0000'><strong>Senhas não conferem! Tente novamente.</strong></font>";
            echo "<script type=\"text/javascript\">
						  window.setTimeout(\"location.href='reset_senha.php?tipoPessoa={$_GET['tipoPessoa']}&token={$_GET['token']}';\", 3000);
						</script>";
        }
    } else {
        $mensagem = "<font color='#FF0000'><strong>Senha de conter um minímo de 5 dígitos</strong></font>";
    }
}

?>

<section id="contact" class="home-section bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <h6>ESQUECEU SUA SENHA?</h6>
                <h5><?php if (isset($mensagem)) {
                        echo $mensagem;
                    } ?></h5>
                <hr>
                <?php if (isset($_GET['token'])) { ?>
                    <!-- Setando a nova senha -->
                    <form method="POST"
                          action="reset_senha.php?tipoPessoa=<?= $_GET['tipoPessoa'] ?>&token=<?= $_GET['token'] ?>">
                        <div class="col-md-offset-4 col-md-4">
                            <div class="form-group">
                                <label>Digite sua nova senha:</label>
                                <input type="password" name="senha01" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Confirme sua nova senha:</label>
                                <input type="password" name="senha02" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="tipoPessoa"
                                       value="<?= base64_decode($_GET['tipoPessoa']) ?>">
                                <input type="hidden" name="id" value="<?= base64_decode($_GET['token']) ?>">
                                <input type="submit" name="enviarSenha" value="Enviar"
                                       class="btn btn-theme btn-md btn-block form-control">
                            </div>
                        </div>
                    </form>
                    <?php
                } else { ?>
                    <font color='#FF0000'><strong>Erro de dados incompletos</strong></font>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php include "visual/rodape_index.php" ?>
