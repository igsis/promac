<?php
$con = bancoMysqli();

$idDeposito = $_GET['idDeposito'];
$liquidacao = recuperaDados("liquidacao", "idLiquidacao", $idLiquidacao);

if(isset($_POST['alteraLiquidacao'])){
    $idLiquidacao = $_POST['IDL'];
    $idDeposito = $_POST['IDD'];
    $data = exibirDataMysql(['data']);
    $valor = $_POST['valor'];
    $numeroLiquidacao = $_POST['numeroLiquidacao'];
    
    $sql = "UPDATE liquidacao SET data = '$data', valor = '$valor', numeroLiquidacao = '$numeroLiquidacao' WHERE idLiquidacao = '$idLiquidacao' ";
    
    if(mysqli_query($con,$sql)){
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=liquidacao&idDeposito=$idDeposito';</script>";
        gravarLog($sql);
    }else{
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
}

?>
    <section id="list_items" class="home-section bg-white">
        <div class="container">
            <div class="form-group">
                <h4>Edição de Liquidação/h4>
                <p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <form method="POST" action="?perfil=edicao_liquidacao&idLiquidacao=<?=$idLiquidacao?>" class="form-horizontal" role="form">

                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-3">
                                <label><br/>Data</label><br/>
                                <input type="text" id='datepicker01' name="data" class="form-control" maxlength="100" value="<?php echo $liquidacao['data'] ?>">
                            </div>

                            <div class="col-md-1"><label>Valor</label><br/>
                                <input type="text" id='valor' name="valor" class="form-control" value="<?php echo $liquidacao['valor'] ?>" required>
                            </div>

                            <div class="col-md-1"><label>Número da Liquidação</label><br/>
                                <input type="text" name="numeroLiquidacao" class="form-control" value="<?php echo $liquidacao['numeroLiquidacao'] ?>" required>
                            </div>
                        </div>
                        <input type="hidden" name="IDL" value="<?php echo $empenho['idLiquidacao'] ?>">
                        <input type="hidden" name="IDD" value="<?php echo $empenho['idDeposito'] ?>">
                        
                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-10">
                                <input type="submit" name="alteraLiquidacao" class="btn btn-theme btn-lg btn-block" value="Gravar">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
