<?php
$con = bancoMysqli();

if(isset($_POST['novoPj'])) //tipoePessoa = 2
{
	$idPj = $_SESSION['idUser'];
	$idAreaAtuacao = $_POST['idAreaAtuacao'];
	if(isset($_POST['contratoGestao']))
	{
		$contratoGestao = $_POST['contratoGestao'];
	}
	else
	{
		$contratoGestao = 0;
	}
	$sql_insere_projeto = "INSERT INTO projeto (idPj, contratoGestao, tipoPessoa, idAreaAtuacao, idStatus, publicado) VALUES ('$idPj', '$contratoGestao', 2, '$idAreaAtuacao', 1, 1)";
	if(mysqli_query($con,$sql_insere_projeto))
	{
		$sql_ultimo = "SELECT idProjeto FROM projeto ORDER BY idProjeto DESC LIMIT 0,1";
		$query_ultimo = mysqli_query($con,$sql_ultimo);
		$ultimoProjeto = mysqli_fetch_array($query_ultimo);
		$_SESSION['idProjeto']  = $ultimoProjeto['idProjeto'];
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Aguarde...</strong></font>";
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0.5;URL=?perfil=projeto_2'>";
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao gravar! Tente novamente.</strong></font> <br/>";
	}
}

if(isset($_POST['insereAtuacao']))
{
	$idPf = $_SESSION['idUser'];
	$idAreaAtuacao = $_POST['idAreaAtuacao'];
	$sql_insere_projeto = "INSERT INTO projeto (idPf, tipoPessoa, idAreaAtuacao, idStatus, publicado) VALUES ('$idPf', 1, '$idAreaAtuacao', 1, 1)";
	if(mysqli_query($con,$sql_insere_projeto))
	{
		$sql_ultimo = "SELECT idProjeto FROM projeto ORDER BY idProjeto DESC LIMIT 0,1";
		$query_ultimo = mysqli_query($con,$sql_ultimo);
		$ultimoProjeto = mysqli_fetch_array($query_ultimo);
		$_SESSION['idProjeto']  = $ultimoProjeto['idProjeto'];
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! </strong></font>";
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao gravar! Tente novamente.</strong></font> <br/>";
	}
}
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
    	<?php
    	if($_SESSION['tipoPessoa'] == 1)
		{
			$idPf= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pf.php';
			$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
			$cooperado = $pf['cooperado'];
		}
		else
		{
			$idPj= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pj.php';
		}
    	?>
		<div class="form-group">
			<h4>Cadastro de Projeto</h4>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">

				<?php
				if($_SESSION['tipoPessoa'] == 2) //Pessoa Jurídica
				{
				?>
					<form method="POST" action="?perfil=projeto_novo" class="form-horizontal" role="form">
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<strong>Possui Contrato de Gestão ou Termo de Colaboração com o Poder Público?* </strong>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="contratoGestao" value="1">
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<label>Área de atuação *</label>
								<select class="form-control" name="idAreaAtuacao" >
									<option value="0"></option>
									<?php echo geraAreaAtuacao("area_atuacao",2) ?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<input type="submit" name="novoPj" class="btn btn-theme btn-md btn-block" value="gravar">
							</div>
						</div>
					</form>
				<?php
				}
				elseif($_SESSION['tipoPessoa'] == 1 && $cooperado == 1) //Pessoa Física Cooperado
				{
					if(!isset($_SESSION['idProjeto']))
					{
				?>
						<div class="form-group">
							<form method="POST" action="?perfil=projeto_novo" class="form-horizontal" role="form">
								<div class="col-md-offset-2 col-md-5">
									<label>Área de atuação *</label><br/>
									<select class="form-control" name="idAreaAtuacao" >
										<option value="0"></option>
										<?php echo geraAreaAtuacao("area_atuacao",2) ?>
									</select>
								</div>
								<div class="col-md-3"><label>&nbsp;</label><br/>
									<input type="submit" name="insereAtuacao" class="btn btn-theme btn-md btn-block" value="Inserir">
								</div>
							</form>
						</div>
					<?php
					}
					if(isset($_SESSION['idProjeto']))
					{
					?>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<strong>Qual cooperativa está representando?* </strong>
								<p><strong>Insira o CNPJ</strong></p>
								</div>
							</div>
							<div class="form-group">
								<form method="POST" action="?perfil=cooperativa_resultado_busca" class="form-horizontal" role="form">
									<div class="col-md-offset-4 col-md-3">
										<input type="text" name="busca" class="form-control" placeholder="CNPJ" id="cnpj" >
									</div>
									<div class="col-md-2">
										<input type="submit" name="pesquisar" class="btn btn-theme btn-md btn-block" value="Pesquisar">
									</div>
								</form>
							</div>
						</div>
					<?php
					}
				}
				else
				{
					if($_SESSION['tipoPessoa'] == 1 && $cooperado == 0 && !isset($_SESSION['idProjeto']))
					{
				?>
						<div class="form-group">
							<form method="POST" action="?perfil=projeto_novo" class="form-horizontal" role="form">
								<div class="col-md-offset-2 col-md-5">
									<label>Área de atuação *</label><br/>
									<select class="form-control" name="idAreaAtuacao" >
										<option value="0"></option>
										<?php echo geraAreaAtuacao("area_atuacao", 2) ?>
									</select>
								</div>
								<div class="col-md-3"><label>&nbsp;</label><br/>
									<input type="submit" name="insereAtuacao" class="btn btn-theme btn-md btn-block" value="Inserir">
								</div>
							</form>
						</div>
				<?php
					}
					else
					{
						echo "<meta HTTP-EQUIV='refresh' CONTENT='0.5;URL=?perfil=projeto_2'>";
					}
				}
				?>
			</div>
		</div>
	</div>
</section>
