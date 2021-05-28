<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
require_once "./controllers/PessoaFisicaController.php";
$insPessoaFisica = new PessoaFisicaController();
require_once "./controllers/AtracaoController.php";
$insAtracao = new AtracaoController();

if ($id) {
    $pf = $insPessoaFisica->recuperaPessoaFisica($id);
    $cenica = $insAtracao->verificaCenica($_SESSION['origem_id_c']);
    if ($pf['cpf'] != "") {
        $documento = $pf['cpf'];
    } else {
        $documento = $pf['passaporte'];
    }
}

if (isset($_POST['pf_cpf'])){
    $documento = $_POST['pf_cpf'];
    $pf = $insPessoaFisica->getCPF($documento)->fetch();
    if ($pf['cpf'] != ''){
        $id = MainModel::encryption($pf['id']);
        $pf = $insPessoaFisica->recuperaPessoaFisica($id);
        $documento = $pf['cpf'];
    }
    $cenica = $insAtracao->verificaCenica($_SESSION['origem_id_c']);
}
if (isset($_POST['pf_passaporte'])){
    $documento = $_POST['pf_passaporte'];
    $pf = $insPessoaFisica->getPassaporte($documento)->fetch();
    if ($pf['passaporte'] != ''){
        $id = MainModel::encryption($pf['id']);
        $pf = $insPessoaFisica->recuperaPessoaFisica($id);
        $documento = $pf['passaporte'];
    }
    $cenica = $insAtracao->verificaCenica($_SESSION['origem_id_c']);
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro do líder do grupo ou artista solo</h1>
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
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/liderAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="pagina" value="oficina">
                        <input type="hidden" name="atracao_id" value="<?= $_POST['atracao_id'] ?>">
                        <input type="hidden" name="pf_ultima_atualizacao" value="<?= date('Y-m-d H-i-s') ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nome">Nome: *</label>
                                    <input type="text" class="form-control" name="pf_nome" placeholder="Digite o nome" maxlength="70" value="<?= $pf['nome'] ?>" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="nomeArtistico">Nome Artistico:</label>
                                    <input type="text" class="form-control" name="pf_nome_artistico" placeholder="Digite o nome artistico" maxlength="70" value="<?= $pf['nome_artistico'] ?>">
                                </div>
                            </div>

                            <div class="row">
                                <?php
                                if (isset($_POST['pf_cpf']) || $pf['cpf'] != ""){
                                    ?>
                                    <div class="form-group col-md-3">
                                        <label for="rg">RG: *</label>
                                        <input type="text" class="form-control" name="pf_rg" placeholder="Digite o RG" maxlength="20" value="<?= $pf['rg'] ?>" required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="cpf">CPF: </label>
                                        <input type="text" name="pf_cpf" class="form-control" id="cpf" value="<?= $documento ?>" readonly>
                                    </div>
                                    <?php
                                }
                                else{
                                    ?>
                                    <div class="form-group col-md-6">
                                        <label for="passaporte" id="documento">Passaporte: </label>
                                        <input type="text" id="passaporte" name="pf_passaporte" class="form-control" value="<?= $documento ?>" readonly>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="form-group col-md-6">
                                    <label for="email">E-mail: *</label>
                                    <input type="email" name="pf_email" class="form-control" maxlength="60" placeholder="Digite o E-mail" value="<?= $pf['email'] ?>" required>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-2">
                                    <label>Telefone #1: *</label>
                                    <input type="text" id="telefone" name="te_telefone_1" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" required value="<?= $pf['telefones']['tel_0'] ?? "" ?>" maxlength="15">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #2:</label>
                                    <input type="text" id="telefone1" name="te_telefone_2" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" maxlength="15" value="<?= $pf['telefones']['tel_1'] ?? "" ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Telefone #3:</label>
                                    <input type="text" id="telefone2" name="te_telefone_3" onkeyup="mascara( this, mtel );"  class="form-control telefone" placeholder="Digite o telefone" maxlength="15" value="<?= $pf['telefones']['tel_2'] ?? "" ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <?php if ($cenica > 0): ?>
                                        <label for="drt">DRT: </label>
                                        <input type="text" id="drt" name="dr_drt" class="form-control" maxlength="45" placeholder="Digite o DRT em caso de artes cênicas" value="<?= $pf['drt'] ?>">
                                    <?php endif; ?>
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