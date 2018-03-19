<!-- Conteudo do documento sendo incluido no perfil projeto_pf -->

<div class="form-group">
	<h4>Resumo do Cadastro</h4>
	<div class="alert alert-warning">
		<strong>Atenção!</strong> Confirme atentamente se os dados abaixo estão corretos!
	</div>
	<?php
		if ($cpo == true)
		{
			echo "<div class='alert alert-danger'>
					Alguns campos obrigatórios não foram preenchidos corretamente.<br/> Revise seu cadastro.
				</div>";
		}
		else
		{
			echo "<div class='alert alert-success'>
					Todos os campos obrigatórios foram preenchidos corretamente.<br/> Seu cadastro de Pessoa Física foi concluído com sucesso!<br> Envie sua solicitação à Secretaria Municipal de Cultura ao final da página!
				</div>";
		}
	?>
	
</div>
 <div class="page-header">
 	<h5>Informações Pessoais</h5>
 </div>
 <div class="well">
	<p align="justify"><strong>Referência:</strong> <?php echo $pf['idPf']; ?></p>
	<p align="justify"><strong>Nome:</strong> <?php echo $pf['nome']; ?></p>
	<p align="justify"><strong>CPF:</strong> <?php echo $pf['cpf']; ?><p>
	<p align="justify"><strong>RG ou RNE: </strong><?php echo $pf['rg']; ?><p>
	<p align="justify"><strong>Email:</strong> <?php echo $pf['email']; ?><p>
	<p align="justify"><strong>Telefone:</strong> <?php echo $pf['telefone']; ?><p>
	<p align="justify"><strong>Celular:</strong> <?php echo $pf['celular']; ?></p>
	<p align="justify"><strong>É Cooperado?:</strong>
		<?php
			if ($pf['cooperado'] == 0)
			{
				echo "Não";
			}
			else
			{
				echo "Sim";
			}
		?></p>
</div>
<div class="table-responsive list_inf">
	<div class = "page-header">
		<h5>Endereço:</h5>
	</div>
	<div class="well">
		<p align="justify"><strong>CEP:</strong> <?php echo $pf['cep']; ?></p>
		<p align="justify"><strong>Logradouro:</strong> <?php echo $pf['logradouro']; ?></p>
		<p align="justify"><strong>Número:</strong> <?php echo $pf['numero']; ?></p>
		<p align="justify"><strong>Complemento:</strong> <?php echo $pf['complemento']; ?></p>
		<p align="justify"><strong>Bairro:</strong> <?php echo $pf['bairro']; ?></p>
		<p align="justify"><strong>Cidade:</strong> <?php echo $pf['cidade']; ?></p>
		<p align="justify"><strong>Estado:</strong> <?php echo $pf['estado']; ?></p>
	</div>
</div>

<div class="table-responsive list_info"><h6>Arquivo(s) de Pessoa Física(s)</h6>
	<?php listaArquivosPessoa($idPf,$tipoPessoa,"arquivos_pf"); ?>
</div>