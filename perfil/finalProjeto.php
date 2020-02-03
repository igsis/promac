<?php



$con = bancoMysqli();
$idUsuario = $_SESSION['idUser'];
$idProjeto = $_SESSION['idProjeto'];
$tipoPessoa = $_SESSION['tipoPessoa'];

//$envioProjetos = recuperaDados('statusprojeto', 'idStatus', 1);
$projeto = recuperaDados("projeto", "idProjeto", $idProjeto);
$area = recuperaDados("area_atuacao", "idArea", $projeto['idAreaAtuacao']);
$renuncia = recuperaDados("renuncia_fiscal", "idRenuncia", $projeto['idRenunciaFiscal']);
$cronograma = recuperaDados("cronograma", "idCronograma", $projeto['idCronograma']);
if ($cronograma) {
    $tempoTotal = $cronograma['preProducao'] + $cronograma['producao'] + $cronograma['posProducao'];
} else {
    $tempoTotal = 0;
}
$video = recuperaDados("projeto", "idProjeto", $idProjeto);
$marca = recuperaDados("exposicao_marca", "id", $projeto['idExposicaoMarca']);
$v = array($video['video1'], $video['video2'], $video['video3']);

$tags = recuperaTags($idProjeto);

if ($tipoPessoa == "1") {
    $pf = recuperaDados("pessoa_fisica", "idPf", $idPf);
} else {
    $pj = recuperaDados("pessoa_juridica", "idPj", $idUsuario);
}
$alterar = 0;

if ($projeto['idEtapaProjeto'] == 6)
    $alterar = 1;
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php
        if ($_SESSION['tipoPessoa'] == 1) {
            $idPf = $_SESSION['idUser'];
            include '../perfil/includes/menu_interno_pf.php';
        } else {
            $idPj = $_SESSION['idUser'];
            include '../perfil/includes/menu_interno_pj.php';
        }
        ?>
        <div class="form-group">
            <h4>Resumo do Projeto</h4>
            <div class="alert alert-warning">
                <strong>Atenção!</strong> Confirme atentamente se os dados abaixo estão corretos!
            </div>
        </div>

        <div class="form-group">
            <?php
            /**Campos Obrigatórios**/
            if (isset($idProjeto)):
                require_once('validacaoCamposObrigatorios.php');
            endif;

            /**Arquivos Obrigatórios**/
            if (isset($tipoPessoa)):
                $tipoDoc = 'anexo';
                $idUser = $idUsuario;
                require_once('validacaoArquivosObrigatorios.php');
            endif;
            ?>
        </div>

        <div class="page-header">
            <h5>Informações do projeto</h5>
        </div>

        <div class="well">
            <p align="justify"><strong>Nome do Projeto:</strong> <?php echo $projeto['nomeProjeto']; ?></p>
            <p align="justify"><strong>Área de atuação:</strong> <?php echo $area['areaAtuacao'] ?></p>
            <p align="justify"><strong>Resumo do
                    projeto:</strong> <?php echo isset($projeto['resumoProjeto']) ? $projeto['resumoProjeto'] : null; ?>
            </p>
            <p align="justify"><strong>Tags:</strong> <?= implode("; ", $tags) ?></p>
            <p align="justify">
                <strong>Currículo:</strong> <?php echo isset($projeto['curriculo']) ? $projeto['curriculo'] : null; ?>
            </p>
            <p align="justify">
                <strong>Descrição do objeto cultural e atividades
                    propostas:</strong> <?php echo isset($projeto['descricao']) ? $projeto['descricao'] : null; ?>
            </p>
            <p align="justify">
                <strong>Objetivos
                    Gerais:</strong> <?php echo isset($projeto['objetivo']) ? $projeto['objetivo'] : null; ?>
            </p>
            <p align="justify">
                <strong>Objetivo
                    Específico:</strong> <?php echo isset($projeto['objetivoEspecifico']) ? $projeto['objetivoEspecifico'] : null; ?>
            </p>
            <p align="justify">
                <strong>Justificativa do
                    projeto:</strong> <?php echo isset($projeto['justificativa']) ? $projeto['justificativa'] : null; ?>
            </p>
            <p align="justify">
                <strong>Contrapartida:</strong> <?php echo isset($projeto['contrapartida']) ? $projeto['contrapartida'] : null; ?>
            </p>
            <p align="justify">
                <strong>Ingresso e forma de
                    acesso:</strong> <?php echo isset($projeto['ingresso']) ? $projeto['ingresso'] : null; ?>
            </p>
            <p align="justify">
                <strong>Democratização de acesso
                    :</strong> <?php echo isset($projeto['democratizacao']) ? $projeto['democratizacao'] : null; ?>
            </p>
            <p align="justify">
                <strong>Acessibilidade:</strong> <?php echo isset($projeto['acessibilidade']) ? $projeto['acessibilidade'] : null; ?>
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
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </li>
            </ul>
        </div>

        <div class="well">
            <p align="justify"><strong>Público
                    alvo:</strong> <?php echo isset($projeto['publicoAlvo']) ? $projeto['publicoAlvo'] : null; ?></p>
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
                            <th>Curriculo resumido</th>
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
                            <td><strong>Início do
                                    projeto:</strong> <?= isset($projeto['inicioCronograma']) ? exibirDataBr($projeto['inicioCronograma']) : null ?>
                            </td>
                            <td><strong>Fim do
                                    projeto:</strong> <?= isset($projeto['fimCronograma']) ? exibirDataBr($projeto['fimCronograma']) : null ?>
                            </td>
                        </tr>
                </li>
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
                            $despesa = recuperaDados("grupo_despesas", "id", $campo['grupo_despesas_id']);
                            $medida = recuperaDados("unidade_medida", "idUnidadeMedida", $campo['idUnidadeMedida']);
                            echo "<tr>";
                            echo "<td class='list_description'>" . $despesa['despesa'] . "</td>";
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
        <!--
        <div class="well">
            <p align="justify"><strong>Valor total do projeto:</strong> R$ <?php echo dinheiroParaBr($projeto['valorProjeto']) ?></p>
            <p align="justify"><strong>Valor do Incentivo solicitado no Pro-Mac:</strong> R$ <?php echo dinheiroParaBr($projeto['valorIncentivo']); ?><p>
            <p align="justify"><strong>Enquadramento da renúncia fiscal:</strong> <?php echo $renuncia['renunciaFiscal'] ?></p>
            <p align="justify"><strong>Descrição da exposição da marca:</strong> <?= $marca['exposicao_marca']; ?></p>
            <p align="justify"><strong>Indicação do valor do ingresso:</strong> <?= $projeto['indicacaoIngresso']; ?></p>
        </div>
-->
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

        <div class="page-header">
            <h5>Anexos do Projeto</h5>
        </div>

        <div class="well">
            <ul class="list-group">
                <li class="list-group-item"><?php exibirArquivos(7, $idProjeto); ?></li>
                <li class="list-group-item"><?php exibirArquivos(3, $idProjeto); ?></li>
            </ul>
        </div>

        <!--Pessoa Juridica-->
        <?php
        if ($projeto['tipoPessoa'] == 2) {
            $pj = recuperaDados("pessoa_juridica", "idPj", $projeto['idPj']);
            ?>
            <div class="page-header">
                <h5>Pessoa Jurídica</h5>
            </div>

            <div class="well">
                <p align="justify"><strong>Razão
                        social:</strong> <?php echo isset($pj['razaoSocial']) ? $pj['razaoSocial'] : null; ?></p>
                <p align="justify"><strong>CNPJ:</strong> <?php echo isset($pj['cnpj']) ? $pj['cnpj'] : null; ?></p>
                <p align="justify"><strong>CCM:</strong> <?php echo isset($pj['ccm']) ? $pj['ccm'] : null; ?></p>
                <p align="justify">
                    <strong>Endereço:</strong> <?= $pj['logradouro'] . ", " . $pj['numero'] . " " . $pj['complemento'] . " " . $pj['bairro'] . ", " . $pj['cidade'] . " - " . $pj['estado'] . ", CEP " . $pj['cep'] ?>
                <p align="justify">
                    <strong>Telefone:</strong> <?php echo isset($pj['telefone']) ? $pj['telefone'] : null; ?><?php echo isset($pj['celular']) ? " / " . $pj['celular'] : null; ?>
                </p>
                <p align="justify"><strong>Email:</strong> <?php echo isset($pj['email']) ? $pj['email'] : null; ?></p>
                <br/>
                <div>
                    <?php listaArquivosPessoaObs($projeto['idPj'], 2) ?>
                </div>
            </div>
            <?php
        } else {
            $pf = recuperaDados("pessoa_fisica", "idPf", $projeto['idPf']);
            ?>
            <div class="page-header">
                <h5>Pessoa Física</h5>
            </div>

            <div class="well">
                <p align="justify"><strong>Nome:</strong> <?php echo isset($pf['nome']) ? $pf['nome'] : null; ?></p>
                <p align="justify"><strong>CPF:</strong> <?php echo isset($pf['cpf']) ? $pf['cpf'] : null; ?></p>
                <p align="justify">
                    <strong>Endereço:</strong> <?= $pf['logradouro'] . ", " . $pf['numero'] . " " . $pf['complemento'] . " " . $pf['bairro'] . ", " . $pf['cidade'] . " - " . $pf['estado'] . ", CEP " . $pf['cep'] ?>
                <p align="justify">
                    <strong>Telefone:</strong> <?php echo isset($pf['telefone']) ? $pf['telefone'] : null; ?><?php echo isset($pf['celular']) ? " / " . $pf['celular'] : null; ?>
                </p>
                <p align="justify"><strong>Email:</strong> <?php echo isset($pf['email']) ? $pf['email'] : null; ?></p>
                <br/>
                <div>
                    <?php listaArquivosPessoaObs($projeto['idPf'], 1) ?>
                </div>
            </div>
            <?php
        }
        ?>

    </div>
    <!--Inicio do termo do contrato-->
    <?php
    $statusProjeto = recuperaStatus();
    if ($statusProjeto == 1) {
        if (sizeof($erros) == 0 && sizeof($arqPendentes) == 0) { ?>
            <div class="container">
                <a href="#">
                    <div class="btn btn-danger">
                        <input type="hidden" name="termos" id="termo" value="false">
                        <a href="#" data-toggle="modal" data-target="#myModal" style="color: #fff;">CLIQUE AQUI PARA
                            PROSSEGUIR</a>
                    </div>
                </a>
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Termo de aceite</h4>
                            </div>

                            <div class="modal-body">
                                <p>Li e aceito as condições para participação no Pro-Mac previstas na Lei nº
                                    15.948/2013,
                                    Decreto nº 58.041/2017, bem como demais atos regulamentares.</p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"
                                        id="btnRejeitar">Rejeitar
                                </button>
                                <button type="button" class="btn btn-success" data-dismiss="modal"
                                        id="btnAceitar">Aceitar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else { ?>
        <div class="col-md-offset-2 col-md-8">
            <div class="form-group">
                <div class="alert alert-warning">
                    <strong>Atenção!</strong> O envio de projetos está desabilitado pela SMC!
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <!--Fim do termo do contrato-->
    </div>
    <!-- Botão para Prosseguir -->
    <div class="form-group">
        <div class="col-md-offset-5 col-md-2">
            <form class="form-horizontal" role="form" action="?perfil=informacoes_administrativas" method="post">
                <?php
                if ($alterar == 1) { ?>
                    <input type="hidden" name="alterar" value="<?php echo $alterar; ?>">
                <?php } ?>
                <br>
                <button id="inptEnviar" class="btn btn-theme btn-lg" type="button" data-toggle="modal"
                        data-target="#confirmApagar" data-title="Inscrever Projeto?"
                        data-message="Deseja realmente inscrever o projeto <?= $projeto['nomeProjeto'] ?>? Após o envio não será possível editá-lo."
                        style="display: none;">Inscrever Projeto
                </button>

                <!-- <input type="hidden" value="Inscrever Projeto" id="inptEnviar"
                    class="btn btn-theme btn-lg btn-block"> -->
            </form>
            <!-- INICIO Modal de confirmação de envio do projeto -->
            <div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Inscrever Projeto?</h4>
                        </div>
                        <div class="modal-body">
                            <p>Confirma?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-success" id="confirm">Inscrever</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FIM Modal de confirmação de envio do projeto -->
        </div>
    </div>
</section>

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

</script>