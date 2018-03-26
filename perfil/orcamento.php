<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

if(isset($_POST['insereOrcamento']) || isset($_POST['editaOrcamento']))
{
	$descricao = $_POST['descricao'];
	$quantidade = $_POST['quantidade'];
	$quantidadeUnidade = $_POST['quantidadeUnidade'];
	$valorUnitario = dinheiroDeBr($_POST['valorUnitario']);
	$valorTotal = $valorUnitario * $quantidadeUnidade * $quantidade;
}

if(isset($_POST['insereOrcamento']))
{
	$idEtapa = $_POST['idEtapa'];
	$idUnidadeMedida = $_POST['idUnidadeMedida'];

	$sql_insere = "INSERT INTO `orcamento`(`idProjeto`, `idEtapa`, `descricao`, `quantidade`, `idUnidadeMedida`, `quantidadeUnidade`, `valorUnitario`, `valorTotal`, `publicado`) VALUES ('$idProjeto', '$idEtapa', '$descricao', '$quantidade', '$idUnidadeMedida', '$quantidadeUnidade', '$valorUnitario', '$valorTotal', 1)";
	if(mysqli_query($con,$sql_insere))
	{
		$mensagem = "<font color='#01DF3A'><strong>Inserido com sucesso! Utilize o menu para avançar.</strong></font>";
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
	descricao = '$descricao',
	quantidade = '$quantidade',
	quantidadeUnidade = '$quantidadeUnidade',
	valorUnitario = '$valorUnitario',
	valorTotal = '$valorTotal'
	WHERE idOrcamento = '$idOrcamento'";
	if(mysqli_query($con,$sql_edita))
	{
		$mensagem = "<font color='#01DF3A'><strong>Editado com sucesso! Utilize o menu para avançar.</strong></font>";
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao editar! Tente novamente.</strong></font>";
	}
}

if(isset($_POST['apagaOrcamento']))
{
	$idOrcamento = $_POST['apagaOrcamento'];
	$sql_apaga = "UPDATE orcamento SET publicado = 0 WHERE idOrcamento = '$idOrcamento'";
	if(mysqli_query($con,$sql_apaga))
	{
		$mensagem = "<font color='#01DF3A'><strong>Apagado com sucesso!</strong></font>";
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
			<h4>Orçamento <button class='btn btn-default' type='button' data-toggle='modal' data-target='#infoOrcamento' style="border-radius: 30px;"><i class="fa fa-info-circle"></i></button></h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<!-- Início Resumo Orçamento -->
				<ul class="list-group">
					<li class="list-group-item list-group-item-success"><b>Resumo</b></li>
					<li class="list-group-item">
						<table class="table table-bordered">
							<tr>
							<?php
								for ($i = 1; $i <= 7; $i++)
								{
									$sql_etapa = "SELECT idEtapa FROM orcamento
										WHERE publicado > 0 AND idProjeto ='$idProjeto' AND idEtapa = '$i'
										ORDER BY idOrcamento";
									$query_etapa = mysqli_query($con,$sql_etapa);
									$lista = mysqli_fetch_array($query_etapa);

									$etapa = recuperaDados("etapa","idEtapa",$lista['idEtapa']);
									echo "<td><strong>".$etapa['etapa'].":</strong>";
								}
							?>
							</tr>
							<tr>
							<?php
								for ($i = 1; $i <= 7; $i++)
								{
									$sql_etapa = "SELECT SUM(valorTotal) AS tot FROM orcamento
										WHERE publicado > 0 AND idProjeto ='$idProjeto' AND idEtapa = '$i'
										ORDER BY idOrcamento";
									$query_etapa = mysqli_query($con,$sql_etapa);
									$lista = mysqli_fetch_array($query_etapa);

									echo "<td>R$ ".dinheiroParaBr($lista['tot'])."</td>";
								}
							?>
							</tr>
							<tr>
							<?php
								$sql_total = "SELECT SUM(valorTotal) AS tot FROM orcamento
											WHERE publicado > 0 AND idProjeto ='$idProjeto'
											ORDER BY idOrcamento";
									$query_total = mysqli_query($con,$sql_total);
									$total = mysqli_fetch_array($query_total);
									echo "<td colspan='7'><strong>TOTAL: R$ ".dinheiroParaBr($total['tot'])."</strong></td>";
							?>
							</tr>
						</table>
					</li>
				</ul>
				<!-- Fim Resumo Orçamento -->

				<div class="form-group"><br><hr/></div>

				<!-- Início Para inserir item de Orçamento -->
				<form class="form-horizontal" role="form" action="?perfil=orcamento" method="post">

					<div class="form-group">
						<div class="col-md-3">
							<br/><label>Etapa *</label>
							<select class="form-control" name="idEtapa" required>
								<option value="0"></option>
								<?php echo geraOpcao("etapa","") ?>
							</select>
						</div>
						<div class="col-md-4"><br/><strong>Descrição: *</strong><br/>
							<input type="text" class="form-control" name="descricao" placeholder="Descrição da etapa" maxlength="255" required>
						</div>
						<div class="col-md-1"><br/><strong>Qtde:</strong><br/>
							<input type="text" class="form-control" name="quantidade" required>
						</div>
						<div class="col-md-1"><strong>Unidade Medida:</strong><br/>
							<select class="form-control" name="idUnidadeMedida" required>
								<option value="0"></option>
								<?php echo geraOpcao("unidade_medida","") ?>
							</select>
						</div>
						<div class="col-md-1"><strong>Qtde Unidade:</strong><br/>
							<input type="text" class="form-control" name="quantidadeUnidade" required>
						</div>
						<div class="col-md-2"><br/><strong>Valor Unitário:</strong><br/>
							<input type="text" class="form-control" id='valor' name="valorUnitario" required>
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="insereOrcamento" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>

				</form>
				<!-- Fim Para inserir item de Orçamento -->

				<div class="form-group"><br><hr/></div>

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
										<td width='25%'>Etapa</td>
										<td>Descrição</td>
										<td width='5%'>Qtde</td>
										<td width='5%'>Unid. Med.</td>
										<td width='5%'>Qtde Unid.</td>
										<td>Valor Unit.</td>
										<td>Valor Total</td>
										<td width='10%'></td>
										<td width='10%'></td>
									</tr>
								</thead>
								<tbody>";
								while($campo = mysqli_fetch_array($query))
								{
									$etapa = recuperaDados("etapa","idEtapa",$campo['idEtapa']);
									$medida = recuperaDados("unidade_medida","idUnidadeMedida",$campo['idUnidadeMedida']);
									echo "<tr>";
									echo "<form method='POST' action='?perfil=orcamento'>";
									echo "<td class='list_description'>".$etapa['etapa']."</td>";
									echo "<td class='list_description'><input type='text' class='form-control' name='descricao' maxlength='255' value=".$campo['descricao']."></td>";
									echo "<td class='list_description'><input type='text' class='form-control' name='quantidade' value=".$campo['quantidade']."></td>";
									echo "<td class='list_description'>".$medida['unidadeMedida']."</td>";
									echo "<td class='list_description'><input type='text' class='form-control' name='quantidadeUnidade' value=".$campo['quantidadeUnidade']."></td>";
									echo "<td class='list_description'><input type='text' class='form-control' name='valorUnitario' id='valor' value=".dinheiroParaBr($campo['valorUnitario'])."></td>";
									echo "<td class='list_description'>".dinheiroParaBr($campo['valorTotal'])."</td>";
									echo "<td class='list_description'>
												<input type='hidden' name='editaOrcamento' value='".$campo['idOrcamento']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='Gravar'></td>";
									echo "</form>";
									echo "<td class='list_description'>
											<form method='POST' action='?perfil=orcamento'>
												<input type='hidden' name='apagaOrcamento' value='".$campo['idOrcamento']."' />
												<button style='margin-top: 13px' class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Excluir Etapa?' data-message='Deseja realmente excluir a etapa ".$etapa['etapa']."?'>Apagar</button>
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
						<button type="button" class="btn btn-danger" id="confirm">Apagar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Fim Confirmação de Exclusão -->
		<!-- Inicio Modal Informações Orçamento -->
		<div class="modal fade" id="infoOrcamento" role="dialog" aria-labelledby="infoOrcamentoLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Atenção aos limites!!</h4>
					</div>
					<div class="modal-body" style="text-align: left;">
						<ul class="list-group">
							<li class="list-group-item list-group-item-success"><b>Conforme art. 53 do Decreto 58.041/2017</b></li>
							<li class="list-group-item">Os projetos culturais poderão acolher despesas de administração de até 20% (vinte por cento) do valor total do projeto, englobando gastos administrativos e serviços de captação de recursos.</li>
							<li class="list-group-item">Para fins de composição das despesas de administração, deverão ser considerados os tetos de 15% (quinze por cento) para gastos administrativos e de 10% (dez por cento) para o serviço de captação de recursos</li>
						</ul>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Fim Modal Informações Orçamento -->
	</div>
</section>