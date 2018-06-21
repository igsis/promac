<?php
$con = bancoMysqli();
$idReserva = $_SESSION['idReserva'];

if(isset($_POST['insereDeposito']))
{
    $tipoPessoa = $_POST['tipoPessoa'];
    $idIncentivador = $_POST['idIncentivador'];
    $data = exibirDataBr($_POST['data']);
    $valorDeposito = $_POST['valorDeposito'];
    $valorRenuncia = $_POST['valorRenuncia'];
    $porcentagemValorRenuncia = $_POST['porcentagemValorRenuncia'];
   
    $sql_insere_deposito = "INSERT INTO `deposito`(`tipoPessoa`,`idIncentivador`,`idDeposito`, `data`, `valor`, `numeroLiquidacao`) VALUES ('$tipoPessoa, '$idIncentivador','$idDeposito', '$data', '$valor', '$numeroLiquidacao')";

    if(mysqli_query($con,$sql_insere_deposito))
    {
        $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
        gravarLog($sql_insere_deposito);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['editaDeposito']))
{
    $idDeposito = $_POST['editaDeposito'];
    $tipoPessoa = $_POST['tipoPessoa'];
    $idIncentivador = $_POST['idIncentivador'];
    $data = exibirDataBr($_POST['data']);
    $valorDeposito = dinheiroDeBr($_POST['valorDeposito']);
    $valorRenuncia = dinheiroDeBr($_POST['valorRenuncia']);
    $porcentagemValorRenuncia = $_POST['porcentagemValorRenuncia'];

    $sql_edita_deposito = "UPDATE `deposito` SET
    `tipoPessoa`= '$tipoPessoa',
    `idIncentivador` = '$idIncentivador',
    `data` = '$data',
    `valorDeposito` = '$valorDeposito',
    `valorRenuncia` = '$valorRenuncia',
    `porcentagemValorRenuncia` = '$porcentagemValorRenuncia'
    WHERE idDeposito = '$idDeposito'";
    if(mysqli_query($con,$sql_edita_liquidacao))
    {
        $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
        gravarLog($sql_edita_liquidacao);
    }
    else
    {       
        $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
    }
}

?>
        <section id="list_items" class="home-section bg-white">
            <div class="container"><?php include '../perfil/includes/menu_interno_pf.php'; ?>
                <div class="form-group">
                    <h4>Depósitos</h4>
                    <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <form class="form-horizontal" role="form" action="?perfil=cadastro_deposito" method="post">
                                    <input type="submit" value="Inserir novo depósito" class="btn btn-theme btn-lg btn-block">
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
                            $sql = "SELECT * FROM deposito WHERE idReserva = '$idReserva'";
                            $query = mysqli_query($con, $sql);
                            $num = mysqli_num_rows($query);
                            if($num > 0) { ?>
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
                                        <?php while ($empenho = mysqli_fetch_array($query)) {
                                            ?>
                                            <tr>
                                               <td><?php echo exibirDataBr($deposito['data']); ?></td>
                                               <td><?php echo dinheiroParaBr($deposito['valorDeposito']); ?></td>
                                               td><?php echo dinheiroParaBr($deposito['valorRenuncia']); ?></td>
                                               <td><?php echo $deposito['porcentagemValorRenuncia']; ?></td>
                                               <td class='list_description'>
                                                <form method='POST' action='?perfil='>
                                                    <input type='hidden' name='' value='".$campo['']."' />
                                                    <input type ='submit' class='btn btn-theme btn-block' value='editar'>
                                                </form>
                                                </td>
                                                 <td class='list_description'>
                                                    <form method='POST' action='?perfil='>
                                                        <input type='hidden' name='' value='".$campo['']."' />
                                                        <input type ='submit' class='btn btn-theme btn-block' value='reservas'>
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
                                <h4>Não existem depósitos cadastrados!</h4>
                            <?php } ?>
                    </div>
            </div>        
        </section>

