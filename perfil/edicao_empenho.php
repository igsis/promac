<?php
$con = bancoMysqli();

$idReserva = $_GET['idReserva'];

$idEmpenho = $_POST['editarEmpenho'];
$empenho = recuperaDados("empenho", "idEmpenho", $idEmpenho);
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
		<div class="form-group">
			<h4>Edição de Empenho</h4>
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=empenho" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-1 col-md-3">
							<label><br/>Data</label><br/>
							<input type="text" id='datepicker01' name="data" class="form-control" maxlength="100" value="<?php echo $empenho['data'] ?>">
						</div>

						<div class="col-md-1"><label>Valor</label><br/>
							<input type="text" id='valor' name="valor" class="form-control" value="<?php echo $empenho['valor'] ?>" required>
						</div>

						<div class="col-md-1"><label>Número do Empenho</label><br/>
							<input type="text" name="numeroEmpenho" class="form-control" value="<?php echo $empenho['numeroEmpenho'] ?>" required>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-1 col-md-10">
							<input type="hidden" name="editarEmpenho" value="<?php echo $idEmpenho ?>">
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>