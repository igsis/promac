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

/*
if(isset($_POST['apagar']))
{
	$idEvento = $_POST['apagar'];
	$sql_apaga = "UPDATE evento SET publicado = '0' WHERE id = '$idEvento'";
	if(mysqli_query($con,$sql_apaga))
	{
		$mensagem = "<font color='#01DF3A'><strong>Evento apagado com sucesso!</strong></font>";
		gravarLog($sql_apaga);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao apagar evento! Tente novamente.</strong></font>";
	}
}
*/

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
											<td>Nome do evento</td>
											<td>Tipo de evento</td>
											<td>Data cadastro</td>
											<td>Enviado</td>
											<td width='10%'></td>
											<td width='10%'></td>
										</tr>
									</thead>
									<tbody>";
									while($campo = mysqli_fetch_array($query))
									{
										echo "<tr>";
										echo "<td class='list_description'>".$campo['idProjeto']."</td>";
										echo "<td class='list_description'>".$campo['descricao']."</td>";
										echo "<td class='list_description'>".retornaTipo($campo['idAreaAtuacao'])."</td>";
										echo "<td class='list_description'>".exibirDataHoraBr($campo['dataCadastro'])."</td>";
										if($campo['publicado'] == 2)
										{
											echo "<td class='list_description'>Sim</td>";
										}
										else
										{
											echo "<td class='list_description'>Não</td>";
										}
										echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=evento_edicao'>
													<input type='hidden' name='carregar' value='".$campo['id']."' />
													<input type ='submit' class='btn btn-theme btn-block' value='carregar'>
												</form>
											</td>";
										if($campo['publicado'] == 1)
										{
											echo "
												<td class='list_description'>
													<form method='POST' action='?perfil=evento'>
														<input type='hidden' name='apagar' value='".$campo['id']."' />
														<input type ='submit' class='btn btn-theme  btn-block' value='apagar'>
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
	</div>
</section>
