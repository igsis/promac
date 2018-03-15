<?php
$con = bancoMysqli();

$idProjeto = $_POST['idProjeto'];
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);

if($projeto['tipoPessoa'] == 1)
{
	$pf = recuperaDados("pessoa_fisica","idPf",$projeto['idPf']);
}
else
{
	$pj = recuperaDados("pessoa_juridica","idPj",$projeto['idPj']);
}
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Ambiente SMC</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
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
									<br>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Informações iniciais</b></li>
										<li class="list-group-item">Razão Social</li>
										<li class="list-group-item">CNPJ</li>
									</ul>
								</div>

								<!-- LABEL PROJETO -->
								<div role="tabpanel" class="tab-pane fade" id="projeto" align="left">
									<br>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Informações legais</b></li>
										<li class="list-group-item"><strong>Referência:</strong> <?php echo $projeto['idProjeto']; ?></li>
										<li class="list-group-item"><strong>Valor do projeto:</strong> <?php echo isset($projeto['valorProjeto']) ? $projeto['valorProjeto'] : null; ?></li>
										<li class="list-group-item"><strong>Valor do incentivo:</strong> <?php echo isset($projeto['valorIncentivo']) ? $projeto['valorIncentivo'] : null; ?></li>
										<li class="list-group-item"><strong>Valor do financiamento:</strong> <?php echo isset($projeto['valorFinanciamento']) ? $projeto['valorFinanciamento'] : null; ?></li>
										<li class="list-group-item"><strong>Marca:</strong> <?php echo isset($projeto['exposicaoMarca']) ? $projeto['exposicaoMarca'] : null; ?></li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Informações gerais do projeto</b></li>
										<li class="list-group-item"><strong>Resumo do projeto:</strong> <?php echo isset($projeto['resumoProjeto']) ? $projeto['resumoProjeto'] : null; ?></li>
										<li class="list-group-item"><strong>Currículo:</strong> <?php echo isset($projeto['curriculo']) ? $projeto['curriculo'] : null; ?></li>
										<li class="list-group-item"><strong>Descrição:</strong> <?php echo isset($projeto['descricao']) ? $projeto['descricao'] : null; ?></li>
										<li class="list-group-item"><strong>Justificativa:</strong> <?php echo isset($projeto['justificativa']) ? $projeto['justificativa'] : null; ?></li>
										<li class="list-group-item"><strong>Objetivo:</strong> <?php echo isset($projeto['objetivo']) ? $projeto['objetivo'] : null; ?></li>
										<li class="list-group-item"><strong>Metodologia:</strong> <?php echo isset($projeto['metodologia']) ? $projeto['metodologia'] : null; ?></li>
										<li class="list-group-item"><strong>Contrapartida:</strong> <?php echo isset($projeto['contrapartida']) ? $projeto['contrapartida'] : null; ?></li>
										<li class="list-group-item"></li>
										<li class="list-group-item"></li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Detalhamento</b></li>
										<li class="list-group-item"><strong>Público alvo:</strong> <?php echo isset($projeto['publicoAlvo']) ? $projeto['publicoAlvo'] : null; ?></li>
										<li class="list-group-item"><strong>Plano de divulgação:</strong> <?php echo isset($projeto['planoDivulgacao']) ? $projeto['planoDivulgacao'] : null; ?></li>
										<li class="list-group-item"><strong>Início do cronograma:</strong> <?php echo isset($projeto['inicioCronograma']) ? $projeto['inicioCronograma'] : null; ?></li>
										<li class="list-group-item"><strong>Fim do cronograma:</strong> <?php echo isset($projeto['fimCronograma']) ? $projeto['fimCronograma'] : null; ?></li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Informações sobre custos</b></li>
										<li class="list-group-item"><strong>Pré-produção:</strong> <?php echo isset($projeto['totalPreProducao']) ? $projeto['totalPreProducao'] : null; ?></li>
										<li class="list-group-item"><strong>Produção:</strong> <?php echo isset($projeto['totalProducao']) ? $projeto['totalProducao'] : null; ?></li>
										<li class="list-group-item"><strong>Imprensa:</strong> <?php echo isset($projeto['totalImprensa']) ? $projeto['totalImprensa'] : null; ?></li>
										<li class="list-group-item"><strong>Administrativos:</strong> <?php echo isset($projeto['totalCustosAdministrativos']) ? $projeto['totalCustosAdministrativos'] : null; ?></li>
										<li class="list-group-item"><strong>Impostos:</strong> <?php echo isset($projeto['totalImpostos']) ? $projeto['totalImpostos'] : null; ?></li>
										<li class="list-group-item"><strong>Agenciamento:</strong> <?php echo isset($projeto['totalAgenciamento']) ? $projeto['totalAgenciamento'] : null; ?></li>
										<li class="list-group-item"><strong>Outros financiamentos:</strong> <?php echo isset($projeto['totalOutrosFinanciamentos']) ? $projeto['totalOutrosFinanciamentos'] : null; ?></li>
									</ul>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Mídias sociais</b></li>
										<li class="list-group-item"><strong>Vídeo 1:</strong> <?php echo isset($projeto['video1']) ? $projeto['video1'] : null; ?></li>
										<li class="list-group-item"><strong>Vídeo 2:</strong> <?php echo isset($projeto['video2']) ? $projeto['video2'] : null; ?></li>
										<li class="list-group-item"><strong>Vídeo 3:</strong> <?php echo isset($projeto['video3']) ? $projeto['video3'] : null; ?></li>
									</ul>
								</div>

								<!-- LABEL PESSOA FÍSICA -->
								<div role="tabpanel" class="tab-pane fade" id="F">
									<br>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Informações iniciais</b></li>
										<li class="list-group-item">Nome</li>
										<li class="list-group-item">CNPJ</li>
									</ul>
								</div>

								<!-- LABEL PESSOA JURÍDICA -->
								<div role="tabpanel" class="tab-pane fade" id="P">
									<br>
									<ul class="list-group">
										<li class="list-group-item list-group-item-success"><b>Informações iniciais</b></li>
										<li class="list-group-item">Razão Social</li>
										<li class="list-group-item">CNPJ</li>
									</ul>
								</div>
							</div>
						</div><!-- role="tabpanel" -->
					</div>
				</div>
			</div>
		</div>
	</div>
</section>