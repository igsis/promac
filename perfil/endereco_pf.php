<?php
$con = bancoMysqli();
$idPf = $_SESSION['idUser'];

if(isset($_POST['cadastrarEndereco']))
{
	$idPf = $_POST['cadastrarEndereco'];
	$Endereco = $_POST['Endereco'];
	$Bairro = $_POST['Bairro'];
	$Cidade = $_POST['Cidade'];
	$Estado = $_POST['Estado'];
	$CEP = $_POST['CEP'];
	$Numero = $_POST['Numero'];
	$Complemento = $_POST['Complemento'];

	$sql_atualiza_endereco_pf = "UPDATE pessoa_fisica SET
	`logradouro` = '$Endereco',
	`bairro` = '$Bairro',
	`cidade` = '$Cidade',
	`estado` = '$Estado',
	`cep` = '$CEP',
	`numero` = '$Numero',
	`complemento` = '$Complemento'
	WHERE `idPf` = '$idPf'";

	if(mysqli_query($con,$sql_atualiza_endereco_pf))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
		gravarLog($sql_atualiza_endereco_pf);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>".$sql_atualiza_endereco_pf ;
	}
}

$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include '../perfil/includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h3>ENDEREÇO</h3>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=endereco_pf" method="post">

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
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="cadastrarEndereco" value="<?php echo $idPf ?>">
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=informacoes_iniciais_pf" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
						</form>
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=arquivos_pf" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>