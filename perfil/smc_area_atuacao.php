<?php 
$conn = bancoPDO();

$sql = "SELECT * FROM area_atuacao";

if (isset($_POST['atualizar']))
{
	$id = $_POST['id'];
	$area = $_POST['area'];
	$query = "UPDATE area_atuacao SET areaAtuacao = '".$area."' WHERE idArea = '".$id."'";
	if($conn->query($query))
	{
		$mensagem = "Atualizado com sucesso!";
	}else {
		$mensagem = "Erro ao atualizar";
	}
	
}
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
            foreach ($conn->query($sql) as $i => $row) {
            	if ($row['tipo'] == 1) {
            		$pessoa = 'Pessoa Física';
            	}else{
            		$pessoa = 'Pessoa Física e Júridica';
            	}
                echo "<tr>";
                echo    "<th scope='row'>$i</th>";
                echo    "<td class='list_description'>".$row['areaAtuacao']."</td>";
                echo    "<td class='list_description'>".$pessoa."</td>";
                            // <form action='' method='post'>
                echo    "<td class='list_description'>
                                <button type='submit' name='edita' class='btn btn-info btn-sm' data-toggle='modal' data-target='#$i'><i class='fa fa-pencil'></i>
                                </button>
                                <button type='submit' name='apaga' class='btn btn-danger btn-sm'><i class='fa fa-trash-o fa-lg'></i>
                                </button>
                            </form>
                        </td>";
                echo "</tr>";
                echo "
					<div class='modal fade' id='$i' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
					  <div class='modal-dialog modal-dialog-centered' role='document'>
					    <div class='modal-content'>
					      <div class='modal-header'>
					        <h5 class='modal-title' id=''>Área</h5>
					        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
					          <span aria-hidden='true'>&times;</span>
					        </button>
					      </div>
					      <div class='modal-body'>
					      	<form action='' method='post' class='form-group'>
								<input type='hidden' name='id' value='".$row['idArea']."' class='form-control'><br>
								<input type='text' name='area' value='".$row['areaAtuacao']."' class='form-control'><br>
								<input type='submit' name='atualizar' class='btn btn-theme btn-block' value='Savar'>
					      	</form>
					      </div>
					      <div class='modal-footer'>
					        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>
					      </div>
					    </div>
					  </div>
					</div>";
            }
            	echo "<form action='' method='post' class='form-group'>";
             	echo "<tr>
	                    <th scope='row'>$i</th>
	                	    <td><input type='text' name='' value='' class='form-control'></td>
	                	 	<td><select name='tipoPessoa'>
	                	 		<option value=''></option>
	                	 		<option value='1'>Pessoa Física</option>
	                	 		<option value='2'>Pessoa Física e Júridica</option>
	                	 	</select></td>
	                	    <td><button type='submit' class='btn btn-success'><i class='fa fa-plus'></i></i>
							</button></td>
	                 	</tr>";
                echo "</form>";
?>
                </tbody>     
            </table>

			<!-- Modal -->

		</div>	
	</div>
</section>
