<?php
$con = bancoMysqli();
$tipoPessoa = '4';

$idPf = $_SESSION['idUser'];
$pf = recuperaDados("incentivador_pessoa_fisica","idPf",$idPf);
$campos = array($pf['nome'], $pf['cpf'], $pf['rg'], $pf['email'], $pf['cep'], $pf['numero']);
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
  $idUser = $idPf;
  $idProjeto = 0; /*Incluso devido a busca pelos anexos*/
  require_once('validacaoArquivosObrigatorios.php');
endif;

if(isset($_POST['liberacao']))
{
	$date = date('Y:m:d H:i:s');
	$sql_liberacao = "UPDATE incentivador_pessoa_fisica SET liberado = 1, dataInscricao = '$date' WHERE idPf = '$idPf'";
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
				
			if($pf['liberado'] == 3)// liberação concedida pela SMC - liberado = 3
			{
			?>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">Sua inscrição foi aprovada pela SMC.</div><br/>
				</div>
			<?php
				include 'includes/resumo_incentivador_pf.php';
			}else {
			?>
				<div class="form-group">
					<div class="alert alert-warning">
						<div class="col-md-offset-2 col-md-8">Inscrição em andamento.</div><br/>
					</div>
				</div>
			<?php
			}
			?>
		</div>
		<!-- Confirmação de Exclusão -->
			<div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Excluir Arquivo?</h4>
						</div>
						<div class="modal-body">
							<p>Confirma?</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							<button type="button" class="btn btn-danger" id="confirm">Remover</button>
						</div>
					</div>
				</div>
			</div>
		<!-- Fim Confirmação de Exclusão -->
	</div>
</section>