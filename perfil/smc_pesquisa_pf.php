<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Pesquisar Pessoa Física</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=smc_pesquisa_pf_resultado" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-5"><label>Nome</label>
							<input type="text" name="nome" class="form-control" placeholder="">
						</div>
						<div class="col-md-3"><label>CPF</label>
							<input type="text" name="cpf" id="cpf" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="pesquisar" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>