<?php
$con = bancoMysqli();
$tipoPessoa = '2';

$idPj = isset($_POST['liberado']) ? $_POST['liberado'] : null;
$pj = recuperaDados("pessoa_juridica","idPj",$idPj);

if(isset($_POST['atualizar']))
{
	$observacao = $_POST['observ'];
	$status = $_POST['status'];
	$idArquivo = $_POST['idArquivo'];

	$query = "UPDATE upload_arquivo SET idStatusDocumento = '$status', observacoes = '$observacao' WHERE idUploadArquivo='$idArquivo'";
	$envia = mysqli_query($con, $query);

	if($envia)
	{
		echo "<script>alert('O arquivo foi atualizado com sucesso.')</script>";
		echo "<script>window.location = '?perfil=smc_lista_liberacao' </script>";
	} else{
		echo "<script>alert('Erro durante o processamento, entre em contato com os responsáveis pelo sistema para maiores informações.')</script>";
		echo "<script>window.location = '?perfil=smc_lista_liberacao' </script>";
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
				while($arquivo = mysqli_fetch_array($query))
				{
					echo "<tr>";
					echo "<td class='list_description'>(".$arquivo['documento'].")</td>";
					echo "<td class='list_description'><a href='../uploadsdocs/".$arquivo['arquivo']."' target='_blank'>". mb_strimwidth($arquivo['arquivo'], 15 ,25,"..." )."</a></td>";
					echo "<form id='atualizaDoc' method='POST' action='?perfil=smc_visualiza_perfil_pj'>";
					$queryy = "SELECT idStatusDocumento FROM upload_arquivo WHERE idUploadArquivo = '".$arquivo['idUploadArquivo']."'";
					$send = mysqli_query($con, $queryy);
					$row = mysqli_fetch_array($send);

						echo "<td class='list_description'>
							<select name='status' id='statusOpt' value='teste'>";
							geraOpcao('statusDocumento', $row['idStatusDocumento']);
							echo " </select>
						</td>";
					$queryOBS = "SELECT observacoes FROM upload_arquivo WHERE idUploadArquivo = '".$arquivo['idUploadArquivo']."'";
					$send = mysqli_query($con, $queryOBS);
					$row = mysqli_fetch_array($send);
					echo "<td class='list_description'>
					<input type='text' name='observ' maxlength='100' id='observ' value='".$row['observacoes']."'/>
					</td>";

					echo "
						<td class='list_description'>
								<input type='hidden' name='idPessoa' value='".$idPessoa."' />
								<input type='hidden' name='idArquivo' value='".$arquivo['idUploadArquivo']."' />
								<input type ='submit' name='atualizar' class='btn btn-theme btn-block' value='Atualizar'></td>
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

?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">

			<h4>Resumo do Usuário</h4>
			<div class="alert alert-warning">
				<strong>Atenção!</strong> Confirme atentamente se os dados abaixo estão corretos!
			</div>
		</div>
		 <div class = "page-header">
		 	<h5>Informações pessoais</h5>
		 	<br>
		 </div>

		 <div class="well">
			<p align="justify"><strong>Referência:</strong> <?php echo $pj['idPj']; ?></p>
			<p align="justify"><strong>Razão Social:</strong> <?php echo isset($pj['razaoSocial']) ? $pj['razaoSocial'] : null; ?></p>
			<p align="justify"><strong>CNPJ:</strong> <?php echo isset($pj['cnpj']) ? $pj['cnpj'] : null; ?><p>
			<p align="justify"><strong>CCM:</strong> <?php echo isset($pj['ccm']) ? $pj['ccm'] : null; ?><p>
		</div>

		<div class = "page-header">
		 	<h5>Endereço e contato</h5>
		 	<br>
		 </div>

		  <div class="well">
			<p align="justify"><strong>Logradouro:</strong> <?php echo isset($pj['logradouro']) ? $pj['logradouro'] : null; ?></p>
			<p align="justify"><strong>Número:</strong> <?php echo isset($pj['numero']) ? $pj['numero'] : null; ?></p>
			<p align="justify"><strong>Complemento:</strong> <?php echo isset($pj['complemento']) ? $pj['complemento'] : null; ?></p>
			<p align="justify"><strong>CEP:</strong> <?php echo isset($pj['cep']) ? $pj['cep'] : null; ?></p>
			<p align="justify"><strong>Bairro:</strong> <?php echo isset($pj['bairro']) ? $pj['bairro'] : null; ?></p>
			<p align="justify"><strong>Cidade:</strong> <?php echo isset($pj['cidade']) ? $pj['cidade'] : null; ?></p>
			<p align="justify"><strong>Estado:</strong> <?php echo isset($pj['estado']) ? $pj['estado'] : null; ?></p>
			<p align="justify"><strong>Telefone:</strong> <?php echo isset($pj['telefone']) ? $pj['telefone'] : null; ?></p>
			<p align="justify"><strong>Celular:</strong> <?php echo isset($pj['celular']) ? $pj['celular'] : null; ?></p>
			<p align="justify"><strong>Email:</strong> <?php echo isset($pj['email']) ? $pj['email'] : null; ?></p>
		 </div>
		 <div class="table-responsive list_info"><h6>Arquivo(s) de Pessoa Física</h6>
		<?php listaArquivosPessoaEditorr($idPj,'2',"smc_visualiza_perfil_pj"); ?>
		</div>
	</div>

<!-- Botão para Prosseguir -->
	<div class="form-group">
		<div class="col-md-offset-5 col-md-2">
			<form class="form-horizontal" role="form" action="?perfil=smc_lista_liberacao" method="post">
				<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block">
			</form>
		</div>
	</div>
</section>
