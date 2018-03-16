<?php
$con = bancoMysqli();
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include '../perfil/includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Liberação de acesso</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">

				<div class="table-responsive list_info">
				<?php
					$sql = "SELECT * FROM pessoa_fisica WHERE liberado = 1";
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
										<td>E-mail</td>
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
									echo "<td class='list_description'>".$campo['email']."</td>";
									echo "<td class='list_description'>".$campo['telefone']."</td>";
									echo "
										<td class='list_description'>
											<form method='POST' action='?perfil=smc_detalhes_pf'>
												<input type='hidden' name='carregar' value='".$campo['idPf']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='carregar'>
											</form>
										</td>";
									echo "</tr>";
								}
						echo "
							</tbody>
							</table>";
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>