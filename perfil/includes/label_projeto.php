<div role="tabpanel" class="tab-pane fade" id="projeto">
    <div class="form-group">
        <div class="col-md-offset-4 col-md-4">
            <?php
            $id = $projeto['tipoPessoa'];
            $idP = $projeto['idProjeto'];
            if ($id == 1) {
                $idPess = $projeto['idPf'];
            } else if ($id == 2) {
                $idPess = $projeto['idPj'];
            }
            ?>
            <a href='<?php echo "../pdf/pdf_teste.php?tipo=$id&projeto=$idP&pessoa=$idPess"; ?>' target='_blank'
               class="btn btn-theme btn-md btn-block"><strong>Gerar Projeto</strong></a><br/>
        </div>
    </div>


        <table class="table table-bordered">
        <tr>
            <td>
                <strong>Protocolo (nº ISP):</strong>
                <span data-mask = "0000.00.00/0000000"><?= $projeto['protocolo'] ?></span>
            </td>
            <td><strong>Tipo:</strong>
                <?php
                if ($projeto['tipoPessoa'] == 1) {
                    echo "Pessoa Física";
                } else {
                    echo "Pessoa Jurídica";
                } ?>
            </td>
            <?php
            if ($projeto['tipoPessoa'] == 1) { ?>
                <td><strong>Cooperado:</strong>
                    <?php
                    if ($pf['cooperado'] == 1) {
                        echo "Sim";
                    } else {
                        echo "Não";
                    } ?>
                </td>
            <?php } else { ?>
                <td><strong>Cooperativa:</strong>
                    <?php
                    if ($pj['cooperativa'] == 1) {
                        echo "Sim";
                    } else {
                        echo "Não";
                    } ?>
                </td>
            <?php } ?>
        </tr>
        <tr>
            <td><strong>Valor do projeto:</strong>R$
                <?php echo
                dinheiroParabr(isset($projeto['valorProjeto']) ? $projeto['valorProjeto'] : ''); ?>
            </td>
            <td><strong>Valor do incentivo:</strong> R$
                <?php echo
                dinheiroParabr(isset($projeto['valorIncentivo'])
                    ? $projeto['valorIncentivo']
                    : null); ?>
            </td>
            <td><strong>Renúncia Fiscal:</strong>
                <?php echo $renuncia['renunciaFiscal'] ?>
            </td>
        </tr>
        <?php
        if ($projeto['idAreaAtuacao'] == 22) {
            ?>
            <tr>
                <td colspan="3"><strong>Segmento:</strong>
                    <?php echo isset($projeto['segmento']) ? $projeto['segmento'] : null; ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>
    <div class="well">
        <p align="justify"><strong>Nome do projeto:</strong> <?php echo $projeto['nomeProjeto']; ?></p>
        <p align="justify"><strong>Área de atuação:</strong> <?php echo $area['areaAtuacao'] ?></p>
        <p align="justify"><strong>Resumo do projeto:</strong> <?php echo isset($projeto['resumoProjeto']) ? $projeto['resumoProjeto'] : null; ?>
        </p>
        <p align="justify">
            <strong>Currículo:</strong> <?php echo isset($projeto['curriculo']) ? $projeto['curriculo'] : null; ?>
        </p>
        <p align="justify">
            <strong>Descrição do objeto e atividades:</strong> <?php echo isset($projeto['descricao']) ? $projeto['descricao'] : null; ?>
        </p>
        <p align="justify">
            <strong>Justificativa do projeto:</strong> <?php echo isset($projeto['justificativa']) ? $projeto['justificativa'] : null; ?>
        </p>
        <p align="justify">
            <strong>Objetivos e metas:</strong> <?php echo isset($projeto['objetivo']) ? $projeto['objetivo'] : null; ?></p>
        <p align="justify">
            <strong>Metodologia:</strong> <?php echo isset($projeto['metodologia']) ? $projeto['metodologia'] : null; ?>
        </p>
        <p align="justify">
            <strong>Contrapartida:</strong> <?php echo isset($projeto['contrapartida']) ? $projeto['contrapartida'] : null; ?>
        </p>
    </div>

    <div class="well">
        <ul class="list-group">
            <li class="list-group-item list-group-item-success"><b>Local</b></li>
            <li class="list-group-item">
                <table class="table table-bordered">
                    <tr>
                        <th>Local</th>
                        <th>Público estimado</th>
                        <th>Endereço</th>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM locais_realizacao
								WHERE publicado = 1 AND idProjeto = " . $projeto['idProjeto'] . "";
                    $query = mysqli_query($con, $sql);
                    while ($campo = mysqli_fetch_array($query)) {
                        $zona = recuperaDados("zona", "idZona", $campo['idZona']);
                        echo "<tr>";
                        echo "<td>" . $campo['local'] . "</td>";
                        echo "<td>" . $campo['estimativaPublico'] . "</td>";
                        echo "<td>" . $campo['logradouro'] . ", ".$campo['numero']." ".$campo['complemento']." ".$campo['bairro'].", ".$campo['cidade']." - ".$campo['estado'].", CEP ".$campo['cep']."</td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </li>
        </ul>
    </div>

    <div class="well">
        <p align="justify"><strong>Público alvo:</strong> <?php echo isset($projeto['publicoAlvo']) ? $projeto['publicoAlvo'] : null; ?></p>
        <p align="justify"><strong>Plano de divulgação:</strong> <?php echo isset($projeto['planoDivulgacao']) ? $projeto['planoDivulgacao'] : null; ?></p>
    </div>

    <div class="well">
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
                    $query = mysqli_query($con, $sql);
                    while ($campo = mysqli_fetch_array($query)) {
                        echo "<tr>";
                        echo "<td class='list_description'>" . $campo['nome'] . "</td>";
                        echo "<td class='list_description'>" . $campo['cpf'] . "</td>";
                        echo "<td class='list_description'>" . $campo['funcao'] . "</td>";
                        echo "</tr>";
                    } ?>
                </table>
            </li>
        </ul>
    </div>

    <?php
    $data = $projeto['inicioCronograma'];
    function tipoCronograma($data){
        $valores = explode('-',$data);
        if(isset($valores[2]) && is_numeric($valores[2])){
            if(count($valores) == 3 & checkdate($valores[1],$valores[2],$valores[0])){
                return true;
            }
            else{
                return false;
            }
        }
    }
    if(tipoCronograma($data)){
       ?>
        <div class="well">
            <ul class="list-group">
                <li class="list-group-item list-group-item-success"><b>Cronograma</b></li>
                <li class="list-group-item">
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Início do projeto:</strong> <?= isset($projeto['inicioCronograma']) ? exibirDataBr($projeto['inicioCronograma']) : null ?></td>
                            <td><strong>Fim do projeto:</strong> <?= isset($projeto['fimCronograma']) ?  exibirDataBr($projeto['fimCronograma']) : null ?></td>
                        </tr>
                </li>
                <li class="list-group-item">
                    <table class="table table-bordered">
                        <tr>
                            <td><strong>Captação de recursos:</strong></td>
                            <td><strong>Pré-Produção:</strong></td>
                            <td><strong>Produção:</strong></td>
                            <td><strong>Pós-Produção:</strong></td>
                            <td><strong>Prestação de Contas:</strong></td>
                        </tr>
                        <tr>
                            <td class='list_description exibir'><?= $cronograma['captacaoRecurso'] ?? '' ?></td>
                            <td class='list_description exibir'><?= $cronograma['preProducao'] ?? '' ?></td>
                            <td class='list_description exibir'><?= $cronograma['producao'] ?? '' ?></td>
                            <td class='list_description exibir'><?= $cronograma['posProducao'] ?? '' ?></td>
                            <td class='list_description exibir'><?= $cronograma['prestacaoContas'] ?? '' ?></td>
                        </tr>
                    </table>
                </li>
            </ul>
        </div>
    <?php
    }
    else{
        ?>
        <ul class="list-group">
            <li class="list-group-item list-group-item-success"><b>Cronograma Formato Antigo</b></li>
            <li class="list-group-item">
                <table class="table table-bordered">
                    <tr>
                        <td><strong>Início do cronograma:</strong>
                            <?=$projeto['inicioCronograma'] ?>
                        </td>
                        <td><strong>Fim do cronograma:</strong>
                            <?= $projeto['fimCronograma'] ?>
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
    <?php
    }
    ?>

    <div class="well">
        <ul class="list-group">
            <li class="list-group-item list-group-item-success"><b>Orçamento</b></li>
            <li class="list-group-item">
                <table class="table table-bordered">
                    <tr>
                        <?php
                        for ($i = 1; $i <= 8; $i++) {
                            $sql_etapa = "SELECT idEtapa FROM orcamento
                                        WHERE publicado > 0 AND idProjeto ='$idProjeto' AND idEtapa = '$i'
                                        ORDER BY idOrcamento";
                            $query_etapa = mysqli_query($con, $sql_etapa);
                            $lista = mysqli_fetch_array($query_etapa);

                            $etapa = recuperaDados("etapa", "idEtapa", $lista['idEtapa']);
                            echo "<td><strong>" . $etapa['etapa'] . ":</strong>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <?php
                        for ($i = 1; $i <= 8; $i++) {
                            $sql_etapa = "SELECT SUM(valorTotal) AS tot FROM orcamento
                                        WHERE publicado > 0 AND idProjeto ='$idProjeto' AND idEtapa = '$i'
                                        ORDER BY idOrcamento";
                            $query_etapa = mysqli_query($con, $sql_etapa);
                            $lista = mysqli_fetch_array($query_etapa);

                            echo "<td>R$ " . dinheiroParaBr($lista['tot']) . "</td>";
                        }
                        ?>
                    </tr>
                    <tr>
                        <?php
                        $sql_total = "SELECT SUM(valorTotal) AS tot FROM orcamento
                                    WHERE publicado > 0 AND idProjeto ='$idProjeto'
                                    ORDER BY idOrcamento";
                        $query_total = mysqli_query($con, $sql_total);
                        $total = mysqli_fetch_array($query_total);
                        echo "<td colspan='8'><strong>TOTAL: R$ " . dinheiroParaBr($total['tot']) . "</strong></td>";
                        ?>
                    </tr>
                </table>
            </li>
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
                    $query = mysqli_query($con, $sql);
                    while ($campo = mysqli_fetch_array($query)) {
                        $etapa = recuperaDados("etapa", "idEtapa", $campo['idEtapa']);
                        $medida = recuperaDados("unidade_medida", "idUnidadeMedida", $campo['idUnidadeMedida']);
                        echo "<tr>";
                        echo "<td class='list_description'>" . $etapa['etapa'] . "</td>";
                        echo "<td class='list_description'>" . $campo['descricao'] . "</td>";
                        echo "<td class='list_description'>" . $campo['quantidade'] . "</td>";
                        echo "<td class='list_description'>" . $medida['unidadeMedida'] . "</td>";
                        echo "<td class='list_description'>" . $campo['quantidadeUnidade'] . "</td>";
                        echo "<td class='list_description'>" . dinheiroParaBr($campo['valorUnitario']) . "</td>";
                        echo "<td class='list_description'>" . dinheiroParaBr($campo['valorTotal']) . "</td>";
                        echo "</tr>";
                    } ?>
                </table>
            </li>
        </ul>
    </div>

    <div class="well" align="left">
        <ul class="list-group">
            <li class="list-group-item list-group-item-success"><b>Mídias sociais</b></li>
            <li class="list-group-item"><strong>Link 1:</strong> <?= $video['midia_social_1'] ?></li>
            <li class="list-group-item"><strong>Link 2:</strong> <?= $video['midia_social_2'] ?></li>
            <li class="list-group-item">
                <?php

                if (!empty($video['video1'] || $video['video2'] || $video['video3'])) {
                    ?>
                    <table class='table table-condensed'>
                        <?php
                        foreach ($v as $key => $m) {
                            if (!empty($m)) {
                                if (isYoutubeVideo($m) == "youtube") {
                                    $desc = "https://www.youtube.com/oembed?format=json&url=" . $m;
                                    $obj = json_decode(file_get_contents($desc), true);
                                } else {
                                    echo "<div class='alert alert-danger'>
												<strong>Erro!</strong> O link ($m) não pode ser aberto, a plataforma aceita somente YouTube.
												</div>";
                                }
                                if (isYoutubeVideo($m) == "youtube") { ?>
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
                        } ?>
                    </table>
                    <?php
                } else {
                    echo "<p>Não há video(s) inserido(s).<p/><br/>";
                }
                ?>
            </li>
        </ul>
    </div>

    <?php
    exibirArquivosProjeto(3,$projeto['idProjeto']);
    exibirComplemento(3,$projeto['idProjeto']);
    exibirSolicitacaoAlteracao(3,$projeto['idProjeto']);
    exibirRecurso(3,$projeto['idProjeto']);
    ?>
    <table class="table table-bordered">
        <tr>
            <td colspan="3"><strong>Pertence às listas de empresas apenadas?</strong>
                <?php if ($projeto['empresaApenada'] == 1) {
                    echo "Sim";
                } else {
                    echo "Não";
                } ?>
            </td>
        </tr>
    </table>
    <?php
    exibirCertificados(3,$projeto['idProjeto']);
    exibirParecerProponente($projeto['idProjeto']);
    ?>
</div>

<script>
    let btnsMenos = document.querySelectorAll('.menos');// pega todos os buttons .menos
    let btnsMais = document.querySelectorAll('.mais');// pega todos os buttons .mais
    let captacaoRecurso = document.querySelector('#captacaoRecurso');
    let etapas = document.querySelectorAll('.progress input');
    let btnInserir = document.querySelector('input[name="insereCronograma"]');
    let listaEtapas = document.querySelectorAll('.exibir'); // lista


    const quantidadeMes = (val) => {

        if((val / 6.25) == 1) // meio
        {
            return `Metade de um mês`
        }
        else if((val / 6.25) == 2) // um
        {
            return `${(val / 12.5)} Mês`
        }
        else if((val / 6.25) == 3) 	// um e meio
        {
            return `${parseInt(val / 12.5)} Mês e Meio`
        }
        else if((val / 6.25) % 2 == 0) 	// par meses
        {
            return `${(val / 12.5)} Meses`
        }
        else{				// meses e meio
            return `${parseInt(val / 12.5)} Meses e Meio`
        }
    }

    const preencher = (item) => {
        let val = parseFloat(item.value)
        if(!isNaN(val)){
            elemento = item.parentNode.children[0]
            elemento.style.width = ((val / .5) * 6.25) + `%`
            elemento.innerHTML = quantidadeMes(parseFloat((val / .5) * 6.25)) // exibe qtd de meses
        }
    }

    for(let etapa of etapas){

        preencher(etapa)
    }

    for(let etapa of listaEtapas){
        etapa.innerHTML = quantidadeMes(parseFloat((etapa.innerHTML / .5) * 6.25))
    }
</script>