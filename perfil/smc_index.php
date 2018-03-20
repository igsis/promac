<?php
$con = bancoMysqli();
$tipoPessoa = '1';

$idPf = $_SESSION['idUser'];
$pf = recuperaDados("pessoa_fisica","idPf",$idPf);

if(isset($_POST['liberacaoPF']))
{
	?>
	<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php
}

if(isset($_POST['liberacaoPJ']))
{
	$idJuridico = $_POST['LIBPJ'];
	$QueryPJ = "UPDATE pessoa_juridica SET liberado='3' WHERE idPj='$idJuridico'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio)
		echo "<script>alert('O usuário foi ativo com sucesso');</script>";
}
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h5>Projetos com data de captação com tempo menor que 30 dias.</h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><br></div>
					</div>

					<div class="col-md-offset-1 col-md-10">
						<div class="table-responsive list_info">
						<?php
							$sql = "SELECT * FROM prazos_projeto AS prz INNER JOIN projeto AS prj ON prj.idProjeto = prz.idProjeto WHERE prj.publicado = 1 AND finalCaptacao< DATE_ADD(now(), INTERVAL 30 DAY)";
							$query = mysqli_query($con,$sql);
							$num = mysqli_num_rows($query);
							if($num > 0)
							{
								echo "
									<table class='table table-condensed'>
										<thead>
											<tr class='list_menu'>
												<td>Protocolo (nº ISP)</td>
												<td>Prazo de Captação: </td>
												<td>Início da execução:</td>
												<td>Fim da execução:</td>
												<td width='10%'>Ação:</td>
											</tr>
										</thead>
										<tbody>";

										while($campo = mysqli_fetch_array($query))
										{
											echo "<tr>";
											echo "<td class='list_description'>".$campo['protocolo']."</td>";
											echo "<td class='list_description'>".$campo['prazoCaptacao']."</td>";
											echo "<td class='list_description'>".$campo['inicioExecucao']."</td>";
											echo "<td class='list_description'>".$campo['fimExecucao']."</td>";
											$idProjetos = $campo['idProjeto'];
											echo "
												<td class='list_description'>
													<form method='POST' action='?perfil=smc_detalhes_projeto'>
														<input type='hidden' name='idProjeto' value='".$idProjetos."'/>
														<input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
													</form>
												</td>";
											}
											echo "</tr>";
								echo "
									</tbody>
									</table>";
								}
								else{
									echo "Nada consta.";
								}
							?>
						</div>
				</div>
		</div>
	</div>
	<div class="container">
		<div class="form-group">
			<h5>Projetos com data final menor que 30 dias.</h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><br></div>
					</div>

					<div class="col-md-offset-1 col-md-10">
						<div class="table-responsive list_info">
						<?php
							$sql = "SELECT * FROM prazos_projeto AS prz INNER JOIN projeto AS prj ON prj.idProjeto = prz.idProjeto WHERE prj.publicado = 1 AND finalProjeto< DATE_ADD(now(), INTERVAL 30 DAY)";
							$query = mysqli_query($con,$sql);
							$num = mysqli_num_rows($query);
							if($num > 0)
							{
								echo "
									<table class='table table-condensed'>
										<thead>
											<tr class='list_menu'>
												<td>Protocolo (nº ISP)</td>
												<td>Prazo de Captação: </td>
												<td>Início da execução:</td>
												<td>Fim da execução:</td>
												<td width='10%'>Ação:</td>
											</tr>
										</thead>
										<tbody>";

										while($campo = mysqli_fetch_array($query))
										{
											echo "<tr>";
											echo "<td class='list_description'>".$campo['protocolo']."</td>";
											echo "<td class='list_description'>".$campo['prazoCaptacao']."</td>";
											echo "<td class='list_description'>".$campo['inicioExecucao']."</td>";
											echo "<td class='list_description'>".$campo['fimExecucao']."</td>";
											$idProjetos = $campo['idProjeto'];
											echo "
												<td class='list_description'>
													<form method='POST' action='?perfil=smc_detalhes_projeto'>
														<input type='hidden' name='idProjeto' value='".$idProjetos."' />
														<input type ='submit' name='liberacaoPF' class='btn btn-theme btn-block' value='Visualizar'>
													</form>
												</td>";
											}
											echo "</tr>";
								echo "
									</tbody>
									</table>";
								}
								else{
									echo "Nada consta.";
								}
							?>
						</div>
				</div>
		</div>
	</div>

	<div class="container">
		<div class="form-group">
			<h5>Projetos com data para prestar contas faltando 30 dias ou menos.</h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><br></div>
					</div>

					<div class="col-md-offset-1 col-md-10">
						<div class="table-responsive list_info">
						<?php
							$sql = "SELECT * FROM prazos_projeto AS prz INNER JOIN projeto AS prj ON prj.idProjeto = prz.idProjeto WHERE prj.publicado = 1 AND prestarContas < DATE_ADD(now(), INTERVAL 30 DAY)";
							$query = mysqli_query($con,$sql);
							$num = mysqli_num_rows($query);
							if($num > 0)
							{
								echo "
									<table class='table table-condensed'>
										<thead>
											<tr class='list_menu'>
												<td>Protocolo (nº ISP)</td>
												<td>Prazo de Captação: </td>
												<td>Início da execução:</td>
												<td>Fim da execução:</td>
												<td width='10%'>Ação:</td>
											</tr>
										</thead>
										<tbody>";

										while($campo = mysqli_fetch_array($query))
										{ 
											echo "<tr>";
											echo "<td class='list_description'>".$campo['protocolo']."</td>";
											echo "<td class='list_description'>".$campo['prazoCaptacao']."</td>";
											echo "<td class='list_description'>".$campo['inicioExecucao']."</td>";
											echo "<td class='list_description'>".$campo['fimExecucao']."</td>";
											$idProjetos = $campo['idProjeto'];
											echo "
												<td class='list_description'>
													<form method='POST' action='?perfil=smc_detalhes_projeto'>
														<input type='hidden' name='idProjeto' value='".$idProjetos."' />
														<input type ='submit' name='liberacaoPF' class='btn btn-theme btn-block' value='Visualizar'>
													</form>
												</td>";
											}
											echo "</tr>";
								echo "
									</tbody>
									</table>";
								}
								else{
									echo "Nada consta.";
								}
							?>
						</div>
				</div>
		</div>
	</div>
</section>