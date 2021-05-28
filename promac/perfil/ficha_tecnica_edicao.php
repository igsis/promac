<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

$idFichaTecnica = $_POST['editaFicha'];
$fichaTecnica = recuperaDados("ficha_tecnica", "idFichaTecnica", $idFichaTecnica);
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
				<form method="POST" action="?perfil=ficha_tecnica" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-4">
							<label>Nome *</label><br/>
							<input type="text" name="nome" class="form-control" maxlength="150" value="<?php echo $fichaTecnica['nome'] ?>" required>
						</div>

						<div class="col-md-2"><label>CPF *</label><br/>
							<input type="text" name="cpf" id="cpf" class="form-control" value="<?php echo $fichaTecnica['cpf'] ?>" required>
						</div>

						<div class="col-md-2">
							<label>Função *</label>
							<input type="text" name="funcao" class="form-control" maxlength="50" value="<?php echo $fichaTecnica['funcao'] ?>" required>
						</div>
					</div>

                    <div class="col-md-offset-2 col-md-8">
                        <div class="form-group">
                            <label>Currículo Resumido do Profissional *</label><br/>
                            <textarea class="form-control" name="curriculo" class="form-control" rows="5" required><?php echo $fichaTecnica['curriculo'] ?></textarea>
                        </div>
                    </div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="editaFicha" value="<?php echo $idFichaTecnica ?>">
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Inserir">
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>