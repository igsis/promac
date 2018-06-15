<?php
$con = bancoMysqli();

$idFinanceiro = isset($_POST['idFinanceiro']) ? $_POST['idFinanceiro'] : null;
if($idFinanceiro == null)
{
    $idFinanceiro = isset($_GET['idFF']) ? $_GET['idFF'] : null;
}
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$financeiro = recuperaDados("financeiro","id",$idFinanceiro);


if(isset($_POST['gravarDeposito']))
{
    $idFin = $_POST['IDF'];
    $dataDeposito = exibirDataMysql($_POST['dataDeposito']);
    $valorDeposito = dinheiroDeBr($_POST['valorDeposito']);
    $valorRenuncia = dinheiroDeBr($_POST['valorRenuncia']);
    $porcentagemRenuncia = $_POST['porcentagemValorRenuncia'];

    $sql_gravarDeposito = "UPDATE financeiro SET dataDeposito = '$dataDeposito', valorDeposito = '$valorDeposito', valorRenuncia = '$valorRenuncia', porcentagemValorRenuncia = '$porcentagemRenuncia' WHERE idProjeto = '$idFin' ";
    if(mysqli_query($con,$sql_gravarDeposito))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=financeiro&idFF=$idFin';</script>";
        gravarLog($sql_gravarDeposito);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['gravarReserva']))
{
    $idFin = $_POST['IDF'];
    $dataReserva = exibirDataMysql($_POST['dataReserva']);
    $valorReserva = dinheiroDeBr($_POST['valorReserva']);
    $numeroReserva = $_POST['numeroReserva'];

    $sql_gravarReserva = "UPDATE financeiro SET dataReserva = '$dataReserva', valorReserva = '$valorReserva', numeroReserva = 'numeroReserva' WHERE idFinanceiro = '$idFin' ";
    if(mysqli_query($con,$sql_gravarReserva))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=financeiro&idFF=$idFin';</script>";
        gravarLog($sql_gravarReserva);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
}


if(isset($_POST['gravarEmpenho']))
{
    $idP = $_POST['IDP'];
    $dataEmpenho = exibirDataMysql($_POST['dataEmpenho']);
    $valorEmpenho = dinheiroDeBr($_POST['valorEmpenho']);
    $numeroEmpenho = $_POST['numeroEmpenho'];

    $sql_gravarEmpenho = "UPDATE financeiro SET dataEmpenho = '$dataEmpenho', valorEmpenho = '$valorEmpenho', numeroEmpenho = '$numeroEmpenho' WHERE idProjeto = '$idP' ";
    if(mysqli_query($con,$sql_gravarEmpenho))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=financeiro&idFF=$idP';</script>";
        gravarLog($sql_gravarEmpenho);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
}


if(isset($_POST['gravarLiquidacao']))
{
    $idP = $_POST['IDP'];
    $dataLiquidacao = exibirDataMysql($_POST['dataLiquidacao']);
    $valorLiquidacao = dinheiroDeBr($_POST['valorLiquidacao']);
    $numeroLiquidacao = $_POST['numeroLiquidacao'];

    $sql_gravarLiquidacao = "UPDATE financeiro SET dataLiquidacao = '$dataLiquidacao', valorLiquidacao = '$valorLiquidacao', numeroLiquidacao = '$numeroLiquidacao' WHERE idProjeto = '$idP' ";
    if(mysqli_query($con,$sql_gravarLiquidacao))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=financeiro&idFF=$idP';</script>";
        gravarLog($sql_gravarLiquidacao);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
}


?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_smc.php'; ?>
        <div class="form-group">
            <h4>Ambiente Coordenadoria</h4>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div role="tabpanel">
                    <!-- LABELS-->
                    <ul class="nav nav-tabs">
                        <?php if(isset($representante)):?>
                            <li class="nav active"><a href="#J" data-toggle="tab">Incentivador Pessoa Jurídica</a></li>
                        <?php else: ?>
                            <li class="nav active"><a href="#F" data-toggle="tab">Incentivador Pessoa Física</a></li>
                        <?php endif ?>
                        <li class="nav"><a href="#deposito" data-toggle="tab">Depósitos</a></li>
                        <li class="nav"><a href="#reserva" data-toggle="tab">Reserva</a></li>
                        <li class="nav"><a href="#empenho" data-toggle="tab">Empenho</a></li>
                        <li class="nav"><a href="#liquidacao" data-toggle="tab">Liquidação</a></li>
                    </ul>
                    <div class="tab-content">                                 
                        <!-- LABEL DEPÓSITOS -->
                        <div role="tabpanel" class="tab-pane fade" id="deposito">
                            <form method="POST" action="?perfil=financeiro" class="form-horizontal" role="form">
                                <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8"><br/></div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-6"><label>Data</label><br/>
                                        <input type="text" name="dataDeposito" id='datepicker01' class="form-control" value="<?php echo exibirDataMysql($financeiro['dataDeposito']) ?>">
                                    </div>

                                    <div class="col-md-6"><label>Valor do Depósito</label><br/>
                                        <input type="text" name="valorDeposito" id='valor' class="form-control" value="<?php echo dinheiroDeBr($financeiro['valorDeposito']) ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-6"><label>Valor da Renúncia</label><br/>
                                       <input type="text" name="valorRenuncia" id='valor' class="form-control" value="<?php echo dinheiroDeBr($financeiro['valorRenuncia']) ?>">
                                    </div>

                                    <div class="col-md-6"><label>Porcentagem Valor da Renúncia</label>
                                       <input type="text" name="porcentagemValorRenuncia" readonly class="form-control" value="<?php echo dinheiroDeBr($financeiro['valorRenuncia']) ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <?php echo "<input type='hidden' name='IDP' value='$idProjeto'>"; ?>
                                        <input type="submit" name="gravarDeposito" class="btn btn-theme btn-md btn-block" value="Gravar">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12"><hr/></div>
                                </div>

                            </form>
                        </div>

                        <!-- LABEL RESERVA -->
                        <div role="tabpanel" class="tab-pane fade" id="reserva">
                            <form method="POST" action="?perfil=financeiro" class="form-horizontal" role="form">
                                <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8"><br/></div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-3"><label>Data</label><br/>
                                        <input type="text" name="dataReserva" id='datepicker02' class="form-control" value="<?php echo exibirDataMysql($financeiro['dataReserva']) ?>">
                                    </div>

                                    <div class="col-md-2"><label>Valor</label><br/>
                                        <input type="text" name="valorReserva" id='valor' class="form-control" value="<?php echo dinheiroDeBr($financeiro['valorReserva']) ?>">
                                    </div>

                                    <div class="col-md-3"><label>Número Reserva</label><br/>
                                        <input type="text" name="numeroReserva" class="form-control" value="<?php echo $financeiro['numeroReserva'] ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <?php echo "<input type='hidden' name='IDP' value='$idProjeto'>"; ?>
                                        <input type="submit" name="gravarReserva" class="btn btn-theme btn-md btn-block" value="Gravar">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12"><hr/></div>
                                </div>

                            </form>
                        </div>

                        <!-- LABEL EMPENHO -->
                        <div role="tabpanel" class="tab-pane fade" id="empenho">
                            <form method="POST" action="?perfil=financeiro" class="form-horizontal" role="form">
                                <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8"><br/></div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-3"><label>Data</label><br/>
                                        <input type="text" name="dataEmpenho" id='datepicker03' class="form-control" value="<?php echo exibirDataMysql($financeiro['dataEmpenho']) ?>">
                                    </div>

                                    <div class="col-md-2"><label>Valor</label><br/>
                                        <input type="text" name="valorEmpenho" id='valor' class="form-control" value="<?php echo dinheiroDeBr($financeiro['valorEmpenho']) ?>">
                                    </div>

                                     <div class="col-md-3"><label>Número Empenho</label><br/>
                                        <input type="text" name="numeroEmpenho" class="form-control" value="<?php echo $financeiro['valorEmpenho'] ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <?php echo "<input type='hidden' name='IDP' value='$idProjeto'>"; ?>
                                        <input type="submit" name="gravarEmpenho" class="btn btn-theme btn-md btn-block" value="Gravar">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12"><hr/></div>
                                </div>

                            </form>
                        </div>

                        <!-- LABEL LIQUIDAÇÃO -->
                        <div role="tabpanel" class="tab-pane fade" id="deposito">
                            <form method="POST" action="?perfil=financeiro" class="form-horizontal" role="form">
                                <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8"><br/></div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-3"><label>Data</label><br/>
                                        <input type="text" name="dataLiquidacao" id='datepicker04' class="form-control" value="<?php echo exibirDataMysql($financeiro['dataLiquidacao']) ?>">
                                    </div>

                                    <div class="col-md-2"><label>Valor</label><br/>
                                        <input type="text" name="valorLiquidacao" id='valor' class="form-control" value="<?php echo dinheiroDeBr($financeiro['valorLiquidacao']) ?>">
                                    </div>

                                     <div class="col-md-3"><label>Número Liquidação</label><br/>
                                        <input type="text" name="numeroLiquidacao" class="form-control" value="<?php echo $financeiro['numeroLiquidacao'] ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <?php echo "<input type='hidden' name='IDP' value='$idProjeto'>"; ?>
                                        <input type="submit" name="gravarLiquidacao" class="btn btn-theme btn-md btn-block" value="Gravar">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12"><hr/></div>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>