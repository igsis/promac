<?php 
$con = bancoMysqli();
$conn = bancoPDO();

$nome = isset($_POST['nome'])?$_POST['nome']:null;
$cpf = isset($_POST['cpf'])?$_POST['cpf']:null;

// if($nome != '' || $cpf != '')
// {
// 	if($nome != '')
// 	{
// 		$filtro_nome = " AND nome LIKE '%$nome%'";
// 	}
// 	else
// 	{
// 		$filtro_nome = "";
// 	}

// 	if($cpf != '')
// 	{
// 		$filtro_cpf = " AND cpf = '$cpf'";
// 	}
// 	else
// 	{
// 		$filtro_cpf = "";
// 	}
// }


	$sql = "SELECT * FROM pessoa_fisica AS pf
			WHERE cpf = :cpf ";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':cpf', $cpf);
	// $stmt->bindParam(':filtro_cpf', $filtro_cpf);
	$stmt->execute();
	$result = $stmt->fetchAll();
	// echo '<pre>';
	// print_r($result[0]['cpf']);
	$id = isset($result[0]['idPf'])?$result[0]['idPf']:null;

	if(isset($_POST['atualizar'])){
	$liberado = $_POST['liberado'];
	// echo $liberado;

	$sql_atualizar = "UPDATE pessoa_fisica SET
		liberado = '$liberado'
		WHERE idPf = :idPf ";
		
	$stmt = $conn->prepare($sql_atualizar);
	$stmt->bindParam(':idPf', $id);
	if ($stmt->execute()) {
		echo '<br><h2>Atualizado</h2>';
	}
}
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Resultado da Busca</h4>
			<div class="col-md-offset-2 col-md-8">
				<div class="table-responsive list_info">
					<table class='table table-condensed'>
						<thead>
							<tr class='list_menu'>
								<td>ID</td>
								<td>Nome</td>
								<td>CPF</td>
								<td>Tipo Acesso</td>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($result as $value)
							{
								echo "<tr>";
								echo "<td class='list_description'>".$value['idPf']."</td>";
								echo "<td class='list_description'>".$value['nome']."</td>";
								echo "<td class='list_description'>".$value['cpf']."</td>";
								echo "<td class='list_description'>".$value['liberado']."</td>";					
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
				<label>Selecione o tipo de acesso</label><br/>
				<form method="POST" action="" class="form-horizontal" role="form">
					<div class="form-group">
						<select class="form-control" name="liberado" >
							<option value="0"></option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
						</select>
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="atualizar" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>
			</div>	
		</div>		
	</div>
</section>