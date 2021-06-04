<?php
require_once "./controllers/IncentivadorPjController.php";
$pjObjeto =  new IncentivadorPjController();

$id = $_SESSION['usuario_id_p'];
$pj = $pjObjeto->recuperaIncentivadorPj($id);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pessoa Jurídica</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/incentivadorPjAjax.php" role="form" data-form="update">
                        <input type="hidden" name="_method" value="editarPj">
                        <input type="hidden" name="pagina" value="<?= $_GET['views'] ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-10">
                                    <label for="razao_social">Razão social: *</label>
                                    <input type="text" class="form-control" id="razao_social" name="pj_razao_social" placeholder="Digite o razao_social" maxlength="70" value="<?= $pj->razao_social ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cnpj">CNPJ: *</label>
                                    <input type="text" name="pj_cnpj" class="form-control" id="cnpj" value="<?= $pj->cnpj ?? null ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="pj_email">E-mail: *</label>
                                    <input type="email" id="pj_email" name="pj_email" class="form-control"
                                           maxlength="60" placeholder="Digite o E-mail"
                                           value="<?= $pj->email ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone">Telefone #1: *</label>
                                    <input type="text" id="telefone" name="te_telefone_1"
                                           onkeyup="mascara( this, mtel );"  class="form-control"
                                           placeholder="Digite o telefone" required
                                           value="<?= $pj->telefones['tel_0'] ?? "" ?>" maxlength="15">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone1">Telefone #2:</label>
                                    <input type="text" id="telefone1" name="te_telefone_2"
                                           onkeyup="mascara( this, mtel );"  class="form-control"
                                           placeholder="Digite o telefone" maxlength="15"
                                           value="<?=  $pj->telefones['tel_1'] ?? "" ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone2">Telefone #3:</label>
                                    <input type="text" id="telefone2" name="te_telefone_3"
                                           onkeyup="mascara( this, mtel );"  class="form-control telefone"
                                           placeholder="Digite o telefone" maxlength="15"
                                           value="<?=  $pj->telefones['tel_2'] ?? "" ?>">
                                </div>
                            </div>

                            <hr>

                            <div class="row mt-2">
                                <div class="form-group col-5">
                                    <label for="cep">CEP: *</label>
                                    <input type="text" class="form-control" name="en_cep" id="cep"
                                           onkeypress="mask(this, '#####-###')" maxlength="9"
                                           placeholder="Digite o CEP" required value="<?= $pj->cep ?? '' ?>" >
                                </div>
                                <div class="form-group col-2">
                                    <label>&nbsp;</label><br>
                                    <input type="button" class="btn btn-secondary" value="Carregar">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="rua">Rua: *</label>
                                    <input type="text" class="form-control" name="en_logradouro" id="rua"
                                           placeholder="Digite a rua" maxlength="200"
                                           value="<?= $pj->logradouro ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-2">
                                    <label for="numero">Número: *</label>
                                    <input type="number" id="numero" name="en_numero" class="form-control"
                                           placeholder="Ex.: 10" value="<?= $pj->numero ?? '' ?>" required>
                                </div>
                                <div class="form-group col">
                                    <label for="complemento">Complemento:</label>
                                    <input type="text" id="complemento" name="en_complemento" class="form-control" maxlength="20" placeholder="Digite o complemento" value="<?= $pj->complemento ?? '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="bairro">Bairro: *</label>
                                    <input type="text" class="form-control" name="en_bairro" id="bairro"
                                           placeholder="Digite o Bairro" maxlength="80"
                                           value="<?= $pj->bairro ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col">
                                    <label for="cidade">Cidade: *</label>
                                    <input type="text" class="form-control" name="en_cidade" id="cidade"
                                           placeholder="Digite a cidade" maxlength="50"
                                           value="<?= $pj->cidade ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col">
                                    <label for="estado">Estado: *</label>
                                    <input type="text" class="form-control" name="en_uf" id="estado" maxlength="2"
                                           placeholder="Ex.: SP" value="<?= $pj->uf ?? '' ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="zona">Zona *</label>
                                    <select name="en_zona_id" id="zona" class="form-control" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $pjObjeto->geraOpcao('zonas',$pj->zona_id ?? '') ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="distrito">Distrito *</label>
                                    <select name="en_distrito_id" id="distrito" class="form-control" required>
                                        <!-- Populando pelo js -->
                                        <?php
                                        if (isset($pj->distrito_id))
                                            $pjObjeto->geraOpcao('distritos',$pj->distrito_id);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="subprefeitura">Subprefeitura *</label>
                                    <select name="en_subprefeitura_id" id="subprefeitura" class="form-control" required>
                                        <!-- Populando pelo js -->
                                        <?php
                                        if (isset($pj->subprefeitura_id))
                                            $pjObjeto->geraOpcao('subprefeituras',$pj->subprefeitura_id);
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="imposto">Imposto</label>
                                    <select name="pj_imposto_id" id="imposto" class="form-control" required>
                                        <?php $pjObjeto->geraOpcao('impostos',$pj->imposto_id) ?>
                                    </select>
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
<script src="../views/dist/js/zona_api.js"></script>