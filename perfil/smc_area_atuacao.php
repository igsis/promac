<?php 
$conn = bancoPDO();

if (isset($_POST['atualizar']))
{
	$id = $_POST['id'];
	$area = $_POST['area'];
	$tipo = $_POST['tipoPessoa'];

	$sql_atualiza = "UPDATE area_atuacao SET areaAtuacao = '".$area."', tipo = '".$tipo."' WHERE idArea = '".$id."'";
	$stmt = $conn->prepare($sql_atualiza);
	if($stmt->execute())
	{
		$mensagem = "Atualizado com sucesso!";
	}else {
		$mensagem = "Erro ao atualizar";
	}
	
}

if (isset($_POST['apagar']))
{
	$id = $_POST['id'];
	$sql_deleta = "UPDATE area_atuacao SET publicado = '0' WHERE idArea = :id ";
	$stmt = $conn->prepare($sql_deleta);
	$stmt->bindParam(':id', $id);

	if ($stmt->execute())
	{
		$mensagem = "Área removida com sucesso!";
	}else {
		$mensagem = "Erro ao remover!";
	}
	
}

if (isset($_POST['inserir'])) 
{
	$conn = bancoPDO();
	$area = $_POST['nomeArea'];
	$tipo = $_POST['tipoPessoa'];

	$sql_insere = "INSERT INTO `area_atuacao` (`areaAtuacao`, `tipo`,publicado) VALUES (:areaAtuacao,:tipo, '1')";
	$stmt = $conn->prepare($sql_insere);
	$stmt->bindParam(':areaAtuacao',$area);
	$stmt->bindParam(':tipo',$tipo);

	if ($stmt->execute()) 
	{
		$mensagem = "Área inserida com sucesso!";
	}else {
		$mensagem = "Erro ao inserir!";
	}

}
$sql = "SELECT * FROM area_atuacao WHERE publicado = '1'";
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h5>Área de Atuação.</a></h5>
			<hr>
			<h6 class="text-success"><?php echo $mensagem ?? '' ;?></h6>
		</div>

			<table class="table table-condensed table-hover text-center"> 
                <thead>
                    <tr class='list_menu'>
                        <th>#</th>
                        <th width='80%' >Área</th>
                        <th width='10%'>Tipo Pessoa</th>	
                        <th>Ações</th>
                    </tr>
                </thead> 
                <tbody>
<?php
            foreach ($conn->query($sql) as $i => $row) 
            {
            	if ($row['tipo'] == 1) {
            		$pessoa = 'Pessoa Física';
            	}else{
            		$pessoa = 'Pessoa Física e Júridica';
            	}
                echo "<tr>";
                echo    "<th scope='row'>$i</th>";
                echo    "<td class='list_description'>".$row['areaAtuacao']."</td>";
                echo    "<td class='list_description'>".$pessoa."</td>";
                            // <form action='' method='post'></form>
                echo    "<td class='list_description'>
                                <button type='submit' name='edita' class='btn btn-info btn-sm' data-toggle='modal' data-target='#edita$i'><i class='fa fa-pencil'></i>
                                </button>
                                <button type='submit' name='apaga' class='btn btn-danger btn-sm' data-toggle='modal' data-target='#apaga$i'><i class='fa fa-trash-o fa-lg'></i>
                                </button>
                            
                        </td>";
                echo "</tr>";
                // Modal Edição 
                echo "
					<div class='modal fade' id='edita$i' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
					  <div class='modal-dialog modal-dialog-centered' role='document'>
					    <div class='modal-content'>
					      <div class='modal-header'>
					        <h5 class='modal-title' id=''>Editar Área</h5>
					        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					          <span aria-hidden='true'>&times;</span>
					        </button>
					      </div>
					      <div class='modal-body'>
					      	<form action='' method='post' class='form-group'>
								<input type='hidden' name='id' value='".$row['idArea']."' class='form-control'><br>
								<input type='text' name='area' value='".$row['areaAtuacao']."' class='form-control'>
								<select name='tipoPessoa'>
									<option value=".$row['tipo']."></option>
									<option value='1'>Pessoa Física</option>
									<option value='2'>Pessoa Física e Júridica</option>
								</select>
								<br><br>
								<input type='submit' name='atualizar' class='btn btn-theme btn-block' value='Savar'>
					      	</form>
					      </div>
					      <div class='modal-footer'>
					        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
					      </div>
					    </div>
					  </div>
					</div>";
				// Modal Apagar
				echo "
					<div class='modal fade' id='apaga$i' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
					  <div class='modal-dialog modal-dialog-centered' role='document'>
					    <div class='modal-content'>
					      <div class='modal-header'>
					        <h5 class='modal-title' id=''>Quer remover essa área?</h5>
					        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					          <span aria-hidden='true'>&times;</span>
					        </button>
					      </div>
					      <div class='modal-body'>
					      	<form action='' method='post' class='form-group'>
								<p>".$row['areaAtuacao']."</p>
								<input type='hidden' name='id' value='".$row['idArea']."' class='form-control'><br>	
								<input type='submit' name='apagar' class='btn btn-theme ' value='Sim'>
								<button type='button' class='btn btn-theme' data-dismiss='modal'>Não</button>
					      	</form>
					      </div>
					      <div class='modal-footer'>
					        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
					      </div>
					    </div>
					  </div>
					</div>";
            } // Inserir 
            	echo "<form action='' method='post' class='form-group'>";
             	echo "<tr>
	                    <th scope='row'>$i</th>
	                	    <td><input type='text' name='nomeArea' class='form-control' required></td>
	                	 	<td><select name='tipoPessoa'>
	                	 		<option value='1'>Pessoa Física</option>
	                	 		<option value='2'>Pessoa Física e Júridica</option>
	                	 	</select></td>
	                	    <td><button type='submit' name='inserir' class='btn btn-success '><i class='fa fa-plus'></i></i>
							</button></td>
	                 	</tr>";
                echo "</form>";
?>
                </tbody>     
            </table>
		</div>	
	</div>
</section>
