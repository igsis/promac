<?php
$con = bancoMysqli();
$tipoPessoa = '1';
if(isset($_POST['liberado']))
{
	$idPf = $_POST['liberado'];
}
else if(isset($_POST['idPessoa']))
{
	$idPf = $_POST['idPessoa'];
}
else if (isset($_POST['LIBPF']))
{
	$idPf = $_POST['LIBPF'];
}
else
{
	$idPf = null;
}

$pf = recuperaDados("pessoa_fisica","idPf",$idPf);

if(isset($_POST['liberar']))
{
	$id = $_POST['LIBPF'];
	$QueryPJ = "UPDATE pessoa_fisica SET liberado='3' WHERE idPf = '$id'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio)
		$mensagem = "<font color='#01DF3A'><strong>O usuario ".$pf['nome']." foi aprovado com sucesso!</strong></font>";
}

if(isset($_POST['negar']))
{
	$id = $_POST['LIBPF'];
	$QueryPJ = "UPDATE pessoa_fisica SET liberado='2' WHERE idPf = '$id'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio)
		$mensagem = "<font color='#FF0000'><strong>O usuario ".$pf['nome']." foi REPROVADO com sucesso!</strong></font>";
}

if(isset($_POST['desbloquear']))
{
	$id = $_POST['LIBPF'];
	$QueryPJ = "UPDATE pessoa_fisica SET liberado='4' WHERE idPf = '$id'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio)
		$mensagem = "<font color='#01DF3A'><strong>O usuario ".$pf['nome']." foi desbloqueado para edição!</strong></font>";
}

if(isset($_POST['atualizar']))
{
	$id = $_POST['idPessoa'];
	$observacao = $_POST['observ'];
	$status = $_POST['status'];
	$idArquivo = $_POST['idArquivo'];

	$query = "UPDATE upload_arquivo SET idStatusDocumento = '$status', observacoes = '$observacao' WHERE idUploadArquivo='$idArquivo'";
	$envia = mysqli_query($con, $query);

	if($envia)
	{
		$mensagem = "<font color='#01DF3A'><strong>Arquivo foi atualizado com sucesso!</strong></font>";
	}
	else
	{
		echo "<script>alert('Erro durante o processamento, entre em contato com os responsáveis pelo sistema para maiores informações.')</script>";
		echo "<script>window.location.href = 'index_pf.php?perfil=smc_index';</script>";
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
							echo "<option>Selecione</option>";
							geraOpcao('status_documento', $row['idStatusDocumento']);
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
								<input type='submit' name='atualizar' class='btn btn-theme btn-block' value='Atualizar'></td>
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

$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
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
		 	<h5>Dados do proponente
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
				<!-- Button para ativar modal -->
				<button type="button" class='btn btn-theme btn-lg btn-block' data-toggle="modal" data-target="#myModal">
					Não Aprovar
				</button>
			</div>
			<div class='col-md-2'>
				<form class='form-horizontal' role='form' action='?perfil=smc_visualiza_perfil_pf' method='post'>
					<input type='hidden' name='LIBPF' value='<?php echo $pf['idPf'] ?>' />
					<input type='submit' name='liberar' value='Aprovar' class='btn btn-theme btn-lg btn-block'>
				</form>
			</div>
		</div>
		<!-- Modal de aviso -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title text-danger" id="myModalLabel">Atenção</h4>
					</div>
					<div class="modal-body">
						<h6>Sempre que preencher o campo "Observações", ou alterar o "Status" clique no botão <b class="text-warning">ATUALIZAR</b></h6>
						<p>Se esse procedimento já foi realizado, clique no botão abaixo</p>
					</div>
					<div class="modal-footer">
						<form class='form-horizontal' role='form' action='?perfil=smc_visualiza_perfil_pf' method='post'>
							<input type='hidden' name='LIBPF' value='<?php echo $pf['idPf'] ?>' />
							<input type='submit' name='negar' value='Não Aprovar' class='btn btn-theme btn-lg btn-block'>
						</form>
					</div>
				</div>
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
	<?php 
	}
	if(($pf['liberado'] == 2) || ($pf['liberado'] == 4))
	{
	?>
		<div class="form-group">
			<h5>Proponente não aprovado!<br> Aguardando reenvio da inscrição.</h5>
		</div>
	<?php
	}
	?>
</section>