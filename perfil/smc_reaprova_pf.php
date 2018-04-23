<?php
$con = bancoMysqli();
$tipoPessoa = '1';

$idPf = $_POST['idPf'];

if(isset($_POST['reaprovar']))
{
	$idPf = $_POST['idPf'];
	$sql = "UPDATE pessoa_fisica SET liberado = 3 WHERE idPf = '$idPf'";
	if(mysqli_query($con,$sql))
	{
		$mensagem = "<font color='#01DF3A'>Cadastro aprovado com sucesso!</font>";
	}
	else
	{
		$mensagem = "<font color='#FF0000'>Erro ao aprovar cadastro. Por favor, tente novamente!</font>";
	}
}

$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<div class="alert alert-warning">
				<strong>Atenção!</strong> Confirme atentamente se os dados abaixo estão corretos!
			</div>
		</div>
		<div class = "page-header">
		 	<h5>Dados do proponente</h5>
		 	<h4><?php if(isset($mensagem)) echo $mensagem; ?></h4>
		</div>
		<div class="well">
			<p align="justify"><strong>Nome:</strong> <?php echo isset($pf['nome']) ? $pf['nome'] : null; ?></p>
			<p align="justify"><strong>CPF:</strong> <?php echo isset($pf['cpf']) ? $pf['cpf'] : null; ?><p>
			<p align="justify"><strong>RG:</strong> <?php echo isset($pf['rg']) ? $pf['rg'] : null; ?><p>
			<p align="justify"><strong>Telefone:</strong> <?php echo isset($pf['telefone']) ? $pf['telefone'] : null; ?></p>
			<p align="justify"><strong>Celular:</strong> <?php echo isset($pf['celular']) ? $pf['celular'] : null; ?></p>
			<p align="justify"><strong>Email:</strong> <?php echo isset($pf['email']) ? $pf['email'] : null; ?></p>
			<p align="justify"><strong>Logradouro:</strong> <?php echo isset($pf['logradouro']) ? $pf['logradouro'] : null; ?></p>
			<p align="justify"><strong>Número:</strong> <?php echo isset($pf['numero']) ? $pf['numero'] : null; ?></p>
			<p align="justify"><strong>Complemento:</strong> <?php echo isset($pf['complemento']) ? $pf['complemento'] : null; ?></p>
			<p align="justify"><strong>Bairro:</strong> <?php echo isset($pf['bairro']) ? $pf['bairro'] : null; ?></p>
			<p align="justify"><strong>Cidade:</strong> <?php echo isset($pf['cidade']) ? $pf['cidade'] : null; ?></p>
			<p align="justify"><strong>Estado:</strong> <?php echo isset($pf['estado']) ? $pf['estado'] : null; ?></p>
			<p align="justify"><strong>CEP:</strong> <?php echo isset($pf['cep']) ? $pf['cep'] : null; ?></p>
		</div>
		<div class="table-responsive list_info">
			<h6>Arquivo(s) de Pessoa Física</h6>
			<?php exibirArquivos($tipoPessoa,$idPf); ?>
		</div>
	</div>

	<!-- Botão -->
	<?php
	if($pf['liberado'] != 3)
	{
	?>
		<div class="form-group">
			<div class='col-md-offset-5 col-md-2'>
				<!-- Button para ativar modal -->
				<button type="button" class='btn btn-theme btn-lg btn-block' data-toggle="modal" data-target="#myModal">
					Aprovar
				</button>
			</div>
		</div>
	<?php
	}
	else
	{
		echo "<h5><font color='#01DF3A'>".$pf['nome']." está com a inscrição do proponente aprovada.</font></h5>";
	}
	?>

	<!-- Modal de aviso -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-danger" id="myModalLabel">Atenção</h4>
				</div>
				<div class="modal-body">
					<p>Tem certeza que deseja aprovar um cadastro que não está liberado?</p>
				</div>
				<div class="modal-footer">
					<form class='form-horizontal' role='form' action='?perfil=smc_reaprova_pf' method='post'>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<input type='hidden' name='idPf' value='<?php echo $pf['idPf'] ?>' />
	 					<button type="submit" name="reaprovar" class="btn btn-success" id="confirm">Aprovar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>