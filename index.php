<?php
include "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";

session_start();

$con = bancoMysqli();
$tipoPessoa = '6';
?>
<html lang="pt-br">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>SMC / Pro-Mac - Programa Municipal de Apoio a Projetos Culturais</title>
		<link href="visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="visual/css/style.css" rel="stylesheet" media="screen">
		<link href="visual/color/default.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="visual/css/font-awesome.min.css">
		<link rel="icon" type="image/png" sizes="16x16" href="visual/images/pin_promac_negativo.png">
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
                text: "EDITAL PROMAC 2021 está com inscrições abertas para projetos culturais! Confira no botão NORMATIVOS!",
                timer: 10000,
                confirmButtonColor:	"#000000",
                showConfirmButton: true });}
        // window.onload = alerta();
    </script>
		<div id="bar">
			<p id="p-bar"><img src="visual/images/logo_cultura_h.png" alt="Prefeitura de São Paulo Cultura" />&nbsp;</p>
		</div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<section id="list_items" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-9" style="text-align: left">
                        <h4>Pro-Mac - Programa Municipal de Apoio a Projetos Culturais</h4>
                    </div>
                    <div class="col-md-3" style="text-align: right">
                        <img src="visual/images/pin_promac_negativo.png" alt="Logo Promac" />
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
                            <button class='btn btn-theme btn-md btn-block' type='button' data-toggle='modal' data-target='#incentivador'>Incentivador</button>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <p style="text-align: justify">O Programa de Municipal de Apoio a Projetos Culturais – Pro-Mac, instituído pela Lei nº 15.948/2013 e regulamentado pelo Decreto nº 59.119/2019, tem como objetivo incentivar projetos culturais e artísticos por meio da renúncia fiscal. Os incentivadores – pessoa física ou jurídica - poderão contribuir por meio da renúncia de até 20% do Imposto sobre Serviços de Qualquer Natureza - ISS e do Imposto Predial e Territorial Urbano - IPTU.</p>
                        <p style="text-align: justify">Você já leu o novo Decreto que regulamenta o PROMAC?<br/><a href="pdf/Novo_Decreto_ProMac.pdf" target="_blank">Leia aqui o normativo na íntegra para ficar por dentro das novidades! O novo Edital para inscrição de projetos será publicado com base nestas novas regras, saiba mais.</a></p>
                        <p style="text-align: justify"><a href="pdf/MAPA E LISTA DE DISTRITOS SITE.pdf" target="_blank">Veja aqui o mapa com os distritos que compõem cada faixa de renúncia fiscal de acordo com o novo Edital do PROMAC</a></p>

						<p style="text-align: justify">
                            <strong>Cadastro de proponente:</strong> aberto o ano todo.<br/>
                            <strong>Cadastro de incentivador:</strong> aberto o ano todo.<br/>
                            <strong>Inscrição de projeto:</strong> abertas de 9h de 08/03/2021 às 19h de 08/07/2021. Confira o Edital PROMAC 2021 no botão Normativos ao lado.<br/>
                            <strong>Captação de recursos:</strong> aberta de 10/03/2021 a 12/11/2021 (ou enquanto houver saldo disponível para captação).
                        </p>

						<p style="text-align: justify">O proponente deverá inscrever-se no botão ao lado e após habilitação poderá inscrever o projeto.</p>

						<p style="text-align: justify">Para saber como participar, clique em <button class='btn btn-theme btn-sm' type='button' data-toggle='modal' data-target='#regulamento' style="border-radius: 10px;">Normativos</button> e se inscreva no link abaixo.</p>

						<p>&nbsp;</p>

                    </div>

                    <!-- Inicio Modal Regulamento  -->
                    <div class="modal fade" id="regulamento" role="dialog" aria-labelledby="regulamentoLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Normativos</h4>
                                </div>
                                <div class="modal-body" align="left">
                                    <div class="well">
                                        <h6>Normativos Vigentes</h6>
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="pdf/Lei_ProMac.pdf" target="_blank">Lei nº 15.948/2013</a></li>
                                            <li class="list-group-item"><a href="pdf/Novo_Decreto_ProMac.pdf" target="_blank">Decreto nº 59.119/2019</a></li>
                                            <li class="list-group-item"><a href="pdf/Retificação_Art31_Decreto.pdf" target="_blank">Retificação do inciso III do Art. 31 do Decreto nº 59.119/2019</a></li>
                                            <li class="list-group-item"><a href="pdf/Portaria_SF_procedimentos_contabeis_incentivador.pdf">Portaria SF nº 173/2018 - Procedimentos Contábeis</a></li>
                                            <li class="list-group-item"><a href="pdf/Portaria_SMC_prestacao_contas.pdf">Portaria Conjunta SMC/SF nº 92/2018 - Prestação de Contas</a></li>
                                            <li class="list-group-item"><a href="pdf/ANEXOS-PRESTACAO-DE-CONTAS-PROMAC.xlsx">Anexos da Portaria de Prestação de Contas</a></li>
                                        </ul>
                                    </div>

                                    <div class="well">
                                        <h6>Edital Vigente e Modelos</h6>
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="pdf/Edital_PROMAC_2021.pdf" target="_blank">Edital Promac 2021</a></li>
                                            <li class="list-group-item"><a href="pdf/Comunicado_Prorrogacao_PROMAC 2021.pdf" target="_blank">Comunicado Prorrogação Promac 2021</a></li>
                                            <li class="list-group-item"><a href="pdf/PRORROGAÇÃO_2_PRAZO_PROMAC_2021_até_08-07-2021.pdf" target="_blank">Comunicado 2ª Prorrogação PROMAC 2021</a></li>
                                            <li class="list-group-item"><a href="pdf/DECLARAÇÃO_CCM_PF.docx" target="_blank">Declaração CCM - Pessoa Física</a></li>
                                            <li class="list-group-item"><a href="pdf/DECLARAÇÃO_CCM_PJ.docx" target="_blank">Declaração CCM - Pessoa Jurídica</a></li>
                                        </ul>
                                        <p><b>Modelos de Termos de Responsabilidade</b></p>
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="pdf/MODELO_TERMO_DE_RESPONSABILIDADE_PROJETOS_APROVADOS_EM_2020_SEM_RECURSOS_EM_CONTA.docx" target="_blank">Projetos Aprovados em 2020 Sem Recursos em Conta</a></li>
                                            <li class="list-group-item"><a href="pdf/MODELO_TERMO_DE_RESPONSABILIDADE_PROJETOS_APROVADOS_EM_2020_COM_RECURSOS_EM_CONTA.docx" target="_blank">Projetos Aprovados em 2020 Com Recursos em Conta  <small>(Enviar extrato da conta juntamente com esse modelo preenchido)</small></a></li>
                                            <li class="list-group-item"><a href="pdf/MODELO_TERMO_DE_RESPONSABILIDADE_PROJETOS_APROVADOS_EM_2021_SEM_RECURSOS_EM_CONTA.docx" target="_blank">Projetos Aprovados em 2021 Sem Recursos em Conta</a></li>
                                        </ul>
                                        <p><b>Modelos de Solicitação de Alteração de Projeto</b></p>
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="pdf/MODELOS_DE_SOLICITACAO_DE_ALTERACAO_DE_PROJETO_PROMAC.pdf" target="_blank">Modelos de Solicitação de Alteração de Projeto</a></li>
                                        </ul>
                                    </div>

                                    <div class="well">
                                        <h6>Editais Anteriores</h6>
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="pdf/Edital_PROMAC_2020.pdf" target="_blank">Edital Promac 2020</a></li>
                                            <li class="list-group-item"><a href="pdf/Prorrogacao_Pro-Mac_2020.pdf" target="_blank">Prorrogação de Prazo de Inscrição</a></li>
                                            <li class="list-group-item"><a href="pdf/2° prorrogação de prazo de inscrição de projetos.pdf" target="_blank">2ª Prorrogação de Inscrição de Projetos - Edital PROMAC 2020</a></li>
                                            <li class="list-group-item"><a href="pdf/Edital_PROMAC_2018.pdf" target="_blank">Edital Promac 2018</a></li>
                                        </ul>
                                    </div>

                                    <div class="well">
                                        <h6>Manuais e Instruções</h6>
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="pdf/Mini_Manual_do_Incentivador_2021.pdf" target="_blank">Mini Manual do Incentivador 2021</a></li>
                                            <li class="list-group-item"><a href="pdf/Mapa_Equipamentos_Culturais_07-01-2019.pdf" target="_blank">Mapa de Equipamentos Culturais</a></li>
                                            <li class="list-group-item"><a href="pdf/EQUIPAMENTOS_CULTURAIS_FAIXAS_E_ENDERECOS.pdf" target="_blank">Lista de Equipamentos Culturais da SMC e CEUS com Endereços e Faixas de Renúncia Fiscal</a></li>
                                            <li class="list-group-item"><a href="pdf/COMO_USAR_O_GEOSAMPA_PARA_CONSULTAR_DISTRITO.pdf" target="_blank">Como usar o Geosampa para localizar o distrito de um endereço?</a></li>
                                        </ul>
                                    </div>

                                    <div class="well">
                                        <h6>Normativos Revogado</h6>
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="pdf/Decreto_ProMac.pdf" target="_blank">Decreto nº 58.041/2017 (Revogado)</a></li>
                                            <li class="list-group-item"><a href="pdf/AlteracaoDecreto_ProMac.pdf" target="_blank"> Alteração do Decreto nº 58.041/2017 (Revogada)</a></li>
                                            <li class="list-group-item"><a href="pdf/Portaria_publicado.pdf">Portaria SMC nº 69/2018 - Portaria de Procedimentos (Revogada)</a></li>
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
                <div class="row">
                    <div class="alert alert-warning">
                        <h5 style="color: #ff9900">Comunicado sobre prazo de inscrição de projetos no Edital PROMAC 2021:</h5>
                        <p style="color: #ff9900">
                            Conforme publicação em Diário Oficial da Cidade de 29/06/21, a inscrição de projetos no Edital PROMAC 2021 poderá ser feita até as 19h do dia 08/07/21. No entanto, não deixe para última hora, para evitar sobrecarga no sistema e grande fila de análise na Comissão Julgadora de Projetos.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="alert alert-danger">
                        <h5 style="color: red">COMUNICADO sobre os Termos de Responsabilidade</h5>
                        <p style="color: red">
                            Devido à atualização trazida pelo Edital PROMAC 2021, <b>existem modelos diferentes do Termo de Responsabilidade de Execução de Projeto Cultural:</b> para projetos aprovados em 2020 e que não captaram recursos ainda, para aqueles aprovados em 2020 que já captaram algum recurso e para os projetos que serão aprovados em 2021. Diferem entre eles apenas os cabeçalhos preenchidos com os números dos processos correspondentes a cada edital e as tabelas para preenchimento com valores de captação. As cláusulas permanecem as mesmas. Os modelos encontram-se na seção Normativos ao lado, favor atentar qual modelo deve ser usado para seu projeto. <b>Os projetos aprovados em 2020 e que já tem algum recurso em conta devem enviar também, junto do Termo de Responsabilidade adequado, um extrato atualizado da conta do projeto para facilitar a análise do Contrato de Incentivo.</b>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="alert alert-success"><p style="text-warning">Devido às medidas de prevenção ao avanço do COVID-19, o atendimento do PROMAC da SMC está funcionando apenas pelos emails listados no rodapé desta página. Contamos com a compreensão de todos.</p></div>
                </div>
			</div>
		</section>
		<footer>
			<div class="container">
				<table style="width: 100%">
					<tr>
                        <td style="color: #ccc"><i class="fa fa-phone-square"></i> Dúvidas: <br>Sobre cadastros: cadastrospromac@prefeitura.sp.gov.br<br>Sobre projetos: projetospromac@prefeitura.sp.gov.br<br>Sobre incentivo e abatimento fiscal: incentivopromac@gmail.com<br>Sobre prestação de contas: prestacaocontaspromac@prefeitura.sp.gov.br</td>
						<td style="color: #ccc; text-align: center">2018 @ Pro-Mac - Programa Municipal de Apoio a Projetos Culturais<br/>Secretaria Municipal de Cultura<br/>Prefeitura de São Paulo</td>
                        <td style="width: 20%; text-align: right"><img src="visual/images/pin_promac_pq.png" alt="Logo Promac"/>
					</tr>
                    <tr>
                        <td colspan="3" style="color: #ccc; text-align: center; font-size: x-small"><br/><i>Supervisão de Tecnologia da Informação - Sistemas de Informação</i></td>
                    </tr>
				</table>
			</div>
			<script src="visual/js/bootstrap.min.js"></script>
		</footer>
    </body>
</html>
