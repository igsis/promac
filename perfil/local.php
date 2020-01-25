<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

$usuarioLogado = pegaUsuarioLogado();

if(isset($_POST['insereLocal']) || isset($_POST['editaLocal'])) {
    $local = addslashes($_POST['local']);
    $estimativaPublico = $_POST['estimativaPublico'];
    $cep = $_POST['cep'];
    $logradouro = addslashes($_POST['logradouro']);
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'] ?? NULL;
    $bairro = addslashes($_POST['bairro']);
    $cidade = addslashes($_POST['cidade']);
    $uf = $_POST['uf'];
    $distrito = $_POST['distrito'];
}


if(isset($_POST['insereLocal']))
{
	$sql_insere_local = "INSERT INTO locais_realizacao(idProjeto, local, estimativaPublico, logradouro, numero, complemento, bairro, cidade, estado, cep, idDistrito, publicado) VALUES ('$idProjeto', '$local', '$estimativaPublico', '$logradouro', '$numero', '$complemento', '$bairro', '$cidade', '$uf', '$cep', '$distrito', 1)";

	if(mysqli_query($con,$sql_insere_local))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
		gravarLog($sql_insere_local);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>.$sql_insere_local";
	}
}

if(isset($_POST['editaLocal']))
{
    $idLocaisRealizacao = $_POST['editaLocal'];
    $sql_edita_local = "UPDATE `locais_realizacao` SET
	`local`= '$local',
	`estimativaPublico`= '$estimativaPublico',
    cep = '$cep',
    logradouro = '$logradouro',
    numero = '$numero',
    complemento = '$complemento',
    bairro = '$bairro',
    cidade = '$cidade',
    estado= '$uf',
    idDistrito= '$distrito',
	`alteradoPor` = '$usuarioLogado'
	WHERE idLocaisRealizacao = '$idLocaisRealizacao'";
	if(mysqli_query($con,$sql_edita_local))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
		gravarLog($sql_edita_local);
	}
	else
	{		
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}

if(isset($_POST['apagaLocal']))
{
	$idLocaisRealizacao = $_POST['apagaLocal'];

	$sql_apaga_local = "UPDATE `locais_realizacao` SET publicado = 0 WHERE idLocaisRealizacao = '$idLocaisRealizacao'";
	if(mysqli_query($con,$sql_apaga_local))
	{
		$mensagem = "<font color='#01DF3A'><strong>Apagado com sucesso!</strong></font>";
		gravarLog($sql_apaga_local);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao apagar! Tente novamente.</strong></font>";
	}
}

?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include '../perfil/includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h4>Local de Realização</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
                        <p align="justify">Atenção! Essa é uma das partes fundamentais do seu projeto, pois está diretamente ligada ao “selo de renúncia fiscal” que seu projeto irá receber da Comissão Julgadora de Projetos. Após aprovação, não será possível fazer alterações de local que impliquem em alteração do “selo de renúncia fiscal”, conforme explicado em Edital. Sendo assim, planeje bem os locais das suas ações. Estude o mapa do Anexo I do Edital para entender em quais faixas de renúncia fiscal os distritos se encontram. As atividades devem ser similares ou equivalentes para serem consideradas igualmente para o cálculo da renúncia fiscal.</p>
                        <p align="justify">Como colocado no Art. 50 do Decreto nº 59.119/2019, que traz nova regulamentação ao PROMAC, os projetos culturais serão aprovados com renúncias fiscais de acordo com o seguinte enquadramento:</p>
                        <ul class="list-group">
                            <li class="list-group-item">100% (cem por cento) de renúncia fiscal: para projetos que realizem, pelo menos, 51% (cinquenta e um por cento) das atividades culturais na Faixa 1;</li>
                            <li class="list-group-item">85% (oitenta e cinco por cento) de renúncia fiscal: para projetos que realizem, pelo menos, 51% (cinquenta por cento) das atividades culturais na Faixa 2;</li>
                            <li class="list-group-item">70% (setenta por cento) de renúncia fiscal: para projetos que realizem, pelo menos, 51% (cinquenta e um por cento) das atividades culturais na Faixa 3.</li>
                        </ul>
						<form class="form-horizontal" role="form" action="?perfil=local_novo" method="post">
							<input type="submit" value="Inserir novo local" class="btn btn-theme btn-lg btn-block">
						</form>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8"><br></div>
			</div>
			<div class="col-md-12">
				<div class="table-responsive list_info">
				<?php
					$sql = "SELECT * FROM locais_realizacao
							WHERE publicado = 1 AND idProjeto = '$idProjeto'";
					$query = mysqli_query($con,$sql);
					$num = mysqli_num_rows($query);
					if($num > 0)
					{
						echo "
							<table class='table table-condensed'>
								<thead>
									<tr class='list_menu'>
										<td>Local</td>
										<td>Público estimado</td>
										<td>Endereço</td>
										<td>Bairro</td>
										<td>Cidade</td>
										<td>Estado</td>
										<td>CEP</td>
										<td>Distrito</td>
										<td>Faixa</td>
										<td width='10%'></td>
										<td width='10%'></td>
									</tr>
								</thead>
								<tbody>";
								while($campo = mysqli_fetch_array($query))
								{
								    $distrito = recuperaDados('distrito', 'idDistrito', $campo['idDistrito']);
									echo "<tr>";
									echo "<td class='list_description'>".$campo['local']."</td>";
									echo "<td class='list_description'>".$campo['estimativaPublico']."</td>";
									echo "<td class='list_description'>".$campo['logradouro'].", ".$campo['numero']." ".$campo['complemento']."</td>";
                                    echo "<td class='list_description'>".$campo['bairro']."</td>";
									echo "<td class='list_description'>".$campo['cidade']."</td>";
									echo "<td class='list_description'>".$campo['estado']."</td>";
									echo "<td class='list_description'>".$campo['cep']."</td>";
									echo "<td class='list_description'>".$distrito['distrito']."</td>";
									echo "<td class='list_description'> Faixa ".$distrito['faixa']."</td>";
									echo "<td class='list_description'>
											<form method='POST' action='?perfil=local_edicao'>
												<input type='hidden' name='editarLocal' value='".$campo['idLocaisRealizacao']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='editar'>
											</form>
										</td>";
									echo "
											<td class='list_description'>
												<form method='POST' action='?perfil=local'>
													<input type='hidden' name='apagaLocal' value='".$campo['idLocaisRealizacao']."' />
													<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Excluir Local?' data-message='Deseja realmente excluir o local ".$campo['local']."?'>Remover
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
							<h4 class="modal-title">Remover Arquivo?</h4>
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