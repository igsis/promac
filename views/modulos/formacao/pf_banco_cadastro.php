<?php
require_once "./controllers/PessoaFisicaController.php";

$pfObjeto =  new PessoaFisicaController();

if (isset($_GET['id'])) {
    $_SESSION['origem_id_c'] = $id = $_GET['id'];
} elseif (isset($_SESSION['origem_id_c'])){
    $id = $_SESSION['origem_id_c'];
} else {
    $id = null;
}

if ($id) {
    $pf = $pfObjeto->recuperaPessoaFisica($id);
    $_SESSION['origem_id_c'] = $id;
    $documento = $pf['cpf'];
}

if (isset($_POST['pf_cpf'])){
    $documento = $_POST['pf_cpf'];
    $pf = $pfObjeto->getCPF($documento)->fetch();
    if ($pf){
        $id = (new MainModel)->encryption($pf['id']);
        $pf = $pfObjeto->recuperaPessoaFisica($id);
        $_SESSION['origem_id_c'] = $id;
        $documento = $pf['cpf'];
    }
}

?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4 class="m-0 text-dark"><?= $pf['nome'] ?? '' ?></h4>
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
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Dados bancários</h3>
                        <div class="card-tools">
                            <?php if ($pf['banco_id']): ?>
                                <form class="form-horizontal formulario-ajax" method="POST" role="form"
                                      data-form="delete"
                                      action="<?= SERVERURL ?>ajax/formacaoAjax.php">
                                    <input type="hidden" name="_method" value="apagarDadosBancarios">
                                    <input type="hidden" name="id" value="<?=$id?>">
                                    <input type="hidden" name="pagina" value="<?=$_GET['views']?>">
                                    <button type="submit" class="btn btn-danger btn-sm float-right">Remover Dados Bancários
                                    </button>
                                    <div class="resposta-ajax"></div>
                                </form>
                            <?php endif ?>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/formacaoAjax.php"
                          role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarPf" : "cadastrarPf" ?>">
                        <input type="hidden" name="pf_ultima_atualizacao" value="<?= date('Y-m-d H-i-s') ?>">
                        <input type="hidden" name="pagina" value="<?= $_GET['views'] ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="alert alert-warning alert-dismissible">
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção!</h5>
                                Realizamos pagamentos de valores acima de R$ 5.000,00 <b>* SOMENTE COM CONTA
                                    CORRENTE NO BANCO DO BRASIL *</b>. Não são aceitas: conta fácil, poupança e
                                conjunta.
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="banco">Banco:</label>
                                    <select required id="banco" name="bc_banco_id" class="form-control select2bs4">
                                        <option value="32">Banco do Brasil S.A.</option>
                                        <?php
                                        $pfObjeto->geraOpcao("bancos", $pf['banco_id']);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="agencia">Agência: *</label>
                                    <input type="text" id="agencia" name="bc_agencia" class="form-control"
                                           placeholder="Digite a Agência" maxlength="12"
                                           value="<?= $pf['agencia'] ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="conta">Conta: *</label>
                                    <input type="text" id="conta" name="bc_conta" class="form-control"
                                           placeholder="Digite a Conta" maxlength="12" value="<?= $pf['conta'] ?? '' ?>"
                                           required>
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


<script src="../views/dist/js/cep_api.js"></script>

<script type="text/javascript">
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        $('.swalDefaultWarning').show(function() {
            Toast.fire({
                type: 'warning',
                title: 'Em caso de alteração, pressione o botão Gravar para confirmar os dados'
            })
        });
    });

    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#dados_bancarios').addClass('active');
    });
</script>