<?php
require_once "./controllers/RepresentanteController.php";
$repObj = new RepresentanteController();

$id = $_GET['id'] ?? null;
$idPj = $_POST['idPj'] ?? $_GET['idPj'];

if (isset($_POST['cpf'])){
    $documento = $_POST['cpf'];
    $representante = $repObj->getCPF($documento);
    if ($representante){
        $id = (new MainModel)->encryption($representante->id);
        $representante = $repObj->recuperaRepresentante($id);
        $documento = $representante->cpf;
    }
}

if ($id) {
    $representante = $repObj->recuperaRepresentante($id);
    $documento = $representante->cpf;
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-9">
                <h1 class="m-0 text-dark">Representante Legal</h1>
            </div><!-- /.col -->
            <div class="col-sm-3">
                <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/representanteAjax.php" role="form" data-form="update">
                    <input type="hidden" name="_method" value="removerRep">
                    <input type="hidden" name="pagina" value="<?= $_GET['views'] ?>">
                    <input type="hidden" name="idPj" value="<?= $idPj ?>">
                    <button type="submit" class="btn btn-danger float-right">Remover Representante</button>
                    <div class="resposta-ajax"></div>
                </form>
            </div>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/representanteAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarRep" : "cadastrarRep" ?>">
                        <input type="hidden" name="pagina" value="<?= $_GET['views'] ?>">
                        <input type="hidden" name="idPj" value="<?= $idPj ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="nome">Nome: *</label>
                                    <input type="text" class="form-control" id="nome" name="pf_nome" placeholder="Digite o nome" maxlength="70" value="<?= $representante->nome ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="rg">RG: *</label>
                                    <input type="text" class="form-control" name="pf_rg" id="rg" placeholder="Digite o RG" maxlength="20" value="<?= $representante->rg ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cpf">CPF: *</label>
                                    <input type="text" name="pf_cpf" class="form-control" id="cpf" value="<?= $documento ?? null ?>" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="pf_email">E-mail: *</label>
                                    <input type="email" id="pf_email" name="pf_email" class="form-control"
                                           maxlength="60" placeholder="Digite o E-mail"
                                           value="<?= $representante->email ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone">Telefone #1: *</label>
                                    <input type="text" id="telefone" name="te_telefone_1"
                                           onkeyup="mascara( this, mtel );"  class="form-control"
                                           placeholder="Digite o telefone" required
                                           value="<?= $representante->telefones['tel_0'] ?? "" ?>" maxlength="15">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone1">Telefone #2:</label>
                                    <input type="text" id="telefone1" name="te_telefone_2"
                                           onkeyup="mascara( this, mtel );"  class="form-control"
                                           placeholder="Digite o telefone" maxlength="15"
                                           value="<?=  $representante->telefones['tel_1'] ?? "" ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone2">Telefone #3:</label>
                                    <input type="text" id="telefone2" name="te_telefone_3"
                                           onkeyup="mascara( this, mtel );"  class="form-control telefone"
                                           placeholder="Digite o telefone" maxlength="15"
                                           value="<?=  $representante->telefones['tel_2'] ?? "" ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="genero">Gênero: *</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="genero" name="pf_genero_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $repObj->geraOpcao("generos",$representante->genero_id ?? '',true);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="etnia">Etnia: *</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="etnia" name="pf_etnia_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $repObj->geraOpcao("etnias",$representante->etnia_id ?? '',true);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input custom-control-input-primary custom-control-input-outline"
                                               type="checkbox" id="lei" value="1" onchange="leiCheckbox()"
                                            <?php
                                            if (isset($representante->lei)){
                                                if ($representante->lei != null){
                                                    echo 'checked';
                                                }
                                            }
                                            ?>
                                        >
                                        <label for="lei" class="custom-control-label">Você já participou de outras leis de incentivo à cultura?</label>
                                    </div>
                                </div>
                                <div class="form-group col-md">
                                    <label for="lei_lei">Lei: *</label>
                                    <input type="text" class="form-control" id="lei_lei" name="le_lei"
                                           maxlength="70" value="<?= $representante->lei ?? null ?>" required disabled>
                                </div>
                            </div>

                            <hr>

                            <div class="row mt-2">
                                <div class="form-group col-5">
                                    <label for="cep">CEP: *</label>
                                    <input type="text" class="form-control" name="en_cep" id="cep"
                                           onkeypress="mask(this, '#####-###')" maxlength="9"
                                           placeholder="Digite o CEP" required value="<?= $representante->cep ?? '' ?>" >
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
                                           value="<?= $representante->logradouro ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-2">
                                    <label for="numero">Número: *</label>
                                    <input type="number" id="numero" name="en_numero" class="form-control"
                                           placeholder="Ex.: 10" value="<?= $representante->numero ?? '' ?>" required>
                                </div>
                                <div class="form-group col">
                                    <label for="complemento">Complemento:</label>
                                    <input type="text" id="complemento" name="en_complemento" class="form-control" maxlength="20" placeholder="Digite o complemento" value="<?= $representante->complemento ?? '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="bairro">Bairro: *</label>
                                    <input type="text" class="form-control" name="en_bairro" id="bairro"
                                           placeholder="Digite o Bairro" maxlength="80"
                                           value="<?= $representante->bairro ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col">
                                    <label for="cidade">Cidade: *</label>
                                    <input type="text" class="form-control" name="en_cidade" id="cidade"
                                           placeholder="Digite a cidade" maxlength="50"
                                           value="<?= $representante->cidade ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col">
                                    <label for="estado">Estado: *</label>
                                    <input type="text" class="form-control" name="en_uf" id="estado" maxlength="2"
                                           placeholder="Ex.: SP" value="<?= $representante->uf ?? '' ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="zona">Zona *</label>
                                    <select name="en_zona_id" id="zona" class="form-control" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $repObj->geraOpcao('zonas',$representante->zona_id ?? '') ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="distrito">Distrito *</label>
                                    <select name="en_distrito_id" id="distrito" class="form-control" required>
                                        <!-- Populando pelo js -->
                                        <?php
                                        if (isset($representante->distrito_id))
                                            $repObj->geraOpcao('distritos',$representante->distrito_id);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="subprefeitura">Subprefeitura *</label>
                                    <select name="en_subprefeitura_id" id="subprefeitura" class="form-control" required>
                                        <!-- Populando pelo js -->
                                        <?php
                                        if (isset($representante->subprefeitura_id))
                                            $repObj->geraOpcao('subprefeituras',$representante->subprefeitura_id);
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