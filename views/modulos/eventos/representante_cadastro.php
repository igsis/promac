<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
require_once "./controllers/RepresentanteController.php";
$insRepresentante = new RepresentanteController();
$representante = $insRepresentante->recuperaRepresentante($id)->fetch();

$idPj = isset($_POST['idPj']) ? $_POST['idPj'] : $_GET['idPj'];

if ($id) {
    $representante = $insRepresentante->recuperaRepresentante($id)->fetch();
    $documento = $representante['cpf'];
}

if (isset($_POST['cpf'])){
    $documento = $_POST['cpf'];
    $representante = $insRepresentante->getCPF($documento)->fetch();
    if ($representante){
        $id = MainModel::encryption($representante['id']);
        $representante = $insRepresentante->recuperaRepresentante($id)->fetch();
        $documento = $representante['cpf'];
    }
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de representante legal</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/representanteAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="idPj" value="<?= $idPj ?>">
                        <input type="hidden" name="pagina" value="eventos">
                        <?php if (isset($_POST['representante'])): ?>
                            <input type="hidden" name="representante" value="<?= $_POST['representante'] ?>">
                        <?php endif; ?>
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nome">Nome: *</label>
                                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome completo" maxlength="70" value="<?= $representante['nome'] ?? ' ' ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="rg">RG: </label>
                                    <input type="text" class="form-control" id="rg" name="rg" maxlength="20" value="<?= $representante['rg'] ?? ' ' ?>" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="cpf">CPF: </label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $documento ?>" required readonly>
                                </div>
                            </div>
                        </div>
                        <div class="resposta-ajax"></div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
                    </form>
                    <form class="form-horizontal" method="POST" action="<?= SERVERURL ?>eventos/pj_cadastro&id=<?= $idPj ?>" role="form">
                        <button type="submit" class="btn btn-default float-left">Voltar</button>
                    </form>
                        </div>
                        <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->