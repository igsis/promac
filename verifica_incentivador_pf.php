<?php include "visual/cabecalho_index.php" ?>
<section id="services" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<h3>Cadastro de Pessoa Física</h3>
					<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
					<p><strong>Vamos verificar se você já possui cadastro no sistema.</strong></p>
					<br/>
					<p><strong>Insira o CPF</strong></p>
				</div>
			</div>
			<div class="form-group">
				<form method="POST" action="login_resultado_incentivador_pf.php" class="form-horizontal" role="form">
					<div class="col-md-offset-4 col-md-2">
						<input type="text" name="busca" class="form-control" placeholder="CPF" id="cpf">
					</div>
					<div class="col-md-2">
						<input type="submit" name="pesquisar" class="btn btn-theme btn-md btn-block" value="Pesquisar">
					</div>
				</form>
			</div>

			<div class="form-group">
                <div class="col-md-offset-2 col-md-8"><br></div>
            </div>

			<div class="form-group">
				<div class="form-group" style="padding-bottom: 60px;">
					<div class="col-md-offset-4 col-md-4">
						<form method="POST" action="login_incentivador_pf.php" class="form-horizontal" role="form">
						<button class='btn btn-theme btn-md' type='submit' style="border-radius: 30px;">Voltar</button>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include "visual/rodape_index.php" ?>