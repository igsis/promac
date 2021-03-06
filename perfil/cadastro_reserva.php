<?php
$con = bancoMysqli();

$idProjeto = $_GET['idProjeto'];

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);

if(isset($_POST['inserirReserva'])){
    $idP = $_POST['IDP'];
    $data = exibirDataMysql($_POST['data']);
    $valor = dinheiroDeBr($_POST['valor']);
    $numeroReserva = $_POST['numeroReserva'];
    
    $sql = "INSERT INTO reserva (idProjeto, data, valor, numeroReserva) values ('$idP', '$data', '$valor', '$numeroReserva')";
    
    if(mysqli_query($con,$sql)){
        $mensagem = "<font color='#01DF3A'><strong>Reserva cadastrada com sucesso!</strong></font>";
        gravarLog($sql);
        echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
    }else{
        $mensagem = "<font color='#FF0000'><strong>Erro ao cadastrar!
        </strong></font>";
    }
}

?>
    <section class="home-section bg-white">
        <div class="container">
            <?php include 'includes/menu_smc.php';?>
            <div class="form-group">
                <h4>Inserir Reserva</h4>
            </div>

            <div class="col-md-offset-1 col-md-10">
                <div class="table-responsive list_info">
                    <form method="POST" , action="?perfil=cadastro_reserva&idProjeto=<?=$idProjeto?>" class="form-horizontal" role="form">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-2">
                                <label>Data </label>
                                <input type="text" name="data" id='datepicker01' class="form-control" placeholder="DD/MM/AA ou MM/AAAA" required>
                            </div>

                            <div class="col-md-3">
                                <label>Valor </label>
                                <input type="text" id='valor' name="valor" class="form-control" required>
                            </div>

                            <div class="col-md-3">
                                <label>Número da Reserva</label>
                                <input type="text" name="numeroReserva" class="form-control" required>
                            </div>
                        </div>
                        <?php echo "<input type='hidden' name='IDP' value='$idProjeto'>";?>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="submit" name="inserirReserva" class="btn btn-theme btn-md btn-block" value="Gravar">
                            </div>
                        </div>
                    </form>
                    <div class="col-md-offset-2 col-md-8" style="margin-top: 5px">
                        <form method="POST" action="?perfil=smc_detalhes_projeto&idFF=<?=$idProjeto?>">
                            <input type='submit' class='btn btn-theme btn-block' value='cancelar'>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
