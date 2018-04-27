<?php
$con = bancoMysqli();
$tipoPessoa = '2';

$idPj = isset($_POST['liberado']) ? $_POST['liberado'] : null;

if($idPj == null)
{
	$idPj = $_GET['idFF'];
}
$pj = recuperaDados("pessoa_juridica","idPj",$idPj);
$rl = recuperaDados("representante_legal","idRepresentanteLegal",$pj['idRepresentanteLegal']);

if(isset($_POST['liberar']))
{
	$id = $_POST['LIBPF'];
	$QueryPJ = "UPDATE pessoa_juridica SET liberado='3' WHERE idPj = '$id'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio)
		echo "<script>alert('O usuário foi liberado com sucesso');</script>";
		echo "<script>window.location = '?perfil=smc_index';</script>";
}

if(isset($_POST['negar']))
{
	$id = $_POST['LIBPF'];
	$QueryPJ = "UPDATE pessoa_juridica SET liberado='2' WHERE idPj = '$id'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio)
		echo "<script>alert('O usuário foi negado com sucesso');</script>";
		echo "<script>window.location = '?perfil=smc_pesquisa_pj';</script>";
}

if(isset($_POST['desbloquear']))
{
	$id = $_POST['LIBPF'];
	$QueryPJ = "UPDATE pessoa_juridica SET liberado='4' WHERE idPj = '$id'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio)
		echo "<script>alert('O usuário foi negado com sucesso');</script>";
		echo "<script>window.location = '?perfil=smc_pesquisa_pj';</script>";
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
			echo "<script>window.location.href = 'index_pf.php?perfil=smc_visualiza_perfil_pj&idFF=".$dado['idPessoa'] ."';</script>";
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
		$QueryPJ = "UPDATE pessoa_juridica SET liberado='2' WHERE idPj = '".$dados[0]['idPessoa']."'";
		$envio = mysqli_query($con, $QueryPJ);
	}else {
		$QueryPJ = "UPDATE pessoa_juridica SET liberado='1' WHERE idPj = '".$dados[0]['idPessoa']."'";
		$envio = mysqli_query($con, $QueryPJ);
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
				<form id='atualizaDoc' method='POST' action='?perfil=smc_visualiza_perfil_pj'>";
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
							echo "<option>Selecione</option>";
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
		echo "<input type ='submit' name='atualizar' class='btn btn-theme btn-lg' value='Atualizar'><br>
			</form>";
	}
	else
	{
		echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
	}
}

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
		 	<h5>Dados do Proponente
				<?php
		 			if(isset($mensagem))
		 			{
		 				echo "<br>";
		 				echo $mensagem;
		 			}
		 		?>
		 	</h5>
		 	<br>
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
			<p align="justify"><strong>Data da Inscrição:</strong> <?php echo isset($pj['dataInscricao']) ? exibirDataHoraBr($pj['dataInscricao']) : null; ?></p>
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
		<?php listaArquivosPessoaEditorr($idPj,'2',"smc_visualiza_perfil_pj"); ?>
		</div>
	</div>

<!-- Botão para Prosseguir -->
	<?php
	if($pj['liberado'] == 1)
	{
	?>
		<div class="form-group">
			<div class='col-md-offset-4 col-md-2'>
				<form class='form-horizontal' role='form' action='?perfil=smc_visualiza_perfil_pj' method='post'>
					<input type='hidden' name='LIBPF' value='<?php echo $pj['idPj'] ?>' />
					<input type='submit' name='negar' value='Não Aprovar' class='btn btn-theme btn-lg btn-block'>
				</form>
			</div>
			<div class='col-md-2'>
				<form class='form-horizontal' role='form' action='?perfil=smc_visualiza_perfil_pj' method='post'>
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
				<form class='form-horizontal' role='form' action='?perfil=smc_visualiza_perfil_pj' method='post'>
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
			<h5>Proponente não aprovado!<br> Aguardando reenvio da inscrição.</h5>
		</div>
	<?php
	}
	?>
</section>