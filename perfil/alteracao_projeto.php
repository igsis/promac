<?php

$con = bancoMysqli();
$idProjeto = $_GET['idProjeto'];
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$tipoPessoa = '3';

// Gerar documentos
$server = "http://".$_SERVER['SERVER_NAME']."/promac";
$http = $server."/pdf/";


function pegaStatus($id)
{
	$con = bancoMysqli();
	$pegaNome = "SELECT etapaProjeto FROM etapa_projeto WHERE idEtapaProjeto = '$id'";
	$enviaNome = mysqli_query($con, $pegaNome);
	$row = mysqli_fetch_array($enviaNome);
	return $row['status'];
}

function listaArquivosPessoaComStatus($idPessoa,$tipoPessoa,$pagina)
{
	$con = bancoMysqli();
	$sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'
			AND list.idListaDocumento IN (47)";
	$query = mysqli_query($con,$sql);
	$linhas = mysqli_num_rows($query);

	if ($linhas > 0)
	{
	echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Nome do arquivo</td>
					<td width='15%'></td>
				</tr>
			</thead>
			<tbody>";
				while($arquivo = mysqli_fetch_array($query))
				{
					echo "<tr>";
					echo "<td class='list_description'>(".$arquivo['documento'].")</td>";
					echo "<td class='list_description'><a href='../uploadsdocs/".$arquivo['arquivo']."' target='_blank'>". mb_strimwidth($arquivo['arquivo'], 15 ,25,"..." )."</a></td>";
					$status = pegaStatus($arquivo['idStatusDocumento']);

					echo "<td class='list_description'>".$status."</td>";
					echo "<td class='list_description'>".$arquivo['observacoes']."</td>";
					echo "
						<td class='list_description'>
							<form id='apagarArq' method='POST' action='?perfil=".$pagina."'>
								<input type='hidden' name='idPessoa' value='".$idPessoa."' />
								<input type='hidden' name='tipoPessoa' value='".$tipoPessoa."' />
								<input type='hidden' name='apagar' value='".$arquivo['idUploadArquivo']."' />
						</td>
							</form>";
					echo "</tr>";
				}
				echo "
		</tbody>
		</table>";
	}
	else
	{
		echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
	}
}

if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '3' AND idListaDocumento IN (47)";
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
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipo`, `idPessoa`, `idListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('3', '$idProjeto', '$y', '$new_name', '$hoje', '1'); ";
						$sql_status = "UPDATE projeto SET idEtapaProjeto = '14', idStatus = 1 WHERE idProjeto = '$idProjeto'";
                        $sql_historico = "INSERT INTO historico_etapa (idProjeto, idEtapaProjeto, data) VALUES ('$idProjeto', '14', '$hoje')";
						$query = mysqli_query($con,$sql_insere_arquivo);
						$query = mysqli_query($con,$sql_status);
                        $query = mysqli_query($con,$sql_historico);
						if($query)
						{
							$mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
							gravarLog($sql_insere_arquivo);
							gravarLog($sql_status);
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

//$pf = recuperaDados("pessoa_fisica","idPf",$idPf);

?>

<!-- Chamamento Alert-->
<thead>
	<script src="js/sweetalert.min.js"></script>
    <link href="css/sweetalert.css" rel="stylesheet" type="text/css"/>
<script>
	function alerta()
	{
    swal({   title: "Atenção!", 
	text: "Certifique-se que sua documentação está correta antes do envio.",
	timer: 10000,   
	confirmButtonColor:	"#5b6533",
	showConfirmButton: true });}
	window.onload = alerta();
	</script>
</thead>

<section id="list_items" class="home-section bg-white">
	<div class="container">
		<?php
    	if($_SESSION['tipoPessoa'] == 1)
		{
			$idPf= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pf.php';
		}
		else
		{
			$idPj= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pj.php';
		}
    	?>
		<div class="form-group">
			<h4>Anexos</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>

		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-12">
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
							<?php listaArquivosPessoaComStatus($idProjeto,'3',"alteracao_projeto&idProjeto=$idProjeto"); ?>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-12">
						<div class="table-responsive list_info"><h6>Upload de Arquivo(s) Somente em PDF com tamanho máximo de 5MB.</h6>
						<form method="POST" action="?perfil=alteracao_projeto&idProjeto=<?=$idProjeto?>" enctype="multipart/form-data">
							<table class='table table-condensed'>
								<tr class='list_menu'>
									<td>Tipo de Arquivo</td>
									<td></td>
								</tr>
								<?php
								  $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '3' AND idListaDocumento IN (47)";
									$query_arquivos = mysqli_query($con,$sql_arquivos);
									while($arq = mysqli_fetch_array($query_arquivos))
									{
								?>
										<tr>
											<?php
											$doc = $arq['documento'];
											$query = "SELECT idListaDocumento FROM lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='3' AND idListaDocumento IN (47)";
											$envio = $con->query($query);
											$row = $envio->fetch_array(MYSQLI_ASSOC);
											 ?>
											<?php 
										    $urlArquivo = $http.$arq['idListaDocumento'];
											if(arquivosExiste($urlArquivo)): ?>	
											  <td class="list_description path">
                                                <?php
                                                 $path = selecionaArquivoAnexo(
                                                  $http, $arq['idListaDocumento']); ?>
                                                  <a href='<?=$path?>'  
                                                  	 target="_blank">
                                                     <?=$arq['documento'] ?> 	
                                                  </a>
                                              </td>	
                                            <?php else: ?>
                                              <td class="list_description path">
                                                <?=$arq['documento']?>	
                                              </td>	
                                            <?php endif ?> 
											<td class="list_description"><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
											<?php } ?>
										</tr>
							
							</table>
							<input type="hidden" name="idPessoa" value="<?php echo $idProjeto; ?>"  />
							<input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"  />
							<input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>
						</form>
						</div>
					</div>
				</div>
				<!-- Fim Upload de arquivo -->

                <!-- Botão para Voltar -->
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-6">
                        <?php
				if($projeto['tipoPessoa'] == 1)
				{
				?>
               		 <form class="form-horizontal" role="form" action="?perfil=projeto_pf" method="post">
                <?php
				}
				else
				{
				?>
                    <form class="form-horizontal" role="form" action="?perfil=projeto_pj" method="post">
                <?php
				}
				?>
                   		 <input type="submit" value="Voltar" class="btn btn-theme btn-md btn-block">
                    </form>
                    </div>
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
		</div>
	</div>
</section>
