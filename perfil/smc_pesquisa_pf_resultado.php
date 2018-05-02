<?php
$con = bancoMysqli();

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$liberado = $_POST['liberado'];

if($nome != '')
{
	$filtro_nome = " AND nome LIKE '%$nome%'";
}
else
{
	$filtro_nome = "";
}

if($cpf != '')
{
	$filtro_cpf = " AND cpf = '$cpf'";
}
else
{
	$filtro_cpf = "";
}

if($liberado != 0)
{
	$filtro_liberado = " AND liberado = '$liberado'";
}
else
{
	$filtro_liberado = "";
}

$sql = "SELECT * FROM pessoa_fisica
		WHERE idNivelAcesso = 1
		$filtro_nome $filtro_cpf $filtro_liberado
		ORDER BY idPf DESC";
$query = mysqli_query($con,$sql);
$num = mysqli_num_rows($query);
if($num > 0)
{
	$i = 0;
	while($lista = mysqli_fetch_array($query))
	{
		$projeto = recuperaDados("projeto","idPf",$lista['idPf']);
		$status = recuperaDados("status","idStatus",$projeto['idStatus']);
		$x[$i]['idPf'] = $lista['idPf'];
		$x[$i]['nome'] = $lista['nome'];
		$x[$i]['cpf'] = $lista['cpf'];
		$x[$i]['rg'] = $lista['rg'];
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
			<h5><a href="?perfil=smc_pesquisa_pf">Fazer outra busca</a></h5>
		</div>
		<div class="row">
			<table class='table table-condensed table-hover list_info'>
				<thead>
					<tr class='list_menu'>
						<td>Nome</td>
						<td>CPF</td>
						<td>RG</td>
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
						echo "<td class='list_description'>".$x[$h]['nome']."</td>";
						echo "<td class='list_description'>".$x[$h]['cpf']."</td>";
						echo "<td class='list_description'>".$x[$h]['rg']."</td>";
						echo "<td class='list_description'>".$x[$h]['email']."</td>";
						echo "<td class='list_description'>".$x[$h]['telefone']."</td>";
						if($x[$h]['liberado'] == 0 || $x[$h]['liberado'] == NULL) { echo "<td class='list_description'>Em elaboração</td>";}
						if($x[$h]['liberado'] == 1) { echo "<td class='list_description'>Acesso aos dados cadastrais</td>";}
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
								<form method='POST' action='?perfil=smc_reaprova_pf'>
									<input type='hidden' name='idPf' value='".$x[$h]['idPf']."' />
									<input type ='submit' class='btn btn-theme btn-block' value='detalhes'>
								</form>
							</td>";
						}
						else
						{
							echo "<td class='list_description'>
								<form method='POST' action='?perfil=smc_visualiza_perfil_pf'>
									<input type='hidden' name='liberado' value='".$x[$h]['idPf']."' />
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