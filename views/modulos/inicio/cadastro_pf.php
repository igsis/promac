<?php
$url = SERVERURL.'api/verificadorEmail.php';

if ($_GET['tipo'] == 'pf') {
    $tipo_cadastro = "proponente_pfs";
} elseif ($_GET['tipo'] == 'incentivador_pf') {
    $tipo_cadastro = "incentivador_pfs";
} else {
    echo '<script> window.location.href="'. SERVERURL .'" </script>';
}

?>
<div class="login-page">
    <div class="card">
        <div class="card-header bg-dark">
            <a href="<?= SERVERURL ?>inicio" class="brand-link">
                <img src="<?= SERVERURL ?>views/dist/img/AdminLTELogo.png" alt="CAPAC Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?= NOMESIS ?> - Cadastro de Artistas e Profissionais de Arte e Cultura</span>
            </a>
        </div>
        <div class="card-body register-card-body">
            <h5 class="login-box-msg">Efetue seu Cadastro</h5>
            <p class="card-text"><span style="text-align: justify; display:block;"> Confira seus dados antes de clicar no botão "Cadastrar".</span></p>

            <?php if ($tipo_cadastro == "proponente_pfs"): ?>
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção!</h5>
                    O cadastrado Pessoa Física não pode ser servidor da SMC e necessita morar há pelo menos 2 anos no
                    município de São Paulo.
                </div>
            <?php endif ?>

            <form class="needs-validation formulario-ajax" data-form="save"
                  action="<?= SERVERURL ?>ajax/usuarioAjax.php" method="post" id="formularioPf">
                <input type="hidden" name="_method" value="insereLoginPf">
                <input type="hidden" name="tipo_cadastro" id="tipo_cadastro" value="<?= $tipo_cadastro ?>">

                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="nome" placeholder="Nome Completo" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        <strong>Insira seu Nome Completo</strong>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="cpf" placeholder="CPF" id="cpf" required maxlength="14" onkeypress="mask(this, '999.999.999-99')">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-id-card"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        <strong>Insira um CPF válido</strong>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Email" required id="email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        <strong>Email já cadastrado</strong>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="senha" placeholder="Senha" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        <strong>Insira sua Senha</strong>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="senha2" placeholder="Confirme sua Senha" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div class="invalid-feedback">
                        <strong>Confirme sua Senha</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" id="cadastra">Cadastrar</button>
                </div>
                <div class="resposta-ajax">

                </div>
            </form>

            <div class="mb-0 text-center">
                <a href="<?= SERVERURL ?>" class="text-center">Já possuo Cadastro</a>
            </div>
        </div>
        <div class="card-footer bg-light-gradient text-center">
            <img src="<?= SERVERURL ?>views/dist/img/CULTURA_HORIZONTAL_pb_positivo.png" alt="logo cultura">
        </div>
    </div><!-- /.card -->
</div>

<script>
    const url = `<?= $url ?>`;
    var email = $('#email');
    var tipoCadastro = $('#tipo_cadastro');

    email.blur(function () {
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                "email": email.val(),
                "tabela": tipoCadastro.val()
            },

            success: function (data) {
                if (data.ok) {
                    email.removeClass("is-invalid");
                    $("#cadastra").attr('disabled', false);
                } else {
                    email.addClass("is-invalid");
                    $("#cadastra").attr('disabled', true);
                }
            }
        })
    })
</script>