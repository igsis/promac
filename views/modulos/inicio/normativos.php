<?php
if (isset($_SESSION))
    session_unset();

require_once "./controllers/NormativoController.php";
$normObj = new NormativoController();
$tipos = $normObj->listaTipoNormativo();
?>
<div class="background">
    <!-- Content Header (Page header) -->
    <div class="content-header bg-dark mb-5 elevation-5">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center justify-content-around">
                <div class="col-sm-10 bg-dark">
                    <a href="<?= SERVERURL ?>" class="brand-link">
                        <img src="<?= SERVERURL ?>views/dist/img/pin_promac.png" alt="PROMAC Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                        <span class="brand-text font-weight-light"><?= NOMESIS ?> - Normativos</span>
                    </a>
                </div>
                <div class="col-sm-1 mr-5">
                    <img src="<?= SERVERURL ?>views/dist/img/CULTURA_PB_NEGATIVO_HORIZONTAL.png" alt="logo cultura">
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <?php foreach ($tipos as $tipo): ?>
                <div class="row">
                    <div class="offset-1 col-10">
                        <div class="card card-dark card-outline elevation-5">
                            <div class="card-header" data-card-widget="collapse" style="cursor: pointer;">
                                <h3 class="card-title"><?= $tipo->tipo ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <?php
                                    $normativos = $normObj->listaNormativos($tipo->id);
                                    foreach ($normativos as $normativo){
                                        echo "<li><a href='pdf/$normativo->arquivo' target='_blank'>$normativo->titulo</a> </li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            <?php endforeach; ?>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>