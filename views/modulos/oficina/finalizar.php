<?php
require_once "./controllers/EventoController.php";
$eventoObj = new EventoController();
$idEvento = $_SESSION['origem_id_c'];
$evento = $eventoObj->recuperaEvento($idEvento);

require_once "./controllers/PedidoController.php";
$pedidoObj = new PedidoController();
$pedido = $pedidoObj->recuperaPedido(1, true);

require_once "./controllers/AtracaoController.php";
$atracaoObj = new AtracaoController();
$idAtracao = $atracaoObj->getAtracaoId($idEvento);
$cenica = $atracaoObj->verificaCenica($idEvento);




$erro = "<span style=\"color: red; \"><b>Preenchimento obrigatório</b></span>";
$validacoesEvento = $eventoObj->validaEvento($_SESSION['origem_id_c'], $_SESSION['pedido_id_c']);
//$validacoesAtracoes = $atracaoObj->validaAtracao($_SESSION['origem_id_c']);
$modulo = explode("/", $_GET['views'])[0];
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Finalizar Oficina</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <?php if ($validacoesEvento): ?>
            <div class="row erro-validacao">
                <?php if ($validacoesEvento): ?>
                    <?php foreach ($validacoesEvento as $titulo => $erros): ?>
                    <div class="col-md-4">
                        <div class="card bg-danger">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-exclamation mr-3"></i><strong>Erros em <?=$titulo?></strong></h3>
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
                <?php endif; ?>
            </div>
        <?php endif; ?>
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
                        <h5 class="m-0">Dados da Oficina</h5>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12"><b>Nome do oficina:</b> <?= $evento->nome_evento ?></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"><b>Espaço em que será realizado o evento é público?</b> <?php if ($evento->espaco_publico == 0): echo "Sim"; else: echo "Não"; endif;  ?></div>
                            <div class="col-md-6"><b>É fomento/programa?</b>
                                <?php
                                if($evento->fomento == 0){
                                    echo "Não";
                                } else{
                                    echo "Sim: ".$evento->fomento_nome;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b>Público (Representatividade e Visibilidade Sócio-cultural):</b>
                                <?php
                                foreach ($evento->publicos as $publico) {
                                    $sql = $eventoObj->listaPublicoEvento($publico);
                                    echo $sql['publico']."; ";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"><b>Sinopse:</b> <?= $evento->sinopse ?></div>
                        </div>
                        <?php
                        foreach ($atracaoObj->listaAtracoes($idEvento) as $atracao): ?>
                            <div class="row">
                                <div class="col-md-12"><b>Ficha técnica completa:</b> <?= $atracao->ficha_tecnica ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"><b>Integrantes:</b> <?= $atracao->integrantes ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"><b>Classificação indicativa:</b> <?= $atracao->classificacao_indicativa ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"><b>Links:</b>  <?= $atracao->links ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><b>Valor:</b> R$ <?= $eventoObj->dinheiroParaBr($atracao->valor_individual) ?></div>
                            </div>

                            <?php if ($pedido->pessoa_tipo_id == 2): ?>
                                <h5><b>Líder do grupo ou artista solo</b></h5>
                                <?php
                                require_once "./controllers/LiderController.php";
                                $liderObj = new LiderController();
                                $lider = $liderObj->getLider($atracao->id);
                                ?>
                                <div class="row">
                                    <div class="col-md-6"><b> Nome:</b> <?= $lider['nome'] ?></div>
                                    <div class="col-md-6"><b>Nome Artístico:</b> <?= $lider['nome_artistico'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"><b>RG:</b> <?= $lider['rg'] ?></div>
                                    <div class="col-md-2"><b>CPF:</b> <?= $lider['cpf'] ?></div>
                                    <div class="col-md-4"><b>E-mail:</b> <?= $lider['email'] ?></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <b>Telefones:</b>
                                        <?= isset($lider['telefones']) ? implode(" | ", $lider['telefones']) : "" ?>
                                    </div>
                                    <?php if($cenica > 0): ?>
                                        <div class="col-md-6"><b>DRT:</b> <?= $lider['drt'] ?? $erro ?></div>
                                    <?php endif ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <!-- ************** Proponente ************** -->
                        <hr>
                        <h5><b>Oficineiro</b></h5>
                        <hr/>
                        <?php
                        $idEncrypt = $pedidoObj->encryption($pedido->proponente->id);
                        if ($pedido->pessoa_tipo_id == 1) {
                            /* ************** Pessoa Física ************** */
                            require_once "./controllers/PessoaFisicaController.php";
                            $pfObj = new PessoaFisicaController();
                            $pf = $pfObj->recuperaPessoaFisica($idEncrypt);
                            ?>
                            <div class="row">
                                <div class="col-md-6"><b> Nome:</b> <?= $pf['nome'] ?></div>
                                <div class="col-md-6"><b>Nome Artístico:</b> <?= $pf['nome_artistico'] ?></div>
                            </div>
                            <div class="row">
                                <?php
                                if(!empty($pf['cpf'])){
                                ?>
                                    <div class="col-md-2"><b>RG:</b> <?= $pf['rg'] ?></div>
                                    <div class="col-md-2"><b>CPF:</b> <?= $pf['cpf'] ?></div>
                                    <div class="col-md-2"><b>CCM:</b> <?= $pf['ccm'] ?></div>
                                <?php
                                }
                                else{
                                ?>
                                    <div class="col-md-6"><b>Passaporte:</b> <?= $pf['passaporte'] ?></div>
                                <?php
                                }
                                ?>
                                <div class="col-md-3"><b>Data de Nascimento:</b> <?= date("d/m/Y", strtotime($pf['data_nascimento'])) ?></div>
                                <div class="col-md-3"><b>Naconalidade:</b> <?= $pf['nacionalidade'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><b>E-mail:</b> <?= $pf['email'] ?></div>
                                <div class="col-md-6">
                                    <b>Telefones:</b>
                                    <?= isset($pf['telefones']) ? implode(" | ", $pf['telefones']) : "" ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><b>NIT:</b> <?= $pf['nit'] ?></div>
                                <?php if($cenica > 0): ?>
                                    <div class="col-md-6"><b>DRT:</b> <?= $pf['drt'] ?></div>
                                <?php endif ?>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <b>Endereço:</b> <?= $pf['logradouro'] . ", " . $pf['numero'] . " " . $pf['complemento'] . " " . $pf['bairro'] . " - " . $pf['cidade'] . "-" . $pf['uf'] . " CEP: " . $pf['cep'] ?>
                                </div>
                            </div>
                            <?php
                            if ($_SESSION['modulo_c']!=2){
                            ?>
                                <div class="row">
                                    <div class="col-md-4"><b>Banco:</b> <?= $pf['banco'] ?></div>
                                    <div class="col-md-4"><b>Agência:</b> <?= $pf['agencia'] ?></div>
                                    <div class="col-md-4"><b>Conta:</b> <?= $pf['conta'] ?></div>
                                </div>
                            <?php
                            }
                        } else {
                            /* ************** Pessoa Juíridica ************** */
                            require_once "./controllers/PessoaJuridicaController.php";
                            $pjObj = new PessoaJuridicaController();
                            $pj = $pjObj->recuperaPessoaJuridica($idEncrypt);
                            ?>
                            <div class="row">
                                <div class="col-md-7"><b>Razão Social:</b> <?= $pj['razao_social'] ?></div>
                                <div class="col-md-3"><b>CNPJ:</b> <?= $pj['cnpj'] ?></div>
                                <div class="col-md-2"><b>CCM:</b> <?= $pj['ccm'] ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><b>E-mail:</b> <?= $pj['email'] ?></div>
                                <div class="col-md-6"><b>Telefones:</b> <?= implode(" | ", $pj['telefones']); ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <b>Endereço:</b> <?= $pj['logradouro'] . ", " . $pj['numero'] . " " . $pj['complemento'] . " " . $pj['bairro'] . " - " . $pj['cidade'] . "-" . $pj['uf'] . " CEP: " . $pj['cep'] ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><b>Banco:</b> <?= $pj['banco'] ?></div>
                                <div class="col-md-4"><b>Agência:</b> <?= $pj['agencia'] ?></div>
                                <div class="col-md-4"><b>Conta:</b> <?= $pj['conta'] ?></div>
                            </div>
                            <!-- ************** Representante Legal 1 ************** -->
                            <?php
                            require_once "./controllers/RepresentanteController.php";
                            $repObj = new RepresentanteController();
                            $idRep1 = $repObj->encryption($pj['representante_legal1_id']);
                            $rep1 = $repObj->recuperaRepresentante($idRep1)->fetch();
                            ?>
                            <br/>
                            <h5><b>Representante Legal</b></h5>
                            <div class="row">
                                <div class="col-md-7"><b>Nome:</b> <?= $rep1['nome'] ?></div>
                                <div class="col-md-3"><b>RG:</b> <?= $rep1['rg'] ?></div>
                                <div class="col-md-2"><b>CFP:</b> <?= $rep1['cpf'] ?></div>
                            </div>
                            <!-- ************** Representante Legal 2 ************** -->
                            <?php
                            if(!empty($pj['representante_legal2_id'])){
                                $idRep2 = $repObj->encryption($pj['representante_legal2_id']);
                                $rep2 = $repObj->recuperaRepresentante($idRep2)->fetch();
                            ?>
                                <div class="row">
                                    <div class="col-md-7"><b>Nome:</b> <?= $rep2['nome'] ?></div>
                                    <div class="col-md-3"><b>RG:</b> <?= $rep2['rg'] ?></div>
                                    <div class="col-md-2"><b>CPF:</b> <?= $rep2['cpf'] ?></div>
                                </div>
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="card-footer">
                        <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/eventoAjax.php" role="form" data-form="update">
                            <input type="hidden" name="_method" value="envioEvento">
                            <input type="hidden" name="modulo" value="<?=$modulo?>">
                            <input type="hidden" name="id" value="<?=$idEvento?>">
                            <button type="submit" class="btn btn-success btn-block float-right" id="cadastra">Enviar</button>
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

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#itens-proponente').addClass('menu-open');
        $('#finalizar').addClass('active');

        if ($('.erro-validacao').length) {
            $('#cadastra').attr('disabled', true);
        } else {
            $('#cadastra').attr('disabled', false);
        }
    });
</script>