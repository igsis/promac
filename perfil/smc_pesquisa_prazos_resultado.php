<?php
$con = bancoMysqli();

$deCaptacao = exibirDataMysql($_POST['deCaptacao']);
$ateCaptacao = exibirDataMysql($_POST['ateCaptacao']);
$deFinalCaptacao = exibirDataMysql($_POST['deFinalCaptacao']);
$ateFinalCaptacao = exibirDataMysql($_POST['ateFinalCaptacao']);
$inicioExecucao = exibirDataMysql($_POST['inicioExecucao']);
$fimExecucao = exibirDataMysql($_POST['fimExecucao']);
$deFinal = exibirDataMysql($_POST['deFinal']);
$ateFinal = exibirDataMysql($_POST['ateFinal']);
$deContas = exibirDataMysql($_POST['deContas']);
$ateContas = exibirDataMysql($_POST['ateContas']);

if($deCaptacao != '--' && $ateCaptacao != '--')
{
	$filtro_captacao = "AND prazoCaptacao BETWEEN '$deCaptacao' AND '$ateCaptacao'";
}
else
{
	$filtro_captacao = "";
}

if($deFinalCaptacao != '--' && $ateFinalCaptacao != '--')
{
	$filtro_finalCaptacao = "AND finalCaptacao BETWEEN '$deFinalCaptacao' AND '$ateFinalCaptacao'";
}
else
{
	$filtro_finalCaptacao = "";
}

if($inicioExecucao != '--' && $fimExecucao != '--')
{
	$filtro_execucao = "AND inicioExecucao BETWEEN '$inicioExecucao' AND '$fimExecucao' AND fimExecucao BETWEEN '$inicioExecucao' AND '$fimExecucao'";
}
else
{
	$filtro_execucao = "";
}

if($deFinal != '--' && $ateFinal != '--')
{
	$filtro_final = "AND finalProjeto BETWEEN '$deFinal' AND '$ateFinal'";
}
else
{
	$filtro_final = "";
}

if($deContas != '--' && $ateContas != '--')
{
	$filtro_contas = "AND prestarContas BETWEEN $deContas AND $ateContas";
}
else
{
	$filtro_contas = "";
}

$sql = "SELECT * FROM prazos_projeto AS prz
		INNER JOIN projeto AS prj ON prj.idProjeto = prz.idProjeto
		WHERE prj.publicado = 1
		$filtro_captacao $filtro_finalCaptacao $filtro_execucao $filtro_final $filtro_contas";
$query = mysqli_query($con,$sql);
$num = mysqli_num_rows($query);
if($num > 0)
{
	$i = 0;
	while($lista = mysqli_fetch_array($query))
	{
		$area = recuperaDados("area_atuacao","idArea",$lista['idAreaAtuacao']);
		$status = recuperaDados("status","idStatus",$lista['idStatus']);
		$pf = recuperaDados("pessoa_fisica","idPf",$lista['idPf']);
		$pj = recuperaDados("pessoa_juridica","idPj",$lista['idPj']);
		$x[$i]['idProjeto'] = $lista['idProjeto'];
		if($lista['tipoPessoa'] == 1)
		{
			$x[$i]['proponente'] = $pf['nome'];
			$x[$i]['documento'] = $pf['cpf'];
		}
		else
		{
			$x[$i]['proponente'] = $pj['razaSocial'];
			$x[$i]['documento'] = $pj['cnpj'];
		}
		$x[$i]['areaAtuacao'] = $area['areaAtuacao'];
		$x[$i]['status'] = $status['status'];
		$i++;
	}
	$x['num'] = $i;
}
else
{
	$x['num'] = 0;
}

$mensagem = "Foram encontrados ".$x['num']." resultados.<br/>";
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Pesquisar Prazos</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
			<h5><a href="?perfil=smc_pesquisa_prazos">Fazer outra busca</a></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="table-responsive list_info">
					<table class='table table-condensed'>
						<thead>
							<tr class='list_menu'>
								<td>Protocolo</td>
								<td>Proponente</td>
								<td>Documento</td>
								<td>Área de Atuação</td>
								<td>Status</td>
								<td width='10%'></td>
							</tr>
						</thead>
						<tbody>
							<?php
							for($h = 0; $h < $x['num']; $h++)
							{
								echo "<tr>";
								echo "<td class='list_description'>".$x[$h]['idProjeto']."</td>";
								echo "<td class='list_description'>".$x[$h]['proponente']."</td>";
								echo "<td class='list_description'>".$x[$h]['documento']."</td>";
								echo "<td class='list_description'>".$x[$h]['areaAtuacao']."</td>";
								echo "<td class='list_description'>".$x[$h]['status']."</td>";
								echo "<td class='list_description'>
										<form method='POST' action='?perfil=smc_detalhes_projeto'>
											<input type='hidden' name='idProjeto' value='".$x[$h]['idProjeto']."' />
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