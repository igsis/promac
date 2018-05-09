<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

$idLocaisRealizacao = $_POST['editarLocal'];
$local = recuperaDados("locais_realizacao", "idLocaisRealizacao", $idLocaisRealizacao);
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
    	<?php
    	if($_SESSION['tipoPessoa'] == 1)
		{
			$idPf= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pf.php';
		}
		else
		{
			$idPj= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pj.php';
		}
    	?>
		<div class="form-group">
			<h4>Edição de Local</h4>
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=local" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-1 col-md-3">
							<label><br/>Local *</label><br/>
							<input type="text" name="local" class="form-control" maxlength="100" value="<?php echo $local['local'] ?>">
						</div>

						<div class="col-md-1"><label>Público * Estimado</label><br/>
							<input type="text" name="estimativaPublico" class="form-control" value="<?php echo $local['estimativaPublico'] ?>" required>
						</div>

						<div class="col-md-2">
							<label><br/>Zona *</label>
							<select class="form-control" name="idZona" required>
								<option value="0"></option>
								<?php echo geraOpcao("zona", $local['idZona']) ?>
							</select>
						</div>

						<div class="col-md-2">
							<label>Prefeitura Regional * <a href="../pdf/lista_distritos.html" target="_blank"><i class="fa fa-info-circle"></i></a></label>
							<select class="form-control" name="idSubprefeitura" required>
								<option value="0"></option>
								<?php echo geraOpcao("subprefeitura",$local['idSubprefeitura']) ?>
							</select>
						</div>

						<div class="col-md-2">
							<label><br/>Distrito * <a href="../pdf/lista_distritos.html" target="_blank"><i class="fa fa-info-circle"></i></a></label>
							<select class="form-control" name="idDistrito" required>
								<option value="0"></option>
								<?php echo geraOpcao("distrito",$local['idDistrito']) ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-1 col-md-10">
							<input type="hidden" name="editaLocal" value="<?php echo $idLocaisRealizacao ?>">
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>