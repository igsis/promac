<?php include "visual/cabecalho_index.php" ?>
    <section id="services" class="home-section bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <div class="form-group">
                        <h3>Cadastro de Pessoa Jurídica</h3>
                        <p><strong><?php if (isset($mensagem)) {
                                    echo $mensagem;
                                } ?></strong></p>
                        <p><strong>Vamos verificar se você já possui cadastro no sistema.</strong></p>
                        <br/>
                        <p><strong>Insira o CNPJ</strong></p>
                    </div>
                </div>
                <div class="form-group">
                    <form method="POST" action="login_resultado_incentivador_pj.php" class="form-horizontal"
                          role="form">
                        <div class="col-md-offset-4 col-md-2">
                            <input type="text" name="busca" class="form-control" placeholder="CNPJ" id="cnpj">
                        </div>
                        <div class="col-md-2">
                            <input type="submit" name="pesquisar" class="btn btn-theme btn-md btn-block"
                                   value="Pesquisar">
                        </div>
                    </form>
                </div>

                <div class="form-group">
                    <div class="col-md-offset-2 col-md-8"><br></div>
                </div>

                <div class="form-group">
                    <div class="form-group" style="padding-bottom: 60px;">
                        <div class="col-md-offset-4 col-md-4">
                            <form method="POST" action="login_incentivador_pj.php" class="form-horizontal" role="form">
                                <button class='btn btn-theme btn-md' type='submit' style="border-radius: 30px;">Voltar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="alerta" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">ATENÇÃO</h4>
                </div>
                <div class="modal-body">
                    <p>SMC ainda não consegue operacionalizar o incentivo fiscal proveniente do ISS de empresas que
                        recolhem o ISS diretamente na fonte. Se esse é o caso da sua empresa, pedimos que aguarde, por
                        gentileza. Estamos estudando como operacionalizar esses casos junto à Secretaria da Fazenda.
                        Dúvidas sobre o assunto podem ser tratadas no cadastropromac@prefeitura.sp.gov.br. </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-theme btn-md btn-block" data-dismiss="modal">Ok</button>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        $(window).on('load', function () {
            $('#alerta').modal('show');
        });
    </script>
<?php include "visual/rodape_index.php" ?>