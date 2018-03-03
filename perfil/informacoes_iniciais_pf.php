<?php

$con = bancoMysqli();
$idPf = $_SESSION['idUser'];


if(isset($_POST['atualizarFisica']))
{
	$nome = addslashes($_POST['nome']);
	$rg = $_POST['rg'];
	$telefone = $_POST['telefone'];
	$celular = $_POST['celular'];
	$email = $_POST['email'];
	$cooperado = $_POST['cooperado'];

	$sql_atualiza_pf = "UPDATE pessoa_fisica SET
	`nome` = '$nome',
	`rg` = '$rg',
	`telefone` = '$telefone',
	`celular` = '$celular',
	`email` = '$email',
	`cooperado` = '$cooperado'
	WHERE `idPf` = '$idPf'";

	if(mysqli_query($con,$sql_atualiza_pf))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
		gravarLog($sql_atualiza_pf);
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao atualizar! Tente novamente.</strong></font> <br/>".$sql_atualiza_pf;
	}
}

if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM upload_lista_documento WHERE idTipoUpload = '$tipoPessoa' AND id IN (2,3,25,31)";
	$query_arquivos = mysqli_query($con,$sql_arquivos);
	while($arq = mysqli_fetch_array($query_arquivos))
	{
		$idPf = $_SESSION['idPf'];
		$y = $arq['id'];
		$x = $arq['sigla'];
		$nome_arquivo = $_FILES['arquivo']['name'][$x];
		$f_size = $_FILES['arquivo']['size'][$x];

		//Extensões permitidas
		$ext = array("PDF","pdf");

		if($f_size > 3145728) // 3MB em bytes
		{
			$mensagem = "<font color='#01DF3A'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 03 MB.</strong></font>";
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
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipoPessoa`, `idPessoa`, `idUploadListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPf', '$y', '$new_name', '$hoje', '1'); ";
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

if(isset($_POST['apagar']))
{
	$idArquivo = $_POST['apagar'];
	$sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE id = '$idArquivo'";
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

$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h4>Informações Iniciais</h4>
				<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=informacoes_iniciais_pf" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
							<input type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $pf['nome']; ?>" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CPF *:</strong><br/>
							<input type="text" readonly class="form-control" id="cpf" name="cpf" placeholder="CPF" value="<?php echo $pf['cpf']; ?>" >
						</div>
						<div class="col-md-6"><strong>RG ou RNE *:</strong><br/>
							<input type="text" class="form-control" name="rg" placeholder="Número do Documento" value="<?php echo $pf['rg']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>E-mail *:</strong><br/>
							<input type="text" class="form-control" name="email" placeholder="E-mail" value="<?php echo $pf['email']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Telefone :</strong><br/>
							<input type="text" class="form-control" name="telefone" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone']; ?>">
						</div>
						<div class="col-md-6"><strong>Celular:</strong><br/>
							<input type="text" class="form-control" name="celular" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['celular']; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-4 col-md-2"><strong>É cooperado? *</strong> não ta gravando
						</div>
						<div class="col-md-2">
							<input type="checkbox" name="cooperado" value="on" checked="checked">
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="atualizarFisica" value="<?php echo $idPf ?>">
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Botão para Prosseguir -->
				<div class="form-group">
					<form class="form-horizontal" role="form" action="?perfil=arquivos_pf" method="post">
						<div class="col-md-offset-8 col-md-2">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPf ?>">
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</section>