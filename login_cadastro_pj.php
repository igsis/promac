<?php
require "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";
$busca = $_POST['cnpj'];
$con = bancoMysqli(); // conecta no banco

if(isset($_POST['cadastraNovoPj']))
{
	$razaoSocial = addslashes($_POST['razaoSocial']);
	$email = $_POST['email'];
	$idFraseSeguranca = $_POST['idFraseSeguranca'];
	if($email == '' OR $razaoSocial == '' OR $idFraseSeguranca == 0)
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
			    $sql_email = "SELECT * FROM `pessoa_juridica` WHERE email = '$email'";
			    $query_email = mysqli_query($con, $sql_email);
			    $uniqueEmail = mysqli_num_rows($query_email);
			    if ($uniqueEmail == 0)
			    {
                    $login = $_POST['cnpj'];
                    $senha01 = md5($_POST['senha01']);
                    $idFraseSeguranca = $_POST['idFraseSeguranca'];
                    $respostaFrase = $_POST['respostaFrase'];

                    $sql_senha = "INSERT INTO `pessoa_juridica`(razaoSocial, cnpj, email, senha, idNivelAcesso, idFraseSeguranca, respostaFrase) VALUES ('$razaoSocial', '$login', '$email', '$senha01', '1', '$idFraseSeguranca', '$respostaFrase' )";


                    $query_senha = mysqli_query($con, $sql_senha);


                    $sql_select = "SELECT * FROM pessoa_juridica WHERE cnpj = '$login'";
                    $query_select = mysqli_query($con, $sql_select);
                    $sql_array = mysqli_fetch_array($query_select);
                    $idPessoaJuridica = $sql_array['idPj'];
                    if ($query_senha) {
                        $mensagem = "<font color='#01DF3A'><strong>Usuário cadastrado com sucesso! Aguarde que você será redirecionado para a página de login.</strong></font>";
                        gravarLog($sql_senha);
                        echo "<script type=\"text/javascript\">
                              window.setTimeout(\"location.href='login_pj.php';\", 4000);
                            </script>";
                    } else {
                        $mensagem = "<font color='#FF0000'><strong>Erro ao cadastrar. Tente novamente.</strong></font>";
                    }
                }
                else
                {
                    $mensagem = "<font color='#FF0000'><strong>Email já cadastrado para outro CNPJ. Utilize um diferente</strong></font>";
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
			$mensagem = "<font color='#FF0000'><strong>A senha não pode estar em branco e deve conter mais de 5 caracteres.</strong></font>";
		}
	}
}
?>

<?php include "visual/cabecalho_index.php" ?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
			<h4>Cadastro de Pessoa Jurídica</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="login_cadastro_pj.php" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Razão Social: *</strong><br/>
						<input type="text" class="form-control" name="razaoSocial" placeholder="Razão Social">
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
					<div class="col-md-offset-2 col-md-6"><strong>CNPJ: *</strong><br/>
						<input type="text" readonly class="form-control" name="cnpj" value="<?php echo $busca ?>" placeholder="CNPJ">
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
						<input type="hidden" name="cadastraNovoPj">
						<input type="submit" value="Enviar" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>

			</div>
		</div>
	</div>
</section>
<?php include "visual/rodape_index.php" ?>