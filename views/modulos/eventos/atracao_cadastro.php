<?php
$evento_id = $_SESSION['origem_id_c'];

if (isset($_GET['key'])) {
    $_SESSION['atracao_id_c'] = $id = $_GET['key'];
} elseif (isset($_SESSION['atracao_id_c'])) {
    $id = $_SESSION['atracao_id_c'];
} else {
    $id = null;
}

require_once "./controllers/AtracaoController.php";
$atracaoObj = new AtracaoController();
$atracao = $atracaoObj->recuperaAtracao($id);
?>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Atração</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Dados da Atração</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal formulario-ajax" method="POST"
                              action="<?= SERVERURL ?>ajax/atracaoAjax.php" role="form"
                              data-form="<?= ($atracao) ? "update" : "save" ?>">
                            <input type="hidden" name="_method"
                                   value="<?= ($atracao) ? "editarAtracao" : "cadastrarAtracao" ?>">
                            <?php if ($atracao): ?>
                                <input type="hidden" name="id" value="<?= $atracao->id ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="nome_evento">Nome da Atração *</label>
                                    <input type="text" class="form-control" id="nome_atracao" name="nome_atracao"
                                           placeholder="Digite o nome da Atração" maxlength="240"
                                           value="<?= $atracao->nome_atracao ?? "" ?>" required>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-7">
                                        <label for="acao">Ações (Expressões Artístico-culturais) * <i>(multipla
                                                escolha) </i></label>
                                        <button class='btn btn-default' type='button' data-toggle='modal'
                                                data-target='#modalAcoes' style="border-radius: 30px;">
                                            <i class="fa fa-question-circle"></i></button>
                                        <div class="row" id="msgEsconde">
                                            <div class="form-group col-md-6">
                                                <span style="color: red;">Selecione ao menos uma das expressões artístico-culturais!</span>
                                            </div>
                                        </div>
                                        <?php $atracaoObj->geraCheckbox('acoes', 'acao_atracao', 'atracao_id', $atracao->id ?? null, true); ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="ficha_tecnica">Ficha técnica completa *</label><br>
                                        <i>Esse campo deve conter a listagem de pessoas envolvidas no espetáculo, como
                                            elenco, técnicos, e outros profissionais envolvidos na realização do
                                            mesmo.</i>
                                        <p align="justify">
                                        <span style="color: gray; ">
                                            <strong><i>Elenco de exemplo:</strong><br>Lúcio Silva (guitarra e vocal)<br>Fabio Sá (baixo)<br>Marco da Costa (bateria)<br>Eloá Faria (figurinista)<br>Leonardo Kuero (técnico de som)</span></i>
                                        </p>
                                        <textarea class="form-control" name="ficha_tecnica" id="ficha_tecnica" rows="8"
                                                  required><?= $atracao->ficha_tecnica ?? "" ?></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="integrantes">Integrantes *</label><br>
                                        <i>Esse campo deve conter a listagem de pessoas envolvidas no espetáculo <span
                                                    style="color: #FF0000; ">incluindo o líder do grupo</span>.<br>Apenas
                                            o <span style="color: #FF0000; ">nome civil, RG e CPF</span> de quem irá se
                                            apresentar, excluindo técnicos.</i>
                                        <p align="justify"><span
                                                    style="color: gray; "><strong><i>Elenco de exemplo:</strong><br>Ana Cañas RG 00000000-0 CPF 000.000.000-00<br>Lúcio Maia RG 00000000-0 CPF 000.000.000-00<br>Fabá Jimenez RG 00000000-0 CPF 000.000.000-00<br>Fabio Sá RG 00000000-0 CPF 000.000.000-00<br>Marco da Costa RG 00000000-0 CPF 000.000.000-00</span></i>
                                        </p>
                                        <textarea class="form-control" name="integrantes" id="integrantes" rows="8"
                                                  required><?= $atracao->integrantes ?? "" ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="classificacao_indicativa_id">Classificação indicativa * </label>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#modal-default"><i class="fa fa-info"></i></button>
                                    <select class="form-control" id="classificacao_indicativa_id"
                                            name="classificacao_indicativa_id" required>
                                        <option value="">Selecione...</option>
                                        <?php $atracaoObj->geraOpcao('classificacao_indicativas', $atracao->classificacao_indicativa_id ?? ""); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="release_comunicacao" class="col-form-label">Release *</label><br>
                                    <i>Esse campo deve abordar informações relacionadas ao artista, abordando breves
                                        marcos na carreira e ações realizadas anteriormente.</i>
                                    <p align="justify"><span style="color: gray; "><strong><i>Texto de exemplo:</strong><br>A cantora e compositora paulistana lançou, em 2007, o seu primeiro disco, "Amor e Caos". Dois anos depois, lançou "Hein?", disco produzido por Liminha e que contou com "Esconderijo", canção composta por Ana, eleita entre as melhores do ano pela revista Rolling Stone e que alcançou repercussão nacional por integrar a trilha sonora da novela "Viver a Vida" de Manoel Carlos, na Rede Globo. Ainda em 2009, grava, a convite do cantor e compositor Nando Reis, a bela canção "Pra Você Guardei o Amor". Em 2012, Ana lança o terceiro disco de inéditas, "Volta", com versões para Led Zeppelin ("Rock'n'Roll") e Edith Piaf ("La Vie en Rose"), além das inéditas autorais "Urubu Rei" (que ganhou clipe dirigido por Vera Egito) e "Será Que Você Me Ama?". Em 2013, veio o primeiro DVD, "Coração Inevitável", registrando o show que contou com a direção e iluminação de Ney Matogrosso.</span></i>
                                    </p>
                                    <textarea id="release_comunicacao" name="release_comunicacao" class="form-control"
                                              rows="5" required><?= $atracao->release_comunicacao ?? "" ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="links">Links</label><br>
                                    <i>
                                        Esse campo deve conter os links relacionados ao espetáculo, ao artista/grupo que
                                        auxiliem na divulgação do evento.
                                    </i>
                                    <p align="justify">
                                    <span style="color: gray; ">
                                        <strong><i>Links de exemplo:</i></strong><br>
                                        <i>
                                            https://www.facebook.com/anacanasoficial/<br>
                                            https://www.youtube.com/user/anacanasoficial
                                        </i>
                                    </span>
                                    </p>
                                    <textarea id="links" name="links" class="form-control"
                                              rows="5"><?= $atracao->links ?? "" ?></textarea>
                                </div>

                                <div class="form-group row">
                                    <div class="form-group col-md-6">
                                        <label for="quantidade_apresentacao">Quantidade de Apresentação *</label>
                                        <input type="number" class="form-control" id="quantidade_apresentacao"
                                               name="quantidade_apresentacao" maxlength="2"
                                               value="<?= $atracao->quantidade_apresentacao ?? "" ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="valor_individual">Valor *</label> <i>Preencher 0,00 quando não
                                            houver valor</i>
                                        <input type="text" id="valor_individual" name="valor_individual"
                                               class="form-control"
                                               value="<?= isset($atracao->valor_individual) ? $atracaoObj->dinheiroParaBr($atracao->valor_individual) : "" ?>"
                                               required
                                               onKeyPress="return(moeda(this,'.',',',event))">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info float-right" id="cadastra">Gravar</button>
                            </div>
                            <!-- /.card-footer -->
                            <div class="resposta-ajax">

                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <!-- /.row -->

            <!-- modal público -->
            <div class="modal fade" id="modalAcoes" style="display: none" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Ações (Expressões Artístico-culturais)</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body" style="text-align: left;">
                            <table class="table table-bordered table-responsive">
                                <thead>
                                <tr>
                                    <th>Ação</th>
                                    <th>Descrição</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $atracaoObj->exibeDescricaoAcao() ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-theme" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal público -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- /modal -->

<?php
$sectionJS = <<<'JQUERY'
<script>
    function desabilitaCheckboxes(acoes) {
        if (acoes[8].checked) {
            for (let x = 0; x < acoes.length; x++) {
                if (x !== 8) {
                    acoes[x].disabled = true;
                    acoes[x].checked = false;
                }
            }
        }
    }

    function reabilitaCheckBoxes(acoes) {
        for (let x = 0; x < acoes.length; x++) {
            acoes[x].disabled = false;
        }
    }

    function validaAcoes() {
        var acoes = $(".acoes");
        var msg = $("#msgEsconde");
        var checked = false;
        var btnCadastra = $('#cadastra');

        for (let x = 0; x < acoes.length; x++) {
            if (acoes[x].checked) {
                if (acoes[8].checked) {
                    desabilitaCheckboxes(acoes);
                } else {
                    acoes[8].disabled = true;
                }
                checked = true;
            }
        }

        if (checked) {
            msg.hide();
            btnCadastra.attr("disabled", false);
            btnCadastra.removeAttr("data-toggle");
            btnCadastra.removeAttr("data-placement");
            btnCadastra.removeAttr("title");
        } else {
            reabilitaCheckBoxes(acoes);
            msg.show();
            btnCadastra.attr("disabled", true);
            btnCadastra.attr("data-toggle", 'tooltip');
            btnCadastra.attr("data-placement", 'left');
            btnCadastra.attr("title", 'Selecione pelo menos uma Ação');

        }
    }

    $('.acoes').on('change', validaAcoes);

    $(document).ready(function () {
        validaAcoes();
        $('.nav-link').removeClass('active');
        $('#atracao_cadastro').addClass('active');
    });
</script>
JQUERY;
?>