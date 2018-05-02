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
				if($pj['liberado'] == 0) // ainda não foi solicitado liberação
				{
					include 'includes/resumo_incentivador_pj.php';
				?>
					<div class="alert alert-info">
						Após o preenchimento de todos os dados pessoais, conclua a inscrição do proponente e aguarde a análise da sua documentação pela Secretaria Municipal de Cultura.
					</div>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<?php							
							if ($cpo == false)							{
								
								$idPess = $pj['idPj'];
								$queryArquivos = 
								  "SELECT 
								    idUploadArquivo 
								   FROM 
								     upload_arquivo 
								   WHERE 
								     idPessoa = $idPess 
								   AND idTipo = '5' AND publicado = '1'";
								
								$enviaArquivos = mysqli_query($con, $queryArquivos);
								$numRow = mysqli_num_rows($enviaArquivos);
								if($numRow == 8)
								{?>
							<form class="form-horizontal" role="form" action="?perfil=incentivador_concluir_pj" method="post">
								<input type="submit" name="liberacao" value="Concluir inscrição do Incentivador" class="btn btn-theme btn-lg btn-block">
							</form>
							<?php
							}
							else{
								echo "<div class='alert alert-warning'>
								<strong>Erro: </strong> Você deve enviar todos os documentos para prosseguir.
								</div>";
							}
						}?>
						</div>
					</div>
			</div>
			<?php
				}
				elseif($pj['liberado'] == 1)// foi solicitado liberação, porém a SMC não analisou ainda.
				{
			?>
					<div class="alert alert-success">
						<strong>Sua solicitação de inscrição foi enviada com sucesso à Secretaria Municipal de Cultura. Aguarde a análise da documentação.</strong>
					</div>
			<?php
				}
				elseif(($pj['liberado'] == 2) || ($pj['liberado'] == 4))// a liberação de projetos foi rejeitada pela SMC.
				{
					if ($pj['liberado'] == 2) 
					{
						
					
			?>
					<div class="alert alert-danger">
						<strong>Sua inscrição para incentivo foi rejeitada pela Secretaria Municipal de Cultura.</strong>
					</div>
			<?php 
					}
					else // liberado == 4
					{
			?>
					<div class="alert alert-danger">
						<strong>Sua inscrição para incentivo foi liberada para edição.</strong>
					</div>
			<?php 
					}
			?>
					<div>
				 		<?php listaArquivosPessoaObs($idPj,5) ?>
				 	</div>
				 	<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<form class="form-horizontal" role="form" action="?perfil=incentivador_concluir_pj.php" method="post">
								<input type="submit" name="liberacao" value="Concluir inscrição do Incentivador" class="btn btn-theme btn-lg btn-block">
							</form>
						</div>
					</div>
			<?php
				}
				else // liberação concedida pela SMC - liberado = 3
				{
			?>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">Sua inscrição foi aprovada pela SMC.</div><br/>
					</div>
				<?php
					include 'includes/resumo_incentivador_pj.php';
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
