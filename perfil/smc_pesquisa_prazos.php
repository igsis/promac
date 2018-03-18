<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Pesquisar Prazos</h4>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=smc_pesquisa_geral_resultado" class="form-horizontal" role="form">

					<hr/>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-2"><br/><label>Prazo de captação</label></div>
						<div class="col-md-3"><label>De</label>
							<input type="text" name="deCaptacao" class="form-control" placeholder="">
						</div>
						<div class="col-md-3"><label>Até</label>
							<input type="text" name="ateCaptacao" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-2"><br/><label>Final captação</label></div>
						<div class="col-md-3"><label>De</label>
							<input type="text" name="deFinalCaptacao" class="form-control" placeholder="">
						</div>
						<div class="col-md-3"><label>Para</label>
							<input type="text" name="ateFinalCaptacao" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-2"><br/><label>Execução</label></div>
						<div class="col-md-3"><label>De</label>
							<input type="text" name="inicioExecucao" class="form-control" placeholder="">
						</div>
						<div class="col-md-3"><label>Para</label>
							<input type="text" name="fimExecucao" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-2"><br/><label>Final do projeto</label></div>
						<div class="col-md-3"><label>De</label>
							<input type="text" name="deFinal" class="form-control" placeholder="">
						</div>
						<div class="col-md-3"><label>Para</label>
							<input type="text" name="ateFinal" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-2"><br/><label>Prestar Contas</label></div>
						<div class="col-md-3"><label>De</label>
							<input type="text" name="deContas" class="form-control" placeholder="">
						</div>
						<div class="col-md-3"><label>Para</label>
							<input type="text" name="ateContas" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="pesquisarPrazos" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>