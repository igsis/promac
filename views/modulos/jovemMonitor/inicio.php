<?php
unset($_SESSION['origem_id_c']);
if (isset($_GET['modulo'])) {
    $_SESSION['modulo_c'] = $_GET['modulo'];
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Resumo das informações para preenchimento do cadastro</h1>
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
                <p class="card-text">
                    Inicia-se aqui um processo passo-a-passo para o preenchimento do cadastro de jovem monitor. Antes de começar, tenha disponível estas informações para que o cadastro possa ser concluído.
                </p>
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit"></i>
                            Cadastro de jovem monitor
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="text-info"><b>Cadastro</b></p>
                        <ul>
                            <li>Nome</li>
                            <li>Nome social</li>
                            <li>Data de nascimento</li>
                            <li>RG</li>
                            <li>CPF</li>
                            <li>E-mail</li>
                            <li>Telefones</li>
                            <li>CEP</li>
                            <li>Número</li>
                            <li>Complemento</li>
                        </ul>
                        <br>
                        <p class="text-info"><b>Anexos</b></p>
                        <ul>
                            <li>RG</li>
                            <li>CPF</li>
                            <li>Comprovante de residência</li>
                        </ul>
                        <br>
                        <div class="tab-content" id="custom-content-above-tabContent">
                            <div class="offset-md-4 col-md-4">
                                <a href="<?= SERVERURL ?>jovemMonitor/proponente"><button class="btn btn-block btn-success">Clique aqui para começar</button></a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
