<html>
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
		<section id="services" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<div class="form-group">
							<h3>Cadastro de Pessoa Jurídica</h3>
							<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
							<p><strong>Vamos verificar se você já possui cadastro no sistema.</strong></p>
							<br/>
							<p><strong>Insira o CNPJ</p>
						</div>
					</div>
					<div class="form-group">
						<form method="POST" action="login_resultado_pf.php" class="form-horizontal" role="form">
							<div class="col-md-offset-4 col-md-2">
								<input type="text" name="busca" class="form-control" placeholder="CNPJ" id="cnpj" >
							</div>
							<div class="col-md-2">
								<input type="submit" name="pesquisar" class="btn btn-theme btn-md btn-block" value="Pesquisar">
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
		<?php include "visual/rodape.php" ?>