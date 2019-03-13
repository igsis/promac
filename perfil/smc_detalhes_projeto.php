<?php
$con = bancoMysqli();

$idProjeto = isset($_POST['idProjeto']) ? $_POST['idProjeto'] : null;

if($idProjeto == null)
{
    $idProjeto = isset($_GET['idFF']) ? $_GET['idFF'] : null;
}
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$reserva = recuperaDados("reserva","idReserva",$idProjeto);
$idListaDocumento = '37';
$tipoPessoa = '9';

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
            gravarLog($sql_insere);
            echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
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
            gravarLog($sql_edita);
            echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
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
    $valorAprovado = dinheiroDeBr($_POST['valorAprovado']);
    $idRenunciaFiscal = $_POST['idRenunciaFiscal'];
    $statusParecerista = $_POST['idStatusParecerista'];
    $statusProjetoProponente = array(5, 6, 12, 21, 22, 26, 27, 28, 32, 33, 16, 17);
    if($_POST['dataReuniao'] == 0000-00-00)
    {
        $dataReuniao = '';
    }
    else
    {
        $dataReuniao = exibirDataMysql($_POST['dataReuniao']);
    }
//    if($_POST['dataPublicacaoDoc'] == 0000-00-00)
//    {
//        $dataPublicacaoDoc = '';
//    }
//    else
//    {
//        $dataPublicacaoDoc = exibirDataMysql($_POST['dataPublicacaoDoc']);
//    }
    $data = date('Y-m-d H:i:s');
    $idUsuario = $_SESSION['idUser'];
    $sql_gravarAdm = "UPDATE projeto SET valorAprovado = '$valorAprovado', idRenunciaFiscal = '$idRenunciaFiscal', idStatusParecerista = '$statusParecerista', dataReuniao = '$dataReuniao' WHERE idProjeto = '$idP' ";
    if(mysqli_query($con,$sql_gravarAdm))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        gravarLog($sql_gravarAdm);
        echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
        if($dataReuniao != '' || $statusParecerista != 0)
        {
            $sql_historico_reuniao = "INSERT INTO historico_reuniao (idProjeto,idEtapaProjeto,dataReuniao,idStatusParecerista,data,idUsuario) VALUES ('$idP','$idStatus','$dataReuniao','$statusParecerista','$data','$idUsuario')";
            if(mysqli_query($con,$sql_historico_reuniao))
            {
                $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";

                gravarLog($sql_historico_reuniao);
                echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
            }
            else
            {
                $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
            }
        }
//        if($dataPublicacaoDoc != '' || $linkPublicacaoDoc != '')
//        {
//            $sql_historico_publicacao = "INSERT INTO historico_publicacao (idProjeto,idEtapaProjeto,dataPublicacao,linkPublicacao,data,idUsuario) VALUES ('$idP','$idStatus','$dataPublicacaoDoc','$linkPublicacaoDoc','$data','$idUsuario')";
//            if(mysqli_query($con,$sql_historico_publicacao))
//            {
//                $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
//
//                gravarLog($sql_historico_publicacao);
//                echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
//            }
//            else
//            {
//                $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
//            }
//        }
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['aprovaProjeto']))
{
    $idProjeto = $_POST['idProjeto'];
    $idEtapaProjeto = $_POST['idEtapaProjeto'];
    switch ($idEtapaProjeto){
        case 10:
            $idEtapaNova = 5;
            $etapa = recuperaDados("etapa_projeto","idEtapaProjeto",$idEtapaNova);
            $idStatus = $etapa['idStatus'];
            $etapaValida = true;
            break;
        case 20:
            $idEtapaNova = 21;
            $etapa = recuperaDados("etapa_projeto","idEtapaProjeto",$idEtapaNova);
            $idStatus = $etapa['idStatus'];
            $etapaValida = true;
            break;
        case 25:
            $idEtapaNova = 26;
            $etapa = recuperaDados("etapa_projeto","idEtapaProjeto",$idEtapaNova);
            $idStatus = $etapa['idStatus'];
            $etapaValida = true;
            break;
        case 15:
            $idEtapaNova = 16;
            $etapa = recuperaDados("etapa_projeto","idEtapaProjeto",$idEtapaNova);
            $idStatus = $etapa['idStatus'];
            $etapaValida = true;
            break;
        default:
            $etapaValida = false;
            break;
    }
    if ($etapaValida) {
        $dateNow = date('Y-m-d H:i:s');
        $sql_reprova = "UPDATE projeto SET idEtapaProjeto = '$idEtapaNova', idStatus = '$idStatus' WHERE idProjeto = '$idProjeto'";
        if (mysqli_query($con, $sql_reprova)) {
            $sql_historico = "INSERT INTO historico_etapa (idProjeto, idEtapaProjeto, data) VALUES ('$idProjeto', '$idEtapaNova', '$dateNow')";
            $query_historico = mysqli_query($con, $sql_historico);
            $mensagem = "<font color='#01DF3A'><strong>Aprovado com sucesso!</strong></font>";
            gravarLog($sql_historico);
            gravarLog($sql_reprova);
        } else {
            $mensagem = "<font color='#FF0000'><strong>Erro ao aprovar! Tente novamente.</strong></font>";
        }
    } else {
        $mensagem = "<font color='#FF0000'><strong>Projeto já aprovado.</strong></font>";
    }
}

if(isset($_POST['reprovaProjeto']))
{
    $idProjeto = $_POST['idProjeto'];
    $idEtapaProjeto = $_POST['idEtapaProjeto'];
    switch ($idEtapaProjeto){
        case 10:
            $idEtapaNova = 6;
            $etapa = recuperaDados("etapa_projeto","idEtapaProjeto",$idEtapaNova);
            $idStatus = $etapa['idStatus'];
            $etapaValida = true;
            break;
        case 20:
            $idEtapaNova = 22;
            $etapa = recuperaDados("etapa_projeto","idEtapaProjeto",$idEtapaNova);
            $idStatus = $etapa['idStatus'];
            $etapaValida = true;
            break;
        case 25:
            $idEtapaNova = 27;
            $etapa = recuperaDados("etapa_projeto","idEtapaProjeto",$idEtapaNova);
            $idStatus = $etapa['idStatus'];
            $etapaValida = true;
            break;
        case 15:
            $idEtapaNova = 17;
            $etapa = recuperaDados("etapa_projeto","idEtapaProjeto",$idEtapaNova);
            $idStatus = $etapa['idStatus'];
            $etapaValida = true;
            break;
        default:
            $etapaValida = false;
            break;
    }
    if ($etapaValida) {
        $dateNow = date('Y-m-d H:i:s');
        $sql_reprova = "UPDATE projeto SET idEtapaProjeto = '$idEtapaNova', idStatus = '$idStatus' WHERE idProjeto = '$idProjeto'";
        if (mysqli_query($con, $sql_reprova)) {
            $sql_historico = "INSERT INTO historico_etapa (idProjeto, idEtapaProjeto, data) VALUES ('$idProjeto', '$idEtapaNova', '$dateNow')";
            $query_historico = mysqli_query($con, $sql_historico);
            $mensagem = "<font color='#01DF3A'><strong>Reaprovado com sucesso!</strong></font>";
            gravarLog($sql_historico);
            gravarLog($sql_reprova);
        } else {
            $mensagem = "<font color='#FF0000'><strong>Erro ao reaprovar! Tente novamente.</strong></font>";
        }
    } else {
        $mensagem = "<font color='#FF0000'><strong>Projeto já reprovado.</strong></font>";
    }
}

if(isset($_POST['complementaProjeto']))
{
    $idProjeto = $_POST['idProjeto'];
    $idEtapaProjeto = $_POST['idEtapaProjeto'];

    $idEtapaNova = 12;
    $etapa = recuperaDados("etapa_projeto","idEtapaProjeto",$idEtapaNova);
    $idStatus = $etapa['idStatus'];

    $dateNow = date('Y-m-d H:i:s');
    $sql_complementa = "UPDATE projeto SET idEtapaProjeto = '$idEtapaNova', idStatus = '$idStatus' WHERE idProjeto = '$idProjeto'";
    if(mysqli_query($con,$sql_complementa))
    {
        $sql_historico = "INSERT INTO historico_etapa (idProjeto, idEtapaProjeto, data) VALUES ('$idProjeto', '$idEtapaNova', '$dateNow')";
        $query_historico = mysqli_query($con, $sql_historico);
        $mensagem = "<font color='#01DF3A'><strong>Solicitação de complemento de informação gravada com sucesso!</strong></font>";
        gravarLog($sql_historico);
        gravarLog($sql_complementa);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao gravar a solicitação de complemento de informação! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['envioComissao']))
{
    $dateNow = date('Y-m-d H:i:s');
    $idProjeto = $_POST['idProjeto'];
    $projeto = recuperaDados("projeto","idProjeto",$idProjeto);
    $idEtapaProjeto = $projeto['idEtapaProjeto'];
    $dataParecerista = $dateNow;
    $semanaAtual = date('W');
    $semana = recuperaDados('contagem_comissao', 'semana', $semanaAtual);
    $projetos = $semana['projetos'];

    if ($projetos == 0)
    {
        $con->query("UPDATE contagem_comissao SET projetos = '0' WHERE semana != $semanaAtual");
    }

    switch ($idEtapaProjeto) {
        case 2:
            $etapaProjeto = 7;
            $etapaValida = true;
            $dataParecerista = "0000-00-00";
            break;
        case 10:
            $etapaProjeto = 7;
            $etapaValida = true;
            break;
        case 13:
            $etapaProjeto = 19;
            $etapaValida = true;
            break;
        case 20:
            $etapaProjeto = 19;
            $etapaValida = true;
            break;
        case 14:
            $etapaProjeto = 34;
            $etapaValida = true;
            break;
        case 15:
            $etapaProjeto = 34;
            $etapaValida = true;
            break;
        case 23:
            $etapaProjeto = 24;
            $etapaValida = true;
            break;
        case 25:
            $etapaProjeto = 24;
            $etapaValida = true;
            break;
        default:
            $etapaValida = false;
            break;
    }

    if ($etapaValida) {
        $sql_envioComissao = "UPDATE projeto SET idEtapaProjeto = '$etapaProjeto', idStatus = 2, dataParecerista = '$dataParecerista', envioComissao = '$dateNow' WHERE idProjeto = '$idProjeto' ";
        if (mysqli_query($con, $sql_envioComissao)) {
            $sql_contagem_comissao = "UPDATE `contagem_comissao` SET `projetos` = '" . ($projetos + 1) . "' WHERE `semana` = '$semanaAtual'";
            $con->query($sql_contagem_comissao);
            $sql_historico = "INSERT INTO historico_etapa (idProjeto, idEtapaProjeto, data) VALUES ('$idProjeto', '$etapaProjeto', '$dateNow')";
            $query_historico = mysqli_query($con, $sql_historico);
            $mensagem = "<font color='#01DF3A'><strong>Enviado com sucesso!</strong></font>";
            gravarLog($sql_historico);
            gravarLog($sql_envioComissao);
        } else {
            $mensagem = "<font color='#FF0000'><strong>Erro ao enviar! Tente novamente.</strong></font>";
        }
    } else {
        $mensagem = "<font color='#FF0000'><strong>Projeto já enviado.</strong></font>";
    }
}

if(isset($_POST['removerIncentivador'])){
    $idP = $_POST['IDP'];
    $idIncentivadorProjeto = $_POST['IIP'];

    $sql_removeIncentivador = "UPDATE incentivador_projeto SET publicado = 0 WHERE idIncentivadorProjeto = '$idIncentivadorProjeto'";

    if(mysqli_query($con, $sql_removeIncentivador))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        gravarLog($sql_gravarFin);
        gravarLog($sql_removeIncentivador);
        echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
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
        gravarLog($sql_gravarFin);
        echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
    }

    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
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
        gravarLog($sql);
        echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
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
    $representante = recuperaDados("representante_legal","idRepresentanteLegal",$pj['idRepresentanteLegal']);
}

if(isset($_POST['editarParecer'])){
    $status = $_POST['status'];
    $observacoes = $_POST['observacoes'];
    $idProjeto = $_POST['idPessoa'];
    $idArquivo = $_POST['idArquivo'];
    $idDisponibilizar = $_POST['idDisponib'];
    $dataDisponivel = exibirDataMysql($_POST['dataDisponivel']) ?? NULL;
    $query = "UPDATE upload_arquivo SET idStatusDocumento = '$status', observacoes = '$observacoes' WHERE idUploadArquivo = '$idArquivo' ";
    $envia = mysqli_query($con, $query);
    if($envia)
    {
        if ($idDisponibilizar == "")
        {
            $sql_data = "INSERT INTO disponibilizar_documento (idUploadArquivo, data) VALUES ('$idArquivo', '$dataDisponivel')";
        }
        else
        {
            $sql_data = "UPDATE disponibilizar_documento SET data = '$dataDisponivel' WHERE idUploadArquivo = '$idArquivo' AND id ='$idDisponibilizar' ";
        }
        $query_data = mysqli_query($con,$sql_data);
        //echo "<script>window.location.href = 'index_pf.php?perfil=smc_detalhes_projeto&idFF=".$idProjeto."';</script>";
        $mensagem = "<font color='#01DF3A'><strong>Os arquivos foram atualizados com sucesso!</strong></font>";
    }
    else
    {
        echo "<script>window.location.href = 'index_pf.php?perfil=smc_detalhes_projeto&idFF=".$idProjeto."';</script>";
        echo "<script>alert('Erro durante o processamento, entre em contato com os responsáveis pelo sistema para maiores informações.')</script>";
    }
}

if(isset($_POST['apagar']))
{
    $idArquivo = $_POST['apagar'];
    $sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE idUploadArquivo = '$idArquivo'";
    if(mysqli_query($con,$sql_apagar_arquivo))
    {
        $mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
        gravarLog($sql_apagar_arquivo);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
    }
}

if(isset($_POST["enviar"]))
{
    $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '$tipoPessoa'";
    $query_arquivos = mysqli_query($con,$sql_arquivos);
    while($arq = mysqli_fetch_array($query_arquivos))
    {
        $y = $arq['idListaDocumento'];
        $x = $arq['sigla'];
        $nome_arquivo = isset($_FILES['arquivo']['name'][$x]) ? $_FILES['arquivo']['name'][$x] : null;
        $f_size = isset($_FILES['arquivo']['size'][$x]) ? $_FILES['arquivo']['size'][$x] : null;

        //Extensões permitidas
        $ext = array("PDF","pdf"); 
        
        if($f_size > 5242880) // 5MB em bytes
        {
            $mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></font>";
        }
        else
        {
            if($nome_arquivo != "")
            {
                $nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
                $new_name = date("YmdHis")."_".semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
                $hoje = date("Y-m-d H:i:s");
                $dir = '../uploadsdocs/'; //Diretório para uploads
                $allowedExts = array(".pdf", ".PDF"); //Extensões permitidas
                $ext = strtolower(substr($nome_arquivo,-4));

                if(in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas
                {
                    if(move_uploaded_file($nome_temporario, $dir.$new_name))
                    {
                        $sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipo`, `idPessoa`, `idListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idProjeto', '$y', '$new_name', '$hoje', '1'); ";
                        $query = mysqli_query($con,$sql_insere_arquivo);
                        if($query)
                        {
                            $idUploadArquivo = recuperaUltimo("upload_arquivo");
                            $sql_insere_data = "INSERT INTO disponibilizar_documento (idUploadArquivo) VALUES ($idUploadArquivo)";
                            $query_insere_data = mysqli_query($con,$sql_insere_data);
                            echo $sql_insere_data;
                            $mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
                            gravarLog($sql_insere_arquivo);
                        }
                        else
                        {
                            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco.</strong></font>";
                        }
                    }
                    else
                    {
                        $mensagem = "<font color='#FF0000'><strong>Erro no upload! Tente novamente.</strong></font>";
                    }
                }
                else
                {
                    $mensagem = "<font color='#FF0000'><strong>Erro no upload! Anexar documentos somente no formato PDF.</strong></font>";
                }
            }
        }
    }
}

if(isset($_POST['cancelarProjeto'])){
    $idProjeto = $_POST['idProjeto'];
    $observacao= $_POST['observacao'];
    $idUser = $_SESSION['idUser'];
    $dateNow = date('Y-m-d H:i:s');

    $sql_cancelar = "UPDATE projeto SET idStatus = 6 WHERE idProjeto = '$idProjeto'";
    if(mysqli_query($con,$sql_cancelar)){
        gravarLog($sql_cancelar);
        $sql_historico_cancelamento = "INSERT INTO historico_cancelamento (idProjeto, observacao, idUsuario, data, acao) VALUES ('$idProjeto', '$observacao','$idUser','$dateNow',1)";
       if(mysqli_query($con,$sql_historico_cancelamento)){
           $mensagem = "<span style=\"color: #01DF3A; \"><strong>Projeto cancelado com sucesso!<br/>Aguarde....</strong></span>";
           gravarLog($sql_historico_cancelamento);
           echo "<meta HTTP-EQUIV='refresh' CONTENT='0.5;URL=?perfil=smc_index'>";
       }
       else{
           $mensagem = "<span style=\"color: #FF0000; \"><strong>Erro ao cancelar projeto. Tente novamente!</strong></span>";
       }
    }
}

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$prazos = recuperaDados("prazos_projeto","idProjeto",$idProjeto);
$area = recuperaDados("area_atuacao","idArea",$projeto['idAreaAtuacao']);
$renuncia = recuperaDados("renuncia_fiscal","idRenuncia",$projeto['idRenunciaFiscal']);
$cronograma = recuperaDados("cronograma","idCronograma",$projeto['idCronograma']);
$video = recuperaDados("projeto","idProjeto",$idProjeto);
$v = array($video['video1'], $video['video2'], $video['video3']);
$data_reuniao = recuperaDados("data_reuniao", "idProjeto", $idProjeto);

$etapa = recuperaDados("etapa_projeto","idEtapaProjeto",$projeto['idEtapaProjeto']);
$status = recuperaDados("etapa_status","idStatus",$projeto['idStatus']);

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
                        <li class="nav"><a href="#impressoes" data-toggle="tab">Impressões</a></li>
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
                    <div class="tab-content"><br/>
                        <!-- LABEL ADMINISTRATIVO-->
                        <?php include "includes/label_smc_adm.php"; ?>

                        <!-- LABEL IMPRESSÕES-->
                        <?php include "includes/label_impressoes.php"; ?>

                        <!-- LABEL PROJETO -->
                        <?php include "includes/label_projeto.php"; ?>

                        <!-- LABEL PESSOA JURÍDICA -->
                        <?php include "includes/label_pj.php"; ?>

                        <!--LABEL PESSOA FISICA-->
                        <?php include "includes/label_pf.php"; ?>

                        <!-- LABEL PRAZOS -->
                        <?php include "includes/label_smc_prazo.php"; ?>

                        <!-- LABEL PAGAMENTOS -->
                        <?php include "includes/label_smc_pagamento.php"; ?>

                        <!-- LABEL HISTÓRICO -->
                        <?php include "includes/label_historico.php"; ?>

                        <!-- LABEL FINANCEIRO -->
                        <?php include "includes/label_smc_financeiro.php"; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
