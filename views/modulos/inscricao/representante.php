<?php
if ($_SESSION['modulo_p'] == 2){
    require_once "./controllers/ProponentePjController.php";
    $pjObj = new ProponentePjController();
    $pj = $pjObj->recuperaProponentePj($_SESSION['usuario_id_p']);
} else{
    require_once "./controllers/IncentivadorPjController.php";
    $pjObj = new IncentivadorPjController();
    $pj = $pjObj->recuperaIncentivadorPj($_SESSION['usuario_id_p']);
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Buscar Representante</h1>
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
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Dados</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal" method="POST" action="<?= SERVERURL ?>inscricao/representante_cadastro" role="form">
                        <input type="hidden" name="_method" value="buscar">
                        <input type="hidden" name="pagina" value="<?= $_GET['views'] ?>">
                        <input type="hidden" name="idPj" value="<?= $pj->id?>">
                        <input type="hidden" name="botao" value="Inserir Representante">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="cpf">CPF:</label>
                                    <input type="text" class="form-control" id="cpf" name="cpf" onkeypress="mask(this, '###.###.###-##')" maxlength="14" required>
                                </div>
                                <br>
                                <span style="display: none;" id="dialogError" class="alert alert-danger"
                                      role="alert">CPF inválido</span>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Buscar</button>
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
<?php
$javascript = <<<'JS'
<script src="../views/dist/js/cep_api.js"></script>
<script src="../views/dist/js/zona_api.js"></script>
<script>
    function leiCheckbox(){
        let boxLei = $('#lei').is(':checked');
        let txtLei = $('#lei_lei')

        if (boxLei) {
            txtLei.removeAttr('disabled');
            txtLei.attr('required', true);
        } else {
            txtLei.attr('disabled', true);
            txtLei.removeAttr('required');
            txtLei.val('');
        }
    }

    $(document).ready(leiCheckbox())

</script>
JS;
?>