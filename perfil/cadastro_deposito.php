<?php
$con = bancoMysqli();

$idReserva = $_GET['idReserva'];
$idProjeto = $_GET['idProjeto'];

$deposito = recuperaDados("deposito","idReserva", $idReserva);
$incentivador_projeto = recuperaDados("incentivador_projeto", "idProjeto", $idProjeto);
$projeto = recuperaDados("projeto", "idProjeto", $idProjeto);

if(isset($_POST['inserirDeposito'])){
    $idReserva = $_POST['idReserva'];
    $valores = explode('|', $_POST['incentivador']);
    $idIncentivador = $valores[0];
    $tipoPessoa = $valores[1];
    $data = exibirDataMysql($_POST['data']);
    $valorDeposito = dinheiroDeBr($_POST['valorDeposito']);
    $valorRenuncia = dinheiroDeBr($_POST['valorRenuncia']);
    $valorAprovado = dinheiroDeBr($_POST['valorAprovado']);
    $porcentagemValorRenuncia = ($valorDeposito * 100) / $valorAprovado;
    
    $sql = "INSERT INTO deposito (idReserva, tipoPessoa, idIncentivador, data, valorDeposito, valorRenuncia, porcentagemValorRenuncia) values ('$idReserva', '$tipoPessoa', '$idIncentivador', '$data', '$valorDeposito', '$valorRenuncia', '$porcentagemValorRenuncia')";
    
    if(mysqli_query($con,$sql)){
        $mensagem = "<font color='#01DF3A'><strong>Liquidação cadastrada com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=deposito&idReserva=$idReserva&idProjeto=$idProjeto';</script>";
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
                    <form method="POST" , action="?perfil=cadastro_deposito&idReserva=<?=$idReserva?>&idProjeto=<?=$idProjeto?>" class="form-horizontal" role="form">
                        <div class="form-group">

                            <div class="col-md-offset-2 col-md-8">
                                <label>Incentivadores</label>
                                <select name="incentivador" required>
                                <option value="" selected disabled="disabled" hidden>Selecione o Incentivador</option>
                                <?php
                                        $sql_busca_incentivador = "SELECT * FROM incentivador_projeto ip INNER JOIN incentivador_pessoa_fisica pf ON ip.idIncentivador = pf.idPf WHERE ip.idProjeto = '$idProjeto' AND ip.tipoPessoa = 4";
                                        $query_busca_incentivador = mysqli_query($con, $sql_busca_incentivador);
                                    
                                        while($dados = mysqli_fetch_array($query_busca_incentivador)){ 
                                    ?>
                                            <option value="<?php echo $dados['idIncentivador'];?>|4"><?php echo $dados['nome'] ?></option>
                                            
                                <?php
                                            
                                        }
                          
                                        $sql_busca_incentivador = "SELECT * FROM incentivador_projeto ip INNER JOIN incentivador_pessoa_juridica pj ON ip.idIncentivador = pj.idPj WHERE ip.idProjeto = '$idProjeto' AND ip.tipoPessoa = 5";
                                        $query_busca_incentivador = mysqli_query($con, $sql_busca_incentivador);
                                    
                                        while($dados = mysqli_fetch_array($query_busca_incentivador)){ 
                                ?>
                                            <option value="<?php echo $dados['idIncentivador'];?>|5"><?php echo $dados['razaoSocial'] ?></option>
                                <?php 
                                        } 
                                ?>
                                
                                </select>
                            </div>

                            <div class="col-md-offset-2 col-md-2">
                                <label>Data</label>
                                <input type="text" name="data" id='datepicker01' class="form-control" placeholder="DD/MM/AA" required>
                            </div>

                            <div class="col-md-3">
                                <label>Valor do Depósito</label>
                                <input type="text" id='valor' name="valorDeposito" class="form-control valorDeposito" required>
                            </div>

                            <div class="col-md-3">
                                <label>Valor da Renúncia</label>
                                <input type="text" id='valor' name="valorRenuncia" class="form-control" required>
                            </div>
                            <!--
                            <div class="col-md-3">
                                <label>Porcentagem Renúncia</label>
                                <input type="text" name="porcentagemRenuncia" class="form-control" id="porcentagemRenuncia" readonly>
                            </div>
-->
                        </div>
                        <input type="hidden" id='valor' name="valorAprovado" class="form-control valorAprovado" value="<?php echo dinheiroParaBr($projeto['valorAprovado']); ?>">
                        <div class="col-md-offset-2 col-md-8">
                            <?php echo "<input type='hidden' name='idReserva' value='$idReserva'>";?>
                            <input type="submit" name="inserirDeposito" class="btn btn-theme btn-md btn-block" value="Gravar">
                        </div>
                    </form>
                    <div class="col-md-offset-2 col-md-8" style="margin-top: 5px">
                        <form method="POST" action="?perfil=deposito&idReserva=<?=$idReserva?>&idProjeto=<?=$idProjeto?>">
                            <input type='submit' class='btn btn-theme btn-block' value='cancelar'>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
