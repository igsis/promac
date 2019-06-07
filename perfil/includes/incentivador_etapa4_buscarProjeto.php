<?php
$con = bancoMysqli();
$idIncentivador = $_SESSION['idUser'];
$tipoPessoa = $_GET['tipoPessoa'] ?? $_POST['tipoPessoa'];

$buscaProjeto = isset($_POST['procurar']) ? 1 : 0;
$displayForm = 'block';
$displayBotao = 'none';

if ($tipoPessoa == 4)
{
    $pf = recuperaDados("incentivador_pessoa_fisica", "idPf", $idPf);
    $etapaArray = recuperaDados("etapas_incentivo", "idIncentivador", $idPf);

    $liberado = $pf['liberado'];
    $etapa = $etapaArray['etapa'];
}
elseif ($tipoPessoa == 5)
{
    $pj = recuperaDados("incentivador_pessoa_juridica", "idPj", $idPj);
    $etapaArray = recuperaDados("etapas_incentivo", "idIncentivador", $idPj);

    $liberado = $pj['liberado'];
    $etapa = $etapaArray['etapa'];
}


switch ($liberado) {
    case '4':
        $statusIncentivador = "Status da Análise de Regularidade Fiscal do Incentivador: Em análise";
        $cor_status = "warning";
        break;
    case '5':
        $statusIncentivador = "APTO - Incentivador não possui irregularidades fiscais, estando apto para incentivar projetos do PROMAC";
        $cor_status = "success";
        break;
    case '6':
        $statusIncentivador = "INAPTO - Incentivador possui irregularidades fiscais, não estando apto para incentivar projetos do <b>PROMAC</b>. <br> Regularize suas pendências para que possamos dar continuidade ao processo de incentivo fiscal";
        $cor_status = "danger";
        break;
}


if (isset($_POST['procurar'])) {
    $projeto = addslashes($_POST['projeto']);

    $sqlBusca = "SELECT * FROM projeto LEFT JOIN exposicao_marca as marca ON marca.id = projeto.idExposicaoMarca WHERE nomeProjeto like '%$projeto%' ORDER BY nomeProjeto";

    if ($query = mysqli_query($con, $sqlBusca)) {
        $linhas = mysqli_num_rows($query);
        if ($linhas > 0) {
            $buscaProjeto = 1;
            $displayBotao = 'block';
            $displayForm = 'none';
        } else {
            $mensagem = "<font color='#FF0000'><strong>Nenhum projeto encontrado com esse nome, tente novamente revisando o nome digitado!</strong></font>";
        }

    } else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao encontrar projeto, tente novamente!</strong></font>";
    }
}

?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'menu_interno_pf.php' ?>
        <ul class="nav nav-tabs">
            <li class="nav active"><a href="#admIncentivador" data-toggle="tab">Administrativo</a></li>
            <li class="nav"><a href="#resumo" data-toggle="tab">Resumo do projeto</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade" id="resumo">
                <?php
                echo "<br><div class='alert alert-warning'>
                                <strong>Aviso!</strong> Seus dados já foram aceitos, portanto, não podem ser alterados.</div>";
                include 'resumo_dados_incentivador_pf.php';
                ?>
            </div>
            <div class="tab-pane fade in active" id="admIncentivador">
                <br>
                <?php
                    if (isset($mensagem)) {
                        echo "<h5>" . $mensagem . "</h5>";
                    }
                ?>
                <ul class="list-group">
                    <li class="list-group-item list-group-item-<?= $cor_status ?>">
                        <strong><?= $statusIncentivador ?>.</strong>
                    </li>
                </ul>

                <div class="well" id="testeTana" style="display: <?=$displayForm?>">
                    <form method="POST" action="?perfil=includes/incentivador_etapa4_buscarProjeto" enctype="multipart/form-data">
                        <div class="form-group">
                            <h4><b>4 - Qual projeto você deseja incentivar? </b></h4>
                            <div class="row">
                                <div class="col-md-offset-4 col-md-6">
                                    <div class="input-group">
                                        <input type="text" name="projeto" class="form-control"
                                               placeholder="Busque aqui o nome do projeto">
                                        <input type="hidden" name="tipoPessoa" value="<?=$tipoPessoa?>">
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-default" name="procurar" style="font-size: 20px"><span class="glyphicon glyphicon-search"></span></button>
                                        </div>
                                    </div><!-- /input-group -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container" id="resultado">
        <?php
        if ($buscaProjeto == 1) {
            ?>
        <form method="POST" action="?perfil=includes/incentivador_etapa4_buscarProjeto" enctype="multipart/form-data">
            <small><b>4 - Qual projeto você deseja incentivar? </b></small>
            <div class="row">
                <div class="col-md-offset-4 col-md-6">
                    <div class="input-group">
                        <input type="text" name="projeto" class="form-control"
                               placeholder="Pesquisa realizada: <?=$projeto ?>">
                        <input type="hidden" name="tipoPessoa" value="<?=$tipoPessoa?>">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default" name="procurar" style="font-size: 20px"><span class="glyphicon glyphicon-search"></span></button>
                        </div>
                    </div><!-- /input-group -->
                </div>
            </div>
        </form>
            <br>
            <?php
            while ($linha = mysqli_fetch_array($query)) {

                ?>
                <div class="well">
                    <h4><strong>Projeto “<?=$linha['nomeProjeto'] ?>”</strong></></h4>
                    <p align="justify"><strong>Valor Aprovado para Captação:</strong> <?= dinheiroParaBr($linha['valorAprovado']) ?>
                    <p>
                    <p align="justify"><strong>Percentual de renúncia
                            <i id="info" class="glyphicon glyphicon-question-sign text-info" data-toggle="tooltip easyTooltip"
                               title="O percentual de renúncia significa o quanto do dinheiro aportado poderá ser abatido como pagamento de imposto."></i>:
                        </strong></p>

                    <p align="justify"><strong>Exposição da
                            marca: </strong><?= $linha['exposicao_marca'] != 0 ? $linha['exposicao_marca'] : "Nao especificado" ?>
                    <p>
                    <p align="justify"><strong>Conta Captação:</strong> <?= $linha['contaCaptacao']; ?><p>
                    <p align="justify"><strong>Conta Movimento:</strong> <?= $linha['contaMovimentacao']; ?><p>
                        <?php
                            if ($linha['contaCaptacao'] == '' || $linha['contaMovimentacao'] == '') {
                                ?>
                                <font color='#FF0000'><strong>O proponente desse projeto ainda
                                        não inseriu as contas do projeto no sistema.
                                        Aguarde a inserção dos dados no sistema para prosseguir com o processo de
                                        incentivo. Se desejar agilizar
                                        o processo, entre em contato diretamente com o proponente.</strong></font>



                                <?php
                            } else {
                               echo "<form method='post' action='?perfil=includes/incentivador_etapa5_incentivarProjeto' class='form-group'>
                                        <input type='hidden' name='idProjeto' value='". $linha['idProjeto'] . "'>
                                        <input type='hidden' name='tipoPessoa' value='".$tipoPessoa."'>
                                        <button class='btn btn-success' type='button' data-id='". $linha['idProjeto'] . "' data-toggle='modal' data-target='#incentivarProjeto' >Incentivar esse Projeto
								</button>
                                       <!-- <input type='submit' name='incentivar_projeto' value='Incentivar esse projeto' class='btn btn-success'> -->
                                    </form>";

                            }
                            ?>
                </div>
        <?php
            }
        }
        ?>
    </div>


    <!-- valor que deseja aportar no projeto -->
    <div class="modal fade" id="incentivarProjeto" role="dialog" aria-labelledby="incentivarProjetoLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h4 class="modal-title">5 - Quanto você deseja aportar no projeto (valor total)?</h4>
                </div>
                <form action="?perfil=includes/incentivador_etapa6_incentivarProjeto" method="post" class="form-group">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-offset-4 col-md-4">
                            <input type="hidden" name="idProjeto" id="idProjeto" value="">
                            <input type="hidden" name="tipoPessoa" id="tipoPessoa" value="<?=$tipoPessoa?>">
                            <input class="form-control" type="text" onkeypress="return(moeda(this, '.', ',', event))"  name="valor_aportado" placeholder="R$ 100.000,00">
                        </div>
                    </div>
                </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" name="incentivar_projeto">Prosseguir</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- Fim do modal -->
</section>


<script type="text/javascript">
    $('#incentivarProjeto').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).attr('data-id');

        $(this).find('#idProjeto').attr('value', id);
    })
</script>