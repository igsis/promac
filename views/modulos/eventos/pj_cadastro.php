<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
require_once "./controllers/PessoaJuridicaController.php";
$insPessoaJuridica = new PessoaJuridicaController();

if ($id) {
    $pj = $insPessoaJuridica->recuperaPessoaJuridica($id);
    $cnpj = $pj['cnpj'];
}

if (isset($_POST['pj_cnpj'])){
    $pj = $insPessoaJuridica->getCNPJ($_POST['pj_cnpj'])->fetch();
    if ($pj){
        $id = MainModel::encryption($pj['id']);
        $pj = $insPessoaJuridica->recuperaPessoaJuridica($id);
        $cnpj = $pj['cnpj'];
    }
    else{
        $cnpj = $_POST['pj_cnpj'];
    }
}
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
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Dados</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/pedidoJuridicaAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="ultima_atualizacao" value="<?= date('Y-m-d H-i-s') ?>">
                        <input type="hidden" name="pagina" value="eventos">
                        <input type="hidden" name="origem_tipo" value="1">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <button class="btn swalDefaultWarning">
                            </button>
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label for="razao_social">Razão Social: *</label>
                                    <input type="text" class="form-control" id="razao_social" name="pj_razao_social" maxlength="100" required value="<?= $pj['razao_social'] ?? '' ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cnpj">CNPJ: *</label>
                                    <input type="text" class="form-control" id="cnpj" name="pj_cnpj" value="<?= $cnpj ?>" required readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="ccm">CCM: </label>
                                    <input type="text" class="form-control" id="ccm" name="pj_ccm" value="<?= $pj['ccm'] ?? '' ?>">
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email">E-mail: *</label>
                                    <input type="email" name="pj_email" class="form-control" maxlength="60" placeholder="Digite o E-mail" value="<?= $pj['email'] ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone">Telefone #1: *</label>
                                    <input type="text" id="telefone" name="te_telefone_1" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" required value="<?= $pj['telefones']['tel_0'] ?? "" ?>" maxlength="15">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone1">Telefone #2:</label>
                                    <input type="text" id="telefone1" name="te_telefone_2" onkeyup="mascara( this, mtel );"  class="form-control" placeholder="Digite o telefone" maxlength="15" value="<?= $pj['telefones']['tel_1'] ?? "" ?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="telefone2">Telefone #3:</label>
                                    <input type="text" id="telefone2" name="te_telefone_3" onkeyup="mascara( this, mtel );"  class="form-control telefone" placeholder="Digite o telefone" maxlength="15" value="<?= $pj['telefones']['tel_2'] ?? "" ?>">
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="cep">CEP: *</label>
                                    <input type="text" class="form-control" name="en_cep" id="cep" onkeypress="mask(this, '#####-###')" maxlength="9" placeholder="Digite o CEP" required value="<?= $pj['cep'] ?? '' ?>" >
                                </div>
                                <div class="form-group col-md-2">
                                    <label>&nbsp;</label><br>
                                    <input type="button" class="btn btn-primary" value="Carregar">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="rua">Rua: *</label>
                                    <input type="text" class="form-control" name="en_logradouro" id="rua" placeholder="Digite a rua" maxlength="2   00" value="<?= $pj['logradouro'] ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="numero">Número: *</label>
                                    <input type="number" name="en_numero" class="form-control" placeholder="Ex.: 10" value="<?= $pj['numero'] ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="complemento">Complemento:</label>
                                    <input type="text" name="en_complemento" class="form-control" maxlength="20" placeholder="Digite o complemento" value="<?= $pj['complemento'] ?? '' ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="bairro">Bairro: *</label>
                                    <input type="text" class="form-control" name="en_bairro" id="bairro" placeholder="Digite o Bairro" maxlength="80" value="<?= $pj['bairro'] ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="cidade">Cidade: *</label>
                                    <input type="text" class="form-control" name="en_cidade" id="cidade" placeholder="Digite a cidade" maxlength="50" value="<?= $pj['cidade'] ?? '' ?>" readonly>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="estado">Estado: *</label>
                                    <input type="text" class="form-control" name="en_uf" id="estado" maxlength="2" placeholder="Ex.: SP" value="<?= $pj['uf'] ?? '' ?>" readonly>
                                </div>
                            </div>
                            <hr/>
                            <div class="alert alert-warning alert-dismissible">
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção!</h5>
                                Realizamos pagamentos de valores acima de R$ 5.000,00 <b>* SOMENTE COM CONTA CORRENTE NO BANCO DO BRASIL *</b>. Não são aceitas: conta fácil, poupança e conjunta.
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="banco">Banco:</label>
                                    <select required id="banco" name="bc_banco_id" class="form-control">
                                        <option value="">Selecione um banco...</option>
                                        <?php
                                        $insPessoaJuridica->geraOpcao("bancos",$pj['banco_id']);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="agencia">Agência: *</label>
                                    <input type="text" id="agencia" name="bc_agencia" class="form-control"  placeholder="Digite a Agência" maxlength="12" value="<?= $pj['agencia'] ?? '' ?>" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="conta">Conta: *</label>
                                    <input type="text" id="conta" name="bc_conta" class="form-control" placeholder="Digite a Conta" maxlength="12" value="<?= $pj['conta'] ?? '' ?>" required>
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

        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-body">
                        <div class="row">
                            <?php
                            if  ($id):
                                if ($pj['representante_legal1_id']):
                                    $r1 = $pj['representante_legal1_id'];
                                    $rep1 = DbModel::consultaSimples("SELECT * FROM representante_legais WHERE id = '$r1'")->fetch();
                            ?>
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th>Representante Legal</th>
                                            <th>RG</th>
                                            <th>CPF</th>
                                            <th>Ação</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><b>#1</b></td>
                                                <td><?= $rep1['nome'] ?></td>
                                                <td><?= $rep1['rg'] ?></td>
                                                <td><?= $rep1['cpf'] ?></td>
                                                <td>
                                                    <div class="row">
                                                        <form class="form-horizontal mr-2" method="POST" action="<?= SERVERURL ?>eventos/representante_cadastro&idPj=<?= $id ?>&id=<?= MainModel::encryption($rep1['id']) ?>" role="form">
                                                            <input type="hidden" name="representante" value="1">
                                                            <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</button>
                                                        </form>
                                                        <button class="btn btn-sm btn-danger" id="e1"><i class="fas fa-trash"></i> Apagar</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            if ($pj['representante_legal2_id']):
                                                $r2 = $pj['representante_legal2_id'];
                                                $rep2 = DbModel::consultaSimples("SELECT * FROM representante_legais WHERE id = '$r2'")->fetch();
                                            ?>
                                                <tr>
                                                    <td><b>#2</b></td>
                                                    <td><?= $rep2['nome'] ?></td>
                                                    <td><?= $rep2['rg'] ?></td>
                                                    <td><?= $rep2['cpf'] ?></td>
                                                    <td>
                                                        <div class="row">
                                                            <form class="form-horizontal mr-2" method="POST" action="<?= SERVERURL ?>eventos/representante_cadastro&idPj=<?= $id ?>&id=<?= MainModel::encryption($rep2['id']) ?>" role="form">
                                                                <input type="hidden" name="representante" value="2">
                                                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Editar</button>
                                                            </form>
                                                            <button class="btn btn-sm btn-danger" id="e2"><i class="fas fa-trash"></i> Apagar</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                            else:
                                            ?>
                                                <button class="btn btn-sm btn-primary" id="2"><i class="fas fa-plus"></i> Novo Representante Legal #2</button>

                                            <?php
                                            endif;
                                            ?>
                                        </tbody>
                                    </table>
                            <?php
                                else:
                                    ?>
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default" id="1"><i class="fas fa-plus"></i> Novo Representante Legal #1</button>
                            <?php
                                endif;
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Representante Legal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal" method="POST" action="<?= SERVERURL ?>eventos/representante_cadastro&idPj=<?= $id ?>" role="form" id="formularioPf">
                <input type="hidden" name="idPj" value="<?= $id ?>">
                <input type="hidden" name="representante" id="representante">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="cpf">CPF:</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" onkeypress="mask(this, '###.###.###-##')" maxlength="14" required>
                        </div>
                        <br>
                        <span style="display: none;" id="dialogError" class="alert alert-danger"
                              role="alert">CPF inválido</span>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary btn">Pesquisar</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!--.modal-->
<div class="modal fade" id="modal-exclusao">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">Representante Legal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/representanteAjax.php" role="form" data-form="update">
                <input type="hidden" name="_method" value="remover">
                <input type="hidden" name="idPj" value="<?= $id ?>">
                <input type="hidden" name="pagina" value="eventos">
                <input type="hidden" name="representante" id="representanteEx">
                <div class="modal-body">
                    <p>Realmente deseja remover o represente legal?</p>
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

<script>
    $(document).ready(function(){
        $("#1").click(function(){
            $("#representante").attr("value","1");
            $("#modal-default").modal();
        });
        $("#2").click(function(){
            $("#representante").attr("value","2");
            $("#modal-default").modal();
        });
        $("#e1").click(function(){
            $("#representanteEx").attr("value","1");
            $("#modal-exclusao").modal();
        });
        $("#e2").click(function(){
            $("#representanteEx").attr("value","2");
            $("#modal-exclusao").modal();
        });
    });
</script>

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
</script>