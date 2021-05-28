<?php
require_once "./controllers/ArquivoController.php";
require_once "./controllers/FomentoController.php";
$arquivosObj = new ArquivoController();
$fomentoObj = new FomentoController();

$edital_id = $_SESSION['edital_c'];
$projeto_id = $_SESSION['projeto_c'];

$tipo_contratacao_id = $fomentoObj->recuperaTipoContratacao((string) $edital_id);

$lista_documento_ids = $arquivosObj->recuperaIdListaDocumento($edital_id, true)->fetchAll(PDO::FETCH_COLUMN);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Anexos dos documentos</h1>
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
                            <li><strong>Tamanho Máximo:</strong> 5Mb</li>
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
                            <input type="hidden" name="origem_id" value="<?= $projeto_id ?>">
                            <input type="hidden" name="pagina" value="<?= $_GET['views'] ?>">
                            <table class="table table-striped">
                                <tbody>
                                <?php
                                $cont = 0;
                                $arquivos = $arquivosObj->listarArquivosFomento($edital_id)->fetchAll(PDO::FETCH_OBJ);
                                foreach ($arquivos as $arquivo) {
                                    $obrigatorio = $arquivo->obrigatorio == 0 ? "[Opcional]" : "*";
                                    if ($arquivosObj->consultaArquivoEnviado($arquivo->id, $projeto_id, true)) {
                                        ?>
                                        <tr>
                                            <td colspan="2">
                                                <div class="callout callout-success text-center">
                                                    Arquivo <strong><?="$arquivo->anexo - $arquivo->documento" ?></strong> já enviado!
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <td>
                                                <label for=""><?= "$arquivo->anexo - $arquivo->documento $obrigatorio" ?></label>
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
                                <th>Tipo do documento</th>
                                <th>Nome do documento</th>
                                <th style="width: 30%">Data de envio</th>
                                <th style="width: 10%">Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $arquivosEnviados = $arquivosObj->listarArquivosEnviados($projeto_id, $lista_documento_ids, $tipo_contratacao_id)->fetchAll(PDO::FETCH_OBJ);
                            if (count($arquivosEnviados) != 0) {
                                foreach ($arquivosEnviados as $arquivo) {
                                    ?>
                                    <tr>
                                        <td><?= "$arquivo->anexo - $arquivo->documento" ?></td>
                                        <td><a href="<?= SERVERURL . "uploads/" . $arquivo->arquivo ?>"
                                               target="_blank"><?= mb_strimwidth($arquivo->arquivo, '15', '25', '...') ?></a>
                                        </td>
                                        <td><?= $arquivosObj->dataParaBR($arquivo->data) ?></td>
                                        <td>
                                            <form class="formulario-ajax" action="<?= SERVERURL ?>ajax/arquivosAjax.php"
                                                  method="POST" data-form="delete">
                                                <input type="hidden" name="_method" value="removerArquivo">
                                                <input type="hidden" name="pagina" value="<?= $_GET['views'] ?>">
                                                <input type="hidden" name="arquivo_id"
                                                       value="<?= $arquivosObj->encryption($arquivo->id) ?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Apagar</button>
                                                <div class="resposta-ajax"></div>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td class="text-center" colspan="4">Nenhum arquivo enviado</td>
                                </tr>
                                <?php
                            }
                            ?>
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

<script>
    function alerta() {
        Swal.fire({
            title: 'FACC - Ficha de Atualização de Cadastro de Credores',
            html: 'A FACC é um documento necessário para recebimento do cachê. Após inserir seus dados pessoais e os dados bancários, clique no botão para gerar a FACC. <br><span style="color:red">Deve ser impressa, datada e assinada nos campos indicados no documento</span>.<br>Logo após, deve-se digitaliza-la e então anexa-la ao sistema através do campo abaixo.',
            type: 'warning',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: false,
            confirmButtonText: 'Confirmar'
        }).then(function () {
            window.open('<?= SERVERURL ?>', '_blank');
        });
    }
</script>

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#itens-proponente').addClass('menu-open');
        $('#anexos').addClass('active');
    })
</script>