<?php
require_once "./controllers/IntegranteController.php";
$integranteObj = new IntegranteController();

$instegrantes = $integranteObj->listaNucleo($_SESSION['projeto_c']);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Núcleo artístico <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-nucleo-art"> <i class="fas fa-info"></i></button></h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <button type="button" class="btn btn-sm btn-success btn-block" data-toggle="modal" data-target="#modal-busca-cpf"> Adicionar</button>
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
                        <h3 class="card-title">Cadastrados</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>RG</th>
                                <th>CPF</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($instegrantes as $integrante):
                            ?>
                                <tr>
                                    <td><?= $integrante->nome ?></td>
                                    <td><?= $integrante->rg ?></td>
                                    <td><?= $integrante->cpf ?></td>
                                    <td>
                                        <a href="<?=SERVERURL?>fomentos/nucleo_artistico_cadastro&id=<?=$integranteObj->encryption($integrante->id)?>"
                                           class="btn btn-sm btn-primary float-left mr-2"><i class="fas fa-edit"></i> Editar</a>
                                        <form class="formulario-ajax" action="<?=SERVERURL?>ajax/integranteAjax.php"
                                              method="post" data-form="delete">
                                            <input type="hidden" name="_method" value="apagaIntegranteFomento">
                                            <input type="hidden" name="id" value="<?=$integranteObj->encryption($integrante->id)?>">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Apagar
                                            </button>
                                            <div class="resposta-ajax"></div>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Nome</th>
                                <th>RG</th>
                                <th>CPF</th>
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

<div class="modal fade" id="modal-nucleo-art">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Núcleo artístico</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-justify">São os artistas e técnicos que se responsabilizem pela fundamentação e execução do projeto, constituindo uma base organizativa de caráter continuado.</p>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-busca-cpf">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Busca por CPF</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <form class="form-horizontal" method="POST" action="<?= SERVERURL ?>fomentos/nucleo_artistico_cadastro" role="form" id="formularioPf">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="cpf">CPF:</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" maxlength="14"
                                   required onkeypress="mask(this, '999.999.999-99')" minlength="14">
                            <div id="dialogError" class="invalid-feedback">CPF inválido</div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-body -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info float-right">Pesquisar</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#nucleo_artistico').addClass('active');
    })
</script>