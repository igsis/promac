﻿<?php

$con = bancoMysqli();
$idPf = $_SESSION['idUser'];


if(isset($_POST['atualizarFisica']))
{
	$nome = addslashes($_POST['nome']);
	$rg = $_POST['rg'];
	$telefone = $_POST['telefone'];
	$celular = $_POST['celular'];
	$email = $_POST['email'];
	$Endereco = $_POST['Endereco'];
	$Bairro = $_POST['Bairro'];
	$Cidade = $_POST['Cidade'];
	$Estado = $_POST['Estado'];
	$CEP = $_POST['CEP'];
	$Numero = $_POST['Numero'];
	$Complemento = $_POST['Complemento'];
	if(isset($_POST['cooperado']))
	{
		$cooperado = $_POST['cooperado'];
	}
	else
	{
		$cooperado = 0;
	}

	$sql_atualiza_pf = "UPDATE pessoa_fisica SET
	`nome` = '$nome',
	`rg` = '$rg',
	`telefone` = '$telefone',
	`celular` = '$celular',
	`email` = '$email',
	`logradouro` = '$Endereco',
	`bairro` = '$Bairro',
	`cidade` = '$Cidade',
	`estado` = '$Estado',
	`cep` = '$CEP',
	`numero` = '$Numero',
	`complemento` = '$Complemento',
	`cooperado` = '$cooperado'
	WHERE `idPf` = '$idPf'";

	if(mysqli_query($con,$sql_atualiza_pf))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
		gravarLog($sql_atualiza_pf);
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao atualizar! Tente novamente.</strong></font> <br/>".$sql_atualiza_pf;
	}
}

$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h4>Informações Iniciais</h4>
				<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=informacoes_iniciais_pf" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
							<input type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $pf['nome']; ?>" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CPF *:</strong><br/>
							<input type="text" readonly class="form-control" id="cpf" name="cpf" placeholder="CPF" value="<?php echo $pf['cpf']; ?>" >
						</div>
						<div class="col-md-6"><strong>RG ou RNE *:</strong><br/>
							<input type="text" class="form-control" name="rg" placeholder="Número do Documento" value="<?php echo $pf['rg']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>E-mail *:</strong><br/>
							<input type="text" class="form-control" name="email" placeholder="E-mail" value="<?php echo $pf['email']; ?>">
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
						<div class="col-md-offset-2 col-md-8"><hr/></div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CEP *:</strong><br/>
							<input type="text" class="form-control" id="CEP" name="CEP" placeholder="CEP" value="<?php echo $pf['cep']; ?>">
						</div>
						<div class="col-md-6" align="left"><i>Clique no número do CEP e pressione a tecla Tab para carregar</i>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Endereço:</strong><br/>
							<input type="text" readonly class="form-control" id="Endereco" name="Endereco" placeholder="Endereço" value="<?php echo $pf['logradouro']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
							<input type="text" class="form-control" id="Numero" name="Numero" placeholder="Numero" value="<?php echo $pf['numero']; ?>">
						</div>
						<div class=" col-md-6"><strong>Complemento:</strong><br/>
							<input type="text" class="form-control" id="Complemento" name="Complemento" placeholder="Complemento" value="<?php echo $pf['complemento']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Bairro:</strong><br/>
							<input type="text" readonly class="form-control" id="Bairro" name="Bairro" placeholder="Bairro" value="<?php echo $pf['bairro']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Cidade:</strong><br/>
							<input type="text" readonly class="form-control" id="Cidade" name="Cidade" placeholder="Cidade" value="<?php echo $pf['cidade']; ?>">
						</div>
						<div class="col-md-6"><strong>Estado:</strong><br/>
							<input type="text" readonly class="form-control" id="Estado" name="Estado" placeholder="Estado" value="<?php echo $pf['estado']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-4 col-md-2">
							<strong>É cooperado? *</strong>
						</div>
						<div class="col-md-2">
							<input type="checkbox" name="cooperado" value="1" <?php checar($pf['cooperado']) ?> >
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="atualizarFisica" value="<?php echo $idPf ?>">
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Botão para Prosseguir -->
				<div class="form-group">
					<form class="form-horizontal" role="form" action="?perfil=arquivos_pf" method="post">
						<div class="col-md-offset-8 col-md-2">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</section>
