<?php
$con = bancoMysqli();
$idProjeto = isset($_POST['idProjeto']) ? $_POST['idProjeto'] : null;
if($idProjeto == null
){
    $idProjeto = isset($_GET['idFF']) ? $_GET['idFF'] : null;
}

$idReserva = $_POST['editarReserva'];
$reserva = recuperaDados("reserva", "idReserva", $idReserva);
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
		<div class="form-group">
			<h4>Edição de Reserva</h4>
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=reserva" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-1 col-md-3">
							<label><br/>Data</label><br/>
							<input type="text" id='datepicker01' name="data" class="form-control" maxlength="100" value="<?php echo $reserva['data'] ?>">
						</div>

						<div class="col-md-1"><label>Valor</label><br/>
							<input type="text" id='valor' name="valor" class="form-control" value="<?php echo $reserva['valor'] ?>" required>
						</div>

						<div class="col-md-1"><label>Número da Reserva</label><br/>
							<input type="text" name="numeroReserva" class="form-control" value="<?php echo $reserva['numeroReserva'] ?>" required>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-1 col-md-10">
							<input type="hidden" name="editaReserva" value="<?php echo $idReserva ?>">
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>