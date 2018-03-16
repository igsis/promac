<?php
$con = bancoMysqli();

$idProjeto = 1; //$idProjeto = $_POST['idProjeto'];
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);

if(isset($_POST['gravarPrazos']))
{
	$prazoCaptacao = exibirDataMysql($_POST['prazoCaptacao']);
	$prorrogacaoCaptacao = $_POST['prorrogacaoCaptacao'];
	$finalCaptacao = exibirDataMysql($_POST['finalCaptacao']);
	$inicioExecucao = exibirDataMysql($_POST['inicioExecucao']);
	$fimExecucao = exibirDataMysql($_POST['fimExecucao']);
	$prorrogacaoExecucao = $_POST['prorrogacaoExecucao'];
	$finalProjeto = exibirDataMysql($_POST['finalProjeto']);
	$prestarContas = exibirDataMysql($_POST['prestarContas']);

	$prazos = recuperaDados("prazos_projeto","idProjeto",$idProjeto);
	if($prazos == NULL)
	{
		$sql_insere = "INSERT INTO prazos_projeto (idProjeto, prazoCaptacao, prorrogacaoCaptacao, finalCaptacao, inicioExecucao, fimExecucao, prorrogacaoExecucao, finalProjeto, prestarContas) VALUES ('$idProjeto', '$prazoCaptacao', '$prorrogacaoCaptacao', '$finalCaptacao', '$inicioExecucao', '$fimExecucao', '$prorrogacaoExecucao', '$finalProjeto', '$prestarContas')";
		if(mysqli_query($con,$sql_insere))
		{
			$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
		}
	}
	else
	{
		$sql_edita = "UPDATE prazos_projeto SET
		prazoCaptacao = '$prazoCaptacao',
		prorrogacaoCaptacao = '$prorrogacaoCaptacao',
		finalCaptacao = '$finalCaptacao',
		inicioExecucao = '$inicioExecucao',
		fimExecucao = '$fimExecucao',
		prorrogacaoExecucao = '$prorrogacaoExecucao',
		finalProjeto = '$finalProjeto',
		prestarContas = '$prestarContas'
		WHERE idProjeto = '$idProjeto'";
		if(mysqli_query($con,$sql_edita))
		{
			$mensagem = "<font color='#01DF3A'><strong>Editado com sucesso!</strong></font>";
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao editar! Tente novamente.</strong></font>";
		}
	}
}

if($projeto['tipoPessoa'] == 1)
{
	$pf = recuperaDados("pessoa_fisica","idPf",$projeto['idPf']);
}
else
{
	$pj = recuperaDados("pessoa_juridica","idPj",$projeto['idPj']);
}

$prazos = recuperaDados("prazos_projeto","idProjeto",$idProjeto);
$cronograma = recuperaDados("cronograma","idCronograma",$projeto['idCronograma']);
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Ambiente SMC</h4>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div role="tabpanel">
					<!-- LABELS -->
					<ul class="nav nav-tabs">
						<li class="nav active"><a href="#prazo" data-toggle="tab">Prazos</a></li>
						<li class="nav"><a href="#projeto" data-toggle="tab">Projeto</a></li>
						<li class="nav"><a href="#F" data-toggle="tab">Pessoa Fisica</a></li>
						<li class="nav"><a href="#J" data-toggle="tab">Pessoa Jurídica</a></li>
					</ul>

					<div class="tab-content">
						<!-- LABEL PRAZOS -->
						<div role="tabpanel" class="tab-pane fade in active" id="prazo">
							<form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
								<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8"><br/></div>
								</div>

								<div class="form-group">
									<div class="col-md-offset-2 col-md-3">
										<label>Prazo Captação</label><br/>
										<input type="text" name="prazoCaptacao" id="datepicker01" class="form-control" value="<?php 
										if(returnEmptyDate('prazoCaptacao', $idProjeto) > 0 ){ 
											$var = strtotime(returnEmptyDate('prazoCaptacao', $idProjeto));
											echo date("d",$var) . "/";
											echo date("m",$var) . "/";
											echo date("Y",$var);
										} else{
											echo "00/00/0000";
										}?>">
									</div>

									<div class="col-md-2"><label>Prorrogação</label><br/>
										<select class="form-control" name="prorrogacaoCaptacao" value="">
											<option value="<?php echo $prazos['prorrogacaoCaptacao'] ?>" selected >
												<?php
													if($prazos['prorrogacaoCaptacao'] == 1){ echo "Sim"; }
													else { echo "Não"; }
												?>
											</option>
											<option value="0">Não</option>
											<option value="1">Sim</option>
										</select>
									</div>

									<div class="col-md-3">
										<label>Data Final da Captação</label>
										<input type="text" name="finalCaptacao" id="datepicker02" class="form-control" value="<?php
										 if(returnEmptyDate('finalCaptacao', $idProjeto) > 0 ){ 
											$var = strtotime(returnEmptyDate('finalCaptacao', $idProjeto));
											echo date("d",$var) . "/";
											echo date("m",$var) . "/";
											echo date("Y",$var);
										} else{
											echo "00/00/0000";
										}
										?>">
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-offset-2 col-md-6"><label>Início da execução do projeto</label>
										<input type="text" name="inicioExecucao" id="datepicker03" class="form-control" value="<?php 
										if(returnEmptyDate('inicioExecucao', $idProjeto) > 0 ){ 
											$var = strtotime(returnEmptyDate('inicioExecucao', $idProjeto));
											echo date("d",$var) . "/";
											echo date("m",$var) . "/";
											echo date("Y",$var);
										} else{
											echo "00/00/0000";
										}
										?>">
									</div>
									<div class="col-md-6"><label>Fim da execução do projeto</label>
										<input type="text" name="fimExecucao" id="datepicker04" class="form-control" value="<?php 
										if(returnEmptyDate('fimExecucao', $idProjeto) > 0 ){ 
											$var = strtotime(returnEmptyDate('fimExecucao', $idProjeto));
											echo date("d",$var) . "/";
											echo date("m",$var) . "/";
											echo date("Y",$var);
										} else{
											echo "00/00/0000";
										}
										?>">
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-offset-2 col-md-2"><label>Prorrogação</label><br/>
										<select class="form-control" name="prorrogacaoExecucao" >
											<option value="<?php echo $prazos['prorrogacaoExecucao'] ?>" selected >
												<?php
													if($prazos['prorrogacaoExecucao'] == 1){ echo "Sim"; }
													else { echo "Não"; }
												?>
											</option>
											<option value="0">Não</option>
											<option value="1">Sim</option>
										</select>
									</div>
									<div class="col-md-3"><label>Data final do projeto</label>
										<input type="text" name="finalProjeto" id="datepicker05" class="form-control" value="<?php 
										if(returnEmptyDate('finalProjeto', $idProjeto) > 0 ){ 
											$var = strtotime(returnEmptyDate('finalProjeto', $idProjeto));
											echo date("d",$var) . "/";
											echo date("m",$var) . "/";
											echo date("Y",$var);
										} else{
											echo "00/00/0000";
										}
										?>">
									</div>
									<div class="col-md-3"><label>Data para prestar contas</label>
										<input type="text" name="prestarContas" id="datepicker06" class="form-control" value="<?php 
										if(returnEmptyDate('prestarContas', $idProjeto) > 0 ){ 
											$var = strtotime(returnEmptyDate('prestarContas', $idProjeto));
											echo date("d",$var) . "/";
											echo date("m",$var) . "/";
											echo date("Y",$var);
										} else{
											echo "00/00/0000";
										}
										?>">
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-offset-2 col-md-8"><input type="submit" name="gravarPrazos" class="btn btn-theme btn-lg btn-block" value="Gravar"></div>
								</div>
							</form>

						</div>

						<!-- LABEL PROJETO -->
						<div role="tabpanel" class="tab-pane fade" id="projeto" align="left">
							<br>
							<table class="table table-bordered">
								<tr>
									<td><strong>Protocolo:</strong> <?php echo $projeto['idProjeto']; ?></td>
									<td><strong>Tipo:</strong>
										<?php if($projeto['tipoPessoa'] == 1){ echo "Pessoa Física"; } else { echo "Pessoa Jurídica"; } ?>
									</td>
									<?php if($projeto['tipoPessoa'] == 1) { ?>
										<td><strong>Cooperado:</strong> <?php if($pf['cooperado'] == 1){ echo "Sim"; } else { echo "Não"; } ?></td>
									<?php } else { ?>
										<td><strong>Cooperativa:</strong> <?php if($pj['cooperativa'] == 1){ echo "Sim"; } else { echo "Não"; } ?></td>
									<?php } ?>
								</tr>
								<tr>
									<td><strong>Valor do projeto:</strong> <?php echo isset($projeto['valorProjeto']) ? $projeto['valorProjeto'] : null; ?></td>
									<td><strong>Valor do incentivo:</strong> <?php echo isset($projeto['valorIncentivo']) ? $projeto['valorIncentivo'] : null; ?></td>
									<td><strong>Valor do financiamento:</strong> <?php echo isset($projeto['valorFinanciamento']) ? $projeto['valorFinanciamento'] : null; ?></td>
								</tr>
								<tr>
									<td><strong>Área de atuação:</strong></td>
									<td colspan="2"><strong>Renúncia Fiscal:</strong> </td>
								</tr>
								<tr>
									<td colspan="3"><strong>Exposição da Marca:</strong> <?php echo isset($projeto['exposicaoMarca']) ? $projeto['exposicaoMarca'] : null; ?></td>
								</tr>
								<tr>
									<td colspan="3"><strong>Resumo do projeto:</strong> <?php echo isset($projeto['resumoProjeto']) ? $projeto['resumoProjeto'] : null; ?></td>
								</tr>
								<tr>
									<td colspan="3"><strong>Currículo:</strong> <?php echo isset($projeto['curriculo']) ? $projeto['curriculo'] : null; ?></td>
								</tr>
								<tr>
									<td colspan="3"><strong>Descrição:</strong> <?php echo isset($projeto['descricao']) ? $projeto['descricao'] : null; ?></td>
								</tr>
								<tr>
									<td colspan="3"><strong>Justificativa:</strong> <?php echo isset($projeto['justificativa']) ? $projeto['justificativa'] : null; ?></td>
								</tr>
								<tr>
									<td colspan="3"><strong>Objetivo:</strong> <?php echo isset($projeto['objetivo']) ? $projeto['objetivo'] : null; ?></td>
								</tr>
								<tr>
									<td colspan="3"><strong>Metodologia:</strong> <?php echo isset($projeto['metodologia']) ? $projeto['metodologia'] : null; ?></td>
								</tr>
								<tr>
									<td colspan="3"><strong>Contrapartida:</strong> <?php echo isset($projeto['contrapartida']) ? $projeto['contrapartida'] : null; ?></td>
								</tr>
							</table>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Local</b></li>
								<li class="list-group-item">
									<table class="table table-bordered">
										
									</table>
								</li>
							</ul>
							<table class="table table-bordered">
								<tr>
									<td colspan="3"><strong>Público alvo:</strong> <?php echo isset($projeto['publicoAlvo']) ? $projeto['publicoAlvo'] : null; ?></td>
								</tr>
								<tr>
									<td colspan="3"><strong>Plano de divulgação:</strong> <?php echo isset($projeto['planoDivulgacao']) ? $projeto['planoDivulgacao'] : null; ?></td>
								</tr>
							</table>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Ficha Técnica</b></li>
								<li class="list-group-item">
									<table class="table table-bordered">
										
									</table>
								</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Cronograma</b></li>
								<li class="list-group-item">
									<table class="table table-bordered">
										<tr>
											<td><strong>Início do cronograma:</strong> <?php echo isset($projeto['inicioCronograma']) ? $projeto['inicioCronograma'] : null; ?></td>
											<td><strong>Fim do cronograma:</strong> <?php echo isset($projeto['fimCronograma']) ? $projeto['fimCronograma'] : null; ?></td>
										</tr>
										<tr>
											<td><strong>Captação de recursos:</strong> <?php echo $cronograma['captacaoRecurso'] ?></td>
											<td><strong>Pré-Produção:</strong> <?php echo $cronograma['preProducao'] ?></td>
										</tr>
										<tr>
											<td><strong>Produção:</strong> <?php echo $cronograma['producao'] ?></td>
											<td><strong>Pós-Produção:</strong> <?php echo $cronograma['posProducao'] ?></td>
										</tr>
										<tr>
											<td colspan="2"><strong>Prestação de Contas:</strong> <?php echo $cronograma['prestacaoContas'] ?></td>
										</tr>
									</table>
								</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Orçamento</b></li>
								<li class="list-group-item">
									<table class="table table-bordered">
										
									</table>
								</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Mídias sociais</b></li>
								<li class="list-group-item"><strong>Vídeo 1:</strong> <?php echo isset($projeto['video1']) ? $projeto['video1'] : null; ?></li>
								<li class="list-group-item"><strong>Vídeo 2:</strong> <?php echo isset($projeto['video2']) ? $projeto['video2'] : null; ?></li>
								<li class="list-group-item"><strong>Vídeo 3:</strong> <?php echo isset($projeto['video3']) ? $projeto['video3'] : null; ?></li>
							</ul>
						</div>

						<!-- LABEL PESSOA FÍSICA -->
						<div role="tabpanel" class="tab-pane fade" id="F" align="left">
							<br>
							<table class="table table-bordered">
								<tr>
									<td colspan="2"><strong>Nome:</strong> <?php echo isset($pf['nome']) ? $pf['nome'] : null; ?></td>
								</tr>
								<tr>
									<td width="50%"><strong>CPF:</strong> <?php echo isset($pf['cpf']) ? $pf['cpf'] : null; ?></td>
									<td><strong>RG:</strong> <?php echo isset($pf['rg']) ? $pf['rg'] : null; ?></td>
								</tr>
								<tr>
									<td colspan="2"><strong>Endereço:</strong> <?php echo isset($pf['logradouro']) ? $pf['logradouro'] : null; ?>, <?php echo isset($pf['numero']) ? $pf['numero'] : null; ?> <?php echo isset($pf['complemento']) ? $pf['complemento'] : null; ?> - <?php echo isset($pf['bairro']) ? $pf['bairro'] : null; ?> - <?php echo isset($pf['cidade']) ? $pf['cidade'] : null; ?> - <?php echo isset($pf['estado']) ? $pf['estado'] : null; ?> - CEP <?php echo isset($pf['cep']) ? $pf['cep'] : null; ?></td>
								</tr>
								<tr>
									<td><strong>Telefone:</strong> <?php echo isset($pf['telefone']) ? $pf['telefone'] : null; ?></td>
									<td><strong>Celular:</strong> <?php echo isset($pf['celular']) ? $pf['celular'] : null; ?></td>
								</tr>
								<tr>
									<td><strong>E-mail:</strong> <?php echo isset($pf['email']) ? $pf['email'] : null; ?></td>
									<td><strong>Cooperado:</strong> <?php if($pf['cooperado'] == 1){ echo "Sim"; } else { echo "Não"; } ?></td>
								</tr>
							</table>
						</div>

						<!-- LABEL PESSOA JURÍDICA -->
						<div role="tabpanel" class="tab-pane fade" id="J">
							<br>
							<table class="table table-bordered">
								<tr>
									<td colspan="2"><strong>Razão Social:</strong> <?php echo isset($pj['razaoSocial']) ? $pj['razaoSocial'] : null; ?></td>
								</tr>
								<tr>
									<td width="50%"><strong>CNPJ:</strong> <?php echo isset($pj['cnpj']) ? $pj['cnpj'] : null; ?></td>
									<td><strong>CCM:</strong> <?php echo isset($pj['ccm']) ? $pj['ccm'] : null; ?></td>
								</tr>
								<tr>
									<td colspan="2"><strong>Endereço:</strong> <?php echo isset($pj['logradouro']) ? $pj['logradouro'] : null; ?>, <?php echo isset($pf['numero']) ? $pf['numero'] : null; ?> <?php echo isset($pj['complemento']) ? $pj['complemento'] : null; ?> - <?php echo isset($pj['bairro']) ? $pj['bairro'] : null; ?> - <?php echo isset($pj['cidade']) ? $pj['cidade'] : null; ?> - <?php echo isset($pj['estado']) ? $pj['estado'] : null; ?> - CEP <?php echo isset($pj['cep']) ? $pj['cep'] : null; ?></td>
								</tr>
								<tr>
									<td><strong>Telefone:</strong> <?php echo isset($pj['telefone']) ? $pj['telefone'] : null; ?></td>
									<td><strong>Celular:</strong> <?php echo isset($pj['celular']) ? $pj['celular'] : null; ?></td>
								</tr>
								<tr>
									<td><strong>E-mail:</strong> <?php echo isset($pj['email']) ? $pj['email'] : null; ?></td>
									<td><strong>Cooperativa:</strong> <?php if($pj['cooperativa'] == 1){ echo "Sim"; } else { echo "Não"; } ?></td>
								</tr>
							</table>
						</div>
					</div><!-- class="tab-content" -->
				</div><!-- role="tabpanel" -->
			</div>
		</div>
	</div>
</section>