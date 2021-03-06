<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

$distritos = $con->query("SELECT * FROM distrito")->fetch_all(MYSQLI_ASSOC);

$idLocaisRealizacao = $_POST['editarLocal'];
$local = recuperaDados("locais_realizacao", "idLocaisRealizacao", $idLocaisRealizacao);
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
			<h4>Edição de Local</h4>
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=local" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-6">
							<label>Local *</label><br/>
							<input type="text" name="local" class="form-control" maxlength="100" value="<?php echo $local['local'] ?>">
						</div>
						<div class="col-md-2"><label>Público * Estimado</label><br/>
							<input type="number" name="estimativaPublico" class="form-control" value="<?php echo $local['estimativaPublico'] ?>" required>
						</div>
                        <div class="col-md-2">
                            <label for="cep">CEP *</label>
                            <input type="text" class="form-control" id="cep" name="cep" data-mask="00000-000" minlength="9" required value="<?= $local['cep'] ?>">
                        </div>
                        <div class="col-md-4" align="left"><br/><font class="alert-info"><i>Clique no número do CEP e pressione a tecla Tab para carregar</i></font> </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="rua">Rua *</label>
                            <input type="text" class="form-control" id="rua" name="logradouro" maxlength="150" required value="<?= $local['logradouro'] ?>">
                        </div>
                        <div class="col-md-2">
                            <label for="numero">Nº *</label>
                            <input type="number" class="form-control" id="numero" name="numero" required value="<?= $local['numero'] ?>">
                        </div>
                        <div class="col-md-2">
                            <label for="complemento">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento" maxlength="15" value="<?= $local['complemento'] ?>">
                        </div>
                        <div class="col-md-2">
                            <label for="bairro">Bairro *</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" maxlength="30" required value="<?= $local['bairro'] ?>">
                        </div>
                        <div class="col-md-2">
                            <label for="cidade">Cidade *</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" maxlength="50" required value="<?= $local['cidade'] ?>">
                        </div>
                        <div class="col-md-1">
                            <label for="estado">UF *</label>
                            <input type="text" class="form-control" id="estado" name="uf" maxlength="2" required value="<?= $local['estado'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-offset-1 col-md-5">
                            <label for="distrito">Distrito *</label>
                            <select class="form-control" name="distrito" id="distrito" required>
                                <option value="">Selecione uma opção...</option>
                                <?php foreach ($distritos as $distrito): ?>
                                    <option value="<?=$distrito['idDistrito']?>"
                                            data-faixa="<?=$distrito['faixa']?>"
                                            <?=$local['idDistrito'] == $distrito['idDistrito'] ? "selected" : ""?>>
                                        <?=$distrito['distrito']?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="distrito">Faixa *</label>
                            <select class="form-control" name="faixa" id="faixa" readonly>
                                <option value="">Selecione uma opção...</option>
                                <option value="1">Faixa 1</option>
                                <option value="2">Faixa 2</option>
                                <option value="3">Faixa 3</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <label for="obsLocal">Explicação sobre os locais de realização do projeto: </label>
                            <textarea name="obsLocal" id="obsLocal" cols="20" rows="5" class="form-control"><?= $local['observacaoLocal'] ?></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-offset-1 col-md-10">
                                <input type="hidden" name="editaLocal" value="<?= $local['idLocaisRealizacao'] ?>">
                                <input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
                            </div>
                        </div>
                    </div>
				</form>

			</div>
		</div>
	</div>
</section>
<script src="../include/cep_api.js"></script>
<script>
    function selecionaFaixa() {
        let faixa = $('#distrito option:selected').attr('data-faixa');
        $('#faixa option').removeAttr('selected');
        $(`#faixa`).val(faixa);
    }

    $('#faixa').on('mousedown', function(e) {
        e.preventDefault();
    });

    $('#distrito').change(selecionaFaixa);

    $(document).ready(selecionaFaixa);
</script>