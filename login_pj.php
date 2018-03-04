<?php

include "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";

session_start();

if(isset($_POST['login']))
{
	$login = $_POST['login'];
	$senha = $_POST['senha'];
	autenticaloginpj($login,$senha);
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ProMAC - Programa Municipal de Apoio a Projetos Culturais<br/>Secretaria Municipal de Cultura</title>
		<link href="visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="visual/css/style.css" rel="stylesheet" media="screen">
		<link href="visual/color/default.css" rel="stylesheet" media="screen">
		<script src="visual/js/modernizr.custom.js"></script>
		<script src="visual/js/jquery-1.9.1.js"></script>
		<script src="visual/js/jquery.maskedinput.js" type="text/javascript"></script>
		<script src="visual/js/jquery.maskMoney.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function(){	$("#cnpj").mask("99.999.999/9999-99");});
		</script>
	</head>
	<body>
		<div id="bar">
			<p id="p-bar"><img src="visual/images/logo_cultura_h.png" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ProMAC</p>
		</div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<section id="contact" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">
						<div class="text-hide">
							<h4>ProMAC - Programa Municipal de Apoio a Projetos Culturais</h4>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<form method="POST" action="login_pj.php" class="form-horizontal" role="form">
							<div class="form-group">
								<div class="col-md-offset-2 col-md-6">
									<input type="text" id="cnpj" name="login" class="form-control" placeholder="Usuário">
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
								<p>Não possui cadastro? <a href="verifica_pj.php">Clique aqui.</a></p>
								<br />
							</div>
							<div class="col-md-6">
								<p>Esqueceu a senha? <a href="recuperar_senha_pj.php">Clique aqui.</a></p>
								<br />
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php include "visual/rodape.php" ?>