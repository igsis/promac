<?php
$con = bancoMysqli();
$idUser= $_SESSION['idUser'];
$tipopessoa = $_SESSION['tipoPessoa'];


if(isset($_POST['senha01']))
{
	//verifica se há um post
	if(($_POST['senha01'] != "") AND (strlen($_POST['senha01']) >= 5))
	{
		if($tipopessoa == 1)
		{
			$queryPF = "SELECT senha FROM pessoa_fisica WHERE idPf = '$idUser'";
			$envia = mysqli_query($con, $queryPF);
		} else{
			$queryPJ = "SELECT senha from pessoa_juridica WHERE idPj = '$idUser'";
			$envia = mysqli_query($con, $queryPJ);
		}
		$row = mysqli_fetch_array($envia);
		$senha = $row['senha'];
		if($_POST['senha01'] == $_POST['senha02'])
		{
			if(md5($_POST['senha03']) == $senha)
			{
				$usuario = $_SESSION['idUser'];
				$senha01 = md5($_POST['senha01']);
				if($tipopessoa == 1){
					$sql_senha = "UPDATE `pessoa_fisica` SET `senha` = '$senha01' WHERE `idPf` = '$usuario';";
					$con = bancoMysqli();
					$query_senha = mysqli_query($con,$sql_senha);
				}
				else
				{
					$sql_senha = "UPDATE `pessoa_juridica` SET `senha` = '$senha01' WHERE `idPj` = '$usuario';";
					$con = bancoMysqli();
					$query_senha = mysqli_query($con,$sql_senha);
				}
				if($query_senha)
				{
					$mensagem = "<font color='#01DF3A'><strong>Senha alterada com sucesso!</strong></font>";
					gravarLog($sql_senha);
				}
				else
				{
					$mensagem = "<font color='#FF0000'><strong>Não foi possível mudar a senha! Tente novamente.</strong></font>";

				}
			}
			else
			{
				$mensagem = "<font color='#FF0000'><strong>Senha atual incorreta!</strong></font>";
			}
		}
		else
		{
			// caso não tenha digitado 2 vezes
			$mensagem = "<font color='#FF0000'><strong>As senhas não conferem! Tente novamente.</strong></font>";
		}
	}
	else
	{
			$mensagem = "<font color='#FF0000'><strong>A senha não pode estar vazia e deve conter mais de 5 caracteres.</strong></font>";
	}
}

if(isset($_POST['fraseSeguranca']))
{
	$idFraseSeguranca = $_POST['idFraseSeguranca'];
	$respostaFrase = $_POST['respostaFrase'];
	if($tipopessoa == 1){
		$sql_seguranca_pf = "UPDATE pessoa_fisica SET
		`idFraseSeguranca` = '$idFraseSeguranca',
		`respostaFrase` = '$respostaFrase'
		WHERE `idPf` = '$idUser'";
	} else{
		$sql_seguranca_pf = "UPDATE pessoa_juridica SET
		`idFraseSeguranca` = '$idFraseSeguranca',
		`respostaFrase` = '$respostaFrase'
		WHERE `idPj` = '$idUser'";
	}

	if(mysqli_query($con,$sql_seguranca_pf))
	{
		$mensagem = "<font color='#01DF3A'><strong>Pergunta secreta atualizada com sucesso!</strong></font>";
		gravarLog($sql_seguranca_pf);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar sua pergunta secreta! Tente novamente.</strong></font>";
	}
}

if($tipopessoa == 1)
	$usuario = recuperaDados("pessoa_fisica","idPf",$idUser);
else
	$usuario = recuperaDados("pessoa_juridica","idPj",$idUser);
?>
<section id="contact" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_minhaconta.php'; ?>
		<div class="form-group">
			<h4>Alteração de Senha</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<!-- Redefinição de senha -->
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=senha"class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Insira sua senha antiga para confirmar a mudança.</label>
							<input type="password" name="senha03" class="form-control" id="inputName" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><label>Nova senha</label>
							<input type="password" name="senha01" class="form-control" id="inputName" placeholder="">
						</div>
						<div class=" col-md-6"><label>Redigite a nova senha</label>
							<input type="password" name="senha02" class="form-control" id="inputEmail" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<button type="submit" class="btn btn-theme btn-md btn-block">Mudar a senha</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- Fim Redefinição de Senha -->

		<div class="row"><hr/></div>

		<!-- Pergunta de Segurança -->
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=senha"class="form-horizontal" role="form">
					<h5>Alteração da pergunta de segurança</h5>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8"><strong>Escolha uma pergunta secreta, para casos de recuperação de senha:</strong><br/>
								<select class="form-control" name="idFraseSeguranca" id="idFraseSeguranca">
									<option></option>
									<?php geraOpcao("frase_seguranca",$usuario['idFraseSeguranca'],"");	?>
								</select>
							</div>
						</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Resposta:</strong><br/>
							<input type="text" class="form-control" id="respostaFrase" maxlength="10" name="respostaFrase" placeholder="" value="<?php echo $usuario['respostaFrase']; ?>">
						</div>
					</div>

				<!-- Botão para gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="submit" name ="fraseSeguranca" value="GRAVAR" class="btn btn-theme btn-md btn-block">
					</div>
				</div>
				</form>
				<!-- Fim Pergunta de Segurança -->
			</div>
		</div>
	</div>
</section>