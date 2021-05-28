<?php
/* ************** Pessoa Física ************** */
require_once "./controllers/PessoaFisicaController.php";
$pfObj = new PessoaFisicaController();
$pf = $pfObj->recuperaPessoaFisica($_SESSION['origem_id_c']);
$erros = $pfObj->validaPf(intval($pf['id']), 2,null,7);
$validacoesJm = $erros ? $pfObj->existeErro($erros) : false;
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Finalizar o Envio</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <?php if ($validacoesJm): ?>
            <div class="row erro-validacao">
                <div class="col-md-4">
                    <div class="card bg-danger">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-exclamation mr-3"></i><strong>Erros no cadastro</strong></h3>
                        </div>
                        <div class="card-body">
                            <?php foreach ($validacoesJm as $erro): ?>
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
                    <div class="card-header">
                        <h5 class="m-0">Jovem Monitor</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12"><b>Nome:</b> <?= $pf['nome'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b>Nome Social:</b> <?= $pf['nome_artistico'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-3"><b>Data de Nascimento:</b> <?= date("d/m/Y", strtotime($pf['data_nascimento'])) ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><b>RG:</b> <?= $pf['rg'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"><b>CPF:</b> <?= $pf['cpf'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><b>E-mail:</b> <?= $pf['email'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <b>Telefones:</b>
                                <?= isset($pf['telefones']) ? implode(" | ", $pf['telefones']) : "" ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <b>Endereço:</b> <?= $pf['logradouro'] . ", " . $pf['numero'] . " " . $pf['complemento'] . " " . $pf['bairro'] . " - " . $pf['cidade'] . "-" . $pf['uf'] . " CEP: " . $pf['cep'] ?>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/jovemMonitorAjax.php" role="form" data-form="update">
                            <input type="hidden" name="_method" value="envioJovemMonitor">
                            <input type="hidden" name="pagina" value="jovemMonitor">
                            <button type="submit" class="btn btn-success btn-block float-right" id="cadastra">Enviar</button>
                            <div class="resposta-ajax"></div>
                        </form>
                    </div>

                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#itens-proponente').addClass('menu-open');
        $('#finalizar').addClass('active');

        if ($('.erro-validacao').length) {
            $('#cadastra').attr('disabled', true);
        } else {
            $('#cadastra').attr('disabled', false);
        }
    });
</script>