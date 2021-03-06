<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];
$usuarioLogado = pegaUsuarioLogado();

if(isset($_POST['insereFicha']))
{
	$nome = addslashes($_POST['nome']);
	$cpf = $_POST['cpf'];
	$funcao = addslashes($_POST['funcao']);
	$curriculo = trim(addslashes($_POST['curriculo']));


		$validacao = validaCPF($_POST['cpf']);
		if($validacao == false)
		{
			echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=erros&p=erro_ficha_tecnica'>";
		}
		else
		{
			// Verifica se o representante já foi cadastrado ao projeto
			$pesquisa_ficha = "SELECT * FROM ficha_tecnica 
			WHERE idProjeto='$idProjeto'
			AND cpf='$cpf' 
			AND publicado='1'";
			
			$res = mysqli_query($con,$pesquisa_ficha);
			// ------------------------ //

			$sql_insere_nome = "INSERT INTO `ficha_tecnica`(`idProjeto`, `nome`, `cpf`, `funcao`, `curriculo`, `publicado`) VALUES ('$idProjeto', '$nome', '$cpf', '$funcao', '$curriculo', 1)";

			if($res->num_rows >= 1)
			{
				$mensagem = "<font color='#FF0000'><strong>Esse integrante já foi cadastrado! Por favor informe outro CPF.</strong></font>";
			}
			elseif(mysqli_query($con,$sql_insere_nome))
			{
				$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Utilize o menu para avançar.</strong></font>";
				gravarLog($sql_insere_nome);
			}
			else
			{
				$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
			}
		}
}

if(isset($_POST['editaFicha']))
{
	$idFichaTecnica = $_POST['editaFicha'];
	$nome = addslashes($_POST['nome']);
	$cpf = $_POST['cpf'];
	$funcao = addslashes($_POST['funcao']);
	$curriculo = trim(addslashes($_POST['curriculo']));

	$sql_edita_ficha = "UPDATE `ficha_tecnica` SET
	`nome`= '$nome',
	`cpf`= '$cpf',
	`funcao`= '$funcao',
	`curriculo`= '$curriculo',
	`AlteradoPor` = '$usuarioLogado'
	WHERE idFichaTecnica = '$idFichaTecnica'";
	if(mysqli_query($con,$sql_edita_ficha))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
		gravarLog($sql_edita_ficha);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}

if(isset($_POST['apagaFicha']))
{
	$idFichaTecnica = $_POST['apagaFicha'];

	$sql_apaga_ficha = "UPDATE `ficha_tecnica` SET publicado = 0 WHERE idFichaTecnica = '$idFichaTecnica'";
	if(mysqli_query($con,$sql_apaga_ficha))
	{
		$mensagem = "<font color='#01DF3A'><strong>Apagado com sucesso!</strong></font>";
		gravarLog($sql_apaga_ficha);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao apagar! Tente novamente.</strong></font>";
	}
}

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
			<h4>Ficha Técnica</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<form class="form-horizontal" role="form" action="?perfil=ficha_tecnica_novo" method="post">
							<input type="submit" value="Inserir novo integrante" class="btn btn-theme btn-lg btn-block">
						</form>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8"><br></div>
			</div>
			<div class="col-md-offset-1 col-md-10">
				<div class="table-responsive list_info">
				<?php
					$sql = "SELECT * FROM ficha_tecnica
							WHERE publicado = 1 AND idProjeto = '$idProjeto'";
					$query = mysqli_query($con,$sql);
					$num = mysqli_num_rows($query);
					if($num > 0)
					{
						echo "
							<table class='table table-condensed'>
								<thead>
									<tr class='list_menu'>
										<td>Nome</td>
										<td>CPF</td>
										<td>Função</td>
										<td width='15%'>Currículo Resumido</td>
										<td width='10%'></td>
										<td width='10%'></td>
									</tr>
								</thead>
								<tbody>";
								while($campo = mysqli_fetch_array($query))
								{
									echo "<tr>";
									echo "<td class='list_description'>".$campo['nome']."</td>";
									echo "<td class='list_description'>".$campo['cpf']."</td>";
									echo "<td class='list_description'>".$campo['funcao']."</td>";
									echo "<td class='list_description'>".mb_strimwidth($campo['curriculo'], 0 ,30,"..." )."</td>";
									echo "<td class='list_description'>
											<form method='POST' action='?perfil=ficha_tecnica_edicao'>
												<input type='hidden' name='editaFicha' value='".$campo['idFichaTecnica']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='editar'>
											</form>
										</td>";
									echo "<td class='list_description'>
												<form method='POST' action='?perfil=ficha_tecnica'>
													<input type='hidden' name='apagaFicha' value='".$campo['idFichaTecnica']."' />
													<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Remover Integrante?' data-message='Deseja realmente excluir o integrante ".$campo['nome']."?'>Apagar
															</button>
												</form>
											</td>";
									echo "</tr>";
								}
								echo "
							</tbody>
							</table>";
					}
					?>
				</div>
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
</section>
