<?php
$tipoContratacao = $_SESSION['modulo_c'];

if (isset($_GET['key'])) {
    $_SESSION['origem_id_c'] = $id = $_GET['key'];
    require_once "./controllers/PedidoController.php";
    $pedidoObj = new PedidoController();
    $pedidoObj->startPedido();

} elseif (isset($_SESSION['origem_id_c'])) {
    $id = $_SESSION['origem_id_c'];
} else {
    $id = null;
}

require_once "./controllers/OficinaController.php";
$oficinaObj = new OficinaController();
$oficina = $oficinaObj->recuperaOficina($id);
if ($oficina) {
    $_SESSION['atracao_id_c'] = $oficinaObj->encryption($oficina->atracao_id);
    $tipoContratacao = $oficina->tipo_contratacao_id;
}

?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro de Oficina</h1>
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
                        <h3 class="card-title">Informações iniciais</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/oficinaAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editarOficina" : "cadastrarOficina" ?>">
                        <input type="hidden" name="ev_tipo_contratacao_id" value="<?=$tipoContratacao?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="evento_id" value="<?=$oficinaObj->encryption($oficina->id)?>">
                            <input type="hidden" name="atracao_id" value="<?=$oficinaObj->encryption($oficina->atracao_id)?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="nomeEvento">Nome da oficina *</label>
                                <input type="text" class="form-control" id="nomeEvento" name="ev_nome_evento"
                                       placeholder="Digite o nome da oficina. Exemplo: Oficina de ponto cruz"
                                       maxlength="240" value="<?=$oficina->nome_evento ?? ""?>" required>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Espaço em que será realizado o evento é público?</label>
                                    <br>
                                    <div class="form-check-inline">
                                        <input name="ev_espaco_publico" class="form-check-input" type="radio" value="1" <?=$oficina ? ($oficina->espaco_publico == 1 ? "checked" : "") : ""?>>
                                        <label class="form-check-label">Sim</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input name="ev_espaco_publico" class="form-check-input" type="radio" value="0"<?=$oficina ? ($oficina->espaco_publico == 0 ? "checked" : "") : "checked"?>>
                                        <label class="form-check-label">Não</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="fomento">É fomento/programa?</label>
                                    <br>
                                    <div class="form-check-inline">
                                        <input name="ev_fomento" class="form-check-input fomento" type="radio" value="1" id="sim" <?=$oficina ? ($oficina->fomento == 1 ? "checked" : "") : ""?>>
                                        <label class="form-check-label">Sim</label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input name="ev_fomento" class="form-check-input fomento" type="radio" value="0" <?=$oficina ? ($oficina->fomento == 0 ? "checked" : "") : "checked"?>>
                                        <label class="form-check-label">Não</label>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="tipoFomento">Fomento/Programa</label> <br>
                                    <select class="form-control" name="ev_fomento_id" id="tipoFomento">
                                        <option value="">Selecione uma opção...</option>
                                        <?php $oficinaObj->geraOpcao('fomentos', $oficina->fomento_id ?? ""); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-7">
                                    <label for="acao">Público (Representatividade e Visibilidade Sócio-cultural)* <i>(multipla escolha) </i></label>
                                    <button class='btn btn-default' type='button' data-toggle='modal'
                                            data-target='#modalPublico' style="border-radius: 30px;">
                                        <i class="fa fa-question-circle"></i></button>
                                    <div class="row" id="msgEsconde">
                                        <div class="form-group col-md-6">
                                            <span style="color: red;">Selecione ao menos uma representatividade!</span>
                                        </div>
                                    </div>
                                    <?php $oficinaObj->geraCheckbox('publicos', 'evento_publico', 'evento_id',$oficina->id ?? null, true); ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sinopse">Sinopse *</label><br/>
                                <i>Esse campo deve conter uma breve descrição do que será apresentado no evento.</i>
                                <p align="justify"><span style="color: gray; "><strong><i>Texto de exemplo:</strong><br/>Ana Cañas faz o show de lançamento do seu quarto disco, “Tô na Vida” (Som Livre/Guela Records). Produzido por Lúcio Maia (Nação Zumbi) em parceria com Ana e mixado por Mario Caldato Jr, é o primeiro disco totalmente autoral da carreira da cantora e traz parcerias com Arnaldo Antunes e Dadi entre outros.</span></i>
                                </p>
                                <textarea name="ev_sinopse" id="sinopse" class="form-control" rows="5" required><?=$oficina->sinopse ?? ""?></textarea>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="ficha_tecnica">Ficha técnica completa *</label><br/>
                                    <i>Esse campo deve conter a listagem de pessoas envolvidas no espetáculo, como elenco, técnicos, e outros profissionais envolvidos na realização do mesmo.</i>
                                    <p align="justify"><span style="color: gray; ">
                                        <i><strong>Elenco de exemplo:</strong><br/>Lúcio Silva (guitarra e vocal)<br/>Fabio Sá (baixo)<br/>Marco da Costa (bateria)<br/>Eloá Faria (figurinista)<br/>Leonardo Kuero (técnico de som)</i>
                                    </span></p>
                                    <textarea id="ficha_tecnica" name="at_ficha_tecnica" class="form-control" rows="8" required><?=$oficina->ficha_tecnica ?? ""?></textarea>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="integrantes">Integrantes *</label><br/>
                                    <i>Esse campo deve conter a listagem de pessoas envolvidas no espetáculo <span style="color: #FF0000; ">incluindo o líder do grupo</span>. Apenas o <span style="color: #FF0000; ">nome civil, RG e CPF</span> de quem irá se apresentar, excluindo técnicos.</i>
                                    <p align="justify"><span style="color: gray; ">
                                        <i><strong>Elenco de exemplo:</strong><br/>Ana Cañas RG 00000000-0 CPF 000.000.000-00<br/>Lúcio Maia RG 00000000-0 CPF 000.000.000-00<br/>Fabá Jimenez RG 00000000-0 CPF 000.000.000-00<br/>Fabio Sá RG 00000000-0 CPF 000.000.000-00<br/>Marco da Costa RG 00000000-0 CPF 000.000.000-00</i>
                                    </span></p>
                                    <textarea id="integrantes" name="at_integrantes" class="form-control" rows="8" required><?=$oficina->integrantes ?? ""?></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="classificacao_indicativa_id">Classificação indicativa * </label>
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#modal-default"><i class="fa fa-info"></i></button>
                                    <select class="form-control" id="classificacao_indicativa_id"
                                            name="at_classificacao_indicativa_id" required>
                                        <option value="">Selecione...</option>
                                        <?php $oficinaObj->geraOpcao('classificacao_indicativas', $oficina->classificacao_indicativa_id ?? ""); ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="valor_individual">Valor *</label> <i>Preencher 0,00 quando não
                                        houver valor</i>
                                    <input type="text" id="valor_individual" name="at_valor_individual"
                                           class="form-control"
                                           value="<?= isset($oficina->valor_individual) ? $oficinaObj->dinheiroParaBr($oficina->valor_individual) : "" ?>"
                                           required
                                           onKeyPress="return(moeda(this,'.',',',event))">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="links">Links</label><br/>
                                <i>Esse campo deve conter os links relacionados ao espetáculo, ao artista/grupo que auxiliem na divulgação do evento.</i>
                                <p align="justify"><span style="color: gray; "><strong><i>Links de exemplo:</i></strong><br/> https://www.facebook.com/anacanasoficial/<br/>https://www.youtube.com/user/anacanasoficial</i></span>
                                </p>
                                <textarea id="links" name="at_links" class="form-control" rows="5"><?=$oficina->links ?? ""?></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right" id="cadastra">Gravar</button>
                        </div>
                        <!-- /.card-footer -->
                        <div class="resposta-ajax"></div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<!-- /modal -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>Classificação Indicativa</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h4><strong>Informação e Liberdade de Escolha</strong></h4>
                <p align="justify">A Classificação Indicativa é um conjunto de informações sobre o conteúdo de
                    obras audiovisuais e diversões públicas quanto à adequação de horário, local e faixa etária.
                    Ela alerta os pais ou responsáveis sobre a adequação da programação à idade de crianças e
                    adolescentes. É da Secretaria Nacional de Justiça (SNJ), do Ministério da Justiça (MJ), a
                    responsabilidade da Classificação Indicativa de programas TV, filmes, espetáculos, jogos
                    eletrônicos e de interpretação (RPG).</p>
                <p align="justify">Programas jornalísticos ou noticiosos, esportivos, propagandas eleitorais e
                    publicidade, espetáculos circenses, teatrais e shows musicais não são classificados pelo
                    Ministério da Justiça e podem ser exibidos em qualquer horário.</p>
                <p align="justify">Os programas ao vivo poderão ser classificados se apresentarem inadequações,
                    a partir de monitoramento ou denúncia.</p>
                <p align="justify">
                    <strong>Livre:</strong> Não expõe crianças a conteúdos potencialmente prejudiciais. Exibição
                    em qualquer horário.<br>
                    <strong>10 anos:</strong> Conteúdo violento ou linguagem inapropriada para crianças, ainda
                    que em menor intensidade. Exibição em qualquer horário.<br>
                    <strong>12 anos:</strong> As cenas podem conter agressão física, consumo de drogas e
                    insinuação sexual. Exibição a partir das 20h.<br>
                    <strong>14 anos:</strong> Conteúdos mais violentos e/ou de linguagem sexual mais acentuada.
                    Exibição a partir das 21h.<br>
                    <strong>16 anos:</strong> Conteúdos mais violentos ou com conteúdo sexual mais intenso, com
                    cenas de tortura, suicídio, estupro ou nudez total. Exibição a partir das 22h.<br>
                    <strong>18 anos:</strong> Conteúdos violentos e sexuais extremos. Cenas de sexo, incesto ou
                    atos repetidos de tortura, mutilação ou abuso sexual. Exibição a partir das 23h.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- modal público -->
<div class="modal fade" id="modalPublico" style="display: none" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Público (Representatividade e Visibilidade Sócio-cultural)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" style="text-align: left;">
                <table class="table table-bordered table-responsive">
                    <thead>
                    <tr>
                        <th>Público</th>
                        <th>Descrição</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $oficinaObj->exibeDescricaoPublico() ?>
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


<script>
    let fomento = $('.fomento');

    fomento.on("change", verificaFomento);

    function verificaFomento() {
        if ($('#sim').is(':checked')) {
            $('#tipoFomento')
                .attr('disabled', false)
                .attr('required', true)
        } else {
            $('#tipoFomento')
                .attr('disabled', true)
                .attr('required', false)
        }
    }

    $(document).ready(
        verificaFomento(),
    );

    function publicoValidacao() {
        var isMsg = $('#msgEsconde');
        isMsg.hide();

        var i = 0;
        var counter = 0;
        var publico = $('.publicos');

        for (; i < publico.length; i++) {
            if (publico[i].checked) {
                counter++;
            }
        }

        if (counter == 0) {
            $('#cadastra').attr("disabled", true);
            isMsg.show();
            return false;
        }

        $('#cadastra').attr("disabled", false);
        isMsg.hide();
        return true;
    }

    $(document).ready(publicoValidacao);

    $('.publicos').on("change", publicoValidacao);
    $('.publicos').attr("name", "ev_publicos[]");
</script>