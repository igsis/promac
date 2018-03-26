<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Pesquisar Incentivadores</h4>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=smc_pesquisa_incentivador_pf_resultado" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-5"><label>Nome</label>
							<input type="text" name="nome" class="form-control" placeholder="">
						</div>
						<div class="col-md-3"><label>CPF</label>
							<input type="text" name="cpf" id="cpf" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Tipo de filtro</label>
							<select required class="form-control" name="liberado">
								<option value="0">Todos</option>
								<option value="1">Liberar inscrição de projeto</option>
								<option value="2">Visualizar as inscrições não aprovadas</option>
								<option value="3">Desbloquear dados do proponente para edição</option>
							</select>
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