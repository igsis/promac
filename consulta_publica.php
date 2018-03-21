<?php
	session_start();
	
	//carrega as funcoes gerais
		require "funcoes/funcoesConecta.php";
		require "funcoes/funcoesGerais.php";

	//Imprime erros com o banco
		@ini_set('display_errors', '1');
		error_reporting(E_ALL);
?>
<html>
	<head>
		<title>SMC / Pro-Mac - Programa Municipal de Apoio a Projetos Culturais</title>
		<meta charset="utf-8" />
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- css -->
		<link href="visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="visual/css/style.css" rel="stylesheet" media="screen">
		<link href="visual/color/default.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="visual/css/font-awesome.min.css">
		<script src="visual/js/modernizr.custom.js"></script>
		<script src="visual/js/jquery-1.9.1.js"></script>
		<script src="visual/js/jquery.maskedinput.js" type="text/javascript"></script>
		<script src="visual/js/jquery.maskMoney.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#cpf").mask("999.999.999-99");
				$("#cnpj").mask("99.999.999/9999-99");
			});
		</script>
    </head>
	<body>
		<div id="bar">
			<p id="p-bar"><img src="visual/images/logo_cultura_h.png" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Pro-Mac</b>
			</p>
		</div>

		<div class="container" style="margin-top: 7%; margin-bottom: 13.5%;">
			<div class="row">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<strong>
							<a href="index.php">Voltar a Tela de Login</a>
						</strong>
					</div>
				</div>
			</div>
			<div class="form-group">
				<h4>Consulta Pública</h4>
			</div>

			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<div class="well">
						Nesta área, você pode consultar os projetos já aprovados!
					</div>
				</div>
			</div>
			<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="consulta_publica_resultado.php" class="form-horizontal" role="form">

					<hr/>

					<label>PESSOA FÍSICA</label>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-5"><label>Nome</label>
							<input type="text" name="nome" class="form-control" placeholder="">
						</div>
						<div class="col-md-3"><label>CPF</label>
							<input type="text" name="cpf" id="cpf" class="form-control" placeholder="">
						</div>
					</div>

					<hr/>

					<label>PESSOA JURÍDICA</label>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-5"><label>Razão Social</label>
							<input type="text" name="razaoSocial" class="form-control" placeholder="">
						</div>
						<div class="col-md-3"><label>CNPJ</label>
							<input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="">
						</div>
					</div>

					<hr/>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Nome do projeto</label>
							<input type="text" name="nomeProjeto" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Protocolo</label>
							<input type="text" name="idProjeto" class="form-control" placeholder="">
						</div>
					</div>


					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Área atuação</label>
							<select class="form-control" name="idAreaAtuacao" >
								<option value="0"></option>
								<?php echo geraOpcao("area_atuacao","") ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Valor Aprovado</label>
							<input type="text" name="valorAprovado" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="pesquisar" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
						</div>
					</div>
				</form>
			</div>
		</div>
		</div>
	</body>
</html>
<?php
	//carrega o rodapé
		include "visual/rodape_index.php";
?>