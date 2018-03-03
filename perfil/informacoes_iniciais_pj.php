<?php

$con = bancoMysqli();
$idUser = $_SESSION['idUser'];
$tipoPessoa = 2;


if(isset($_POST['cadastrarJuridica']))
{
	$razaoSocial = addslashes($_POST['razaoSocial']);
	$cnpj = $_POST['cnpj'];
	$ccm = $_POST['ccm'];
	$telefone1 = $_POST['telefone1'];
	$telefone2 = $_POST['telefone2'];
	$telefone3 = $_POST['telefone3'];
	$email = $_POST['email'];
	$dataAtualizacao = date("Y-m-d H:i:s");

	$sql_cadastra_pj = "INSERT INTO `pessoa_juridica`(`razaoSocial`, `cnpj`, `ccm`, `telefone1`, `telefone2`, `telefone3`, `email`, `dataAtualizacao`, `idUsuario`) VALUES ('$razaoSocial', '$cnpj', '$ccm', '$telefone1', '$telefone2', '$telefone3', '$email', '$dataAtualizacao', '$idUser')";
	if(mysqli_query($con,$sql_cadastra_pj))
	{
		$mensagem = "<font color='#01DF3A'><strong>Cadastrado com sucesso!</strong></font>";
		gravarLog($sql_cadastra_pj);
		if(isset($_SESSION['idEvento']))
		{
			$idEvento = $_SESSION['idEvento'];
			$sql_ultimo = "SELECT id FROM pessoa_juridica WHERE idUsuario = '$idUser' ORDER BY id DESC LIMIT 0,1";
			$query_ultimo = mysqli_query($con,$sql_ultimo);
			$ultimoPj = mysqli_fetch_array($query_ultimo);
			$idPj = $ultimoPj['id'];

			$sql_atualiza_evento = "UPDATE evento SET idPj = '$idPj', idTipoPessoa = '2' WHERE id = '$idEvento'";
			if(mysqli_query($con,$sql_atualiza_evento))
			{
				$mensagem .= "<font color='#01DF3A'><strong>Empresa inserida no evento.</strong></font><br/>";
				$_SESSION['idPj'] = $idPj;
				gravarLog($sql_atualiza_evento);

			}
			else
			{
				$mensagem .= "<font color='#FF0000'><strong>Erro ao cadastrar no evento!</strong></font>";
			}
		}
		else
		{
			$sql_ultimo = "SELECT id FROM pessoa_juridica WHERE idUsuario = '$idUser' ORDER BY id DESC LIMIT 0,1";
			$query_ultimo = mysqli_query($con,$sql_ultimo);
			$ultimoPj = mysqli_fetch_array($query_ultimo);
			$_SESSION['idPj'] = $ultimoPj['id'];
			$idPj = $_SESSION['idPj'];
		}
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao cadastrar! Tente novamente.</strong></font>";
	}
}

if(isset($_POST['atualizarJuridica']))
{
	$razaoSocial = addslashes($_POST['razaoSocial']);
	$cnpj = $_POST['cnpj'];
	$ccm = $_POST['ccm'];
	$telefone1 = $_POST['telefone1'];
	$telefone2 = $_POST['telefone2'];
	$telefone3 = $_POST['telefone3'];
	$email = $_POST['email'];
	$dataAtualizacao = date("Y-m-d H:i:s");
	$idPj = $_SESSION['idPj'];

	$sql_atualiza_pj = "UPDATE pessoa_juridica SET
	`razaoSocial` = '$razaoSocial',
	`telefone1` = '$telefone1',
	`telefone2` = '$telefone2',
	`telefone3` = '$telefone3',
	`email` = '$email',
	`dataAtualizacao` = 'dataAtualizacao'
	WHERE `id` = '$idPj'";

	if(mysqli_query($con,$sql_atualiza_pj))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
		gravarLog($sql_atualiza_pj);
		if(isset($_SESSION['idEvento']))
		{
			$idEvento = $_SESSION['idEvento'];
			$sql_atualiza_evento = "UPDATE evento SET idPj = '$idPj', idTipoPessoa = '2' WHERE id = '$idEvento'";
			if(mysqli_query($con,$sql_atualiza_evento))
			{
				$mensagem .= "<font color='#01DF3A'><strong>Empresa inserida no evento.</strong></font><br/>";
				gravarLog($sql_atualiza_evento);
			}
			else
			{
				$mensagem .= "<font color='#FF0000'><strong>Erro ao cadastrar no evento!</strong></font>";
			}
		}
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
	}
}

if(isset($_POST['carregar']))
{
	$_SESSION['idPj'] = $_POST['carregar'];
}

$idPj = $_SESSION['idPj'];

$pj = recuperaDados("pessoa_juridica","id",$idPj);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_evento.php'; ?>
		<div class="form-group">
			<h4>PASSO 6: Informações Iniciais</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?perfil=informacoes_iniciais_pj" method="post">
			<!-- Botão para inserir empresa no evento -->
			<?php
				if(isset($_SESSION['idEvento']))
				{
					$evento = recuperaDados("evento","id",$_SESSION['idEvento']);
					if($evento['idPj'] == NULL)
					{
			?>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<input type="hidden" name="atualizarJuridica" value="<?php echo $idPj ?>">
								<input type="submit" value="Inserir empresa no evento" class="btn btn-theme btn-md btn-block">
							</div>
						</div>
			<?php
					}
				}
			?>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Razão Social *:</strong><br/>
						<input type="text" class="form-control" name="razaoSocial" placeholder="Razão Social" value="<?php echo $pj['razaoSocial']; ?>" >
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>CNPJ *:</strong><br/>
						<input type="text" readonly class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" value="<?php echo $pj['cnpj']; ?>" >
					</div>
					<div class="col-md-6"><strong>CCM:</strong><br/>
						<input type="text" class="form-control" id="ccm" name="ccm" placeholder="CCM" value="<?php echo $pj['ccm']; ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Celular *:</strong><br/>
						<input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pj['telefone1']; ?>">
					</div>
					<div class="col-md-6"><strong>Telefone #2:</strong><br/>
						<input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pj['telefone2']; ?>">
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #3:</strong><br/>
						<input type="text" class="form-control" name="telefone3" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pj['telefone3']; ?>" >
					</div>
					<div class="col-md-6"><strong>E-mail *:</strong><br/>
						<input type="text" class="form-control" name="email" placeholder="E-mail" value="<?php echo $pj['email']; ?>" >
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
					<form class="form-horizontal" role="form" action="?perfil=arquivos_pj" method="post">
						<div class="col-md-offset-8 col-md-2">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</section>