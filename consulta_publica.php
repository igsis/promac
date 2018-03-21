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
					<select class="form-control" id="metodoPesquisa">
						<option>Escolha o modo de Pesquisa</option>
						<option data-region="protocolo">Nº de Protocolo</option>
						<option data-region="nomeProjeto">Nome do Projeto</option>
						<option data-region="cp">CPF</option>
						<option data-region="razaoSocial">Razão Social</option>
						<option data-region="cnp">CNPJ</option>
						<option data-region="areaAtuacao">Área de Atuação</option>
						<option data-region="valorAprovado">Valor Aprovado</option>
					</select>
					<hr/>

					<div class="content">
						<form method="POST" action="?perfil=consulta_publica_resultado" class="form-horizontal" role="form">
							<div id="protocolo" class="pesquisa">
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<label>Nº de Protocolo</label>
										<input class="form-control" type="text" name="protocolo" placeholder="Nº de Protocolo" style="text-align: center;">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<input type="submit" name="consultaPublica" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
									</div>
								</div>
							</div>
						</form>

						<form method="POST" action="?perfil=consulta_publica_resultado" class="form-horizontal" role="form">
							<div id="nomeProjeto" class="pesquisa">
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<label>Nome do Projeto</label>
										<input class="form-control" type="text" name="nomeProjeto" placeholder="Nome do Projeto" style="text-align: center;">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<input type="submit" name="consultaPublica" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
									</div>
								</div>
							</div>
						</form>

						<form method="POST" action="?perfil=consulta_publica_resultado" class="form-horizontal" role="form">
							<div id="cp" class="pesquisa">
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<label>CPF</label>
										<input type="text" id="cpf" name="cpf" class="form-control" placeholder="CPF" style="text-align: center;">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<input type="submit" name="consultaPublica" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
									</div>
								</div>
							</div>
						</form>

						<form method="POST" action="?perfil=consulta_publica_resultado" class="form-horizontal" role="form">
							<div id="razaoSocial" class="pesquisa">
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<label>Razão Social</label>
										<input class="form-control" type="text" name="razaoSocial" placeholder="Razão Social" style="text-align: center;">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<input type="submit" name="consultaPublica" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
									</div>
								</div>
							</div>
						</form>

						<form method="POST" action="?perfil=consulta_publica_resultado" class="form-horizontal" role="form">
							<div id="cnp" class="pesquisa">
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<label>CNPJ</label>
										<input type="text" id="cnpj" name="cnpj" class="form-control" placeholder="CNPJ" style="text-align: center;">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<input type="submit" name="consultaPublica" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
									</div>
								</div>
							</div>
						</form>

						<form method="POST" action="?perfil=consulta_publica_resultado" class="form-horizontal" role="form">
							<div id="areaAtuacao" class="pesquisa">
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<label>Área de Atuação</label>
										<input class="form-control" type="text" name="areaAtuacao" placeholder="Área de Atuação" style="text-align: center;">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<input type="submit" name="consultaPublica" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
									</div>
								</div>
							</div>
						</form>

						<form method="POST" action="?perfil=consulta_publica_resultado" class="form-horizontal" role="form">
							<div id="valorAprovado" class="pesquisa">
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<label>Valor Aprovado</label>
										<input class="form-control" type="text" name="valorAprovado" placeholder="Valor Aprovado" style="text-align: center;">
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-2 col-md-8">
										<input type="submit" name="consultaPublica" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
									</div>
								</div>
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
	//carrega o rodapé
		include "visual/rodape_index.php";
?>