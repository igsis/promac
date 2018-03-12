<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

if(isset($_POST['editaCronograma']))
{
	$captacaoRecurso = $_POST['captacaoRecurso'];
	$preProducao = $_POST['preProducao'];
	$producao = $_POST['producao'];
	$posProducao = $_POST['posProducao'];
	$prestacaoContas = $_POST['prestacaoContas'];

	$sql_edita_cronograma = "UPDATE `cronograma` SET
	captacaoRecurso = '$captacaoRecurso',
	preProducao = '$preProducao',
	producao = '$producao',
	posProducao = '$posProducao',
	prestacaoContas = '$prestacaoContas'
	WHERE idCronograma = 'idCronograma'";
	if(mysqli_query($con,$sql_edita_cronograma))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$cronograma = recuperaDados("cronograma","idCronograma",$projeto['idCronograma']);
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
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=cronograma_edicao" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<label>ETAPA</label>
						</div>
						<div class="col-md-6">
							<label>MÊS (Período)</label>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<label>Captação de recursos *</label>
						</div>
						<div class="col-md-6">
							<input type="text" name="captacaoRecurso" class="form-control" maxlength="50" value="<?php echo $cronograma['captacaoRecurso'] ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<label>Pré-Produção *</label>
						</div>
						<div class="col-md-6">
							<input type="text" name="preProducao" class="form-control" maxlength="50" value="<?php echo $cronograma['preProducao'] ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<label>Produção *</label>
						</div>
						<div class="col-md-6">
							<input type="text" name="producao" class="form-control" maxlength="50" value="<?php echo $cronograma['producao'] ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<label>Pós-Produção *</label>
						</div>
						<div class="col-md-6">
							<input type="text" name="posProducao" class="form-control" maxlength="50" value="<?php echo $cronograma['posProducao'] ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<label>Prestação de Contas *</label>
						</div>
						<div class="col-md-6">
							<input type="text" name="prestacaoContas" class="form-control" maxlength="50" value="<?php echo $cronograma['prestacaoContas'] ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="editaCronograma" class="btn btn-theme btn-lg btn-block" value="Inserir">
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>