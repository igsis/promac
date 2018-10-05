<?php
//TODO: Confirmar a utilização deste arquivo
$con = bancoMysqli();

$idFinanceiro = $_POST['idFinanceiro'];
$financeiro = recuperaDados('financeiro','idFinanceiro',$idFinanceiro);
$projeto = recuperaDados("projeto","idProjeto",$financeiro['idProjeto']);
if($financeiro['tipoPessoa'] == 4)
{
    $pf = recuperaDados('incentivador_pessoa_fisica', 'idPf', $financeiro['idIncentivador']);
}
else
{
    $pj = recuperaDados('incentivador_pessoa_juridica', 'idPj', $financeiro['idIncentivador']);
    $representante = recuperaDados('representante_legal', 'idRepresentanteLegal', $pj['idRepresentanteLegal']);
}


if(isset($_POST['gravarDeposito']))
{
    $idFinanceiro = $_POST['idFinanceiro'];
    $dataDeposito = exibirDataMysql($_POST['dataDeposito']);
    $valorDeposito = dinheiroDeBr($_POST['valorDeposito']);
    $valorRenuncia = dinheiroDeBr($_POST['valorRenuncia']);
    $porcentagemRenuncia = $_POST['porcentagemValorRenuncia'];

    $sql_gravarDeposito = "UPDATE financeiro SET dataDeposito = '$dataDeposito', valorDeposito = '$valorDeposito', valorRenuncia = '$valorRenuncia', porcentagemValorRenuncia = '$porcentagemRenuncia' WHERE idFinanceiro = '$idFinanceiro' ";
    if(mysqli_query($con,$sql_gravarDeposito))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        gravarLog($sql_gravarDeposito);
        echo "<script>window.location = '?perfil=financeiro&idFF=$idFin';</script>";
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
        gravarLog($sql_gravarReserva);
        echo "<script>window.location = '?perfil=financeiro&idFF=$idFin';</script>";
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
        gravarLog($sql_gravarEmpenho);
        echo "<script>window.location = '?perfil=financeiro&idFF=$idP';</script>";
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
        gravarLog($sql_gravarLiquidacao);
        echo "<script>window.location = '?perfil=financeiro&idFF=$idP';</script>";
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
            <h4>Editar Financeiro</h4>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div role="tabpanel">
                    <!-- LABELS-->
                    <ul class="nav nav-tabs">
                        <?php if($financeiro['tipoPessoa'] == 4):?>
                            <li class="active"><a href="#F" data-toggle="tab">Incentivador Pessoa Física</a></li>
                        <?php else: ?>
                            <li class="active"><a href="#J" data-toggle="tab">Incentivador Pessoa Jurídica</a></li>
                        <?php endif ?>
                        <li><a href="#deposito" data-toggle="tab">Depósitos</a></li>
                        <li><a href="#reserva" data-toggle="tab">Reserva</a></li>
                        <li><a href="#empenho" data-toggle="tab">Empenho</a></li>
                        <li><a href="#liquidacao" data-toggle="tab">Liquidação</a></li>
                    </ul>
                    <div class="tab-content">
                        <?php if($financeiro['tipoPessoa'] == 4) { ?>
                            <!--LABEL PESSOA FISICA-->
                            <div role="tabpanel" class="tab-pane fade in active" id="F" align="left">
                                <br>
                                <li class="list-group-item list-group-item-success">
                                    <div style="text-align: center;">
                                        <b>Dados do Incentivador</b>
                                    </div>
                                </li>
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="2">
                                            <strong>Nome:</strong> <?=$pf['nome']?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%">
                                            <strong>CPF:</strong> <?=$pf['cpf']?>
                                        </td>
                                        <td>
                                            <strong>RG:</strong> <?=$pf['rg']?>
                                        </td>
                                    </tr>
                                    <?php if($pf['cep'] != null) { ?>
                                        <tr>
                                            <td colspan="2">
                                                <strong>Endereço:</strong>
                                                <?=isset($pf['logradouro']) ? $pf['logradouro'] : ''?>,
                                                <?=isset($pf['numero']) ? $pf['numero'] : ''?>,
                                                <?=isset($pf['bairro']) ? $pf['bairro'] : ''?>,
                                                <?=isset($pf['cidade']) ? $pf['cidade'] : ''?> -
                                                <?=isset($pf['estado']) ? $pf['estado'] : ''?> -
                                                CEP <?=isset($pf['cep']) ? $pf['cep'] : ''?>
                                            </td>
                                        </tr>
                                    <?php }
                                    else { ?>
                                        <tr>
                                            <td colspan="2">
                                                <strong>Endereço:</strong> Não cadastrado
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td>
                                            <strong>Telefone:</strong> <?=isset($pf['telefone']) ? $pf['telefone'] : ''?>
                                        </td>
                                        <td>
                                            <strong>Celular:</strong> <?=isset($pf['celular']) ? $pf['celular'] : ''?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong>E-mail:</strong> <?= isset($pf['email']) ? $pf['email'] : ''?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        <?php }
                        else { ?>

                            <!--LABEL PESSOA JURÍDICA-->
                            <div role="tabpanel" class="tab-pane fade in active" id="J">
                                <br>
                                <li class="list-group-item list-group-item-success">
                                    <b>Dados do Incentivador</b>
                                </li>
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="2">
                                            <strong>Razão Social:</strong> <?=isset($pj['razaoSocial']) ? $pj['razaoSocial'] : ''?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong>CNPJ:</strong> <?=isset($pj['cnpj']) ? $pj['cnpj'] : ''?>
                                        </td>
                                    </tr>
                                    <?php if($pj['cep'] != null) { ?>
                                        <tr>
                                            <td colspan="2">
                                                <strong>Endereço:</strong>
                                                <?=isset($pj['logradouro']) ? $pj['logradouro'] : ''?>,
                                                <?=isset($pj['numero']) ? $pj['numero'] : ''?>,
                                                <?=isset($pj['complemento']) ? $pj['complemento'] : ''?>,
                                                <?=isset($pj['bairro']) ? $pj['bairro'] : ''?>,
                                                <?=isset($pj['cidade']) ? $pj['cidade'] : ''?> -
                                                <?=isset($pj['estado']) ? $pj['estado'] : ''?> -
                                                CEP <?=isset($pj['cep']) ? $pj['cep'] : ''; ?>
                                            </td>
                                        </tr>
                                    <?php }
                                    else { ?>
                                        <tr>
                                            <td colspan="2">
                                                <strong>Endereço:</strong> Não cadastrado
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td width="50%">
                                            <strong>Telefone:</strong> <?=isset($pj['telefone']) ? $pj['telefone'] : ''?>
                                        </td>
                                        <td>
                                            <strong>Celular:</strong> <?=isset($pj['celular']) ? $pj['celular'] : ''; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <strong>E-mail:</strong> <?php echo isset($pj['email']) ? $pj['email'] : null; ?>
                                        </td>
                                    </tr>
                                </table>

                                <li class="list-group-item list-group-item-success">
                                    <b>Dados do Representante</b>
                                </li>

                                <?php if($pj['idRepresentanteLegal'] != null) { ?>
                                    <table class="table table-bordered">
                                        <tr>
                                            <td colspan="2">
                                                <strong>Nome:</strong><?=$representante['nome']?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="50%">
                                                <strong>CPF:</strong> <?=$representante['cpf']?>
                                            </td>
                                            <td>
                                                <strong>RG:</strong> <?=$representante['rg']?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <strong>Endereço:</strong>
                                                <?=isset($representante['logradouro']) ? $representante['logradouro'] : ''?>,
                                                <?=isset($representante['numero']) ? $representante['numero'] : ''?>,
                                                <?=isset($representante['bairro']) ? $representante['bairro'] : ''?>,
                                                <?=isset($representante['cidade']) ? $representante['cidade'] : ''?> -
                                                <?=isset($representante['estado']) ? $representante['estado'] : ''?> -
                                                CEP <?=isset($representante['cep']) ? $representante['cep'] : ''?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>Telefone:</strong>
                                                <?=isset($representante['telefone']) ? $representante['telefone'] : ''?>
                                            </td>
                                            <td>
                                                <strong>Celular:</strong>
                                                <?=isset($representante['celular']) ? $representante['celular'] : ''?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <strong>E-mail:</strong>
                                                <?=isset($representante['email']) ? $representante['email'] : ''?>
                                            </td>
                                        </tr>
                                    </table>
                                <?php }
                                else { ?>
                                    <h5>Representante legal não cadastrado</h5>
                                <?php } ?>
                            </div>
                        <?php } ?>

                        <!-- LABEL DEPÓSITOS -->
                        <div role="tabpanel" class="tab-pane fade" id="deposito">
                            <form method="POST" action="?perfil=financeiro" class="form-horizontal" role="form">
                                <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8"><br/></div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-6"><label>Data</label><br/>
                                        <input type="text" name="dataDeposito" id='datepicker01' class="form-control" value="<?=($financeiro['dataDeposito'] ==  '' ? exibirDataMysql($financeiro['dataDeposito']) : '')?>">
                                    </div>

                                    <div class="col-md-6"><label>Valor do Depósito</label><br/>
                                        <input type="text" name="valorDeposito" id='valor' class="form-control" value="<?=($financeiro['valorDeposito'] == '' ? dinheiroDeBr($financeiro['valorDeposito']) : '')?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-6"><label>Valor da Renúncia</label><br/>
                                        <input type="text" name="valorRenuncia" id='valor' class="form-control" value="<?=($financeiro['valorRenuncia'] == '' ? dinheiroDeBr($financeiro['valorRenuncia']) : '')?>">
                                    </div>

                                    <div class="col-md-6"><label>Porcentagem Valor da Renúncia</label>
                                        <input type="text" name="porcentagemValorRenuncia" readonly class="form-control" value="<?= ($projeto[''] - $financeiro['va']) ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <input type='hidden' name='idFinanceiro' value="<?=$idFinanceiro?>">
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
                        <div role="tabpanel" class="tab-pane fade" id="liquidacao">
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