<?php
$con = bancoMysqli();
$idPj = $_SESSION['idUser'];

$pj = recuperaDados("pessoa_juridica","idPj",$idPj);

// Edita os dados do representante
if(isset($_POST['apagaRepresentante']))
{
	$idPj = $_POST['apagaRepresentante'];

	$sql_apaga_rep1 = "UPDATE pessoa_juridica SET idRepresentanteLegal = '0'
	WHERE `idPj` = '$idPj'";

	if(mysqli_query($con,$sql_apaga_rep1))
	{
		$mensagem = "<font color='#01DF3A'><strong>Apagado com sucesso!</strong></font>";
		gravarLog($sql_apaga_rep1);
	?>
		<script language="JavaScript">
			window.location = "?perfil=representante_pj";
		</script>
	<?php
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao remover representante! Tente novamente.</strong></font>";
	}
}

if ($pj['idRepresentanteLegal'] == 0) // Não possui representante legal cadastrado
{
?>
	<section id="services" class="home-section bg-white">
		<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
						<h4>Representante Legal</h4>
						<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
						<p><strong>Você está inserindo representante legal </strong></p>
						<p></p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<form method="POST" action="?perfil=representante_pj_resultado_busca" class="form-horizontal" role="form">
						<div class="form-group">
							<div class="col-md-offset-4 col-md-2"><label>Insira o CPF</label>
								<input type="text" name="busca" class="form-control" id="cpf" >
							</div>
							<div class="col-md-2"><label><br/></label>
								<input type="submit" name="pesquisar" class="btn btn-theme btn-md btn-block" value="Pesquisar">
							</div>
						</div>
					</form>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

			</div>
		</div>
	</section>

<?php
}
else
{
	echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=representante_pj_cadastro'>";
}
?>