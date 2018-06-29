<?php
$con = bancoMysqli();
$idReserva = $_GET['idReserva'];

$reserva = recuperaDados("reserva", "idReserva", $idReserva);


if(isset($_POST['insereEmpenho']))
{
    $data = exibirDataBr($_POST['data']);
    $valor = $_POST['valor'];
    $numeroEmpenho = $_POST['numeroEmpenho'];
   
    $sql_insere_empenho = "INSERT INTO `empenho`(`idReserva`, `data`, `valor`, `numeroEmpenho`) VALUES ('$idReserva', '$data', '$valor', '$numeroEmpenho')";

    if(mysqli_query($con,$sql_insere_empenho))
    {
        $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
        gravarLog($sql_insere_empenho);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['editaEmpenho']))
{
    $idEmpenho = $_POST['editaEmpenho'];
    $data = exibirDataBr($_POST['data']);
    $valor = $_POST['valor'];
    $numeroEmpenho = $_POST['numeroEmpenho'];

    $sql_edita_empenho = "UPDATE `empenho` SET
    `data`= '$data',
    `valor` = '$valor',
    `numeroEmpenho` = '$numeroEmpenho'
    WHERE idEmpenho = '$idEmpenho'";
    if(mysqli_query($con,$sql_edita_empenho))
    {
        $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
        gravarLog($sql_edita_empenho);
    }
    else
    {       
        $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
    }
}

?>
    <section id="list_items" class="home-section bg-white">
        <div class="container">
            <?php include 'includes/menu_smc.php';?>
            <div class="form-group">
                <h4>Empenhos</h4>
                <h5>
                    <?php if(isset($mensagem)){echo $mensagem;}; ?>
                </h5>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <form class="form-horizontal" role="form" action="?perfil=cadastro_empenho&idReserva=<?=$idReserva?>" method="post">
                                <input type="submit" value="Inserir novo empenho" class="btn btn-theme btn-lg btn-block">
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

            <div class="modal fade" id="modal_reserva" role="dialog" aria-labelledby="proponenteLabel"
                 aria-hidden="true">
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
                            $sql = "SELECT * FROM empenho WHERE idReserva = '$idReserva'";
                            $query = mysqli_query($con, $sql);
                            $num = mysqli_num_rows($query);
                            if($num > 0) { ?>
                            <div class="table-responsive list_info">
                                <table class='table table-condensed'>
                                    <thead>
                                        <tr class='list_menu'>
                                            <td>Data</td>
                                            <td>Valor</td>
                                            <td>Número do Empenho</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($empenho = mysqli_fetch_array($query)) {
                                            ?>
                                        <tr>
                                            <td>
                                                <?php echo exibirDataBr($empenho['data']); ?>
                                            </td>
                                            <td>
                                                <?php echo dinheiroParabr($empenho['valor']); ?>
                                            </td>
                                            <td>
                                                <?php echo $empenho['numeroEmpenho']; ?>
                                            </td>
                                            <td class='list_description'>
                                                <form method="POST" action="?perfil=edicao_empenho&idEmpenho=<?=$empenho['idEmpenho'] ?>">
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
                                <h4>Não existem empenhos cadastrados!</h4>
                                <?php } ?>
                    </div>
                </div>
    </section>
