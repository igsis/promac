<?php
$pasta = "?perfil=";
?>
<div class="well">
	<div class="form-group" style="padding-bottom: 60px;">
		<div class="col-md-offset-4 col-md-4">
			<form method="POST" action="<?=$pasta?>consulta_publica">
				<input type="hidden" name="consulta" value="1">
				<button class="btn btn-theme btn-md btn-block" style="border-radius: 30px;">Consulta Pública</button>
			</form>
		</div>
	</div>
	<h6>Listar:</h6>
	<div class="form-group" style="padding-bottom: 60px;">
		<div class="col-md-offset-2 col-md-4">
			<form method="POST" action="<?=$pasta?>consulta_publica_proponente_pf">
				<input type="hidden" name="consulta" value="1">
				<button class="btn btn-theme btn-md btn-block" style="border-radius: 30px;">Proponente Pessoa Física</button>
			</form>
			<form method="POST" action="<?=$pasta?>consulta_publica_proponente_pj">
				<input type="hidden" name="consulta" value="1">
				<button class="btn btn-theme btn-md btn-block" style="border-radius: 30px;">Proponente Pessoa Jurídica</button>
			</form>
		</div>
		<div class="col-md-4">
			<form method="POST" action="<?=$pasta?>consulta_publica_incentivador_pf">
				<input type="hidden" name="consulta" value="1">
				<button class="btn btn-theme btn-md btn-block" style="border-radius: 30px;">Incentivador Pessoa Física</button>
			</form>
			<form method="POST" action="<?=$pasta?>consulta_publica_incentivador_pj">
				<input type="hidden" name="consulta" value="1">
				<button class="btn btn-theme btn-md btn-block" style="border-radius: 30px;">Incentivador Pessoa Jurídica</button>
			</form>
		</div>
	</div>
</div>