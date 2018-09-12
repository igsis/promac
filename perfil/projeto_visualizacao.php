<?php

$con = bancoMysqli();

if(isset($_POST['carregar']))
{
	$_SESSION['idProjeto'] = $_POST['carregar'];
}
$idProjeto = $_SESSION['idProjeto'];

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$area = recuperaDados("area_atuacao","idArea",$projeto['idAreaAtuacao']);
$renuncia = recuperaDados("renuncia_fiscal","idRenuncia",$projeto['idRenunciaFiscal']);
$cronograma = recuperaDados("cronograma","idCronograma",$projeto['idCronograma']);
$video = recuperaDados("projeto","idProjeto",$idProjeto);
$v = array($video['video1'], $video['video2'], $video['video3']);
$status = recuperaDados("status","idStatus",$projeto['idStatus']);
$idStatus = $projeto['idStatus'];
$dateNow = date('Y-m-d');
$dataPublicacaoDoc = $projeto['dataPublicacaoDoc'];
$dataRecurso = date('Y-m-d', strtotime("+7 days",strtotime($dataPublicacaoDoc)));
// Calcula a diferença em segundos entre as datas do recurso e publicação
$diferenca = strtotime($dateNow) - strtotime($dataRecurso);
$dias = floor($diferenca / (60 * 60 * 24));//Calcula a diferença em dias

?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php
    if($_SESSION['tipoPessoa'] == 1)
    {
        $idPf= $_SESSION['idUser'];
        include '../perfil/includes/menu_interno_pf.php';
    }
    else
    {
        $idPj= $_SESSION['idUser'];
        include '../perfil/includes/menu_interno_pj.php';
    }
    ?>
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <div role="tabpanel">
                        <!-- LABELS -->
                        <ul class="nav nav-tabs">
                            <li class="nav active"><a href="#info" data-toggle="tab">Informações da Inscrição</a></li>
                            <li class="nav"><a href="#projeto" data-toggle="tab">Projeto</a></li>
                            <li class="nav"><a href="#parecer" data-toggle="tab">Parecer</a></li>
                        </ul>
                        <div class="tab-content">

                            <!--
                                LABEL INFORMAÇÕES
                             -->
                            <div role="tabpanel" class="tab-pane fade in active" id="info">
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8" align="left">
                                        <ul class='list-group'>
                                            <li class='list-group-item list-group-item-success'></li>
                                            <li class='list-group-item'><strong>Protocolo (nº ISP):</strong>
                                                <?php echo $projeto['protocolo'];?>
                                            </li>
                                            <li class='list-group-item'><strong>Etapa do projeto:</strong>
                                                <?php
                                                if($idStatus == 7 || $idStatus == 10 || $idStatus == 12 || $idStatus == 19 || $idStatus == 20 || $idStatus == 24 || $idStatus == 25 || $idStatus == 28 || $idStatus == 30 || $idStatus == 31 || $idStatus == 34 || $idStatus == 15)
                                                {
                                                    echo "Projeto em análise";
                                                }
                                                else
                                                {
                                                    echo $status['status'];
                                                }
                                                ?>
                                            </li>
                                            <li class='list-group-item'>
                                                <strong>Valor Aprovado:</strong>
                                                <?php
                                                if($idStatus == 5 || $idStatus == 21 || $idStatus == 26 || $idStatus == 32 || $idStatus == 16 || $idStatus == 11)
                                                {
                                                    echo "R$ ".dinheiroParaBr($projeto['valorAprovado']);
                                                }
                                              ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8" align="left">
                                        <ul class='list-group'>
                                            <li class='list-group-item list-group-item-success'>Notas</li>
                                                <?php
                                                $sql = "SELECT * FROM notas
                                                        WHERE idProjeto = '$idProjeto' AND interna = 0";
                                                $query = mysqli_query($con,$sql);
                                                $num = mysqli_num_rows($query);
                                                if($num > 0)
                                                {
                                                    while($campo = mysqli_fetch_array($query))
                                                    {
                                                        echo "<li class='list-group-item'><strong>".exibirDataHoraBr($campo['data'])."</strong><br/>".$campo['nota']."</li>";
                                                    }
                                                }
                                                else
                                                {
                                                    echo "<li class='list-group-item'>Não há notas disponíveis.</li>";
                                                }
                                            ?>
                                        </ul>
                                    </div>
                                </div>

                                 <!-- Botão para anexar certificados -->
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-6">
                                        <?php
                                        if($idStatus == 5)
                                        {
                                        ?>
                                            <form class="form-horizontal" role="form" action="?perfil=certificados&idProjeto=<?=$idProjeto?>" method="post">
                                            <input type="submit" value="anexar certificados" class="btn btn-theme btn-md btn-block">
                                            </form>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                                 <!-- Botão para solicitar alteração do projeto -->
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-6">
                                        <?php
                                        if($idStatus == 5 || $idStatus == 16 || $idStatus == 21 || $idStatus = 26 || $idStatus == 32 || $idStatus == 11)
                                        {
                                        ?>
                                            <form class="form-horizontal" role="form" action="?perfil=alteracao_projeto&idProjeto=<?=$idProjeto?>" method="post">
                                                <input type="submit" value="solicitar alteração do projeto" class="btn btn-theme btn-md btn-block">
                                            </form>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                                <!-- Botão para anexar complemento de informações -->
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-6">
                                        <?php
                                        if(($idStatus== 12 || $idStatus == 13) &&  $dias >= -7 && $dias <= 0)
                                        {
                                        ?>
                                            <form class="form-horizontal" role="form" action="?perfil=complemento_informacoes&idProjeto=<?=$idProjeto?>" method="post">
                                            <input type="submit" value="anexar complementos" class="btn btn-theme btn-md btn-block">
                                        <?php
                                        }
                                        ?>
                                     </form>
                                    </div>
                                </div>

                                <!-- Botão para anexar recurso -->
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-6">
                                        <?php
                                        if(($idStatus == 5 || $idStatus == 6 || $idStatus == 22 || $idStatus == 17) &&  $dias >= -7 && $dias <= 0)
                                        {
                                        ?>
                                            <form class="form-horizontal" role="form" action="?perfil=envio_recursos&idProjeto=<?=$idProjeto?>" method="post">
                                                <input type="submit" value="anexar recurso" class="btn btn-theme btn-md btn-block">
                                            </form>
                                        <?php
                                        }
                                        ?>
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
                                        <td><strong>Valor do projeto:</strong> R$
                                            <?php echo dinheiroParaBr($projeto['valorProjeto']) ?>
                                        </td>
                                        <td><strong>Valor do incentivo:</strong> R$
                                            <?php echo dinheiroParaBr($projeto['valorIncentivo']) ?>
                                        </td>
                                        <td><strong>Valor do financiamento:</strong> R$
                                            <?php echo dinheiroParaBr($projeto['valorFinanciamento']) ?>
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
                                            WHERE publicado = 1 AND idProjeto = ".$projeto['idProjeto']."";
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
                            </div>
                            <!-- FIM LABEL PROJETO -->

                            <!-- LABEL PARECER -->
                            <div role="tabpanel" class="tab-pane fade" id="parecer" align="left">
                            <br>
                                <!-- Exibir arquivos -->
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <div class="table-responsive list_info">
                                            <h6>Parecer da Solicitação de Alteração do Projeto</h6>
                                            <?php listaAlteracaoParecer($idProjeto,9,"comissao_detalhes_projeto"); ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Exibir arquivos -->
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <div class="table-responsive list_info">
                                            <h6>Parecer do Projeto</h6>
                                            <?php listaParecer($idProjeto,9,"comissao_detalhes_projeto"); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--FIM LABEL PARECER -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Botão para Voltar -->
            <div class="form-group">
                <div class="col-md-offset-4 col-md-6">
                    <?php
            if($projeto['tipoPessoa'] == 1)
            {
            ?>
                        <form class="form-horizontal" role="form" action="?perfil=projeto_pf" method="post">
                            <?php
            }
            else
            {
            ?>
                            <form class="form-horizontal" role="form" action="?perfil=projeto_pj" method="post">
                                <?php
            }
            ?>
                                <input type="submit" value="Voltar" class="btn btn-theme btn-md btn-block">
                            </form>
                </div>
            </div>
    </div>
</section>
