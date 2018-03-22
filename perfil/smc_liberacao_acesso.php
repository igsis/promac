<?php 
$con = bancoMysqli();
$conn = bancoPDO();

$nome = isset($_POST['nome'])?$_POST['nome']:null;
$cpf = isset($_POST['cpf'])?$_POST['cpf']:null;


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
}

$sql = "SELECT * FROM pessoa_fisica 
		WHERE :filtro_cpf :filtro_nome";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':filtro_cpf', $filtro_cpf);
$stmt->bindValue(':filtro_nome', $filtro_nome);
$stmt->execute();
$result = $stmt->fetchAll();

// $id = isset($result[0]['idPf'])?$result[0]['idPf']:null;

// if(isset($_POST['atualizar'])){
// 	$liberado = $_POST['liberado'];
// 	$sql_atualizar = "UPDATE pessoa_fisica SET
// 		liberado = '$liberado'
// 		WHERE idPf = :idPf ";

// 	$stmt = $conn->prepare($sql_atualizar);
// 	$stmt->bindParam(':idPf', $_POST['id']);
// 	$stmt->execute();
// }
if(isset($_POST['alterar'])){
	$id = $_POST['id'];
	$liberado = $_POST['liberado'];
	$sql_atualizar = "UPDATE pessoa_fisica SET
		liberado = '$liberado'
 		WHERE idPf = :idPf ";
 	$stmt = $conn->prepare($sql_atualizar);
 	$stmt->bindParam(':idPf', $id);
 	$stmt->execute();
}

// echo '<pre>';
// print_r($result);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Resultado da Busca</h4><hr>
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
								echo "<form method='POST' action=''>";
								echo "<tr>";
								echo "<td class='list_description'>".$value['idPf']."</td>";
								echo "<td class='list_description'>".$value['nome']."</td>";
								echo "<td class='list_description'>".$value['cpf']."</td>";
								echo "<td class='list_description'>
										<select class='form-control' name='liberado'>
											<option value='0'>".$value['liberado']."</option>
											<option value='1'>1</option>
											<option value='2'>2</option>
											<option value='3'>3</option>									
										</select>
									</td>";
								echo "<td class='list_description'>
										<input type='hidden' name='id' value='".$value['idPf']."' />
										<input type ='submit' class='btn btn-theme btn-block btn-sm' value='alterar'>						
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