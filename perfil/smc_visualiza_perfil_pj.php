<?php
$con = bancoMysqli();
$tipoPessoa = '2';

$idPj = $_POST['liberado'];
$pj = recuperaDados("pessoa_juridica","idPj",$idPj);

?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
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
			<p align="justify"><strong>Referência:</strong> <?php echo $pj['idPj']; ?></p>
			<p align="justify"><strong>Razão Social:</strong> <?php echo isset($pj['razaoSocial']) ? $pj['razaoSocial'] : null; ?></p>
			<p align="justify"><strong>CNPJ:</strong> <?php echo isset($pj['cnpj']) ? $pj['cnpj'] : null; ?><p>
			<p align="justify"><strong>CCM:</strong> <?php echo isset($pj['ccm']) ? $pj['ccm'] : null; ?><p>
		</div>

		<div class = "page-header">
		 	<h5>Endereço e contato</h5>
		 	<br>
		 </div>

		  <div class="well">
			<p align="justify"><strong>Logradouro:</strong> <?php echo isset($pj['logradouro']) ? $pj['logradouro'] : null; ?></p>
			<p align="justify"><strong>Número:</strong> <?php echo isset($pj['numero']) ? $pj['numero'] : null; ?></p>
			<p align="justify"><strong>Complemento:</strong> <?php echo isset($pj['complemento']) ? $pj['complemento'] : null; ?></p>
			<p align="justify"><strong>CEP:</strong> <?php echo isset($pj['cep']) ? $pj['cep'] : null; ?></p>
			<p align="justify"><strong>Bairro:</strong> <?php echo isset($pj['bairro']) ? $pj['bairro'] : null; ?></p>
			<p align="justify"><strong>Cidade:</strong> <?php echo isset($pj['cidade']) ? $pj['cidade'] : null; ?></p>
			<p align="justify"><strong>Estado:</strong> <?php echo isset($pj['estado']) ? $pj['estado'] : null; ?></p>
			<p align="justify"><strong>Telefone:</strong> <?php echo isset($pj['telefone']) ? $pj['telefone'] : null; ?></p>
			<p align="justify"><strong>Celular:</strong> <?php echo isset($pj['celular']) ? $pj['celular'] : null; ?></p>
			<p align="justify"><strong>Email:</strong> <?php echo isset($pj['email']) ? $pj['email'] : null; ?></p>
		 </div>
		 <div class="table-responsive list_info"><h6>Arquivo(s) de Pessoa Física</h6>
		<?php listaArquivosPessoaEditor($idPj,'2',"smc_visualiza_perfil_pj"); ?>
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
