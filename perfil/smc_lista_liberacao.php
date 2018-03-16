<?php
$con = bancoMysqli();
unset($_SESSION['idProjeto']);
$tipoPessoa = '1';
$tipoLiberacao = $_GET['tipo'];
$tipoUsuario = $_SESSION['tipoUsuario'];
$liberado = isset($_GET['liberado']) ? $_GET['liberado'] : null;

$idPf = $_SESSION['idUser'];
$pf = recuperaDados("pessoa_fisica","idPf",$idPf);

if(isset($_POST['liberacaoPF']))
{
	$idFisico = $_POST['LIBPF'];
	$QueryPJ = "UPDATE pessoa_fisica SET liberado='3' WHERE idPf='$idFisico'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio)
		echo "<script>alert('O usuário foi ativo com sucesso');</script>";
}

if(isset($_POST['liberacaoPJ']))
{
	$idJuridico = $_POST['LIBPJ'];
	$QueryPJ = "UPDATE pessoa_juridica SET liberado='3' WHERE idPj='$idJuridico'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio)
		echo "<script>alert('O usuário foi ativo com sucesso');</script>";
}

if($tipoUsuario != 2)
{
	header("Location: visual/index_pf.php");
}
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include '../perfil/includes/menu_interno_pf.php'; ?>
		<center><div class= "alert alert-success" style="width: 70%">
			<strong>ATENÇÃO!</strong> Você deseja liberar <b><a href="../visual/index_pf.php?perfil=smc_lista_liberacao&tipo=1">pessoas físicas</a></b> ou <b><a href="index_pf.php?perfil=smc_lista_liberacao&tipo=2"> pessoas jurídicas</a></b>?
		</div>
		<?php
		if($tipoLiberacao == 1){ ?>
		<div class="form-group">
			<h5>Pessoas físicas</h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><br></div>
					</div>

					<div class="col-md-offset-1 col-md-10">
						<div class="table-responsive list_info">
						<?php
							$sql = "SELECT * FROM pessoa_fisica
									WHERE liberado = 1 
									ORDER BY idPf DESC";
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
											echo "
												<td class='list_description'>
													<form method='POST' action='?perfil=smc_lista_liberacao'>
														<input type='hidden' name='LIBPF' value='".$campo['idPf']."' />
														<input type ='submit' name='liberacaoPF' class='btn btn-theme btn-block' value='Liberar'>
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
	</div>
	<?php } else if($tipoLiberacao == 2){ ?>
		<div class="form-group">
			<h5>Pessoas jurídicas</h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><br></div>
					</div>

					<div class="col-md-offset-1 col-md-10">
						<div class="table-responsive list_info">
						<?php
							$sql = "SELECT * FROM pessoa_juridica
									WHERE liberado = 1 
									ORDER BY idPj DESC";
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
												<td>CCM</td>
												<td>Email</td>
												<td>Telefone</td>
												<td width='10%'></td>
												<td width='10%'></td>
											</tr>
										</thead>
										<tbody>";
										while($campo = mysqli_fetch_array($query))
										{
											echo "<tr>";
											echo "<td class='list_description'>".$campo['razaoSocial']."</td>";
											echo "<td class='list_description'>".$campo['cnpj']."</td>";
											echo "<td class='list_description'>".$campo['ccm']."</td>";	
											echo "<td class='list_description'>".$campo['email']."</td>";
											echo "<td class='list_description'>".$campo['telefone']."</td>";
											echo "
												<td class='list_description'>
													<form method='POST' action='?perfil=smc_visualiza_perfil_pj'>
														<input type='hidden' name='liberado' value='".$campo['idPj']."' />
														<input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
													</form>
												</td>";
											echo "
												<td class='list_description'>
													<form method='POST' action='?perfil=smc_lista_liberacao'>
													<input type='hidden' name='LIBPJ' value='".$campo['idPj']."' />
														<input type ='submit' name='liberacaoPJ' class='btn btn-theme btn-block' value='Liberar'>
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
</div>
<?php } ?>
</section>