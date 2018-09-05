<?php
$con = bancoMysqli();

$idProjeto = isset($_POST['idProjeto']) ? $_POST['idProjeto'] : null;
if($idProjeto == null
){
    $idProjeto = isset($_GET['idFF']) ? $_GET['idFF'] : null;
}
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$reserva = recuperaDados("reserva","idReserva",$idProjeto);


// Gerar documentos
$server = "http://".$_SERVER['SERVER_NAME']."/promac/";
$http = $server."/pdf/";
$link1 = $http."rlt_projeto.php";

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
    $dataPublicacaoDoc = exibirDataMysql($_POST['dataPublicacaoDoc']);
    $linkPublicacaoDoc = $_POST['linkPublicacaoDoc'];
    $sql_gravarAdm = "UPDATE projeto SET idStatus = '$idStatus', valorAprovado = '$valorAprovado', idRenunciaFiscal = '$idRenunciaFiscal', idStatusParecerista = '$statusParecerista', dataPublicacaoDoc = '$dataPublicacaoDoc', linkPublicacaoDoc = '$linkPublicacaoDoc' WHERE idProjeto = '$idP' ";
    if(mysqli_query($con,$sql_gravarAdm))

    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
        gravarLog($sql_gravarAdm);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['dataReuniao']))
{
    $idP = $_POST['IDP'];
    $dataReuniao = exibirDataMysql($_POST['dataReuniao']);
    $sql_dataReuniao = "INSERT INTO data_reuniao (idProjeto, dataReuniao) VALUES ('$idP', '$dataReuniao')";
    $sql_dataReuniaoAtualizar = "UPDATE projeto SET dataReuniao = '$dataReuniao' WHERE idProjeto = '$idP' ";
    if(mysqli_query($con,$sql_dataReuniao))
    if(mysqli_query($con,$sql_dataReuniaoAtualizar))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
        gravarLog($sql_dataReuniaoAtualizar);
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

if(isset($_POST['envioComissao']))
{
    $idP = $_POST['IDP'];
    $dateNow = date('Y:m:d h:i:s');
    $sql_envioComissaoAtualiza = "UPDATE projeto SET idStatus = '7', envioComissao = '$dateNow' WHERE idProjeto = '$idP' ";
    $sql_envioComissao = "INSERT INTO envio_comissao (idProjeto, data) VALUES ('$idP', '$dateNow')";    

    if(mysqli_query($con,$sql_envioComissao))
    if(mysqli_query($con,$sql_envioComissaoAtualiza))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        echo "<script>window.location = '?perfil=smc_detalhes_projeto&idFF=$idP';</script>";
        gravarLog($sql_envioComissao);
        gravarLog($sql_envioComissaoAtualiza);
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
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div role="tabpanel">
                    <!-- LABELS xura-->
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
                        <div role="tabpanel" class="tab-pane fade in active" id="adm">
                            <h5>
                                <?php if(isset($mensagem)){echo $mensagem;}; ?>
                            </h5>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-3" align="right"><br/><label>Enviar projeto para comissão</label><br>
                                    <?php echo exibirDataHoraBr($projeto['envioComissao'])?>
                                </div>
                                <div class="col-md-1"><br/>
                                     <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                                        <input type='hidden' name='IDP' value='<?php echo $idProjeto?>'>
                                        <input type="submit" name="envioComissao" class="btn btn-theme btn-lg btn-block" value="Sim">
                                    </form>
                                </div>
                            </div>

                            <!-- Se existir um parecerista -->
                            <?php if($projeto['idComissao'] > 0): ?>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8" align="left"><br/>
                                        <strong>Parecerista Responsável:</strong> <?php echo isset($comissao['nome']) ? $comissao['nome'] : null ?>
                                    </div>
                                </div>
                            <?php endif ?>

                            <div class="form-group">
                               <div class="col-md-offset-0 col-md-12"><hr/></div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-4 col-md-4">
                                    <?php
                                    $id = $projeto['tipoPessoa'];
                                    $idP = $projeto['idProjeto'];
                                    if($id == 1)
                                    {
                                        $idPess = $projeto['idPf'];
                                    } else if($id == 2)
                                    {
                                        $idPess = $projeto['idPj'];
                                    }
                                    ?>
                                    <a href='<?php echo "../pdf/gera_pdf.php?tipo=$id&projeto=$idP&pessoa=$idPess"; ?>' target='_blank' class="btn btn-theme btn-md btn-block"><strong>Gerar PDF do Projeto</strong></a><br/>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <hr/>
                                </div>
                            </div>

                            <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-4"><label>Etapa do Projeto</label><br/>
                                        <select class="form-control" name="idStatus">
                                        <?php echo geraOpcao("status",$projeto['idStatus']) ?>
                                    </select>
                                    </div>
                                    <div class="col-md-4"><label>Valor Aprovado</label><br/>
                                        <input type="text" name="valorAprovado" id='valor' class="form-control" value="<?php echo dinheiroParaBr($projeto['valorAprovado']) ?>">
                                    </div>                                  
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-4"><label>Valor Renúncia</label><br/>
                                        <select class="form-control" name="idRenunciaFiscal">
                                            <?php echo geraOpcao("renuncia_fiscal",$projeto['idRenunciaFiscal']) ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6"><label>Status de Análise</label><br/>
                                        <select class="form-control" name="idStatusParecerista">
                                                <option value="0"></option>
                                            <?php echo geraOpcao("status_parecerista",$projeto['idStatusParecerista']) ?>
                                        </select>
                                    </div>
                                </div>

                                 <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8"><label>Data Publicação DOC</label>
                                        <input type="text" name="dataPublicacaoDoc" id='datepicker09' class="form-control" placeholder="DD/MM/AA ou MM/AAAA" required value="<?php echo exibirDataBr($projeto['dataPublicacaoDoc']) ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">    
                                   <div class="col-md-offset-2 col-md-8"><label>Link Publicação DOC</label>
                                        <input type="text" name="linkPublicacaoDoc" class="form-control" value="<?php echo $projeto['linkPublicacaoDoc'] ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <?php echo "<input type='hidden' name='IDP' value='$idProjeto'>"; ?>
                                        <input type="submit" name="gravarAdm" class="btn btn-theme btn-md btn-block" value="Gravar">
                                    </div>
                                </div>
                            </form>
                            <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                                <div class="form-group">
                                   <div class="col-md-offset-2 col-md-8"><label>Data da Reunião</label>
                                        <input type="text" name="dataReuniao" id='datepicker08' class="form-control" placeholder="DD/MM/AA ou MM/AAAA" required value="<?php echo exibirDataBr($projeto['dataReuniao']) ?>">
                                    </div>
                                </div>    

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <?php echo "<input type='hidden' name='IDP' value='$idProjeto'>"; ?>
                                        <input type="submit" name="data" class="btn btn-theme btn-md btn-block" value="Gravar">
                                    </div>
                                </div>

                                <br/>            
                            </form>

                            <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8"><label>Notas</label><br/>
                                        <textarea name="nota" class="form-control" rows="10" placeholder="Insira neste campo informações de notificações para o usuário."></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <?php echo "<input type='hidden' name='IDP' value='$idProjeto'>"; ?>
                                        <input type="submit" name="gravarNota" class="btn btn-theme btn-md btn-block" value="Gravar">
                                    </div>
                                </div>
                            </form>
                            <ul class='list-group'>
                                <li class='list-group-item list-group-item-success'>Notas</li>
                                    <?php
                                $sql = "SELECT * FROM notas WHERE idProjeto = '$idProjeto'";
                                $query = mysqli_query($con,$sql);
                                $num = mysqli_num_rows($query);
                                if($num > 0)
                                {
                                    while($campo = mysqli_fetch_array($query))
                                    {
                                        echo "<li class='list-group-item' align='left'><strong>".exibirDataHoraBr($campo['data'])."</strong><br/>".$campo['nota']."</li>";
                                    }
                                }
                                else
                                {
                                    echo "<li class='list-group-item'>Não há notas disponíveis.</li>";
                                }
                                ?>
                                </li>
                            </ul>

                            <!-- Exibir arquivos -->
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="table-responsive list_info">
                                        <h6>Arquivo(s) Anexado(s)</h6>
                                        <?php listaArquivosPessoaSMC($idProjeto,9,"smc_detalhes_projeto"); ?>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- LABEL PROJETO -->
                        <div role="tabpanel" class="tab-pane fade" id="projeto" align="left">
                            <br>
                            <table class="table table-bordered">
                                <tr>
                                    <td><strong>Protocolo (nº ISP):</strong>
                                        <?php echo $projeto['protocolo'] ?>
                                    </td>
                                    <td><strong>Tipo:</strong>
                                        <?php if($projeto['tipoPessoa'] == 1){ echo "Pessoa Física"; } else { echo "Pessoa Jurídica"; } ?>
                                    </td>
                                    <?php if($projeto['tipoPessoa'] == 1) { ?>
                                    <td><strong>Cooperado:</strong>
                                        <?php if($pf['cooperado'] == 1){ echo "Sim"; } else { echo "Não"; } ?>
                                    </td>
                                    <?php } else { ?>
                                    <td><strong>Cooperativa:</strong>
                                        <?php if($pj['cooperativa'] == 1){ echo "Sim"; } else { echo "Não"; } ?>
                                    </td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Valor do projeto:</strong>R$
                                        <?php echo
                                    dinheiroParabr(isset($projeto['valorProjeto'])
                                        ? $projeto['valorProjeto']
                                        :  ''); ?>
                                    </td>
                                    <td><strong>Valor do incentivo:</strong> R$
                                        <?php echo dinheiroParabr(isset($projeto['valorIncentivo']) ? $projeto['valorIncentivo'] : null); ?>
                                    </td>
                                    <td><strong>Valor do financiamento:</strong> R$
                                        <?php echo dinheiroParabr(isset($projeto['valorFinanciamento']) ? $projeto['valorFinanciamento'] : null); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Área de atuação:</strong>
                                        <?php echo $area['areaAtuacao'] ?>
                                    </td>
                                    <td><strong>Renúncia Fiscal:</strong>
                                        <?php echo $renuncia['renunciaFiscal'] ?>
                                    </td>
                                </tr>
                                <?php
                                    if($projeto['idAreaAtuacao'] == 22){
                                    ?>
                                    <tr>
                                        <td colspan="3"><strong>Segmento:</strong>
                                            <?php echo isset($projeto['segmento']) ? $projeto['segmento'] : null; ?>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                        <tr>
                                            <td colspan="3"><strong>Nome do Projeto:</strong>
                                                <?php echo isset($projeto['nomeProjeto']) ? $projeto['nomeProjeto'] : null; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><strong>Exposição da Marca:</strong>
                                                <?php echo isset($projeto['exposicaoMarca']) ? $projeto['exposicaoMarca'] : null; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><strong>Resumo do projeto:</strong>
                                                <?php echo isset($projeto['resumoProjeto']) ? $projeto['resumoProjeto'] : null; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><strong>Currículo:</strong>
                                                <?php echo isset($projeto['curriculo']) ? $projeto['curriculo'] : null; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><strong>Descrição:</strong>
                                                <?php echo isset($projeto['descricao']) ? $projeto['descricao'] : null; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><strong>Justificativa:</strong>
                                                <?php echo isset($projeto['justificativa']) ? $projeto['justificativa'] : null; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><strong>Objetivo:</strong>
                                                <?php echo isset($projeto['objetivo']) ? $projeto['objetivo'] : null; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><strong>Metodologia:</strong>
                                                <?php echo isset($projeto['metodologia']) ? $projeto['metodologia'] : null; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><strong>Contrapartida:</strong>
                                                <?php echo isset($projeto['contrapartida']) ? $projeto['contrapartida'] : null; ?>
                                            </td>
                                        </tr>
                            </table>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Local</b></li>
                                <li class="list-group-item">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Local</th>
                                            <th>Público estimado</th>
                                            <th>Zona</th>
                                        </tr>
                                        <?php
                                    $sql = "SELECT * FROM locais_realizacao
                                    WHERE publicado = 1 AND idProjeto = ".$projeto['idProjeto'];
                                    $query = mysqli_query($con,$sql);
                                    while($campo = mysqli_fetch_array($query))
                                    {
                                        $zona = recuperaDados("zona","idZona",$campo['idZona']);
                                        echo "<tr>";
                                        echo "<td>".$campo['local']."</td>";
                                        echo "<td>".$campo['estimativaPublico']."</td>";
                                        echo "<td>".$zona['zona']."</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                    </table>
                                </li>
                            </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="3"><strong>Público alvo:</strong>
                                        <?php echo isset($projeto['publicoAlvo']) ? $projeto['publicoAlvo'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Plano de divulgação:</strong>
                                        <?php echo isset($projeto['planoDivulgacao']) ? $projeto['planoDivulgacao'] : null; ?>
                                    </td>
                                </tr>
                            </table>

                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Ficha Técnica</b></li>
                                <li class="list-group-item">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>Função</th>
                                        </tr>
                                        <?php
                                    $sql = "SELECT * FROM ficha_tecnica
                                    WHERE publicado = 1 AND idProjeto = '$idProjeto'";
                                    $query = mysqli_query($con,$sql);
                                    while($campo = mysqli_fetch_array($query))
                                    {
                                        echo "<tr>";
                                        echo "<td class='list_description'>".$campo['nome']."</td>";
                                        echo "<td class='list_description'>".$campo['cpf']."</td>";
                                        echo "<td class='list_description'>".$campo['funcao']."</td>";
                                        echo "</tr>";
                                    }?>
                                    </table>
                                </li>
                            </ul>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Cronograma</b></li>
                                <li class="list-group-item">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td><strong>Início do cronograma:</strong>
                                                <?php echo exibirDataBr($projeto['inicioCronograma']) ?>
                                            </td>
                                            <td><strong>Fim do cronograma:</strong>
                                                <?php echo exibirDataBr($projeto['fimCronograma']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Captação de recursos:</strong>
                                                <?php echo $cronograma['captacaoRecurso'] ?>
                                            </td>
                                            <td><strong>Pré-Produção:</strong>
                                                <?php echo $cronograma['preProducao'] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Produção:</strong>
                                                <?php echo $cronograma['producao'] ?>
                                            </td>
                                            <td><strong>Pós-Produção:</strong>
                                                <?php echo $cronograma['posProducao'] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><strong>Prestação de Contas:</strong>
                                                <?php echo $cronograma['prestacaoContas'] ?>
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ul>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Orçamento</b></li>
                                <?php
                            for ($i = 1; $i <= 7; $i++)
                            {
                                $sql_etapa = "SELECT idEtapa, SUM(valorTotal) AS tot FROM orcamento
                                WHERE publicado > 0 AND idProjeto ='$idProjeto' AND idEtapa = '$i'
                                ORDER BY idOrcamento";
                                $query_etapa = mysqli_query($con,$sql_etapa);
                                $lista = mysqli_fetch_array($query_etapa);

                                $etapa = recuperaDados("etapa","idEtapa",$lista['idEtapa']);
                                echo "<li class='list-group-item'><strong>".$etapa['etapa'].":</strong> R$ ".dinheiroParaBr($lista['tot'])."</li>";
                            }
                            $sql_total = "SELECT SUM(valorTotal) AS tot FROM orcamento
                            WHERE publicado > 0 AND idProjeto ='$idProjeto'
                            ORDER BY idOrcamento";
                            $query_total = mysqli_query($con,$sql_total);
                            $total = mysqli_fetch_array($query_total);
                            echo "<li class='list-group-item'><strong>TOTAL:</strong> R$ ".dinheiroParaBr($total['tot'])."</li>";
                            ?>
                                    <li class="list-group-item">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td width='25%'><strong>Etapa</strong></td>
                                                <td><strong>Descrição</strong></td>
                                                <td width='5%'><strong>Qtde</strong></td>
                                                <td width='5%'><strong>Unid. Med.</strong></td>
                                                <td width='5%'><strong>Qtde Unid.</strong></td>
                                                <td><strong>Valor Unit.</strong></td>
                                                <td><strong>Valor Total</strong></td>
                                            </tr>
                                            <?php
                                    $sql = "SELECT * FROM orcamento
                                    WHERE publicado > 0 AND idProjeto ='$idProjeto'
                                    ORDER BY idEtapa";
                                    $query = mysqli_query($con,$sql);
                                    while($campo = mysqli_fetch_array($query))
                                    {
                                        $etapa = recuperaDados("etapa","idEtapa",$campo['idEtapa']);
                                        $medida = recuperaDados("unidade_medida","idUnidadeMedida",$campo['idUnidadeMedida']);
                                        echo "<tr>";
                                        echo "<td class='list_description'>".$etapa['etapa']."</td>";
                                        echo "<td class='list_description'>".$campo['descricao']."</td>";
                                        echo "<td class='list_description'>".$campo['quantidade']."</td>";
                                        echo "<td class='list_description'>".$medida['unidadeMedida']."</td>";
                                        echo "<td class='list_description'>".$campo['quantidadeUnidade']."</td>";
                                        echo "<td class='list_description'>".dinheiroParaBr($campo['valorUnitario'])."</td>";
                                        echo "<td class='list_description'>".dinheiroParaBr($campo['valorTotal'])."</td>";
                                        echo "</tr>";
                                    }?>
                                        </table>
                                    </li>
                            </ul>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Mídias sociais</b></li>
                                <li class="list-group-item">
                                    <?php

                                if(!empty($video['video1'] || $video['video2'] || $video['video3']))
                                {
                                    ?>
                                        <table class='table table-condensed'>
                                            <?php
                                        foreach ($v as $key => $m)
                                        {
                                            if (!empty($m))
                                            {
                                                if(isYoutubeVideo($m) == "youtube")
                                                {
                                                    $desc = "https://www.youtube.com/oembed?format=json&url=".$m;
                                                    $obj =	json_decode(file_get_contents($desc), true);
                                                } else{
                                                    echo "<div class='alert alert-danger'>
                                                    <strong>Erro!</strong> O link ($m) não pode ser aberto, a plataforma aceita somente YouTube.
                                                    </div>";
                                                }
                                                if(isYoutubeVideo($m) == "youtube"){ ?>
                                                <tr>
                                                    <td>
                                                        <img src="<?php echo $obj['thumbnail_url']; ?>" style='width: 150px;'>
                                                    </td>
                                                    <td>
                                                        <?php echo $obj['title']; ?><br/>
                                                        <?php echo $m ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <?php
                                            }
                                        }?>
                                        </table>
                                        <?php
                                }
                                else
                                {
                                    echo "<p>Não há video(s) inserido(s).<p/><br/>";
                                }
                                ?>
                                </li>
                            </ul>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Arquivos do Projeto</b></li>
                                <li class="list-group-item">
                                    <?php exibirArquivos(3,$projeto['idProjeto']); ?>
                                </li>
                            </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="3"><strong>Pertence às listas de empresas apenadas?</strong>
                                        <?php if($projeto['empresaApenada'] == 1){ echo "Não"; } else { echo "Sim"; } ?>
                                    </td>
                                </tr>
                            </table>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Certificados do Projeto</b></li>
                                <li class="list-group-item">
                                    <?php exibirCertificados(3,$projeto['idProjeto']); ?>
                                </li>
                            </ul>
                             <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Complemento de Informações</b></li>
                                <li class="list-group-item">
                                    <?php exibirComplemento(3,$projeto['idProjeto']); ?>
                                </li>
                            </ul>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Solicitação de Alteração</b></li>
                                <li class="list-group-item">
                                    <?php exibirSolicitacaoAlteracao(9,$projeto['idProjeto']); ?>
                                </li>
                            </ul>
                        </div>

                        <!-- LABEL PESSOA JURÍDICA -->
                        <div role="tabpanel" class="tab-pane fade" id="J">
                            <br>
                            <?php if($projeto['tipoPessoa'] == 2) { ?>
                            <li class="list-group-item list-group-item-success">
                                <b>Dados Pessoa Jurídica</b>
                            </li>
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="2">
                                        <strong>Razão Social:</strong>
                                        <?php echo isset($pj['razaoSocial']) ? $pj['razaoSocial'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <strong>CNPJ:</strong>
                                        <?php echo isset($pj['cnpj']) ? $pj['cnpj'] : null; ?>
                                    </td>
                                    <td>
                                        <strong>CCM:</strong>
                                        <?php echo isset($pj['ccm']) ? $pj['ccm'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Endereço:</strong>
                                        <?php echo isset($pj['logradouro']) ? $pj['logradouro'] : null; ?>,
                                        <?php echo isset($pj['numero']) ? $pj['numero'] : null; ?>
                                        <?php echo isset($pj['complemento']) ? $pj['complemento'] : null; ?> -
                                        <?php echo isset($pj['bairro']) ? $pj['bairro'] : null; ?> -
                                        <?php echo isset($pj['cidade']) ? $pj['cidade'] : null; ?> -
                                        <?php echo isset($pj['estado']) ? $pj['estado'] : null; ?> - CEP
                                        <?php echo isset($pj['cep']) ? $pj['cep'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Telefone:</strong>
                                        <?php echo isset($pj['telefone']) ? $pj['telefone'] : null; ?>
                                    </td>
                                    <td><strong>Celular:</strong>
                                        <?php echo isset($pj['celular']) ? $pj['celular'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>E-mail:</strong>
                                        <?php echo isset($pj['email']) ? $pj['email'] : null; ?>
                                    </td>
                                    <td><strong>Cooperativa:</strong>
                                        <?php if($pj['cooperativa'] == 1){ echo "Sim"; } else { echo "Não"; } ?>
                                    </td>
                                </tr>
                            </table>

                            <li class="list-group-item list-group-item-success">
                                <b>Dados Representante</b>
                            </li>
                            <!--Dados Representante xura -->
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="2">
                                        <strong>Nome:</strong>
                                        <?= isset($representante['nome']) ? $representante['nome'] : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <strong>CPF:</strong>
                                        <?= isset($representante['cpf']) ? $representante['cpf'] : ''; ?>
                                    </td>
                                    <td>
                                        <strong>RG:</strong>
                                        <?= isset($representante['rg']) ? $representante['rg'] : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <strong>Endereço:</strong>
                                        <?=
                                        isset($representante['logradouro'])
                                            ? $representante['logradouro']
                                            : ''; ?>
                                            ,
                                            <?=
                                        isset($representante['numero'])
                                            ? $representante['numero']
                                            : ''; ?>

                                                <b>Bairro</b>:
                                                <?=
                                        isset($representante['bairro'])
                                            ? $representante['bairro']
                                            : ''; ?>

                                                    <b>Cep</b>:
                                                    <?=
                                        isset($representante['cep'])
                                            ? $representante['cep']
                                            : ''; ?>

                                                        <b>Cidade</b>:
                                                        <?=
                                        isset($representante['cidade'])
                                            ? $representante['cidade']
                                            : ''; ?>
                                                            -
                                                            <?=
                                        isset($representante['estado'])
                                            ? $representante['estado']
                                            : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Telefone:</strong>
                                        <?= isset($representante['telefone']) ? $representante['telefone'] : ''; ?>
                                    </td>
                                    <td>
                                        <strong>Celular:</strong>
                                        <?= isset($representante['celular']) ? $representante['celular'] : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>E-mail:</strong>
                                        <?= isset($representante['email']) ? $representante['email'] : ''; ?>
                                    </td>
                                    <td>
                                        <strong>Cooperado:</strong>
                                        <?= $representante['cooperativa'] == 1 ? 'SIM' : 'NÃO' ?>
                                    </td>
                                </tr>
                            </table>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success">
                                    <b>Arquivos da Pessoa Jurídica</b></li>
                                <li class="list-group-item">
                                    <?php exibirArquivos(2,$pj['idPj']); ?>
                                </li>
                            </ul>
                            <?php } else { echo "<strong>Não há pessoa jurídica cadastrada.</strong>"; } ?>
                        </div>

                        <!--LABEL PESSOA FISICA-->
                        <div role="tabpanel" class="tab-pane fade" id="F" align="left">
                            <br>
                            <li class="list-group-item list-group-item-success">
                                <div style="text-align: center;">
                                    <b>Dados Pessoa Física</b>
                                </div>
                            </li>
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="2">
                                        <strong>Nome:</strong>
                                        <?php //echo isset($pf['nome']) ? $pf['nome'] : null; ?>
                                        <?= isset($pessoaFisica['nome']) ? $pessoaFisica['nome'] : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <strong>CPF:</strong>
                                        <?php //echo isset($pf['cpf']) ? $pf['cpf'] : null; ?>
                                        <?= isset($pessoaFisica['cpf']) ? $pessoaFisica['cpf'] : ''; ?>
                                    </td>
                                    <td>
                                        <strong>RG:</strong>
                                        <?php //echo isset($pf['rg']) ? $pf['rg'] : null; ?>
                                        <?= isset($pessoaFisica['rg']) ? $pessoaFisica['rg'] : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <strong>Endereço:</strong>
                                        <?php //echo isset($pf['logradouro']) ? $pf['logradouro'] : null; ?>
                                        <?php //echo isset($pf['numero']) ? $pf['numero'] : null; ?>
                                        <?php //echo isset($pf['complemento']) ? $pf['complemento'] : null; ?>
                                        <?php //echo isset($pf['bairro']) ? $pf['bairro'] : null; ?>
                                        <?php //echo isset($pf['cidade']) ? $pf['cidade'] : null; ?>
                                        <?php //echo isset($pf['estado']) ? $pf['estado'] : null; ?>
                                        <?php //echo isset($pf['cep']) ? $pf['cep'] : null; ?>
                                        <?=
                                    isset($pessoaFisica['logradouro'])
                                        ? $pessoaFisica['logradouro']
                                        : ''; ?>
                                            ,

                                            <?=
                                    isset($pessoaFisica['numero'])
                                        ? $pessoaFisica['numero']
                                        : ''; ?>

                                                <b>Bairro</b>:

                                                <?=
                                    isset($pessoaFisica['bairro'])
                                        ? $pessoaFisica['bairro']
                                        : ''; ?>

                                                    <b>Cep</b>:
                                                    <?=
                                    isset($pessoaFisica['cep'])
                                        ? $pessoaFisica['cep']
                                        : ''; ?>

                                                        <b>Cidade</b>:
                                                        <?=
                                    isset($pessoaFisica['cidade'])
                                        ? $pessoaFisica['cidade']
                                        : ''; ?>
                                                            -
                                                            <?=
                                    isset($pessoaFisica['estado'])
                                        ? $pessoaFisica['estado']
                                        : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Telefone:</strong>
                                        <?php //echo isset($pf['telefone']) ? $pf['telefone'] : null; ?>
                                        <?= isset($pessoaFisica['telefone']) ? $pessoaFisica['telefone'] : ''; ?>
                                    </td>
                                    <td>
                                        <strong>Celular:</strong>
                                        <?php //echo isset($pf['celular']) ? $pf['celular'] : null; ?>
                                        <?= isset($pessoaFisica['celular']) ? $pessoaFisica['celular'] : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>E-mail:</strong>
                                        <?php //echo isset($pf['email']) ? $pf['email'] : null; ?>
                                        <?= isset($pessoaFisica['email']) ? $pessoaFisica['email'] : ''; ?>
                                    </td>
                                    <td>
                                        <strong>Cooperado:</strong>
                                        <?php //if($pf['cooperado'] == 1){ echo "Sim"; } else { echo "Não"; } ?>
                                        <?= $pessoaFisica['cooperado'] == 1 ? 'SIM' : 'NÃO' ?>
                                    </td>
                                </tr>
                            </table>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success">
                                    <center>
                                        <b>Arquivos da Pessoa Física</b>
                                    </center>
                                </li>
                                <li class="list-group-item">
                                    <?php exibirArquivos(1,$pessoaFisica['idPf']); ?>
                                </li>
                            </ul>
                        </div>

                        <!-- LABEL PRAZOS -->
                        <div role="tabpanel" class="tab-pane fade" id="prazo">
                            <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                                <h5>
                                    <?php if(isset($mensagem)){echo $mensagem;}; ?>
                                </h5>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8"><br/></div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-3">
                                        <label>Data inicial de Captação</label><br/>
                                        <input type="text" name="prazoCaptacao" id="datepicker01" class="form-control" value="<?php
                                    if(returnEmptyDate('prazoCaptacao', $idProjeto) > 0 ){
                                        $var = strtotime(returnEmptyDate('prazoCaptacao', $idProjeto));
                                        echo date(" d ",$var) . "/ ";
                                        echo date("m ",$var) . "/ ";
                                        echo date("Y ",$var);
                                    } else{
                                        echo "00/00/0000 ";
                                    }?>">
                                    </div>

                                    <div class="col-md-2"><label>Prorrogação</label><br/>
                                        <select class="form-control" name="prorrogacaoCaptacao" value="">
                                        <option value="<?php echo $prazos['prorrogacaoCaptacao'] ?>" selected >
                                            <?php
                                            if($prazos['prorrogacaoCaptacao'] == 1){ echo "Sim"; }
                                            else { echo "Não"; }
                                            ?>
                                        </option>
                                        <option value="0">Não</option>
                                        <option value="1">Sim</option>
                                    </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Data Final da Captação</label>
                                        <input type="text" name="finalCaptacao" id="datepicker02" class="form-control" value="<?php
                                    if(returnEmptyDate('finalCaptacao', $idProjeto) > 0 ){
                                        $var = strtotime(returnEmptyDate('finalCaptacao', $idProjeto));
                                        echo date(" d ",$var) . "/ ";
                                        echo date("m ",$var) . "/ ";
                                        echo date("Y ",$var);
                                    } else{
                                        echo "00/00/0000 ";
                                    }
                                    ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-6"><label>Início da execução do projeto</label>
                                        <input type="text" name="inicioExecucao" id="datepicker03" class="form-control" value="<?php
                                    if(returnEmptyDate('inicioExecucao', $idProjeto) > 0 ){
                                        $var = strtotime(returnEmptyDate('inicioExecucao', $idProjeto));
                                        echo date(" d ",$var) . "/ ";
                                        echo date("m ",$var) . "/ ";
                                        echo date("Y ",$var);
                                    } else{
                                        echo "00/00/0000 ";
                                    }
                                    ?>">
                                    </div>
                                    <div class="col-md-6"><label>Fim da execução do projeto</label>
                                        <input type="text" name="fimExecucao" id="datepicker04" class="form-control" value="<?php
                                    if(returnEmptyDate('fimExecucao', $idProjeto) > 0 ){
                                        $var = strtotime(returnEmptyDate('fimExecucao', $idProjeto));
                                        echo date(" d ",$var) . "/ ";
                                        echo date("m ",$var) . "/ ";
                                        echo date("Y ",$var);
                                    } else{
                                        echo "00/00/0000 ";
                                    }
                                    ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-2"><label>Prorrogação</label><br/>
                                        <select class="form-control" name="prorrogacaoExecucao">
                                        <option value="<?php echo $prazos['prorrogacaoExecucao'] ?>" selected >
                                            <?php
                                            if($prazos['prorrogacaoExecucao'] == 1){ echo "Sim"; }
                                            else { echo "Não"; }
                                            ?>
                                        </option>
                                        <option value="0">Não</option>
                                        <option value="1">Sim</option>
                                    </select>
                                    </div>
                                    <?php
                                if($prazos['prorrogacaoExecucao'] == 1)
                                {
                                    ?>
                                        <div class="col-md-3"><label>Data final do projeto</label>
                                            <input type="text" name="finalProjeto" id="datepicker05" class="form-control" value="<?php
                                        if(returnEmptyDate('finalProjeto', $idProjeto) > 0 ){
                                            $var = strtotime(returnEmptyDate('finalProjeto', $idProjeto));
                                            echo date(" d ",$var) . "/ ";
                                            echo date("m ",$var) . "/ ";
                                            echo date("Y ",$var);
                                        } else{
                                            echo "00/00/0000 ";
                                        }
                                        ?>">
                                        </div>
                                        <?php
                                }
                                else
                                {
                                    ?>
                                            <div class="col-md-3"><label>Data final do projeto</label><br/>
                                                <i>Não há prorrogração</i>
                                            </div>
                                            <?php
                                }
                                ?>
                                                <div class="col-md-3"><label>Data para prestar contas</label>
                                                    <input type="text" name="prestarContas" id="datepicker06" class="form-control" value="<?php
                                    if(returnEmptyDate('prestarContas', $idProjeto) > 0 ){
                                        $var = strtotime(returnEmptyDate('prestarContas', $idProjeto));
                                        echo date(" d ",$var) . "/ ";
                                        echo date("m ",$var) . "/ ";
                                        echo date("Y ",$var);
                                    } else{
                                        echo "00/00/0000 ";
                                    }
                                    ?>">
                                                </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <?php echo "<input type='hidden' name='IDP' value='$idProjeto'>"; ?>
                                        <input type="submit" name="gravarPrazos" class="btn btn-theme btn-lg btn-block" value="Gravar"></div>
                                </div>
                            </form>
                        </div>

                        <!-- LABEL PAGAMENTOS -->
                        <div role="tabpanel" class="tab-pane fade" id="pagamentos">
                            <form method="POST" action="?perfil=cadastro_reserva&idProjeto=<?=$idProjeto?>" class="form-horizontal" role="form">
                                <h5>
                                    <?php if(isset($mensagem)){echo $mensagem;}; ?>
                                </h5>
                                <div class="form-group">
                                    <h4>Reservas</h4>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <input type="submit" class="btn btn-theme btn-md btn-block" value="INSERIR RESERVA">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <hr/>
                                    </div>
                                </div>
                            </form>

                            <?php
                        $sql = "SELECT * FROM reserva WHERE idProjeto = '$idProjeto'";
                        $query = mysqli_query($con, $sql);
                        $num = mysqli_num_rows($query);
                        if($num > 0) { ?>
                                <div class="table-responsive list_info">
                                    <table class='table table-condensed'>
                                        <thead>
                                            <tr class='list_menu'>
                                                <td>Data</td>
                                                <td>Valor</td>
                                                <td>Número da Reserva</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($reserva = mysqli_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php echo exibirDataBr($reserva['data']) ?>
                                                </td>
                                                <td>
                                                    <?php echo dinheiroParabr($reserva['valor']); ?>
                                                </td>
                                                <td>
                                                    <?php echo $reserva['numeroReserva']; ?>
                                                </td>
                                                <td class="list_description">
                                                    <form method="POST" action="?perfil=edicao_reserva&idReserva=<?=$reserva['idReserva']?>">
                                                        <input type="hidden" name="idReserva" value="'.$linha['idReserva'].'" />
                                                        <input type="submit" class="btn btn-theme btn-block" value="editar">
                                                    </form>
                                                </td>
                                                <td class='list_description'>
                                                    <form method="POST" action="?perfil=empenho&idReserva=<?=$reserva['idReserva']?>">
                                                        <input type='hidden' name='' value='".$campo[' ']."' />
                                                        <input type='submit' class='btn btn-theme btn-block' value='empenhos'>
                                                    </form>
                                                </td>
                                                <td class='list_description'>
                                                    <form method='POST' action="?perfil=deposito&idReserva=<?=$reserva['idReserva']?>&idProjeto=<?=$reserva['idProjeto']?>">
                                                        <input type='hidden' name='' value='".$campo[' ']."' />
                                                        <input type='submit' class='btn btn-theme btn-block' value='depósitos'>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                        }
                        else {?>
                                    <h4>Não existem reservas cadastradas!</h4>
                                    <?php } ?>
                        </div>

                        <!-- LABEL HISTÓRICO -->
                        <div role="tabpanel" class="tab-pane fade" id="historico">
                            <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                                <h5>
                                    <?php if(isset($mensagem)){echo $mensagem;}; ?>
                                </h5>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8"><br/></div>
                                </div>

                                <ul class='list-group'>
                                    <li class='list-group-item list-group-item-success'>Histórico de Reuniões</li>
                                   <?php
                                        $sql_data_reuniao = "SELECT * FROM `data_reuniao` WHERE idProjeto = '$idProjeto' ORDER BY dataReuniao DESC";
                                         $query_data_reuniao = mysqli_query($con,$sql_data_reuniao);
                                         $num = mysqli_num_rows($query_data_reuniao);

                                    if($num > 0)
                                    {
                                    ?>                          
                                        <table class='table table-condensed'>
                                            <?php                                   
                                            while($dataReuniao = mysqli_fetch_array($query_data_reuniao))
                                            {                                   
                                            ?>  
                                                    <tr>
                                                        <td><?php  echo exibirDataHoraBr($dataReuniao['dataReuniao']); ?></td>
                                                    </tr>
                                            <?php
                                            }
                                            ?>
                                        </table>
                                    <?php
                                    }
                                    else
                                    {
                                        echo "<li class='list-group-item'>Não há registros disponíveis.</li>";
                                    }   
                                    ?>
                                    </li>
                                </ul> 

                                <ul class='list-group'>
                                    <li class='list-group-item list-group-item-success'>Histórico de envios para a Comissão</li>
                                   <?php
                                        $sql_envio_comissao = "SELECT * FROM `envio_comissao` WHERE idProjeto = '$idProjeto' ORDER BY data DESC";
                                         $query_envio_comissao = mysqli_query($con,$sql_envio_comissao); 
                                         $num = mysqli_num_rows($query_envio_comissao);

                                    if($num > 0)
                                    {
                                    ?>                          
                                        <table class='table table-condensed'>
                                            <?php                                   
                                            while($envioComissao = mysqli_fetch_array($query_envio_comissao))
                                            {                                   
                                            ?>  
                                                    <tr>
                                                        <td><?php  echo exibirDataHoraBr($envioComissao['data']); ?></td>
                                                    </tr>
                                            <?php
                                            }
                                            ?>
                                        </table>
                                    <?php
                                    }
                                    else
                                    {
                                        echo "<li class='list-group-item'>Não há registros disponíveis.</li>";
                                    }   
                                    ?>
                                    </li>
                                </ul> 


                                <ul class='list-group'>
                                    <li class='list-group-item list-group-item-success'>Histórico de finalização da Comissão e envio à SMC</li>
                                   <?php
                                        $sql_finalizacao_comissao = "SELECT * FROM `finalizacao_comissao` WHERE idProjeto = '$idProjeto' ORDER BY data DESC";
                                         $query_finalizacao_comissao = mysqli_query($con,$sql_finalizacao_comissao); 
                                         $num = mysqli_num_rows($query_finalizacao_comissao);

                                    if($num > 0)
                                    {
                                    ?>                          
                                        <table class='table table-condensed'>
                                            <?php                                   
                                            while($finalizacaoComissao = mysqli_fetch_array($query_finalizacao_comissao))
                                            {                                   
                                            ?>  
                                                    <tr>
                                                        <td><?php  echo exibirDataHoraBr($finalizacaoComissao['data']); ?></td>
                                                    </tr>
                                            <?php
                                            }
                                            ?>
                                        </table>
                                    <?php
                                    }
                                    else
                                    {
                                        echo "<li class='list-group-item'>Não há registros disponíveis.</li>";
                                    }   
                                    ?>
                                    </li>
                                </ul> 
                        </div>

                                                <!-- LABEL PAGAMENTOS -->
                        <div role="tabpanel" class="tab-pane fade" id="pagamentos">
                            <form method="POST" action="?perfil=cadastro_reserva&idProjeto=<?=$idProjeto?>" class="form-horizontal" role="form">
                                <h5>
                                    <?php if(isset($mensagem)){echo $mensagem;}; ?>
                                </h5>
                                <div class="form-group">
                                    <h4>Reservas</h4>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <input type="submit" class="btn btn-theme btn-md btn-block" value="INSERIR RESERVA">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <hr/>
                                    </div>
                                </div>
                            </form>

                            <?php
                        $sql = "SELECT * FROM reserva WHERE idProjeto = '$idProjeto'";
                        $query = mysqli_query($con, $sql);
                        $num = mysqli_num_rows($query);
                        if($num > 0) { ?>
                                <div class="table-responsive list_info">
                                    <table class='table table-condensed'>
                                        <thead>
                                            <tr class='list_menu'>
                                                <td>Data</td>
                                                <td>Valor</td>
                                                <td>Número da Reserva</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($reserva = mysqli_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php echo exibirDataBr($reserva['data']) ?>
                                                </td>
                                                <td>
                                                    <?php echo dinheiroParabr($reserva['valor']); ?>
                                                </td>
                                                <td>
                                                    <?php echo $reserva['numeroReserva']; ?>
                                                </td>
                                                <td class="list_description">
                                                    <form method="POST" action="?perfil=edicao_reserva&idReserva=<?=$reserva['idReserva']?>">
                                                        <input type="hidden" name="idReserva" value="'.$linha['idReserva'].'" />
                                                        <input type="submit" class="btn btn-theme btn-block" value="editar">
                                                    </form>
                                                </td>
                                                <td class='list_description'>
                                                    <form method="POST" action="?perfil=empenho&idReserva=<?=$reserva['idReserva']?>">
                                                        <input type='hidden' name='' value='".$campo[' ']."' />
                                                        <input type='submit' class='btn btn-theme btn-block' value='empenhos'>
                                                    </form>
                                                </td>
                                                <td class='list_description'>
                                                    <form method='POST' action="?perfil=deposito&idReserva=<?=$reserva['idReserva']?>&idProjeto=<?=$reserva['idProjeto']?>">
                                                        <input type='hidden' name='' value='".$campo[' ']."' />
                                                        <input type='submit' class='btn btn-theme btn-block' value='depósitos'>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                        }
                        else {?>
                                    <h4>Não existem reservas cadastradas!</h4>
                                    <?php } ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
