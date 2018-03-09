<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

if(isset($_POST['insereLocal']))
{
	$local = $_POST['local'];
	$estimativaPublico = $_POST['estimativaPublico'];
	$idZona = $_POST['idZona'];

	$sql_insere_local = "INSERT INTO `locais_realizacao`(`idProjeto`, `local`, `estimativaPublico`, `idZona`, `publicado`) VALUES ('$idProjeto', '$local', '$estimativaPublico', '$idZona', 1)";

	if(mysqli_query($con,$sql_insere_local))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}

if(isset($_POST['editaLocal']))
{
	$idLocaisRealizacao = $_POST['editaLocal'];
	$local = $_POST['local'];
	$estimativaPublico = $_POST['estimativaPublico'];
	$idZona = $_POST['idZona'];

	$sql_edita_local = "UPDATE `locais_realizacao` SET
	`local`= '$local',
	`estimativaPublico`= '$estimativaPublico',
	`idZona`= '$idZona'
	WHERE idLocaisRealizacao = 'idLocaisRealizacao'";
	if(mysqli_query($con,$sql_edita_local))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}

if(isset($_POST['apagaLocal']))
{
	$idLocaisRealizacao = $_POST['apagaLocal'];

	$sql_apaga_local = "UPDATE `locais_realizacao` SET publicado = 0 WHERE idLocaisRealizacao = '$idLocaisRealizacao'";
	if(mysqli_query($con,$sql_apaga_local))
	{
		$mensagem = "<font color='#01DF3A'><strong>Apagado com sucesso!</strong></font>";
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao apagar! Tente novamente.</strong></font>";
	}
}

?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include '../perfil/includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h4>Local de Realização</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<form class="form-horizontal" role="form" action="?perfil=local_novo" method="post">
							<input type="submit" value="Inserir novo local" class="btn btn-theme btn-lg btn-block">
						</form>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8"><br></div>
			</div>
			<div class="col-md-offset-1 col-md-10">
				<div class="table-responsive list_info">
				<?php
					$sql = "SELECT * FROM locais_realizacao
							WHERE publicado = 1 AND idProjeto = '$idProjeto'";
					$query = mysqli_query($con,$sql);
					$num = mysqli_num_rows($query);
					if($num > 0)
					{
						echo "
							<table class='table table-condensed'>
								<thead>
									<tr class='list_menu'>
										<td>Local</td>
										<td>Público estimado</td>
										<td>Zona</td>
										<td width='10%'></td>
										<td width='10%'></td>
									</tr>
								</thead>
								<tbody>";
								while($campo = mysqli_fetch_array($query))
								{
									echo "<tr>";
									echo "<td class='list_description'>".$campo['local']."</td>";
									echo "<td class='list_description'>".$campo['estimativaPublico']."</td>";
									echo "<td class='list_description'>".$campo['idZona']."</td>";
									echo "<td class='list_description'>
											<form method='POST' action='?perfil=local_edicao'>
												<input type='hidden' name='editarLocal' value='".$campo['idLocaisRealizacao']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='editar'>
											</form>
										</td>";
									echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=local'>
													<input type='hidden' name='apagaLocal' value='".$campo['idLocaisRealizacao']."' />
													<input type ='submit' class='btn btn-theme  btn-block' value='apagar'>
												</form>
											</td>";
									echo "</tr>";
								}
								echo "
							</tbody>
							</table>";
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>