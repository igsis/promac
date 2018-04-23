<?php
$con = bancoMysqli();
$tipoPessoa = '2';

$idPj = $_POST['idPj'];

if(isset($_POST['reaprovar']))
{
	$idPj = $_POST['idPj'];
	$sql = "UPDATE pessoa_juridica SET liberado = 3 WHERE idPj = '$idPj'";
	if(mysqli_query($con,$sql))
	{
		$mensagem = "<font color='#01DF3A'>Cadastro aprovado com sucesso!</font>";
	}
	else
	{
		$mensagem = "<font color='#FF0000'>Erro ao aprovar cadastro. Por favor, tente novamente!</font>";
	}
}

$pj = recuperaDados("pessoa_juridica","idPj",$idPj);
$rl = recuperaDados("representante_legal","idRepresentanteLegal",$pj['idRepresentanteLegal']);
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
			<p align="justify"><strong>Razão Social:</strong> <?php echo isset($pj['razaoSocial']) ? $pj['razaoSocial'] : null; ?></p>
			<p align="justify"><strong>CNPJ:</strong> <?php echo isset($pj['cnpj']) ? $pj['cnpj'] : null; ?><p>
			<p align="justify"><strong>CCM:</strong> <?php echo isset($pj['ccm']) ? $pj['ccm'] : null; ?><p>
			<p align="justify"><strong>Telefone:</strong> <?php echo isset($pj['telefone']) ? $pj['telefone'] : null; ?></p>
			<p align="justify"><strong>Celular:</strong> <?php echo isset($pj['celular']) ? $pj['celular'] : null; ?></p>
			<p align="justify"><strong>Email:</strong> <?php echo isset($pj['email']) ? $pj['email'] : null; ?></p>
			<p align="justify"><strong>Logradouro:</strong> <?php echo isset($pj['logradouro']) ? $pj['logradouro'] : null; ?></p>
			<p align="justify"><strong>Número:</strong> <?php echo isset($pj['numero']) ? $pj['numero'] : null; ?></p>
			<p align="justify"><strong>Complemento:</strong> <?php echo isset($pj['complemento']) ? $pj['complemento'] : null; ?></p>
			<p align="justify"><strong>Bairro:</strong> <?php echo isset($pj['bairro']) ? $pj['bairro'] : null; ?></p>
			<p align="justify"><strong>Cidade:</strong> <?php echo isset($pj['cidade']) ? $pj['cidade'] : null; ?></p>
			<p align="justify"><strong>Estado:</strong> <?php echo isset($pj['estado']) ? $pj['estado'] : null; ?></p>
			<p align="justify"><strong>CEP:</strong> <?php echo isset($pj['cep']) ? $pj['cep'] : null; ?></p>
			<p align="justify"><strong>Cooperativa:</strong> <?php if($pj['cooperativa'] == 1){ echo "Sim"; } else { echo "Não"; } ?></p>
		</div>

		<div class = "page-header">
		 	<h5>Representante Legal</h5>
		 	<br>
		</div>

		<div class="well">
		  	<p align="justify"><strong>Nome:</strong> <?php echo isset($rl['nome']) ? $rl['nome'] : null; ?></p>
			<p align="justify"><strong>CPF:</strong> <?php echo isset($rl['cpf']) ? $rl['cpf'] : null; ?><p>
			<p align="justify"><strong>RG:</strong> <?php echo isset($rl['rg']) ? $rl['rg'] : null; ?><p>
			<p align="justify"><strong>Logradouro:</strong> <?php echo isset($rl['logradouro']) ? $rl['logradouro'] : null; ?></p>
			<p align="justify"><strong>Número:</strong> <?php echo isset($rl['numero']) ? $rl['numero'] : null; ?></p>
			<p align="justify"><strong>Complemento:</strong> <?php echo isset($rl['complemento']) ? $rl['complemento'] : null; ?></p>
			<p align="justify"><strong>Bairro:</strong> <?php echo isset($rl['bairro']) ? $rl['bairro'] : null; ?></p>
			<p align="justify"><strong>Cidade:</strong> <?php echo isset($rl['cidade']) ? $rl['cidade'] : null; ?></p>
			<p align="justify"><strong>Estado:</strong> <?php echo isset($rl['estado']) ? $rl['estado'] : null; ?></p>
			<p align="justify"><strong>CEP:</strong> <?php echo isset($rl['cep']) ? $rl['cep'] : null; ?></p>
		</div>

		<div class="table-responsive list_info">
			<h6>Arquivo(s) de Pessoa Jurídica</h6>
			<?php exibirArquivos($tipoPessoa,$idPj); ?>
		</div>
	</div>

	<!-- Botão -->
	<?php
	if($pj['liberado'] != 3)
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
		echo "<h5><font color='#01DF3A'>".$pj['razaoSocial']." está com a inscrição do proponente aprovada.</font></h5>";
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
					<form class='form-horizontal' role='form' action='?perfil=smc_reaprova_pj' method='post'>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<input type='hidden' name='idPj' value='<?php echo $pj['idPj'] ?>' />
	 					<button type="submit" name="reaprovar" class="btn btn-success" id="confirm">Aprovar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>