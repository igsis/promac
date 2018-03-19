<?php
$con = bancoMysqli();
$tipoPessoa = '1';
$idPf = isset($_POST['liberado']) ? $_POST['liberado'] : null;
$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">

			<h4>Resumo do Usuário</h4>
			<div class="alert alert-warning">
				<strong>Atenção!</strong> Confirme atentamente se os dados abaixo estão corretos!
			</div>
		</div>
		 <div class = "page-header">
		 	<h5>Informações pessoais</h5>
		 	<br>
		 </div>

		 <div class="well">
			<p align="justify"><strong>Referência:</strong> <?php echo $pf['idPf']; ?></p>
			<p align="justify"><strong>Nome:</strong> <?php echo isset($pf['nome']) ? $pf['nome'] : null; ?></p>
			<p align="justify"><strong>CPF:</strong> <?php echo isset($pf['cpf']) ? $pf['cpf'] : null; ?><p>
			<p align="justify"><strong>RG:</strong> <?php echo isset($pf['rg']) ? $pf['rg'] : null; ?><p>
		</div>

		<div class = "page-header">
		 	<h5>Endereço e contato</h5>
		 	<br>
		 </div>

		  <div class="well">
			<p align="justify"><strong>Logradouro:</strong> <?php echo isset($pf['logradouro']) ? $pf['logradouro'] : null; ?></p>
			<p align="justify"><strong>Número:</strong> <?php echo isset($pf['numero']) ? $pf['numero'] : null; ?></p>
			<p align="justify"><strong>Complemento:</strong> <?php echo isset($pf['complemento']) ? $pf['complemento'] : null; ?></p>
			<p align="justify"><strong>CEP:</strong> <?php echo isset($pf['cep']) ? $pf['cep'] : null; ?></p>
			<p align="justify"><strong>Bairro:</strong> <?php echo isset($pf['bairro']) ? $pf['bairro'] : null; ?></p>
			<p align="justify"><strong>Cidade:</strong> <?php echo isset($pf['cidade']) ? $pf['cidade'] : null; ?></p>
			<p align="justify"><strong>Estado:</strong> <?php echo isset($pf['estado']) ? $pf['estado'] : null; ?></p>
			<p align="justify"><strong>Telefone:</strong> <?php echo isset($pf['telefone']) ? $pf['telefone'] : null; ?></p>
			<p align="justify"><strong>Celular:</strong> <?php echo isset($pf['celular']) ? $pf['celular'] : null; ?></p>
			<p align="justify"><strong>Email:</strong> <?php echo isset($pf['email']) ? $pf['email'] : null; ?></p>
		 </div>
		 <div class="table-responsive list_info"><h6>Arquivo(s) de Pessoa Física</h6>
		<?php 
		$query = "SELECT idProjeto FROM projeto WHERE idPf='$idPf' AND publicado = '1'";
		$send = mysqli_query($con, $query);
		$row = mysqli_fetch_array($send);
		listaArquivosPessoaEditor($pf['idPf'],$tipoPessoa,"smc_visualiza_perfil_pf"); ?>
		</div>
	</div>

<!-- Botão para Prosseguir -->
	<div class="form-group">
		<div class="col-md-offset-5 col-md-2">
			<form class="form-horizontal" role="form" action="?perfil=smc_lista_liberacao" method="post">
				<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block">
			</form>
		</div>
	</div>
</section>
