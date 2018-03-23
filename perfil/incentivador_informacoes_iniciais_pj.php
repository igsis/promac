<?php

$con = bancoMysqli();
$idPj = $_SESSION['idUser'];


if(isset($_POST['atualizarJuridica'])){
	
	$razaoSocial = addslashes($_POST['razaoSocial']);
	$cnpj = $_POST['cnpj'];
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

	$sql_atualiza_pj = "UPDATE incentivador_pessoajuridica SET
	`razaoSocial` = '$razaoSocial',
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
	WHERE `idPj` = '$idPj'";

	if(mysqli_query($con,$sql_atualiza_pj))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso! Utilize o menu para avançar.</strong></font>";
		gravarLog($sql_atualiza_pj);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
	}
}

$pj = recuperaDados("incentivador_pessoajuridica","idPj",$idPj);

if($pj['liberado'] == 3)
{
	echo "<div class='alert alert-warning'>
  	<strong>Aviso!</strong> Seus dados já foram aceitos, portanto, não podem ser alterados.</div>";

  	include 'resumo_usuario.php';
}
else{
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<h4>Proponente</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=incentivador_informacoes_iniciais_pj" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Razão Social *:</strong><br/>
							<input type="text" class="form-control" name="razaoSocial" placeholder="Razão Social" value="<?php echo $pj['razaoSocial']; ?>" required>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CNPJ *:</strong><br/>
							<input type="text" readonly class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" value="<?php echo $pj['cnpj']; ?>" required>
						</div>
						<div class="col-md-6"><strong>E-mail *:</strong><br/>
							<input type="text" class="form-control" name="email" placeholder="E-mail" value="<?php echo $pj['email']; ?>" required>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Telefone :</strong><br/>
							<input type="text" class="form-control" name="telefone" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pj['telefone']; ?>">
						</div>
						<div class="col-md-6"><strong>Celular:</strong><br/>
							<input type="text" class="form-control" name="celular" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pj['celular']; ?>">
						</div>
					</div>

					<div class="form-group">
							<div class="col-md-offset-2 col-md-8"><hr/></div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CEP *:</strong><br/>
							<input type="text" class="form-control" id="CEP" name="CEP" placeholder="CEP" value="<?php echo $pj['cep']; ?>" required>
						</div>
						<div class="col-md-6" align="left"><br/><i>Pressione a tecla Tab para carregar</i>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Endereço:</strong><br/>
							<input type="text" readonly class="form-control" id="Endereco" name="Endereco" placeholder="Endereço" value="<?php echo $pj['logradouro']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
							<input type="text" class="form-control" id="Numero" name="Numero" placeholder="Numero" value="<?php echo $pj['numero']; ?>" required>
						</div>
						<div class=" col-md-6"><strong>Complemento:</strong><br/>
							<input type="text" class="form-control" id="Complemento" name="Complemento" placeholder="Complemento" value="<?php echo $pj['complemento']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Bairro:</strong><br/>
							<input type="text" readonly class="form-control" id="Bairro" name="Bairro" placeholder="Bairro" value="<?php echo $pj['bairro']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Cidade:</strong><br/>
							<input type="text" readonly class="form-control" id="Cidade" name="Cidade" placeholder="Cidade" value="<?php echo $pj['cidade']; ?>">
						</div>
						<div class="col-md-6"><strong>Estado:</strong><br/>
							<input type="text" readonly class="form-control" id="Estado" name="Estado" placeholder="Estado" value="<?php echo $pj['estado']; ?>">
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="atualizarJuridica" value="<?php echo $idPj ?>">
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>
<?php } ?>