<?php
require_once "./controllers/PessoaFisicaController.php";
require_once "./controllers/FormacaoController.php";

$pfObj = new PessoaFisicaController();
$formObj = new FormacaoController();

$ano = $_SESSION['ano_c'];
$form_cadastro_id = $_SESSION['formacao_id_c'];

$cadastroEncerrado = $formObj->cadastroEncerrado($ano);

/* ************** Pessoa Física ************** */

$pessoa_fisica_id = $_SESSION['origem_id_c'];
$pf = $pfObj->recuperaPessoaFisica($pessoa_fisica_id);

$form = $formObj->recuperaFormacao($ano, false, $form_cadastro_id);
$validacoesPrograma = $formObj->validaForm($form_cadastro_id, $pessoa_fisica_id, $form->form_cargo_id);
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Finalizar o Envio</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <?php
        if ($validacoesPrograma) {
            ?>
            <div class="row erro-validacao">
                <?php foreach ($validacoesPrograma as $titulo => $erros): ?>
                    <div class="col-md-4">
                        <div class="card bg-danger">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-exclamation mr-3"></i><strong>Erros
                                        em <?= $titulo ?></strong></h3>
                            </div>
                            <div class="card-body">
                                <?php foreach ($erros as $erro): ?>
                                    <li><?= $erro ?></li>
                                <?php endforeach; ?>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
        }
        ?>
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
                            <div class="col-md-12"><b>Nome:</b> <?= $pf['nome'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b>Nome Artístico:</b> <?= $pf['nome_artistico'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>RG:</b> <?= $pf['rg'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>CPF:</b> <?= $pf['cpf'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>CCM:</b> <?= $pf['ccm'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Data de Nascimento:</b> <?= date("d/m/Y", strtotime($pf['data_nascimento'])) ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Nacionalidade:</b> <?= $pf['nacionalidade'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4"><b>E-mail:</b> <?= $pf['email'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <b>Telefones:</b>
                                <?= isset($pf['telefones']) ? implode(" | ", $pf['telefones']) : "" ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <b>Endereço:</b> <?= $pf['logradouro'] . ", " . $pf['numero'] . " " . $pf['complemento'] . " " . $pf['bairro'] . " - " . $pf['cidade'] . "-" . $pf['uf'] . " CEP: " . $pf['cep'] ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Etnia:</b> <?= $pf['descricao'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Grau de instrução:</b> <?= $pf['grau_instrucao'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>NIT:</b> <?= $pf['nit'] ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>DRT:</b> <?= $pf['drt'] ?></div>
                        </div>
                        <?php if ($pf['banco']): ?>
                            <div class="row">
                                <div class="col"><b>Banco:</b> <?= $pf['banco'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col"><b>Agência:</b> <?= $pf['agencia'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col"><b>Conta:</b> <?= $pf['conta'] ?></div>
                            </div>
                        <?php endif ?>
                        <br>
                        <!-- ************** Programa ************** -->
                        <hr>
                        <h5><b>Detalhes do programa</b></h5>
                        <hr/>
                        <div class="row">
                            <div class="col"><b>Ano de execução do serviço:</b> <?= $form->ano ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Região preferencial:</b> <?= $form->regiao ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Cargo:</b> <?= $form->cargo1 ?></div>
                        </div>
                        <?php if ($form->cargo2): ?>
                            <div class="row">
                                <div class="col"><b>Cargo (2º Opção):</b> <?= $form->cargo2 ?></div>
                            </div>
                        <?php endif ?>
                        <?php if ($form->cargo3): ?>
                            <div class="row">
                                <div class="col"><b>Cargo (3º Opção):</b> <?= $form->cargo3 ?></div>
                            </div>
                        <?php endif ?>
                        <div class="row">
                            <div class="col"><b>Programa:</b> <?= $form->programa ?></div>
                        </div>
                        <div class="row">
                            <div class="col"><b>Linguagem:</b> <?= $form->linguagem ?></div>
                        </div>
                    </div>
                    <?php if (!$cadastroEncerrado): ?>
                        <div class="card-footer" id="cardFooter">
                            <?php if (!$validacoesPrograma): ?>
                                <form class="form-horizontal formulario-ajax" method="POST"
                                      action="<?= SERVERURL ?>ajax/formacaoAjax.php" role="form" data-form="update"
                                      id="formEnviar">
                                    <input type="hidden" name="_method" value="envioFormacao">
                                    <input type="hidden" name="id" value="<?= $form_cadastro_id ?>">
                                    <button type="submit" class="btn btn-success btn-block float-right" id="cadastra">
                                        Enviar
                                    </button>
                                    <div class="resposta-ajax"></div>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-warning btn-block float-right">
                                    Você possui pendencias em seu cadastro. Verifique-as no topo da tela para poder
                                    envia-lo
                                </button>
                            <?php endif ?>
                        </div>
                    <?php else: ?>
                        <button class="btn btn-danger btn-block float-right">
                            O período para inscrições está encerrado.
                        </button>
                    <?php endif ?>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->