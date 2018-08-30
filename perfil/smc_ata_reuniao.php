<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Gerar Relatório de Ata de Reunião</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="../pdf/ata_reuniao.php" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-3 col-md-3"><label>Data da reunião</label>
							<input type="text" name="data" id="datepicker01" class="form-control" placeholder="">
						</div>
						<div class="col-md-3"><br/>
							<input type="submit" class="btn btn-theme btn-md btn-block" value="Gerar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>