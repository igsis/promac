<?php
require_once "../config/configGeral.php";

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
//require_once "../views/plugins/fpdf/fpdf.php";
// ACESSO AO BANCO
$pedidoAjax = true;
require_once "../config/configAPP.php";

// CONSULTA
require_once "../controllers/EventoController.php";
$eventoObj = new EventoController();
session_start(['name' => 'cpc']);
$idEvento = $_SESSION['origem_id_c'];
$evento = $eventoObj->recuperaEvento($idEvento);

require_once "../controllers/AtracaoController.php";
$atracaoObj = new AtracaoController();
$idAtracao = $atracaoObj->getAtracaoId($idEvento);
$cenica = $atracaoObj->verificaCenica($idEvento);

require_once "../controllers/PedidoController.php";
$pedidoObj = new PedidoController();
$pedido = $pedidoObj->recuperaPedido(1);
?>

<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>CAPAC | SMC</title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= SERVERURL ?>views/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= SERVERURL ?>views/dist/css/custom.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- jQuery -->
    <script src="<?= SERVERURL ?>views/plugins/jquery/jquery.min.js"></script>
</head>
<!--<body class="hold-transition login-page">-->
<body onload="window.print()">

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-12">
                <div class="card card-default card-outline">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6"><h4 class="m-0"><b><?= $evento->nome_evento ?></b></h4></div>
                            <div class="col-md-6" align="right"><h4><b>CAPAC Nº <?= $evento->id ?></b></h4></div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12"><b>Nome do evento:</b> <?= $evento->nome_evento ?></div>
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
                        <br>
                        <!-- ************** Atrações ************** -->
                        <hr>
                        <h5><b>Atrações</b></h5>
                        <hr/>
                        <?php
                        foreach ($atracaoObj->listaAtracoes($idEvento) as $atracao): ?>
                            <div class="row">
                                <div class="col-md-12"><b>Nome da atração:</b> <?= $atracao->nome_atracao ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"><b>Ações (Expressões Artístico-culturais):</b>
                                    <?php
                                    foreach ($atracao->acoes as $acao){
                                        echo $acao->acao."; ";
                                    }
                                    ?>
                                </div>
                            </div>
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
                                <div class="col-md-12"><b>Release:</b>  <?= $atracao->release_comunicacao ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12"><b>Links:</b>  <?= $atracao->links ?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><b>Quantidade de Apresentação:</b>  <?= $atracao->quantidade_apresentacao ?></div>
                                <div class="col-md-6"><b>Valor:</b> R$ <?= $eventoObj->dinheiroParaBr($atracao->valor_individual) ?></div>
                            </div>

                            <div class="row">
                                <div class="col-md-5"><b>Produtor:</b>  <?= $atracao->produtor->nome ?? NULL?></div>
                                <div class="col-md-3"><b>Telefone:</b>  <?= $atracao->produtor->telefone1  ?? NULL?> / <?= $atracao->produtor->telefone2  ?? NULL?></div>
                                <div class="col-md-4"><b>E-mail:</b>  <?= $atracao->produtor->email ?? NULL?></div>
                            </div>
                            <div class="row">
                                <div class="col-md-4"><b>Observação:</b>  <?= $atracao->produtor->observacao ?? NULL ?></div>
                            </div>
                            <br>

                            <?php if ($pedido->pessoa_tipo_id == 2): ?>
                                <h5><b>Líder do grupo ou artista solo</b></h5>
                                <?php
                                require_once "../controllers/LiderController.php";
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
                                <br>
                                <br>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <!-- ************** Proponente ************** -->
                        <hr>
                        <h5><b>Proponente</b></h5>
                        <hr/>
                        <?php
                        $idEncrypt = $pedidoObj->encryption($pedido->proponente->id);
                        if ($pedido->pessoa_tipo_id == 1) {
                            /* ************** Pessoa Física ************** */
                            require_once "../controllers/PessoaFisicaController.php";
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
                            require_once "../controllers/PessoaJuridicaController.php";
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
                            require_once "../controllers/RepresentanteController.php";
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

                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</body>
</html>