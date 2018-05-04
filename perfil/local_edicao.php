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
			<h4>Cadastro de Projeto</h4>
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=local" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-4">
							<label>Local *</label><br/>
							<input type="text" name="local" class="form-control" maxlength="100" value="<?php echo $local['local'] ?>">
						</div> 

						<div class="col-md-2"><label>Público Estimado *</label><br/>
							<input type="text" name="estimativaPublico" class="form-control" value="<?php echo $local['estimativaPublico'] ?>" required>
						</div>

						<div class="col-md-2">
							<label>Zona *</label>
							<select class="form-control" name="idZona" required>
								<option value="1"></option>
								<?php echo geraOpcao("zona", $local['idZona']) ?>
							</select>
						</div>

						<div class="col-md-2">
							<label>Subprefeitura *</label>
							<select class="form-control" name="idSubprefeitura" required>
								<option value="0"></option>
								<?php echo geraOpcao("subprefeitura","") ?>
							</select>
						</div>

						<div class="col-md-2">
							<label>Distrito *</label>
							<select class="form-control" name="idDistrito" required>
								<option value="0"></option>
								<?php echo geraOpcao("distrito","") ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="editaLocal" value="<?php echo $idLocaisRealizacao ?>">
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir">
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>