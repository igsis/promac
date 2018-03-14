<?php
$con = bancoMysqli();
unset($_SESSION['idProjeto']);
$tipoPessoa = '1';

$idPf = $_SESSION['idUser'];
$pf = recuperaDados("pessoa_fisica","idPf",$idPf);

if(isset($_POST['liberacao']))
{
	$sql_liberacao = "UPDATE pessoa_fisica SET liberado = 1 WHERE idPf = '$idPf'";
	if(mysqli_query($con,$sql_liberacao))
	{
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=projeto_pf'>";
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao atualizar! Tente novamente.</strong></font> <br/>".$sql_atualiza_pf;
	}
}

if(isset($_POST['apagar']))
{
	$idProjeto = $_POST['apagar'];
	$sql_apaga = "UPDATE projeto SET publicado = '0' WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_apaga))
	{
		$mensagem = "<font color='#01DF3A'><strong>Projeto apagado com sucesso!</strong></font>";
		gravarLog($sql_apaga);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao apagar projeto! Tente novamente.</strong></font>";
	}
}

?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include '../perfil/includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h4>Projetos</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<?php
				if($pf['liberado'] == 0)// ainda não foi solicitado liberação
				{
				?>
					<p>Após o preenchimento de todos os dados pessoais, solicite liberação para envio de projetos mediante a liberação da Secretaria MUnicipal de Cultura.</p>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<form class="form-horizontal" role="form" action="?perfil=projeto_pf" method="post">
								<input type="submit" name="liberacao" value="Solicitar liberação de acesso" class="btn btn-theme btn-lg btn-block">
							</form>
						</div>
					</div>
			<?php
				}
				elseif($pf['liberado'] == 1)// foi solicitado liberação, porém a SMC não analisou ainda.
				{
			?>
				<p><font color='#01DF3A'><strong>Sua solicitação para a liberação de envio de projetos foi enviada à Secretaria MUnicipal de Cultura. Aguarde a análise da sua documentação e liberação.</strong></font></p>
			<?php
				}
				elseif($pf['liberado'] == 2)// a liberação de projetos foi rejeitada pela SMC.
				{
			?>
				<p><font color='#01DF3A'><strong>Sua solicitação para a liberação de envio de projetos foi enviada à Secretaria MUnicipal de Cultura. Aguarde a análise da sua documentação e liberação.</strong></font></p>
			<?php
				}
				else // liberação concedida pela SMC - liberado = 3
				{
			?>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<form class="form-horizontal" role="form" action="?perfil=projeto_novo" method="post">
								<input type="submit" value="Inserir novo evento" class="btn btn-theme btn-lg btn-block">
							</form>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><br></div>
					</div>

					<div class="table-responsive list_info">
					<?php
						$sql = "SELECT * FROM projeto
								WHERE publicado > 0 AND idPf ='$idPf'
								ORDER BY idProjeto DESC";
						$query = mysqli_query($con,$sql);
						$num = mysqli_num_rows($query);
						if($num > 0)
						{
							echo "
								<table class='table table-condensed'>
									<thead>
										<tr class='list_menu'>
											<td width='10%'>ID projeto</td>
											<td>Descrição</td>
											<td>Área de Atuação</td>
											<td>Status</td>
											<td width='10%'></td>
											<td width='10%'></td>
										</tr>
									</thead>
									<tbody>";
									while($campo = mysqli_fetch_array($query))
									{
										$area = recuperaDados("area_atuacao","idArea",$campo['idAreaAtuacao']);
										echo "<tr>";
										echo "<td class='list_description'>".$campo['idProjeto']."</td>";
										echo "<td class='list_description'>".$campo['descricao']."</td>";
										echo "<td class='list_description'>".$area['areaAtuacao']."</td>";
										$idCampo = $campo['idStatus'];
										
										$status = "SELECT status FROM status WHERE idStatus='$idCampo'";
										$envio = mysqli_query($con, $status);
										$rowStatus = mysqli_fetch_array($envio);
										switch($campo['idStatus']){
											case 1:
												echo "<td class='list_description'> ".$rowStatus['status']."</td>";
												echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=projeto_edicao'>
													<input type='hidden' name='carregar' value='".$campo['idProjeto']."' />
													<input type ='submit' class='btn btn-theme btn-block' value='carregar'>
												</form>
											</td>";
											echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=projeto_pf'>
													<input type='hidden' name='apagar' value='".$campo['idProjeto']."' />
													<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Excluir Projeto?' data-message='Deseja realmente excluir o projeto nº ".$campo['idProjeto']."?'>Apagar
															</button>
												</form>
											</td>";
												break;
											case 2:
												echo "<td class='list_description'>".$rowStatus['status']." </td>";
												echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=projeto_visualizacao'>
													<input type='hidden' name='carregar' value='".$campo['idProjeto']."' />
													<input type ='submit' class='btn btn-theme btn-block' value='visualizar'>
												</form>
											</td>";
												break;
											case 3:
												echo "<td class='list_description'> ".$rowStatus['status']." </td>";
												echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=projeto_visualizacao'>
													<input type='hidden' name='carregar' value='".$campo['idProjeto']."' />
													<input type ='submit' class='btn btn-theme btn-block' value='visualizar'>
												</form>
											</td>";
												break;
											case 4:
												echo "<td class='list_description'> ".$rowStatus['status']." </td>";
												echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=projeto_edicao'>
													<input type='hidden' name='carregar' value='".$campo['idProjeto']."' />
													<input type ='submit' class='btn btn-theme btn-block' value='carregar'>
												</form>
											</td>";
												break;
											case 5:
												echo "<td class='list_description'> ".$rowStatus['status']." </td>";
												echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=projeto_visualizacao'>
													<input type='hidden' name='carregar' value='".$campo['idProjeto']."' />
													<input type ='submit' class='btn btn-theme btn-block' value='visualizar'>
												</form>
											</td>";
											break;
											case 6:
												echo "<td class='list_description'> ".$rowStatus['status']." </td>";
												echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=projeto_edicao'>
													<input type='hidden' name='carregar' value='".$campo['idProjeto']."' />
													<input type ='submit' class='btn btn-theme btn-block' value='carregar'>
												</form>
											</td>";
											echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=projeto_pf'>
													<input type='hidden' name='apagar' value='".$campo['idProjeto']."' />
													<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Excluir Projeto?' data-message='Deseja realmente excluir o projeto nº ".$campo['idProjeto']."?'>Apagar
															</button>
												</form>
											</td>";
										}
										echo "</tr>";
									}
							echo "
								</tbody>
								</table>";
						}
						?>
					</div>
				<?php
				}
				?>
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
							<button type="button" class="btn btn-danger" id="confirm">Apagar</button>
						</div>
					</div>
				</div>
			</div>
		<!-- Fim Confirmação de Exclusão -->
	</div>
</section>