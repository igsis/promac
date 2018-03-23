<?php

$con = bancoMysqli();

if(isset($_POST['consulta']))
{
	$cpf = $_POST['cpf'];
	$query = "SELECT idPf FROM pessoa_fisica WHERE idNivelAcesso in (2,3) AND cpf = '$cpf'";
	$envia = mysqli_query($con, $query);
	$row = mysqli_fetch_array($envia);
	$idUser = $row['idPf'];
	if($idUser != 2 && $idUser != 3)
	{
		echo "<script>alert('ERRO: O usuário em questão não faz parte da SMC ou Comissão.')</script>";
	}
	else{
		echo 
		"<script>
    			window.location = '/promac/visual/index_pf.php?perfil=visualiza_perfil&id=$idUser';
		</script>";
	}
}
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><br><br>
		<div class="form-group">
			<h4>Consulta de usuários</h4>
		</div>

		<div class="row">
			<div class="col-md-offset-4 col-md-5">
				<div class="well">
					Insira o CPF do usuário que deseja resetar a senha.
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=resetar_senha" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-3 col-md-7"><label>CPF</label>
							<input type="text" name="cpf" id="cpf" class="form-control" placeholder="">
						</div>
					</div>


					<div class="form-group">
						<div class="col-md-offset-3 col-md-7">
							<input type="submit" name="consulta" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
						</div>
					</div><br><br>
				</form>
			</div>
		</div>
	</div>
</section>