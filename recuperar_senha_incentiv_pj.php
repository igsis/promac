<?php
include "visual/cabecalho_index.php";
include "funcoes/funcoesConecta.php";
include "funcoes/funcoesGerais.php";

include "funcoes/funcaoEmail.php";

$con = bancoMysqli();

if (isset($_POST['enviarEmail'])) {
    $email = $_POST['email'];
    $sql = "SELECT email FROM incentivador_pessoa_juridica WHERE email = '$email'";
    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);
    if ($num > 0) {
        $pf = recuperaDados("incentivador_pessoa_juridica", "email", $email);
        $mensagem = enviaEmail($email, base64_encode($pf['idPj']), base64_encode('incentivador_pessoa_juridica'));
    } else {
        $mensagem = "<font color='#ff0000'><strong>E-mail não encontrado em nossa base de dados.</strong></font>";
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

                    <!-- Solicitando E-mail -->
                    <form method="POST" action="./recuperar_senha_pf.php">
                        <div class="col-md-offset-4 col-md-4">
                            <div class="form-group">
                                <label>Digite Seu E-mail:</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="enviarEmail" value="Enviar"
                                       class="btn btn-theme btn-md btn-block form-control" required>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php include "visual/rodape_index.php" ?>