<?php 
$con  = bancoMysqli();
$conn = bancoPDO();


$nome = isset($_POST['nome'])?$_POST['nome']:null;
$cpf  = isset($_POST['cpf'])?$_POST['cpf']:null;
$razaoSocial = isset($_POST['razaoSocial'])? $_POST['razaoSocial']:null;
$cnpj = isset($_POST['cnpj'])?$_POST['cnpj']:null;


if($nome != '' || $cpf != '')
{
	if($nome != '')
	{
		$filtro_nome = "nome LIKE '%$nome%'";
	}
	else
	{
		$filtro_nome = "";
	}

	if($cpf != '')
	{
		$filtro_cpf = "cpf = '$cpf'";
	}
	else
	{
		$filtro_cpf = "";
	}

	if ($filtro_nome != '' && $filtro_cpf != '')
	{
		$filtro = " AND ";
	}
	else
	{
		$filtro = '';
	}

}
if(isset($_POST['pesquisarPf'])){
	$sql = "SELECT * FROM pessoa_fisica 
			WHERE $filtro_cpf $filtro $filtro_nome";

	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll();

}
if (isset($_POST['alterarPf'])) {
	$id = $_POST['id'];
	$idNivelAcesso = $_POST['idNivelAcesso'];
	$sql_atualizar = "UPDATE pessoa_fisica SET
		idNivelAcesso = :idNivelAcesso
 		WHERE idPf = :idPf ";
 	$stmt = $conn->prepare($sql_atualizar);
 	$stmt->bindParam(':idPf', $id);
 	$stmt->bindParam(':idNivelAcesso', $idNivelAcesso);
 	$stmt->execute();

 	$sql = "SELECT * FROM pessoa_fisica 
		WHERE idPf = $id ";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll();
}

if($razaoSocial != '' || $cnpj != '')
{
	if($razaoSocial != '')
	{
		$filtro_razaoSocial = "razaoSocial LIKE '%$razaoSocial%'";
	}
	else
	{
		$filtro_razaoSocial = "";
	}

	if($cnpj != '')
	{
		$filtro_cnpj = "cnpj = '$cnpj'";
	}
	else
	{
		$filtro_cnpj = "";
	}

	if ($razaoSocial != '' && $cnpj != '')
	{
		$filtro = " AND ";
	}
	else
	{
		$filtro = '';
	}
}
if(isset($_POST['pesquisarPj'])){
	$sql = "SELECT * FROM pessoa_juridica
			WHERE $filtro_cnpj $filtro $filtro_razaoSocial";

	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll();

}
if (isset($_POST['alterarPj'])) {
	$id = $_POST['id'];
	$idNivelAcesso = $_POST['idNivelAcesso'];
	$sql_atualizar = "UPDATE pessoa_juridica SET
		idNivelAcesso = :idNivelAcesso
 		WHERE idPj = :idPj ";
 	$stmt = $conn->prepare($sql_atualizar);
 	$stmt->bindParam(':idPj', $id);
 	$stmt->bindParam(':idNivelAcesso', $idNivelAcesso);
 	$stmt->execute();

 	$sql = "SELECT * FROM pessoa_juridica 
		WHERE idPj = $id ";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$result = $stmt->fetchAll();
}

if($nome == true || $cpf == true || isset($_POST['alterarPf'])){
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Resultado da Busca</h4><hr>
			<h5><a href="?perfil=smc_pesquisa_nome">Fazer outra busca</a></h5>
			<div class="col-md-offset-2 col-md-8">
				<div class="table-responsive list_info">
					<table class='table table-condensed table-hover text-center'>
						<thead>
							<tr class='list_menu'>
								<td>ID</td>
								<td>Nome</td>
								<td>CPF</td>
								<td>Tipo Acesso</td>
								<td width='15%'></td>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($result as $value)
							{
								if ($value['idNivelAcesso'] == 1) {
									$acesso = 'Proponente';
								}elseif ($value['idNivelAcesso'] == 2){
									$acesso = 'SMC';
								}elseif ($value['idNivelAcesso'] == 3) {
									$acesso = 'Comissão';
								}else {
									$acesso = '';
								}
								echo "<form method='POST' action=''>";
								echo "<tr>";
								echo "<td class='list_description'>".$value['idPf']."</td>";
								echo "<td class='list_description'>".$value['nome']."</td>";
								echo "<td class='list_description'>".$value['cpf']."</td>";
								echo "<td class='list_description'>
										<select class='form-control' name='idNivelAcesso'>
											<option value='".$value['idNivelAcesso']."'>".$acesso."</option>
											<option value='1'>Proponente</option>
											<option value='2'>SMC</option>
											<option value='3'>Comissão</option>									
										</select>
									</td>";
								echo "<td class='list_description'>
										<input type='hidden' name='id' value='".$value['idPf']."' />
										<input type ='submit' name='alterarPf' class='btn btn-theme btn-block btn-sm' value='alterar'>						
									</td>";				
								echo "</tr>";
								echo "</form>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>	
		</div>		
	</div>
</section>
<?php 
	}elseif ($razaoSocial == true || $cnpj == true || isset($_POST['alterarPj'])){
	
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Resultado da Busca</h4><hr>
			<h5><a href="?perfil=smc_pesquisa_nome">Fazer outra busca</a></h5>
			<div class="col-md-offset-2 col-md-8">
				<div class="table-responsive list_info">
					<table class='table table-condensed table-hover text-center'>
						<thead>
							<tr class='list_menu'>
								<td>ID</td>
								<td>Razão Social</td>
								<td>CNPJ</td>
								<td>Tipo Acesso</td>
								<td width='15%'></td>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($result as $value)
							{
								if ($value['idNivelAcesso'] == 1) {
									$acesso = 'Proponente';
								}elseif ($value['idNivelAcesso'] == 2){
									$acesso = 'SMC';
								}elseif ($value['idNivelAcesso'] == 3) {
									$acesso = 'Comissão';
								}else {
									$acesso = '';
								}
								echo "<form method='POST' action=''>";
								echo "<tr>";
								echo "<td class='list_description'>".$value['idPj']."</td>";
								echo "<td class='list_description'>".$value['razaoSocial']."</td>";
								echo "<td class='list_description'>".$value['cnpj']."</td>";
								echo "<td class='list_description'>
										<select class='form-control' name='idNivelAcesso'>
											<option value='".$value['idNivelAcesso']."'>".$acesso."</option>
											<option value='1'>Proponente</option>
											<option value='2'>SMC</option>
											<option value='3'>Comissão</option>								
										</select>
									</td>";
								echo "<td class='list_description'>
										<input type='hidden' name='id' value='".$value['idPj']."' />
										<input type ='submit' name='alterarPj' class='btn btn-theme btn-block btn-sm' value='alterar'>						
									</td>";				
								echo "</tr>";
								echo "</form>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>	
		</div>		
	</div>
</section>
<?php 
	}
 ?>