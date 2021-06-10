<?php
require_once "./controllers/ArquivoController.php";
$arquivosObj = new ArquivoController();

$tipo_cadastro = $_SESSION['modulo_p'];
$usuario_id = $_SESSION['usuario_id_p'];

if ($tipo_cadastro == 1) {
    $proponente = true;
    require_once "./controllers/ProponentePfController.php";
    $pfObj = new ProponentePfController();

    $dados = $pfObj->recuperaProponentePf($usuario_id);
} elseif ($tipo_cadastro == 3) {
    $proponente = false;
    require_once "./controllers/IncentivadorPfController.php";


} else {
    echo '<script> window.location.href="'. SERVERURL .'" </script>';
}

if ($dados->cep) {
    $endereco = $dados->logradouro . ", " . $dados->numero;
    if ($dados->complemento){
        $endereco .= ", " . $dados->complemento;
    }
    $endereco .= " - " . $dados->bairro . ", " . $dados->cidade . " - " . $dados->uf . ", " . $dados->cep;
}

$erros = $pfObj->validaPf(intval($dados->id), $tipo_cadastro);
$validacoesPf = $erros ? $pfObj->existeErro($erros) : false;
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
                                        <h3 class="card-title">Dados do Cadastro</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- table start -->
                                    <div class="card-body">
                                        <strong>Nome:</strong>
                                        <p class="text-muted"><?= $dados->nome ?></p>
                                        <hr>

                                        <strong>RG:</strong>
                                        <p class="text-muted"><?= $dados->rg ?></p>
                                        <hr>

                                        <strong>CPF:</strong>
                                        <p class="text-muted"><?= $dados->cpf ?></p>
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
                                            <strong>Cooperado:</strong>
                                            <p class="text-muted"><?= $dados->cooperado == 1 ? "Sim" : "Não" ?></p>
                                            <hr>

                                            <strong>Genero:</strong>
                                            <p class="text-muted"><?= $dados->genero ?></p>
                                            <hr>

                                            <strong>Etnia:</strong>
                                            <p class="text-muted"><?= $dados->etnia ?></p>
                                            <hr>

                                            <strong>Já participou de outras leis de incentivo à cultura? Se sim, qual?</strong>
                                            <p class="text-muted"><?= $dados->lei == null ? "Não" : "Sim, " . $dados->lei ?></p>
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
                                        <h3 class="card-title">Arquivos anexados</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- table start -->
                                    <div class="card-body p-0">
                                        <table class="table table-bordered table-hover table-responsive">
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