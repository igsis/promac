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
	<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<?php
				
			if($pj['liberado'] == 3)// liberação concedida pela SMC - liberado = 3
			{
			?>

			<div class="alert alert-success">
				<strong>Sua inscrição foi aprovada pela SMC.</strong>
				</div>
			</div>

			<?php
				include 'includes/resumo_dados_incentivador_pj.php';
				include 'includes/resumo_incentivador_representante_pj.php';
			?>	
				<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-12">
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
							<?php listaArquivosPessoaVisualizacao($idPj,$tipoPessoa,"arquivos_incentivador_pj"); ?>
						</div>
					</div>
				</div>

			<?php
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