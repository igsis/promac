<?php
unset($_SESSION['origem_id_c']);
unset($_SESSION['pedido_id_c']);
unset($_SESSION['modulo']);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Bem-vindo ao Sistema CAPAC</h1>
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
            <div class="col-md-3">
                <!-- small card -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt"></i>
                            Proponente PF
                        </h3>
                    </div>
                    <div class="bg-light col-md">
                        <p> </p>
                    </div>
                    <div align="center">
                        <a href="<?= SERVERURL ?>inscricao/proponente_pf_cadastro" class="small-box-footer">
                            Acesse <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-md-3">
                <!-- small card -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt"></i>
                            Proponente PJ
                        </h3>
                    </div>
                    <div class="bg-light col-md">
                        <p> </p>
                    </div>
                    <div align="center">
                        <a href="<?= SERVERURL ?>inscricao/proponente_pj_cadastro" class="small-box-footer">
                            Acesse <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-md-3">
                <!-- small card -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt"></i>
                            Incentivador PF
                        </h3>
                    </div>
                    <div class="bg-light col-md">
                        <p> </p>
                    </div>
                    <div align="center">
                        <a href="<?= SERVERURL ?>inscricao/incentivador__pf_cadastro" class="small-box-footer">
                            Acesse <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-md-3">
                <!-- small card -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt"></i>
                            Incentivador PJ
                        </h3>
                    </div>
                    <div class="bg-light col-md">
                        <p> </p>
                    </div>
                    <div align="center">
                        <a href="<?= SERVERURL ?>inscricao/incentivador_pj_cadastro" class="small-box-footer">
                            Acesse <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- ./row -->

    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->