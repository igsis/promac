<?php
$con = bancoMysqli();

$idDeposito = $_GET['idDeposito'];

$deposito = recuperaDados("deposito", "idDeposito", $idDeposito);
$reserva = recuperaDados("reserva", "idReserva", $deposito['idReserva']);


?>
    <section id="list_items" class="home-section bg-white">
        <div class="container">
            <?php include 'includes/menu_smc.php';?>
            <div class="form-group">
                <h4>Liquidações</h4>
                <h5>
                    <?php if(isset($mensagem)){echo $mensagem;}; ?>
                </h5>
            </div>
            <div class="row">


                <?php
                  $sql = "SELECT * FROM liquidacao WHERE idDeposito = '$idDeposito'";
                  $query = mysqli_query($con, $sql);
                  $num = mysqli_num_rows($query);
                  if($num > 0) { ?>
                    <div class="table-responsive list_info">
                        <table class='table table-condensed'>
                            <thead>
                                <tr class='list_menu'>
                                    <td>Data</td>
                                    <td>Valor</td>
                                    <td>Número da Liquidação</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($liquidacao = mysqli_fetch_array($query)) { ?>
                                <tr>
                                    <td>
                                        <?php echo exibirDataBr($liquidacao['data']); ?>
                                    </td>
                                    <td>
                                        <?php echo dinheiroParabr($liquidacao['valor']); ?>
                                    </td>
                                    <td>
                                        <?php echo $liquidacao['numeroLiquidacao']; ?>
                                    </td>
                                    <td class='list_description'>
                                        <form method="POST" action="?perfil=edicao_liquidacao&idLiquidacao=<?=$liquidacao['idLiquidacao'] ?>">
                                            <input type='hidden' name='' value='".$campo[' ']."' />
                                            <input type='submit' class='btn btn-theme btn-block' value='editar'>
                                        </form>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                  }
                  else {?>

                        <div class="col-md-offset-1 col-md-10">
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <form class="form-horizontal" role="form" action="?perfil=cadastro_liquidacao&idDeposito=<?=$idDeposito?>" method="post">
                                        <input type="submit" value="Inserir liquidação" class="btn btn-theme btn-lg btn-block">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <p>&nbsp</p>
                        <p>&nbsp</p>
                        <h4>Não existem liquidações cadastradas!</h4>
                        <?php } ?>

                        <div class="col-md-offset-1 col-md-10">
                            <form method="POST" action="?perfil=deposito&idReserva=<?=$reserva['idReserva']?>&idProjeto=<?=$reserva['idProjeto']?>">
                                <input type='submit' class='btn btn-theme btn-block' value='voltar'>
                            </form>
                        </div>
            </div>
        </div>
    </section>
