<?php

$con = bancoMysqli();
$idPj = $_SESSION['idUser'];
$tipoPessoa = '5';

if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '5'";
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
							$mensagem = "<font color='#01DF3A'><strong>Arquivo(s) recebido(s) com sucesso, utilize o menu para concluir e enviar sua inscrição para a SMC</strong></font>";

							$sql_insere_arquivo .= " Arquivo: arquivos_incentivador_pj.php";
							gravarLog($sql_insere_arquivo);

                            // Script para evitar reenvio dos arquivos qdo user atualiza a pagina logo após o envio
                            $urlAtual = urlAtual();
                            echo "<script>window.location = '$urlAtual';</script>";
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

$pj = recuperaDados("incentivador_pessoa_juridica","idPj",$idPj);

?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<h4>Documentos do Incentivador <br>
				<small>Pessoa Jurídica</small>
			</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>			    
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<?php
                if($pj['liberado'] == NULL OR $pj['liberado'] == 2 OR $pj['liberado'] == 4)
				{
				?>
				<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-12">
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
							<?php listaArquivosPessoa($idPj,$tipoPessoa,"arquivos_incentivador_pj"); ?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
						<div class="table-responsive list_info"><h6>Upload de Arquivo(s) Somente em PDF</h6>
						<form method="POST" action="?perfil=arquivos_incentivador_pj" enctype="multipart/form-data">
						<?php
                            if ($pj['imposto'] == 1)
                            {
                                $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '$tipoPessoa' AND idListaDocumento NOT IN (35,36) AND publicado = '1'";
                            }
                            elseif ($pj['imposto'] == 2)
                            {
                                $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '$tipoPessoa' AND idListaDocumento NOT IN (53,30) AND publicado = '1'";
                            }
                            elseif ($pj['imposto'] == 3)
                            {
                                $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '$tipoPessoa' AND publicado = '1'";
                            }
                            else
                            {
                                $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '$tipoPessoa' AND idListaDocumento NOT IN (35, 53, 30, 36) AND publicado = '1'";
                            }
							$documentos = [];
							$query_arquivos = mysqli_query($con,$sql_arquivos);
							while($arq = mysqli_fetch_array($query_arquivos))
							{
								$doc = $arq['documento'];
								$query = "SELECT idListaDocumento FROM lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='5'";
								$envio = $con->query($query);
								$row = $envio->fetch_array(MYSQLI_ASSOC);

								if(verificaArquivosExistentesIncentivador($idPj,$row['idListaDocumento'])){
									echo '<div class="alert alert-success">O arquivo ' . $doc . ' já foi enviado.</div>';
								}
								else{ 											
									$documento = (object) 
									[
										'nomeDocumento'	=>	$arq['documento'],
										'sigla' 		=>	 $arq['sigla']
									];
									array_push($documentos, $documento);									
								}
							}

							if ($documentos)
							{							
							?>
								<table class='table table-condensed'>
									<tr class='list_menu'>
										<td>Tipo de Arquivo</td>
										<td></td>
									</tr>									
										<?php 										
											foreach ($documentos as $documento) {	
												echo "<tr>";											
												echo 	"<td class='list_description'><label>$documento->nomeDocumento</label></td>";
												echo 	"<td class='list_description'><input type='file' name='arquivo[$documento->sigla]'></td>";												
												echo "<tr>";
											}
										?>	
								</table>
								<input type="hidden" name="idPessoa" value="<?php echo $idPj; ?>"  />
								<input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"  />
								<input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>
							<?php
								}
							?>							
						</form>
						</div>
					</div>
				</div>
				<!-- Fim Upload de arquivo -->
				
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

			<?php 
				}
				else
				{
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
			} 
			?>
	</div>
</section>
