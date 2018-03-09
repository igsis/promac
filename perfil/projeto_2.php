<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

if(isset($_POST['insere']))
{
	$valorProjeto = dinheiroDeBr($_POST['valorProjeto']);
	$valorIncentivo = dinheiroDeBr($_POST['valorIncentivo']);
	$valorFinanciamento = dinheiroDeBr($_POST['valorFinanciamento']);
	$idRenunciaFiscal = $_POST['idRenunciaFiscal'];

	$sql_insere = "UPDATE projeto SET
		valorProjeto = '$valorProjeto',
		valorIncentivo = '$valorIncentivo',
		valorFinanciamento = '$valorFinanciamento',
		idRenunciaFiscal = '$idRenunciaFiscal'
		WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_insere))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
?>
<section id="inserir" class="home-section bg-white">
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
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=projeto_2" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-3 col-md-2">
							<label>Valor total do <br/>projeto</label>
							<input type="text" name="valorProjeto" class="form-control" id="valor" value="<?php echo dinheiroParaBr($projeto['valorProjeto']) ?>" />
						</div>
						<div class="col-md-2">
							<label>Valor solicitado como incentivo</label>
							<input type="text" name="valorIncentivo" class="form-control" value="<?php echo dinheiroParaBr($projeto['valorIncentivo']) ?>" />
						</div>
						<div class="col-md-2">
							<label>Valor de outros financiamentos</label>
							<input type="text" name="valorFinanciamento" class="form-control" 	value="<?php echo dinheiroParaBr($projeto['valorFinanciamento']) ?>" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Enquadramento da renúncia fiscal *</label> ÍCONE
							<select class="form-control" name="idRenunciaFiscal" >
								<option value="0"></option>
								<?php echo geraOpcao("renuncia_fiscal","") ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="insere" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>