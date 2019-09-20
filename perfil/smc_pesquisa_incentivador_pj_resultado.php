<?php
$con = bancoMysqli();

$nome = isset($_POST['nome']) ? $_POST['nome'] : null;
$cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : null;
$liberado = isset($_POST['liberado']) ? $_POST['liberado'] : null;

if($nome != '')
{
	$filtro_nome = " AND razaoSocial LIKE '%$nome%'";
}
else
{
	$filtro_nome = "";
}

if($cnpj != '')
{
	$filtro_cnpj = " AND cnpj = '$cnpj'";
}
else
{
	$filtro_cnpj = "";
}

if($liberado != 0 && $liberado != NULL)
{
	$filtro_liberado = " AND liberado = '$liberado'";
}
else
{
	$filtro_liberado = "";
}

$sql = "SELECT * FROM incentivador_pessoa_juridica
		WHERE idNivelAcesso = 1
		$filtro_liberado $filtro_nome $filtro_cnpj
		ORDER BY idPj DESC";
$query = mysqli_query($con,$sql);
$num = mysqli_num_rows($query);
if($num > 0)
{
	$i = 0;
	while($lista = mysqli_fetch_array($query))
	{
		$x[$i]['idPj'] = $lista['idPj'];
		$x[$i]['razaoSocial'] = $lista['razaoSocial'];
		$x[$i]['cnpj'] = $lista['cnpj'];
		$x[$i]['email'] = $lista['email'];
		$x[$i]['telefone'] = $lista['telefone'];
		$x[$i]['liberado'] = $lista['liberado'];
		$i++;
	}
	$x['num'] = $i;
}
else
{
	$x['num'] = 0;
}

$mensagem = "Foram encontrados ".$x['num']." resultados";
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Pesquisar Incentivadores</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
			<h5><a href="?perfil=smc_pesquisa_incentivador_pj">Fazer outra busca</a></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="table-responsive list_info">
					<table class='table table-condensed'>
						<thead>
							<tr class='list_menu'>
								<td>Razão Social</td>
								<td>CNPJ</td>
								<td>Email</td>
								<td>Telefone</td>
								<td>Liberação</td>
								<td width='10%'></td>
							</tr>
						</thead>
						<tbody>
							<?php
							for($h = 0; $h < $x['num']; $h++)
							{
								echo "<tr>";
								echo "<td class='list_description'>".$x[$h]['razaoSocial']."</td>";
								echo "<td class='list_description'>".$x[$h]['cnpj']."</td>";
								echo "<td class='list_description'>".$x[$h]['email']."</td>";
								echo "<td class='list_description'>".$x[$h]['telefone']."</td>";
								if($x[$h]['liberado'] == 1) { echo "<td class='list_description'>Acesso aos dados cadastrais</td>";}
								if($x[$h]['liberado'] == 2) { echo "<td class='list_description'>Acesso não aprovado</td>";}
								if($x[$h]['liberado'] == 3) { echo "<td class='list_description'>Acesso ao projeto</td>";}
								if($x[$h]['liberado'] == 4) { echo "<td class='list_description'>Liberado para Edição</td>";}
								if($x[$h]['liberado'] == 6) { echo "<td class='list_description'>Não Apto a Incentivos</td>";}
								echo "<td class='list_description'>
										<form method='POST' action='?perfil=smc_visualiza_incentivadores_pj'>
											<input type='hidden' name='liberado' value='".$x[$h]['idPj']."' />
											<input type ='submit' class='btn btn-theme btn-block' value='detalhes'>
										</form>
									</td>";
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>