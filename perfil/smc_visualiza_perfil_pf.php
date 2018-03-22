<?php
$con = bancoMysqli();
$tipoPessoa = '1';
$idPf = isset($_POST['liberado']) ? $_POST['liberado'] : null;
$pf = recuperaDados("pessoa_fisica","idPf",$idPf);

if(isset($_POST['liberar']))
{
	$id = $_POST['LIBPF'];
	$QueryPJ = "UPDATE pessoa_fisica SET liberado='3' WHERE idPf = '$id'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio)
		echo "<script>alert('O usuário foi liberado com sucesso');</script>";
		echo "<script>window.location = '?perfil=smc_index';</script>";
}

if(isset($_POST['negar']))
{
	$id = $_POST['LIBPF'];
	$QueryPJ = "UPDATE pessoa_fisica SET liberado='2' WHERE idPf = '$id'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio)
		echo "<script>alert('O usuário foi negado com sucesso');</script>";
		echo "<script>window.location = '?perfil=smc_pesquisa_pf';</script>";
}

if(isset($_POST['desbloquear']))
{
	$id = $_POST['LIBPF'];
	$QueryPJ = "UPDATE pessoa_fisica SET liberado='1' WHERE idPf = '$id'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio)
		echo "<script>alert('O usuário foi desbloqueado com sucesso');</script>";
		echo "<script>window.location = '?perfil=smc_pesquisa_pf';</script>";
}

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
	}
	else
	{
		echo "<script>alert('Erro durante o processamento, entre em contato com os responsáveis pelo sistema para maiores informações.')</script>";
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
					echo "<form id='atualizaDoc' method='POST' action='?perfil=smc_visualiza_perfil_pf'>";
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
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Resumo do Usuário</h4>
			<div class="alert alert-warning">
				<strong>Atenção!</strong> Confirme atentamente se os dados abaixo estão corretos!
			</div>
		</div>
		 <div class = "page-header">
		 	<h5>Dados do proponente</h5>
		 </div>
		 <div class="well">
			<p align="justify"><strong>Nome:</strong> <?php echo isset($pf['nome']) ? $pf['nome'] : null; ?></p>
			<p align="justify"><strong>CPF:</strong> <?php echo isset($pf['cpf']) ? $pf['cpf'] : null; ?><p>
			<p align="justify"><strong>RG:</strong> <?php echo isset($pf['rg']) ? $pf['rg'] : null; ?><p>
			<p align="justify"><strong>Telefone:</strong> <?php echo isset($pf['telefone']) ? $pf['telefone'] : null; ?></p>
			<p align="justify"><strong>Celular:</strong> <?php echo isset($pf['celular']) ? $pf['celular'] : null; ?></p>
			<p align="justify"><strong>Email:</strong> <?php echo isset($pf['email']) ? $pf['email'] : null; ?></p>
			<p align="justify"><strong>Logradouro:</strong> <?php echo isset($pf['logradouro']) ? $pf['logradouro'] : null; ?></p>
			<p align="justify"><strong>Número:</strong> <?php echo isset($pf['numero']) ? $pf['numero'] : null; ?></p>
			<p align="justify"><strong>Complemento:</strong> <?php echo isset($pf['complemento']) ? $pf['complemento'] : null; ?></p>
			<p align="justify"><strong>Bairro:</strong> <?php echo isset($pf['bairro']) ? $pf['bairro'] : null; ?></p>
			<p align="justify"><strong>Cidade:</strong> <?php echo isset($pf['cidade']) ? $pf['cidade'] : null; ?></p>
			<p align="justify"><strong>Estado:</strong> <?php echo isset($pf['estado']) ? $pf['estado'] : null; ?></p>
			<p align="justify"><strong>CEP:</strong> <?php echo isset($pf['cep']) ? $pf['cep'] : null; ?></p>
		 </div>
		 <div class="table-responsive list_info"><h6>Arquivo(s) de Pessoa Física</h6>
		<?php
		$query = "SELECT idProjeto FROM projeto WHERE idPf='$idPf' AND publicado = '1'";
		$send = mysqli_query($con, $query);
		$row = mysqli_fetch_array($send);
		listaArquivosPessoaEditorr($pf['idPf'],$tipoPessoa,"smc_visualiza_perfil_pf");
		$idFisica = $pf['idPf']; ?>
		</div>
	</div>

<!-- Botão para Prosseguir -->
	<?php
	if($pf['liberado'] == 1)
	{
	?>
		<div class="form-group">
			<div class='col-md-offset-4 col-md-2'>
				<form class='form-horizontal' role='form' action='?perfil=smc_visualiza_perfil_pf' method='post'>
					<input type='hidden' name='LIBPF' value='<?php echo $pf['idPf'] ?>' />
					<input type='submit' name='negar' value='Não Aprovar' class='btn btn-theme btn-lg btn-block'>
				</form>
			</div>
			<div class='col-md-2'>
				<form class='form-horizontal' role='form' action='?perfil=smc_visualiza_perfil_pf' method='post'>
					<input type='hidden' name='LIBPF' value='<?php echo $pf['idPf'] ?>' />
					<input type='submit' name='liberar' value='Aprovar' class='btn btn-theme btn-lg btn-block'>
				</form>
			</div>
		</div>
	<?php
	}
	if($pf['liberado'] == 3)
	{
	?>
		<div class="form-group">
			<div class='col-md-offset-2 col-md-8'>
				<form class='form-horizontal' role='form' action='?perfil=smc_visualiza_perfil_pf' method='post'>
					<input type='hidden' name='LIBPF' value='<?php echo $pf['idPf'] ?>' />
					<input type='submit' name='desbloquear' value='Desbloquear dados do proponente para edição' class='btn btn-theme btn-lg btn-block'>
				</form>
			</div>
		</div>
	<?php } ?>
</section>