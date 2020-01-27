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
        <script src="visual/js/sweetalert.min.js"></script>
        <link href="visual/css/sweetalert.css" rel="stylesheet" type="text/css"/>
	</head>
	<body>
    <script>
        function alerta()
        {
            swal({   title: "Atenção!",
                text: "EDITAL PROMAC 2020 está com inscrições abertas para projetos culturais! Confira no botão NORMATIVOS!",
                timer: 10000,
                confirmButtonColor:	"#000000",
                showConfirmButton: true });}
        window.onload = alerta();
    </script>
		<div id="bar">
			<p id="p-bar"><img src="visual/images/logo_cultura_h.png" />&nbsp;</p>
		</div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<section id="list_items" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-9" align="left">
                        <h4>Pro-Mac - Programa Municipal de Apoio a Projetos Culturais</h4>
                    </div>
                    <div class="col-md-3">
                        <img src="visual/images/pin_promac.png" align="right"  />
                    </div>
                </div>
                <div class="row">
                    <br/>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <form>
                            <button class='btn btn-theme btn-md btn-block' type='button' data-toggle='modal' data-target='#regulamento' >Normativos</button>
                        </form>
                        <form method="POST" action="analise_projeto.php" class="form-horizontal" role="form">
                            <button class='btn btn-theme btn-md btn-block' type='submit'>Confira a análise <br/>do seu projeto aqui</button>
                        </form>
                        <form method="POST" action="visual/index.php" class="form-horizontal" role="form">
                            <input type="hidden" name="consulta" value="1">
                            <button class='btn btn-theme btn-md btn-block' type='submit'>CONSULTA PÚBLICA: <br/>PROJETOS APROVADOS E OUTROS</button>
                        </form>
                        <div class="well">
                            <p>Faça seu login ou inscreva-se aqui:</p>
                            <button class='btn btn-theme btn-md btn-block' type='button' data-toggle='modal' data-target='#proponente'>Proponente</button>
                            <button class='btn btn-theme btn-md btn-block' type='button' data-toggle='modal' data-target='#incentivador' >Incentivador</button>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <p align="justify">O Programa de Municipal de Apoio a Projetos Culturais – Pro-Mac, instituído pela Lei nº 15.948/2013 e regulamentado pelo Decreto nº 59.119/2019, tem como objetivo incentivar projetos culturais e artísticos por meio da renúncia fiscal. Os incentivadores – pessoa física ou jurídica - poderão contribuir por meio da renúncia de até 20% do Imposto sobre Serviços de Qualquer Natureza - ISS e do Imposto Predial e Territorial Urbano - IPTU.</p>
                        <p align="justify">Você já leu o novo Decreto que regulamenta o PROMAC?<br/><a href="pdf/Novo_Decreto_ProMac.pdf" target="_blank">Leia aqui o normativo na íntegra para ficar por dentro das novidades! O novo Edital para inscrição de projetos será publicado com base nestas novas regras, saiba mais.</a></p>
                        <p align="justify"><a href="pdf/MAPA E LISTA DE DISTRITOS SITE.pdf" target="_blank">Veja aqui o mapa com os distritos que compõem cada faixa de renúncia fiscal de acordo com o novo Edital do PROMAC</a></p>

						<p align="justify">
                            <strong>Cadastro de proponente:</strong> aberta o ano todo.<br/>
                            <strong>Cadastro de incentivador:</strong> aberta o ano todo.<br/>
						    <strong>Inscrição de projeto:</strong> abertas de 9h de 27/01/2020 às 18h de 27/04/2020. Confira o novo Edital no botão Normativos ao lado.
                        </p>

						<p align="justify">O proponente deverá inscrever-se no botão ao lado e após habilitação poderá inscrever o projeto.</p>

						<p align="justify">Para saber como participar, clique em <button class='btn btn-theme btn-sm' type='button' data-toggle='modal' data-target='#regulamento' style="border-radius: 10px;">Normativos</button> e se inscreva no link abaixo.</p>

						<p>&nbsp;</p>
                    </div>

                    <div class="col-md-12">
                        <div class="well">
                            <br/>
                            <h6><span style="color: red; ">ATENÇÃO! INFORMAÇÃO SOBRE AS CARTAS DE INCENTIVO EM FILA DE ESPERA</span></h6>
                            <p><span style="color: red; ">As Cartas de Incentivo entregues na Secretaria Municipal da Cultura e protocoladas em fila de espera após o esgotamento dos recursos do PROMAC expirarão no final deste exercício fiscal e não servirão para dar alguma prioridade para a captação do incentivo fiscal de projetos em 2020. Como a fila de espera tinha o objetivo de organizar uma possível chegada de recursos extras ao PROMAC ainda em 2019, que não ocorreu e não ocorrerá até dia 31 de dezembro de 2019, ela se torna inócua ao final deste exercício fiscal, já que não existe mais a possibilidade de que essa vinda de recursos extras aconteça. Os documentos protocolados, portanto, se tornam inválidos, uma vez que preveem datas de aporte passadas e não tem mais objetivo.</span></p>
                            <p><span style="color: red; ">Acompanhem aqui nesta página, nas redes oficiais na Secretaria Municipal da Cultura e na mídia em geral mais noticias sobre o PROMAC em 2020.</span></p>
                            <br/>
                        </div>
                    </div>

						
                    <!-- Inicio Modal Regulamento -->
                    <div class="modal fade" id="regulamento" role="dialog" aria-labelledby="regulamentoLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Normativos</h4>
                                </div>
                                <div class="modal-body" align="left">
                                    <div class="well">
                                        <h6>Lei / Decreto / Portarias</h6>
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="pdf/Lei_ProMac.pdf" target="_blank">Lei</a></li>
                                            <li class="list-group-item"><a href="pdf/Novo_Decreto_ProMac.pdf" target="_blank">Novo Decreto</a></li>
                                            <li class="list-group-item"><a href="pdf/Decreto_ProMac.pdf" target="_blank">Decreto Revogado</a></li>
                                            <li class="list-group-item"><a href="pdf/AlteracaoDecreto_ProMac.pdf" target="_blank">Alteração de Decreto Revogada</a></li>
                                            <li class="list-group-item"><a href="pdf/Portaria_publicado.pdf">Portaria de Procedimentos Revogada</a></li>
                                            <li class="list-group-item"><a href="pdf/Portaria_SF_procedimentos_contabeis_incentivador.pdf">Portaria de Procedimentos Contábeis – Incentivador</a></li>
                                            <li class="list-group-item"><a href="pdf/Portaria_SMC_prestacao_contas.pdf">Portarias de prestação de contas</a></li>
                                        </ul>
                                    </div>
                                    <div class="well">
                                        <h6>Documentos para Projetos Aprovados</h6>
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="pdf/TERMO_DE_RESPONSABILIDADE_FINAL.docx" target="_blank">Termo de Responsabilidade de Realização de Projeto Cultural</a></li>
                                            <li class="list-group-item"><a href="pdf/CARTA_DE_INTENCAO_DE_INCENTIVO.docx" target="_blank">Carta de Intenção de Incentivo</a></li>
                                            <li class="list-group-item"><a href="pdf/Certificado_Incentivo.docx" target="_blank">Certificado de Incentivo</a></li>
                                        </ul>
                                    </div>
                                    <div class="well">
                                        <h6>Manuais</h6>
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="pdf/manual_utilizacao.pdf" target="_blank">Manual de utilização do sistema</a></li>
                                            <li class="list-group-item"><a href="pdf/identidade_visual.zip">Manual de uso da marca</a></li>
                                            <li class="list-group-item"><a href="pdf/Portaria_SMC_prestacao_contas.pdf">Manual de prestação de contas</a></li>
                                            <li class="list-group-item"><a href="pdf/manual_incentivador.pdf">Manual do Incentivador</a></li>
                                        </ul>
                                    </div>

                                    <div class="well">
                                        <h6>Edital</h6>
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="pdf/Edital_PROMAC_2020.pdf" target="_blank">EDITAL PROMAC 2020</a></li>
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
                                    <div class="alert-danger">
                                        <br/>
                                        <h6><span style="color: darkred; ">ATENÇÃO!</span></h6>
                                        <p>A utilização de mais de uma aba ou janela do mesmo navegador para inserção ou edição dos dados pode causar perda de informações.</p>
                                        <br/>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <form method="POST" action="login_pf.php" class="form-horizontal" role="form">
                                                <button type="submit" class="btn btn-theme btn-md btn-block" style="border-radius: 10px;">Pessoa Física</button>
                                            </form>
                                        </div>
                                        <div class="col-md-offset-2 col-md-5">
                                            <form method="POST" action="login_pj.php" class="form-horizontal" role="form">
                                                <button type="submit" class="btn btn-theme btn-md btn-block" style="border-radius: 10px;">Pessoa Jurídica</button>
                                            </form>
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
                    <!-- Inicio Modal Incentivador -->
                    <div class="modal fade" id="incentivador" role="dialog" aria-labelledby="incentivadorLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Incentivador</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="alert-danger">
                                        <br/>
                                        <h6><span style="color: darkred; ">ATENÇÃO!</span></h6>
                                        <p>A utilização de mais de uma aba ou janela do mesmo navegador para inserção ou edição dos dados pode causar perda de informações.</p>
                                        <br/>
                                    </div>
                                    <br/>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <form method="POST" action="login_incentivador_pf.php" class="form-horizontal" role="form">
                                                <button type="submit" class="btn btn-theme btn-md btn-block" style="border-radius: 10px;">Pessoa Física</button>
                                            </form>
                                        </div>
                                        <div class="col-md-offset-2 col-md-5">
                                            <form method="POST" action="login_incentivador_pj.php" class="form-horizontal" role="form">
                                                <button type="submit" class="btn btn-theme btn-md btn-block" style="border-radius: 10px;">Pessoa Jurídica</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fim Modal Incentivador -->
				</div>
			</div>
		</section>
		<footer>
			<div class="container">
				<table width="100%">
					<tr>
						<td width="20%"><img src="visual/images/pin_promac_pq.png" align="left"/></td>
						<td align="center"><font color="#ccc">2018 @ Pro-Mac - Programa Municipal de Apoio a Projetos Culturais<br/>Secretaria Municipal de Cultura<br/>Prefeitura de São Paulo</font></td>
						<td align="right"><font color="#ccc"><b>Contato:</b><br/><i class="fa fa-phone-square"></i> (11) 3397-0002 das 13h às 17h<br/><i class="fa fa-envelope"></i> Dúvidas: promac@prefeitura.sp.gov.br</font></td>
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