<?php
$con = bancoMysqli();

//verifica a página atual caso seja informada na URL, senão atribui como 1ª página
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;
$sql_lista = "SELECT nome FROM pessoa_fisica WHERE liberado = '3'";
$query_lista = mysqli_query($con,$sql_lista);

//conta o total de itens
$total_geral = mysqli_num_rows($query_lista);

//seta a quantidade de itens por página
$registros = 100;

//calcula o número de páginas arredondando o resultado para cima
$numPaginas = ceil($total_geral/$registros);

//variavel para calcular o início da visualização com base na página atual
$inicio = ($registros*$pagina)-$registros;

//seleciona os itens por página
$sql_lista = "SELECT nome FROM pessoa_fisica WHERE liberado = '3' ORDER BY nome LIMIT $inicio,$registros";
$query_lista = mysqli_query($con,$sql_lista);

//conta o total de itens
$total = mysqli_num_rows($query_lista);
?>
<section id="list_items" class="home-section bg-white">
	<div class="container">
		<div class="sub-title"><h4>PROPONENTES PESSOA FÍSICA INSCRITOS</h4>
		</div>
		<?php include 'includes/menu_consulta_publica.php'; ?>
		<p><strong>Total de registros:</strong> <?php echo $total_geral;?> | <strong>Registros nesta página:</strong> <?php echo $total;?></p>
		<div class="table-responsive list_info">
			<table class="table table-condensed">
				<thead>
					<tr class="list_menu">
						<td>Razão Social</td>
					</tr>
				</thead>
				<tbody>
			<?php
				while($campo = mysqli_fetch_array($query_lista))
				{
					echo "<tr>";
					echo "<td class='list_description'>".$campo['nome']."</td>";
					echo "</tr>";
				}
			?>
					<tr>
						<td colspan="10" bgcolor="#DEDEDE">
						<?php
							//exibe a paginação
							echo "<strong>Páginas</strong>";
							echo "<table>";
							echo "<tr>";
							for($i = 1; $i < $numPaginas + 1; $i++)
							{
								echo "<td>";
								echo "<form method='POST' action='?perfil=consulta_publica_proponente_pf&pagina=$i'>";
								echo "<button class='btn btn-theme btn-xs' type='submit' style='border-radius: 30px;' name='consulta' value='1'>$i</button>";
								echo "</form>";
								echo "</td>";
							}
							echo "</tr>";
							echo "</table>";
						?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</section>