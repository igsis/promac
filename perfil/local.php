<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];
/*

if(isset($_POST['apagar']))
{
	$idEvento = $_POST['apagar'];
	$sql_apaga = "UPDATE evento SET publicado = '0' WHERE id = '$idEvento'";
	if(mysqli_query($con,$sql_apaga))
	{
		$mensagem = "<font color='#01DF3A'><strong>Evento apagado com sucesso!</strong></font>";
		gravarLog($sql_apaga);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao apagar evento! Tente novamente.</strong></font>";
	}
}

$tipoPessoa = '2';

if($tipoPessoa = 2)
{
	$idPj = $_SESSION['idUser'];
	$pj = recuperaDados("pessoa_juridica","idPj",$idPj);
}
else
{
	$idPf = $_SESSION['idUser'];
	$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
}
*/
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
										<td width='10%'>Zona</td>
										<td>Local</td>
										<td>Público estimado</td>
										<td width='10%'></td>
										<td width='10%'></td>
									</tr>
								</thead>
								<tbody>";
								while($campo = mysqli_fetch_array($query))
								{
									echo "<tr>";
									echo "<td class='list_description'>".$campo['id']."</td>";
									echo "<td class='list_description'>".$campo['nomeEvento']."</td>";
									echo "<td class='list_description'>".retornaTipo($campo['idTipoEvento'])."</td>";
									echo "<td class='list_description'>".exibirDataHoraBr($campo['dataCadastro'])."</td>";
									echo "S
										<td class='list_description'>
											<form method='POST' action='?perfil=local_edicao'>
												<input type='hidden' name='editar' value='".$campo['id']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='carregar'>
											</form>
										</td>";
									echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=local'>
													<input type='hidden' name='apagar' value='".$campo['id']."' />
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