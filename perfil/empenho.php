<?php
$con = bancoMysqli();
$idReserva = $_GET['idReserva'];

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
                                                <?php echo $empenho['valor']; ?>
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
                                            <td class='list_description'>
                                                <form method='POST' action='?perfil='>
                                                    <input type='hidden' name='' value='".$campo[' ']."' />
                                                    <input type='submit' class='btn btn-theme btn-block' value='reservas'>
                                                </form>
                                            </td>
                                        </tr>
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
