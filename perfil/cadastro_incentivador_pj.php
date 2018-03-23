<?php

$con = bancoMysqli();
$idPj = $_SESSION['idUser'];

if(isset($_POST['cadastraNovoPj']))
{
	$razaoSocial = addslashes($_POST['razaoSocial']);
	$cnpj = $_POST['cnpj'];
	$telefone = $_POST['telefone'];
	$celular = $_POST['celular'];
	$email = $_POST['email'];
	$Endereco = $_POST['Endereco'];
	$CEP = $_POST['CEP'];

	$sql_atualiza_pj = "UPDATE incentivador_pessoajuridica SET
	`razaoSocial` = '$razaoSocial',
	`telefone` = '$telefone',
	`celular` = '$celular',
	`email` = '$email',
	`logradouro` = '$Endereco',
	`cep` = '$CEP'
	WHERE `idPj` = '$idPj'";

	if(mysqli_query($con,$sql_atualiza_pj))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
		gravarLog($sql_atualiza_pj);
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao atualizar! Tente novamente.</strong></font> <br/>".$sql_atualiza_pj;
	}
}

$pj = recuperaDados("incentivador_pessoajuridica","idPj",$idPj);
 ?>

			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="form-group">
						<h4>Cadastro de Incentivador<br>
							<small>Pessoa Jurídica</small>
						</h4>
						<h4><?php if(isset($mensagem)){echo $mensagem;};?></h4>
					</div>
					<div class="row">
						<div class="col-md-offset-1 col-md-10">
						<form class="form-horizontal" role="form" action="?perfil=cadastro_incentivador_pj" method="post">
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8"><strong>Razão Social: *</strong><br/>
									<input type="text" class="form-control" name="razaoSocial" placeholder="Razão Social" value="<?= $pj['razaoSocial']?>" required>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-4 col-md-6"><strong>CNPJ: *</strong>
									<input type="text" name="cnpj" class="form-control" id="inputName" placeholder="" value="<?= $pj['cnpj']?>" readonly>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-6"><strong>CEP: *</strong><br/>
									<input type="text" class="form-control" id="CEP" name="CEP" value="<?= $pj['cep']?>" placeholder="CEP" required>
								</div>
								<div class="col-md-6"><strong>Endereço: *</strong><br/>
									<input type="text" class="form-control" id="Endereco" name="Endereco" value="<?= $pj['logradouro']?>" placeholder="Endereco" readonly>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-6"><strong>Telefone: </strong><br/>
									<input type="text" class="form-control" name="telefone"<?= $pj['telefone']?> placeholder="Telefone">
								</div>
								<div class="col-md-6"><strong>Celular: </strong><br/>
									<input type="text" class="form-control" name="celular" value="<?= $pj['celular']?>" placeholder="Celular">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-8"><strong>Email: *</strong><br/>
									<input type="email" class="form-control" name="email" value="<?= $pj['email']?>" placeholder="xxxx@xxxxx.xxx" required>
								</div>
							</div>

							<!-- Botão para Gravar -->
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<input type="hidden" value="<?php echo $busca ?>">
									<input type="hidden" name="cadastraNovoPj">
									<input type="submit" value="Enviar" class="btn btn-theme btn-lg btn-block">
								</div>
							</div>
						</form>
						</div>
					</div>
				</div>
			</section>