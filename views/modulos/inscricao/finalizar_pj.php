<?php

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Finalizar o Envio</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->

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
                        <h5 class="m-0">Pessoa Física</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12"><b>Nome:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b>Nome Artístico:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>RG:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>CPF:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>CCM:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Data de Nascimento:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Nacionalidade:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><b>E-mail:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <b>Telefones:</b>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <b>Endereço:</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Etnia:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Grau de instrução:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>NIT:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>DRT:</b> </div>
                        </div>

                            <div class="row">
                                <div class="col"><b>Banco:</b> </div>
                            </div>
                            <div class="row">
                                <div class="col"><b>Agência:</b> </div>
                            </div>
                            <div class="row">
                                <div class="col"><b>Conta:</b> </div>
                            </div>

                        <br>
                        <!-- ************** Programa ************** -->
                        <hr>
                        <h5><b>Detalhes do programa</b></h5>
                        <hr/>
                        <div class="row">
                            <div class="col"><b>Ano de execução do serviço:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Região preferencial:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Cargo:</b> </div>
                        </div>

                            <div class="row">
                                <div class="col"><b>Cargo (2º Opção):</b> </div>
                            </div>

                            <div class="row">
                                <div class="col"><b>Cargo (3º Opção):</b> </div>
                            </div>

                        <div class="row">
                            <div class="col"><b>Programa:</b> </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Linguagem:</b> </div>
                        </div>
                    </div>

                        <div class="card-footer" id="cardFooter">
                            <form class="form-horizontal formulario-ajax" method="POST"
                                  action="<?= SERVERURL ?>ajax/formacaoAjax.php" role="form" data-form="update"
                                  id="formEnviar">
                                <input type="hidden" name="_method" value="envioFormacao">
                                <button type="submit" class="btn btn-success btn-block float-right" id="cadastra">
                                    Enviar
                                </button>
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