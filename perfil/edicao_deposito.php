<?php
$con = bancoMysqli();

$idDeposito = $_GET['idDeposito'];
$idProjeto = $_GET['idProjeto'];

if(isset($_POST['idIncentivador'])){
    $idIncentivador = $_POST['idIncentivador'];
}

if(isset($_POST['nome'])){
    $nmIncentivador = $_POST['nome'];
}

if(isset($_POST['tipoPessoa'])){
    $tipoPessoa = $_POST['tipoPessoa'];    
}

if(isset($_POST['idReserva'])){
    $idReserva = $_POST['idReserva'];
}

$deposito = recuperaDados("deposito","idDeposito", $idDeposito);
$financeiro = recuperaDados("financeiro", "idProjeto", $idProjeto);


if(isset($_POST['alteraDeposito'])){
    $idDeposito = $_POST['idDeposito'];
    $idReserva = $_POST['idReserva'];
    $valores = explode('|', $_POST['incentivador']);
    $idIncentivador = $valores[0];
    $tipoPessoa = $valores[1];
    
    $data = exibirDataMysql($_POST['data']);
    $valorDeposito = dinheiroDeBr($_POST['valorDeposito']);
    $valorRenuncia = dinheiroDeBr($_POST['valorRenuncia']);
    $porcentagemValorRenuncia = $_POST['porcentagemValorRenuncia'];
    
    $sql = "UPDATE deposito SET idIncentivador = '$idIncentivador', tipoPessoa = '$tipoPessoa', data = '$data', valorDeposito = '$valorDeposito', valorRenuncia = '$valorRenuncia', porcentagemValorRenuncia = '$porcentagemValorRenuncia' WHERE idDeposito = '$idDeposito' ";
    
    if(mysqli_query($con,$sql)){
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=deposito&idReserva=$idReserva&idProjeto=$idProjeto';</script>";
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
                    <form method="POST" action="?perfil=edicao_deposito&idDeposito=<?=$idDeposito?>&idProjeto=<?=$idProjeto?>" class="form-horizontal" role="form">

                        <div class="form-group">

                            <div class="col-md-offset-2 col-md-8">
                                <label>Incentivadores</label>
                                <select name="incentivador">
                                <option value="<?php echo $idIncentivador;?>|<?php echo $tipoPessoa;?>" select="disable" selected hidden><?php echo $nmIncentivador ; ?></option>
                                <?php
                                        $sql_busca_incentivador = "SELECT * FROM financeiro f INNER JOIN incentivador_pessoa_fisica pf ON f.idIncentivador = pf.idPf WHERE f.idProjeto = '$idProjeto' AND f.tipoPessoa = 4";
                                        $query_busca_incentivador = mysqli_query($con, $sql_busca_incentivador);
                                    
                                        while($dados = mysqli_fetch_array($query_busca_incentivador)){ 
                                    ?>
                                            <option value="<?php echo $dados['idIncentivador'];?>|4"><?php echo $dados['nome'] ?></option>
                                            
                                <?php
                                            
                                        }
                          
                                        $sql_busca_incentivador = "SELECT * FROM financeiro f INNER JOIN incentivador_pessoa_juridica pj ON f.idIncentivador = pj.idPj WHERE f.idProjeto = '$idProjeto' AND f.tipoPessoa = 5";
                                        $query_busca_incentivador = mysqli_query($con, $sql_busca_incentivador);
                                    
                                        while($dados = mysqli_fetch_array($query_busca_incentivador)){ 
                                ?>
                                            <option value="<?php echo $dados['idIncentivador'];?>|5"><?php echo $dados['razaoSocial'] ?></option>
                                <?php 
                                        } 
                                ?>
                                
                                </select>
                            </div>
                            
                            <div class="col-md-offset-2 col-md-4">
                                <label>Data</label>
                                <input type="text" id="datepicker01" name="data" class="form-control" maxlength="100" value="<?php echo exibirDataBr($deposito['data']) ?>">
                            </div>

                            <div class="col-md-4">
                                <label>Valor do Depósito</label>
                                <input type="text" id='valor' name="valorDeposito" class="form-control" value="<?php echo dinheiroParaBr($deposito['valorDeposito']); ?>" required>
                            </div>

                            <div class="col-md-offset-3 col-md-3">
                                <label>Valor da Renúncia</label>
                                <input type="text" id='valor' name="valorRenuncia" class="form-control" value="<?php echo dinheiroParaBr($deposito['valorRenuncia']); ?>" required>
                            </div>

                            <div class="col-md-3">
                                <label>Porcentagem Renúncia</label>
                                <input type="text" name="porcentagemValorRenuncia" class="form-control" value="<?php echo $deposito['porcentagemValorRenuncia'] ?>" required>
                            </div>
                        </div>
                        <?php echo "<input type='hidden' name='idDeposito' value='$idDeposito'>";?>
                        <?php echo "<input type='hidden' name='idReserva' value='$idReserva'>";?>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="submit" name="alteraDeposito" class="btn btn-theme btn-md btn-block" value="Gravar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
