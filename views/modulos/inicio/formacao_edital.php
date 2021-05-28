<?php
if (isset($_SESSION)) {
    session_unset();
}
require_once "./controllers/FormacaoController.php";
$formacaoObj = new FormacaoController();
$now = date('Y-m-d H:i:s');
$formacaos = $formacaoObj->listaAbertura();
?>
<div class="background">
    <div class="content-header bg-dark mb-5 elevation-5">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center justify-content-around">
                <div class="col-sm-10 bg-dark">
                    <a href="<?= SERVERURL ?>" class="brand-link">
                        <img src="<?= SERVERURL ?>views/dist/img/AdminLTELogo.png" alt="CAPAC Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                        <span class="brand-text font-weight-light"><?= NOMESIS ?> - Formação</span>
                    </a>
                </div>
                <div class="col-sm-1 mr-5">
                    <img src="<?= SERVERURL ?>views/dist/img/CULTURA_PB_NEGATIVO_HORIZONTAL.png" alt="logo cultura">
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="container-fluid">
            <?php if (count($formacaos)): ?>
                <?php foreach ($formacaos as $formacao): ?>
                    <div class="row">
                        <div class="offset-1 col-10">
                            <div class="card card-dark card-outline elevation-5">
                                <div class="card-header" data-card-widget="collapse" style="cursor: pointer;">
                                    <h3 class="card-title"><?= $formacao->titulo ?></h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <?= nl2br($formacao->descricao) ?>
                                </div>
                                <div class="card-footer">
                                    <?php if ($formacao->data_abertura <= $now && $now <= $formacao->data_encerramento): ?>
                                        <a href="login&modulo=5&edital=<?= $formacaoObj->encryption($formacao->id) ?>"
                                           class="small-box-footer">
                                            Inscreva-se <i class="fas fa-arrow-circle-right"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-md-6 -->
                    </div>
                    <!-- /.row -->
                <?php endforeach; ?>
            <?php else: ?>
                <div class="row">
                    <div class="offset-1 col-10">
                        <div class="card card-dark card-outline collapsed-card elevation-5">
                            <div class="card-header" style="cursor: default;">
                                <h3 class="card-title">Não existe edital aberto no momento</h3>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            <?php endif; ?>
        </div>
        <!-- /.container-fluid -->
    </div>
</div>