<?php
$con = bancoMysqli();

$idReserva = $_GET['idReserva'];
$reserva = recuperaDados("reserva", "idReserva", $idReserva);

if(isset($_POST['alteraReserva'])){
    $idP = $_POST['IDP'];
    $idReserva = $_POST['IDR'];
    $data = exibirDataMysql($_POST['data']);
    $valor = dinheiroDeBr($_POST['valor']);
    $numeroReserva = $_POST['numeroReserva'];
    
    $sql = "UPDATE reserva SET data = '$data', valor = '$valor', numeroReserva = '$numeroReserva' WHERE idReserva = '$idReserva' ";
    
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
            <?php include 'includes/menu_smc.php';?>
            <div class="form-group">
                <h4>Edição de Reserva</h4>
                <p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
            </div>
            <div class="row">

                <div class="col-md-offset-1 col-md-10">
                    <form method="POST" action="?perfil=edicao_reserva&idReserva=<?=$idReserva?>" class="form-horizontal" role="form">

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-2">
                                <label>Data</label>
                                <input type="text" id="datepicker01" name="data" class="form-control" maxlength="100" value="<?php echo exibirDataBr($reserva['data']) ?>">
                            </div>

                            <div class="col-md-3">
                                <label>Valor</label>
                                <input type="text" id='valor' name="valor" class="form-control" value="<?php echo dinheiroParaBr($reserva['valor']) ?>" required>
                            </div>

                            <div class="col-md-3">
                                <label>Número da Reserva</label>
                                <input type="text" id="numeroReserva" name="numeroReserva" class="form-control" value="<?php echo $reserva['numeroReserva'] ?>" required>
                            </div>
                        </div>
                        <input type="hidden" name="IDR" value="<?php echo $reserva['idReserva'] ?>">
                        <input type="hidden" name="IDP" value="<?php echo $reserva['idProjeto'] ?>">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="submit" name="alteraReserva" class="btn btn-theme btn-lg btn-block" value="Gravar">
                            </div>
                        </div>
                    </form>
                    <div class="col-md-offset-2 col-md-8" style="margin-top: 5px">
                        <form method="POST" action="?perfil=smc_detalhes_projeto&idFF=<?=$reserva['idProjeto']?>">
                            <input type ='submit' class='btn btn-theme btn-block' value='cancelar'>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
