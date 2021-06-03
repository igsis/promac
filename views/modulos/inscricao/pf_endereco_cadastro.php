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
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Endereço</h3>
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
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="cep">CEP: *</label>
                                    <input type="text" class="form-control" name="en_cep" id="cep"
                                           onkeypress="mask(this, '#####-###')" maxlength="9" placeholder="Digite o CEP" required value="<?= $pf['cep'] ?? '' ?>" >
                                </div>
                                <div class="form-group col-md-2">
                                    <label>&nbsp;</label><br>
                                    <input type="button" class="btn btn-primary" value="Carregar">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="rua">Rua: *</label>
                                    <input type="text" class="form-control" name="en_logradouro" id="rua"
                                           placeholder="Digite a rua" maxlength="200" value="<?= $pf['logradouro'] ?? '' ?>"
                                           readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="numero">Número: *</label>
                                    <input type="number" name="en_numero" class="form-control" placeholder="Ex.: 10"
                                           value="<?= $pf['numero'] ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="complemento">Complemento:</label>
                                    <input type="text" name="en_complemento" class="form-control" maxlength="20"
                                           placeholder="Digite o complemento" value="<?= $pf['complemento'] ?? '' ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="bairro">Bairro: *</label>
                                    <input type="text" class="form-control" name="en_bairro" id="bairro"
                                           placeholder="Digite o Bairro" maxlength="80"
                                           value="<?= $pf['bairro'] ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cidade">Cidade: *</label>
                                    <input type="text" class="form-control" name="en_cidade" id="cidade"
                                           placeholder="Digite a cidade" maxlength="50"
                                           value="<?= $pf['cidade'] ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="estado">Estado: *</label>
                                    <input type="text" class="form-control" name="en_uf" id="estado" maxlength="2"
                                           placeholder="Ex.: SP" value="<?= $pf['uf'] ?? '' ?>" readonly>
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
        $('#dados_endereco').addClass('active');
    });
</script>