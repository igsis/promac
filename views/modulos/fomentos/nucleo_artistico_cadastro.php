<?php
require_once "./controllers/IntegranteController.php";

$integranteObj =  new IntegranteController();

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    $pf = $integranteObj->recuperaIntegrante($id);
}

if (isset($_POST['cpf'])){
    $cpf = $_POST['cpf'];
    $pf = $integranteObj->recuperaIntegranteCpf($cpf);
    if ($pf) {
        $id = (new MainModel)->encryption($pf['id']);
    }
}

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Novo integrante do núcleo artístico</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Dados</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST"
                          action="<?= SERVERURL ?>ajax/integranteAjax.php" role="form"
                          data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editaIntegranteFomento" : "cadastraIntegranteFomento" ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col form-group">
                                    <label for="nome">Nome Completo:</label>
                                    <input type="text" class="form-control" name="nome" id="nome" value="<?= $pf['nome'] ?? '' ?>">
                                </div>
                                <div class="col form-group">
                                    <label for="cpf">CPF:</label>
                                    <input type="text" class="form-control" name="cpf" readonly value="<?= $pf['cpf'] ?? $_POST['cpf'] ?>">
                                </div>
                                <div class="col form-group">
                                    <label for="rg">RG:</label>
                                    <input type="text" class="form-control" name="rg" value="<?= $pf['rg'] ?? '' ?>">
                                </div>
                            </div>
                        </div>

                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
                            <a href="<?=SERVERURL?>fomentos/nucleo_artistico_lista" class="btn btn-default float-left">Voltar</a>
                        </div>
                        <!-- /.card-footer -->
                        <div class="resposta-ajax"></div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->

    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script type="text/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#nucleo_artistico').addClass('active');
    });
</script>