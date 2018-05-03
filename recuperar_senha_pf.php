<?php
	include "visual/cabecalho_index.php";
	include "funcoes/funcoesConecta.php";
	include "funcoes/funcoesGerais.php";
	$con = bancoMysqli();

	$etapa = 1;

	if(isset($_POST['enviarEmail']))
	{	
		$email = $_POST['email'];
		$sql = "SELECT * FROM pessoa_fisica WHERE email = '$email'";
		$query = mysqli_query($con,$sql);
		$num = mysqli_num_rows($query);
		if($num > 0)
		{
			$etapa = 2;
			$pf = recuperaDados("pessoa_fisica","email",$email);
		}
		else
		{
			$mensagem = "<font color='#01DF3A'><strong>E-mail não encontrado em nossa base de dados.</strong></font>";
		}
	}

	if (isset($_POST['enviarResposta']))
	{	
		$email = $_POST['email'];
		$pergunta = $_POST['frase'];
		$resposta = $_POST['resposta'];
		$pf = recuperaDados("pessoa_fisica","email",$email);

	}
?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<h6>ESQUECEU SUA SENHA?</h6>
				<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
				<hr>
				<?php
				if ($etapa == 1)
				{?>

				<!-- Solicitando E-mail -->
				<form method="POST" action="./recuperar_senha_pf.php">
					<div class="col-md-offset-4 col-md-4">
						<div class="form-group">
							<label>Digite Seu E-mail:</label>
							<input type="email" name="email" class="form-control">
						</div>
						<div class="form-group">
							<input type="submit" name="enviarEmail" value="Enviar" class="btn btn-theme btn-md btn-block form-control" required>
						</div>
					</div>
				</form>
		<?php 	}
				else
				{?>

				<!-- Confirmando Pergunta e Resposta -->
				<form method="POST" action="./recuperar_senha_pf.php">
					<div class="col-md-offset-4 col-md-4">
						<div class="form-group">
							<label>Escolha sua Pergunta Secreta:</label>
							<select class="form-control" name="frase" >
								<option value="0"></option>
								<?php echo geraOpcao("frase_seguranca","") ?>
							</select>
						</div>
						<div class="form-group">
							<label>Digite Sua Resposta</label>
							<input type="text" name="resposta" class="form-control">
						</div>
						<div class="form-group">
							<input type="hidden" name="email" value="$pf['email']">
							<input type="submit" name="enviarResposta" value="Enviar" class="btn btn-theme btn-md btn-block form-control">
						</div>
					</div>
				</form>
		<?php 	} ?>
			</div>
		</div>
	</div>
</section>
<?php include "visual/rodape_index.php" ?>