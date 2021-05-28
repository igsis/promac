<?php
$atracao_id = $_SESSION['atracao_id_c'];

//$atracao_id = $_POST['atracao_id'];
require_once "./controllers/OficinaController.php";
$oficinaObj = new OficinaController();
$complementos = $oficinaObj->recuperaComplementosOficina($atracao_id);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dados complementares da oficina</h1>
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
                        <h3 class="card-title">Detalhes</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/oficinaAjax.php" role="form" data-form="<?= ($complementos) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($complementos) ? "editaComplemento" : "cadastraComplemento" ?>">
                        <?php if ($complementos): ?>
                            <input type="hidden" name="id" value="<?= $oficinaObj->encryption($complementos->id) ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="modalidade_id">Modalidade: *</label>
                                    <select class="form-control" name="modalidade_id" id="modalidade_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $oficinaObj->geraOpcao('modalidades', $complementos->modalidade_id ?? "", true) ?>
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-4">
                                    <label for="data_inicio">Data inicial - Data Final: *</label><br/>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                        </div>
                                        <input type="text" id="dateRange" name="dataInicioFim" class="form-control" value="<?= $oficinaObj->dataParaBR($complementos->data_inicio) . " - " . $oficinaObj->dataParaBR($complementos->data_fim) ?>"></div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="execucao_dia1_id">Dia execução 1: *</label><br/>
                                    <select class="form-control" name="execucao_dia1_id" id="execucao_dia1_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $oficinaObj->geraOpcao('execucao_dias', $complementos->execucao_dia1_id ?? "", false, true) ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="execucao_dia2_id">Dia execução 2: *</label><br/>
                                    <select class="form-control" name="execucao_dia2_id" id="execucao_dia2_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $oficinaObj->geraOpcao('execucao_dias', $complementos->execucao_dia2_id ?? "", false, true) ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
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

<script>
    $(function () {
        $('#dateRange').daterangepicker({
            "locale": {
                "format": "DD/MM/YYYY",
                "separator": " - ",
                "applyLabel": "Selecionar",
                "cancelLabel": "Cancelar",
                "daysOfWeek": [
                    "Dom",
                    "Seg",
                    "Ter",
                    "Qua",
                    "Qui",
                    "Sex",
                    "Sab"
                ],
                "monthNames": [
                    "Janeiro",
                    "Fevereiro",
                    "Março",
                    "Abril",
                    "Maio",
                    "Junho",
                    "Julho",
                    "Agosto",
                    "Setembro",
                    "Outubro",
                    "Novembro",
                    "Dezembro"
                ],
                "firstDay": 1
            }
        })
    })
</script>