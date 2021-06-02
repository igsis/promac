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
                                    <a href="normativos" target="_blank"><button type="button" class="btn btn-default"><i class="fas fa-file-alt"></i> Normativos</button></a>
                                    <a href="<?=SERVERURL?>promac/analise_projeto.php" target="_blank"><button type="button" class="btn btn-default"><i class="fas fa-diagnoses"></i> Confira a análise do seu projeto aqui</button></a>
                                    <a href="<?=SERVERURL?>promac/visual/index.php" target="_blank"><button type="button" class="btn btn-default"><i class="fas fa-comment-dots"></i> Consulta Pública: projetos aprovados e outros</button></a>
                                    <button type="button" class="btn btn-default toastsDefaultDefault"><i class="fas fa-bullhorn"></i> Comunicados</button>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-user"></i> Acesse ou cadastre-se no sistema aqui
                                        </button>
                                        <div class="dropdown-menu" role="menu" style="">
                                            <button class="btn dropdown-item" onclick="modalLogin('pf')">Proponente Pessoa Física</button>
                                            <button class="btn dropdown-item" onclick="modalLogin('pj')">Proponente Pessoa Jurídica</button>
                                            <div class="dropdown-divider"></div>
                                            <button class="btn dropdown-item" onclick="modalLogin('incentivador_pf')">Incentivador Pessoa Física</button>
                                            <button class="btn dropdown-item" onclick="modalLogin('incentivador_pj')">Incentivador Pessoa Jurídica</button>
                                            <div class="dropdown-divider"></div>
                                            <button class="btn dropdown-item" onclick="modalLogin('adm')">Administrativo</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md">
                                    <p class="card-text" style="text-align: justify">O Programa de Municipal de Apoio a Projetos Culturais – Pro-Mac, instituído pela Lei nº 15.948/2013 e regulamentado pelo Decreto nº 59.119/2019, tem como objetivo incentivar projetos culturais e artísticos por meio da renúncia fiscal. Os incentivadores – pessoa física ou jurídica - poderão contribuir por meio da renúncia de até 20% do Imposto sobre Serviços de Qualquer Natureza - ISS e do Imposto Predial e Territorial Urbano - IPTU.</p>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <p style="text-align: justify">
                                        <br>
                                        <strong>Cadastro de proponente:</strong> aberto o ano todo.<br/>
                                        <strong>Cadastro de incentivador:</strong> aberto o ano todo.<br/>
                                        <strong>Inscrição de projeto:</strong> abertas de 9h de 08/03/2021 às 19h de 30/06/2021. Confira o Edital PROMAC 2021 no botão Normativos ao lado.<br/>
                                        <strong>Captação de recursos:</strong> aberta de 10/03/2021 a 12/11/2021 (ou enquanto houver saldo disponível para captação).
                                    </p>

                                    <p style="text-align: justify">
                                        O proponente deverá inscrever-se no botão ao lado e após habilitação poderá inscrever o projeto.<br>
                                        Para saber como participar, clique em Normativos e se inscreva no menu acima.
                                    </p>
                                </div>

                                <div class="col-md-5">
                                    <div class="card card-secondary card-outline">
                                        <div class="card-header" style="text-align: center">Você já leu o novo Decreto que regulamenta o PROMAC?</div>
                                        <div class="card-body">
                                            <p style="text-align: justify">
                                                <a href="pdf/Novo_Decreto_ProMac.pdf" target="_blank">Leia aqui o normativo na íntegra para ficar por dentro das novidades! O novo Edital para inscrição de projetos será publicado com base nestas novas regras, saiba mais.</a><br><br>
                                                <a href="pdf/MAPA E LISTA DE DISTRITOS SITE.pdf" target="_blank">Veja aqui o mapa com os distritos que compõem cada faixa de renúncia fiscal de acordo com o novo Edital do PROMAC</a>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="alert alert-warning alert-dismissible"  style="text-align: center">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
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

<!-- Modal -->
<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLoginLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLoginLabel">Acesso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="" id="formLogin">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="login" id="labelLogin">Login:</label>
                        <input class="form-control" type="text" id="txtLogin" required>
                    </div>
                    <div class="form-group">
                        <label for="senha">Senha:</label>
                        <input class="form-control" type="password" id="senha" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary" href="" id="linkCadastro">Cadastro? Click Aqui</a>
                    <button type="submit" class="btn btn-primary">Acessar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function modalLogin(tipo_acesso) {
        let modalLogin = $('#modalLogin');
        let txtLogin = $("#txtLogin");

        switch (tipo_acesso) {
            case 'pf':
                modalLogin.find('.modal-title').text('Acesso Proponente Pessoa Física');
                modalLogin.find('#formLogin').attr('action', 'aeoo');
                modalLogin.find('#labelLogin').text('CPF:');
                txtLogin.attr('type', 'text');
                txtLogin.val('');
                txtLogin.mask("999.999.999-99");
                modalLogin.find('#linkCadastro').attr('href', 'cadastro_pf&tipo=pf');
                break;

            case 'pj':
                modalLogin.find('.modal-title').text('Acesso Proponente Pessoa Jurídica');
                modalLogin.find('#labelLogin').text('CNPJ:');
                txtLogin.attr('type', 'text');
                txtLogin.val('');
                txtLogin.mask("99.999.999/9999-99");
                modalLogin.find('#linkCadastro').attr('href', 'cadastro_pj&tipo=pj');
                break;

            case 'incentivador_pf':
                modalLogin.find('.modal-title').text('Acesso Incentivador Pessoa Física');
                modalLogin.find('#labelLogin').text('CPF:');
                txtLogin.attr('type', 'text');
                txtLogin.val('');
                txtLogin.mask("999.999.999-99");
                modalLogin.find('#linkCadastro').attr('href', 'cadastro_pf&tipo=incentivador_pf');
                break;

            case 'incentivador_pj':
                modalLogin.find('.modal-title').text('Acesso Incentivador Pessoa Jurídica');
                modalLogin.find('#labelLogin').text('CNPJ:');
                txtLogin.attr('type', 'text');
                txtLogin.val('');
                txtLogin.mask("99.999.999/9999-99");
                modalLogin.find('#linkCadastro').attr('href', 'cadastro_pj&tipo=incentivador_pj');
                break;

            default:
                modalLogin.find('.modal-title').text('Acesso Administrativo');
                modalLogin.find('#labelLogin').text('Email:');
                txtLogin.val('');
                txtLogin.attr('type', 'email');
                txtLogin.unmask();
                modalLogin.find('#linkCadastro').attr('href', 'cadastro');
                break;
        }

        modalLogin.modal({
            show: true
        });
    }

    /**
     * Comunicados
     */
    $(function() {
        $('.toastsDefaultDefault').click(function() {
            $(document).Toasts('create', {
                title: 'COMUNICADO sobre os Termos de Responsabilidade',
                body: 'Devido à atualização trazida pelo Edital PROMAC 2021, <b>existem modelos diferentes do Termo de Responsabilidade de Execução de Projeto Cultural:</b> para projetos aprovados em 2020 e que não captaram recursos ainda, para aqueles aprovados em 2020 que já captaram algum recurso e para os projetos que serão aprovados em 2021. Diferem entre eles apenas os cabeçalhos preenchidos com os números dos processos correspondentes a cada edital e as tabelas para preenchimento com valores de captação. As cláusulas permanecem as mesmas. Os modelos encontram-se na seção Normativos ao lado, favor atentar qual modelo deve ser usado para seu projeto. <b>Os projetos aprovados em 2020 e que já tem algum recurso em conta devem enviar também, junto do Termo de Responsabilidade adequado, um extrato atualizado da conta do projeto para facilitar a análise do Contrato de Incentivo.'
            })
            $(document).Toasts('create', {
                title: 'Comunicado sobre prazo de inscrição de projetos no Edital PROMAC 2021:',
                body: 'Conforme publicação em Diário Oficial da Cidade de 15/05/21, a inscrição de projetos no Edital PROMAC 2021 poderá ser feita até as 19h do dia 30/06/21. No entanto, não deixe para última hora, para evitar sobrecarga no sistema e grande fila de análise na Comissão Julgadora de Projetos.'
            })
        });
    });
</script>