<?php
$con = bancoMysqli();

if(isset($_POST['carregar']))
{
	$_SESSION['idProjeto'] = $_POST['carregar'];
}

$idProjeto = $_SESSION['idProjeto'];

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
	$sql_insere_projeto = "UPDATE projeto SET
		contratoGestao = '$contratoGestao',
		idAreaAtuacao = '$idAreaAtuacao'
		WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_insere_projeto))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Aguarde...</strong></font>";
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0.5;URL=?perfil=projeto_2'>";
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}

if(isset($_POST['insereAtuacao']))
{
	$idPf = $_SESSION['idUser'];
	$idAreaAtuacao = $_POST['idAreaAtuacao'];
	$sql_insere_projeto = "UPDATE projeto SET
		idAreaAtuacao = '$idAreaAtuacao'
		WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_insere_projeto))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Aguarde...</strong></font>";
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0.5;URL=?perfil=projeto_2'>";
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
    	<?php
    	if($projeto['tipoPessoa'] == 1)
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
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">

				<?php
				if($projeto['tipoPessoa'] == 2) //Pessoa Jurídica
				{
				?>
					<form method="POST" action="?perfil=projeto_edicao" class="form-horizontal" role="form">
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<strong>Possui Contrato de Gestão ou Termo de Colaboração com o Poder Público?* </strong>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="contratoGestao" value="1" <?php checar($projeto['contratoGestao']) ?>>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<label>Área de atuação *</label>
								<select class="form-control" name="idAreaAtuacao" >
									<option value="1"></option>
									<?php echo geraOpcao("area_atuacao",$projeto['idAreaAtuacao']) ?>
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
				if($projeto['tipoPessoa'] == 1) //Pessoa Física Cooperado
				{
				?>
					<div class="form-group">
						<form method="POST" action="?perfil=projeto_edicao" class="form-horizontal" role="form">
							<div class="col-md-offset-2 col-md-5">
								<label>Área de atuação *</label><br/>
								<select class="form-control" name="idAreaAtuacao" >
									<option value="1"></option>
									<?php echo geraOpcao("area_atuacao",$projeto['idAreaAtuacao']) ?>
								</select>
							</div>
							<div class="col-md-3"><label>&nbsp;</label><br/>
								<input type="submit" name="insereAtuacao" class="btn btn-theme btn-md btn-block" value="Inserir">
							</div>
						</form>
					</div>
					<?php
					if($cooperado == 1)
					{
						$pj= recuperaDados("pessoa_juridica", "idPj",$projeto['idPj']);
					?>
						<div class="form-group">
							<div class="col-md-offset-2 col-md-8"><hr/></div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-2 col-md-8" align="left">
								<strong>Cooperativa está representando:</strong> <?php echo $pj['razaoSocial'] ?>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-2 col-md-8"><br/></div>
						</div>

						<div class="form-group">
							<div class="col-md-offset-2 col-md-8">
								<strong>Deseja trocar de Cooperativa?</strong>
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
					<?php
					}
				}
				?>
			</div>
		</div>
	</div>
</section>