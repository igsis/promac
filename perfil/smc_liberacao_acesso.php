<?php 
$con = bancoMysqli();

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];

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
// 		$sql = "SELECT * FROM pessoa_fisica";
// }	


?>

<section id="list_items" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
			<div class="col-md-offset-2 col-md-8">
				<label>Selecione o tipo de acesso</label><br/>
				<select class="form-control" name="idAreaAtuacao" >
					<option value="0"></option>
					<?php  ?>
				</select>
			</div>	
		</div>		
	</div>
</section>