<?php

include "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";

session_start();

$con = bancoMysqli();
$tipoPessoa = '6';
?>


<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>SMC / Pro-Mac - Programa Municipal de Apoio a Projetos Culturais</title>
		<link href="visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="visual/css/style.css" rel="stylesheet" media="screen">
		<link href="visual/color/default.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="visual/css/font-awesome.min.css">
		<link rel="icon" type="image/png" sizes="16x16" href="visual/images/favicon.png">
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
						<p align="justify">O Programa de Municipal de Apoio a Projetos Culturais – Pro-Mac, instituído pela Lei nº 15.948/2013 e regulamentado pelo Decreto nº 58.041/2017, tem como objetivo incentivar projetos culturais e artísticos por meio da renúncia fiscal. Os incentivadores – pessoa física ou jurídica - poderão contribuir por meio da renúncia de até 20% do Imposto sobre Serviços de Qualquer Natureza - ISS e do Imposto Predial e Territorial Urbano - IPTU.</p>

						<p align="justify"><strong>Inscrição de proponente: </strong>aberta o ano todo.<br/>
						<strong>Inscrição de projeto: </strong>de 23/04/2018 à 31/10/2018.</p>	

						<p align="justify">O proponente deverá inscrever-se no link abaixo e após habilitação poderá inscrever o projeto.</p>

						<p align="justify">Para saber como participar, clique em <button class='btn btn-theme btn-md' type='button' data-toggle='modal' data-target='#regulamento' style="border-radius: 30px;">Regulamento</button> e se inscreva no link abaixo.</p>

						<div class="well" style="padding-top: 60px;">
								<div class="form-group" style="padding-bottom: 60px;">
									<div class="col-md-offset-4 col-md-4">
										<button class='btn btn-theme btn-md' type='button' data-toggle='modal' data-target='#analise' style="border-radius: 30px;">Confira a análise do seu projeto aqui</button>	
									</div>
								</div>
						</div>

						<p>&nbsp;</p>

						<div class="well">
							<h6>Faça seu login ou inscreva-se aqui:</h6>
							<div class="form-group" style="padding-bottom: 50px;">
								<div class="col-md-offset-3 col-md-3">
									<button class='btn btn-theme btn-md btn-block' type='button' data-toggle='modal' data-target='#proponente' style="border-radius: 30px;">Proponente</button>
								</div>
								<div class="col-md-3">
									<button class='btn btn-theme btn-md btn-block' type='button' data-toggle='modal' data-target='#incentivador' style="border-radius: 30px;">Incentivador</button>
								</div>
							</div>
						</div>

						<div class="form-group"></div>
							<div class="well" style="padding-top: 60px;">
								<div class="form-group" style="padding-bottom: 60px;">
									<div class="col-md-offset-4 col-md-4">
										<form method="POST" action="visual/index.php" class="form-horizontal" role="form">
											<input type="hidden" name="consulta" value="1">
											<button class='btn btn-theme btn-md btn-block' type='submit' style="border-radius: 30px;">Consulta Pública</button>
										</form>
									</div>
								</div>
							</div>
						</div>

						
						<!-- Inicio Modal Regulamento -->
						<div class="modal fade" id="regulamento" role="dialog" aria-labelledby="regulamentoLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title">Regulamento</h4>
									</div>
									<div class="modal-body" align="left">
										<div class="well">
                                            <h6>Lei / Decreto / Portarias</h6>
                                            <ul class="list-group">
												<li class="list-group-item"><a href="pdf/Lei_ProMac.pdf" target="_blank">Lei</a></li>
												<li class="list-group-item"><a href="pdf/Decreto_ProMac.pdf" target="_blank">Decreto</a></li>
												<li class="list-group-item"><a href="pdf/AlteracaoDecreto_ProMac.pdf" target="_blank">Alteração de Decreto</a></li>
												<li class="list-group-item"><a href="pdf/Portaria_publicado.pdf">Portaria de Procedimentos</a></li>
												<li class="list-group-item"><a href="pdf/Portaria_SF_procedimentos_contabeis_incentivador.pdf">Portaria de Procedimentos Contábeis – Incentivador</a></li>
												<li class="list-group-item"><a href="pdf/Portaria_SMC_prestacao_contas.pdf">Portarias de prestação de contas</a></li>
											</ul>
                                        </div>
                                        <div class="well">
                                            <h6>Documentos para Projetos Aprovados</h6>
                                            <ul class="list-group">
                                                <li class="list-group-item"><a href="pdf/1. TERMO DE RESPONSABILIDADE DE REALIZAÇÃO DE PROJETO CULTURAL FINAL.docx" target="_blank">Termo de Responsabilidade de Realização de Projeto Cultural</a></li>
                                                <li class="list-group-item"><a href="pdf/CARTA DE INTENCAO DE INCENTIVO_OLD.docx" target="_blank">Carta de Intenção de Incentivo</a></li>
                                                <li class="list-group-item"><a href="pdf/Certificado_Incentivo.docx" target="_blank">Certificado de Incentivo</a></li>
                                            </ul>
                                        </div>
                                        <div class="well">
											<h6>Manuais</h6>
											<ul class="list-group">
												<li class="list-group-item"><a href="pdf/manual_utilizacao.pdf" target="_blank">Manual de utilização do sistema</a></li>
												<li class="list-group-item"><a href="pdf/identidade_visual.zip">Manual de uso da marca</a></li>
												<li class="list-group-item"><a href="#">Manual de prestação de contas</a></li>
												<li class="list-group-item"><a href="pdf/manual_incentivador.pdf">Manual do Incentivador</a></li>
											</ul>
										</div>

										<div class="well">
											<h6>Edital</h6>
											<ul class="list-group">
												<li class="list-group-item"><a href="pdf/edital_promac.pdf" target="_blank">Edital de Abertura</a></li>
											</ul>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
									</div>
								</div>
							</div>
						</div>
						<!-- Fim Modal Regulamento -->
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
											<button type="submit" class="btn btn-theme btn-md btn-block" style="border-radius: 30px;">Pessoa Física</button>
										</form>
										<form method="POST" action="login_pj.php" class="form-horizontal" role="form">
											<button type="submit" class="btn btn-theme btn-md btn-block" style="border-radius: 30px;">Pessoa Jurídica</button>
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
											<button type="submit" class="btn btn-theme btn-md btn-block" style="border-radius: 30px;">Pessoa Física</button>
										</form>
										<form method="POST" action="login_incentivador_pj.php" class="form-horizontal" role="form">
											<button type="submit" class="btn btn-theme btn-md btn-block" style="border-radius: 30px;">Pessoa Jurídica</button>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
									</div>
								</div>
							</div>
						</div>
						<!-- Fim Modal Incentivador -->
						<!-- Inicio Modal Aprovados -->
						<div class="modal fade" id="analise" role="dialog" aria-labelledby="analiseLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title">Análise de Projetos</h4>
									</div>
									<div class="col-md-offset-1 col-md-10">
										<!-- Exibir arquivos -->
										<div class="form-group">
											<div class="col-md-12">
												<div class="table-responsive list_info">
													<?php listaArquivosAnalise($tipoPessoa,"index"); ?>
												</div>
											</div>
										</div>
									</div>	
									<div class="modal-footer">
										<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
									</div>
								</div>
							</div>
						</div>
						<!-- Fim Modal Proponente -->
					</div>
				</div>
			</div>
		</section>
		<footer>
			<div class="container">
				<table width="100%">
					<tr>
						<td width="20%"><img src="visual/images/logo_promac_branco.png" align="left"/></td>
						<td align="center"><font color="#ccc">2018 @ Pro-Mac - Programa Municipal de Apoio a Projetos Culturais<br/>Secretaria Municipal de Cultura<br/>Prefeitura de São Paulo</font></td>
						<td align="right"><font color="#ccc"><b>Contato:</b><br/><i class="fa fa-phone-square"></i> (11) 3397-0063<br/><i class="fa fa-phone-square"></i> (11) 3397-0228<br/><i class="fa fa-envelope"></i> promac@prefeitura.sp.gov.br</font></td>
					</tr>
				</table>
			</div>
			<div class="container">
				<table width="100%">
					<tr>
						<td><font color="#ccc" size="1"><br/><i>Supervisão de Tecnologia da Informação - Programação e Desenvolvimento</i></font></td>
						<td align="right"><font color="#ccc" size="1"><i>Versão 0.1</i></font></td>
					</tr>
				</table>
			</div>
			<script src="visual/js/bootstrap.min.js"></script>
		</footer>
    </body>
</html>