<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];


if(isset($_POST['insereOrcamento']))
{
	$idEtapa = $_POST['idEtapa'];
	$descricao = $_POST['descricao'];
	$quantidade = $_POST['quantidade'];
	$idUnidadeMedida = $_POST['idUnidadeMedida'];
	$quantidadeUnidade = $_POST['quantidadeUnidade'];
	$valorUnitario = $_POST['valorUnitario'];
	$valorTotal = $valorUnitario * $quantidadeUnidade
	$sql_insere = "INSERT INTO `orcamento`(`idProjeto`, `idEtapa`, `descricao`, `quantidade`, `idUnidadeMedida`, `quantidadeUnidade`, `valorUnitario`, `valorTotal`) VALUES ('$idProjeto', '$idEtapa', '$quantidade', '$idUnidadeMedida', '$quantidadeUnidade', '$valorUnitario', '$valorTotal')";
	if(mysqli_query($con,$sql_insere))
	{
		$mensagem = "<font color='#01DF3A'><strong>Inserido com sucesso!</strong></font>";
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao inserir! Tente novamente.</strong></font>";
	}
}


?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include '../perfil/includes/menu_evento.php'; ?>
		<div class="form-group">
			<h4>Orçamento</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<form class="form-horizontal" role="form" action="?perfil=orcamento_novo" method="post">
							<input type="submit" value="Inserir novo evento" class="btn btn-theme btn-lg btn-block">
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
					$sql = "SELECT * FROM orcamento
							WHERE publicado > 0 AND idUsuario ='$idUser'
							ORDER BY id DESC";
					$query = mysqli_query($con,$sql);
					$num = mysqli_num_rows($query);
					if($num > 0)
					{
						echo "
							<table class='table table-condensed'>
								<thead>
									<tr class='list_menu'>
										<td width='10%'>ID evento</td>
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
									echo "<td class='list_description'>".$campo['id']."</td>";
									echo "<td class='list_description'>".$campo['nomeEvento']."</td>";
									echo "<td class='list_description'>".retornaTipo($campo['idTipoEvento'])."</td>";
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
			</div>
		</div>
	</div>
</section>