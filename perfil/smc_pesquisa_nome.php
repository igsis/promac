<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Nível de acesso</h4>
			<h6>Pesquisar Usuários</h6> 
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=smc_liberacao_acesso" class="form-horizontal" role="form">
					<hr/>
					<label>PESSOA FÍSICA</label>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-5"><label>Nome</label>
							<input type="text" name="nome" class="form-control" placeholder="">
						</div>
						<div class="col-md-3"><label>CPF</label>
							<input type="text" name="cpf" id="cpf" class="form-control" placeholder="">
						</div>
					</div>
					<hr/>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="pesquisarPf" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
