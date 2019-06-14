<?php

$con = bancoMysqli();
$idPf = $_SESSION['idUser'];
$tipoPessoa = 4;

$pf = recuperaDados("incentivador_pessoa_fisica", "idPf", $idPf);
$etapaArray = recuperaDados("etapas_incentivo", "idIncentivador", $idPf);

$liberado = $pf['liberado'];
$etapa = $etapaArray['etapa'];

switch ($liberado) {
    case '4':
        $statusIncentivador = "Status da Análise de Regularidade Fiscal do Incentivador: Em análise";
        $cor_status = "warning";
        break;
    case '5':
        $statusIncentivador = "APTO - Incentivador não possui irregularidades fiscais, estando apto para incentivar projetos do PROMAC";
        $cor_status = "success";
        break;
    case '6':
        $statusIncentivador = "INAPTO - Incentivador possui irregularidades fiscais, não estando apto para incentivar projetos do <b>PROMAC</b>. <br> Regularize suas pendências para que possamos dar continuidade ao processo de incentivo fiscal";
        $cor_status = "danger";
        break;
}


switch ($etapa) {
case '':
    ?>
    <div class="well">
        <label for="admResposta">Você deseja incentivar um projeto agora?</label><br>
        <input type="radio" name="admResposta" value="1" class="resposta" id="sim"> Sim
        <input type="radio" name="admResposta" value="0" class="resposta" id="nao" checked> Não

        <div id="aviso" style="display: none;">
            <hr>
            <div class='alert alert-warning'>
                Para encontrar um projeto para incentivar, continue buscando os projetos aprovados semanalmente na
                Consulta Pública disponível na Home do site PROMAC.<br> Depois de escolher o projeto que deseja
                incentivar, retorne a essa página, por gentileza.
            </div>
        </div>
        <div id="incentivar" style="display: none;">
            <br>
            <form method="post" action="?perfil=includes/documentos_fiscais_incentivador_pf" class="form-group">
                <input type="submit" name="iniciar_incentivo" value="Iniciar incentivo" class="btn btn-success">
            </form>
        </div>
    </div>
    <?php
    break;
case '1':
    echo "<script>location.href = '?perfil=incentivar_projeto/documentos_fiscais_incentivador_pf'</script>";
    break;

case '2':
case '3':
    echo "<script>location.href = '?perfil=incentivar_projeto/incentivadorPF_etapa3_visualiza_docs'</script>";
    break;

    case '4':
        echo "<script>location.href = '?perfil=incentivar_projeto/incentivador_etapa4_buscarProjeto&tipoPessoa=$tipoPessoa'</script>";
        break;

    case '6':
        echo "<script>location.href = '?perfil=incentivar_projeto/incentivador_etapa6_incentivarProjeto&tipoPessoa=$tipoPessoa'</script>";
        break;

}

?>

<script>

    var resposta = $('.resposta');
    resposta.on("click", verificaResposta);
    $(document).ready(verificaResposta());

    function verificaResposta() {
        if ($('#nao').is(':checked')) {
            $('#aviso').css('display', 'block');
            $('#incentivar').css('display', 'none');
        } else if ($('#sim').is(':checked')) {
            $('#aviso').css('display', 'none');
            $('#incentivar').css('display', 'block');
            // location.href = '?perfil=includes/documentos_fiscais_incentivador_pf'
        }
    }
</script>