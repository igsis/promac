<?php
$con = bancoMysqli();
$idPj = $_SESSION['idUser'];

if(isset($_POST['cadastraRepresentante']) || isset($_POST['editaRepresentante']))
{
	$nome = addslashes($_POST['nome']);
	$rg = $_POST['rg'];
	$cpf = $_POST['cpf'];
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
}

// Cadastro um representante que não existe
if(isset($_POST['cadastraRepresentante']))
{
	if($rg == '' OR $nome == '')
	{
		$mensagem = "<font color='#FF0000'><strong>Por favor, preencha todos os campos obrigatórios!</strong></font>";
	}
	else
	{
		$sql_insere_rep1 = "INSERT INTO representante_legal (nome, rg, cpf, telefone, celular, email, logradouro, bairro, cidade, estado, cep, numero, complemento) VALUES ('$nome', '$rg', '$cpf', '$telefone', '$celular', '$email', '$Endereco', '$Bairro', '$Cidade', '$Estado', '$CEP', '$Número', '$Complemento') ";

		if(mysqli_query($con,$sql_insere_rep1))
		{
			$mensagem .= "<font color='#01DF3A'><strong>Cadastrado com sucesso!</strong></font>";
			$idrep1 = recuperaUltimo("representante_legal");
			$sql_representante1_empresa = "UPDATE pessoa_juridica SET idRepresentanteLegal = '$idrep1' WHERE idPj = '$idPj'";
			$query_representante1_empresa = mysqli_query($con,$sql_representante1_empresa);
			if(mysqli_query($con,$sql_insere_rep1))
			{
				$mensagem = "<font color='#01DF3A'><strong>Representante inserido com sucesso na empresa!</strong></font>";
				gravarLog($sql_representante1_empresa);
			}
			else
			{
				$mensagem = "<font color='#FF0000'><strong>Erro ao inserir o representante na empresa! Tente novamente.</strong></font>";
			}
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao cadastrar! Tente novamente.</strong></font>";
		}
	}
}

// Insere um Representante que foi pesquisado
if(isset($_POST['insereRepresentante']))
{
	$idrep1 = $_POST['insereRepresentante'];
	$sql_representante1_empresa = "UPDATE pessoa_juridica SET idRepresentanteLegal = '$idrep1' WHERE idPj = '$idPj'";
	if(mysqli_query($con,$sql_representante1_empresa))
	{
		$mensagem = "<font color='#01DF3A'><strong>Inserido com sucesso!</strong></font>";
		gravarLog($sql_representante1_empresa);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao inserir representante.</strong></font>";
	}
}

// Edita os dados do representante
if(isset($_POST['editaRepresentante']))
{
	if($rg == '' OR $nome == '')
	{
		$mensagem = "<font color='#FF0000'><strong>Por favor, preencha todos os campos obrigatórios!</strong></font>";
	}
	else
	{
		$idrep1 = $_POST['editaRepresentante'];

		$sql_atualiza_rep1 = "UPDATE `representante_legal` SET
		`nome` = '$nome',
		`rg` = '$rg',
		`cpf` = '$cpf',
		`telefone` = '$telefone',
		`celular` = '$celular',
		`email` = '$email',
		`logradouro` = '$Endereco',
		`bairro` = '$Bairro',
		`cidade` = '$Cidade',
		`estado` = '$Estado',
		`cep` = '$CEP',
		`numero` = '$Numero',
		`complemento` = '$Complemento'
		WHERE `idRepresentanteLegal` = '$idrep1'";

		if(mysqli_query($con,$sql_atualiza_rep1))
		{
			$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
			$sql_representante1_empresa = "UPDATE pessoa_juridica SET idRepresentanteLegal = '$idrep1' WHERE idPj = '$idPj'";
			$query_representante1_empresa = mysqli_query($con,$sql_representante1_empresa);
			gravarLog($sql_atualiza_rep1);
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>".$sql_atualiza_rep1;
		}
	}
}

$pj = recuperaDados("pessoa_juridica","idPj",$idPj);
$representante1 = recuperaDados("representante_legal","idRepresentanteLegal",$pj['idRepresentanteLegal']);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<h4>Representante Legal</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=representante_pj_cadastro" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
							<input type="text" class="form-control" name="nome" placeholder="Nome completo" value="<?php echo $representante1['nome']; ?>" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>RG/RNE/PASSAPORTE: *</strong><br/>
							<input type="text" class="form-control" name="rg" placeholder="RG/RNE/PASSAPORTE" value="<?php echo $representante1['rg']; ?>" >
						</div>
						<div class="col-md-6"><strong>CPF: *</strong><br/>
							<input type="text" readonly class="form-control" name="cpf" placeholder="CPF" value="<?php echo $representante1['cpf']; ?>" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>E-mail *:</strong><br/>
							<input type="text" class="form-control" name="email" placeholder="E-mail" value="<?php echo $representante1['email']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Telefone :</strong><br/>
							<input type="text" class="form-control" name="telefone" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $representante1['telefone']; ?>">
						</div>
						<div class="col-md-6"><strong>Celular:</strong><br/>
							<input type="text" class="form-control" name="celular" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $representante1['celular']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><hr/></div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CEP *:</strong><br/>
							<input type="text" class="form-control" id="CEP" name="CEP" placeholder="CEP" value="<?php echo $representante1['cep']; ?>">
						</div>
						<div class="col-md-6" align="left"><i>Clique no número do CEP e pressione a tecla Tab para carregar</i>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Endereço:</strong><br/>
							<input type="text" readonly class="form-control" id="Endereco" name="Endereco" placeholder="Endereço" value="<?php echo $representante1['logradouro']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
							<input type="text" class="form-control" id="Numero" name="Numero" placeholder="Numero" value="<?php echo $representante1['numero']; ?>">
						</div>
						<div class=" col-md-6"><strong>Complemento:</strong><br/>
							<input type="text" class="form-control" id="Complemento" name="Complemento" placeholder="Complemento" value="<?php echo $representante1['complemento']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Bairro:</strong><br/>
							<input type="text" readonly class="form-control" id="Bairro" name="Bairro" placeholder="Bairro" value="<?php echo $representante1['bairro']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Cidade:</strong><br/>
							<input type="text" readonly class="form-control" id="Cidade" name="Cidade" placeholder="Cidade" value="<?php echo $representante1['cidade']; ?>">
						</div>
						<div class="col-md-6"><strong>Estado:</strong><br/>
							<input type="text" readonly class="form-control" id="Estado" name="Estado" placeholder="Estado" value="<?php echo $representante1['estado']; ?>">
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="editaRepresentante" value="<?php echo $representante1['idRepresentanteLegal'] ?>">
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Botão para Trocar o Representante -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<form method='POST' action='?perfil=representante_pj'>
								<input type="hidden" name="apagaRepresentante" value="<?php echo $idPj ?>">
								<input type="submit" value="Trocar o Representante" class="btn btn-theme btn-lg btn-block">
							</form>
						</div>
					</div>

				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=endereco_pj" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</form>
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=arquivos_pj" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>