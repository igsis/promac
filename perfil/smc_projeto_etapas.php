<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Gerar Relatório de Etapas do Projeto</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="../pdf/excel_historico_etapa.php" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-4 col-md-2"><label>Data início</label>
							<input type="text" name="dataInicio" id="datepicker01" class="form-control" required>
						</div>
						<div class="col-md-2"><label>Data fim</label>
                            <input type="text" name="dataFim" id="datepicker02" class="form-control" required>
						</div>
					</div>
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-4">
                            <input type="submit" class="btn btn-theme btn-md btn-block" value="Gerar">
                        </div>
                    </div>
				</form>
			</div>
		</div>
	</div>
</section>