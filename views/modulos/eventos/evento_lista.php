<?php
require_once "./controllers/EventoController.php";
if (isset($_SESSION['origem_id_c'])) {
    unset($_SESSION['origem_id_c']);
    unset($_SESSION['atracao_id_c']);
}
if(isset($_SESSION['pedido_id_c'])){
    unset($_SESSION['pedido_id_c']);
}

$eventoObj = new EventoController();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Eventos</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <a href="<?= SERVERURL ?>eventos/evento_cadastro"><button class="btn btn-success btn-block">Adicionar</button></a>
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
                        <h3 class="card-title">Eventos Cadastrados</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Código CAPAC</th>
                                    <th>Nome do Evento</th>
                                    <th>Tipo do Evento</th>
                                    <th>Data cadastro/envio</th>
                                    <th>Enviado</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($eventoObj->listaEvento($_SESSION['usuario_id_c'], $_SESSION['modulo_c']) as $evento): ?>
                                <tr>
                                    <td><?=$evento->publicado == 2 ? $evento->id : "Envie para obter o código"?></td>
                                    <td><?=$evento->nome_evento?></td>
                                    <td><?=$evento->tipo_contratacao?></td>
                                    <td><?=$eventoObj->dataHora($evento->data_cadastro)?></td>
                                    <td><?=$evento->publicado == 1 ? "Não" : "Sim"?></td>
                                    <td>
                                        <div class="row">
                                            <div class="col">
                                                <a href="<?=SERVERURL."eventos/evento_cadastro&key=".$eventoObj->encryption($evento->id)?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                            </div>
                                            <div class="col">
                                                <?php if ($evento->publicado == 1): ?>
                                                <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/eventoAjax.php" role="form" data-form="update">
                                                    <input type="hidden" name="_method" value="apagaEvento">
                                                    <input type="hidden" name="id" value="<?=$evento->id?>">
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
                                    <th>Nome do Evento</th>
                                    <th>Tipo do Evento</th>
                                    <th>Data cadastro/envio</th>
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