<?php
$con = bancoMysqli();
$idUser= $_SESSION['idUser'];


if(isset($_POST['atualizarCadastro']))
{
	$Telefone = addslashes($_POST['telefone']);
	if($Telefone == '')
	{
		$mensagem = "<font color='#FF0000'><strong>Por favor, preencha todos os campos!</strong></font>";
	}
	else
	{
		$idUser = $_POST['atualizarCadastro'];
		$Nome = addslashes($_POST['nome']);
		$Telefone = $_POST['telefone'];
		$Email = $_POST['email'];

		$sql_atualiza_cadastro = "UPDATE usuario SET
		`nome` = '$Nome',
		`telefone` = '$Telefone'
		WHERE `id` = '$idUser'";

		if(mysqli_query($con,$sql_atualiza_cadastro))
		{
			$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
			gravarLog($sql_atualiza_cadastro);
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
		}
	}
}

$usuario = recuperaDados("usuario","id",$idUser);
?>

<section id="contact" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_minhaconta.php'; ?>
		<div class="form-group">
			<h3>MEUS DADOS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idUser; ?> | <b>Nome:</b> <?php echo $usuario['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=minha_conta" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
							<input type="text" class="form-control" name="nome" placeholder="Insira seu nome completo" value="<?php echo $usuario['nome']; ?>" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Telefone *:</strong><br/>
							<input type="text" class="form-control" name="telefone" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $usuario['telefone']; ?>">
						</div>

						<div class="col-md-6"><strong>E-mail *:</strong><br/>
							<input type="text" readonly class="form-control" name="email" placeholder="E-mail" value="<?php echo $usuario['email']; ?>" >
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="atualizarCadastro" value="<?php echo $idUser ?>">
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>