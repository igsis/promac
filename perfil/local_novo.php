<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
?>
<script language="JavaScript" >
    $("#cep").mask('00000-000', {reverse: true});
</script>
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
			<h4>Cadastro de Local</h4>
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=local" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-6">
							<label>Local *</label>
							<input type="text" name="local" class="form-control" maxlength="100" required>
						</div>

						<div class="col-md-2"><label>Público Estimado *</label><br/>
							<input type="number" name="estimativaPublico" class="form-control" required>
						</div>
                        <div class="col-md-2">
                            <label for="cep">CEP *</label>
                            <input type="text" class="form-control" id="cep" name="cep" data-mask="00000-000" minlength="9" required>
                        </div>
                        <div class="col-md-4" align="left"><br/><font class="alert-info"><i>Clique no número do CEP e pressione a tecla Tab para carregar</i></font> </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="rua">Rua *</label>
                            <input type="text" class="form-control" id="rua" name="logradouro" maxlength="150" required>
                        </div>
                        <div class="col-md-2">
                            <label for="numero">Nº *</label>
                            <input type="number" class="form-control" id="numero" name="numero" required>
                        </div>
                        <div class="col-md-2">
                            <label for="complemento">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento" maxlength="15">
                        </div>
                        <div class="col-md-2">
                            <label for="bairro">Bairro *</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" maxlength="30" required>
                        </div>
                        <div class="col-md-2">
                            <label for="cidade">Cidade *</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" maxlength="50" required>
                        </div>
                        <div class="col-md-1">
                            <label for="estado">UF *</label>
                            <input type="text" class="form-control" id="estado" name="uf" maxlength="2" required>
                        </div>
                    </div>

					<div class="form-group">
						<div class="col-md-offset-1 col-md-10">
							<input type="submit" name="insereLocal" class="btn btn-theme btn-lg btn-block" value="Inserir">
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>
<script src="../include/cep_api.js"></script>