<?php
$con = bancoMysqli();

$idEmpenho = $_GET['idEmpenho'];
$empenho = recuperaDados("empenho", "idEmpenho", $idEmpenho);

if(isset($_POST['alteraEmpenho'])){
    $idEmpenho = $_POST['IDE'];
    $idReserva = $_POST['IDR'];
    $data = exibirDataMysql($_POST['data']);
    $valor = dinheiroDeBr($_POST['valor']);
    $numeroEmpenho = $_POST['numeroEmpenho'];
    
    $sql = "UPDATE empenho SET data = '$data', valor = '$valor', numeroEmpenho = '$numeroEmpenho' WHERE idEmpenho = '$idEmpenho' ";
    
    if(mysqli_query($con,$sql)){
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=empenho&idReserva=$idReserva';</script>";
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
                <h4>Edição de Empenho</h4>
                <p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <form method="POST" action="?perfil=edicao_empenho&idEmpenho=<?=$idEmpenho?>" class="form-horizontal" role="form">

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-2">
                                <label>Data</label>
                                <input type="text" id='datepicker01' name="data" class="form-control" maxlength="100" value="<?php echo exibirDataBr($empenho['data']) ?>">
                            </div>

                            <div class="col-md-3"><label>Valor</label>
                                <input type="text" id='valor' name="valor" class="form-control" value="<?php echo dinheiroParaBr($empenho['valor']) ?>" required>
                            </div>

                            <div class="col-md-3"><label>Número do Empenho</label>
                                <input type="text" name="numeroEmpenho" class="form-control" value="<?php echo $empenho['numeroEmpenho'] ?>" required>
                            </div>
                        </div>
                        <input type="hidden" name="IDE" value="<?php echo $empenho['idEmpenho'] ?>">
                        <input type="hidden" name="IDR" value="<?php echo $empenho['idReserva'] ?>">

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="submit" name="alteraEmpenho" class="btn btn-theme btn-lg btn-block" value="Gravar">
                            </div>
                        </div>
                    </form>
                    <div class="col-md-offset-2 col-md-8" style="margin-top: 5px">
                        <form method="POST" action="?perfil=empenho&idReserva=<?=$empenho['idReserva']?>">
                            <input type ='submit' class='btn btn-theme btn-block' value='cancelar'>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
