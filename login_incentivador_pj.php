<?php

include "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";

session_start();

if(isset($_POST['login']))
{
	$login = $_POST['login'];
	$senha = $_POST['senha'];
	autenticaloginincentivadorpj($login,$senha);
}
?>

<?php include "visual/cabecalho_index.php" ?>
<section id="contact" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="col-md-offset-2 col-md-8">
				<div class="text-hide">
					<h4>Pro-Mac - Programa Municipal de Apoio a Projetos Culturais</h4>
					<h5><?php if(isset($_POST['login'])){ echo autenticaloginincentivadorpj($login, $senha); } ?></h5>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="login_incentivador_pj.php" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<input type="text" id="cnpj" name="login" class="form-control" placeholder="CNPJ">
						</div>
						<div class=" col-md-6">
							<input type="password" name="senha" class="form-control" placeholder="Senha">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<button type="submit" class="btn btn-theme btn-lg btn-block">Entrar</button>
						</div>
					</div>
				</form>

				<br />

				<div class="form-group">
					<div class="col-md-offset-2 col-md-6">
						<p>Não possui cadastro? <a href="verifica_incentivador_pj.php">Clique aqui.</a></p>
						<br />
					</div>
					<div class="col-md-6">
						<p>Esqueceu a senha? <a href="recuperar_senha.php">Clique aqui.</a></p>
						<br />
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php include "visual/rodape_index.php" ?>