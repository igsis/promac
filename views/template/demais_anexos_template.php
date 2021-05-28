<?php
require_once "./controllers/ArquivoController.php";
require_once "./controllers/PedidoController.php";
$arquivosObj = new ArquivoController();

$pedido_id = $_SESSION['pedido_id_c'];
$tipo_documento_id = 3;

$pedidoObj = new PedidoController();
$proponente = $pedidoObj->recuperaProponente($pedido_id);
if ($proponente->pessoa_tipo_id == 1) {
    $url_pf = SERVERURL."pdf/declaracao_exclusividade_pf.php?id=".$_SESSION['origem_id_c'];
    $botoes="<div class=\"offset-3 col-md-6\"><a href=\"$url_pf\" class=\"btn btn-primary btn-block\" target=\"_blank\">Modelo Único - Grupo</a></div>";
} else {
    $url_pj_g = SERVERURL."pdf/declaracao_exclusividade_grupo_pj.php?id=".$_SESSION['origem_id_c'];
    $url_pj_s = SERVERURL."pdf/declaracao_exclusividade_1pessoa_pj.php?id=".$_SESSION['origem_id_c'];
    $botoes="<div class=\"offset-1 col-md-5\"><a href=\"$url_pj_g\" class=\"btn btn-primary btn-block\" target=\"_blank\">Grupo</a></div><div class=\"col-md-5\"><a href=\"$url_pj_s\" class=\"ml-md-2 btn btn-primary btn-block\" target=\"_blank\">Artista Solo</a></div>";
}

$lista_documento_ids = $arquivosObj->recuperaIdListaDocumento($tipo_documento_id)->fetchAll(PDO::FETCH_COLUMN);
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Demais Anexos</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Atenção!</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li><strong>Formato Permitido:</strong> PDF</li>
                            <li><strong>Tamanho Máximo:</strong> 6Mb</li>
                            <li>Clique nos arquivos após efetuar o upload e confira a exibição do documento!</li>
                        </ul>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">Gerar documentos</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <p>Para gerar alguns dos arquivos online, utilize os links abaixo:</p>
                        <ul>
                            <li><a href="#" onclick="alerta();">Declaração de Exclusividade</a></li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
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
                    <div class="card-body p-0">
                        <form class="formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/arquivosAjax.php" data-form="save" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="enviarArquivo">
                            <input type="hidden" name="origem_id" value="<?= $pedido_id ?>">
                            <input type="hidden" name="pagina" value="<?=$_GET['views']?>">
                            <table class="table table-striped">
                                <tbody>
                                <?php
                                $arquivos = $arquivosObj->listarArquivos($tipo_documento_id)->fetchAll(PDO::FETCH_OBJ);
                                foreach ($arquivos as $arquivo) {
                                    if ($arquivosObj->consultaArquivoEnviado($arquivo->id, $pedido_id)) {
                                        ?>
                                        <tr>
                                            <td colspan="2">
                                                <div class="callout callout-success text-center">
                                                    Arquivo <strong><?= $arquivo->documento ?></strong> já enviado!
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <td>
                                                <label for=""><?=$arquivo->documento?></label>
                                            </td>
                                            <td>
                                                <input type="hidden" name="<?=$arquivo->sigla?>" value="<?=$arquivo->id?>">
                                                <input class="text-center" type='file' name='<?=$arquivo->sigla?>'><br>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
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
                            $arquivosEnviados = $arquivosObj->listarArquivosEnviados($pedido_id, $lista_documento_ids)->fetchAll(PDO::FETCH_OBJ);
                            if (count($arquivosEnviados) != 0) {
                                foreach ($arquivosEnviados as $arquivo) {
                                    ?>
                                    <tr>
                                        <td><?= $arquivo->documento ?></td>
                                        <td><a href="<?=SERVERURL."uploads/".$arquivo->arquivo?>" target="_blank"><?= $arquivo->arquivo ?></a></td>
                                        <td><?= $arquivosObj->dataParaBR($arquivo->data) ?></td>
                                        <td>
                                            <form class="formulario-ajax" action="<?=SERVERURL?>ajax/arquivosAjax.php" method="POST" data-form="delete">
                                                <input type="hidden" name="_method" value="removerArquivo">
                                                <input type="hidden" name="pagina" value="<?=$_GET['views']?>">
                                                <input type="hidden" name="arquivo_id" value="<?=$arquivosObj->encryption($arquivo->id)?>">
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
                                    <td class="text-center" colspan="3">Nenhum arquivo enviado</td>
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
    function alerta(){
        Swal.fire({
            title: 'Declaração de Exclusividade',
            html: 'A Declaração de Exclusividade é um documento necessário para sua contratação, quando se tratar de um grupo de artistas.<br>Escolha entre um dos modelos abaixo e clique no botão para gerar a Declaração de Exclusividade.<br>' +
                '<div class="row"><?= $botoes ?></div>'+
                '<span style="color:red">Deve ser impressa, datada e assinada nos campos indicados no documento</span>.<br>Logo após, deve-se digitaliza-la e então anexa-la ao sistema através da lista de arquivos.<br>',
            type: 'warning',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonText: 'Fechar'
        });
    }
</script>

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#demais_anexos').addClass('active');
    })
</script>