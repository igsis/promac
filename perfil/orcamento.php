<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

if(isset($_POST['insereOrcamento']) || isset($_POST['editaOrcamento']))
{
	$idEtapa = $_POST['idEtapa'];
	$descricao = $_POST['descricao'];
	$quantidade = $_POST['quantidade'];
	$idUnidadeMedida = $_POST['idUnidadeMedida'];
	$quantidadeUnidade = $_POST['quantidadeUnidade'];
	$valorUnitario = dinheiroDeBr($_POST['valorUnitario']);
	$valorTotal = $valorUnitario * $quantidadeUnidade;
}

if(isset($_POST['insereOrcamento']))
{
	$sql_insere = "INSERT INTO `orcamento`(`idProjeto`, `idEtapa`, `descricao`, `quantidade`, `idUnidadeMedida`, `quantidadeUnidade`, `valorUnitario`, `valorTotal`, `publicado`) VALUES ('$idProjeto', '$idEtapa', '$descricao', '$quantidade', '$idUnidadeMedida', '$quantidadeUnidade', '$valorUnitario', '$valorTotal', 1)";
	if(mysqli_query($con,$sql_insere))
	{
		$mensagem = "<font color='#01DF3A'><strong>Inserido com sucesso!</strong></font>";
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao inserir! Tente novamente.</strong></font>" .$sql_insere;
	}
}

if(isset($_POST['editaOrcamento']))
{
	$idOrcamento = $_POST['editaOrcamento'];
	$sql_edita = "UPDATE orcamento SET
	idEtapa = '$idEtapa',
	descricao = '$descricao',
	quantidade = '$quantidade',
	idUnidadeMedida = '$idUnidadeMedida',
	quantidadeUnidade = '$quantidadeUnidade',
	valorUnitario = '$valorUnitario',
	valorTotal = '$valorTotal'
	WHERE idOrcamento = '$idOrcamento'";
	if(mysqli_query($con,$sql_edita))
	{
		$mensagem = "<font color='#01DF3A'><strong>Editado com sucesso!</strong></font>";
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao editar! Tente novamente.</strong></font>";
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
			<h4>Orçamento</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<form class="form-horizontal" role="form" action="?perfil=orcamento_novo" method="post">
							<input type="submit" value="Inserir novo item" class="btn btn-theme btn-lg btn-block">
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
							WHERE publicado > 0 AND idProjeto ='$idProjeto'
							ORDER BY idEtapa";
					$query = mysqli_query($con,$sql);
					$num = mysqli_num_rows($query);
					if($num > 0)
					{
						echo "
							<table class='table table-condensed'>
								<thead>
									<tr class='list_menu'>
										<td width='10%'>Etapa</td>
										<td>Descrição</td>
										<td>Quantidade</td>
										<td>Unidade de Medida</td>
										<td>Quantidade Unidade</td>
										<td>Valor Unitário</td>
										<td>Valor Total</td>
										<td width='10%'></td>
										<td width='10%'></td>
									</tr>
								</thead>
								<tbody>";
								while($campo = mysqli_fetch_array($query))
								{
									echo "<tr>";
									echo "<td class='list_description'>".$campo['idEtapa']."</td>";
									echo "<td class='list_description'>".$campo['descricao']."</td>";
									echo "<td class='list_description'>".$campo['quantidade']."</td>";
									echo "<td class='list_description'>".$campo['idUnidadeMedida']."</td>";
									echo "<td class='list_description'>".$campo['quantidadeUnidade']."</td>";
									echo "<td class='list_description'>".dinheiroParaBr($campo['valorUnitario'])."</td>";
									echo "<td class='list_description'>".dinheiroParaBr($campo['valorTotal'])."</td>";
									echo "<td class='list_description'>
											<form method='POST' action='?perfil=orcamento_edicao'>
												<input type='hidden' name='carregar' value='".$campo['idOrcamento']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='carregar'>
											</form>
										</td>";
									echo "<td class='list_description'>
											<form method='POST' action='?perfil=orcamento'>
												<input type='hidden' name='apagar' value='".$campo['idOrcamento']."' />
												<input type ='submit' class='btn btn-theme  btn-block' value='apagar'>
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
	</div>
</section>