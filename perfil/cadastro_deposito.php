<?php
$con = bancoMysqli();

$idReserva = $_GET['idReserva'];
$idProjeto = $_GET['idProjeto'];

$deposito = recuperaDados("deposito","idReserva", $idReserva);
$financeiro = recuperaDados("financeiro", "idProjeto", $idProjeto);

if(isset($_POST['inserirDeposito'])){
    $idReserva = $_POST['idReserva'];
    $tipoPessoa = $_POST['tipoPessoa'];
    $idIncentivador = $_POST['idIncentivador'];
    $data = exibirDataMysql($_POST['data']);
    $valorDeposito = dinheiroDeBr($_POST['valorDeposito']);
    $valorRenuncia = dinheiroDeBr($_POST['valorRenuncia']);
    $porcentagemValorRenuncia = $_POST['porcentagemValorRenuncia'];
    
    $sql = "INSERT INTO deposito (idReserva, tipoPessoa, idIncentivador, data, valorDeposito, valorRenuncia, porcentagemValorRenuncia) values ('$idReserva', '$tipoPessoa', '$idIncentivador', '$data', '$valorDeposito', '$valorRenuncia', '$porcentagemValorRenuncia')";
    
    if(mysqli_query($con,$sql)){
        $mensagem = "<font color='#01DF3A'><strong>Liquidação cadastrada com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
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
                <h4>Inserir Depósito</h4>
            </div>

            <div class="col-md-offset-1 col-md-10">
                <div class="table-responsive list_info">
                    <form method="POST" , action="?perfil=cadastro_deposito&idReserva=<?=$idReserva?>" class="form-horizontal" role="form">
                        <div class="form-group">

                            <div class="col-md-offset-2 col-md-2">
                                <label>Incentivadores</label>
                                <select>
                                <option value="" selected disabled="disabled" hidden>Selecione o Incentivador</option>
                                <?php
                                        $sql_busca_incentivador = "SELECT * FROM financeiro f INNER JOIN incentivador_pessoa_fisica pf ON f.idIncentivador = pf.idPf WHERE f.idProjeto = '$idProjeto' AND f.tipoPessoa = 4";
                                        $query_busca_incentivador = mysqli_query($con, $sql_busca_incentivador);
                                    
                                        while($dados = mysqli_fetch_array($query_busca_incentivador)){ 
                                    ?>
                                            <option value="<?php echo $dados['idIncentivador'];?>"><?php echo $dados['nome'] ?></option>
                                <?php 
                                        }
                          
                                        $sql_busca_incentivador = "SELECT * FROM financeiro f INNER JOIN incentivador_pessoa_juridica pj ON f.idIncentivador = pj.idPj WHERE f.idProjeto = '$idProjeto' AND f.tipoPessoa = 5";
                                        $query_busca_incentivador = mysqli_query($con, $sql_busca_incentivador);
                                    
                                        while($dados = mysqli_fetch_array($query_busca_incentivador)){ 
                                    ?>
                                            <option value="<?php echo $dados['idIncentivador'];?>"><?php echo $dados['razaoSocial'] ?></option>
                                        <?php } ?>
                                
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>Data</label>
                                <input type="text" name="data" id='datepicker01' class="form-control" placeholder="DD/MM/AA ou MM/AAAA" required>
                            </div>

                            <div class="col-md-3">
                                <label>Valor do Depósito</label>
                                <input type="text" id='valor' name="valorDeposito" class="form-control" required>
                            </div>

                            <div class="col-md-3">
                                <label>Valor da Renúncia</label>
                                <input type="text" id='valor' name="valorRenuncia" class="form-control" required>
                            </div>

                            <div class="col-md-3">
                                <label>Porcentagem Renúncia</label>
                                <input type="text" name="porcentagemValorRenuncia" class="form-control">
                            </div>

                            <?php echo "<input type='hidden' name='idReserva' value='$idReserva'>";?>
                            <br>
                            <br>
                            <br>
                            <input type="submit" name="inserirDeposito" class="btn btn-theme btn-md btn-block" value="Gravar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
