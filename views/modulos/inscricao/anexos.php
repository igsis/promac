<?php
require_once "./controllers/ArquivoController.php";
$arquivosObj = new ArquivoController();

$tipo_cadastro = $_SESSION['modulo_p'];
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Documentos</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="offset-3 col-md-6">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Atenção!</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li><strong>Formato Permitido:</strong> PDF</li>
                            <li><strong>Tamanho Máximo:</strong> 05MB</li>
                            <li>Clique nos arquivos após efetuar o upload e confira a exibição do documento!</li>
                        </ul>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Arquivos</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- table start -->
                    <div id="lista-arquivos" class="card-body p-0">
                        <form class="formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/arquivosAjax.php"
                              data-form="save" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="enviarArquivo">
                            <input type="hidden" name="pagina" value="<?= $_GET['views'] ?>">
                            <table class="table table-striped">
                                <tbody>
                                <?php
                                $cont = 0;
                                $arquivos = $arquivosObj->listarArquivos($tipo_cadastro)->fetchAll(PDO::FETCH_OBJ);
                                foreach ($arquivos as $arquivo) {
                                    $obrigatorio = $arquivo->obrigatorio == 0 ? "[Opcional]" : "*";
                                    ?>
                                    <tr>
                                        <td>
                                            <label for=""><?= "$arquivo->documento $obrigatorio" ?></label>
                                        </td>
                                        <td>
                                            <input type="hidden" name="<?= $arquivo->sigla ?>"
                                                   value="<?= $arquivo->id ?>">
                                            <input class="text-center" type='file'
                                                   name='<?= $arquivo->sigla ?>'><br>
                                        </td>
                                    </tr>
                                    <?php
                                    $cont++;
                                }

                                if ($cont == 0): ?>
                                    <tr>
                                        <td colspan="2">
                                            Todos os arquivos já foram enviados!
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                            <input type="submit" class="btn btn-success btn-md btn-block" name="enviar" value='Enviar'>

                            <div class="resposta-ajax"></div>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>

            <!-- /.col -->
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Arquivos anexados</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- table start -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Nome do documento</th>
                                <th style="width: 30%">Data de envio</th>
                                <th style="width: 10%">Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center" colspan="4">Nenhum arquivo enviado</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

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
        $('#anexos').addClass('active');
    })
</script>