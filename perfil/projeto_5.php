<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];
$bool = false;

if(isset($_POST['insere']))
{
	$justificativa = $_POST['justificativa'];
	$objetivo = $_POST['objetivo'];

	$sql_insere = "UPDATE projeto SET
		justificativa = '$justificativa',
		objetivo = '$objetivo'
		WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_insere))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
		$bool = true;
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}


$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
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
			<h4>Cadastro de Projeto</h4>
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=projeto_5" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Justficativa do projeto*</label>
							<textarea name="justificativa" class="form-control" rows="10" required><?php echo $projeto['justificativa'] ?></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Objetivos e metas*</label>
							<textarea name="objetivo" class="form-control" rows="10" required><?php echo $projeto['objetivo'] ?></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="insere" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>
				<!-- Botão para Prosseguir -->
				<div class="form-group">
					<?php if($bool == true)
					{ ?>
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=projeto_4" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block">
						</form>
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=projeto_6" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block">
						</form>
					</div>
				</div>
				<?php } 
				else { ?>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="alert alert-info">
							Grave suas informações para prosseguir o formulário.
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section>