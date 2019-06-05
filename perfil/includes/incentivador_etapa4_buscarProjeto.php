<?php
$con = bancoMysqli();
$idPf = $_SESSION['idUser'];
$tipoPessoa = 3;

$buscaProjeto = isset($_POST['procurar']) ? 1 : 0;
$displayForm = 'block';
$displayBotao = 'none';

$pf = recuperaDados("incentivador_pessoa_fisica", "idPf", $idPf);
$etapaArray = recuperaDados("etapas_incentivo", "idIncentivador", $idPf);

$liberado = $pf['liberado'];
$etapa = $etapaArray['etapa'];

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

    $sqlBusca = "SELECT * FROM projeto LEFT JOIN exposicao_marca as marca ON marca.id = projeto.idExposicaoMarca WHERE nomeProjeto like '%$projeto%'";

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
            <div class="row">
                <div class="col-md-offset-4 col-md-6">
                    <div class="input-group">
                        <input type="text" name="projeto" class="form-control"
                               placeholder="Pesquisa realizada: <?=$projeto ?>">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default" name="procurar" style="font-size: 20px"><span class="glyphicon glyphicon-search"></span></button>
                        </div>
                    </div><!-- /input-group -->
                </div>
            </div>
            <br>
            <div class="table-responsive list_info" id="tabelaEventos">
                <table class='table table-condensed table-striped'>
                    <thead>
                    <tr class='list_menu'>
                        <td>Projeto</td>
                        <td>Percentual de renúncia &nbsp;&nbsp;<i id="info" class="glyphicon glyphicon-info-sign" data-toggle="tooltip easyTooltip" title="O percentual de renúncia significa o quanto do dinheiro aportado poderá ser abatido como pagamento de imposto."></i></td>
                        <td>Valor Aprovado</td>
                        <td>Exposicao da marca</td>
                        <td>Conta Captação</td>
                        <td>Conta Movimento</td>
                    </tr>
                    </thead>
                    <?php
                    while ($linha = mysqli_fetch_array($query)) {

                        ?>
                        <tr>
                            <td class="list_description"><?= $linha['nomeProjeto']?></td>
                            <td class="list_description"></td>
                            <td class="list_description"><?= dinheiroParaBr($linha['valorAprovado']) ?></td>
                            <td class="list_description"><?= $linha['exposicao_marca'] != 0 ? $linha['exposicao_marca']  : "Nao especificado"?></td>
                            <td class="list_description"><?= $linha['contaCaptacao']?></td>
                            <td class="list_description"><?= $linha['contaCaptacao']?></td>
                            <td class="list_description"><?= $linha['contaMovimentacao']?></td>
                        </tr>
                        <?php
                        if ($linha['contaCaptacao'] == '' || $linha['contaMovimentacao'] == '') {
                            ?>

                            <tr class="list-menu">
                                <td></td>
                                <td></td>
                                <td><small><i color='#FF0000'><strong>O proponente do projeto que você deseja incentivar ainda não inseriu as contas do projeto no sistema.
                                                Aguarde a inserção dos dados no sistema para prosseguir com o processo de incentivo. Se desejar agilizar
                                                o processo, entre em contato diretamente com o proponente.</strong></i></small></td>
                                <td></td>
                                <td></td>
                            </tr>


                    <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
        ?>
    </div>
</section>


<script>
    function mostraDiv() {
        let form = document.querySelector('#testeTana');
        form.style.display = 'block';

        let botoes = document.querySelector('#botoes');
        botoes.style.display = 'none';

        let resultado = document.querySelector('#resultado');
        resultado.style.display = 'none';
    }
</script>