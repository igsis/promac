<?php
if (isset($_SESSION['atracao_id_c'])) {
    $atracao_id = $_SESSION['atracao_id_c'];
} elseif (isset($_POST['atracao_id'])) {
    $atracao_id = $_SESSION['atracao_id_c'] = $_POST['atracao_id'];
} else {
    $atracao_id = null;
}

$id = $_GET['key'] ?? null;

require_once "./controllers/ProdutorController.php";
$insProdutor = new ProdutorController();
$produtor = $insProdutor->recuperaProdutor($id)->fetchObject();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Produtor</h1>
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
                        <h3 class="card-title">Dados do Produtor</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/produtorAjax.php" role="form" data-form="<?= ($produtor) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($produtor) ? "editarProdutor" : "cadastrarProdutor" ?>">
                        <input type="hidden" name="atracao_id" value="<?=$atracao_id?>" <?=$produtor ? "disabled" : ""?>>
                        <input type="hidden" name="modulo" value="<?=$modulo?>">
                        <?php if ($produtor): ?>
                            <input type="hidden" name="produtor_id" value="<?= $produtor->id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="nome">Nome: *</label>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome completo" maxlength="120" value="<?=($produtor) ? $produtor->nome : ""?>" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">E-mail: *</label>
                                    <input type="email" class="form-control" id="email" name="email" maxlength="60" placeholder="Digite o e-mail" value="<?=($produtor) ? $produtor->email : ""?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="telefone1">Telefone #1: *</label>
                                    <input type="text" data-mask="(00) 00000-0000" class="form-control" id="telefone" name="telefone1" maxlength="15" onkeyup="mascara( this, mtel );" placeholder="Digite o Telefone principal" value="<?=($produtor) ? $produtor->telefone1 : ""?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="telefone2">Telefone #2</label>
                                    <input type="text" data-mask="(00) 00000-0000" class="form-control" id="telefone" name="telefone2" maxlength="15" onkeyup="mascara( this, mtel );" placeholder="Digite o Telefone secundário" value="<?=($produtor) ? $produtor->telefone2 : ""?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="observacao">Observação</label>
                                    <textarea name="observacao" id="observacao" class="form-control" rows="3"><?=($produtor) ? $produtor->observacao : ""?></textarea>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
                        </div>
                        <!-- /.card-footer -->
                        <div class="resposta-ajax">

                        </div>
                    </form>

                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
