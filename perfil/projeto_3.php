<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];
$idPf = $_SESSION['idUser'];

if(isset($_POST['insere']))
{
	$resumoProjeto = addslashes($_POST['resumoProjeto']);
	$curriculo = addslashes($_POST['curriculo']);

	$sql_insere = "UPDATE projeto SET
		resumoProjeto = '$resumoProjeto',
		curriculo = '$curriculo'
		WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_insere))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Utilize o menu para avançar.</strong></font>";
		gravarLog($sql_insere);
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
				<form method="POST" action="?perfil=projeto_3" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Resumo do projeto*</label>
							<textarea name="resumoProjeto" class="form-control" rows="5" maxlength="500" required><?php echo $projeto['resumoProjeto'] ?></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Currículo do proponente *</label>
							<textarea name="curriculo" class="form-control" rows="10" maxlength="5000" required><?php echo $projeto['curriculo'] ?></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="insere" class="btn  btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
