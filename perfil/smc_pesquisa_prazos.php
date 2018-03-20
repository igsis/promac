<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Pesquisar Prazos</h4>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<select class="form-control" id="metodoPesquisa">
					<option>Escolha o modo de Pesquisa</option>
					<option data-region="prazoCaptacao">Prazo de Captação</option>
					<option data-region="finalCaptacao">Final Captação</option>
					<option data-region="execucao">Execução</option>
					<option data-region="finalProjeto">Final do Projeto</option>
					<option data-region="prestarContas">Prestar Contas</option>
				</select>
				<hr/>

				<div class="content">
					<form method="POST" action="?perfil=smc_pesquisa_prazos_resultado" class="form-horizontal" role="form">
						<div id="prazoCaptacao" class="pesquisa">
							<div class="form-group">
								<div class="col-md-offset-2 col-md-2"><br/><label>Prazo de captação</label></div>
								<div class="col-md-3"><label>De</label>
									<input type="text" name="deCaptacao" id="datepicker01" class="form-control" placeholder="">
								</div>
								<div class="col-md-3"><label>Até</label>
									<input type="text" name="ateCaptacao" id="datepicker02" class="form-control" placeholder="">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<input type="hidden" name="metodoPesquisa" value="1">
									<input type="submit" name="pesquisarPrazos" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
								</div>
							</div>
						</div>
					</form>

					<form method="POST" action="?perfil=smc_pesquisa_prazos_resultado" class="form-horizontal" role="form">
						<div id="finalCaptacao" class="pesquisa">
							<div class="form-group">
								<div class="col-md-offset-2 col-md-2"><br/><label>Final captação</label></div>
								<div class="col-md-3"><label>De</label>
									<input type="text" name="deFinalCaptacao" id="datepicker03" class="form-control" placeholder="">
								</div>
								<div class="col-md-3"><label>Até</label>
									<input type="text" name="ateFinalCaptacao" id="datepicker04" class="form-control" placeholder="">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<input type="hidden" name="metodoPesquisa" value="finalCaptacao">
									<input type="submit" name="pesquisarPrazos" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
								</div>
							</div>
						</div>
					</form>

					<form method="POST" action="?perfil=smc_pesquisa_prazos_resultado" class="form-horizontal" role="form">
						<div id="execucao" class="pesquisa">
							<div class="form-group">
								<div class="col-md-offset-2 col-md-2"><br/><label>Execução</label></div>
								<div class="col-md-3"><label>De</label>
									<input type="text" name="inicioExecucao" id="datepicker05" class="form-control" placeholder="">
								</div>
								<div class="col-md-3"><label>Até</label>
									<input type="text" name="fimExecucao" id="datepicker06" class="form-control" placeholder="">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<input type="hidden" name="metodoPesquisa" value="execucao">
									<input type="submit" name="pesquisarPrazos" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
								</div>
							</div>
						</div>
					</form>

					<form method="POST" action="?perfil=smc_pesquisa_prazos_resultado" class="form-horizontal" role="form">
						<div id="finalProjeto" class="pesquisa">
							<div class="form-group">
								<div class="col-md-offset-2 col-md-2"><br/><label>Final do projeto</label></div>
								<div class="col-md-3"><label>De</label>
									<input type="text" name="deFinal" id="datepicker07" class="form-control" placeholder="">
								</div>
								<div class="col-md-3"><label>Até</label>
									<input type="text" name="ateFinal" id="datepicker08" class="form-control" placeholder="">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<input type="hidden" name="metodoPesquisa" value="finalProjeto">
									<input type="submit" name="pesquisarPrazos" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
								</div>
							</div>
						</div>
					</form>

					<form method="POST" action="?perfil=smc_pesquisa_prazos_resultado" class="form-horizontal" role="form">
						<div id="prestarContas" class="pesquisa">
							<div class="form-group">
								<div class="col-md-offset-2 col-md-2"><br/><label>Prestar Contas</label></div>
								<div class="col-md-3"><label>De</label>
									<input type="text" name="deContas" id="datepicker09" class="form-control" placeholder="">
								</div>
								<div class="col-md-3"><label>Até</label>
									<input type="text" name="ateContas" id="datepicker10" class="form-control" placeholder="">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<input type="hidden" name="metodoPesquisa" value="prestarContas">
									<input type="submit" name="pesquisarPrazos" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
								</div>
							</div>
						</div>
					</form>

				</div>
			</div>
		</div>
	</div>
</section>