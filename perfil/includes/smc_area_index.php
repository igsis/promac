<?php
if(isset($_POST['envioComissao']))
{
	$idProjeto = $_POST['idProjeto'];
	$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
	$idEtapa = $projeto['idEtapaProjeto'];

	switch ($idEtapa) {
		case 2:
			$statusEnvio = 7;
			break;
		case 10:
			$statusEnvio = 7;
			break;
		case 13:
			$statusEnvio = 19;
			break;
		case 20:
			$statusEnvio = 19;
			break;
		case 14:
			$statusEnvio = 34;
			break;
		case 15:
			$statusEnvio = 34;
			break;
		case 23:
			$statusEnvio = 24;
			break;
		case 25:
			$statusEnvio = 24;
			break;
	}
	$dateNow = date('Y-m-d H:i:s');
	$sql_envioComissao = "UPDATE projeto SET idEtapaProjeto = '$statusEnvio', envioComissao = '$dateNow', idStatus = '2' WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_envioComissao))
	{
		$sql_historico = "INSERT INTO historico_etapa (idProjeto, idEtapaProjeto, data) VALUES ('$idProjeto', '$statusEnvio', '$dateNow')";
		$query_historico = mysqli_query($con, $sql_historico);
        $mensagem = "<font color='#01DF3A'><strong>Enviado com sucesso!</strong></font>";
		gravarLog($sql_historico);
		gravarLog($sql_envioComissao);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao enviar! Tente novamente.</strong></font>";
	}
}

    if ($pf['idNivelAcesso'] == 2)
    { ?>
        <!-- Lista 1 -->
        <div class="form-group">
            <h5><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></h5>
            <h5>Inscrições de proponente pessoa física a liberar</h5>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive list_info">
                    <?php
                    $sql = "SELECT * FROM pessoa_fisica WHERE liberado = 1 LIMIT 0,10";
                    $query = mysqli_query($con,$sql);
                    $num = mysqli_num_rows($query);
                    if($num > 0)
                    {
                        echo "
                            <table class='table table-condensed'>
                                <thead>
                                    <tr class='list_menu'>
                                        <td>Nome</td>
                                        <td>CPF</td>
                                        <td>RG</td>
                                        <td>Email</td>
                                        <td>Telefone</td>
                                        <td width='10%'></td>
                                    </tr>
                                </thead>
                                <tbody>";
                        while($campo = mysqli_fetch_array($query))
                        {
                            echo "<tr>";
                            echo "<td class='list_description'>".$campo['nome']."</td>";
                            echo "<td class='list_description'>".$campo['cpf']."</td>";
                            echo "<td class='list_description'>".$campo['rg']."</td>";
                            echo "<td class='list_description'>".$campo['email']."</td>";
                            echo "<td class='list_description'>".$campo['telefone']."</td>";
                            echo "
                                        <td class='list_description'>
                                            <form method='POST' action='?perfil=smc_visualiza_perfil_pf'>
                                                <input type='hidden' name='liberado' value='".$campo['idPf']."' />
                                                <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                            </form>
                                        </td>";
                        }
                        echo "</tr>";
                        echo "</tbody>
                                </table>";
                    }
                    else
                    {
                        echo "Não há resultado no momento.";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Lista 2 -->
        <div class="form-group">
            <h5>Inscrições de proponente pessoa jurídica a liberar</h5>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive list_info">
                    <?php
                    $sql = "SELECT * FROM pessoa_juridica WHERE liberado = 1 LIMIT 0,10";
                    $query = mysqli_query($con,$sql);
                    $num = mysqli_num_rows($query);
                    if($num > 0)
                    {
                        echo "
                            <table class='table table-condensed'>
                                <thead>
                                    <tr class='list_menu'>
                                        <td>Razão Social</td>
                                        <td>CNPJ</td>
                                        <td>Email</td>
                                        <td>Telefone</td>
                                        <td width='10%'></td>
                                    </tr>
                                </thead>
                                <tbody>";
                        while($campo = mysqli_fetch_array($query))
                        {
                            echo "<tr>";
                            echo "<td class='list_description'>".$campo['razaoSocial']."</td>";
                            echo "<td class='list_description'>".$campo['cnpj']."</td>";
                            echo "<td class='list_description'>".$campo['email']."</td>";
                            echo "<td class='list_description'>".$campo['telefone']."</td>";
                            echo "
                                        <td class='list_description'>
                                            <form method='POST' action='?perfil=smc_visualiza_perfil_pj'>
                                                <input type='hidden' name='liberado' value='".$campo['idPj']."' />
                                                <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                            </form>
                                        </td>";
                        }
                        echo "</tr>";
                        echo "</tbody>
                                </table>";
                    }
                    else
                    {
                        echo "Não há resultado no momento.";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Lista 3 -->
        <div class="form-group">
            <h5>Inscrições de incentivador pessoa física a liberar</h5>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive list_info">
                    <?php
                    $sql = "SELECT * FROM incentivador_pessoa_fisica WHERE liberado = 1 LIMIT 0,10";
                    $query = mysqli_query($con,$sql);
                    $num = mysqli_num_rows($query);
                    if($num > 0)
                    {
                        echo "
                            <table class='table table-condensed'>
                                <thead>
                                    <tr class='list_menu'>
                                        <td>Nome</td>
                                        <td>CPF</td>
                                        <td>Email</td>
                                        <td>Telefone</td>
                                        <td width='10%'></td>
                                    </tr>
                                </thead>
                                <tbody>";
                        while($campo = mysqli_fetch_array($query))
                        {
                            echo "<tr>";
                            echo "<td class='list_description'>".$campo['nome']."</td>";
                            echo "<td class='list_description'>".$campo['cpf']."</td>";
                            echo "<td class='list_description'>".$campo['email']."</td>";
                            echo "<td class='list_description'>".$campo['telefone']."</td>";
                            echo "
                                        <td class='list_description'>
                                            <form method='POST' action='?perfil=smc_visualiza_incentivadores_pf'>
                                                <input type='hidden' name='liberado' value='".$campo['idPf']."' />
                                                <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                            </form>
                                        </td>";
                        }
                        echo "</tr>";
                        echo "</tbody>
                                </table>";
                    }
                    else
                    {
                        echo "Não há resultado no momento.";
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- Lista 4 -->
        <div class="form-group">
            <h5>Inscrições de incentivador pessoa jurídica a liberar</h5>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive list_info">
                    <?php
                    $sql = "SELECT * FROM incentivador_pessoa_juridica WHERE liberado = 1 LIMIT 0,10";
                    $query = mysqli_query($con,$sql);
                    $num = mysqli_num_rows($query);
                    if($num > 0)
                    {
                        echo "
                            <table class='table table-condensed'>
                                <thead>
                                    <tr class='list_menu'>
                                        <td>Razão Social</td>
                                        <td>CNPJ</td>
                                        <td>Email</td>
                                        <td>Telefone</td>
                                        <td width='10%'></td>
                                    </tr>
                                </thead>
                                <tbody>";
                        while($campo = mysqli_fetch_array($query))
                        {
                            echo "<tr>";
                            echo "<td class='list_description'>".$campo['razaoSocial']."</td>";
                            echo "<td class='list_description'>".$campo['cnpj']."</td>";
                            echo "<td class='list_description'>".$campo['email']."</td>";
                            echo "<td class='list_description'>".$campo['telefone']."</td>";
                            echo "
                                        <td class='list_description'>
                                            <form method='POST' action='?perfil=smc_visualiza_incentivadores_pj'>
                                                <input type='hidden' name='liberado' value='".$campo['idPj']."' />
                                                <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                            </form>
                                        </td>";
                        }
                        echo "</tr>";
                        echo "</tbody>
                                </table>";
                    }
                    else
                    {
                        echo "Não há resultado no momento.";
                    }
                    ?>
                </div>
            </div>
        </div>
<?php
    }
    
$array_status = array(2, 3, 10, 12, 13, 20, 23, 25, 14, 15, 11); //status
foreach ($array_status as $idStatus)
{
    $sqlStatus = "SELECT idEtapaProjeto, etapaProjeto, ordem FROM etapa_projeto WHERE idEtapaProjeto = '$idStatus'";
    $sqlProjeto = "SELECT idProjeto, nomeProjeto, protocolo, pf.nome, pf.cpf, razaoSocial, cnpj, areaAtuacao, pfc.nome AS comissao, etapaProjeto, pro.idEtapaProjeto AS idEtapaProjeto 
                    FROM projeto AS pro
                    LEFT JOIN pessoa_fisica AS pf ON pro.idPf = pf.idPf
                    LEFT JOIN pessoa_juridica AS pj ON pro.idPj = pj.idPj
                    INNER JOIN area_atuacao AS ar ON pro.idAreaAtuacao = ar.idArea
                    LEFT JOIN pessoa_fisica AS pfc ON pro.idComissao = pfc.idPf 
                    INNER JOIN etapa_projeto AS st ON pro.idEtapaProjeto = st.idEtapaProjeto
                    WHERE pro.publicado = 1 AND pro.idStatus != 6  AND pro.idEtapaProjeto = '$idStatus' ORDER BY idProjeto DESC";
    $queryProjeto = mysqli_query($con,$sqlProjeto);
    $queryStatus = mysqli_query($con,$sqlStatus);
    $num = mysqli_num_rows($queryProjeto);

    foreach ($queryStatus as $status)
    {
        $i = 0;
        ?>
        <div class='form-group'>
            <h5>Projetos com Etapa "<?=$status['etapaProjeto']?>"</h5>
            <?php
            if ($pf['idNivelAcesso'] == 2)
            {
                echo "<form method='POST' action='?perfil=smc_pesquisa_geral_resultado' class='form-horizontal' role='form'>";
            }
            ?>

                <button type="submit" class="label label-warning" name="idEtapaProjeto" value="<?=$status['idEtapaProjeto']?>">
                    <span>Total: <?=$num?></span>
                </button>
            </form>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive list_info">
                    <?php
                    if($num > 0)
                    {
                    ?>

                    <table class='table table-condensed'>
                        <thead>
                        <tr class='list_menu'>
                            <td>Protocolo (nº ISP)</td>
                            <td>Nome do Projeto</td>
                            <td>Proponente</td>
                            <td>Documento</td>
                            <td>Área de Atuação</td>
                            <?=($status['ordem'] >= 5) ? "<td>Parecerista</td>" : NULL ?>
                            <?php
                            if (($status['idEtapaProjeto'] == 23) || ($status['idEtapaProjeto'] == 13))
                            {
                                ?>
                                <td>Arquivo</td>
                                <td>Enviado à</td>
                                <?php
                            }
                            ?>    
                            <?=($status['idEtapaProjeto'] == '2' || $status['idEtapaProjeto'] == '13' || $status['idEtapaProjeto'] == '14' || $status['idEtapaProjeto'] == '23') ? "<td></td>" : NULL ?>
                            <td width='10%'></td>
                        </tr>
                        </thead>
                        <?php
                        while ($campo = mysqli_fetch_array($queryProjeto))
                        {

                            if ($i < 5) {
                                ?>
                                <tr>
                                    <td class='list_description maskProtocolo' data-mask = "0000.00.00/0000000"><?= $campo['protocolo'] ?></td>
                                    <td class='list_description'><?= $campo['nomeProjeto'] ?></td>
                                    <td class='list_description'><?= isset($campo['nome']) ? $campo['nome'] : $campo['razaoSocial'] ?></td>
                                    <td class='list_description'><?= isset($campo['cpf']) ? $campo['cpf'] : $campo['cnpj'] ?></td>
                                    <td class='list_description'><?= mb_strimwidth($campo['areaAtuacao'], 0, 38, "...") ?></td>
                                    <?= ($status['ordem'] >= 5) ? "<td class='list_description'>".$campo['comissao']."</td>" : NULL ?>
                                    <?php
                                    /*TODO: Transformar este bloco de if/elseif em função*/
                                    if ($status['idEtapaProjeto'] == 23)
                                    {
                                        $sqlRecurso = "SELECT DISTINCT `arquivo`, `dataEnvio` FROM `upload_arquivo` WHERE `idTipo` = '3' AND `idPessoa` = '".$campo['idProjeto']."' AND `idListaDocumento` = '52' AND `publicado` = '1'";
                                        $recurso = mysqli_fetch_array(mysqli_query($con, $sqlRecurso));
                                        $dataEnvio = date_create($recurso['dataEnvio']);
                                        $dataAtual = date_create(date("Y-m-d"));
                                        $dias = date_diff($dataEnvio, $dataAtual);


                                        echo "<td><a href='../uploadsdocs/".$recurso['arquivo']."' target='_blank'>".mb_strimwidth($recurso['arquivo'], 15, 38, "...")."</a></td>";
                                        echo "<td>".$dias->format("%a dias")."</td>";
                                    }
                                    elseif (($status['idEtapaProjeto'] == 13))
                                    {
                                        $sqlComplemento = "SELECT DISTINCT `arquivo`, `dataEnvio` FROM `upload_arquivo` WHERE `idTipo` = '3' AND `idPessoa` = '".$campo['idProjeto']."' AND `idListaDocumento` = '46' AND `publicado` = '1'";
                                        $complemento = mysqli_fetch_array(mysqli_query($con, $sqlComplemento));
                                        $dataEnvio = date_create($complemento['dataEnvio']);
                                        $dataAtual = date_create(date("Y-m-d"));
                                        $dias = date_diff($dataEnvio, $dataAtual);

                                        echo "<td><a href='../uploadsdocs/".$complemento['arquivo']."' target='_blank'>".mb_strimwidth($complemento['arquivo'], 15, 25, "...")."</a></td>";
                                        echo "<td>".$dias->format("%a dias")."</td>";
                                    }
                                    if ($pf['idNivelAcesso'] == 2)
                                    {
                                        ?>
                                        <td class='list_description'>
                                            <form method='POST' action='?perfil=smc_detalhes_projeto'>
                                                <input type='hidden' name='idProjeto'
                                                       value='<?= $campo['idProjeto'] ?>'/>
                                                <input type='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                            </form>
                                        </td>
                                        <td class='list_description'>
                                        <?php
                                            if ($status['idEtapaProjeto'] == '2' || $status['idEtapaProjeto'] == '13' || $status['idEtapaProjeto'] == '14' || $status['idEtapaProjeto'] == '23') {
                                        ?>
                                                <form method="POST" action=''>
                                                    <input type='button' data-id="<?= $campo['idProjeto'] ?>"  name='envioComissao' class='btn btn-theme btn-block' value='Enviar para comissão' data-toggle='modal' data-target='#enviarComissao'>
                                                </form>
                                        <?php                                                
                                            }
                                        ?>
                                        </td>
                                        <?php                                        
                                    }
                                    ?>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                    }
                    else
                    {
                        echo "Não há resultado no momento.";
                    }
                    ?>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

<!-- Lista 7 -->
<div class="form-group">
    <h5>Projetos com data final de captação com tempo menor que 30 dias.</h5>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive list_info">
            <?php
            $sql = "SELECT * FROM prazos_projeto AS prz INNER JOIN projeto AS prj ON prj.idProjeto = prz.idProjeto WHERE prj.publicado = 1 AND finalCaptacao != '0000-00-00' AND finalCaptacao BETWEEN CURRENT_DATE()-30 AND CURRENT_DATE() LIMIT 0,10";
            $query = mysqli_query($con,$sql);
            $num = mysqli_num_rows($query);
            if($num > 0)
            {
                ?>
                <table class='table table-condensed'>
                    <thead>
                    <tr class='list_menu'>
                        <td>Protocolo (nº ISP)</td>
                        <td>Prazo de Captação: </td>
                        <td>Início da execução:</td>
                        <td>Fim da execução:</td>
                        <td width='10%'>Ação:</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while($campo = mysqli_fetch_array($query))
                    {
                    ?>
                    <tr>
                        <td class='list_description'><?=$campo['protocolo']?></td>
                        <td class='list_description'><?=exibirDataBr($campo['prazoCaptacao'])?></td>
                        <td class='list_description'><?=exibirDataBr($campo['inicioExecucao'])?></td>
                        <td class='list_description'><?=exibirDataBr($campo['fimExecucao'])?></td>
                        <?$idProjetos = $campo['idProjeto']?>
                        <td class='list_description'>
                            <form method='POST' action='?perfil=smc_detalhes_projeto'>
                                <input type='hidden' name='idProjeto' value='<?=$idProjetos?>'/>
                                <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                            </form>
                        </td>
                        <?php
                        }
                        ?>
                    </tr>
                    </tbody>
                </table>
                <?php
            }
            else
            {
                echo "Não há resultado no momento.";
            }
            ?>
        </div>
    </div>
</div>

<!-- Lista 8 -->
<div class="form-group">
    <h5>Projetos com data de execução menor que 30 dias.</h5>
</div>
<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <div class="table-responsive list_info">
            <?php
            $sql = "SELECT * FROM prazos_projeto AS prz INNER JOIN projeto AS prj ON prj.idProjeto = prz.idProjeto WHERE prj.publicado = 1 AND finalProjeto !='0000-00-00' AND finalProjeto BETWEEN CURRENT_DATE()-30 AND CURRENT_DATE() LIMIT 0,10";
            $query = mysqli_query($con,$sql);
            $num = mysqli_num_rows($query);
            if($num > 0)
            {
                ?>
                <table class='table table-condensed'>
                    <thead>
                    <tr class='list_menu'>
                        <td>Protocolo (nº ISP)</td>
                        <td>Prazo de Captação: </td>
                        <td>Início da execução:</td>
                        <td>Fim da execução:</td>
                        <td width='10%'>Ação:</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while($campo = mysqli_fetch_array($query))
                    {
                    ?>
                    <tr>
                        <td class='list_description'><?=$campo['protocolo']?></td>
                        <td class='list_description'><?=exibirDataBr($campo['prazoCaptacao'])?></td>
                        <td class='list_description'><?=exibirDataBr($campo['inicioExecucao'])?></td>
                        <td class='list_description'><?=exibirDataBr($campo['fimExecucao'])?></td>
                        <?$idProjetos = $campo['idProjeto']?>
                        <td class='list_description'>
                            <form method='POST' action='?perfil=smc_detalhes_projeto'>
                                <input type='hidden' name='idProjeto' value='<?=$idProjetos?>' />
                                <input type ='submit' name='liberacaoPF' class='btn btn-theme btn-block' value='Visualizar'>
                            </form>
                        </td>
                        <?php
                        }
                        ?>
                    </tr>
                    </tbody>
                </table>
                <?php
            }
            else
            {
                echo "Não há resultado no momento.";
            }
            ?>
        </div>
    </div>
</div>

<!-- Lista 9 -->
<div class="form-group">
    <h5>Projetos com data para prestar contas faltando 30 dias ou menos.</h5>
</div>
<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <div class="table-responsive list_info">
            <?php
            $sql = "SELECT * FROM prazos_projeto AS prz INNER JOIN projeto AS prj ON prj.idProjeto = prz.idProjeto WHERE prj.publicado = 1 AND prestarContas != '0000-00-00' AND prestarContas BETWEEN CURRENT_DATE()-30 AND CURRENT_DATE() LIMIT 0,10";
            $query = mysqli_query($con,$sql);
            $num = mysqli_num_rows($query);
            if($num > 0)
            {
                ?>
                <table class='table table-condensed'>
                    <thead>
                    <tr class='list_menu'>
                        <td>Protocolo (nº ISP)</td>
                        <td>Prazo de Captação: </td>
                        <td>Início da execução:</td>
                        <td>Fim da execução:</td>
                        <td width='10%'>Ação:</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    while($campo = mysqli_fetch_array($query))
                    {
                    ?>
                    <tr>
                        <td class='list_description'><?=$campo['protocolo']?></td>
                        <td class='list_description'><?=exibirDataBr($campo['prazoCaptacao'])?></td>
                        <td class='list_description'><?=exibirDataBr($campo['inicioExecucao'])?></td>
                        <td class='list_description'><?=exibirDataBr($campo['fimExecucao'])?></td>
                        <?$idProjetos = $campo['idProjeto']?>
                        <td class='list_description'>
                            <form method='POST' action='?perfil=smc_detalhes_projeto'>
                                <input type='hidden' name='idProjeto' value='<?=$idProjetos?>' />
                                <input type ='submit' name='liberacaoPF' class='btn btn-theme btn-block' value='Visualizar'>
                            </form>
                        </td>
                        <?php
                        }
                        ?>
                    </tr>
                    </tbody>
                </table>
                <?php
            }
            else
            {
                echo "Não há resultado no momento.";
            }
            ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="enviarComissao" tabindex="-1" role="dialog" aria-labelledby="enviarComissao">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="enviarComissao">Enviar para comissão?</h4>
      </div>
      <div class="modal-body">
        <p>Para confirmar clique no botão SIM!</p>
      </div>
      <div class="modal-footer">
        <form method='POST' action='' id='formEnviar'>
            <input type='hidden' name='idProjeto'>           
            <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
            <button type="submit" name='envioComissao' class="btn btn-primary">SIM</button>
        </form>
      </div>
    </div>
  </div>
</div>

 <script type="text/javascript">
    // Alimenta o modal com o idProjeto
    $('#enviarComissao').on('show.bs.modal', function (e)
    {
        let idProjeto = $(e.relatedTarget).attr('data-id');
        $(this).find('#formEnviar input[name="idProjeto"]').attr('value', idProjeto);

    });
</script>