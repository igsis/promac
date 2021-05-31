<?php
    if (isset($_POST['email']) && (isset($_POST['senha']))) {
        require_once "./controllers/UsuarioController.php";
        $login = new UsuarioController();
        echo $login->iniciaSessao();
    }
?>
<!-- /.content-header -->
<div class="login-page">
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="offset-1 col-lg-10">
                    <div class="card">
                        <div class="card-header bg-dark">

                            <div class="row">
                                <div class="col-md-10 bg-dark">
                                    <a href="<?= SERVERURL ?>inicio" class="brand-link">
                                        <img src="<?= SERVERURL ?>views/dist/img/pin_promac.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                                        <span class="brand-text font-weight-light"><?= NOMESIS ?> - Programa de Municipal de Apoio a Projetos Culturais – Pro-Mac</span>
                                    </a>
                                </div>
                                <div class="col-md-2">
                                    <img src="<?= SERVERURL ?>views/dist/img/CULTURA_PB_NEGATIVO_HORIZONTAL.png" alt="logo cultura">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-dark"><i class="fas fa-file-alt"></i> Normativos</button>
                                    <button type="button" class="btn btn-outline-dark"><i class="fas fa-diagnoses"></i> Confira a análise do seu projeto aqui</button>
                                    <button type="button" class="btn btn-outline-dark"><i class="fas fa-comment-dots"></i> Consulta Pública: projetos aprovados e outros</button>
                                    <button type="button" class="btn btn-outline-dark toastsDefaultDefault"><i class="fas fa-bullhorn"></i> Comunicados</button>

                                    <div class="btn-group">
                                        <button type="button" class="btn btn-outline-dark"><i class="fas fa-user"></i> Acesse o sistema aqui</button>
                                        <button type="button" class="btn btn-outline-dark dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <a class="dropdown-item" href="#">Proponente Pessoa Física</a>
                                            <a class="dropdown-item" href="#">Proponente Pessoa Jurídica</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Incentivador Pessoa Física</a>
                                            <a class="dropdown-item" href="#">Incentivador Pessoa Jurídica</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Administrativo</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md">
                                    <p class="card-text" style="text-align: justify">O Programa de Municipal de Apoio a Projetos Culturais – Pro-Mac, instituído pela Lei nº 15.948/2013 e regulamentado pelo Decreto nº 59.119/2019, tem como objetivo incentivar projetos culturais e artísticos por meio da renúncia fiscal. Os incentivadores – pessoa física ou jurídica - poderão contribuir por meio da renúncia de até 20% do Imposto sobre Serviços de Qualquer Natureza - ISS e do Imposto Predial e Territorial Urbano - IPTU.</p>
                                    <p style="text-align: justify">Você já leu o novo Decreto que regulamenta o PROMAC?<br/>
                                        <a href="pdf/Novo_Decreto_ProMac.pdf" target="_blank">Leia aqui o normativo na íntegra para ficar por dentro das novidades! O novo Edital para inscrição de projetos será publicado com base nestas novas regras, saiba mais.</a><br>
                                        <a href="pdf/MAPA E LISTA DE DISTRITOS SITE.pdf" target="_blank">Veja aqui o mapa com os distritos que compõem cada faixa de renúncia fiscal de acordo com o novo Edital do PROMAC</a>
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <p style="text-align: justify">
                                        <strong>Cadastro de proponente:</strong> aberto o ano todo.<br/>
                                        <strong>Cadastro de incentivador:</strong> aberto o ano todo.<br/>
                                        <strong>Inscrição de projeto:</strong> abertas de 9h de 08/03/2021 às 19h de 30/06/2021. Confira o Edital PROMAC 2021 no botão Normativos ao lado.<br/>
                                        <strong>Captação de recursos:</strong> aberta de 10/03/2021 a 12/11/2021 (ou enquanto houver saldo disponível para captação).
                                    </p>

                                    <p style="text-align: justify">O proponente deverá inscrever-se no botão ao lado e após habilitação poderá inscrever o projeto.</p>

                                    <p style="text-align: justify">Para saber como participar, clique em <button class='btn btn-theme btn-sm' type='button' data-toggle='modal' data-target='#regulamento' style="border-radius: 10px;">Normativos</button> e se inscreva no link abaixo.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="alert alert-warning alert-dismissible">
                                    Devido às medidas de prevenção ao avanço do COVID-19, o atendimento do PROMAC da SMC está funcionando apenas pelos emails listados no rodapé desta página. Contamos com a compreensão de todos.
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light-gradient text-center">
                            <div class="row">
                                <div class="col-md-1">
                                    <i class="fa fa-phone-square"></i> Dúvidas:
                                </div>
                                <div class="col-md">
                                     Sobre cadastros: cadastrospromac@prefeitura.sp.gov.br<br>Sobre projetos: projetospromac@prefeitura.sp.gov.br
                                </div>
                                <div class="col-md">
                                    Sobre incentivo e abatimento fiscal: incentivopromac@gmail.com<br>Sobre prestação de contas: prestacaocontaspromac@prefeitura.sp.gov.br
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="toastsContainerTopRight" class="toasts-top-right fixed">
    <div class="toast fade" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header"><strong class="mr-auto">Comunicado sobre prazo de inscrição de projetos no Edital PROMAC 2021:</strong>
            <button data-dismiss="toast" type="button" class="ml-2 mb-1 close" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="toast-body">Conforme publicação em Diário Oficial da Cidade de 15/05/21, a inscrição de projetos no
            Edital PROMAC 2021 poderá ser feita até as 19h do dia 30/06/21. No entanto, não deixe para última hora, para
            evitar sobrecarga no sistema e grande fila de análise na Comissão Julgadora de Projetos.
        </div>
    </div>

    <div class="toast fade" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header"><strong class="mr-auto">COMUNICADO sobre os Termos de Responsabilidade</strong>
            <button data-dismiss="toast" type="button" class="ml-2 mb-1 close" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="toast-body">Devido à atualização trazida pelo Edital PROMAC 2021, <b>existem modelos diferentes do Termo de Responsabilidade de Execução de Projeto Cultural:</b> para projetos aprovados em 2020 e que não captaram recursos ainda, para aqueles aprovados em 2020 que já captaram algum recurso e para os projetos que serão aprovados em 2021. Diferem entre eles apenas os cabeçalhos preenchidos com os números dos processos correspondentes a cada edital e as tabelas para preenchimento com valores de captação. As cláusulas permanecem as mesmas. Os modelos encontram-se na seção Normativos ao lado, favor atentar qual modelo deve ser usado para seu projeto. <b>Os projetos aprovados em 2020 e que já tem algum recurso em conta devem enviar também, junto do Termo de Responsabilidade adequado, um extrato atualizado da conta do projeto para facilitar a análise do Contrato de Incentivo.</b>
        </div>
    </div>
</div>