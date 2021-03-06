<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Reiniciar Senha <br>
				<small>Pesquisar Pessoas</small>
			</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<hr/>
				<div id="accordion">
					<div class="panel">
						<div class="form-group">
							<button type="button" class="btn btn-theme" data-parent="#accordion" data-toggle="collapse" data-target="#proponentePf">Proponente Pessoa Física</button>
						</div>
						<div id="proponentePf" class="collapse">
							<form method="POST" action="?perfil=smc_pesquisa_reseta_senha_resultado" class="form-horizontal" role="form">
								<label>PESSOA FÍSICA</label>
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
										<input type="hidden" name="tipo" value="pessoa_fisica">
										<input type="submit" name="pesquisaPf" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
									</div>
								</div>
							</form>
						</div>
					</div>
					
					<div class="panel">
						<div class="form-group">
							<button type="button" class="btn btn-theme" data-parent="#accordion" data-toggle="collapse" data-target="#proponentePj">Proponente Pessoa Jurídica</button>
						</div>
						<div id="proponentePj" class="collapse">
							<form method="POST" action="?perfil=smc_pesquisa_reseta_senha_resultado" class="form-horizontal" role="form">
								<label>PESSOA JURÍDICA</label>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-5"><label>Razão Social</label>
										<input type="text" name="razaoSocial" class="form-control" placeholder="">
									</div>
									<div class="col-md-3"><label>CNPJ</label>
										<input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<input type="hidden" name="tipo" value="pessoa_juridica">
										<input type="submit" name="pesquisaPj" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
									</div>
								</div>
							</form>
						</div>
					</div>

					<div class="panel">
						<div class="form-group">
							<button type="button" class="btn btn-theme" data-parent="#accordion" data-toggle="collapse" data-target="#incentivadorPf">Incentivador Pessoa Física</button>
						</div>
						<div id="incentivadorPf" class="collapse">
							<form method="POST" action="?perfil=smc_pesquisa_reseta_senha_resultado" class="form-horizontal" role="form">
								<label>INCENTIVADOR PESSOA FÍSICA</label>
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
										<input type="hidden" name="tipo" value="incentivador_pessoa_fisica">
										<input type="submit" name="pesquisaPf" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
									</div>
								</div>
							</form>
						</div>
					</div>

					<div class="panel">
						<div class="form-group">
							<button type="button" class="btn btn-theme" data-parent="#accordion" data-toggle="collapse" data-target="#incentivadorPj">Incentivador Pessoa Jurídica</button>
						</div>
						<div id="incentivadorPj" class="collapse">
							<form method="POST" action="?perfil=smc_pesquisa_reseta_senha_resultado" class="form-horizontal" role="form">
								<label>INCENTIVADOR PESSOA JURÍDICA</label>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-5"><label>Razão Social</label>
										<input type="text" name="razaoSocial" class="form-control" placeholder="">
									</div>
									<div class="col-md-3"><label>CNPJ</label>
										<input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<input type="hidden" name="tipo" value="incentivador_pessoa_juridica">
										<input type="submit" name="pesquisaPj" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>