<?php

$con = bancoMysqli();
$idPf = $_SESSION['idUser'];

if(isset($_POST['cadastraNovoPf']))
{
	$nome = addslashes($_POST['nome']);
	$rg = $_POST['rg'];
	$telefone = $_POST['telefone'];
	$celular = $_POST['celular'];
	$email = $_POST['email'];
	$Endereco = $_POST['Endereco'];
	$CEP = $_POST['CEP'];

	$sql_atualiza_pf = "UPDATE incentivador_pessoafisica SET
	nome = '$nome',
	`rg` = '$rg',
	`telefone` = '$telefone',
	`celular` = '$celular',
	`email` = '$email',
	`logradouro` = '$Endereco',
	`cep` = '$CEP'
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

$pf = recuperaDados("incentivador_pessoafisica","idPf",$idPf);
 ?>

			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="form-group">
						<h4>Cadastro de Incentivador<br>
							<small>Pessoa Física</small>
						</h4>
						<h4><?php if(isset($mensagem)){echo $mensagem;};?></h4>
					</div>
					<div class="row">
						<div class="col-md-offset-1 col-md-10">
						<form class="form-horizontal" role="form" action="?perfil=cadastro_incentivador_pf" method="post">
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
									<input type="text" class="form-control" name="nome" placeholder="Nome completo" value="<?= $pf['nome']?>" required>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-6"><strong>CPF: *</strong>
									<input type="text" name="cpf" class="form-control" id="inputName" placeholder="" value="<?= $pf['cpf']?>" readonly>
								</div>
								<div class=" col-md-6"><strong>RG ou RNE *</strong>
									<input type="text" name="rg" value="<?= $pf['rg']?>" class="form-control" id="inputEmail" placeholder="" required>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-6"><strong>CEP: *</strong><br/>
									<input type="text" class="form-control" id="CEP" name="CEP" value="<?= $pf['cep']?>" placeholder="CEP" required>
								</div>
								<div class="col-md-6"><strong>Endereço: *</strong><br/>
									<input type="text" class="form-control" id="Endereco" name="Endereco" value="<?= $pf['logradouro']?>" placeholder="Endereco" readonly>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-6"><strong>Telefone: </strong><br/>
									<input type="text" class="form-control" name="telefone"<?= $pf['telefone']?> placeholder="Telefone">
								</div>
								<div class="col-md-6"><strong>Celular: </strong><br/>
									<input type="text" class="form-control" name="celular" value="<?= $pf['celular']?>" placeholder="Celular">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-8"><strong>Email: *</strong><br/>
									<input type="email" class="form-control" name="email" value="<?= $pf['email']?>" placeholder="xxxx@xxxxx.xxx" required>
								</div>
							</div>

							<!-- Botão para Gravar -->
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<input type="hidden" value="<?php echo $busca ?>">
									<input type="hidden" name="cadastraNovoPf">
									<input type="submit" value="Enviar" class="btn btn-theme btn-lg btn-block">
								</div>
							</div>
						</form>
						</div>
					</div>
				</div>
			</section>