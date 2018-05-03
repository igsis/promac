<?php 
$con = bancoMysqli();
$tipoPessoa = '5';

$idPj = $_SESSION['idUser'];
$pj = recuperaDados("incentivador_pessoa_juridica","idPj",$idPj);
$rl = recuperaDados("representante_legal","idRepresentanteLegal",$idPj);
$campos = array($pj['razaoSocial'], $pj['cnpj'], $pj['email'], $pj['cep'], $pj['numero']);
$cpo = false;

foreach ($campos as $cpos)
{
	if ($cpos == null)
	{
		$cpo = true;
	}
}

/**Arquivos Obrigatórios**/
if(isset($tipoPessoa)):
  $tipoDoc = 'proponente';
  $idUser = $idPj;
  $idProjeto = 0; /*Incluso devido a busca pelos anexos*/
  require_once('validacaoArquivosObrigatorios.php');
endif;

if(isset($_POST['liberacao']))
{
	$date = date('Y:m:d H:i:s');
	$sql_liberacao = "UPDATE incentivador_pessoa_juridica SET liberado = 1, dataInscricao = '$date' WHERE idPj = '$idPj'";
	if(mysqli_query($con,$sql_liberacao))
	{
		$mensagem = "Sua inscrição foi enviada à SMC!";
		gravarLog($sql_liberacao);
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao atualizar! Tente novamente.</strong></font> <br/>";
	}
}
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<?php
				
				if ($pj['liberado'] == 3) // liberação concedida pela SMC - liberado = 3
				{
			?>
					<div class="form-group">
						<div class="alert alert-info">
							<div class="col-md-offset-2 col-md-8">Sua inscrição foi aprovada pela SMC.</div><br/>
						</div>
					</div>
				<?php
					include 'includes/resumo_incentivador_pj.php';
				}else{
				?>
				<div class="form-group">
						<div class="alert alert-info">
							<div class="col-md-offset-2 col-md-8">Inscrição em andamento</div><br/>
						</div>
					</div>
				<?php
				}
				?>
		</div>

	</div>
</section>
