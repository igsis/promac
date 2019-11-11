<!-- Conteudo do documento sendo incluido no perfil projeto_pj -->
<div class="form-group">
	<h4>Resumo do Cadastro</h4>
	<div class="alert alert-warning">
		<strong>Atenção!</strong> Confirme atentamente se os dados abaixo estão corretos!
	</div>
	<div class="alert alert-info">
		Após o preenchimento de todos os dados pessoais, conclua a inscrição do proponente e aguarde a análise da sua documentação pela Secretaria Municipal de Cultura.
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
			echo "";
		}
		if ($cporep == true)
		{
			echo "<div class='alert alert-danger'>
					A etapa 'REPRESENTANTE LEGAL' não foi preenchida corretamente.<br/> Revise seu cadastro.
				</div>";
		}
		else
		{
			echo "";
		}
		if ($cpo == false AND $cporep == false)
		{
			echo "<div class='alert alert-success'>
					Todos os campos obrigatórios foram preenchidos corretamente.<br/>
					Conclua sua inscrição ao final da página para enviar suas informações à Secretaria Municipal de Cultura.
				</div>";
		}

	?>
</div>
<div class="page-header">
 	<h5>Dados do Proponente</h5>
</div>
<div class="well">
	<p align="justify"><strong>Razão Social:</strong> <?php echo $pj['razaoSocial']; ?></p>
	<p align="justify"><strong>CNPJ:</strong> <?php echo $pj['cnpj']; ?><p>
	<p align="justify"><strong>Email:</strong> <?php echo $pj['email']; ?><p>
	<p align="justify"><strong>Telefone:</strong> <?php echo $pj['telefone']; ?><p>
	<p align="justify"><strong>Celular:</strong> <?php echo $pj['celular']; ?></p>
	<p align="justify"><strong>Logradouro:</strong> <?php echo $pj['logradouro']; ?></p>
	<p align="justify"><strong>Número:</strong> <?php echo $pj['numero']; ?></p>
	<p align="justify"><strong>Complemento:</strong> <?php echo $pj['complemento']; ?></p>
	<p align="justify"><strong>Bairro:</strong> <?php echo $pj['bairro']; ?></p>
	<p align="justify"><strong>Cidade:</strong> <?php echo $pj['cidade']; ?></p>
	<p align="justify"><strong>Estado:</strong> <?php echo $pj['estado']; ?></p>
	<p align="justify"><strong>CEP:</strong> <?php echo $pj['cep']; ?></p>

	<p align="justify"><strong>É Cooperativa?:</strong>
	<?php
		if ($pj['cooperativa'] == 0)
		{
			echo "Não";
		}
		else
		{
			echo "Sim";
		}
	?>
	</p>
</div>

<div class="table-responsive list_inf">
	<div class = "page-header">
		<h5>Representante Legal</h5>
	</div>
	<div class="well">
		<?php
		if ($pj['idRepresentanteLegal'] == 0)
		{
			echo "Empresa não possui nenhum representante legal";
		}
		else
		{?>
			<p align="justify"><strong>Nome:</strong> <?php echo $rl['nome']; ?></p>
			<p align="justify"><strong>CPF:</strong> <?php echo $rl['cpf']; ?><p>
			<p align="justify"><strong>RG ou RNE: </strong><?php echo $rl['rg']; ?><p>
			<p align="justify"><strong>Email:</strong> <?php echo $rl['email']; ?><p>
			<p align="justify"><strong>Telefone:</strong> <?php echo $rl['telefone']; ?><p>
			<p align="justify"><strong>Celular:</strong> <?php echo $rl['celular']; ?></p>
			<p align="justify"><strong>Logradouro:</strong> <?php echo $rl['logradouro']; ?></p>
			<p align="justify"><strong>Número:</strong> <?php echo $rl['numero']; ?></p>
			<p align="justify"><strong>Complemento:</strong> <?php echo $rl['complemento']; ?></p>
			<p align="justify"><strong>Bairro:</strong> <?php echo $rl['bairro']; ?></p>
			<p align="justify"><strong>Cidade:</strong> <?php echo $rl['cidade']; ?></p>
			<p align="justify"><strong>Estado:</strong> <?php echo $rl['estado']; ?></p>
			<p align="justify"><strong>CEP:</strong> <?php echo $rl['cep']; ?></p>
		<?php
		}
		?>
	</div>
<br>
</div>
