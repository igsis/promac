<?php

$con = bancoMysqli();
$idPj = $_SESSION['idUser'];
$tipoPessoa = '2';

$rl = recuperaDados("representante_legal","idRepresentanteLegal",$pj['idRepresentanteLegal']);
$campos = array($pj['razaoSocial'], $pj['cnpj'], $pj['email'], $pj['cep'], $pj['numero']);
$cpo = false;

foreach ($campos as $cpos) {
	if ($cpos == null)
	{
		$cpo = true;
	}
}
// Enviar projeto para analise 
if(isset($_POST['liberacao']))
{
	$sql_liberacao = "UPDATE pessoa_juridica SET liberado = 1 WHERE idPj = '$idPj'";
	if(mysqli_query($con,$sql_liberacao))
	{
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=resultado_inscricao_pj'>";
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
	}
}

/**Arquivos Obrigatórios**/
if(isset($tipoPessoa)):
  $tipoDoc = 'proponente';
  $idUser = $idPj;
  $idProjeto = 0; /*Incluso devido a busca pelos anexos*/
  require_once('validacaoArquivosObrigatorios.php');
endif;

// Gerar documentos
$server = "http://".$_SERVER['SERVER_NAME']."/promac";
$http = $server."/pdf/";

if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '$tipoPessoa'";
	$query_arquivos = mysqli_query($con,$sql_arquivos);
	while($arq = mysqli_fetch_array($query_arquivos))
	{
		$y = $arq['idListaDocumento'];
		$x = $arq['sigla'];
		$nome_arquivo = isset($_FILES['arquivo']['name'][$x]) ? $_FILES['arquivo']['name'][$x] : null;
		$f_size = isset($_FILES['arquivo']['size'][$x]) ? $_FILES['arquivo']['size'][$x] : null;

		//Extensões permitidas
		$ext = array("PDF","pdf");
		
		if($f_size > 5242880) // 5MB em bytes
		{
			$mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></font>";
		}
		else
		{
			if($nome_arquivo != "")
			{
				$nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
				$new_name = date("YmdHis")."_".semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
				$hoje = date("Y-m-d H:i:s");
				$dir = '../uploadsdocs/'; //Diretório para uploads				
				$allowedExts = array(".pdf", ".PDF"); //Extensões permitidas
				$ext = strtolower(substr($nome_arquivo,-4));

				if(in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas
				{
					if(move_uploaded_file($nome_temporario, $dir.$new_name))
					{
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipo`, `idPessoa`, `idListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPj', '$y', '$new_name', '$hoje', '1'); ";
						$query = mysqli_query($con,$sql_insere_arquivo);
						if($query)
						{
							$mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
							gravarLog($sql_insere_arquivo);
						}
						else
						{
							$mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco.</strong></font>";
						}
					}
					else
					{
						$mensagem = "<font color='#FF0000'><strong>Erro no upload! Tente novamente.</strong></font>";
					}
				}
				else
				{
					$mensagem = "<font color='#FF0000'><strong>Erro no upload! Anexar documentos somente no formato PDF.</strong></font>";
				}
			}
		}
	}
}

// Apagar uploads da validação
if(isset($_POST['apagar']))
{
	$idArquivo = $_POST['apagar'];
	$sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE idUploadArquivo = '$idArquivo'";
	if(mysqli_query($con,$sql_apagar_arquivo))
	{
		$mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
		gravarLog($sql_apagar_arquivo);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
	}
}

$pj = recuperaDados("pessoa_juridica","idPj",$idPj);

?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<!-- <h4>Resultado da Inscrição</h4> -->
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<?php
				if($pj['liberado'] == 0)// ainda não foi solicitado liberação
				{

				include 'includes/resumo_pj.php';
				?>
				<div class="alert alert-info">
					Após o preenchimento de todos os dados pessoais, conclua a inscrição do proponente e aguarde a análise da sua documentação pela Secretaria Municipal de Cultura.
				</div>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<?php
						if ($cpo == false)
						{
							$queryArquivos = "SELECT idUploadArquivo FROM upload_arquivo WHERE idPessoa = $idPj AND idTipo = '2' AND publicado = '1'";
							$enviaArquivos = mysqli_query($con, $queryArquivos);
							$numRow = mysqli_num_rows($enviaArquivos);

							if($numRow != 0)
							{?>
						<form class="form-horizontal" role="form" action="?perfil=resultado_inscricao_pj" method="post">
							<input type="submit" name="liberacao" value="Concluir inscrição do proponente" class="btn btn-theme btn-lg btn-block">
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
				<?php
				} // Fim liberado 0 ou null

				if($pj['liberado'] == 1)// foi solicitado liberação, porém a SMC não analisou ainda.
				{
				?>
				<div class="alert alert-success">
					<strong>Sua solicitação de inscrição foi enviada com sucesso à Secretaria Municipal de Cultura. Aguarde a análise da documentação.</strong>
				</div>
				<?php
				}// Fim liberado 1

				if(($pj['liberado'] == 2) || ($pj['liberado'] == 4))// a liberação de projetos foi rejeitada pela SMC.
				{
					if ($pj['liberado'] == 2)
					{
				?>
						<div class="alert alert-danger">
							<strong>Sua solicitação para a liberação de envio de projetos foi rejeitada pela Secretaria Municipal de Cultura.</strong>
						</div>
				<?php 
					}
					else // Liberado 4
					{
				?>		

						<div class="alert alert-danger">
							<strong>Seu cadastro foi desbloqueado para edição</strong>
						</div>

				<?php 
					}
				?>
				<!-- Exibir Staus da incrição  -->
				<div>
			 		<?php listaArquivosPessoaObs($idPj,2) ?>
			 	</div>

				<div class='alert alert-warning'>Reenvie o arquivo com as alterações sujeridas.</div>

			 	<!-- Exibir arquivos Pendentes-->
				<div class="form-group">
					<div class="col-md-12">
						<div class="table-responsive list_info"><h6>Documentos não aprovados</h6>
							<?php listaArquivosPendentePessoa($idPj,$tipoPessoa,"resultado_inscricao_pj"); ?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
						<div class="table-responsive list_info"><h6>Upload de Arquivo(s) Somente em PDF</h6>
						<form method="POST" action="?perfil=resultado_inscricao_pj" enctype="multipart/form-data">
							<table class='table table-condensed'>
								<tr class='list_menu'>
									<td>Tipo de Arquivo</td>
									<td></td>
								</tr>
								<?php
									$sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '$tipoPessoa'";
									$query_arquivos = mysqli_query($con,$sql_arquivos);
									while($arq = mysqli_fetch_array($query_arquivos))
									{
								?>
										<tr>
											<?php
											$doc = $arq['documento'];
											$query = "SELECT idListaDocumento FROM lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='2'";
											$envio = $con->query($query);
											$row = $envio->fetch_array(MYSQLI_ASSOC);

											if(verificaArquivosExistentesPF($idPj,$row['idListaDocumento'])){
												echo '<div class="alert alert-success">O arquivo ' . $doc . ' já foi enviado.</div>';
											}
											elseif ($arq['idListaDocumento'] == 15) 
											{?>
											  <td class="list_description path">
                                                <?php              
                                                 $path = selecionaArquivoAnexo(
                                                  $http, $arq['idListaDocumento']); ?>                  
                                                  <a href='<?=$path?>'  
                                                  	 target="_blank">
                                                     <?=$arq['documento'] ?> 	
                                                  </a>
                                              </td>
                                              <td class="list_description"><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
											
                                      <?php }	else { ?>
                                              <td class="list_description path">
                                                <?=$arq['documento']?>	
                                              </td>	
											<td class="list_description"><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
                                            <?php } ?>  
										</tr>
								<?php
									}
								?>
							</table><br>
							<input type="hidden" name="idPessoa" value="<?php echo $idPj; ?>"  />
							<input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"  />
							<input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>
						</form>
						</div>
					</div>
				</div>
				<!-- Fim Upload de arquivo -->

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<form class="form-horizontal" role="form" action="?perfil=resultado_inscricao_pj" method="post">
							<input type="submit" name="liberacao" value="Concluir inscrição do proponente" class="btn btn-theme btn-lg btn-block">
						</form>
					</div>
				</div>

				<?php
				} // Fim liberado 2 e 4
				?>
				
				<?php 
				if($pj['liberado'] == 3)
				{
					echo "<div class='alert alert-warning'>
				  	<strong>Aviso!</strong> Seus dados já foram aceitos, portanto, não podem ser alterados.</div>";

				} // Fim liberado 3
				?>
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
		</div>
	</div>
</section>
