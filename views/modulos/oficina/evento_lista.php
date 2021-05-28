<?php
require_once "./controllers/EventoController.php";
if (isset($_SESSION['origem_id_c'])) {
    unset($_SESSION['origem_id_c']);
    unset($_SESSION['atracao_id_c']);
}
if(isset($_SESSION['pedido_id_c'])){
    unset($_SESSION['pedido_id_c']);
}

$oficinaObj = new EventoController();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Oficinas</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <a href="<?= SERVERURL ?>oficina/evento_cadastro"><button class="btn btn-success btn-block">Adicionar</button></a>
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
                        <h3 class="card-title">Oficinas cadastradas</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Código CAPAC</th>
                                    <th>Nome da oficina</th>
                                    <th>Data cadastro</th>
                                    <th>Enviado</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($oficinaObj->listaEvento($_SESSION['usuario_id_c'], $_SESSION['modulo_c']) as $oficina): ?>
                                <tr>
                                    <td><?=$oficina->publicado == 2 ? $oficina->id : "Envie para obter o código"?></td>
                                    <td><?=$oficina->nome_evento?></td>
                                    <td><?=$oficinaObj->dataHora($oficina->data_cadastro)?></td>
                                    <td><?=$oficina->publicado == 1 ? "Não" : "Sim"?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                <a href="<?=SERVERURL."oficina/evento_cadastro&key=".$oficinaObj->encryption($oficina->id)?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                            </div>
                                            <div class="col">
                                                <?php if ($oficina->publicado == 1): ?>
                                                    <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/oficinaAjax.php" role="form" data-form="update">
                                                        <input type="hidden" name="_method" value="apagaOficina">
                                                        <input type="hidden" name="id" value="<?=$oficina->id?>">
                                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Apagar</button>
                                                        <div class="resposta-ajax"></div>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Código CAPAC</th>
                                    <th>Nome da oficina</th>
                                    <th>Data cadastro</th>
                                    <th>Enviado</th>
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