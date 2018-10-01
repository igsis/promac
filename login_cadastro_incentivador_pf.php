<?php
require "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";
$busca = $_POST['cpf'];
$con = bancoMysqli(); // conecta no banco

if(isset($_POST['cadastraNovoPf']))
{
	$email = $_POST['email'];
	$nome = addslashes($_POST['nome']);
	if($email == '' OR $nome == '')
	{
		$mensagem = "<font color='#FF0000'><strong>Por favor, preencha todos os campos.</strong></font>";
	}
	else
	{
		//verifica se há um post
		if(($_POST['senha01'] != "") AND (strlen($_POST['senha01']) >= 5))
		{
			if($_POST['senha01'] == $_POST['senha02'])
			{
				$senha01 = md5($_POST['senha01']);
				$login = $_POST['cpf'];
				$dataAtualizacao = date("Y-m-d");
				$idFraseSeguranca = $_POST['idFraseSeguranca'];
				$respostaFrase = $_POST['respostaFrase'];
				$sql_senha = "INSERT INTO `incentivador_pessoa_fisica`(nome, cpf, email, senha, idFraseSeguranca, respostaFrase) VALUES ('$nome', '$login', '$email', '$senha01', '$idFraseSeguranca', '$respostaFrase')";
				$query_senha = mysqli_query($con,$sql_senha);
				$sql_select = "SELECT * FROM incentivador_pessoa_fisica WHERE cpf = '$login'";
				$query_select = mysqli_query($con,$sql_select);
				$sql_array = mysqli_fetch_array($query_select);
				$idPessoaFisica = $sql_array['idPf'];
				if($query_senha)
				{
					$mensagem = "<font color='#01DF3A'><strong>Usuário cadastrado com sucesso! Aguarde que você será redirecionado para a página de login.</strong></font>";
					gravarLog($sql_senha);
					 echo "<script type=\"text/javascript\">
						  window.setTimeout(\"location.href='login_incentivador_pf.php';\", 4000);
						</script>";
				}
				else
				{
					$mensagem = "<font color='#FF0000'><strong>Erro ao cadastrar. Tente novamente.</strong></font>";
				}
			}
			else
			{
				// caso não tenha digitado 2 vezes
				$mensagem = "<font color='#FF0000'><strong>As senhas não conferem. Tente novamente.</strong></font>";
			}
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>A senha não pode estar em branco e deve conter mais de 5 caracteres. </strong></font>";
		}
	}
}
?>

<?php include "visual/cabecalho_index.php" ?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
			<h4>Cadastro de Pessoa Física</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="login_cadastro_incentivador_pf.php" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
							<input type="text" class="form-control" name="nome" placeholder="Nome completo">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Senha: *</strong>
							<input type="password" name="senha01" class="form-control" id="inputName" placeholder="">
						</div>
						<div class=" col-md-6"><strong>Redigite a senha: *</strong>
							<input type="password" name="senha02" class="form-control" id="inputEmail" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CPF: *</strong><br/>
							<input type="text" readonly class="form-control" name="cpf" value="<?php echo $busca ?>" placeholder="CPF">
						</div>
						<div class="col-md-6"><strong>E-mail: *</strong><br/>
							<input type="text" class="form-control" name="email" placeholder="E-mail">
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


					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="cadastraNovoPf">
							<input type="submit" value="Enviar" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>
<?php include "visual/rodape_index.php" ?>