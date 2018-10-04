<?php
$con = bancoMysqli();
$tipoPessoa = '2';

if(isset($_POST['liberado']))
{
	$idPj = $_POST['liberado'];
}
else if(isset($_POST['idPessoa']))
{
	$idPj = $_POST['idPessoa'];
}
else if (isset($_POST['LIBPF']))
{
	$idPj = $_POST['LIBPF'];
}
else
{
	$idPj = null;
}

if($idPj == null)
{
	$idPj = $_POST['idPj'];
}

if(isset($_POST['reaprovar']))
{
	$idPj = $_POST['idPj'];
	$sql = "UPDATE pessoa_juridica SET liberado = 3 WHERE idPj = '$idPj'";
	if(mysqli_query($con,$sql))
	{
		$mensagem = "<font color='#01DF3A'>Cadastro aprovado com sucesso!</font>";
	}
	else
	{
		$mensagem = "<font color='#FF0000'>Erro ao aprovar cadastro. Por favor, tente novamente!</font>";
	}
}

if(isset($_POST['negar']))
{
	$idPj = $_POST['idPj'];
	$sql = "UPDATE pessoa_juridica SET liberado = 2 WHERE idPj = '$idPj'";
	$negar = mysqli_query($con, $sql);
	if($negar)
	{
		$mensagem = "<font color='#01DF3A'>Cadastro reprovado com sucesso!</font>";
        gravarLog($negar);

	}
	else
	{
		$mensagem = "<font color='#FF0000'>Erro ao reprovar cadastro. Por favor, tente novamente!</font>";
	}
}

function listaArquivosPessoaEditorr($idPessoa,$tipoPessoa,$pagina)
{

	$con = bancoMysqli();
	$sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'";
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
					<td width='15%'>Status</td>
					<td>Observações</td>
				</tr>
			</thead>
			<tbody>";
				echo "
				<form id='atualizaDoc' method='POST' action='?perfil=smc_reaprova_pj'>";
				$count = 0;
				while($arquivo = mysqli_fetch_array($query))
				{
					echo "<tr>";
					echo "<td class='list_description'>(".$arquivo['documento'].")</td>";
					echo "<td class='list_description'><a href='../uploadsdocs/".$arquivo['arquivo']."' target='_blank'>". mb_strimwidth($arquivo['arquivo'], 15 ,25,"..." )."</a></td>";
					$queryy = "SELECT idStatusDocumento FROM upload_arquivo WHERE idUploadArquivo = '".$arquivo['idUploadArquivo']."'";
					$send = mysqli_query($con, $queryy);
					$row = mysqli_fetch_array($send);

						echo "<td class='list_description'>
							<select name='dado[$count][status]' id='statusOpt' value='teste'>";
							echo "<option value=''>Selecione</option>";
							geraOpcao('status_documento', $row['idStatusDocumento']);
							echo " </select>
						</td>";
					$queryOBS = "SELECT observacoes FROM upload_arquivo WHERE idUploadArquivo = '".$arquivo['idUploadArquivo']."'";
					$send = mysqli_query($con, $queryOBS);
					$row = mysqli_fetch_array($send);
					echo "<td class='list_description'>
					<input type='text' name='dado[$count][observ]' maxlength='100' id='observ' value='".$row['observacoes']."'/>
					</td>";

					echo "
						<td class='list_description'>
							<input type='hidden' name='dado[$count][idPessoa]' value='".$idPessoa."' />
							<input type='hidden' name='dado[$count][idArquivo]' value='".$arquivo['idUploadArquivo']."' /></td>
							";
					echo "</tr>";
					$count ++;
				}
				echo "
		</tbody>
		</table>";
        echo "<input type='submit' name='atualizar' class='btn btn-theme btn-lg' value='Atualizar'>";
        echo "<input type='hidden' name='liberado' class='btn btn-theme btn-lg' value='$idPessoa'>";
        echo "</form>";
	}
	else
	{
		echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
	}
}

if(isset($_POST['atualizar']))
{
	// array com os inputs
	$dados = $_POST['dado'];

	// atualiza todos os campos
	foreach ($dados as $dado)
	{
		$query = "UPDATE upload_arquivo SET idStatusDocumento = '".$dado['status']."', observacoes = '".$dado['observ']."' WHERE idUploadArquivo = '".$dado['idArquivo']."' ";
		$envia = mysqli_query($con, $query);
		if($envia)
		{
			$mensagem = "<font color='#01DF3A'><strong>Os arquivos foram atualizados com sucesso!</strong></font>";
            gravarLog($query);
		}
		else
		{
			echo "<script>alert('Erro durante o processamento, entre em contato com os responsáveis pelo sistema para maiores informações.')</script>";
			echo "<script>window.location.href = 'index_pf.php?perfil=smc_index';</script>";
		}
	}

	$sql = "SELECT *
		FROM lista_documento as list
		INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
		WHERE arq.idPessoa = '".$dados[0]['idPessoa']."'
		AND arq.idTipo = '$tipoPessoa'
		AND arq.publicado = '1'";
	$query = mysqli_query($con,$sql);
	$rows = mysqli_num_rows($query);

	$count = 0;
	if ($rows > 0) {
		while($arquivo = mysqli_fetch_array($query))
		{
			# Recebe um array com idStatus de todos os docs
			$totStatus[$count] = $arquivo['idStatusDocumento'];
	 		$count ++;
		}
	}
	# Verifica se tem algum status reprovado ou complemetação
	if ((in_array('2',$totStatus)) || in_array('3',$totStatus))
	{
		$QueryPJ = "UPDATE pessoa_fisica SET liberado='2' WHERE idPf = '".$dados[0]['idPessoa']."'";
		$envio = mysqli_query($con, $QueryPJ);
        gravarLog($QueryPJ);
	}else {
		$QueryPJ = "UPDATE pessoa_fisica SET liberado='1' WHERE idPf = '".$dados[0]['idPessoa']."'";
		$envio = mysqli_query($con, $QueryPJ);
        gravarLog($QueryPJ);
	}
}

$pj = recuperaDados("pessoa_juridica","idPj",$idPj);
$rl = recuperaDados("representante_legal","idRepresentanteLegal",$pj['idRepresentanteLegal']);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<div class="alert alert-warning">
				<strong>Atenção!</strong> Confirme atentamente se os dados abaixo estão corretos!
			</div>
		</div>
		<div class = "page-header">
		 	<h5>Dados do proponente</h5>
		 	<h4><?php if(isset($mensagem)) echo $mensagem; ?></h4>
		</div>
		<div class="well">
			<p align="justify"><strong>Razão Social:</strong> <?php echo isset($pj['razaoSocial']) ? $pj['razaoSocial'] : null; ?></p>
			<p align="justify"><strong>CNPJ:</strong> <?php echo isset($pj['cnpj']) ? $pj['cnpj'] : null; ?><p>
			<p align="justify"><strong>CCM:</strong> <?php echo isset($pj['ccm']) ? $pj['ccm'] : null; ?><p>
			<p align="justify"><strong>Telefone:</strong> <?php echo isset($pj['telefone']) ? $pj['telefone'] : null; ?></p>
			<p align="justify"><strong>Celular:</strong> <?php echo isset($pj['celular']) ? $pj['celular'] : null; ?></p>
			<p align="justify"><strong>Email:</strong> <?php echo isset($pj['email']) ? $pj['email'] : null; ?></p>
			<p align="justify"><strong>Logradouro:</strong> <?php echo isset($pj['logradouro']) ? $pj['logradouro'] : null; ?></p>
			<p align="justify"><strong>Número:</strong> <?php echo isset($pj['numero']) ? $pj['numero'] : null; ?></p>
			<p align="justify"><strong>Complemento:</strong> <?php echo isset($pj['complemento']) ? $pj['complemento'] : null; ?></p>
			<p align="justify"><strong>Bairro:</strong> <?php echo isset($pj['bairro']) ? $pj['bairro'] : null; ?></p>
			<p align="justify"><strong>Cidade:</strong> <?php echo isset($pj['cidade']) ? $pj['cidade'] : null; ?></p>
			<p align="justify"><strong>Estado:</strong> <?php echo isset($pj['estado']) ? $pj['estado'] : null; ?></p>
			<p align="justify"><strong>CEP:</strong> <?php echo isset($pj['cep']) ? $pj['cep'] : null; ?></p>
			<p align="justify"><strong>Cooperativa:</strong> <?php if($pj['cooperativa'] == 1){ echo "Sim"; } else { echo "Não"; } ?></p>
		</div>

		<div class = "page-header">
		 	<h5>Representante Legal</h5>
		 	<br>
		</div>

		<div class="well">
		  	<p align="justify"><strong>Nome:</strong> <?php echo isset($rl['nome']) ? $rl['nome'] : null; ?></p>
			<p align="justify"><strong>CPF:</strong> <?php echo isset($rl['cpf']) ? $rl['cpf'] : null; ?><p>
			<p align="justify"><strong>RG:</strong> <?php echo isset($rl['rg']) ? $rl['rg'] : null; ?><p>
			<p align="justify"><strong>Logradouro:</strong> <?php echo isset($rl['logradouro']) ? $rl['logradouro'] : null; ?></p>
			<p align="justify"><strong>Número:</strong> <?php echo isset($rl['numero']) ? $rl['numero'] : null; ?></p>
			<p align="justify"><strong>Complemento:</strong> <?php echo isset($rl['complemento']) ? $rl['complemento'] : null; ?></p>
			<p align="justify"><strong>Bairro:</strong> <?php echo isset($rl['bairro']) ? $rl['bairro'] : null; ?></p>
			<p align="justify"><strong>Cidade:</strong> <?php echo isset($rl['cidade']) ? $rl['cidade'] : null; ?></p>
			<p align="justify"><strong>Estado:</strong> <?php echo isset($rl['estado']) ? $rl['estado'] : null; ?></p>
			<p align="justify"><strong>CEP:</strong> <?php echo isset($rl['cep']) ? $rl['cep'] : null; ?></p>
		</div>

		<div class="table-responsive list_info"><h6>Arquivo(s) de Pessoa Jurídica</h6>
			<?php listaArquivosPessoaEditorr($idPj,'2',"smc_reaprova_pj"); ?>
		</div>
	</div>

	<!-- Botão -->
	<?php
	if($pj['liberado'] != 3)
	{
	?>
		<div class="form-group">
            <div class='col-md-offset-4 col-md-2'>
			<!-- Button para ativar modal -->
			<button type="button" class='btn btn-theme btn-lg btn-block' data-toggle="modal" data-target="#myModal2">
				Não aprovar
			</button>
			</div>
			<div class='col-md-2'>
			<!-- Button para ativar modal -->
			<button type="button" class='btn btn-theme btn-lg btn-block' data-toggle="modal" data-target="#myModal1">
				Aprovar
			</button>
			</div>
		</div>
	<?php
	}
	else
	{
		echo "<h5><font color='#01DF3A'>".$pj['razaoSocial']." está com a inscrição do proponente aprovada.</font></h5>";
	}
	?>

	<div class="form-group">
		<div class="col-md-offset-2 col-md-8"><hr/></div>
	</div>

	<div class="col-md-offset-2 col-md-8">
		<a href="../include/arquivos_pessoa.php?idPessoa=<?php echo $pj['idPj'] ?>&tipo=<?php echo $tipoPessoa?>" class="btn btn-theme btn-md btn-block" target="_blank">Baixar todos os arquivos do proponente</a>
	</div>

	<!-- Modal de aviso aprovar -->
	<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-danger" id="myModalLabel">Atenção</h4>
				</div>
				<div class="modal-body">
					<p>Tem certeza que deseja aprovar um cadastro que não está liberado?</p>
				</div>
				<div class="modal-footer">
					<form class='form-horizontal' role='form' action='?perfil=smc_reaprova_pj' method='post'>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<input type='hidden' name='idPj' value='<?php echo $pj['idPj'] ?>' />
	 					<button type="submit" name="reaprovar" class="btn btn-success" id="confirm">Aprovar</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal de aviso não aprovar -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-danger" id="myModalLabel">Atenção</h4>
				</div>
				<div class="modal-body">
					<p>Tem certeza que deseja reprovar esse cadastro?</p>
				</div>
				<div class="modal-footer">
					<form class='form-horizontal' role='form' action='?perfil=smc_reaprova_pj' method='post'>
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<input type='hidden' name='idPj' value='<?php echo $pj['idPj'] ?>' />
	 					<button type="submit" name="negar" class="btn btn-success" id="confirm">Não aprovar</button>
					</form>
				</div>
			</div>
		</div>
	</div>



</section>