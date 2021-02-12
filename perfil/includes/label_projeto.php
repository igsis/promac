<?php
$id = $projeto['tipoPessoa'];
$idP = $projeto['idProjeto'];
$tags = recuperaTags($idP);
$postosTrabalho = recuperaDados("postos_trabalho", "idProjeto", $idP);

if ($id == 1) {
    $idPess = $projeto['idPf'];
} else if ($id == 2) {
    $idPess = $projeto['idPj'];
}
?>
<div role="tabpanel" class="tab-pane fade" id="projeto">
    <div class="form-group">
        <div class="col-md-offset-4 col-md-4">
            <a href='<?php echo "../pdf/pdf_teste.php?tipo=$id&projeto=$idP&pessoa=$idPess"; ?>' target='_blank'
               class="btn btn-theme btn-md btn-block"><strong>Gerar Projeto</strong></a><br/>
        </div>
    </div>


    <table class="table table-bordered">
        <tr>
            <td>
                <strong>Protocolo (nº ISP):</strong>
                <span data-mask="0000.00.00/0000000"><?= $projeto['protocolo'] ?></span>
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
            <td colspan="2"><strong>Valor do projeto:</strong>R$
                <?php
                if (isset($projeto['valorProjeto']) && $projeto['valorProjeto'] > 0) {
                    echo dinheiroParabr(isset($projeto['valorProjeto']) ? $projeto['valorProjeto'] : '');
                } else {
                    echo dinheiroParaBr(isset($projeto['valorIncentivo']) ? $projeto['valorIncentivo'] : '');
                }
                ?>
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
        <p align="justify"><strong>Tags:</strong> <?= implode("; ", $tags) ?></p>

        <p align="justify">
            <strong>Resumo do
                projeto:</strong> <?php echo isset($projeto['resumoProjeto']) ? $projeto['resumoProjeto'] : null; ?>
        </p>
        <p align="justify">
            <strong>Currículo do
                proponente:</strong> <?php echo isset($projeto['curriculo']) ? $projeto['curriculo'] : null; ?>
        </p>
        <p align="justify">
            <strong>Descrição do objeto cultural e atividades
                propostas:</strong> <?php echo isset($projeto['descricao']) ? $projeto['descricao'] : null; ?>
        </p>
        <p align="justify">
            <strong>Objetivos Gerais:</strong> <?php echo isset($projeto['objetivo']) ? $projeto['objetivo'] : null; ?>
        </p>
        <p align="justify">
            <strong>Objetivos
                Específicos:</strong> <?php echo isset($projeto['objetivoEspecifico']) ? $projeto['objetivoEspecifico'] : null; ?>
        </p>
        <p align="justify">
            <strong>Justificativa do
                projeto:</strong> <?php echo isset($projeto['justificativa']) ? $projeto['justificativa'] : null; ?>
        </p>
        <p align="justify">
            <strong>Quantos postos de trabalho diretos o seu projeto gera, ainda que
                temporariamente?</strong> <?php echo isset($postosTrabalho['quantidade']) ? $postosTrabalho['quantidade'] : null; ?>
        </p>
        <p align="justify">
            <strong>Qual a média, em meses, de tempo de contratação de cada posto de
                trabalho?</strong> <?php echo isset($postosTrabalho['media_meses']) ? "{$postosTrabalho['media_meses']} meses" : null; ?>
        </p>
        <p align="justify">
            <strong>Qual a média, em reais, de remuneração de cada posto de
                trabalho?</strong> <?php echo isset($postosTrabalho['media_valor']) ? "R$ " . dinheiroParaBr($postosTrabalho['media_valor']) : null; ?>
        </p>
    </div>

    <div class="well">
        <ul class="list-group">
            <li class="list-group-item list-group-item-success"><b>Plano de Trabalho</b></li>
            <li class="list-group-item">
                <?php recuperaPlanos($projeto['idProjeto']); ?>
            </li>
        </ul>
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
                        <th>Distrito</th>
                        <th>Faixa</th>
                        <th>Obs. Local</th>
                    </tr>
                    <?php
                    $sql = "SELECT lr.*, d.distrito, d.faixa FROM locais_realizacao AS lr
                                LEFT JOIN distrito d on lr.idDistrito = d.idDistrito
								WHERE lr.publicado = 1 AND lr.idProjeto = '{$projeto['idProjeto']}'";
                    $query = mysqli_query($con, $sql);
                    while ($campo = mysqli_fetch_array($query)) {
                        $zona = recuperaDados("zona", "idZona", $campo['idZona']);
                        echo "<tr>";
                        echo "<td>" . $campo['local'] . "</td>";
                        echo "<td>" . $campo['estimativaPublico'] . "</td>";
                        echo "<td>" . $campo['logradouro'] . ", " . $campo['numero'] . " " . $campo['complemento'] . " " . $campo['bairro'] . ", " . $campo['cidade'] . " - " . $campo['estado'] . ", CEP " . $campo['cep'] . "</td>";
                        echo "<td>" . $campo['distrito'] . "</td>";
                        echo "<td> Faixa " . $campo['faixa'] . "</td>";
                        if ($campo['observacaoLocal'] != ''):
                        echo "<td>
                                <button class='btn btn-default' id='btn-info-modal' type='button' data-toggle='modal' 
                                data-target='#infoObservacao' data-text='" . $campo['observacaoLocal'] . "' style='border-radius: 30px;'>
                                    <i class='fa fa-info-circle'></i>
                                </button>
                              </td>";
                        else:
                            echo "<td></td>";
                        endif;
                            echo "</tr>";
                    }
                    ?>
                </table>
            </li>
        </ul>
    </div>

    <div class="well">
        <p align="justify">
            <strong>Público de
                Alvo:</strong> <?php echo isset($projeto['publicoAlvo']) ? $projeto['publicoAlvo'] : null; ?>
        </p>
        <p align="justify">
            <strong>Contrapartida:</strong> <?php echo isset($projeto['contrapartida']) ? $projeto['contrapartida'] : null; ?>
        </p>
        <p align="justify">
            <strong>Ingresso e forma de
                acesso:</strong> <?php echo isset($projeto['ingresso']) ? $projeto['ingresso'] : null; ?>
        </p>
        <p align="justify">
            <strong>Democratização de
                acesso:</strong> <?php echo isset($projeto['democratizacao']) ? $projeto['democratizacao'] : null; ?>
        </p>
        <p align="justify">
            <strong>Acessibilidade:</strong> <?php echo isset($projeto['acessibilidade']) ? $projeto['acessibilidade'] : null; ?>
        </p>
    </div>

    <div class="well">
        <p align="justify">
            <strong>Plano de
                Divulgação:</strong> <?php echo isset($projeto['planoDivulgacao']) ? $projeto['planoDivulgacao'] : null; ?>
        </p>
        <ul class="list-group">
            <li class="list-group-item list-group-item-success"><b>Plano de divulgação</b></li>
            <li class="list-group-item">
                <?php recuperaMaterial($idProjeto); ?>
            </li>
        </ul>
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
                        <th>Curriculo</th>
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
                        echo "<td class='list_description'>" . $campo['curriculo'] . "</td>";
                        echo "</tr>";
                    } ?>
                </table>
            </li>
        </ul>
    </div>

    <div class="well">
        <ul class="list-group">
            <li class="list-group-item list-group-item-success"><b>Cronograma</b></li>
            <li class="list-group-item">
                <table class="table table-bordered">
                    <tr>
                        <td><strong>Pré-Produção:</strong></td>
                        <td><strong>Produção:</strong></td>
                        <td><strong>Pós-Produção:</strong></td>
                        <td><strong>Total em Meses da Execução:</strong></td>
                    </tr>
                    <tr>
                        <td class='list_description exibir'><?= $cronograma['preProducao'] ?? '' ?></td>
                        <td class='list_description exibir'><?= $cronograma['producao'] ?? '' ?></td>
                        <td class='list_description exibir'><?= $cronograma['posProducao'] ?? '' ?></td>
                        <td class='list_description exibir'><?= $cronograma['totalExecucao'] ?? '' ?></td>
                    </tr>
                </table>
            </li>
        </ul>
    </div>

    <div class="well">
        <ul class="list-group">
            <li class="list-group-item list-group-item-success"><b>Orçamento</b></li>
            <li class="list-group-item">
                <?php recuperaTabelaOrcamento($idProjeto); ?>
            </li>
            <li class="list-group-item">
                <table class="table table-bordered">
                    <tr>
                        <td width='25%'><strong>Grupo de Despesa</strong></td>
                        <td><strong>Descrição</strong></td>
                        <td width='5%'><strong>Qtde</strong></td>
                        <td width='5%'><strong>Unid. Med.</strong></td>
                        <td width='5%'><strong>Ocorrências</strong></td>
                        <td><strong>Valor Unit.</strong></td>
                        <td><strong>Valor Total</strong></td>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM orcamento
                                WHERE publicado > 0 AND idProjeto ='$idProjeto'
                                ORDER BY idEtapa";
                    $query = mysqli_query($con, $sql);
                    while ($campo = mysqli_fetch_array($query)) {
                        $despesa = recuperaDados("grupo_despesas", "id", $campo['grupo_despesas_id']);
                        $medida = recuperaDados("unidade_medida", "idUnidadeMedida", $campo['idUnidadeMedida']);
                        ?>
                        <tr>
                            <td class='list_description'><?= $despesa['despesa'] ?? '' ?></td>
                            <td class='list_description'><?= $campo['descricao'] ?? '' ?></td>
                            <td class='list_description'><?= $campo['quantidade'] ?? '' ?></td>
                            <td class='list_description'><?= $medida['unidadeMedida'] ?? '' ?></td>
                            <td class='list_description'><?= $campo['quantidadeUnidade'] ?? '' ?></td>
                            <td class='list_description'><?= dinheiroParaBr($campo['valorUnitario']) ?? '' ?></td>
                            <td class='list_description'><?= dinheiroParaBr($campo['valorTotal']) ?? '' ?></td>
                        </tr>
                        <?php
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

    <div class="well">
        <ul class="list-group">
            <li class="list-group-item list-group-item-success"><b>Foto do Projeto</b></li>
            <li class="list-group-item"><?php exibirArquivos(7, $idProjeto); ?></li>
        </ul>
    </div>

    <?php
    exibirArquivosProjeto(3, $projeto['idProjeto']);
    exibirComplemento(3, $projeto['idProjeto']);
    exibirSolicitacaoAlteracao(3, $projeto['idProjeto']);
    exibirRecurso(3, $projeto['idProjeto']);
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
    exibirCertificados(3, $projeto['idProjeto']);
    exibirParecerProponente($projeto['idProjeto']);
    ?>
</div>

<div class="modal fade" id="infoObservacao" role="dialog" aria-labelledby="infoObservacaoLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Explicação sobre os locais de realização do projeto</h4>
            </div>
            <div class="modal-body" style="text-align: left;">
                <p id="texto-local"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    let btnsMenos = document.querySelectorAll('.menos');// pega todos os buttons .menos
    let btnsMais = document.querySelectorAll('.mais');// pega todos os buttons .mais
    let captacaoRecurso = document.querySelector('#captacaoRecurso');
    let etapas = document.querySelectorAll('.progress input');
    let btnInserir = document.querySelector('input[name="insereCronograma"]');
    let listaEtapas = document.querySelectorAll('.exibir'); // lista


    const quantidadeMes = (val) => {

        if ((val / 6.25) == 1) // meio
        {
            return `Metade de um mês`
        } else if ((val / 6.25) == 2) // um
        {
            return `${(val / 12.5)} Mês`
        } else if ((val / 6.25) == 3) 	// um e meio
        {
            return `${parseInt(val / 12.5)} Mês e Meio`
        } else if ((val / 6.25) % 2 == 0) 	// par meses
        {
            return `${(val / 12.5)} Meses`
        } else {				// meses e meio
            return `${parseInt(val / 12.5)} Meses e Meio`
        }
    }

    const preencher = (item) => {
        let val = parseFloat(item.value)
        if (!isNaN(val)) {
            elemento = item.parentNode.children[0]
            elemento.style.width = ((val / .5) * 6.25) + `%`
            elemento.innerHTML = quantidadeMes(parseFloat((val / .5) * 6.25)) // exibe qtd de meses
        }
    }

    for (let etapa of etapas) {
        preencher(etapa)
    }

    for (let etapa of listaEtapas) {
        etapa.innerHTML = quantidadeMes(parseFloat((etapa.innerHTML / .5) * 6.25))
    }

    $("#btn-info-modal").click(function (){
       let content = $(this).data('text');
       $('#texto-local').text(content);
    });

</script>