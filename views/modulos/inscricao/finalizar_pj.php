<?php
/**
 * @var ProponentePjController|IncentivadorPjController $pjObj
 * @var object $dados
 * @var bool $proponente
 */

require_once "./controllers/ArquivoController.php";
require_once "./controllers/RepresentanteController.php";
$arquivosObj = new ArquivoController();
$representanteObj = new RepresentanteController();

$tipo_cadastro = $_SESSION['modulo_p'];
$usuario_id = $_SESSION['usuario_id_p'];

if ($tipo_cadastro == 2) {
    $proponente = true;
    require_once "./controllers/ProponentePjController.php";
    $pjObj = new ProponentePjController();

    $dados = $pjObj->recuperaProponentePj($usuario_id);
} elseif ($tipo_cadastro == 4) {
    $proponente = false;
    require_once "./controllers/IncentivadorPjController.php";
    $pjObj = new IncentivadorPjController();

    $dados = $pjObj->recuperaIncentivadorPj($usuario_id);
} else {
    echo '<script> window.location.href="'. SERVERURL .'" </script>';
}

$representante = $representanteObj->recuperaRepresentante($dados->representante_legal_id);

if (isset($representante->cep)) {
    if ($representante->cep) {
        $endereco_representante = $pjObj->enderecoParaString($representante);
    }
}

if (isset($dados->cep)) {
    if ($dados->cep) {
        $endereco = $pjObj->enderecoParaString($dados);
    }
}

$erros = $pjObj->validaPj(intval($dados->id), $tipo_cadastro);
$validacoesPf = $erros ? $pjObj->existeErro($erros) : false;

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Finalizar</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <?php if ($validacoesPf): ?>
            <div class="row erro-validacao" id="erros">
                <div class="col-md-4">
                    <div class="card bg-danger">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-exclamation mr-3"></i><strong>Erros no cadastro</strong></h3>
                        </div>
                        <div class="card-body">
                            <?php foreach ($validacoesPf as $erro): ?>
                                <li><?= $erro ?></li>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Horizontal Form -->
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Dados da Empresa</h3>
                                    </div>
                                    <div class="card-body">
                                        <strong>Razão Social:</strong>
                                        <p class="text-muted"><?= $dados->razao_social ?></p>
                                        <hr>

                                        <strong>CNPJ:</strong>
                                        <p class="text-muted"><?= $dados->cnpj ?></p>
                                        <hr>

                                        <strong>E-mail:</strong>
                                        <p class="text-muted"><?= $dados->email ?></p>
                                        <hr>

                                        <strong>Telefones:</strong>
                                        <p class="text-muted">
                                            <?php
                                            if (isset($dados->telefones)) {
                                                echo implode(" / ", $dados->telefones);
                                            }
                                            ?>
                                        </p>
                                        <hr>

                                        <strong>Endereço:</strong>
                                        <p class="text-muted"><?= $endereco ?? '' ?></p>
                                        <hr>

                                        <?php if ($proponente): ?>
                                            <strong>É mei?</strong>
                                            <p class="text-muted"><?= $pjObj->simNao($dados->mei) ?></p>
                                            <hr>

                                            <strong>É cooperativa?</strong>
                                            <p class="text-muted"><?= $pjObj->simNao($dados->cooperativa) ?></p>
                                            <hr>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <div class="col-md-6">
                                <!-- Horizontal Form -->
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Dados do Representante Legal</h3>
                                    </div>

                                    <div class="card-body">
                                        <?php if ($dados->representante_legal_id == null): ?>
                                            <div class="text-center">
                                                <p>Representante Legal não cadastrado</p>
                                            </div>
                                        <?php else: ?>
                                            <strong>Nome:</strong>
                                            <p class="text-muted"><?= $representante->nome ?></p>
                                            <hr>

                                            <strong>RG:</strong>
                                            <p class="text-muted"><?= $representante->rg ?></p>
                                            <hr>

                                            <strong>CPF:</strong>
                                            <p class="text-muted"><?= $representante->cpf ?></p>
                                            <hr>

                                            <strong>E-mail:</strong>
                                            <p class="text-muted"><?= $representante->email ?></p>
                                            <hr>

                                            <strong>Telefones:</strong>
                                            <p class="text-muted">
                                                <?php
                                                if (isset($representante->telefones)) {
                                                    echo implode(" / ", $dados->telefones);
                                                }
                                                ?>
                                            </p>
                                            <hr>

                                            <strong>Endereço:</strong>
                                            <p class="text-muted"><?= $endereco_representante ?? '' ?></p>
                                            <hr>

                                            <strong>Genero:</strong>
                                            <p class="text-muted"><?= $representante->genero ?></p>
                                            <hr>

                                            <strong>Etnia:</strong>
                                            <p class="text-muted"><?= $representante->etnia ?></p>
                                            <hr>

                                            <strong>Já participou de outras leis de incentivo à cultura? Se sim,
                                                qual?</strong>
                                            <p class="text-muted"><?= $representante->lei == null ? "Não" : "Sim, " . $representante->lei ?></p>
                                            <hr>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md">
                                <!-- Horizontal Form -->
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Arquivos anexados</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- table start -->
                                    <div class="card-body p-0">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Documento</th>
                                                <th>Nome do documento</th>
                                                <th style="width: 30%">Data de envio</th>
                                                <th style="width: 10%">Ação</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $arquivosEnviados = $arquivosObj->listarArquivosEnviados($tipo_cadastro, $usuario_id)->fetchAll(PDO::FETCH_OBJ);
                                            if (count($arquivosEnviados) != 0) {
                                                foreach ($arquivosEnviados as $arquivo) {
                                                    $observacoes = $arquivosObj->listarObservacoesArquivo($arquivo->id);
                                                    ?>
                                                    <tr data-widget="expandable-table" aria-expanded="<?= $observacoes ? 'true' : 'false' ?>">
                                                        <td><?= "$arquivo->documento" ?></td>
                                                        <td><a href="<?= SERVERURL . "uploads/" . $arquivo->arquivo ?>"
                                                               target="_blank"><?= mb_strimwidth($arquivo->arquivo, '15', '25', '...') ?></a>
                                                        </td>
                                                        <td><?= $arquivosObj->dataParaBR($arquivo->data_envio) ?></td>
                                                        <td>
                                                            <?php if ($arquivo->status_documento_id == 2): ?>
                                                                <form class="formulario-ajax"
                                                                      action="<?= SERVERURL ?>ajax/arquivosAjax.php"
                                                                      method="POST" data-form="delete">
                                                                    <input type="hidden" name="_method"
                                                                           value="removerArquivo">
                                                                    <input type="hidden" name="pagina"
                                                                           value="<?= $_GET['views'] ?>">
                                                                    <input type="hidden" name="arquivo_id"
                                                                           value="<?= $arquivosObj->encryption($arquivo->id) ?>">
                                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                                        Apagar
                                                                    </button>
                                                                    <div class="resposta-ajax"></div>
                                                                </form>
                                                            <?php else: ?>
                                                                <span class="badge badge-light">Nenhuma ação disponível</span>
                                                            <?php endif ?>
                                                        </td>
                                                    </tr>
                                                    <tr class="expandable-body">
                                                        <td colspan="4">
                                                            <?php if ($observacoes) {
                                                                foreach ($observacoes as $observacao)
                                                                    ?>
                                                                    <p>
                                                                    <strong>Observação: </strong> <?= $observacao ?>
                                                                </p>
                                                            <?php }
                                                            else {
                                                                ?>
                                                                <p class="text-center">
                                                                    Nenhuma observação para este arquivo
                                                                </p>
                                                            <?php } ?>
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
                    </div>

                    <div class="card-footer" id="cardFooter">
                        <?php if (!$erros): ?>
                            <form class="form-horizontal formulario-ajax" method="POST"
                                  action="<?= SERVERURL ?>ajax/formacaoAjax.php" role="form" data-form="update"
                                  id="formEnviar">
                                <input type="hidden" name="_method" value="envioFormacao">
                                <button type="submit" class="btn btn-success btn-block float-right" id="cadastra">
                                    Enviar
                                </button>
                                <div class="resposta-ajax"></div>
                            </form>
                        <?php else: ?>
                            <a href="#erros">
                                <div class="alert alert-warning">
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção!</h5>
                                    Você possui pendencias em seu cadastro. Clique aqui e verifique-as no topo da tela para poder
                                    envia-lo
                                </div>
                            </a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->