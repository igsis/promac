<?php
$con = bancoMysqli();

$idDeposito = $_GET['idDeposito'];

$deposito = recuperaDados("deposito","idDeposito",$idDeposito);

if(isset($_POST['inserirLiquidacao'])){
    $idDeposito = $_POST['idDeposito'];
    $data = exibirDataMysql($_POST['data']);
    $valor = dinheiroDeBr($_POST['valor']);
    $numeroLiquidacao = $_POST['numeroLiquidacao'];
    $numeroSei = $_POST['numeroSei'];

    
    $sql = "INSERT INTO liquidacao (idDeposito, data, valor, numeroLiquidacao,numeroSei) values ('$idDeposito', '$data', '$valor', '$numeroLiquidacao', '$numeroSei')";
    
    if(mysqli_query($con,$sql)){
        $mensagem = "<font color='#01DF3A'><strong>Liquidação cadastrada com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=liquidacao&idDeposito=$idDeposito';</script>";
        gravarLog($sql);
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
                <h4>Inserir Liquidação</h4>
            </div>

            <div class="col-md-offset-1 col-md-10">
                <div class="table-responsive list_info">
                    <form method="POST" action="?perfil=cadastro_liquidacao&idDeposito=<?=$idDeposito?>" class="form-horizontal" role="form">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-4">
                                <label>Data</label>
                                <input type="text" name="data" id='datepicker01' class="form-control" placeholder="DD/MM/AA ou MM/AAAA" required>
                            </div>
                            <div class="col-md-4">
                                <label>Valor</label>
                                <input type="text" id='valor' name="valor" class="form-control" required>
                            </div>
                        </div>    

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-4">                                
                                <label>Número da Liquidação</label>
                                <input type="text" name="numeroLiquidacao" class="form-control">
                            </div>
                            <div class="col-md-4">                                
                                <label>Nº Processo SEI</label>
                                <input type="text" name="numeroSei" class="form-control">
                            </div>
                        </div>

                        <?php echo "<input type='hidden' name='idDeposito' value='$idDeposito'>";?>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="submit" name="inserirLiquidacao" class="btn btn-theme btn-md btn-block" value="Gravar">
                            </div>
                        </div>
                    </form>
                    <div class="col-md-offset-2 col-md-8" style="margin-top: 5px">
                        <form method="POST" action="?perfil=liquidacao&idDeposito=<?=$idDeposito?>">
                            <input type='submit' class='btn btn-theme btn-block' value='cancelar'>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
