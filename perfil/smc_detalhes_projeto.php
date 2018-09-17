<?php
$con = bancoMysqli();

$idProjeto = isset($_POST['idProjeto']) ? $_POST['idProjeto'] : null;
if($idProjeto == null)
{
    $idProjeto = isset($_GET['idFF']) ? $_GET['idFF'] : null;
}
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$reserva = recuperaDados("reserva","idReserva",$idProjeto);


if(isset($_POST['gravarPrazos']))
{
    $idP = $_POST['IDP'];
    $prazoCaptacao = exibirDataMysql($_POST['prazoCaptacao']);
    $prorrogacaoCaptacao = $_POST['prorrogacaoCaptacao'];
    $finalCaptacao = exibirDataMysql($_POST['finalCaptacao']);
    $inicioExecucao = exibirDataMysql($_POST['inicioExecucao']);
    $fimExecucao = exibirDataMysql($_POST['fimExecucao']);
    $prorrogacaoExecucao = $_POST['prorrogacaoExecucao'];
    $finalProjeto = exibirDataMysql($_POST['finalProjeto']);
    $prestarContas = exibirDataMysql($_POST['prestarContas']);

    $prazos = recuperaDados("prazos_projeto","idProjeto",$idP);
    if($prazos == NULL)
    {
        $sql_insere = "INSERT INTO prazos_projeto (idProjeto, prazoCaptacao, prorrogacaoCaptacao, finalCaptacao, inicioExecucao, fimExecucao, prorrogacaoExecucao, finalProjeto, prestarContas) VALUES ('$idP', '$prazoCaptacao', '$prorrogacaoCaptacao', '$finalCaptacao', '$inicioExecucao', '$fimExecucao', '$prorrogacaoExecucao', '$finalProjeto', '$prestarContas')";
        if(mysqli_query($con,$sql_insere))
        {
            $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Utilize o menu para avançar.</strong></font>";
            echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
            gravarLog($sql_insere);
        }
        else
        {
            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
        }
    }
    else
    {
        $sql_edita = "UPDATE prazos_projeto SET
        prazoCaptacao = '$prazoCaptacao',
        prorrogacaoCaptacao = '$prorrogacaoCaptacao',
        finalCaptacao = '$finalCaptacao',
        inicioExecucao = '$inicioExecucao',
        fimExecucao = '$fimExecucao',
        prorrogacaoExecucao = '$prorrogacaoExecucao',
        finalProjeto = '$finalProjeto',
        prestarContas = '$prestarContas'
        WHERE idProjeto = '$idP'";
        if(mysqli_query($con,$sql_edita))
        {
            $mensagem = "<font color='#01DF3A'><strong>Editado com sucesso!</strong></font>";
            echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
            gravarLog($sql_edita);
        }
        else
        {
            $mensagem = "<font color='#FF0000'><strong>Erro ao editar! Tente novamente.</strong></font>";
        }
    }
}

if(isset($_POST['gravarAdm']))
{
    $idP = $_POST['IDP'];
    $idStatus = $_POST['idStatus'];
    $valorAprovado = dinheiroDeBr($_POST['valorAprovado']);
    $idRenunciaFiscal = $_POST['idRenunciaFiscal'];
    $statusParecerista = $_POST['idStatusParecerista'];
    $statusProjetoProponente = array(5, 6, 12, 21, 22, 26, 27, 28, 32, 33, 16, 17, 18);
    if($_POST['dataReuniao'] == 0000-00-00)
    {
        $dataReuniao = '';
    }
    else
    {
        $dataReuniao = exibirDataMysql($_POST['dataReuniao']);
    }
    if($_POST['dataPublicacaoDoc'] == 0000-00-00)
    {
        $dataPublicacaoDoc = '';
    }
    else
    {
        $dataPublicacaoDoc = exibirDataMysql($_POST['dataPublicacaoDoc']);
    }
    $linkPublicacaoDoc = $_POST['linkPublicacaoDoc'];
    $data = date('Y-m-d h:i:s');
    $idUsuario = $_SESSION['idUser'];
    $sql_gravarAdm = "UPDATE projeto SET idStatus = '$idStatus', valorAprovado = '$valorAprovado', idRenunciaFiscal = '$idRenunciaFiscal', idStatusParecerista = '$statusParecerista', dataReuniao = '$dataReuniao', dataPublicacaoDoc = '$dataPublicacaoDoc', linkPublicacaoDoc = '$linkPublicacaoDoc' WHERE idProjeto = '$idP' ";
    if(mysqli_query($con,$sql_gravarAdm))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
        gravarLog($sql_gravarAdm);
        if($dataReuniao != '' || $statusParecerista != 0)
        {
            $sql_historico_reuniao = "INSERT INTO historico_reuniao (idProjeto,idStatus,dataReuniao,idStatusParecerista,data,idUsuario) VALUES ('$idP','$idStatus','$dataReuniao','$statusParecerista','$data','$idUsuario')";
            if(mysqli_query($con,$sql_historico_reuniao))
            {
                $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";

                if (in_array($idStatus, $statusProjetoProponente))
                {
                    $sqlParecerista = "UPDATE projeto SET idComissao = '0' WHERE idProjeto = '$idP'";
                    mysqli_query($con, $sqlParecerista);
                }

                echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
                gravarLog($sql_historico_reuniao);
            }
            else
            {
                $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
            }
        }
        if($dataPublicacaoDoc != '' || $linkPublicacaoDoc != '')
        {
            $sql_historico_publicacao = "INSERT INTO historico_publicacao (idProjeto,idStatus,dataPublicacao,linkPublicacao,data,idUsuario) VALUES ('$idP','$idStatus','$dataPublicacaoDoc','$linkPublicacaoDoc','$data','$idUsuario')";
            if(mysqli_query($con,$sql_historico_publicacao))
            {
                $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";

                if (in_array($idStatus, $statusProjetoProponente))
                {
                    $sqlParecerista = "UPDATE projeto SET idComissao = '0' WHERE idProjeto = '$idP'";
                    mysqli_query($con, $sqlParecerista);
                }

                echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
                gravarLog($sql_historico_publicacao);
            }
            else
            {
                $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
            }
        }
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['envioComissao']))
{
    $idProjeto = $_POST['idProjeto'];
    $projeto = recuperaDados("projeto","idProjeto",$idProjeto);
    $idStatus = $projeto['idStatus'];

    switch ($idStatus) {
        case 2:
            $statusEnvio = 7;
            break;
        case 10:
            $statusEnvio = 7;
            break;
        case 13:
            $statusEnvio = 19;
            break;
        case 20:
            $statusEnvio = 19;
            break;
        case 14:
            $statusEnvio = 34;
            break;
        case 15:
            $statusEnvio = 34;
            break;
        case 23:
            $statusEnvio = 24;
            break;
        case 25:
            $statusEnvio = 24;
            break;
        case 29:
            $statusEnvio = 30;
            break;
        case 31:
            $statusEnvio = 30;
            break;
    }
    $dateNow = date('Y:m:d h:i:s');
    $sql_envioComissao = "UPDATE projeto SET idStatus = '$statusEnvio', envioComissao = '$dateNow' WHERE idProjeto = '$idProjeto' ";
    if(mysqli_query($con,$sql_envioComissao))
    {
        $sql_historico = "INSERT INTO historico_status (idProjeto, idStatus, data) VALUES ('$idProjeto', '$statusEnvio', '$dateNow')";
        $query_historico = mysqli_query($con, $sql_historico);
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
       // echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idProjeto';</script>";
        gravarLog($sql_historico);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['removerIncentivador'])){
    $idP = $_POST['IDP'];
    $idIncentivadorProjeto = $_POST['IIP'];

    $sql_removeIncentivador = "UPDATE incentivador_projeto SET publicado = 0 WHERE idIncentivadorProjeto = '$idIncentivadorProjeto'";

    if(mysqli_query($con, $sql_removeIncentivador))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
        gravarLog($sql_gravarFin);
    }

    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['gravarFin']))
{
    $idP = $_POST['IDP'];
    $valorAprovado = dinheiroDeBr($_POST['valorAprovado']);
    $renunciaFiscal = $_POST['idRenunciaFiscal'];
    $processoSei = $_POST['processoSei'];
    $assinaturaTermo = exibirDataMysql($_POST['assinaturaTermo']);
    $observacoes = $_POST['observacoes'];
    $agencia = $_POST['agencia'];
    $contaMovimentacao = $_POST['contaMovimentacao'];
    $contaCaptacao = $_POST['contaCaptacao'];

    $sql_gravarFin = "UPDATE projeto SET valorAprovado = '$valorAprovado', idRenunciaFiscal = '$renunciaFiscal', processoSei = '$processoSei', assinaturaTermo = '$assinaturaTermo', observacoes = '$observacoes', agencia = '$agencia', contaMovimentacao = '$contaMovimentacao', contaCaptacao = '$contaCaptacao' WHERE idProjeto = '$idP' ";
    if(mysqli_query($con,$sql_gravarFin))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
        gravarLog($sql_gravarFin);
    }

    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['gravarNota']))
{
    $idP = $_POST['IDP'];
    if ($idP != 0)
    {
        $dateNow = date('Y:m:d h:i:s');
        $nota = addslashes($_POST['nota']);
        $sql_nota = "INSERT INTO notas (idProjeto, data, nota, interna) VALUES ('$idP', '$dateNow', '$nota', '0')";
        if(mysqli_query($con,$sql_nota))
        {
            $mensagem = "<font color='#01DF3A'><strong>Nota inserida com sucesso!</strong></font>";
            echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
            gravarLog($sql_nota);
        }
        else
        {
            $mensagem = "<font color='#FF0000'><strong>Erro ao inserir nota! Tente novamente.</strong></font>";
        }
    }
}

if(isset($_POST['apagaIncentivador']))
{
    $tipoPessoa = $_POST['tipoPessoa'];
    $idIncentivador = $_POST['idIncentivador'];

    $sql = "UPDATE incentivador_projeto SET publicado = '0' WHERE idIncentivador = '$idIncentivador'";
    if (mysqli_query($con, $sql))
    {
        $mensagem = "<font color='#01DF3A'><strong>Incentivador removido com sucesso!</strong></font>";
        gravarLog($sql);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao remover incentivador! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['insereReserva']))
{
    $sql = "INSERT INTO reserva (idProjeto, data, valor, numeroReserva)
            VALUES ('$idProjeto', '$data', '$valor' '$numeroReserva')";
    if (mysqli_query($con, $sql))
    {
        $mensagem = "<font color='#01DF3A'><strong>Reserva inserida com sucesso!</strong></font>";
        gravarLog($sql);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao inserir reserva! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['editarReserva'])){
    $idR = $_POST['IDR'];
    $data = exibirDataMysql($_POST['data']);
    $valor = $_POST['valor'];
    $numeroReserva = $_POST['numeroReserva'];
    
    $sql = "UPDATE reserva SET data = '$data', valor = '$valor', numeroReserva = '$numeroReserva' WHERE idReserva = '$idR'";
    
    if(mysqli_query($con,$sql)){
        $mensagem = "<font color='#01DF3A'><strong>Reserva cadastrada com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
        gravarLog($sql);
    }else{
        $mensagem = "<font color='#FF0000'><strong>Erro ao cadastrar!
        </strong></font>";
    }
}

if($projeto['tipoPessoa'] == 1)
{
    $pf = recuperaDados("pessoa_fisica","idPf",$projeto['idPf']);
}
else
{
    $pj = recuperaDados("pessoa_juridica","idPj",$projeto['idPj']);
}

if(isset($_POST['editarParecer'])){

    $status = $_POST['status'];
    $observacoes = $_POST['observacoes'];
    $idProjeto = $_POST['idPessoa'];
    $idArquivo = $_POST['idArquivo'];

    $query = "UPDATE upload_arquivo SET idStatusDocumento = '".$status."', observacoes = '".$observacoes."' WHERE idUploadArquivo = '".$idArquivo."' ";
        $envia = mysqli_query($con, $query);
        if($envia)
        {
            echo "<script>window.location.href = 'index_pf.php?perfil=smc_detalhes_projeto&idFF=".$idProjeto."';</script>";
            $mensagem = "<font color='#01DF3A'><strong>Os arquivos foram atualizados com sucesso!</strong></font>";
        }
        else
        {
            echo "<script>window.location.href = 'index_pf.php?perfil=smc_detalhes_projeto&idFF=".$idProjeto."';</script>";
            echo "<script>alert('Erro durante o processamento, entre em contato com os responsáveis pelo sistema para maiores informações.')</script>";
        }

}



$representante = pegaProjetoRepresentante($idProjeto);
$pessoaFisica = pegaProjetoPessoaFisica($idProjeto);

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$prazos = recuperaDados("prazos_projeto","idProjeto",$idProjeto);
$area = recuperaDados("area_atuacao","idArea",$projeto['idAreaAtuacao']);
$renuncia = recuperaDados("renuncia_fiscal","idRenuncia",$projeto['idRenunciaFiscal']);
$cronograma = recuperaDados("cronograma","idCronograma",$projeto['idCronograma']);
$video = recuperaDados("projeto","idProjeto",$idProjeto);
$v = array($video['video1'], $video['video2'], $video['video3']);
$data_reuniao = recuperaDados("data_reuniao", "idProjeto", $idProjeto);

$comissao = recuperaDados("pessoa_fisica","idPf",$projeto['idComissao']);
?>

<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include 'includes/menu_smc.php'; ?>
        <div class="form-group">
            <h4>Ambiente Coordenadoria</h4>
            <h6><?= $projeto['nomeProjeto'] ?></h6>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div role="tabpanel">
                    <!-- LABELS -->
                    <ul class="nav nav-tabs">
                        <li class="nav active"><a href="#adm" data-toggle="tab">Administrativo</a></li>
                        <li class="nav"><a href="#projeto" data-toggle="tab">Projeto</a></li>
                        <?php if(isset($representante)):?>
                        <li class="nav"><a href="#J" data-toggle="tab">Pessoa Jurídica</a></li>
                        <?php else: ?>
                        <li class="nav"><a href="#F" data-toggle="tab">Pessoa Física</a></li>
                        <?php endif ?>
                        <li class="nav"><a href="#prazo" data-toggle="tab">Prazos</a></li>
                        <li class="nav"><a href="#financeiro" data-toggle="tab">Financeiro</a></li>
                        <li class="nav"><a href="#pagamentos" data-toggle="tab">Pagamentos</a></li>
                        <li class="nav"><a href="#historico" data-toggle="tab">Histórico</a></li>
                    </ul>
                    <div class="tab-content">

                        <!-- LABEL ADMINISTRATIVO-->
                        <?php include "includes/label_smc_adm.php"; ?>


                        <!-- LABEL PROJETO -->
                        <?php include "includes/label_projeto.php"; ?>


                        <!-- LABEL PESSOA JURÍDICA -->
                        <?php include "includes/label_smc_pj.php"; ?>


                        <!--LABEL PESSOA FISICA-->
                        <?php include "includes/label_smc_pf.php"; ?>


                        <!-- LABEL PRAZOS -->
                        <?php include "includes/label_smc_prazo.php"; ?>


                        <!-- LABEL PAGAMENTOS -->
                        <?php include "includes/label_smc_pagamento.php"; ?>


                        <!-- LABEL HISTÓRICO -->
                        <?php include "includes/label_historico.php"; ?>


                        <!-- LABEL FINANCEIRO -->
                        <?php include "includes/label_smc_financeiro.php"; ?>

</section>
