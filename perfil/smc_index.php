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
				<div class="modal-body">...</div>
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
		<p align="left"><strong><?php echo saudacao(); ?>, <?php echo $_SESSION['nome']; ?></strong></p>
		<div class="form-group">
			<h5>Inscrições de pessoa física a liberar</h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="table-responsive list_info">
				<?php
					$sql = "SELECT * FROM pessoa_fisica WHERE liberado = 1 LIMIT 0,10";
					$query = mysqli_query($con,$sql);
					$num = mysqli_num_rows($query);
					if($num > 0)
					{
						echo "
							<table class='table table-condensed'>
								<thead>
									<tr class='list_menu'>
										<td>Nome</td>
										<td>CPF</td>
										<td>RG</td>
										<td>Email</td>
										<td>Telefone</td>
										<td width='10%'></td>
									</tr>
								</thead>
								<tbody>";
								while($campo = mysqli_fetch_array($query))
								{
									echo "<tr>";
									echo "<td class='list_description'>".$campo['nome']."</td>";
									echo "<td class='list_description'>".$campo['cpf']."</td>";
									echo "<td class='list_description'>".$campo['rg']."</td>";
									echo "<td class='list_description'>".$campo['email']."</td>";
									echo "<td class='list_description'>".$campo['telefone']."</td>";
									echo "
										<td class='list_description'>
											<form method='POST' action='?perfil=smc_visualiza_perfil_pf'>
												<input type='hidden' name='liberado' value='".$campo['idPf']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
											</form>
										</td>";
								}
							echo "</tr>";
						}
						echo "
							</tbody>
							</table>";
					?>
				</div>
			</div>
		</div>
		<div class="form-group">
			<h5>Inscrições de pessoa jurídica a liberar</h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="table-responsive list_info">
					<?php
					$sql = "SELECT * FROM pessoa_juridica WHERE liberado = 1 LIMIT 0,10";
					$query = mysqli_query($con,$sql);
					$num = mysqli_num_rows($query);
					if($num > 0)
					{
						echo "
							<table class='table table-condensed'>
								<thead>
									<tr class='list_menu'>
										<td>Razão Social</td>
										<td>CNPJ</td>
										<td>Email</td>
										<td>Telefone</td>
										<td width='10%'></td>
									</tr>
								</thead>
								<tbody>";
								while($campo = mysqli_fetch_array($query))
								{
									echo "<tr>";
									echo "<td class='list_description'>".$campo['razaoSocial']."</td>";
									echo "<td class='list_description'>".$campo['cnpj']."</td>";
									echo "<td class='list_description'>".$campo['email']."</td>";
									echo "<td class='list_description'>".$campo['telefone']."</td>";
									echo "
										<td class='list_description'>
											<form method='POST' action='?perfil=smc_visualiza_perfil_pj'>
												<input type='hidden' name='liberado' value='".$campo['idPj']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
											</form>
										</td>";
								}
							echo "</tr>";
						}
						echo "
							</tbody>
							</table>";
					?>
				</div>
			</div>
		</div>
		<div class="form-group">
			<h5>Projetos com data de captação com tempo menor que 30 dias.</h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="table-responsive list_info">
				<?php
					$sql = "SELECT * FROM prazos_projeto AS prz INNER JOIN projeto AS prj ON prj.idProjeto = prz.idProjeto WHERE prj.publicado = 1 AND finalCaptacao != '0000-00-00' AND finalCaptacao BETWEEN CURRENT_DATE()-30 AND CURRENT_DATE() LIMIT 0,10";
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
		<div class="form-group">
			<h5>Projetos com data final menor que 30 dias.</h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="table-responsive list_info">
				<?php
					$sql = "SELECT * FROM prazos_projeto AS prz INNER JOIN projeto AS prj ON prj.idProjeto = prz.idProjeto WHERE prj.publicado = 1 AND finalProjeto !='0000-00-00' AND finalProjeto BETWEEN CURRENT_DATE()-30 AND CURRENT_DATE() LIMIT 0,10";
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
				<div class="table-responsive list_info">
				<?php
					$sql = "SELECT * FROM prazos_projeto AS prz INNER JOIN projeto AS prj ON prj.idProjeto = prz.idProjeto WHERE prj.publicado = 1 AND prestarContas != '0000-00-00' AND prestarContas BETWEEN CURRENT_DATE()-30 AND CURRENT_DATE() LIMIT 0,10";
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