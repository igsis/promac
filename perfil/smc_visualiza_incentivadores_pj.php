<?php
$con = bancoMysqli();
$tipoPessoa = '5';

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
	$idPj = $_GET['idPj'];
}

$pj = recuperaDados("incentivador_pessoa_juridica","idPj",$idPj);
$rl = recuperaDados("representante_legal","idRepresentanteLegal",$pj['idRepresentanteLegal']);

if(isset($_POST['liberar']))
{
	$id = $_POST['LIBPF'];
	$QueryPJ = "UPDATE incentivador_pessoa_juridica SET liberado='3' WHERE idPj = '$id'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio) {
        $mensagem = "<font color='#01DF3A'><strong>O usuário " . $pj['razaoSocial'] . " foi aprovado com sucesso!</strong></font>";
        gravarLog($QueryPJ);
    }
}

if(isset($_POST['negar']))
{
	$id = $_POST['LIBPF'];
	$QueryPJ = "UPDATE incentivador_pessoa_juridica SET liberado='2' WHERE idPj = '$id'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio){
		$mensagem = "<font color='#FF0000'><strong>O usuario ".$pj['razaoSocial']." foi REPROVADO com sucesso!</strong></font>";
        gravarLog($QueryPJ);
	}
}

if(isset($_POST['desbloquear']))
{
	$id = $_POST['LIBPF'];
	$QueryPJ = "UPDATE incentivador_pessoa_juridica SET liberado='4' WHERE idPj = '$id'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio){
		$mensagem = "<font color='#01DF3A'><strong>O usuario ".$pj['razaoSocial']." foi desbloqueado para edição!</strong></font>";
        gravarLog($QueryPJ);
	}
}

if(isset($_POST['atualizar']))
{
	// array com os inputs
	$dados = $_POST['dado']; 

	// atualiza todos os campos
	foreach ($dados as $dado) {

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
		$QueryPJ = "UPDATE incentivador_pessoa_juridica SET liberado='2' WHERE idPj = '".$dados[0]['idPessoa']."'";
		$envio = mysqli_query($con, $QueryPJ);
        gravarLog($QueryPJ);
	}else {
		$QueryPJ = "UPDATE incentivador_pessoa_juridica SET liberado='1' WHERE idPj = '".$dados[0]['idPessoa']."'";
		$envio = mysqli_query($con, $QueryPJ);
        gravarLog($QueryPJ);
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
					<td>Status</td>
					<td>Observações</td>
					<td>Ação</td>
				</tr>
			</thead>
			<tbody>";
				echo "<form id='atualizaDoc' method='POST' action='?perfil=smc_visualiza_incentivadores_pj'>";
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
							echo "<option value = ''>Selecione</option>";
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
					$count++;
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

$pj = recuperaDados("incentivador_pessoa_juridica","idPj",$idPj);
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Resumo do Usuário</h4>
			<div class="alert alert-warning">
				<strong>Atenção!</strong> Confirme atentamente se os dados abaixo estão corretos!
			</div>
		</div>
		 <div class = "page-header">
		 	<h5>Dados do Incentivador
		 	<?php
	 			if(isset($mensagem))
	 			{
	 				echo "<br>";
	 				echo $mensagem;
	 			}
		 		?>
		 	</h5>
		 </div>
		 <div class="well">
			<p align="justify"><strong>Razão Social:</strong> <?php echo isset($pj['razaoSocial']) ? $pj['razaoSocial'] : null; ?></p>
			<p align="justify"><strong>CNPJ:</strong> <?php echo isset($pj['cnpj']) ? $pj['cnpj'] : null; ?><p>
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
			<p align="justify"><strong>Data da Inscrição:</strong> <?php echo isset($pj['dataInscricao']) ? exibirDataHoraBr($pj['dataInscricao']) : null; ?></p>
		</div>

		<div class = "page-header">
		 	<h5>Representante Legal</h5>
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
		<?php
			$query = "SELECT idProjeto FROM projeto WHERE idPj='$idPj' AND publicado = '1'";
			$send = mysqli_query($con, $query);
			$row = mysqli_fetch_array($send);
			listaArquivosPessoaEditorr($pj['idPj'],'5',"smc_visualiza_incentivadores_pj");
		?>
		</div>
	</div>

<!-- Botão para Prosseguir -->
	<?php
	if($pj['liberado'] == 1)
	{
	?>
		<div class="form-group">
			<div class='col-md-offset-4 col-md-2'>
				<form class='form-horizontal' role='form' action='?perfil=smc_visualiza_incentivadores_pj' method='post'>
					<input type='hidden' name='LIBPF' value='<?php echo $pj['idPj'] ?>' />
					<input type='submit' name='negar' value='Não Aprovar' class='btn btn-theme btn-lg btn-block'>
				</form>
			</div>
			<div class='col-md-2'>
				<form class='form-horizontal' role='form' action='?perfil=smc_visualiza_incentivadores_pj' method='post'>
					<input type='hidden' name='LIBPF' value='<?php echo $pj['idPj'] ?>' />
					<input type='submit' name='liberar' value='Aprovar' class='btn btn-theme btn-lg btn-block'>
				</form>
			</div>
		</div>
	<?php
	}
	if($pj['liberado'] == 3)
	{
	?>
		<div class="form-group">
			<div class='col-md-offset-2 col-md-8'>
				<form class='form-horizontal' role='form' action='?perfil=smc_visualiza_incentivadores_pj' method='post'>
					<input type='hidden' name='LIBPF' value='<?php echo $pj['idPj'] ?>' />
					<input type='submit' name='desbloquear' value='Desbloquear dados do proponente para edição' class='btn btn-theme btn-lg btn-block'>
				</form>
			</div>
		</div>
	<?php
	}
	if(($pj['liberado'] == 2) || ($pj['liberado'] == 4))
	{
	?>
		<div class="form-group">
			<h5>Incentivador não aprovado!<br> Aguardando reenvio da inscrição.</h5>
		</div>
	<?php
	}
	?>

	<div class="col-md-offset-2 col-md-8">
		<a href="../include/arquivos_pessoa.php?idPessoa=<?php echo $pj['idPj'] ?>&tipo=<?php echo $tipoPessoa?>" class="btn btn-theme btn-md btn-block" target="_blank">Baixar todos os arquivos da empresa</a>
	</div>
</section>