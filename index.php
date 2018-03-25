<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>SMC / Pro-Mac - Programa Municipal de Apoio a Projetos Culturais</title>
		<link href="visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="visual/css/style.css" rel="stylesheet" media="screen">
		<link href="visual/color/default.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="visual/css/font-awesome.min.css">
		
		<script src="visual/js/modernizr.custom.js"></script>
		<script src="visual/js/jquery-1.9.1.js"></script>
		<script src="visual/js/jquery-ui.js"></script>
	</head>
	<body>
		<div id="bar">
			<p id="p-bar"><img src="visual/images/logo_cultura_h.png" />&nbsp;</p>
		</div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<section id="list_items" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-1 col-md-10">
						<h4>Pro-Mac - Programa Municipal de Apoio a Projetos Culturais</h4>
						<img src="visual/images/logo_promac_colorido.png" align="left" hspace="20" />
						<p align="justify">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

						<p align="justify">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>

						<p align="justify">Links de informações sobre o sistema:</p>

						<ul>
							<li align="left">Manual de aplicação de marca no texto de abertura.</li>
							<li align="left"><a href="manual/index.php">Manual de utilização do sistema.</a></li>
						</ul>

						<hr/>

						<div class="form-group">
							<div class="col-md-offset-1 col-md-3">
								<button class='btn btn-theme btn-md btn-block' type='button' data-toggle='modal' data-target='#proponente' style="border-radius: 30px;">Proponente</button>
							</div>
							<div class="col-md-3">
								<button class='btn btn-theme btn-md btn-block' type='button' data-toggle='modal' data-target='#incentivador' style="border-radius: 30px;">Incentivador</button>
							</div>
							<div class="col-md-3">
								<form method="POST" action="./visual/index.php" class="form-horizontal" role="form">
									<input type="hidden" name="consulta" value="1">
									<button class='btn btn-theme btn-md btn-block' type='submit' style="border-radius: 30px;">Consulta Pública</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- Inicio Modal Proponente -->
				<div class="modal fade" id="proponente" role="dialog" aria-labelledby="proponenteLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Proponente</h4>
							</div>
							<div class="modal-body">
								<form method="POST" action="login_pf.php" class="form-horizontal" role="form">
									<button type="submit" class="btn btn-theme btn-block">Pessoa Física</button>
								</form>
								<form method="POST" action="login_pj.php" class="form-horizontal" role="form">
									<button type="submit" class="btn btn-theme btn-block">Pessoa Jurídica</button>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
							</div>
						</div>
					</div>
				</div>
				<!-- Fim Modal Proponente -->
				<!-- Inicio Modal Incentivador -->
				<div class="modal fade" id="incentivador" role="dialog" aria-labelledby="incentivadorLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Incentivador</h4>
							</div>
							<div class="modal-body">
								<form method="POST" action="login_incentivador_pf.php" class="form-horizontal" role="form">
									<button type="submit" class="btn btn-theme btn-block">Pessoa Física</button>
								</form>
								<form method="POST" action="login_incentivador_pj.php" class="form-horizontal" role="form">
									<button type="submit" class="btn btn-theme btn-block">Pessoa Jurídica</button>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
							</div>
						</div>
					</div>
				</div>
				<!-- Fim Modal Incentivador -->
			</div>
		</section>
		<footer>
			<div class="container">
				<table width="100%">
					<tr>
						<td width="20%"><img src="visual/images/logo_promac_branco.png" align="left"/></td>
						<td align="center"><font color="#ccc">2018 @ Pro-Mac - Programa Municipal de Apoio a Projetos Culturais<br/>Secretaria Municipal de Cultura<br/>Prefeitura de São Paulo</font></td>
						<td width="20%"><img src="visual/images/logo_cultura_q.png" align="right"/></td>
					</tr>
					<tr>
						<td colspan="2"><font color="#ccc"><br/>Supervisão de Tecnologia da Informação - Programação e Desenvolvimento</font></td>
						<td align="right"><font color="#ccc">Versão 0.1</font></td>
					</tr>
				</table>
				<script src="visual/js/bootstrap.min.js"></script>
			</div>
		</footer>
    </body>
</html>