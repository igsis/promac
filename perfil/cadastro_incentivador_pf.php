<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<title>ProMAC - Programa Municipal de Apoio a Projetos Culturais<br/>Secretaria Municipal de Cultura</title>
			<link href="visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
			<link href="visual/css/style.css" rel="stylesheet" media="screen">
			<link href="visual/color/default.css" rel="stylesheet" media="screen">
			<script src="visual/js/modernizr.custom.js"></script>
		</head>
		<body>
			<section id="contact" class="home-section bg-white">
				<div class="container">
					<div class="form-group">
						<h4>Cadastro de Incentivador PF</h4><br>
					</div>
					<div class="row">
						<div class="col-md-offset-1 col-md-10">
						<form class="form-horizontal" role="form" action="redirect_pra_algum_lugar.php" method="post">
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
									<input type="text" class="form-control" name="nome" placeholder="Nome completo">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-6"><strong>CPF: *</strong>
									<input type="text" name="cpf" class="form-control" id="inputName" placeholder="">
								</div>
								<div class=" col-md-6"><strong>RG ou RNE *</strong>
									<input type="text" name="rg" class="form-control" id="inputEmail" placeholder="">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-6"><strong>CEP: *</strong><br/>
									<input type="text" class="form-control" name="cep" placeholder="CEP">
								</div>
								<div class="col-md-6"><strong>Endereço: *</strong><br/>
									<input type="text" class="form-control" name="endereco" placeholder="Endereço">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-6"><strong>Telefone: </strong><br/>
									<input type="text" class="form-control" name="telefone" placeholder="Telefone">
								</div>
								<div class="col-md-6"><strong>Celular: </strong><br/>
									<input type="text" class="form-control" name="celular" placeholder="Celular">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-8"><strong>Email: *</strong><br/>
									<input type="text" class="form-control" name="email" placeholder="xxxx@xxxxx.xxx">
								</div>
							</div>

							<!-- Botão para Gravar -->
							<div class="form-group">
								<div class="col-md-offset-2 col-md-8">
									<input type="hidden" value="<?php echo $busca ?>">
									<input type="hidden" name="cadastraNovoPf">
									<input type="submit" value="Enviar" class="btn btn-theme btn-lg btn-block">
								</div>
							</div>
						</form>
						</div>
					</div>
				</div>
			</section>