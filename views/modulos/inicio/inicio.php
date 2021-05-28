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
                            Evento - Com cachê
                        </h3>
                    </div>
                    <div class="bg-light col-md">
                        <p>Aqui são inseridas as informações sobre o seu evento com cachê, incluindo pessoa jurídica e/ou física.</p>
                    </div>
                    <div align="center">
                        <a href="<?= SERVERURL ?>eventos/inicio&modulo=1" class="small-box-footer">
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
                            Evento - Sem cachê
                        </h3>
                    </div>
                    <div class="bg-light col-md">
                        <p>Aqui são inseridas as informações sobre o seu evento sem cachê, incluindo pessoa jurídica e/ou física.</p>
                    </div>
                    <div align="center">
                        <a href="<?= SERVERURL ?>eventos/inicio&modulo=2" class="small-box-footer">
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
                            Emenda Parlamentar
                        </h3>
                    </div>
                    <div class="bg-light col-md">
                        <p>Para evento com contratação através de emenda parlamentar, incluindo pessoa jurídica e/ou física.</p>
                    </div>
                    <div align="center">
                        <a href="<?= SERVERURL ?>eventos/inicio&modulo=3" class="small-box-footer">
                            Acesse <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <!-- Removido até verificar o melhor jeito para fazer
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-calendar-alt"></i>
                            Agendão
                        </h3>
                    </div>
                    <div class="bg-light col-md">
                        <p>Área para inserção de eventos de unidades externas para divulgação através do site Agendão.</p>
                    </div>
                    <div align="center">
                        <a href="<?= SERVERURL ?>agendao/inicio&modulo=4" class="small-box-footer">
                            Acesse <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            -->
            <!-- ./col -->
        </div>
        <!-- ./row -->
        <div class="row">
            <div class="col-md-3">
                <!-- small card -->
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-file-alt"></i>
                            Oficinas - Edital nº 002/2018
                        </h3>
                    </div>
                    <div class="bg-light col-md">
                        <p>Oficineiros<br>SELECIONADOS NO EDITAL nº 002/2018 SMC/GAB</p>
                    </div>
                    <div align="center">
                        <a href="<?=SERVERURL?>oficina&modulo=5" class="small-box-footer">
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
                            <i class="fas fa-file-alt"></i>
                            Formação - Edital
                        </h3>
                    </div>
                    <div class="bg-light col-md">
                        <p>Artistas Orientadores e Educadores<br>SELECIONADOS NO EDITAL nº 002/2018 SMC/GAB</p>
                    </div>
                    <div align="center">
                        <a href="<?=SERVERURL?>formacao&modulo=6" class="small-box-footer">
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
                            <i class="fas fa-file-alt"></i>
                            Jovem Monitor
                        </h3>
                    </div>
                    <div class="bg-light col-md">
                        <p>Estudantes<br>SELECIONADOS NO EDITAL nº 002/2018 SMC/GAB</p>
                    </div>
                    <div align="center">
                        <a href="<?=SERVERURL?>jovemMonitor&modulo=7" class="small-box-footer">
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
<?php
include "fomento_edital.php";
?>