<?php
switch ($_SESSION['modulo_p']){
    case 1:
        require_once "./controllers/ProponentePfController.php";
        $pfObj = new ProponentePfController();
        $pessoa = $pfObj->recuperaProponentePf($_SESSION['usuario_id_p']);
        $nome_empresa = $pessoa->nome;
        $documento = $pessoa->cpf;
        break;
    case 2:
        require_once "./controllers/ProponentePjController.php";
        $pjObj = new ProponentePjController();
        $pessoa = $pjObj->recuperaProponentePj($_SESSION['usuario_id_p']);
        $nome_empresa = $pessoa->razao_social;
        $documento = $pessoa->cnpj;
        break;
    case 3:
        require_once "./controllers/IncentivadorPfController.php";
        $pfObj = new IncentivadorPfController();
        $pessoa = $pfObj->recuperaIncentivadorPf($_SESSION['usuario_id_p']);
        $nome_empresa = $pessoa->nome;
        $documento = $pessoa->cpf;
        break;
    case 4:
        require_once "./controllers/IncentivadorPjController.php";
        $pjObj = new IncentivadorPjController();
        $pessoa = $pjObj->recuperaIncentivadorPj($_SESSION['usuario_id_p']);
        $nome_empresa = $pessoa->razao_social;
        $documento = $pessoa->cnpj;
        break;
}

switch ($pessoa->liberado){
    case 0:
        $status = "Em elaboração";
        $btColor = "secondary";
        break;
    case 1:
        $status = "Em análise";
        $btColor = "info";
        break;
    case 2:
        $status = "Aprovado";
        $btColor = "success";
        break;
    case 3:
        $status = "Necessita alteração";
        $btColor = "danger";
        break;
    default:
        (new UsuarioController)->forcarFimSessao();
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Boas-vindas ao PROMAC!</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <!-- Small Box (Stat card) -->
        <h5 class="mb-2 mt-4"></h5>
        <div class="row">
            <div class="col-md-10">
                <!-- small card -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user"></i>
                            Inscrição
                        </h3>
                    </div>
                    <div class="bg-light col-md">
                        <br>
                        <p><b><?= $nome_empresa ?? null ?></b><br>
                            <b>Documento:</b> <?= $documento ?? null ?> |
                            <b>E-mail:</b> <?= $pessoa->email ?? null ?> |
                            <b>Telefones:</b>
                            <?php
                            if (isset($pessoa->telefones['tel_0'])){
                                echo $pessoa->telefones['tel_0'] ?? null . " " .$pessoa->telefones['tel_1'] ?? null. " ".$pessoa->telefones['tel_2'] ?? null;
                            } else{
                                echo "não cadastrado";
                            }
                            ?>
                            <br>
                            <b>Endereço:</b>
                            <?php
                            if (isset($pessoa->logradouro)){
                                echo $pessoa->logradouro.", ".$pessoa->numero." ".$pessoa->complemento." ".$pessoa->bairro.", ".$pessoa->cidade." - ".$pessoa->uf." CEP: ".$pessoa->cep;
                            } else{
                                echo "não cadastrado";
                            }
                            ?>
                        </p>

                    </div>
                    <?php if ($pessoa->liberado != 0 && $pessoa->data_inscricao != null): ?>
                        <div style="text-align: center">
                            <a class="small-box-footer" href="<?= SERVERURL ?>pdf/resumo_inscricao.php?modulo=<?=$_SESSION['modulo_p']?>&id=<?=$_SESSION['usuario_id_p']?>" target="_blank">Visualize <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user"></i>
                            Status
                        </h3>
                    </div>
                    <div class="bg-light col-md">
                        <br>
                        <div class="btn btn-block bg-gradient-<?=$btColor?> btn-lg"><?= $status ?></div>
                        <br>
                    </div>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- ./row -->
        <hr>
        <!-- row -->
        <!-- Para quando houver área de projetos
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt"></i>
                            Projetos
                        </h3>
                    </div>
                    <div class="bg-light col-md">
                        <p> </p>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- ./row -->

    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<script>
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>