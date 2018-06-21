<?php
$con = bancoMysqli();

$idReserva = $_GET['idReserva'];

$reserva = recuperaDados("reserva","idReserva",$idReserva);

if(isset($_POST['inserirEmpenho'])){
    $idReserva = $_POST['idReserva'];
    $data = exibirDataMysql($_POST['data']);
    $valor = dinheiroDeBr($_POST['valor']);
    $numeroEmpenho = $_POST['numeroEmpenho'];
    
    $sql = "INSERT INTO empenho (idReserva, data, valor, numeroEmpenho) values ('$idReserva', '$data', '$valor', '$numeroEmpenho')";
    
    if(mysqli_query($con,$sql)){
        $mensagem = "<font color='#01DF3A'><strong>Empenho cadastrado com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=empenho&idReserva=$idReserva';</script>";
        gravarLog($sql);
    }else{
        $mensagem = "<font color='#FF0000'><strong>Erro ao cadastrar!
        </strong></font>";
    }
}

?>
    <section class="home-section bg-white">
        <div class="container">
            <!--<?php include 'includes/menu_smc.php';?>-->
            <div class="form-group">
                <h4>Inserir Empenho</h4>
            </div>
            
            <div class="col-md-offset-1 col-md-10">
                <div class="table-responsive list_info">
                    <form method="POST" action="?perfil=cadastro_empenho&idReserva=<?=$idReserva?>" class="form-horizontal" role="form">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-2">
                                <label>Data</label>
                                <input type="text" name="data" id='datepicker01' class="form-control" placeholder="DD/MM/AA ou MM/AAAA" required>
                            </div>

                            <div class="col-md-3">
                                <label>Valor</label>
                                <input type="text" id='valor' name="valor" class="form-control" required>
                            </div>

                            <div class="col-md-3">
                                <label>Número do Empenho</label>
                                <input type="text" name="numeroEmpenho" class="form-control">
                            </div>

                            <?php echo "<input type='hidden' name='idReserva' value='$idReserva'>";?>
                            <br>
                            <br>
                            <br>
                            <input type="submit" name="inserirEmpenho" class="btn btn-theme btn-md btn-block" value="Gravar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
