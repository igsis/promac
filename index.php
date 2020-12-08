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
<!--		<link rel="icon" type="image/png" sizes="16x16" href="visual/images/favicon.png">-->
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
<!--                        <img src="visual/images/pin_promac_negativo.png" align="right"  />-->
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
						    <strong>Inscrição de projeto:</strong> abertas de 9h de 27/01/2020 às 23h59 de 27/06/2020. Confira o novo Edital no botão Normativos ao lado.
                        </p>

						<p align="justify">O proponente deverá inscrever-se no botão ao lado e após habilitação poderá inscrever o projeto.</p>

						<p align="justify">Para saber como participar, clique em <button class='btn btn-theme btn-sm' type='button' data-toggle='modal' data-target='#regulamento' style="border-radius: 10px;">Normativos</button> e se inscreva no link abaixo.</p>

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
                                        </ul>
                                    </div>
                                    <!--Solicitada remoção deste bloco dia 28/05/2020
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
                                    </div>-->

                                    <div class="well">
                                        <h6>Edital</h6>
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="pdf/Edital_PROMAC_2020.pdf" target="_blank">Edital Promac 2020</a></li>
                                            <li class="list-group-item"><a href="pdf/Prorrogacao_Pro-Mac_2020.pdf" target="_blank">Prorrogação de Prazo de Inscrição</a></li>
                                            <li class="list-group-item"><a href="pdf/2° prorrogação de prazo de inscrição de projetos.pdf" target="_blank">2ª Prorrogação de Inscrição de Projetos - Edital PROMAC 2020</a></li>
                                        </ul>
                                    </div>

                                    <div class="well">
                                        <h6>Manuais e Instruções</h6>
                                        <ul class="list-group">
                                            <li class="list-group-item"><a href="pdf/mini_manual_incentivador.pdf" target="_blank">Mini Manual do Incentivador</a></li>
        
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
                    <div class="alert alert-success"><p class="text-warning">Devido às medidas de prevenção ao avanço do COVID-19, o atendimento do PROMAC da SMC está funcionando apenas pelos emails listados no rodapé desta página. Contamos com a compreensão de todos.</p></div>
                </div>
                <div class="row">
<!--                    <div class="alert alert-danger">-->
<!--                        <p class="text-justify">Comunicamos que a partir do dia 22 de abril de 2020 está aberto o período de captação de recursos do Pro-Mac para os projetos culturais aprovados. Em conformidade com as medidas tomadas para contenção do avanço da COVID-19, o envio de Contratos de Incentivo (Anexo IV do Edital) e Termos de Responsabilidade de Execução de Projeto Cultural (Anexo V do Edital) se dará exclusivamente por meio eletrônico pelo e-mail incentivopromac@prefeitura.sp.gov.br. O título do e-mail deverá seguir o seguinte padrão: “CONTRATO DE INCENTIVO E TERMO DE RESPONSABILIDADE (NOME DO PROJETO) + (NOMES DOS INCENTIVADORES)”. As vias originais dos respectivos documentos devem ser mantidas para posterior apresentação à SMC caso solicitado.</p>-->
<!---->
<!--                        <p class="text-justify">O remetente do e-mail deverá aguardar nossa resposta com um número de protocolo confirmando o recebimento da documentação. Porém, isto não significará que a reserva dos recursos está automaticamente garantida, pois os Contratos de Incentivo serão analisados com base nos critérios (tais como regularidade cadastral e fiscal do proponente e incentivador; forma, conteúdo, prazos e assinaturas do contrato, etc) estabelecidos no edital, contidos nos itens 76 a 124 do edital Pro-Mac 2020. Caso o(s) Contrato(s) de Incentivo venha a ter alguma irregularidade ou inconformidade, informaremos por e-mail e o projeto será automaticamente excluído da fila. Após a correção dos problemas apontados será necessário o envio de toda a documentação novamente.</p>-->
<!---->
<!--                        <p>Dúvidas podem ser encaminhadas para o e-mail incentivopromac@prefeitura.sp.gov.br</p>-->
<!--                    </div>-->
                    <div class="alert alert-danger">
                        <p><strong>ATENÇÃO! INFORMES PROMAC</strong></p>
                        <p><strong>SOBRE O ENCERRAMENTO DO EXERCÍCIO FISCAL DE 2020:</strong></p>
                        <p>Comunicamos que, em decorrência da publicação do Decreto Municipal nº 59.934, de  01 de dezembro de 2020, que dispõe sobre o encerramento do exercício de 2020, o PROMAC encerrou em 04 de dezembro de 2020 o recebimento de Contratos de Incentivo para captação de recursos do exercício fiscal de 2020. Tal encerramento se deve à data limite para empenhos imposta no Decreto supracitado, a qual o PROMAC, assim como demais programas da Prefeitura de São Paulo, fica submetido. Sendo assim, para captação de recursos de projetos, favor aguardar o início da captação em 2021.</p>
                        <p><strong>SOBRE OS APORTES FINAIS DE 2020 (PARA PROJETOS E INCENTIVADORES QUE JÁ POSSUEM AUTORIZAÇÃO ÚNICA DE DEPÓSITO REFERENTE A CONTRATOS DE INCENTIVO DE 2020):</strong></p>
                        <p>Também a partir da publicação do Decreto Municipal nº 59.934/2020 e da determinação do prazo final para as liquidações de recursos, <strong>o PROMAC estabelece o dia 20 de dezembro de 2020 às 18h como data limite para envio de comprovantes de aporte nos projetos (extrato bancário e comprovante de depósito) para emissão de Certificados de Incentivo.</strong>  Sendo assim, se ainda há "saldo" para aportes de acordo com a Autorização Única de Depósito emitida, o incentivador poderá depositar e nos enviar o comprovante e extrato no máximo até dia 21 deste mês às 18h. Extratos enviados após essa data limite serão desconsiderados e o aporte terá que ser devolvido ao incentivado</p>
                        <p>Eventuais "saldos" nas Autorizações de Depósitos do ano de 2020 são zerados para o ano de 2021, ou seja, as Autorizações de Depósito são válidas apenas no seu ano de emissão, como está informado na própria Autorização e no item 1 do Contrato de Incentivo.</p>
                        <p>Como informado em Edital e no próprio Contrato de Incentivo, os Certificados de Incentivo obtidos após realização dos aportes aos projetos tem validade de 2 (dois) anos, ou seja, eles podem ser abatidos em até 24 (vinte e quatro) meses após sua emissão, de forma não fracionada (cada Certificado de Incentivo é usado de uma só vez e uma única vez). Sendo assim, é possível utilizar um Certificado de Incentivo emitido em 2020 para pagamento de impostos em 2021, por exemplo.</p>
                        <p><strong>SOBRE A CAPTAÇÃO DE RECURSOS DO ANO DE 2021:</strong></p>
                        <p>O início da captação de recursos do ano de 2021 e o montante destinado ao PROMAC estão em negociação com a Secretaria Municipal da Fazenda e a Câmara Municipal dos Vereadores, dentro do contexto de discussão sobre o orçamento municipal. A data de abertura da captação de recursos, quando novos Contratos de Incentivo poderão ser enviados, depende de algumas definições dessa discussão. Mais informações sobre o assunto serão publicadas neste site e no Diário Oficial.</p>
                        <p>Dúvidas sobre esses assuntos: <u><i>incentivopromac@prefeitura.sp.gov.br</i></u></p>
                    </div>
                </div>
			</div>
		</section>
		<footer>
			<div class="container">
				<table width="100%">
					<tr>
                        <td><font color="#ccc"><i class="fa fa-phone-square"></i> Dúvidas: <br>Sobre cadastros: cadastrospromac@prefeitura.sp.gov.br<br>Sobre projetos: projetospromac@prefeitura.sp.gov.br<br>Sobre incentivo e abatimento fiscal: incentivopromac@prefeitura.sp.gov.br<br>Sobre prestação de contas: prestacaocontaspromac@prefeitura.sp.gov.br</font></td>
						<td align="center"><font color="#ccc">2018 @ Pro-Mac - Programa Municipal de Apoio a Projetos Culturais<br/>Secretaria Municipal de Cultura<br/>Prefeitura de São Paulo</font></td>
<!--                        <td width="20%"><img src="visual/images/pin_promac_pq.png" align="right"/></td>-->
					</tr>
                    <tr>
                        <td colspan="3" align="center"><font color="#ccc" size="1"><br/><i>Supervisão de Tecnologia da Informação - Sistemas de Informação</i></font></td>
                    </tr>
				</table>
			</div>
			<script src="visual/js/bootstrap.min.js"></script>
		</footer>
    </body>
</html>
