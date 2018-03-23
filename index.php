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
						<p align="justify">Inspirado no Programa de Ação Cultural (ProAC) do Governo de São Paulo, o Pro-Mac permite que o patrocinador tenha dedução de 100% do valor investido, disponibilizando mais recursos para artistas e produtores culturais, que antes recebiam no máximo 70% do valor total do patrocínio. Com o Pro-Mac, áreas como design, cultura digital, séries de TV, espaços culturais independentes, circo, cinema, dança, fotografia, teatro – dentre outras – que não estavam previstas na Lei Mendonça  – agora podem receber patrocínio.</p>

						<p align="justify">Ao estabelecer regras simples e critérios mais objetivos para a obtenção do incentivo, a nova Lei se torna acessível a pequenos produtores e a artistas independentes, que antes dependiam de empresas e produtoras culturais para adequarem seus projetos à burocracia e às exigências da Lei Mendonça. Outro destaque é que o Pro-Mac também prevê que a contrapartida ao patrocínio, que antes era determinada por lei (Ex: o artista deverá produzir e distribuir 1000 CDs ou realizar 10 shows gratuitos) seja formulada pelo proponente do projeto. Isso significa que o autor da proposta é quem vai indicar a melhor forma de levar ao público o seu projeto cultural, o que também será um critério de avaliação.</p>

						<p align="justify">Para acessar o sistema, escolha entre uma das áreas abaixo.</p>

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
							<div class="col-md-1">
								<form method="POST" action="manual/index.php" class="form-horizontal" role="form">
									<button class='btn btn-default' type='submit' style="border-radius: 30px;"><i class="fa fa-question-circle"></i></button>
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
				</table>
				<script src="visual/js/bootstrap.min.js"></script>
			</div>
		</footer>
    </body>
</html>