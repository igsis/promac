<?php

include "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";

$con = bancoMysqli();

if(isset($_POST['cadastrar']))
{
	$busca = $_POST['email'];
	$num_busca = 0;
	$telefone = $_POST['telefone'];
	$nome = addslashes($_POST['nome']);
	if($telefone == '' OR $nome == '')
	{
		$mensagem = "<font color='#FF0000'><strong>Por favor, preencha todos os campos!</strong></font>";
	}
	else
	{
		//verifica se há um post
		if(($_POST['senha01'] != "") AND (strlen($_POST['senha01']) >= 5))
		{
			if($_POST['senha01'] == $_POST['senha02'])
			{
				$senha01 = md5($_POST['senha01']);
				$email = $_POST['email'];
				$idFraseSeguranca = $_POST['idFraseSeguranca'];
				$respostaFrase = $_POST['respostaFrase'];
				$sql_cadastra = "INSERT INTO `usuario`(`nome`, `email`, `senha`, `telefone`, `idFraseSeguranca`, `respostaFrase`) VALUES ('$nome', '$email', '$senha01', '$telefone', '$idFraseSeguranca', '$respostaFrase')";
				$query_cadastra = mysqli_query($con,$sql_cadastra);
				if($query_cadastra)
				{
					$mensagem = "<br/><font color='#01DF3A'><strong>Usuário cadastrado com sucesso! Aguarde que você será redirecionado para a página de login...</strong:</font> <!--";
					 echo "<script type=\"text/javascript\">
						  window.setTimeout(\"location.href='index.php';\", 4000);
						</script>";
					gravarLog($sql_cadastra);
				}
				else
				{
					$mensagem = "<font color='#FF0000'><strong>Erro ao cadastrar! Tente novamente.</strong></font>";
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
			$mensagem = "<font color='#FF0000'><strong>A senha não pode estar em branco e deve conter mais de 5 caracteres</strong></font>";
		}
	}
}

/* ESTÁ DANDO ERRO NA VALIDAÇAO DE EMAIL ONLINE
if(isset($_POST['busca']))
{
	$validacao = validaEmail($_POST['busca']);
	if($validacao == false)
	{
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=erro_login.php'>";
	}
	else
	{
		$busca = $_POST['busca'];
		$sql_busca = "SELECT * FROM usuario WHERE email = '$busca' ORDER BY nome";
		$query_busca = mysqli_query($con,$sql_busca);
		$num_busca = mysqli_num_rows($query_busca);
	}
}
*/

if(isset($_POST['busca']))
{
	$busca = $_POST['busca'];
	$sql_busca = "SELECT * FROM usuario WHERE email = '$busca' ORDER BY nome";
	$query_busca = mysqli_query($con,$sql_busca);
	$num_busca = mysqli_num_rows($query_busca);
}

if($num_busca > 0)
{ // Se exisitr, lista a resposta.
?>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>IGSIS - Cadastro de Artistas e Profissionais de Arte e Cultura</title>
			<link href="visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
			<link href="visual/css/style.css" rel="stylesheet" media="screen">
			<link href="visual/color/default.css" rel="stylesheet" media="screen">
			<script src="visual/js/modernizr.custom.js"></script>
		</head>
		<body>
			<section id="list_items" class="home-section bg-white">
				<div class="container">
					<div class="form-group">
						<h3>USUÁRIO JÁ POSSUI CADASTRO</h3>
					</div>
					<div class="row">
						<div class="col-md-offset-1 col-md-10">
							<div class="table-responsive list_info">
								<table class="table table-condensed">
									<thead>
										<tr class="list_menu">
											<td>Nome</td>
											<td>CPF</td>
											<td width="15%"></td>
										</tr>
									</thead>
									<tbody>
									<?php
										while($descricao = mysqli_fetch_array($query_busca))
										{
											echo "
												<tr>
													<td class='list_description'><b>".$descricao['nome']."</b></td>
													<td class='list_description'>".$descricao['email']."</td>
													<td><a href='https://goo.gl/forms/AM7jU1XVDUBUVJXE3'><input type='submit' value='Esqueci a Senha' class='btn btn-theme btn-block'></a></td>
												</tr>
											";
										}
									?>
									</tbody>
								</table>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<a href="index.php"><input type="submit" value="Entrar com outro usuário" class="btn btn-theme btn-block"></a>
								</div>
							</div>

						</div>
					</div>
				</div>
			</section>
		</body>
	</html>

<?php
}
else
{ // se não existir o email, imprime um formulário.
	$busca = $_POST['busca'];
	require "include/script.php";
?>
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>IGSIS - Cadastro de Artistas e Profissionais de Arte e Cultura</title>
			<link href="visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
			<link href="visual/css/style.css" rel="stylesheet" media="screen">
			<link href="visual/color/default.css" rel="stylesheet" media="screen">
			<script src="visual/js/modernizr.custom.js"></script>
		</head>
		<body>
			<div id="bar">
				<p id="p-bar">&nbsp;IGSIS - CADASTRO DE ARTISTAS E PROFISSIONAIS DE ARTE E CULTURA</p>
			</div>
			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="form-group">
						<h3>CADASTRO DE USUÁRIO</h3>
						<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
					</div>
					<div class="row">
						<div class="col-md-offset-1 col-md-10">
						<form class="form-horizontal" role="form" action="login_resultado.php" method="post">
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
									<input type="text" class="form-control" name="nome" placeholder="Nome completo" required>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-6"><strong>Senha: *</strong>
									<input type="password" name="senha01" class="form-control" id="inputName" placeholder="" required>
								</div>
								<div class=" col-md-6"><strong>Redigite a senha: *</strong>
									<input type="password" name="senha02" class="form-control" id="inputEmail" placeholder="" required>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-6"><strong>Telefone *:</strong><br/>
									<input type="text" class="form-control" name="telefone" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" required />
								</div>
								<div class="col-md-6"><strong>Email: *</strong><br/>
									<input type="text" readonly class="form-control" name="email" value="<?php echo $busca ?>" placeholder="Email" required>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-8"><strong>Escolha uma pergunta secreta, para casos de recuperação de senha:</strong><br/>
									<select class="form-control" name="idFraseSeguranca" id="idFraseSeguranca" required>
										<option>Selecione...</option>
										<?php geraOpcao("frase_seguranca","");	?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-8"><strong>Resposta:</strong><br/>
									<input type="text" class="form-control" id="respostaFrase" maxlength="10" name="respostaFrase" required/>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<input type="hidden" name="cadastrar">
									<input type="submit" value="Enviar" class="btn btn-theme btn-lg btn-block">
								</div>
							</div>
						</form>

						</div>
					</div>
				</div>
			</section>
			<?php include "visual/rodape.php" ?>
		</body>
	</html>
<?php
}
?>
