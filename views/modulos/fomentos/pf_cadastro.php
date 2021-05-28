<?php
require_once "./controllers/PessoaFisicaController.php";

$pfObjeto =  new PessoaFisicaController();

if (isset($_GET['id'])) {
    $_SESSION['origem_id_c'] = $id = $_GET['id'];
} elseif (isset($_SESSION['origem_id_c'])){
    $id = $_SESSION['origem_id_c'];
} else {
    $id = null;
}

if ($id) {
    $pf = $pfObjeto->recuperaPessoaFisicaFom($id);
    $documento = $pf['cpf'];
}

if (isset($_POST['pf_cpf'])){
    $documento = $_POST['pf_cpf'];
    $pf = $pfObjeto->getCPF($documento)->fetch();
    if ($pf){
        $id = (new MainModel)->encryption($pf['id']);
        $pf = $pfObjeto->recuperaPessoaFisicaFom($id);
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
            <?php
            if ($id) {
                ?>
                <div class="col-sm-6">
                    <button type="submit" data-toggle="modal" data-target="#modal-troca" class="btn btn-secondary float-right">Trocar Pessoa Física</button>
                </div><!-- /.col -->
                <?php
            }
            ?>
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
                    <form class="form-horizontal formulario-ajax" method="POST"
                          action="<?= SERVERURL ?>ajax/projetoAjax.php" role="form"
                          data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="cadastrarPf">
                        <input type="hidden" name="pf_ultima_atualizacao" value="<?= date('Y-m-d H-i-s') ?>">
                        <input type="hidden" name="pagina" value="<?= $_GET['views'] ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <button class="btn swalDefaultWarning">
                            </button>
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col form-group">
                                    <label for="nome">Nome Completo:</label>
                                    <input type="text" class="form-control" name="pf_nome" id="nome" value="<?= $pf['nome'] ?? '' ?>">
                                </div>
                                <div class="col form-group">
                                    <label for="cpf">CPF:</label>
                                    <input type="text" class="form-control" name="pf_cpf" readonly
                                           value="<?= isset($_POST['pf_cpf']) ? $_POST['pf_cpf'] : $pf['cpf'] ?>">
                                </div>
                            </div>
                            <div class="row my-1">
                                <div class="col form-group">
                                    <label for="genero">Gênero *:</label>
                                    <select name="fm_genero_id" id="genero" class="form-control" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $pfObjeto->geraOpcao('generos',$pf['genero_id'] ?? '', true) ?>
                                    </select>
                                </div>
                                <div class="col form-group">
                                    <label for="etnia">Raça ou Cor *:</label>
                                    <select name="fm_etnia_id" id="etnia" class="form-control" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $pfObjeto->geraOpcao('etnias',$pf['etnia_id'] ?? '', true) ?>
                                    </select>
                                </div>
                                <div class="col form-group">
                                    <label for="data_nascimento">Data de Nascimento:</label>
                                    <input type="date" name="pf_data_nascimento" id="data_nascimento"
                                           class="form-control"
                                           onkeyup="barraData(this);"
                                           value="<?= $pf['data_nascimento'] ?? '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group">
                                    <label for="fm_rede_social">Rede Social:</label>
                                    <input type="text" class="form-control" name="fm_rede_social" id="redeSocial"
                                           value="<?= $pf['rede_social'] ?? '' ?>">
                                </div>
                                <div class="col form-group">
                                    <label for="subprefeitura">Escolaridade *</label>
                                    <select name="fm_grau_instrucao_id" id="grau_instrucao" class="form-control" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $pfObjeto->geraOpcao('grau_instrucoes',$pf['grau_instrucao_id'] ?? '', false, false, true) ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-group">
                                    <label for="email">E-mail: *</label>
                                    <input type="email" name="pf_email" class="form-control" maxlength="60"
                                           placeholder="Digite o E-mail" required value="<?= $pf['email'] ?? '' ?>">
                                </div>
                                <div class="col form-group">
                                    <label for="telefone">Telefone #1: *</label>
                                    <input type="text" id="telefone" name="te_telefone_1"
                                           onkeyup="mascara( this, mtel );"  class="form-control"
                                           placeholder="Digite o telefone" required maxlength="15"
                                           value="<?= $pf['telefones']['tel_0'] ?? '' ?>">
                                </div>
                                <div class="col form-group">
                                    <label for="telefone">Telefone #2: *</label>
                                    <input type="text" id="telefone1" name="te_telefone_2"
                                           onkeyup="mascara( this, mtel );"  class="form-control"
                                           placeholder="Digite o telefone" required maxlength="15"
                                           value="<?= $pf['telefones']['tel_1'] ?? "" ?>">
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-2">
                                <div class="form-group col-5">
                                    <label for="cep">CEP: *</label>
                                    <input type="text" class="form-control" name="en_cep" id="cep"
                                           onkeypress="mask(this, '#####-###')" maxlength="9"
                                           placeholder="Digite o CEP" required value="<?= $pf['cep'] ?? '' ?>" >
                                </div>
                                <div class="form-group col-2">
                                    <label>&nbsp;</label><br>
                                    <input type="button" class="btn btn-primary" value="Carregar">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="rua">Rua: *</label>
                                    <input type="text" class="form-control" name="en_logradouro" id="rua"
                                           placeholder="Digite a rua" maxlength="200"
                                           value="<?= $pf['logradouro'] ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-2">
                                    <label for="numero">Número: *</label>
                                    <input type="number" name="en_numero" class="form-control"
                                           placeholder="Ex.: 10" value="<?= $pf['numero'] ?? '' ?>" required>
                                </div>
                                <div class="form-group col">
                                    <label for="complemento">Complemento:</label>
                                    <input type="text" name="en_complemento" class="form-control" maxlength="20"
                                           placeholder="Digite o complemento" value="<?= $pf['complemento'] ?? '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label for="bairro">Bairro: *</label>
                                    <input type="text" class="form-control" name="en_bairro" id="bairro"
                                           placeholder="Digite o Bairro" maxlength="80"
                                           value="<?= $pf['bairro'] ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col">
                                    <label for="cidade">Cidade: *</label>
                                    <input type="text" class="form-control" name="en_cidade" id="cidade"
                                           placeholder="Digite a cidade" maxlength="50"
                                           value="<?= $pf['cidade'] ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col">
                                    <label for="estado">Estado: *</label>
                                    <input type="text" class="form-control" name="en_uf" id="estado" maxlength="2"
                                           placeholder="Ex.: SP" value="<?= $pf['uf'] ?? '' ?>" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="subprefeitura">Subprefeitura *</label>
                                    <select name="fm_subprefeitura_id" id="genero" class="form-control" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php $pfObjeto->geraOpcao('subprefeituras',$pf['subprefeitura_id'] ?? '') ?>
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


        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!--.modal-->
<div class="modal fade" id="modal-troca">
    <div class="modal-dialog">
        <div class="modal-content bg-warning">
            <div class="modal-header">
                <h4 class="modal-title">Trocar inscrito do projeto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/projetoAjax.php" role="form" data-form="delete">
                <input type="hidden" name="_method" value="removerPf">
                <div class="modal-body">
                    <p>Realmente deseja remover o inscrito <?= $pf['nome'] ?? '' ?> deste projeto?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <button type="submit" class="btn btn-default">Sim</button>
                </div>
                <div class="resposta-ajax"></div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

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
        $('#proponente').addClass('active');
    });
</script>