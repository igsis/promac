<?php
$con = bancoMysqli();

$nome = $_POST['nome'] ?? NULL;
$cpf = $_POST['cpf'] ?? NULL;
$razaoSocial = $_POST['razaoSocial'] ?? NULL;
$cnpj = $_POST['cnpj'] ?? NULL;
$nomeProjeto = $_POST['nomeProjeto'] ?? NULL;
$idProjeto = $_POST['idProjeto'] ?? NULL;
$idAreaAtuacao = $_POST['idAreaAtuacao'] ?? NULL;
$idEtapaProjeto = $_POST['idEtapaProjeto'] ?? NULL;
$idComissao = $_POST['idComissao'] ?? NULL;

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
			$etapa = recuperaDados("etapa_projeto","idEtapaProjeto",$lista['idEtapaProjeto']);
			$comissao = recuperaDados("pessoa_fisica","idPf",$lista['idComissao']);
			$x[$i]['idProjeto'] = $lista['idProjeto'];
			$x[$i]['protocolo'] = $lista['protocolo'];
			$x[$i]['nomeProjeto'] = $lista['nomeProjeto'];
			$x[$i]['proponente'] = $lista['nome'];
			$x[$i]['documento'] = $lista['cpf'];
			$x[$i]['areaAtuacao'] = $area['areaAtuacao'];
			$x[$i]['comissao'] = $comissao['nome'];
			$x[$i]['etapa'] = $etapa['etapaProjeto'];
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
	$sql = "SELECT * FROM projeto AS prj
			INNER JOIN pessoa_juridica AS pj ON prj.idPj = pj.idPj
			INNER JOIN representante_legal AS rep ON rep.idRepresentanteLegal = pj.idRepresentanteLegal
			WHERE publicado = 1
			$filtro_razaoSocial $filtro_cnpj";
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0)
	{
		$i = 0;
		while($lista = mysqli_fetch_array($query))
		{
			$area = recuperaDados("area_atuacao","idArea",$lista['idAreaAtuacao']);
            $etapa = recuperaDados("etapa_projeto","idEtapaProjeto",$lista['idEtapaProjeto']);
			$comissao = recuperaDados("pessoa_fisica","idPf",$lista['idComissao']);
			$x[$i]['idProjeto'] = $lista['idProjeto'];
			$x[$i]['protocolo'] = $lista['protocolo'];
			$x[$i]['nomeProjeto'] = $lista['nomeProjeto'];
			$x[$i]['proponente'] = $lista['razaoSocial']."<br/>".$lista['nome'];
			$x[$i]['documento'] = $lista['cnpj'];
			$x[$i]['areaAtuacao'] = $area['areaAtuacao'];
			$x[$i]['comissao'] = $comissao['nome'];
			$x[$i]['etapa'] = $etapa['etapaProjeto'];
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

	if($idEtapaProjeto != 0)
	{
		$filtro_idEtapa = " AND idEtapaProjeto = '$idEtapaProjeto'";
	}
	else
	{
		$filtro_idEtapa = "";
	}

	if($idComissao != NULL)
	{
		$filtro_idComissao = "AND idComissao = '$idComissao'";
	}
	else
	{
		$filtro_idComissao = "";
	}

	$sql = "SELECT * FROM projeto AS prj
			WHERE publicado = 1 AND idStatus != 6
			$filtro_nomeProjeto $filtro_idProjeto $filtro_idAreaAtuacao $filtro_idEtapa $filtro_idComissao";
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0)
	{
		$i = 0;
		while($lista = mysqli_fetch_array($query))
		{
			$area = recuperaDados("area_atuacao","idArea",$lista['idAreaAtuacao']);
            $etapa = recuperaDados("etapa_projeto","idEtapaProjeto",$lista['idEtapaProjeto']);
			$pf = recuperaDados("pessoa_fisica","idPf",$lista['idPf']);
			$pj = recuperaDados("pessoa_juridica","idPj",$lista['idPj']);
			$comissao = recuperaDados("pessoa_fisica","idPf",$lista['idComissao']);
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
			$x[$i]['comissao'] = $comissao['nome'];
            $x[$i]['etapa'] = $etapa['etapaProjeto'];
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
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Pesquisar Projetos</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
			<h5><a href="?perfil=smc_pesquisa_geral">Fazer outra busca</a></h5>
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
								<td>Parecerista</td>
								<td>Etapa</td>
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
								echo "<td class='list_description'>".mb_strimwidth($x[$h]['areaAtuacao'], 0, 38, "...")."</td>";
								echo "<td class='list_description'>".strstr($x[$h]['comissao'], ' ', true)."</td>";
								echo "<td class='list_description'>".$x[$h]['etapa']."</td>";
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