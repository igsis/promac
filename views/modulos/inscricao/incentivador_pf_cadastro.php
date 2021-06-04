<?php
require_once "./controllers/ProponentePfController.php";
$url_zona = SERVERURL."api/api_distrito_subprefeitura.php";
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
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Dados</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/proponentePfAjax.php"
                          role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarPf" : "cadastrarPf" ?>">
                        <input type="hidden" name="pagina" value="<?= $_GET['views'] ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="nome">Nome: *</label>
                                    <input type="text" class="form-control" id="nome" name="pf_nome" placeholder="Digite o nome" maxlength="70" value="<?= $pf->nome ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="rg">RG: *</label>
                                    <input type="text" class="form-control" name="pf_rg" id="rg" placeholder="Digite o RG" maxlength="20" value="<?= $pf->rg ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cpf">CPF: *</label>
                                    <input type="text" name="pf_cpf" class="form-control" id="cpf" value="<?= $pf->cpf ?? null ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="pf_email">E-mail: *</label>
                                    <input type="email" id="pf_email" name="pf_email" class="form-control"
                                           maxlength="60" placeholder="Digite o E-mail"
                                           value="<?= $pf->email ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone">Telefone #1: *</label>
                                    <input type="text" id="telefone" name="te_telefone_1"
                                           onkeyup="mascara( this, mtel );"  class="form-control"
                                           placeholder="Digite o telefone" required
                                           value="<?= $pf->telefones['tel_0'] ?? "" ?>" maxlength="15">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone1">Telefone #2:</label>
                                    <input type="text" id="telefone1" name="te_telefone_2"
                                           onkeyup="mascara( this, mtel );"  class="form-control"
                                           placeholder="Digite o telefone" maxlength="15"
                                           value="<?=  $pf->telefones['tel_1'] ?? "" ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone2">Telefone #3:</label>
                                    <input type="text" id="telefone2" name="te_telefone_3"
                                           onkeyup="mascara( this, mtel );"  class="form-control telefone"
                                           placeholder="Digite o telefone" maxlength="15"
                                           value="<?=  $pf->telefones['tel_2'] ?? "" ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="genero">Gênero: *</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="genero" name="pf_genero_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $pfObjeto->geraOpcao("generos",$pf->genero_id ?? '',true);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="etnia">Etnia: *</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="etnia" name="pf_etnia_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $pfObjeto->geraOpcao("etnias",$pf->etnia_id ?? '',true);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="pf_cooperado">Cooperado?</label><br>
                                    <input type="checkbox" class="checkbox-grid-2" id="pf_cooperado" name="pf_cooperado" value="1"
                                        <?php
                                        if (isset($pf->cooperado)){
                                            if ($pf->cooperado == 1){
                                                echo 'checked';
                                            }
                                        }
                                        ?>
                                    >
                                </div>
                                <div class="form-group col-md-3"><br>
                                    <div class="row">
                                        <div class="col-2" style="text-align: right"><input id="lei" type="checkbox" class="form-control-sm checkbox-grid-2"></div>
                                        <div class="col"><label for="lei">Você já participou de outras leis de incentivo à cultura?</label></div>
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
                                <div class="form-group col-5">
                                    <label for="cep">CEP: *</label>
                                    <input type="text" class="form-control" name="en_cep" id="cep"
                                           onkeypress="mask(this, '#####-###')" maxlength="9"
                                           placeholder="Digite o CEP" required value="<?= $pf->cep ?? '' ?>" >
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
                                           value="<?= $pf->logradouro ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-2">
                                    <label for="numero">Número: *</label>
                                    <input type="number" id="numero" name="en_numero" class="form-control"
                                           placeholder="Ex.: 10" value="<?= $pf->numero ?? '' ?>" required>
                                </div>
                                <div class="form-group col">
                                    <label for="complemento">Complemento:</label>
                                    <input type="text" id="complemento" name="en_complemento" class="form-control" maxlength="20" placeholder="Digite o complemento" value="<?= $pf->complemento ?? '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="bairro">Bairro: *</label>
                                    <input type="text" class="form-control" name="en_bairro" id="bairro"
                                           placeholder="Digite o Bairro" maxlength="80"
                                           value="<?= $pf->bairro ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col">
                                    <label for="cidade">Cidade: *</label>
                                    <input type="text" class="form-control" name="en_cidade" id="cidade"
                                           placeholder="Digite a cidade" maxlength="50"
                                           value="<?= $pf->cidade ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col">
                                    <label for="estado">Estado: *</label>
                                    <input type="text" class="form-control" name="en_uf" id="estado" maxlength="2"
                                           placeholder="Ex.: SP" value="<?= $pf->uf ?? '' ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="zona">Zona *</label>
                                    <select name="en_zona_id" id="zona" class="form-control" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $pfObjeto->geraOpcao('zonas',$pf->zona_id ?? '') ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="distrito">Distrito *</label>
                                    <select name="en_distrito_id" id="distrito" class="form-control" required>
                                        <!-- Populando pelo js -->
                                        <?php
                                        if (isset($pf->distrito_id))
                                            $pfObjeto->geraOpcao('distritos',$pf->distrito_id);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="subprefeitura">Subprefeitura *</label>
                                    <select name="en_subprefeitura_id" id="subprefeitura" class="form-control" required>
                                        <!-- Populando pelo js -->
                                        <?php
                                        if (isset($pf->subprefeitura_id))
                                            $pfObjeto->geraOpcao('subprefeituras',$pf->subprefeitura_id);
                                        ?>
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