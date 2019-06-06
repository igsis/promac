<?php
$con = bancoMysqli();
$idIncentivador = $_SESSION['idUser'];

$buscaProjeto = isset($_POST['procurar']) ? 1 : 0;
$displayForm = 'block';
$displayBotao = 'none';

$pf = recuperaDados("incentivador_pessoa_fisica", "idPf", $idPf);
$etapaArray = recuperaDados("etapas_incentivo", "idIncentivador", $idPf);

$liberado = $pf['liberado'];
$etapa = $etapaArray['etapa'];

if(isset($_POST['incentivar_projeto'])) {
    $idProjeto = $_POST['idProjeto'];
    $tipoPessoa = $_POST['tipoPessoa'];

    $sqlEtapa = "UPDATE etapas_incentivo SET idProjeto = '$idProjeto', etapa = 5 WHERE tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador'";




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
            <form method="POST" action="?perfil=includes/incentivador_etapa4_buscarProjeto" enctype="multipart/form-data">
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
            </form>
            <br>
            <?php
            while ($linha = mysqli_fetch_array($query)) {

                ?>
                <div class="well">
                    <h4><strong>Projeto “<?= $linha['nomeProjeto'] ?>”</strong></></h4>
                    <p align="justify"><strong>Valor Aprovado para Captação:</strong> <?= dinheiroParaBr($linha['valorAprovado']) ?>
                    <p>
                    <p align="justify"><strong>Percentual de renúncia
                            <i id="info" class="glyphicon glyphicon-info-sign" data-toggle="tooltip easyTooltip"
                               title="O percentual de renúncia significa o quanto do dinheiro aportado poderá ser abatido como pagamento de imposto."></i>:
                        </strong></p>

                    <p align="justify"><strong>Exposicao da
                            marca: </strong><?= $linha['exposicao_marca'] != 0 ? $linha['exposicao_marca'] : "Nao especificado" ?>
                    <p>
                    <p align="justify"><strong>Conta Captação:</strong> <?= $linha['contaCaptacao']; ?><p>
                    <p align="justify"><strong>Conta Movimento:</strong> <?= $linha['contaMovimentacao']; ?><p>
                        <?php
                        if ($linha['contaCaptacao'] == '' || $linha['contaMovimentacao'] == '') {
                            ?>
                            <font color='#FF0000'><strong>O proponente do projeto que você deseja incentivar ainda
                                    não inseriu as contas do projeto no sistema.
                                    Aguarde a inserção dos dados no sistema para prosseguir com o processo de
                                    incentivo. Se desejar agilizar
                                    o processo, entre em contato diretamente com o proponente.</strong></font>



                            <?php
                        } else {
                            echo "<form method='post' action='?perfil=includes/incentivador_etapa5_incentivarProjeto' class='form-group'>
                                        <input type='hidden' name='idProjeto' value='". $linha['idProjeto'] . "'>
                                        <input type='submit' name='incentivar_projeto' value='Incentivar esse projeto' class='btn btn-success'>
                                    </form>";

                        }
                        ?>
                </div>
                <?php
            }
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