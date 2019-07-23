<?php
$con = bancoMysqli();
$idPj = $_SESSION['idUser'];
$tipoPessoa = '5';

$pj = recuperaDados("incentivador_pessoa_juridica", "idPj", $idPj);

$sqlProject = "SELECT idProjeto FROM etapas_incentivo WHERE tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idPj'";
$queryProject = mysqli_query($con, $sqlProject);
$arr = mysqli_fetch_assoc($queryProject);
$idProjeto = $arr['idProjeto'];

if($idProjeto != '') {
    $idProjeto = $idProjeto;
} else {
    $idProjeto = '';
}

$sqlEtapa = "SELECT etapa FROM etapas_incentivo WHERE idProjeto = '$idProjeto' AND idIncentivador = '$idPj' AND tipoPessoa = '$tipoPessoa'";
$queryEtapa = mysqli_query($con, $sqlEtapa);
$etapaArray = mysqli_fetch_assoc($queryEtapa);
$etapa = $etapaArray['etapa'];

$liberado = $pj['liberado'];
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
                <form method="post" action="?perfil=includes/documentos_fiscais_incentivador_pj" class="form-group">
                    <input type="submit" name="iniciar_incentivo" value="Iniciar incentivo" class="btn btn-success">
                </form>
            </div>
        </div>
        <?php
        break;

    case '1':
        echo "<script>location.href = '?perfil=includes/documentos_fiscais_incentivador_pj'</script>";
        break;

    case '2':
    case '3':
        echo "<script>location.href = '?perfil=includes/incentivadorPJ_etapa3_visualiza_docs'</script>";
        break;


    case '4':
        echo "<script>location.href = '?perfil=includes/incentivador_etapa4_buscarProjeto&tipoPessoa=$tipoPessoa'</script>";
        break;

    case '6':
        echo "<script>location.href = '?perfil=includes/incentivador_etapa6_incentivarProjeto&tipoPessoa=$tipoPessoa'</script>";
        break;

    case '7':
    case '8':
        echo "<script>location.href = '?perfil=includes/incentivador_etapa7_gerarContrato&tipoPessoa=$tipoPessoa'</script>";
        break;

    case '9':
    case '10':
    case '11':
        echo "<script>location.href = '?perfil=includes/incentivador_etapa9_verificaData&tipoPessoa=$tipoPessoa'</script>";
        break;

    case '12':
        echo "<script>location.href = '?perfil=includes/incentivador_etapa12_DAMSP&tipoPessoa=$tipoPessoa'</script>";
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
            // location.href = '?perfil=includes/documentos_fiscais_incentivador_pj'
        }
    }
</script>