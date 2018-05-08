<?php
	include "visual/cabecalho_index.php";
	include "funcoes/funcoesConecta.php";
	include "funcoes/funcoesGerais.php";
	$con = bancoMysqli();

	$etapa = 1;
	$tentativa = isset($_POST['tentativa']) ? $_POST['tentativa'] : 0;

	if(isset($_POST['enviarEmail']))
	{	
		$email = $_POST['email'];
		$sql = "SELECT email FROM incentivador_pessoa_juridica WHERE email = '$email'";
		$query = mysqli_query($con,$sql);
		$num = mysqli_num_rows($query);
		if($num > 0)
		{
			$etapa = 2;
			$tentativa = 0;
			$pj = recuperaDados("incentivador_pessoa_juridica","email",$email);
		}
		else
		{
			$mensagem = "<font color='#ff0000'><strong>E-mail não encontrado em nossa base de dados.</strong></font>";
			$tentativa++;
		}
	}

	if (isset($_POST['enviarResposta']))
	{	
		$email = $_POST['email'];
		$frase = $_POST['frase'];
		$resposta = $_POST['resposta'];

		$sql = "SELECT email, idFraseSeguranca, respostaFrase FROM incentivador_pessoa_juridica WHERE email = '$email' AND idFraseSeguranca = '$frase' AND respostaFrase = '$resposta'";
		$query = mysqli_query($con,$sql);
		$num = mysqli_num_rows($query);
		if($num > 0)
		{
			$etapa = 3;
			$tentativa = 0;
			$pj = recuperaDados("incentivador_pessoa_juridica","email",$email);
		}
		else
		{
			$etapa = 2;
			$pj = recuperaDados("incentivador_pessoa_juridica","email",$email);
			$mensagem = "<font color='#ff0000'><strong>Pergunta secreta ou Resposta não confere com a cadastrada em nossa base de dados.</strong></font>";
			$tentativa++;
		}
	}

	if (isset($_POST['enviarSenha']))
	{
		$email = $_POST['email'];
		$idUsuario = $_POST['idPj'];

		if(($_POST['senha01'] != "") AND (strlen($_POST['senha01']) >= 5))
		{
			if($_POST['senha01'] == $_POST['senha02'])
			{
				$senha01 = md5($_POST['senha01']);
				$sql_senha = "UPDATE `incentivador_pessoa_juridica` SET `senha` = '$senha01' WHERE `idPj` = '$idUsuario';";
				$query_senha = mysqli_query($con,$sql_senha);
				
				if($query_senha)
				{
					$mensagem = "<font color='#33cc33'><strong>Senha alterada com sucesso! Aguarde que você será redirecionado para a página de login</strong></font>";
					gravarLogSenha($sql_senha, $idUsuario);
					echo "<script type=\"text/javascript\">
						  window.setTimeout(\"location.href='login_incentivador_pj.php';\", 3000);
						</script>";
				}
				else
				{
					$mensagem = "<font color='#FF0000'><strong>Não foi possível mudar a senha! Tente novamente.</strong></font>";
					echo "<script type=\"text/javascript\">
						  window.setTimeout(\"location.href='recuperar_senha_incentiv_pj.php';\", 3000);
						</script>";
				}
			}
			else
			{
				$etapa = 3;
				$mensagem = "<font color='#FF0000'><strong>Senhas não conferem! Tente novamente.</strong></font>";
				$pj = recuperaDados("incentivador_pessoa_juridica","email",$email);
			}
		}
		else
		{	
			$etapa = 3;
			$mensagem = "<font color='#FF0000'><strong>Senha de conter um minímo de 5 dígitos</strong></font>";
			$pj = recuperaDados("incentivador_pessoa_juridica","email",$email);
		}
	}
?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<h6>ESQUECEU SUA SENHA?</h6>
				<h5><?php if(isset($mensagem)){echo $mensagem;}?></h5>
				<hr>
				
				<?php
					if ($tentativa >= 3)
					{?>
							<div class="col-md-offset-4 col-md-4 form-group">
								<a href="https://drive.google.com/open?id=11W-UF7HakT6lKZt-0qAJ9b0DCactPHsyuLCUSxdcWwo" target="_blank" class="btn btn-theme btn-md btn-block form-control">Utilize nosso Formulário</a>
							</div>
			<?php	}
				if ($etapa == 1)
				{?>

				<!-- Solicitando E-mail -->
				<form method="POST" action="./recuperar_senha_incentiv_pj.php">
					<div class="col-md-offset-4 col-md-4">
						<div class="form-group">
							<label>Digite Seu E-mail:</label>
							<input type="email" name="email" class="form-control">
						</div>
						<div class="form-group">
							<input type="hidden" name="tentativa" value="<?=$tentativa?>">
							<input type="submit" name="enviarEmail" value="Enviar" class="btn btn-theme btn-md btn-block form-control" required>
						</div>
					</div>
				</form>
		<?php 	}
				else if ($etapa == 2)
				{?>

				<!-- Confirmando Pergunta e Resposta -->
				<form method="POST" action="./recuperar_senha_incentiv_pj.php">
					<div class="col-md-offset-4 col-md-4">
						<div class="form-group">
							<label>Escolha sua Pergunta Secreta:</label>
							<select class="form-control" name="frase" >
								<option value="0">Selecione...</option>
								<?php echo geraOpcao("frase_seguranca","") ?>
							</select>
						</div>
						<div class="form-group">
							<label>Digite Sua Resposta</label>
							<input type="text" name="resposta" class="form-control">
						</div>
						<div class="form-group">
							<input type="hidden" name="tentativa" value="<?=$tentativa?>">
							<input type="hidden" name="email" value="<?=$pj['email']?>">
							<input type="submit" name="enviarResposta" value="Enviar" class="btn btn-theme btn-md btn-block form-control">
						</div>
					</div>
				</form>
		<?php 	}
				else
				{?>
					<!-- Setando a nova senha -->
					<form method="POST" action="./recuperar_senha_incentiv_pj.php">
						<div class="col-md-offset-4 col-md-4">
							<div class="form-group">
								<label>Digite sua nova senha:</label>
								<input type="password" name="senha01" class="form-control" required>
							</div>
							<div class="form-group">
								<label>Confirme sua nova senha:</label>
								<input type="password" name="senha02" class="form-control" required>
							</div>
							<div class="form-group">
								<input type="hidden" name="email" value="<?=$pj['email']?>">
								<input type="hidden" name="idPj" value="<?=$pj['idPj']?>">
								<input type="submit" name="enviarSenha" value="Enviar" class="btn btn-theme btn-md btn-block form-control">
							</div>
						</div>
					</form>
		<?php	}?>
			</div>
		</div>
	</div>
</section>
<?php include "visual/rodape_index.php" ?>