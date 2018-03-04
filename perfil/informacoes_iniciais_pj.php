<?php

$con = bancoMysqli();
$idPj = $_SESSION['idUser'];


if(isset($_POST['atualizarJuridica']))
{
	$razaoSocial = addslashes($_POST['razaoSocial']);
	$cnpj = $_POST['cnpj'];
	$telefone = $_POST['telefone'];
	$celular = $_POST['celular'];
	$email = $_POST['email'];
	$cooperativa = $_POST['cooperativa'];

	$sql_atualiza_pj = "UPDATE pessoa_juridica SET
	`razaoSocial` = '$razaoSocial',
	`telefone` = '$telefone',
	`celular` = '$celular',
	`email` = '$email',
	`cooperativa` = '$cooperativa'
	WHERE `idPj` = '$idPj'";

	if(mysqli_query($con,$sql_atualiza_pj))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
		gravarLog($sql_atualiza_pj);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
	}
}

$idPj = $_SESSION['idPj'];

$pj = recuperaDados("pessoa_juridica","idPj",$idPj);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_evento.php'; ?>
		<div class="form-group">
			<h4>Informações Iniciais</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=informacoes_iniciais_pj" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Razão Social *:</strong><br/>
							<input type="text" class="form-control" name="razaoSocial" placeholder="Razão Social" value="<?php echo $pj['razaoSocial']; ?>" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CNPJ *:</strong><br/>
							<input type="text" readonly class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" value="<?php echo $pj['cnpj']; ?>" >
						</div>
						<div class="col-md-6"><strong>E-mail *:</strong><br/>
							<input type="text" class="form-control" name="email" placeholder="E-mail" value="<?php echo $pj['email']; ?>" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Telefone :</strong><br/>
							<input type="text" class="form-control" name="telefone" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone']; ?>">
						</div>
						<div class="col-md-6"><strong>Celular:</strong><br/>
							<input type="text" class="form-control" name="celular" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['celular']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-4 col-md-2"><strong>É cooperativa? *</strong> não ta gravando
						</div>
						<div class="col-md-2">
							<input type="checkbox" name="cooperativa" value="on" checked="checked">
						</div>
					</div>

				<!-- Botão para Gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="atualizarJuridica" value="<?php echo $idPj ?>">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>
				<!-- Botão para Prosseguir -->
				<div class="form-group">
					<form class="form-horizontal" role="form" action="?perfil=endereco_pj" method="post">
						<div class="col-md-offset-8 col-md-2">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</section>