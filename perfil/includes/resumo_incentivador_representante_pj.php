<!-- Conteudo do documento sendo incluido no incentivador_concluir_pj -->
<div class="form-group">
	<h4>Resumo do Cadastro</h4>
</div>

<div class="table-responsive list_inf">
	<div class = "page-header">
		<h5>Dados Representante Legal</h5>
	</div>
		<div class="container">
			<div class="well">		<?php
				$rl = recuperaDados("representante_legal","idRepresentanteLegal",$pj['idRepresentanteLegal']);

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
		</div>
	</div>
<br>

