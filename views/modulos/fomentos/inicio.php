<?php
require_once "./controllers/ProjetoController.php";
require_once "./controllers/FomentoController.php";
unset($_SESSION['projeto_c']);
unset($_SESSION['origem_id_c']);

$fomentoObj = new FomentoController();
$projetoObj = new ProjetoController();

$nomeEdital = $fomentoObj->recuperaNomeEdital($_SESSION['edital_c']);
$projetos = $projetoObj->listaProjetos();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Projetos</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <a href="<?= SERVERURL ?>fomentos/projeto_cadastro"><button class="btn btn-success btn-block">Adicionar</button></a>
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
                        <h3 class="card-title">Projetos Cadastrados para o edital: <?=$nomeEdital?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabela" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Protocolo</th>
                                <th>Nome do Projeto</th>
                                <th>Valor do Projeto</th>
                                <th>Data cadastro/envio</th>
                                <th>Enviado</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($projetos as $projeto):
                                $enviado = $projeto->protocolo == null ? false : true?>
                                <tr>
                                    <td><?=$enviado ? $projeto->protocolo : "Envie o projeto para obter seu protocolo"?></td>
                                    <?php echo "<td>$projeto->nome_projeto</td>" ?>
                                    <td><?=$fomentoObj->dinheiroParaBr($projeto->valor_projeto)?></td>
                                    <td><?=$enviado ? $projetoObj->dataHora($projeto->data_inscricao) : "Projeto não enviado" ?></td>
                                    <td><?=$enviado ? "Sim" : "Não"?></td>
                                    <td>
                                        <div class="row">
                                            <?php if (!$enviado): ?>
                                                <div class="col">
                                                    <a href="<?= SERVERURL . "fomentos/projeto_cadastro&id=" . $projetoObj->encryption($projeto->id) ?>"
                                                       class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</a>
                                                </div>
                                                <div class="col">
                                                    <form class="form-horizontal formulario-ajax" method="POST"
                                                          action="<?= SERVERURL ?>ajax/projetoAjax.php" role="form"
                                                          data-form="delete">
                                                        <input type="hidden" name="_method" value="apagaProjeto">
                                                        <input type="hidden" name="id" value="<?= $projeto->id ?>">
                                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i>
                                                            Apagar
                                                        </button>
                                                        <div class="resposta-ajax"></div>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                <div class="col">
                                                    <a href="<?= SERVERURL . "pdf/resumo_fomento.php?id=" . $projetoObj->encryption($projeto->id) ?>"
                                                       class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-edit"></i> Visualizar</a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Protocolo</th>
<!--                                <th>Instituição</th>-->
                                <th>Valor do Projeto</th>
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
<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#fomentos_inicio').addClass('active');
    })
</script>