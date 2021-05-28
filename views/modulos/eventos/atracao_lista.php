<?php
require_once "./controllers/AtracaoController.php";
if (isset($_SESSION['atracao_id_c'])) {
    unset($_SESSION['atracao_id_c']);
}

$evento_id = $_SESSION['origem_id_c'];

$atracaoObj = new AtracaoController();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Atrações</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <a href="<?= SERVERURL ?>eventos/atracao_cadastro"><button class="btn btn-success btn-block">Adicionar</button></a>
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
                        <h3 class="card-title">Atrações Cadastrados</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Nome da Atração</th>
                                    <th>Produtor</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($atracaoObj->listaAtracoes($evento_id) as $atracao): ?>
                                <tr>
                                    <td><?=$atracao->nome_atracao?></td>
                                    <td>
                                        <?php if (!$atracao->produtor_id): ?>
                                            <form action="<?=SERVERURL."eventos/produtor_cadastro"?>" method="post">
                                                <input type="hidden" name="atracao_id" value="<?=$atracaoObj->encryption($atracao->id)?>">
                                                <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-plus"></i>Adicionar Produtor</button>
                                            </form>
                                        <?php else: ?>
                                            <a href="<?=SERVERURL."eventos/produtor_cadastro&key=".$atracaoObj->encryption($atracao->produtor_id)?>">
                                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> <?=$atracao->produtor->nome?></button>
                                            </a>
                                        <?php endif; ?>

                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                <a href="<?=SERVERURL."eventos/atracao_cadastro&key=".$atracaoObj->encryption($atracao->id)?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                            </div>
                                            <div class="col">
                                                <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/atracaoAjax.php" role="form" data-form="update">
                                                    <input type="hidden" name="_method" value="apagaAtracao">
                                                    <input type="hidden" name="id" value="<?=$atracao->id?>">
                                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Apagar</button>
                                                    <div class="resposta-ajax"></div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nome da Atração</th>
                                    <th>Produtor</th>
                                    <th>Ação</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->

                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#atracao_lista').addClass('active');
    })
</script>