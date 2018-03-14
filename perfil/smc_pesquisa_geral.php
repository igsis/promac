<?php
$con = bancoMysqli();

if(isset($_POST['pesquisar']))
{
	$nome = $_POST['nome'];
	$cpf = $_POST['cpf'];
	$razaoSocial = $_POST['razaoSocial'];
	$cnpj = $_POST['cnpj'];
	$idProjeto = $_POST['idProjeto'];
	$inicioCronograma = $_POST['inicioCronograma'];
	$fimCronograma = $_POST['fimCronograma'];
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
				$x[$i]['idProjeto'] = $lista['$idProjeto'];
				$x[$i]['proponente'] = $lista['nome'];
				$x[$i]['documento'] = $lista['cpf'];
				$x[$i]['areaAtuacao'] = $area['areaAtuacao'];
				$x[$i]['status'] = $status['status'];
				$i++;
			}
			$x['num'] = $i;
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
				INNER JOIN pessoa_juridica AS pj ON prj.idPj = pf.idPj
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
				$x[$i]['idProjeto'] = $lista['$idProjeto'];
				$x[$i]['proponente'] = $lista['razaSocial'];
				$x[$i]['documento'] = $lista['cnpj'];
				$x[$i]['areaAtuacao'] = $area['areaAtuacao'];
				$x[$i]['status'] = $status['status'];
				$i++;
			}
			$x['num'] = $i;
		}
	}
	//Início Projeto
	else
	{
		if($idProjeto != '')
		{
			$filtro_idProjeto = " AND idProjeto = '$idProjeto'";
		}
		else
		{
			$filtro_idProjeto = "";
		}
		/*
		if($inicioCronograma != '')
		{
			$filtro_inicioCronograma = " AND inicioCronograma "
		}
		else
		{
			$filtro_inicioCronograma = "";
		}

		if($fimCronograma != '')
		{
			$filtro_fimCronograma
		}
		else
		{
			$filtro_fimCronograma = "";
		}
		*/
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
				$filtro_idProjeto $filtro_inicioCronograma $filtro_fimCronograma $filtro_idAreaAtuacao $filtro_idStatus";
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
				$pj = recuperaDados("pessoa_juridica","idPj",$lista['idPj']);S
				$x[$i]['idProjeto'] = $lista['$idProjeto'];
				$x[$i]['proponente'] = $lista['razaSocial'];
				$x[$i]['documento'] = $lista['cnpj'];
				$x[$i]['areaAtuacao'] = $area['areaAtuacao'];
				$x[$i]['status'] = $status['status'];
				$i++;
			}
			$x['num'] = $i;
		}
	}


	$mensagem = "Foram encontradas ".$x['num']." registros";
}
else
{
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container"><?php include 'includes/menu_smc.php'; ?>
			<div class="form-group">
				<h4>Pesquisar Projetos</h4>
				<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<form method="POST" action="?perfil=pesquisa_geral" class="form-horizontal" role="form">

						<hr/>

						<label>PESSOA FÍSICA</label>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-5"><label>Nome</label>
								<input type="text" name="nome" class="form-control" placeholder="">
							</div>
							<div class="col-md-3"><label>CPF</label>
								<input type="text" name="cpf" id="cpf" class="form-control" placeholder="">
							</div>
						</div>

						<hr/>

						<label>PESSOA JURÍDICA</label>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-5"><label>Razão Social</label>
								<input type="text" name="razaoSocial" class="form-control" placeholder="">
							</div>
							<div class="col-md-3"><label>CNPJ</label>
								<input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="">
							</div>
						</div>

						<hr/>

						<div class="form-group">
							<div class="col-md-offset-2 col-md-8"><label>Código do projeto</label>
								<input type="text" name="idProjeto" class="form-control" placeholder="">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-2 col-md-6"><label>Início Cronograma</label>
								<input type="text" name="inicioCronograma" class="form-control" placeholder="">
							</div>
							<div class="col-md-6"><label>Fim Cronograma</label>
								<input type="text" name="fimCronograma" class="form-control" placeholder="">
							</div>
						</div>


						<div class="form-group">
							<div class="col-md-offset-2 col-md-8"><label>Área atuação</label>
								<select class="form-control" name="idAreaAtuacao" >
									<option value="0"></option>
									<?php echo geraOpcao("area_atuacao","") ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-2 col-md-8"><label>Status</label>
								<select class="form-control" name="idStatus" >
									<option value="0"></option>
									<?php echo geraOpcao("status","") ?>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<input type="submit" name="pesquisar" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
<?php
}
?>