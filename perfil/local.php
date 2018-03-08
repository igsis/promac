<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

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
									echo "<td class='list_description'>".retornaTipo($campo['idZona'])."</td>";
									echo "<td class='list_description'>
											<form method='POST' action='?perfil=local_edicao'>
												<input type='hidden' name='editar' value='".$campo['idLocal']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='carregar'>
											</form>
										</td>";
									echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=local'>
													<input type='hidden' name='apagar' value='".$campo['idLocal']."' />
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