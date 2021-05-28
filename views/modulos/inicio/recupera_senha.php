
<div class="login-page">
    <div class="card">
        <div class="card-header bg-dark">
            <a href="<?= SERVERURL ?>inicio" class="brand-link">
                <img src="<?= SERVERURL ?>views/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?= NOMESIS ?></span>
            </a>
        </div>
        <div class="card-body register-card-body">
            <p class="card-text"><span style="text-align: justify; display:block;"> Para recuperar senha digite o e-mail usado no cadastro.</span></p>
            <p><?= isset($message) ? $message : '' ?></p>
            <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/recuperaSenhaAjax.php" role="form"
                  data-form="recover">
                <input type="hidden" name="_method" value="check">
                <label>E-mail</label>
                <div class="input-group mb-3">
                    <input name="email" id="email" type="email" class="form-control" placeholder="Email" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Enviar</button>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="resposta-ajax"></div>
            </form>
            <div class="mb-0 text-left">
                <p class="mb-1">
                    <a href="<?= SERVERURL ?>">Voltar a Tela de Login</a>
                </p>
            </div>
        </div>
        <div class="card-footer bg-light-gradient text-center">
            <img src="<?= SERVERURL ?>views/dist/img/CULTURA_HORIZONTAL_pb_positivo.png" alt="logo cultura">
        </div>
    </div><!-- /.card -->
</div>