<?php
$con = bancoMysqli();

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$razaoSocial = $_POST['razaoSocial'];
$cnpj = $_POST['cnpj'];
$nomeProjeto = $_POST['nomeProjeto'];
$idProjeto = $_POST['idProjeto'];
$idAreaAtuacao = $_POST['idAreaAtuacao'];
$idStatus = $_POST['idStatus'];

// Inicio Pessoa Física
if($nome != '' || $cpf != '')
{
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

	$sql = "SELECT * FROM projeto AS prj
			INNER JOIN pessoa_fisica AS pf ON prj.idPf = pf.idPf
			WHERE publicado = 1
			$filtro_nome $filtro_cpf";
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0)
	{
		$i = 0;
		while($lista = mysqli_fetch_array($query))
		{
			$area = recuperaDados("area_atuacao","idArea",$lista['idAreaAtuacao']);
			$status = recuperaDados("status","idStatus",$lista['idStatus']);
			$x[$i]['idProjeto'] = $lista['idProjeto'];
			$x[$i]['protocolo'] = $lista['protocolo'];
			$x[$i]['nomeProjeto'] = $lista['nomeProjeto'];
			$x[$i]['proponente'] = $lista['nome'];
			$x[$i]['documento'] = $lista['cpf'];
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
}
// Inicio Pessoa Jurídica
elseif($razaoSocial != '' || $cnpj != '')
{
	if($razaSocial != '')
	{
		$filtro_razaSocial = " AND razaSocial LIKE '%$razaSocial%'";
	}
	else
	{
		$filtro_razaSocial = "";
	}

	if($cnpj != '')
	{
		$filtro_cnpj = " AND cnpj = '$cnpj'";
	}
	else
	{
		$filtro_cnpj = "";
	}
	$sql = "SELECT * FROM projeto AS prj
			INNER JOIN pessoa_juridica AS pj ON prj.idPj = pj.idPj
			WHERE publicado = 1
			$filtro_razaSocial $filtro_cnpj";
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0)
	{
		$i = 0;
		while($lista = mysqli_fetch_array($query))
		{
			$area = recuperaDados("area_atuacao","idArea",$lista['idAreaAtuacao']);
			$status = recuperaDados("status","idStatus",$lista['idStatus']);
			$x[$i]['idProjeto'] = $lista['idProjeto'];
			$x[$i]['protocolo'] = $lista['protocolo'];
			$x[$i]['nomeProjeto'] = $lista['nomeProjeto'];
			$x[$i]['proponente'] = $lista['razaSocial'];
			$x[$i]['documento'] = $lista['cnpj'];
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
}
//Início Projeto
else
{
	if($nomeProjeto != '')
	{
		$filtro_nomeProjeto = " AND nomeProjeto LIKE '%$nomeProjeto%'";
	}
	else
	{
		$filtro_nomeProjeto = "";
	}

	if($idProjeto != '')
	{
		$filtro_idProjeto = " AND idProjeto = '$idProjeto'";
	}
	else
	{
		$filtro_idProjeto = "";
	}

	if($idAreaAtuacao != 0)
	{
		$filtro_idAreaAtuacao = " AND idAreaAtuacao = '$idAreaAtuacao'";
	}
	else
	{
		$filtro_idAreaAtuacao = "";
	}

	if($idStatus != 0)
	{
		$filtro_idStatus = " AND idStatus = '$idStatus'";
	}
	else
	{
		$filtro_idStatus = "";
	}

	$sql = "SELECT * FROM projeto AS prj
			WHERE publicado = 1
			$filtro_nomeProjeto $filtro_idProjeto $filtro_idAreaAtuacao $filtro_idStatus";
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
			$x[$i]['protocolo'] = $lista['protocolo'];
			$x[$i]['nomeProjeto'] = $lista['nomeProjeto'];
			if($lista['tipoPessoa'] == 1)
			{
				$x[$i]['proponente'] = $pf['nome'];
				$x[$i]['documento'] = $pf['cpf'];
			}
			else
			{
				$x[$i]['proponente'] = $pj['razaoSocial'];
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
}

$mensagem = "Foram encontrados ".$x['num']." resultados";
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_comissao.php'; ?>
		<div class="form-group">
			<h4>Pesquisar Projetos</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
			<h5><a href="?perfil=comissao_pesquisa">Fazer outra busca</a></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="table-responsive list_info">
					<table class='table table-condensed'>
						<thead>
							<tr class='list_menu'>
								<td>Protocolo</td>
								<td>Nome Projeto</td>
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
								echo "<td class='list_description'>".$x[$h]['protocolo']."</td>";
								echo "<td class='list_description'>".$x[$h]['nomeProjeto']."</td>";
								echo "<td class='list_description'>".$x[$h]['proponente']."</td>";
								echo "<td class='list_description'>".$x[$h]['documento']."</td>";
								echo "<td class='list_description'>".$x[$h]['areaAtuacao']."</td>";
								echo "<td class='list_description'>".$x[$h]['status']."</td>";
								echo "<td class='list_description'>
										<form method='POST' action='?perfil=comissao_detalhes_projeto'>
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