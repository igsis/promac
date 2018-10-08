<?php
$con = bancoMysqli();

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$razaoSocial = $_POST['razaoSocial'];
$cnpj = $_POST['cnpj'];
$nomeProjeto = $_POST['nomeProjeto'];
$protocolo = $_POST['protocolo'];
$idAreaAtuacao = $_POST['idAreaAtuacao'];
$valorAprovado = $_POST['valorAprovado'];

$status_aprovado = "AND idStatus IN (5, 11, 14, 15, 16, 18, 21, 26, 34)";

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
			INNER JOIN area_atuacao AS ar on prj.idAreaAtuacao = ar.idArea
			WHERE prj.publicado = 1 $status_aprovado
			$filtro_nome $filtro_cpf";
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0)
	{
		$i = 0;
		while($lista = mysqli_fetch_array($query))
		{
			$x[$i]['idProjeto'] = $lista['idProjeto'];
			$x[$i]['protocolo'] = $lista['protocolo'];
			$x[$i]['nomeProjeto'] = $lista['nomeProjeto'];
			$x[$i]['proponente'] = $lista['nome'];
			$x[$i]['documento'] = $lista['cpf'];
			$x[$i]['areaAtuacao'] = $lista['areaAtuacao'];
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
			INNER JOIN area_atuacao AS ar on prj.idAreaAtuacao = ar.idArea
			WHERE prj.publicado = 1 $status_aprovado
			$filtro_razaoSocial $filtro_cnpj";
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0)
	{
		$i = 0;
		while($lista = mysqli_fetch_array($query))
		{
			$x[$i]['idProjeto'] = $lista['idProjeto'];
			$x[$i]['protocolo'] = $lista['protocolo'];
			$x[$i]['nomeProjeto'] = $lista['nomeProjeto'];
			$x[$i]['proponente'] = $lista['razaoSocial'];
			$x[$i]['documento'] = $lista['cnpj'];
			$x[$i]['areaAtuacao'] = $lista['areaAtuacao'];
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

	if($protocolo != '')
	{
		$filtro_protocolo = " AND protocolo LIKE '%$protocolo%'";
	}
	else
	{
		$filtro_protocolo = "";
	}

	if($idAreaAtuacao != 0)
	{
		$filtro_idAreaAtuacao = " AND idAreaAtuacao = '$idAreaAtuacao'";
	}
	else
	{
		$filtro_idAreaAtuacao = "";
	}

	if($valorAprovado != '')
	{
		$filtro_valorAprovado = " AND valorAprovado LIKE '%$valorAprovado%'";
	}
	else
	{
		$filtro_valorAprovado = "";
	}


	$sql = "SELECT * FROM projeto AS prj
			INNER JOIN area_atuacao AS ar on prj.idAreaAtuacao = ar.idArea
			WHERE prj.publicado = 1 $status_aprovado
			$filtro_nomeProjeto $filtro_protocolo $filtro_idAreaAtuacao $filtro_valorAprovado";
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0)
	{
		$i = 0;
		while($lista = mysqli_fetch_array($query))
		{
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
			$x[$i]['areaAtuacao'] = $lista['areaAtuacao'];
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
	<div class="container">
		<div class="form-group">
			<h4>Pesquisar Projetos</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
			<div class="col-md-offset-5 col-md-2">
				<form method="POST" action="../visual/index.php" class="form-horizontal" role="form">
					<input type="hidden" name="consulta" value="1">
					<button class='btn btn-theme btn-md btn-block' align= "center" type='submit' style="border-radius: 30px;">Fazer outra busca</button>
				</form>
			</div>
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
								echo "<td class='list_description'>
										<form method='POST' action='?perfil=consulta_publica_detalhes'>
											<input type='hidden' name='consulta' value='1'>
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