<?php
require_once "./controllers/PessoaFisicaController.php";
require_once "./controllers/FormacaoController.php";

$pfObjeto =  new PessoaFisicaController();
$formacaoObj = new FormacaoController();

if (isset($_GET['id'])) {
    $_SESSION['origem_id_c'] = $id = $_GET['id'];
} elseif (isset($_SESSION['origem_id_c'])){
    $id = $_SESSION['origem_id_c'];
} else {
    $id = null;
}

if ($id) {
    $pf = $pfObjeto->recuperaPessoaFisica($id);
    $formacao_id = $formacaoObj->recuperaFormacaoId($id, $_SESSION['ano_c']);
    if ($formacao_id) {
        $_SESSION['formacao_id_c'] = $formacao_id;
    }
    $_SESSION['origem_id_c'] = $id;
    $documento = $pf['cpf'];
}

if (isset($_POST['pf_cpf'])){
    $documento = $_POST['pf_cpf'];
    $pf = $pfObjeto->getCPF($documento)->fetch();
    if ($pf){
        $id = (new MainModel)->encryption($pf['id']);
        $pf = $pfObjeto->recuperaPessoaFisica($id);
        $_SESSION['origem_id_c'] = $id;
        $documento = $pf['cpf'];
    }
}

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
                                <div class="form-group col-md-6">
                                    <label for="nome">Nome: *</label>
                                    <input type="text" class="form-control" id="nome" name="pf_nome" placeholder="Digite o nome" maxlength="70" value="<?= $pf['nome'] ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nomeArtistico">Nome Artístico:</label>
                                    <input type="text" class="form-control" name="pf_nome_artistico" id="nomeArtistico" placeholder="Digite o nome artístico" maxlength="70" value="<?= $pf['nome_artistico'] ?? '' ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label for="rg">RG: *</label>
                                    <input type="text" class="form-control" name="pf_rg" id="rg" placeholder="Digite o RG" maxlength="20" value="<?= $pf['rg'] ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cpf">CPF: </label>
                                    <input type="text" name="pf_cpf" class="form-control" id="cpf" value="<?= $documento ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="ccm">CCM:</label>
                                    <input type="text" id="ccm" name="pf_ccm" class="form-control" placeholder="Digite o CCM" maxlength="11" value="<?= $pf['ccm'] ?? '' ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="data_nascimento">Data de nascimento: *</label>
                                    <input type="date" class="form-control" id="data_nascimento"
                                           name="pf_data_nascimento" onkeyup="barraData(this);"
                                           value="<?= $pf['data_nascimento'] ?? '' ?>" required/>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="nacionalidade">Nacionalidade: *</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="nacionalidade" name="pf_nacionalidade_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $pfObjeto->geraOpcao("nacionalidades",$pf['nacionalidade_id'] ?? '');
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="pf_email">E-mail: *</label>
                                    <input type="email" name="pf_email" class="form-control"
                                           maxlength="60" placeholder="Digite o E-mail"
                                           value="<?= $pf['email'] ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone">Telefone #1: *</label>
                                    <input type="text" id="telefone" name="te_telefone_1"
                                           onkeyup="mascara( this, mtel );"  class="form-control"
                                           placeholder="Digite o telefone" required
                                           value="<?= $pf['telefones']['tel_0'] ?? "" ?>" maxlength="15">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone1">Telefone #2:</label>
                                    <input type="text" id="telefone1" name="te_telefone_2"
                                           onkeyup="mascara( this, mtel );"  class="form-control"
                                           placeholder="Digite o telefone" maxlength="15"
                                           value="<?= $pf['telefones']['tel_1'] ?? "" ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone2">Telefone #3:</label>
                                    <input type="text" id="telefone2" name="te_telefone_3"
                                           onkeyup="mascara( this, mtel );"  class="form-control telefone"
                                           placeholder="Digite o telefone" maxlength="15"
                                           value="<?= $pf['telefones']['tel_2'] ?? "" ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="nit">NIT: *</label>
                                    <input type="text" id="nit" name="ni_nit" class="form-control" maxlength="45"
                                           placeholder="Digite o NIT" required value="<?= $pf['nit'] ?? '' ?>">
                                </div>
                                <div class="form-group col-md">
                                    <label for="drt">DRT: </label>
                                    <input type="text" id="drt" name="dr_drt" class="form-control" maxlength="45"
                                           placeholder="Digite o DRT em caso de artes cênicas"
                                           value="<?= $pf['drt'] ?? '' ?>">
                                </div>
                                <div class="form-group col-md">
                                    <label for="grau_instrucao">Grau de instrução: *</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="grau_instrucao" name="dt_grau_instrucao_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $pfObjeto->geraOpcao("grau_instrucoes",$pf['grau_instrucao_id'] ?? '');
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label for="etnia">Etnia: *</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="etnia" name="dt_etnia_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $pfObjeto->geraOpcao("etnias",$pf['etnia_id'] ?? '',true);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md">
                                    <label for="genero">Gênero: *</label>
                                    <select class="form-control select2bs4" style="width: 100%;" id="genero" name="dt_genero_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $pfObjeto->geraOpcao("generos",$pf['genero_id'] ?? '',true);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="dt_trans">Trans?</label><br>
                                    <input type="checkbox" class="form-control-sm checkbox-grid-2 float-left" id="dt_trans" name="dt_trans" value="1"
                                        <?php
                                        if (isset($pf['trans'])){
                                            if ($pf['trans'] == 1){
                                                echo 'checked';
                                            }
                                        }
                                        ?>
                                    >
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="dt_pcd">PCD?</label><br>
                                    <input type="checkbox" class="form-control-sm checkbox-grid-2 float-left" id="dt_pcd" name="dt_pcd" value="1"
                                        <?php
                                        if (isset($pf['pcd'])){
                                            if ($pf['pcd'] == 1){
                                                echo 'checked';
                                            }
                                        }
                                        ?>
                                    >
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