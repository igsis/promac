<?php
$con = bancoMysqli();
$idReserva = $_GET['idReserva'];
$idProjeto = $_GET['idProjeto'];

$reserva = recuperaDados("reserva", "idReserva", $idReserva);


$porcentagemTotal = 0;
?>
    <section id="list_items" class="home-section bg-white">
        <div class="container">
            <?php include 'includes/menu_smc.php'; ?>
            <div class="form-group">
                <h4>Depósitos</h4>
                <h5>
                    <?php if (isset($mensagem)) {
                    echo $mensagem;
                }; ?>
                </h5>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <form class="form-horizontal" role="form" action="?perfil=cadastro_deposito&idReserva=<?= $idReserva ?>&idProjeto=<?= $idProjeto ?>" method="POST">
                                <input type="submit" value="Inserir novo depósito" class="btn btn-theme btn-lg btn-block">
                            </form>
                        </div>
                    </div>
                </div>

                <!--Botao Modal-->

                <div class="col-md-offset-1 col-md-10">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <button class='btn btn-theme btn-lg btn-block' data-toggle='modal' data-target='#modal_reserva'>
                            Detalhes da reserva
                        </button>
                        </div>
                    </div>
                </div>

                <!--MODAL-->

                <div class="modal fade" id="modal_reserva" role="dialog" aria-labelledby="proponenteLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Detalhes da reserva</h4>
                            </div>
                            <div class="modal-body">
                                <p>
                                    <label>Data: <?php echo exibirDataBr($reserva['data']); ?></label>
                                </p>

                                <p>
                                    <label>Valor da Reserva: R$ <?php echo dinheiroParaBr($reserva['valor']); ?></label>
                                </p>

                                <p>
                                    <label>Número da Reserva: <?php echo $reserva['numeroReserva']; ?></label>
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8"><br></div>
                </div>
                <div class="col-md-offset-1 col-md-10">
                    <div class="table-responsive list_info">
                        <?php
                    $sql = "SELECT * FROM deposito WHERE idReserva = '$idReserva'";
                    $query = mysqli_query($con, $sql);
                    $num = mysqli_num_rows($query);
                    if ($num > 0) { ?>
                            <div class="table-responsive list_info">
                                <table class='table table-condensed'>
                                    <thead>
                                        <tr class='list_menu'>
                                            <td>Documento</td>
                                            <td>Incentivador</td>
                                            <td>Data</td>
                                            <td>Valor do Depósito</td>
                                            <td>Valor da Renúncia</td>
                                            <td>Porcentagem Renúncia</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!--INCENTIVADOR PESSOA FISICA-->
                                        <?php
                                $sql = "SELECT * FROM deposito d INNER JOIN incentivador_pessoa_fisica pf ON d.idIncentivador = pf.idPf WHERE d.idReserva = '$idReserva' AND d.tipoPessoa = 4";
                                $query = mysqli_query($con, $sql);
                                while ($deposito = mysqli_fetch_array($query)) {
                                    $porcentagemTotal += $deposito['porcentagemValorRenuncia'];?>
                                            <tr>
                                                <td>
                                                    <?php echo $deposito['cpf']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $deposito['nome']; ?>
                                                </td>
                                                <td>
                                                    <?php echo exibirDataBr($deposito['data']); ?>
                                                </td>
                                                <td>
                                                    <?php echo dinheiroParaBr($deposito['valorDeposito']); ?>
                                                </td>
                                                <td>
                                                    <?php echo dinheiroParaBr($deposito['valorRenuncia']); ?>
                                                </td>
                                                <td>
                                                    <?php echo $deposito['porcentagemValorRenuncia']; ?>%</td>
                                                <td class='list_description'>
                                                    <form method='POST' action="?perfil=edicao_deposito&idDeposito=<?= $deposito['idDeposito'] ?>&idProjeto=<?= $idProjeto ?>">
                                                        <input type='hidden' name='' value='".$campo[' ']."' />
                                                        <input type="hidden" name="idIncentivador" value="<?php echo $deposito['idIncentivador']; ?>">
                                                        <input type="hidden" name="nome" value="<?php echo $deposito['nome']; ?>">
                                                        <input type="hidden" name="tipoPessoa" value="<?php echo $deposito['tipoPessoa']; ?>">
                                                        <input type="hidden" name="idReserva" value="<?php echo $deposito['idReserva']; ?>">
                                                        <input type='submit' class='btn btn-theme btn-block' value='editar'>
                                                    </form>
                                                </td>
                                                <td class='list_description'>
                                                    <form method="POST" action="?perfil=liquidacao&idDeposito=<?=$deposito['idDeposito']?>">
                                                        <input type='hidden' name='' value='".$campo[' ']."' />
                                                        <input type='submit' class='btn btn-theme btn-block' value='Liquidação'>
                                                    </form>
                                                </td>
                                            </tr>
                                            <!--INCENTIVADOR PESSOA JURIDICA-->
                                            <?php }
                                $sql = "SELECT * FROM deposito d INNER JOIN incentivador_pessoa_juridica pj ON d.idIncentivador = pj.idPj WHERE d.idReserva = '$idReserva' AND d.tipoPessoa = 5";
                                $query = mysqli_query($con, $sql);
                                while ($deposito = mysqli_fetch_array($query)) {
                                    $porcentagemTotal += $deposito['porcentagemValorRenuncia'];
                                    ?>
                                            <tr>
                                                <td>
                                                    <?php echo $deposito['cnpj']; ?>
                                                </td>
                                                <td>
                                                    <?php echo $deposito['razaoSocial']; ?>
                                                </td>
                                                <td>
                                                    <?php echo exibirDataBr($deposito['data']); ?>
                                                </td>
                                                <td>
                                                    <?php echo dinheiroParaBr($deposito['valorDeposito']); ?>
                                                </td>
                                                <td>
                                                    <?php echo dinheiroParaBr($deposito['valorRenuncia']); ?>
                                                </td>
                                                <td>
                                                    <?php echo $deposito['porcentagemValorRenuncia']; ?>%</td>

                                                <td class='list_description'>
                                                    <form method='POST' action="?perfil=edicao_deposito&idDeposito=<?= $deposito['idDeposito'] ?>&idProjeto=<?= $idProjeto ?>">
                                                        <input type='hidden' name='' value='".$campo[' ']."' />
                                                        <input type="hidden" name="idIncentivador" value="<?php echo $deposito['idIncentivador']; ?>">
                                                        <input type="hidden" name="nome" value="<?php echo $deposito['razaoSocial']; ?>">
                                                        <input type="hidden" name="tipoPessoa" value="<?php echo $deposito['tipoPessoa']; ?>">
                                                        <input type="hidden" name="idReserva" value="<?php echo $deposito['idReserva']; ?>">
                                                        <input type='submit' class='btn btn-theme btn-block' value='editar'>
                                                    </form>
                                                </td>
                                                <td class='list_description'>
                                                    <form method="POST" action="?perfil=liquidacao&idDeposito=<?=$deposito['idDeposito']?>">
                                                        <input type='hidden' name='' value='".$campo[' ']."' />
                                                        <input type='submit' class='btn btn-theme btn-block' value='Liquidação'>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                    </tbody>
                                    <tr>
                                        <td colspan="5" align="right"><b>TOTAL PORCENTAGEM: </b></td>
                                        <td colspan="1" align="left">
                                            <?php
                                        if($porcentagemTotal > 35){
                                            echo "<label style='color: red'>".$porcentagemTotal."%</label>";
                                        }else{
                                            echo "<label>".$porcentagemTotal."%</label>";
                                        }
                                        ?>
                                        </td>

                                    </tr>
                                </table>
                            </div>
                            <?php
                    } else { ?>
                                <h4>Não existem depósitos cadastrados!</h4>
                                <?php } ?>
                                <div class="col-md-offset-1 col-md-10">
                                    <form method="POST" action="?perfil=smc_detalhes_projeto&idFF=<?=$idProjeto?>">
                                        <input type='submit' class='btn btn-theme btn-block' value='voltar'>
                                    </form>
                                </div>
                    </div>
                </div>

    </section>
