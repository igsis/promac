<?php
$con = bancoMysqli();

$idPf = $_POST['carregar'];
$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
$tipoPessoa = 1;

if(isset($_POST['liberacao']))
{
	$sql_liberacao = "UPDATE pessoa_fisica SET liberado = 1 WHERE idPf = '$idPf'";
	if(mysqli_query($con,$sql_liberacao))
	{
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=projeto_pf'>";
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao atualizar! Tente novamente.</strong></font> <br/>".$sql_atualiza_pf;
	}
}
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Detalhes Pessoa Física</h4>
				<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<p>Lista todos os campos da PF</p>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong> <?php echo $pf['nome']; ?><br/>
					</div>
				</div>

				<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						(Documento | combobox status | campo observação | botão gravar)
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
							<?php listaArquivosPessoa($idPf,$tipoPessoa,"arquivos_pf"); ?>
						</div>
					</div>
				</div>

				<!-- Botão para Liberar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6">
						<form class="form-horizontal" role="form" action="?perfil=smc_detalhes_pf" method="post">
							<input type="hidden" name="liberarPf" value="<?php echo $idPf ?>">
							<input type="submit" value="Liberar Acesso" class="btn btn-theme btn-lg btn-block">
						</form>
					</div>
					<div class="col-md-6">
						<form class="form-horizontal" role="form" action="?perfil=smc_detalhes_pf" method="post">
							<input type="hidden" name="naoLiberarPf" value="<?php echo $idPf ?>">
							<input type="submit" value="Não Liberar Acesso" class="btn btn-theme btn-lg btn-block">
						</form>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

			</div>
		</div>
	</div>
</section>
