<?php
$con = bancoMysqli();
$valorTotalDisponivel;
$valorReservaNaoLiquidada;
function calculaValorDisponivel($valor, $valorTotal){
	return $valorTotalDisponivel = $valor - $valorTotal;
}

function calculaValorReservaNaoLiquidada($valorDaReserva, $valorDaLiquidacao){
	return $valorReservaNaoLiquidada = $valorDaReserva - $valorDaLiquidacao;
}
?>
    <section id="list_items" class="home-section bg-white">
        <div class="container">
            <?php include 'includes/menu_smc.php'; ?>
            <div class="form-group">
                <h4>Fazenda</h4>
            </div>
            <div class="col-md-offset-1 col-md-10">
                <div class="table-responsive list_info">
                    <?php
					$sql_reserva = "SELECT * FROM reserva";
					$query_reserva = mysqli_query($con, $sql_reserva);
					$valorReserva = 0;
					while($campo = mysqli_fetch_array($query_reserva)){
						$valorReserva += $campo['valor'];
					}
                    
                    $sql_liquidacao = "SELECT * FROM liquidacao";
                    $query_liquidacao = mysqli_query($con, $sql_liquidacao);
                    $valorLiquidacao = 0;
                    while($campo = mysqli_fetch_array($query_liquidacao)){
                        $valorLiquidacao += $campo['valor'];
                    }
                    
					$sql = "SELECT * FROM orcamento_anual ORDER BY ano DESC LIMIT 0,10";
					$query = mysqli_query($con,$sql);
					$num = mysqli_num_rows($query);
					if($num > 0)
					{
						echo "
								<table class='table table-condensed' style='text-align:center'>
           							<thead>
									<tr class='list_menu'>
										<td>Ano</td>
										<td>Valor Anual Total</td>
										<td>Valor Anual Disponivel</td>
										<td>Reserva Não Liquidada</td>
										<!--<td width='10%'></td>-->
									</tr>
								</thead>
								<tbody>";
								while($campo = mysqli_fetch_array($query))
								{
									echo "<tr>";
									echo "<td class='list_description'>".$campo['ano']."</td>";
                                    
									echo "<td class='list_description'>
                                    R$ ".number_format($campo['valor'], 2, ',', '.')."</td>";
                                    
									echo "<td class='list_description'>
                                    R$ ".number_format(calculaValorDisponivel($campo['valor'], $valorReserva), 2, ',', '.') ."</td>";
                                    
									echo "<td class='list_description'>
                                    R$ ".number_format(calculaValorReservaNaoLiquidada($valorReserva, $valorLiquidacao), 2, ',', '.')."</td>";
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
