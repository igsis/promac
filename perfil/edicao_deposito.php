<?php
$con = bancoMysqli();

$idDeposito = $_GET['idDeposito'];
$deposito = recuperaDados("deposito", "idDeposito", $idDeposito);

if(isset($_POST['alteraDeposito'])){
    $idReserva = $_POST['idReserva'];
    $tipoPessoa = $_POST['tipoPessoa'];
    $idIncentivador = $_POST['idIncentivador'];
    $data = exibirDataMysql($_POST['data']);
    $valorDeposito = dinheiroDeBr($_POST['valorDeposito']);
    $valorRenuncia = dinheiroDeBr($_POST['valorRenuncia']);
    $porcentagemValorRenuncia = $_POST['porcentagemValorRenuncia'];
    
    $sql = "UPDATE deposito SET tipoPessoa = '$tipoPessoa',  idIncentivador = '$idIncentivador, data = '$data', valorDeposito = '$valorDeposito',  valorRenuncia = '$valorRenuncia', porcentagemValorRenuncia = '$porcentagemValorRenuncia' WHERE idDeposito = '$idDeposito' ";
    
    if(mysqli_query($con,$sql)){
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
        gravarLog($sql);
    }else{
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
}

?>
    <section id="list_items" class="home-section bg-white">
        <div class="container">
            <div class="form-group">
                <h4>Edição de Reserva</h4>
                <p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
            </div>
            <div class="row">

                <div class="col-md-offset-1 col-md-10">
                    <form method="POST" action="?perfil=edicao_deposito&idDeposito=<?=$idDeposito?>" class="form-horizontal" role="form">

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-2">
                                <label>Data</label>
                                <input type="text" id="datepicker01" name="data" class="form-control" maxlength="100" value="<?php echo exibirDataBr($deposito['data']) ?>">
                            </div>

                            <div class="col-md-3">
                                <label>Valor do Depósito</label>
                                <input type="text" id='valor' name="valorDeposito" class="form-control" value="<?php echo $deposito['valorDeposito'] ?>" required>
                            </div>

                            <div class="col-md-3">
                                <label>Valor da Renúncia</label>
                                <input type="text" id='valor' name="valorRenuncia" class="form-control" value="<?php echo $deposito['valorRenuncia'] ?>" required>
                            </div>

                            <div class="col-md-3">
                                <label>Porcentagem Renúncia</label>
                                <input type="text" name="porcentagemValorRenuncia" class="form-control" value="<?php echo $deposito['porcentagemValorRenuncia'] ?>" required>
                            </div>
                        </div>
                        <input type="hidden" name="IDD" value="<?php echo $reserva['idDeposito'] ?>">
                        <input type="hidden" name="IDR" value="<?php echo $reserva['idReserva'] ?>">
                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-10">
                                <input type="submit" name="alteraDeposito" class="btn btn-theme btn-lg btn-block" value="Gravar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
