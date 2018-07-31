<?php
$con = bancoMysqli();

if(isset($_POST['idProjeto']))
{
	$idProjeto = $_POST['idProjeto'];
	$_SESSION['idProjeto'] = $idProjeto;
}
else
{
	if(isset($_SESSION['idProjeto']))
	{
		$idProjeto = $_SESSION['idProjeto'];
	}
	else
	{
		$idProjeto = null;
	}
}

// $idProjeto = isset($_POST['idProjeto'])?$_POST['idProjeto']:null;
// $_SESSION['idProjeto'] = $idProjeto;
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);

// Gerar documentos
$server = "http://".$_SERVER['SERVER_NAME']."/promac/";
$http = $server."/pdf/";
$link1 = $http."rlt_projeto.php";

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
		$sql_insere = "INSERT INTO prazos_projeto (idProjeto, prazoCaptacao, prorrogacaoCaptacao, finalCaptacao, inicioExecucao, fimExecucao, prorrogacaoExecucao, finalProjeto, prestarContas, publicado) VALUES ('$idProjeto', '$prazoCaptacao', '$prorrogacaoCaptacao', '$finalCaptacao', '$inicioExecucao', '$fimExecucao', '$prorrogacaoExecucao', '$finalProjeto', '$prestarContas', 0)";
		if(mysqli_query($con,$sql_insere))
		{
			$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Utilize o menu para avançar.</strong></font>";
			gravarLog($sql_insere);
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
			gravarLog($sql_edita);
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao editar! Tente novamente.</strong></font>";
		}
	}
}

if(isset($_POST['gravarAdm']))
{
	$valorAprovado = dinheiroDeBr($_POST['valorAprovado']);
	$sql_gravarAdm = "UPDATE projeto SET valorAprovado = '$valorAprovado' WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_gravarAdm))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
		gravarLog($sql_gravarAdm);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
	}
}

if(isset($_POST['gravarNota']))
{
	if ($idProjeto != 0)
	{
		$dateNow = date('Y:m:d h:i:s');
		$nota = addslashes($_POST['nota']);
		$sql_nota = "INSERT INTO notas (idProjeto, data, nota, interna) VALUES ('$idProjeto', '$dateNow', '$nota', '2')";
		if(mysqli_query($con,$sql_nota))
		{
			$mensagem = "<font color='#01DF3A'><strong>Nota inserida com sucesso!</strong></font>";
			gravarLog($sql_nota);
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao inserir nota! Tente novamente.</strong></font>";
		}
	}
}

if(isset($_POST['solicitaReabertura']))
{
	$idP = $_POST['IDP'];
	$dateNow = date('Y:m:d h:i:s');
	$sql_solicitaReabertura = "UPDATE projeto SET idStatus = '8', solicitacaoReabertura = '$dateNow' WHERE idProjeto = '$idP' ";
	if(mysqli_query($con,$sql_solicitaReabertura))
	{
		$mensagem = "<font color='#01DF3A'><strong>Reaberto com sucesso!</strong></font>";
		echo "<script>window.location = '?perfil=comissao_detalhes_projeto&idFF=$idP';</script>";
		gravarLog($sql_solicitaReabertura);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao reabrir! Tente novamente.</strong></font>";
	}
}

if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '9'";
	$query_arquivos = mysqli_query($con,$sql_arquivos);
	while($arq = mysqli_fetch_array($query_arquivos))
	{
		$y = $arq['idListaDocumento'];
		$x = $arq['sigla'];
		$nome_arquivo = isset($_FILES['arquivo']['name'][$x]) ? $_FILES['arquivo']['name'][$x] : null;
		$f_size = isset($_FILES['arquivo']['size'][$x]) ? $_FILES['arquivo']['size'][$x] : null;

		//Extensões permitidas
		$ext = array("PDF","pdf");

		if($f_size > 3145728) // 3MB em bytes
		{
			$mensagem = "<font color='#01DF3A'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 03 MB.</strong></font>";
		}
		else
		{
			if($nome_arquivo != "")
			{
				$nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
				$new_name = date("YmdHis")."_".semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
				$hoje = date("Y-m-d H:i:s");
				$dir = '../uploadsdocs/'; //Diretório para uploads*/

				$allowedExts = array(".pdf", ".PDF"); //Extensões permitidas
				$ext = strtolower(substr($nome_arquivo,-4));

				if(in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas
				{
					if(move_uploaded_file($nome_temporario, $dir.$new_name))
					{
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipo`, `idPessoa`, `idListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('9', '$idProjeto', '$y', '$new_name', '$hoje', '1'); ";
						$query = mysqli_query($con,$sql_insere_arquivo);
						if($query)
						{
							$mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
							gravarLog($sql_insere_arquivo);
							//echo '<script>window.location = "?perfil=anexos"</script>';
						}
						else
						{
							$mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco.</strong></font>";
						}
					}
					else
					{
						$mensagem = "<font color='#FF0000'><strong>Erro no upload! Tente novamente.</strong></font>";
					}
				}
				else
				{
					$mensagem = "<font color='#FF0000'><strong>Erro no upload! Anexar documentos somente no formato PDF.</strong></font>";
				}
			}
		}
	}
}

if(isset($_POST['apagar']))
{
	$idArquivo = $_POST['apagar'];
	$sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE idUploadArquivo = '$idArquivo'";
	if(mysqli_query($con,$sql_apagar_arquivo))
	{
		$mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
		gravarLog($sql_apagar_arquivo);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
	}
}

if($projeto['tipoPessoa'] == 1)
{
	$pf = recuperaDados("pessoa_fisica","idPf",$projeto['idPf']);
}
else
{
	$pj = recuperaDados("pessoa_juridica","idPj",$projeto['idpj']);
}

if(isset($_POST['idComissao']))
{
	$con = bancoMysqli();
	$idComissao = $_POST['comissao'];
	$idProjeto = $_POST['idComissao'];
	$sql_atualiza_comissao = "UPDATE projeto SET idComissao = '$idComissao' WHERE idProjeto = '$idProjeto'";
	$query_atualiza_comissao = mysqli_query($con,$sql_atualiza_comissao);
	if($query_atualiza_comissao)
	{
		$mensagem = "Parecerista responsável pelo projeto atualizado!";
	}
	else
	{
		$mensagem = "Erro o atribuir! Tente novamente.";
	}
}

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$prazos = recuperaDados("prazos_projeto","idProjeto",$idProjeto);
$area = recuperaDados("area_atuacao","idArea",$projeto['idAreaAtuacao']);
$renuncia = recuperaDados("renuncia_fiscal","idRenuncia",$projeto['idRenunciaFiscal']);
$cronograma = recuperaDados("cronograma","idCronograma",$projeto['idCronograma']);
$video = recuperaDados("projeto","idProjeto",$idProjeto);
$v = array($video['video1'], $video['video2'], $video['video3']);
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_comissao.php'; ?>
		<div class="form-group">
			<h4>Ambiente Comissão</h4>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div role="tabpanel">
					<!-- LABELS -->
					<ul class="nav nav-tabs">
						<li class="nav active"><a href="#adm" data-toggle="tab">Administrativo</a></li>
						<li class="nav"><a href="#projeto" data-toggle="tab">Projeto</a></li>
						<li class="nav"><a href="#F" data-toggle="tab">Pessoa Fisica</a></li>
						<li class="nav"><a href="#J" data-toggle="tab">Pessoa Jurídica</a></li>
					</ul>

					<div class="tab-content">
						<!-- LABEL ADMINISTRATIVO-->
						<div role="tabpanel" class="tab-pane fade in active" id="adm">
							<div class="form-group">
								<div class="col-md-offset-1 col-md-10"></div>
							</div>
							<!-- Diretor da Comissão -->
						<?php 
							$direcao = recuperaDados("pessoa_fisica","idPf", $_SESSION['idUser']);
							if($direcao['idNivelAcesso'] == 3)
							{
						?>	
						<form class="form-horizontal" role="form" action="?perfil=comissao_detalhes_projeto" method="post">
						<div class="form-group">
							<div class="col-md-offset-2 col-md-5"><strong>Parecerista responsável no Setor de Comissão:</strong><br/>
								<select class="form-control" name="comissao" id="">
									<option value='0'></option>
									<?php  geraOpcaoComissao($projeto['idComissao']); ?>
								</select>
							</div>
							<div class="col-md-3"><br/>
								<input type="hidden" name="idComissao" value="<?php echo $idProjeto; ?>" />
								<input type="submit" class="btn btn-theme  btn-block" value="Atualizar responsável">
							</div>
						</div>
						</form>
						<?php
						}
						?>
							<form method="POST" action="?perfil=comissao_detalhes_projeto" class="form-horizontal" role="form">
								<div class="form-group">
									<div class="col-md-offset-2 col-md-6" align="right"><br/><label>Solicitar reabertura do projeto para edição?</label><br><?php echo exibirDataHoraBr($projeto['solicitacaoReabertura']) ?>
									</div>
									<div class="col-md-2"><br/>
										<?php echo "<input type='hidden' name='IDP' value='$idProjeto'>"; ?>
										<input type="submit" name="solicitaReabertura" class="btn btn-theme btn-md btn-block" value="Sim">
									</div>
								</div>
							</form>

							<form method="POST" action="?perfil=comissao_detalhes_projeto" class="form-horizontal" role="form">
								<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-4">
									<?php
										$id = $projeto['tipoPessoa'];
										$idP = $projeto['idProjeto'];
										if($id == 1)
										{
											$idPess = $projeto['idpf'];
										} else if($id == 2)
										{
											$idPess = $projeto['idpj'];
										}
									?>
										<a href='<?php echo "../pdf/gera_pdf.php?tipo=$id&projeto=$idP&pessoa=$idPess"; ?>' target='_blank' class="btn btn-theme btn-md btn-block"><strong>Gerar PDF do Projeto</strong></a><br/>
									</div>
									<div class="col-md-4">
									<a href='<?php echo "../pdf/gera_excel.php?tipo=$id&projeto=$idP&pessoa=$idPess"; ?>' target='_blank' class="btn btn-theme btn-md btn-block"><strong>Gerar Excel do Projeto</strong></a><br/>

									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-6"><label>Valor Aprovado</label><br/>
										<input type="text" name="valorAprovado" id='valor' class="form-control" value="<?php echo dinheiroParaBr($projeto['valorAprovado']) ?>">
									</div>
									<div class="col-md-6"><label><br/></label>
										<input type="hidden" name="idProjeto" value="<?php echo $idProjeto ?>">
										<input type="submit" name="gravarAdm" class="btn btn-theme btn-md btn-block" value="Gravar">
									</div>
								</div>
							</form>

							<div class="form-group">
								<div class="col-md-offset-1 col-md-10"><hr/></div>
							</div>

							<!-- Exibir arquivos -->
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
										<?php listaArquivosComissao($idProjeto,9,"comissao_detalhes_projeto"); ?>
									</div>
								</div>
							</div>

							<form method="POST" action="?perfil=comissao_detalhes_projeto" enctype="multipart/form-data">
							<div class="col-md-offset-2 col-md-8">
								<div class="table-responsive list_info"><h6>Upload de Arquivo(s) Somente em PDF</h6>
									<table class='table table-condensed'>
										<tr class='list_menu'>
											<td>Tipo de Arquivo</td>
											<td></td>
										</tr>
										<?php
										  $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '9'";
											$query_arquivos = mysqli_query($con,$sql_arquivos);
											while($arq = mysqli_fetch_array($query_arquivos))
											{
										?>
												<tr>
													<?php
													$doc = $arq['documento'];
													$query = "SELECT idListaDocumento FROM lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='9'";
													$envio = $con->query($query);
													$row = $envio->fetch_array(MYSQLI_ASSOC);

													if(verificaArquivosExistentesPF($idProjeto,$row['idListaDocumento'])){
														echo '<div class="alert alert-success">O arquivo ' . $doc . ' já foi enviado.</div>';
													}
													else{ ?>
													<td class="list_description path">
		                                              <?php
		                                                $path = selecionaArquivoAnexo(
		                                                $http, $arq['documento'] ) ?>
		                                               <?=$arq['documento'] ?>
		                                            </td>
													<td class="list_description"><input type='file' name='arquivo[<?php echo $arq['sigla']; ?>]'></td>
													<?php } ?>
												</tr>
										<?php
											}
										?>
									</table><br>
									<input type="hidden" name="idPessoa" value="<?php echo $idProjeto; ?>"  />
									<input type="hidden" name="idProjeto" value="<?php echo $idProjeto ?>">
									<input type="hidden" name="tipoPessoa" value="4"  />
									<input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>
								</div>
							</div></form>
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

							<div class="form-group">
								<div class="col-md-offset-1 col-md-10"><hr/></div>
							</div>

							<form method="POST" action="?perfil=comissao_detalhes_projeto" class="form-horizontal" role="form">
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8"><label>Notas</label><br/>
										<textarea name="nota" class="form-control" rows="10" placeholder="Insira neste campo informações de notificações para o usuário."></textarea>
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<input type="submit" name="gravarNota" class="btn btn-theme btn-md btn-block" value="Gravar">
									</div>
								</div>
							</form>
							<ul class='list-group'>
								<li class='list-group-item list-group-item-success'>Notas
								<?php
									$sql = "SELECT * FROM notas WHERE idProjeto = '$idProjeto'";
									$query = mysqli_query($con,$sql);
									$num = mysqli_num_rows($query);
									if($num > 0)
									{
										while($campo = mysqli_fetch_array($query))
										{
											echo "<li class='list-group-item' align='left'><strong>".exibirDataHoraBr($campo['data'])."</strong><br/>".$campo['nota']."</li>";
										}
									}
									else
									{
										echo "<li class='list-group-item'>Não há notas disponíveis.</li>";
									}
								?>
								</li>
							</ul>
						</div>

						<!-- LABEL PROJETO -->
						<div role="tabpanel" class="tab-pane fade" id="projeto" align="left">
							<br>
							<table class="table table-bordered">
								<tr>
									<td><strong>Protocolo (nº ISP):</strong> <?php echo $projeto['protocolo'] ?></td>
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
									<td><strong>Valor do projeto:</strong> R$ <?php echo isset($projeto['valorProjeto']) ? $projeto['valorProjeto'] : null; ?></td>
									<td><strong>Valor do incentivo:</strong> R$ <?php echo isset($projeto['valorIncentivo']) ? $projeto['valorIncentivo'] : null; ?></td>
									<td><strong>Valor do financiamento:</strong> R$ <?php echo isset($projeto['valorFinanciamento']) ? $projeto['valorFinanciamento'] : null; ?></td>
								</tr>
								<tr>
									<td colspan="2"><strong>Área de atuação:</strong> <?php echo $area['areaAtuacao'] ?></td>
									<td><strong>Renúncia Fiscal:</strong> <?php echo $renuncia['renunciaFiscal'] ?></td>
								</tr>
								<tr>
									<td colspan="3"><strong>Nome do Projeto:</strong> <?php echo isset($projeto['nomeProjeto']) ? $projeto['nomeProjeto'] : null; ?></td>
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
										<tr>
											<th>Local</th>
											<th>Público estimado</th>
											<th>Zona</th>
										</tr>
										<?php
										$sql = "SELECT * FROM locais_realizacao
												WHERE publicado = 1 AND idProjeto = ".$projeto['idProjeto']."";
										$query = mysqli_query($con,$sql);
										while($campo = mysqli_fetch_array($query))
										{
											$zona = recuperaDados("zona","idZona",$campo['idZona']);
											echo "<tr>";
											echo "<td>".$campo['local']."</td>";
											echo "<td>".$campo['estimativaPublico']."</td>";
											echo "<td>".$zona['zona']."</td>";
											echo "</tr>";
										}
										?>
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
										<tr>
											<th>Nome</th>
											<th>CPF</th>
											<th>Função</th>
										</tr>
										<?php
										$sql = "SELECT * FROM ficha_tecnica
												WHERE publicado = 1 AND idProjeto = '$idProjeto'";
										$query = mysqli_query($con,$sql);
										while($campo = mysqli_fetch_array($query))
										{
											echo "<tr>";
											echo "<td class='list_description'>".$campo['nome']."</td>";
											echo "<td class='list_description'>".$campo['cpf']."</td>";
											echo "<td class='list_description'>".$campo['funcao']."</td>";
											echo "</tr>";
										}?>
									</table>
								</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Cronograma</b></li>
								<li class="list-group-item">
									<table class="table table-bordered">
										<tr>
											<td><strong>Início do cronograma:</strong> <?php echo exibirDataBr($projeto['inicioCronograma']) ?></td>
											<td><strong>Fim do cronograma:</strong> <?php echo exibirDataBr($projeto['fimCronograma']) ?></td>
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
								<?php
									for ($i = 1; $i <= 7; $i++)
									{
										$sql_etapa = "SELECT idEtapa, SUM(valorTotal) AS tot FROM orcamento
											WHERE publicado > 0 AND idProjeto ='$idProjeto' AND idEtapa = '$i'
											ORDER BY idOrcamento";
										$query_etapa = mysqli_query($con,$sql_etapa);
										$lista = mysqli_fetch_array($query_etapa);

										$etapa = recuperaDados("etapa","idEtapa",$lista['idEtapa']);
										echo "<li class='list-group-item'><strong>".$etapa['etapa'].":</strong> R$ ".dinheiroParaBr($lista['tot'])."</li>";
									}
									$sql_total = "SELECT SUM(valorTotal) AS tot FROM orcamento
											WHERE publicado > 0 AND idProjeto ='$idProjeto'
											ORDER BY idOrcamento";
									$query_total = mysqli_query($con,$sql_total);
									$total = mysqli_fetch_array($query_total);
									echo "<li class='list-group-item'><strong>TOTAL:</strong> R$ ".dinheiroParaBr($total['tot'])."</li>";
								?>
								<li class="list-group-item">
									<table class="table table-bordered">
										<tr>
											<td width='25%'><strong>Etapa</strong></td>
											<td><strong>Descrição</strong></td>
											<td width='5%'><strong>Qtde</strong></td>
											<td width='5%'><strong>Unid. Med.</strong></td>
											<td width='5%'><strong>Qtde Unid.</strong></td>
											<td><strong>Valor Unit.</strong></td>
											<td><strong>Valor Total</strong></td>
										</tr>
										<?php
										$sql = "SELECT * FROM orcamento
												WHERE publicado > 0 AND idProjeto ='$idProjeto'
												ORDER BY idEtapa";
										$query = mysqli_query($con,$sql);
										while($campo = mysqli_fetch_array($query))
										{
											$etapa = recuperaDados("etapa","idEtapa",$campo['idEtapa']);
											$medida = recuperaDados("unidade_medida","idUnidadeMedida",$campo['idUnidadeMedida']);
											echo "<tr>";
											echo "<td class='list_description'>".$etapa['etapa']."</td>";
											echo "<td class='list_description'>".$campo['descricao']."</td>";
											echo "<td class='list_description'>".$campo['quantidade']."</td>";
											echo "<td class='list_description'>".$medida['unidadeMedida']."</td>";
											echo "<td class='list_description'>".$campo['quantidadeUnidade']."</td>";
											echo "<td class='list_description'>".dinheiroParaBr($campo['valorUnitario'])."</td>";
											echo "<td class='list_description'>".dinheiroParaBr($campo['valorTotal'])."</td>";
											echo "</tr>";
										}?>
									</table>
								</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Mídias sociais</b></li>
								<li class="list-group-item">
									<?php
									if(!empty($video['video1'] || $video['video2'] || $video['video3']))
									{?>
										<table class='table table-condensed'>
										<?php
										foreach ($v as $key => $m)
										{
											if (!empty($m))
											{
												$desc = "https://www.youtube.com/oembed?format=json&url=".$m;
												$obj =	json_decode(file_get_contents($desc), true);
											?>
												<tr>
													<td>
														<img src="<?php echo $obj['thumbnail_url']; ?>" style='width: 150px;'>
													</td>
													<td>
														<?php echo $obj['title']; ?><br/>
														<?php echo $m ?>
													</td>
												</tr>
										<?php
											}
										}?>
											</table>
									<?php
									}
									else
									{
										echo "<p>Não há video(s) inserido(s).<p/><br/>";
									}
									?>
								</li>
							</ul>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Arquivos do Projeto</b></li>
								<li class="list-group-item"><?php exibirArquivos(3,$projeto['idProjeto']); ?></li>
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
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Arquivos da Pessoa Física</b></li>
								<li class="list-group-item"><?php exibirArquivos(1,$pf['idPf']); ?></li>
							</ul>
						</div>

						<!-- LABEL PESSOA JURÍDICA -->
						<div role="tabpanel" class="tab-pane fade" id="J">
							<br>
							<?php if($projeto['tipoPessoa'] == 2) { ?>
							<table class="table table-bordered">
								<tr>
									<td colspan="2"><strong>Razão Social:</strong> <?php echo isset($pj['razaoSocial']) ? $pj['razaoSocial'] : null; ?></td>
								</tr>
								<tr>
									<td width="50%"><strong>CNPJ:</strong> <?php echo isset($pj['cnpj']) ? $pj['cnpj'] : null; ?></td>
									<td><strong>CCM:</strong> <?php echo isset($pj['ccm']) ? $pj['ccm'] : null; ?></td>
								</tr>
								<tr>
									<td colspan="2"><strong>Endereço:</strong> <?php echo isset($pj['logradouro']) ? $pj['logradouro'] : null; ?>, <?php echo isset($pj['numero']) ? $pj['numero'] : null; ?> <?php echo isset($pj['complemento']) ? $pj['complemento'] : null; ?> - <?php echo isset($pj['bairro']) ? $pj['bairro'] : null; ?> - <?php echo isset($pj['cidade']) ? $pj['cidade'] : null; ?> - <?php echo isset($pj['estado']) ? $pj['estado'] : null; ?> - CEP <?php echo isset($pj['cep']) ? $pj['cep'] : null; ?></td>
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
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Arquivos da Pessoa Jurídica</b></li>
								<li class="list-group-item"><?php exibirArquivos(2,$pj['idPj']); ?></li>
							</ul>
							<?php } else { echo "<strong>Não há pessoa jurídica cadastrada.</strong>"; } ?>
						</div>
					</div><!-- class="tab-content" -->
				</div><!-- role="tabpanel" -->
			</div>
		</div>
	</div>
</section>