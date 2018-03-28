<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

if(isset($_POST['insere']))
{
	if($_POST['fimCronograma'] < $_POST['inicioCronograma'])
	{
		echo "<script>alert('ERRO: A data final não pode ser menor que a data inicial. ')</script>";
		header("Location: index_pf.php?perfil=cronograma");
		} else {
		$inicioCronograma = exibirDataMysql($_POST['inicioCronograma']);
		$fimCronograma = exibirDataMysql($_POST['fimCronograma']);

		$sql_insere = "UPDATE projeto SET
			inicioCronograma = '$inicioCronograma',
			fimCronograma = '$fimCronograma'
			WHERE idProjeto = '$idProjeto'";
		if(mysqli_query($con,$sql_insere))
		{
			$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! </strong></font>";
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
		}
	}
}

if(isset($_POST['insereCronograma']))
{
	$captacaoRecurso = $_POST['captacaoRecurso'];
	$preProducao = $_POST['preProducao'];
	$producao = $_POST['producao'];
	$posProducao = $_POST['posProducao'];
	$prestacaoContas = $_POST['prestacaoContas'];

	$sql_insere_cronograma = "INSERT INTO `cronograma`(captacaoRecurso, preProducao, producao, posProducao, prestacaoContas) VALUES ('$captacaoRecurso', '$preProducao', '$producao', '$posProducao', '$prestacaoContas')";

	if(mysqli_query($con,$sql_insere_cronograma))
	{
		$sql_ultimo = "SELECT idCronograma FROM cronograma ORDER BY idCronograma DESC LIMIT 0,1";
		$query_ultimo = mysqli_query($con,$sql_ultimo);
		$ultimoCronograma = mysqli_fetch_array($query_ultimo);
		$idCronograma = $ultimoCronograma['idCronograma'];
		$sql_insere_cronograma_evento = "UPDATE projeto SET idCronograma = '$idCronograma' WHERE idProjeto = '$idProjeto'";
		if(mysqli_query($con,$sql_insere_cronograma_evento))
		{
			$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
		}
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
if($projeto['fimCronograma'] == 0000-00-00)
{
	$fimCronograma = "";
}
else
{
	$fimCronograma = exibirDataBr($projeto['fimCronograma']);
}
?>
<section id="list_items" class="home-section bg-white">
	<div class="container">
		<?php
    	if($_SESSION['tipoPessoa'] == 1)
		{
			$idPf= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pf.php';
		}
		else
		{
			$idPj= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pj.php';
		}
    	?>
		<div class="form-group">
			<h4>Cronograma</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=cronograma" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-3"><label>Data estimada de início do projeto</label>
							<input type="text" name="inicioCronograma" class="form-control" id="datepicker01" value="<?php
										if(returnEmptyDateCronograma('inicioCronograma', $idProjeto) > 0 ){
											$var = strtotime(returnEmptyDateCronograma('inicioCronograma', $idProjeto));
											echo date("d",$var) . "/";
											echo date("m",$var) . "/";
											echo date("Y",$var);
										} else{
											echo "00/00/0000";
										}?>" required>
						</div>
						<div class="col-md-offset-2 col-md-3"><label>Data estimada do final do projeto</label>
							<input type="text" name="fimCronograma" class="form-control" id="datepicker02" value="<?php
										if(returnEmptyDateCronograma('fimCronograma', $idProjeto) > 0 ){
											$var = strtotime(returnEmptyDateCronograma('fimCronograma', $idProjeto));
											echo date("d",$var) . "/";
											echo date("m",$var) . "/";
											echo date("Y",$var);
										} else{
											echo "00/00/0000";
										}?>" required>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="insere" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/></div>
				</div>

				<?php
				if($projeto['idCronograma'] == 0)
				{
				?>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<form class="form-horizontal" role="form" action="?perfil=cronograma_novo" method="post">
								<input type="submit" value="Inserir detalhes do cronograma" class="btn btn-theme btn-lg btn-block">
							</form>
						</div>
					</div>
				<?php
				}
				if($projeto['idCronograma'] > 0)
				{
					$cronograma = recuperaDados("cronograma","idCronograma",$projeto['idCronograma']);
				?>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<form class="form-horizontal" role="form" action="?perfil=cronograma_edicao" method="post">
								<input type="submit" value="Editar detalhes do cronograma" class="btn btn-theme btn-md btn-block">
							</form>
						</div>
					</div>

					<div class="table-responsive list_info">
						<table class='table table-condensed'>
							<thead>
								<tr class='list_menu'>
									<td colspan='2'>Cronograma</td>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class='list_description'>ETAPA</td>
									<td class='list_description'>MÊS (Período)</td>
								</tr>
								<tr>
									<td class='list_description'>Captação de recursos</td>
									<td class='list_description'><?php echo $cronograma['captacaoRecurso'] ?></td>
								</tr>
								<tr>
									<td class='list_description'>Pré-Produção</td>
									<td class='list_description'><?php echo $cronograma['preProducao'] ?></td>
								</tr>
								<tr>
									<td class='list_description'>Produção</td>
									<td class='list_description'><?php echo $cronograma['producao'] ?></td>
								</tr>
								<tr>
									<td class='list_description'>Pós-Produção</td>
									<td class='list_description'><?php echo $cronograma['posProducao'] ?></td>
								</tr>
								<tr>
									<td class='list_description'>Prestação de Contas</td>
									<td class='list_description'><?php echo $cronograma['prestacaoContas'] ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</section>