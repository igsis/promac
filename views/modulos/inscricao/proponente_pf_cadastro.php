<?php
require_once "./controllers/ProponentePfController.php";

/**
 * Lembrar de criar uma função para validar o módulo ou destruir a sessão.
 */

$pfObjeto =  new ProponentePfController();

$id = $_SESSION['usuario_id_p'];
$pf = $pfObjeto->recuperaProponentePf($id);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Pessoa Física</h1>
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
                        <h3 class="card-title">Dados</h3>
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
                                <div class="col-md-8">
                                    <label for="nome">Nome: *</label>
                                    <input type="text" class="form-control" id="nome" name="pf_nome" placeholder="Digite o nome" maxlength="70" value="<?= $pf->nome ?? '' ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="rg">RG: *</label>
                                    <input type="text" class="form-control" name="pf_rg" id="rg" placeholder="Digite o RG" maxlength="20" value="<?= $pf->rg ?? '' ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="cpf">CPF: *</label>
                                    <input type="text" name="pf_cpf" class="form-control" id="cpf" value="<?= $pf->cpf ?? null ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="pf_email">E-mail: *</label>
                                    <input type="email" id="pf_email" name="pf_email" class="form-control"
                                           maxlength="60" placeholder="Digite o E-mail"
                                           value="<?= $pf->email ?? '' ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="telefone">Telefone #1: *</label>
                                    <input type="text" id="telefone" name="te_telefone_1"
                                           onkeyup="mascara( this, mtel );"  class="form-control"
                                           placeholder="Digite o telefone" required
                                           value="<?= $pf->telefones['tel_0'] ?? "" ?>" maxlength="15">
                                </div>
                                <div class="col-md-2">
                                    <label for="telefone1">Telefone #2:</label>
                                    <input type="text" id="telefone1" name="te_telefone_2"
                                           onkeyup="mascara( this, mtel );"  class="form-control"
                                           placeholder="Digite o telefone" maxlength="15"
                                           value="<?=  $pf->telefones['tel_1'] ?? "" ?>">
                                </div>
                                <div class="col-md-2">
                                    <label for="telefone2">Telefone #3:</label>
                                    <input type="text" id="telefone2" name="te_telefone_3"
                                           onkeyup="mascara( this, mtel );"  class="form-control telefone"
                                           placeholder="Digite o telefone" maxlength="15"
                                           value="<?=  $pf->telefones['tel_2'] ?? "" ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <label for="genero">Gênero: *</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="genero" name="pf_genero_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $pfObjeto->geraOpcao("generos",$pf->genero_id ?? '',true);
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="etnia">Etnia: *</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="etnia" name="pf_etnia_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $pfObjeto->geraOpcao("etnias",$pf->etnia_id ?? '',true);
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label for="pf_cooperado">Cooperado?</label><br>
                                    <input type="checkbox" class="form-control-sm checkbox-grid-2 float-left" id="pf_cooperado" name="pf_cooperado" value="1"
                                        <?php
                                        if (isset($pf->cooperado)){
                                            if ($pf->cooperado == 1){
                                                echo 'checked';
                                            }
                                        }
                                        ?>
                                    >
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-5">
                                    <br>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input class="custom-control-input" type="checkbox" id="lei">
                                        <label for="lei" class="custom-control-label">Você já participou de outras leis de incentivo à cultura?</label>
                                    </div>
                                </div>
                                <div class="form-group col-md">
                                    <label for="lei_lei">Lei: *</label>
                                    <input type="text" class="form-control" id="lei_lei" name="lei_lei"
                                           maxlength="70" value="<?= $pf->lei_lei ?? null ?>" required readonly>
                                </div>
                            </div>

                            <hr>

                            <div class="row mt-2">
                                <div class="col-5">
                                    <label for="cep">CEP: *</label>
                                    <input type="text" class="form-control" name="en_cep" id="cep"
                                           onkeypress="mask(this, '#####-###')" maxlength="9"
                                           placeholder="Digite o CEP" required value="<?= $pf->cep ?? '' ?>" >
                                </div>
                                <div class="col-2">
                                    <label>&nbsp;</label><br>
                                    <input type="button" class="btn btn-primary" value="Carregar">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label for="rua">Rua: *</label>
                                    <input type="text" class="form-control" name="en_logradouro" id="rua"
                                           placeholder="Digite a rua" maxlength="200"
                                           value="<?= $pf->logradouro ?? '' ?>" readonly>
                                </div>
                                <div class="col-2">
                                    <label for="numero">Número: *</label>
                                    <input type="number" id="numero" name="en_numero" class="form-control"
                                           placeholder="Ex.: 10" value="<?= $pf->numero ?? '' ?>" required>
                                </div>
                                <div class="col">
                                    <label for="complemento">Complemento:</label>
                                    <input type="text" id="complemento" name="en_complemento" class="form-control" maxlength="20" placeholder="Digite o complemento" value="<?= $pf->complemento ?? '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="bairro">Bairro: *</label>
                                    <input type="text" class="form-control" name="en_bairro" id="bairro"
                                           placeholder="Digite o Bairro" maxlength="80"
                                           value="<?= $pf->bairro ?? '' ?>" readonly>
                                </div>
                                <div class="col">
                                    <label for="cidade">Cidade: *</label>
                                    <input type="text" class="form-control" name="en_cidade" id="cidade"
                                           placeholder="Digite a cidade" maxlength="50"
                                           value="<?= $pf->cidade ?? '' ?>" readonly>
                                </div>
                                <div class="col">
                                    <label for="estado">Estado: *</label>
                                    <input type="text" class="form-control" name="en_uf" id="estado" maxlength="2"
                                           placeholder="Ex.: SP" value="<?= $pf->uf ?? '' ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="zona">Zona *</label>
                                    <select name="en_zona_id" id="zona" class="form-control" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $pfObjeto->geraOpcao('zonas',$pf->zona_id ?? '') ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="subprefeitura">Subprefeitura *</label>
                                    <select name="en_subprefeitura_id" id="subprefeitura" class="form-control" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $pfObjeto->geraOpcao('subprefeituras',$pf->subprefeitura_id ?? '') ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="distrito">Distrito *</label>
                                    <select name="en_distrito_id" id="distrito" class="form-control" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $pfObjeto->geraOpcao('distritos',$pf->distrito_id ?? '') ?>
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
        $('#dados_cadastrais').addClass('active');
    });
</script>