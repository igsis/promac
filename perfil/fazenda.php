<?php
$con = bancoMysqli();
$valorTotalDisponivel;
function calculaValorDisponivel($valor, $valorTotal){
	return $valorTotalDisponivel = $valor - $valorTotal;
}
?>
<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_smc.php'; ?>
        <div class="form-group">
            <h4>Fazenda</h4>
        </div>
<div class="col-md-offset-1 col-md-10">
        <div class="table-responsive list_info">
				<?php
					$sql_financeiro = "SELECT * FROM financeiro WHERE publicado = 1";
					$query_financeiro = mysqli_query($con, $sql_financeiro);
					$valorReserva = 0;
					while($campo = mysqli_fetch_array($query_financeiro)){
						$valorReserva += $campo['valorReserva']; 
					}

					$sql = "SELECT * FROM orcamento_anual LIMIT 0,10";
					$query = mysqli_query($con,$sql);
					$num = mysqli_num_rows($query);
					if($num > 0)
					{
						echo "
								<table class='table table-condensed'>
           							<thead>
									<tr class='list_menu'>
										<td>Ano</td>
										<td>Valor Anual Total</td>
										<td>Valor Anual Disponivel</td>
										<td width='10%'></td>
									</tr>
								</thead>
								<tbody>";
								while($campo = mysqli_fetch_array($query))
								{
									echo "<tr>";
									echo "<td class='list_description'>".$campo['ano']."</td>";
									echo "<td class='list_description'>".$campo['valor']."</td>";
									echo "<td class='list_description'>".calculaValorDisponivel($campo['valor'], $valorReserva)."</td>";
								}
							echo "</tr>";
							echo "</tbody>
								</table>";
						}
						else
						{
							echo "Não há resultado no momento.";
						}
				?>
			</div>
	</div>
	</div>
</section>