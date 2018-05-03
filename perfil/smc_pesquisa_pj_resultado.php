<?php
$con = bancoMysqli();

$razaoSocial = isset($_POST['razaoSocial']) ? $_POST['razaoSocial'] : null;
$cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : null;
$liberado = isset($_POST['liberado']) ? $_POST['liberado'] : null;

if($razaoSocial != '')
{
	$filtro_razaoSocial = " AND razaoSocial LIKE '%$razaoSocial%'";
}
else
{
	$filtro_razaoSocial = "";
}

if($cnpj != '')
{
	$filtro_cnpj = " AND cnpj = '$cnpj'";
}
else
{
	$filtro_cnpj = "";
}

if($liberado != 0)
{
	$filtro_liberado = " AND liberado = '$liberado'";
}
else
{
	$filtro_liberado = "";
}

$sql = "SELECT * FROM pessoa_juridica
		WHERE idNivelAcesso = 1
		$filtro_razaoSocial $filtro_cnpj $filtro_liberado
		ORDER BY idPj DESC";
$query = mysqli_query($con,$sql);
$num = mysqli_num_rows($query);
if($num > 0)
{
	$i = 0;
	while($lista = mysqli_fetch_array($query))
	{
		$projeto = recuperaDadosProjeto("projeto","idPj",$lista['idPj']);
		$status = recuperaDados("status","idStatus",$projeto['idStatus']);
		$x[$i]['idPj'] = $lista['idPj'];
		$x[$i]['razaoSocial'] = $lista['razaoSocial'];
		$x[$i]['cnpj'] = $lista['cnpj'];
		$x[$i]['email'] = $lista['email'];
		$x[$i]['telefone'] = $lista['telefone'];
		$x[$i]['liberado'] = $lista['liberado'];
		$x[$i]['projeto'] = $projeto['nomeProjeto'];
		$x[$i]['statusProjeto'] = $status['status'];
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
			<h4>Pesquisar Projetos</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
			<h5><a href="?perfil=smc_pesquisa_pj">Fazer outra busca</a></h5>
		</div>
		<div class="row">
			<table class='table table-condensed table-hover list_info'>
				<thead>
					<tr class='list_menu'>
						<td>Razão Social</td>
						<td>CNPJ</td>
						<td>Email</td>
						<td>Telefone</td>
						<td>Status do Proponente</td>
						<td>Projeto Enviado</td>
						<td>Status do Projeto</td>
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
						if($x[$h]['liberado'] == 0 || $x[$h]['liberado'] == NULL) { echo "<td class='list_description'>Em elaboração</td>";}
						if($x[$h]['liberado'] == 1) { echo "<td class='list_description'>Liberação Solicitada</td>";}
						if($x[$h]['liberado'] == 2) { echo "<td class='list_description'>Proponente Reprovado</td>";}
						if($x[$h]['liberado'] == 3) { echo "<td class='list_description'>Proponente Aprovado</td>";}
						if($x[$h]['liberado'] == 4) { echo "<td class='list_description'>Liberado para Edição</td>";}
						if($x[$h]['projeto'] == "")
						{
							echo "<td class='list_description'>Sem Projetos Enviados</td>";
							echo "<td class='list_description'></td>";
						}
						else
						{
							echo "<td class='list_description'>".$x[$h]['projeto']."</td>";
							echo "<td class='list_description'>".$x[$h]['statusProjeto']."</td>";
						}
						if($x[$h]['liberado'] == 2)
						{
							echo "<td class='list_description'>
								<form method='POST' action='?perfil=smc_reaprova_pj'>
									<input type='hidden' name='idPj' value='".$x[$h]['idPj']."' />
									<input type ='submit' class='btn btn-theme btn-block' value='detalhes'>
								</form>
							</td>";
						}
						else
						{
							echo "<td class='list_description'>
									<form method='POST' action='?perfil=smc_visualiza_perfil_pj'>
										<input type='hidden' name='liberado' value='".$x[$h]['idPj']."' />
										<input type ='submit' class='btn btn-theme btn-block' value='detalhes'>
									</form>
								</td>";
						}
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</section>