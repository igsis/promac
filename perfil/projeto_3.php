<?php
$con = bancoMysqli();
//$idProjeto = $_SESSION['idProjeto'];
$idProjeto = '2';
$idPf = $_SESSION['idUser'];
$arquivo = 0;

if(isset($_POST['insere']))
{
	$resumoProjeto = $_POST['resumoProjeto'];
	$curriculo = $_POST['curriculo'];

	$sql_insere = "UPDATE projeto SET
		resumoProjeto = '$resumoProjeto',
		curriculo = '$curriculo'
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

if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '2' AND idListaDocumento IN (18,19)";
	$query_arquivos = mysqli_query($con,$sql_arquivos);
	while($arq = mysqli_fetch_array($query_arquivos))
	{
		$y = $arq['idListaDocumento'];
		$x = $arq['sigla'];
		$nome_arquivo = $_FILES['arquivo']['name'][$x];
		$f_size = $_FILES['arquivo']['size'][$x];

		//Extensões permitidas
		$ext = array("PDF","pdf");

		if($f_size > 2097152) // 2MB em bytes
		{
			$mensagem = "Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 02 MB.";
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
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipo`, `idPessoa`, `idListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('2', '$idPf', '$y', '$new_name', '$hoje', '1'); ";
						$query = mysqli_query($con,$sql_insere_arquivo);

						if($query)
						{
							$mensagem = "Arquivo recebido com sucesso!";
						}
						else
						{
							$mensagem = "Erro ao gravar no banco!";
						}
					}
					else
					{
						$mensagem = "Erro no upload. Tete novamente!";
					}
				}
				else
				{
					$mensagem = "Erro no upload! Anexar documentos somente no formato PDF.";
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
		$mensagem =	"Arquivo apagado com sucesso!";
		gravarLog($sql_apagar_arquivo);
	}
	else
	{
		$mensagem = "Erro ao apagar o arquivo. Tente novamente!";
	}
}

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
?>
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
			<h4>Cadastro de Projeto</h4>
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=projeto_3" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Resumo do projeto*</label>
							<textarea name="resumoProjeto" class="form-control" rows="5" maxlength="500"><?php echo $projeto['resumoProjeto'] ?></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Currículo do proponente *</label>
							<textarea name="curriculo" class="form-control" rows="10" maxlength="5000"><?php echo $projeto['curriculo'] ?></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="insere" class="btn  btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/></div>
				</div>

				<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
							<?php 
							$pagina = "projeto_3";
							listaArquivosEvento($idPf, '2', $pagina) ?>
						</div>
					</div>
				</div>

				<!-- Upload de arquivo -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<div class = "center">
						<form method="POST" action="?perfil=projeto_3" enctype="multipart/form-data">
							<table>
								<tr>
									<td width="50%"><td>
								</tr>
								<?php
									$sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '2' AND idListaDocumento = '18'";
									$query_arquivos = mysqli_query($con,$sql_arquivos);
									while($arq = mysqli_fetch_array($query_arquivos))
									{
									?>
										<tr>
											<td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
										</tr>
								<?php
									}
									$sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '2' AND idListaDocumento = '19'";
									$query_arquivos = mysqli_query($con,$sql_arquivos);
									while($arq = mysqli_fetch_array($query_arquivos))
									{
									?>
										<tr>
											<td><label><?php echo $arq['documento']?></label></td><td><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
										</tr>
								<?php
									}
								?>
							</table><br>
							<input type="hidden" name="idPessoa" value="<?php echo $idPessoaFisica; ?>"  />
							<input type="hidden" name="tipoPessoa" value="<?php echo "2"; ?>"  />
							<input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>
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
									<button type="button" class="btn btn-danger" id="confirm">Apagar</button>
								</div>
							</div>
						</div>
					</div>
				<!-- Fim Confirmação de Exclusão -->

			</div>
		</div>
	</div>
</section>
