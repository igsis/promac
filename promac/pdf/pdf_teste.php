<?php
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

//CONEXÃO COM BANCO DE DADOS

$con = bancoMysqli();

$idProjeto = $_GET['projeto'];
$idPessoa = $_GET['pessoa'];

$ano = date('Y');

$projeto = recuperaDados("projeto", "idProjeto", $idProjeto);
$area = recuperaDados("area_atuacao", "idArea", $projeto['idAreaAtuacao']);
$renuncia = recuperaDados("renuncia_fiscal", "idRenuncia", $projeto['idRenunciaFiscal']);
$cronograma = recuperaDados("cronograma", "idCronograma", $projeto['idCronograma']);
$video = recuperaDados("projeto", "idProjeto", $idProjeto);
$marca = recuperaDados("exposicao_marca", "id", $projeto['idExposicaoMarca']);
$v = array($video['video1'], $video['video2'], $video['video3']);
$tags = recuperaTags($idProjeto);

$tipoPessoa = $projeto['tipoPessoa'];

if($tipoPessoa == 1)
{
    $pf = recuperaDados("pessoa_fisica","idPf",$projeto['idPf']);
    $sqlInfosAdicionais = "SELECT g.genero, e.etnia, pia.lei_incentivo, pia.nome_lei FROM pessoa_informacao_adicional AS pia
                            INNER JOIN generos AS g ON pia.genero = g.id
                            INNER JOIN etnias AS e ON pia.etnia = e.id
                            WHERE tipo_pessoa_id = 1 AND pessoa_id = '{$pf['idPf']}'";
    $infoAdicionais = $con->query($sqlInfosAdicionais)->fetch_assoc();
}
else
{
    $pj = recuperaDados("pessoa_juridica","idPj",$projeto['idPj']);
    $rep = recuperaDados("representante_legal","idRepresentanteLegal",$pj['idRepresentanteLegal']);
    $sqlInfosAdicionais = "SELECT g.genero, e.etnia, pia.lei_incentivo, pia.nome_lei FROM pessoa_informacao_adicional AS pia
                            INNER JOIN generos AS g ON pia.genero = g.id
                            INNER JOIN etnias AS e ON pia.etnia = e.id
                            WHERE tipo_pessoa_id = 2 AND pessoa_id = '{$pj['idRepresentanteLegal']}'";
    $infoAdicionais = $con->query($sqlInfosAdicionais)->fetch_assoc();
}
?>
<html lang="br">
<head>
    <title>SMC / Pro-Mac - Programa Municipal de Apoio a Projetos Culturais</title>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- JQUEY Mask -->
    <script src="../visual/dist/js/jquery-1.12.4.min.js"></script>
    <script src="../visual/dist/js/jquery.mask.js"></script>
    <!-- JQuery -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="../visual/js/jquery.js"></script>
    <!-- CSS -->
    <style>

        body {
            font-size: 15px;
            font-family: Arial;
            margin-top: 30px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid #9e9e9e;
        }

        @page {
            margin: 20mm;
            margin-left: 70px;
            margin-right: 70px;
            page-break-inside: avoid;
            size: A4;
        }
    </style>
</head>
<body>
<section id='list_items' class='home-section bg-white'>
    <div class='container' style='height: 800px;'>
        <h3 style="text-transform: uppercase;"><b>Projeto: <?= $projeto['nomeProjeto'] ?> </b></h3>
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
                <td colspan="2"><strong>Valor do projeto:</strong> R$
                    <?php echo
                    dinheiroParabr(isset($projeto['valorProjeto'])
                        ? $projeto['valorProjeto']
                        : ''); ?>
                </td>
                <td><strong>Renúncia Fiscal:</strong> <?php echo $renuncia['renunciaFiscal'] ?></td>
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
        <br/>
        <?php
        if ($tipoPessoa == 1) {
            ?>
            <h3 align="center"><b>Dados de pessoa física</b></h3>
            <p align="justify"><strong>Nome:</strong> <?php echo isset($pf['nome']) ? $pf['nome'] : null; ?></p>
            <p align="justify"><strong>CPF:</strong> <?php echo isset($pf['cpf']) ? $pf['cpf'] : null; ?></p>
            <p align="justify"><strong>Endereço:</strong> <?= $pf['logradouro'] . ", ".$pf['numero']." ".$pf['complemento']." ".$pf['bairro'].", ".$pf['cidade']." - ".$pf['estado'].", CEP ".$pf['cep'] ?>
            <p align="justify"><strong>Telefone:</strong> <?php echo isset($pf['telefone']) ? $pf['telefone'] : null; ?><?php echo isset($pf['celular']) ? " / ".$pf['celular'] : null; ?></p>
            <p align="justify"><strong>Email:</strong> <?php echo isset($pf['email']) ? $pf['email'] : null; ?></p>
            <?php
        } else {
            ?>
            <h3 align="center"><b>Dados de pessoa jurídica</b></h3>
            <p align="justify"><strong>Razão social:</strong> <?php echo isset($pj['razaoSocial']) ? $pj['razaoSocial'] : null; ?></p>
            <p align="justify"><strong>CNPJ:</strong> <?php echo isset($pj['cnpj']) ? $pj['cnpj'] : null; ?></p>
            <p align="justify"><strong>CCM:</strong> <?php echo isset($pj['ccm']) ? $pj['ccm'] : null; ?></p>
            <p align="justify"><strong>Endereço:</strong> <?= $pj['logradouro'] . ", ".$pj['numero']." ".$pj['complemento']." ".$pj['bairro'].", ".$pj['cidade']." - ".$pj['estado'].", CEP ".$pj['cep'] ?>
            <p align="justify"><strong>Telefone:</strong> <?php echo isset($pj['telefone']) ? $pj['telefone'] : null; ?><?php echo isset($pj['celular']) ? " / ".$pj['celular'] : null; ?></p>
            <p align="justify"><strong>Email:</strong> <?php echo isset($pj['email']) ? $pj['email'] : null; ?></p>
            <p align="justify"><strong>Cooperativa:</strong> <?php echo isset($pj['cooperativa']) ? $pj['cooperativa'] == 1 ? 'Sim' : 'Não' : null; ?></p>
            <br/>

            <h3 align="center"><b>Dados do representante legal</b></h3>
            <p align="justify"><strong>Nome:</strong> <?php echo isset($rep['nome']) ? $rep['nome'] : null; ?></p>
            <p align="justify"><strong>CPF:</strong> <?php echo isset($rep['cpf']) ? $rep['cpf'] : null; ?></p>
            <p align="justify"><strong>RG:</strong> <?php echo isset($rep['rg']) ? $rep['rg'] : null; ?></p>
            <p align="justify"><strong>Endereço:</strong> <?= $rep['logradouro'] . ", ".$rep['numero']." ".$rep['complemento']." ".$rep['bairro'].", ".$rep['cidade']." - ".$rep['estado'].", CEP ".$rep['cep'] ?>
            <p align="justify"><strong>Telefone:</strong> <?php echo isset($rep['telefone']) ? $rep['telefone'] : null; ?><?php echo isset($rep['celular']) ? " / ".$rep['celular'] : null; ?></p>
            <p align="justify"><strong>Email:</strong> <?php echo isset($rep['email']) ? $rep['email'] : null; ?></p>
            <p align="justify"><strong>Genero:</strong> <?= isset($rep) ? $infoAdicionais['genero'] : '' ?></p>
            <p align="justify"><strong>Etnia:</strong> <?= isset($rep) ? $infoAdicionais['etnia'] : '' ?></p>
            <p align="justify"><strong>Já participa de algum projeto de lei? Se sim, qual?</strong>
                <?php if (isset($rep)) {
                    if ($infoAdicionais['lei_incentivo'] == 1) {
                        echo $infoAdicionais['nome_lei'];
                    } else {
                        echo "Não";
                    }
                }
                ?>
            </p>
            <?php
        }
        ?>

        <br><br>
        <h3 align="center"><b>Dados do projeto</b></h3>

        <p align="justify"><strong>Nome do projeto:</strong> <?php echo $projeto['nomeProjeto']; ?></p>
        <p align="justify"><strong>Área de atuação:</strong> <?php echo $area['areaAtuacao'] ?></p>
        <p align="justify"><strong>Tags:</strong> <?= implode("; ", $tags) ?></p>

        <p align="justify">
            <strong>Resumo do projeto:</strong> <?php echo isset($projeto['resumoProjeto']) ? $projeto['resumoProjeto'] : null; ?>
        </p>
        <p align="justify">
            <strong>Currículo do proponente:</strong> <?php echo isset($projeto['curriculo']) ? $projeto['curriculo'] : null; ?>
        </p>
        <p align="justify">
            <strong>Descrição do objeto cultural e atividades propostas:</strong> <?php echo isset($projeto['descricao']) ? $projeto['descricao'] : null; ?>
        </p>
        <p align="justify">
            <strong>Objetivos Gerais:</strong> <?php echo isset($projeto['objetivo']) ? $projeto['objetivo'] : null; ?>
        </p>
        <p align="justify">
            <strong>Objetivos Específicos:</strong> <?php echo isset($projeto['objetivoEspecifico']) ? $projeto['objetivoEspecifico'] : null; ?>
        </p>
        <p align="justify">
            <strong>Justificativa do projeto:</strong> <?php echo isset($projeto['justificativa']) ? $projeto['justificativa'] : null; ?>
        </p>

        <br>
        <p align="center"><strong>Plano de Trabalho</strong></p>
        <?php recuperaPlanos($idProjeto); ?>

        <br>
        <p align="center">
            <strong>Local </strong><br/>
        </p>
        <table class="table table-bordered" border="1" width="100%">
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
                echo "<td>". $campo['observacaoLocal'] ."</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <p align="justify">
            <strong>Público de Alvo:</strong> <?php echo isset($projeto['publicoAlvo']) ? $projeto['publicoAlvo'] : null; ?>
        </p>
        <p align="justify">
            <strong>Contrapartida:</strong> <?php echo isset($projeto['contrapartida']) ? $projeto['contrapartida'] : null; ?>
        </p>
        <p align="justify">
            <strong>Ingresso e forma de acesso:</strong> <?php echo isset($projeto['ingresso']) ? $projeto['ingresso'] : null; ?>
        </p>
        <p align="justify">
            <strong>Democratização de acesso:</strong> <?php echo isset($projeto['democratizacao']) ? $projeto['democratizacao'] : null; ?>
        </p>
        <p align="justify">
            <strong>Acessibilidade:</strong> <?php echo isset($projeto['acessibilidade']) ? $projeto['acessibilidade'] : null; ?>
        </p>

        <br>
        <p align="center"><strong>Plano de Divulgação</strong></p>
        <p align="justify">
            <strong>Plano de Divulgação:</strong> <?php echo isset($projeto['planoDivulgacao']) ? $projeto['planoDivulgacao'] : null; ?>
        </p>
        <?php recuperaMaterial($idProjeto); ?>

        <br>
        <p align="center">
            <strong>Ficha Técnica</strong><br/>
        </p>
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
        <br>
        <p align="center">
            <strong>Cronograma</strong><br/>
        </p>
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

        <br>
        <p align="center">
            <strong>Orçamento</strong><br/>
        </p>
        <?php if ($projeto['edital'] != 2020): ?>
            <table class="table table-bordered" border="1" width="100%">
                <tr>
                    <?php
                    for ($i = 1; $i <= 8; $i++) {
                        $sql_etapa = "SELECT idEtapa FROM orcamento
                                        WHERE publicado > 0 AND idProjeto ='$idProjeto' AND idEtapa = '$i'
                                        ORDER BY idOrcamento";
                        $query_etapa = mysqli_query($con, $sql_etapa);
                        $lista = mysqli_fetch_array($query_etapa);

                        if ($lista != null) {
                            $etapa = recuperaDados("etapa", "idEtapa", $lista['idEtapa']);
                            echo "<td><strong>" . $etapa['etapa'] . ":</strong>";
                        } else {
                            echo "<td><strong></strong>";
                        }
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
        <?php else: ?>
            <?php recuperaTabelaOrcamento($idProjeto); ?>
        <?php endif; ?>
        <br/>
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
                <td class='list_description'><?= $despesa['despesa'] ?></td>
                <td class='list_description'><?= $campo['descricao'] ?></td>
                <td class='list_description'><?= $campo['quantidade'] ?? "" ?></td>
                <td class='list_description'><?= $medida['unidadeMedida'] ?? "" ?></td>
                <td class='list_description'><?= $campo['quantidadeUnidade'] ?></td>
                <td class='list_description'><?= dinheiroParaBr($campo['valorUnitario']) ?></td>
                <td class='list_description'><?= dinheiroParaBr($campo['valorTotal']) ?></td>
                </tr>
                <?php
            } ?>
        </table>
        <?php $marca = recuperaDados("exposicao_marca", "id", $projeto['idExposicaoMarca']); ?>
        <p align="justify"><strong>Valor total do projeto:</strong> R$ <?php echo dinheiroParaBr($projeto['valorProjeto']) ?></p>
        <p align="justify"><strong>Valor do Incentivo solicitado no Pro-Mac:</strong> R$ <?php echo dinheiroParaBr($projeto['valorIncentivo']); ?><p>
        <p align="justify"><strong>Enquadramento da renúncia fiscal:</strong> <?php echo $renuncia['renunciaFiscal'] ?></p>
        <p align="justify"><strong>Descrição da exposição da marca:</strong> <?= $marca['exposicao_marca'] ?? ""; ?></p>
        <p align="justify"><strong>Indicação do valor do ingresso:</strong> <?= $projeto['indicacaoIngresso']; ?></p>

        <br>
        <p align="center">
            <strong>Mídias Sociais</strong><br/>
        </p>
        <p align="justify"><strong>Link 1:</strong> <?= $video['midia_social_1'] ?></p>
        <p align="justify"><strong>Link 2:</strong> <?= $video['midia_social_2'] ?></p>
        <p align="justify"><strong>Video 1:</strong> <?= $video['video1'] ?></p>
        <p align="justify"><strong>Video 2:</strong> <?= $video['video2'] ?></p>
        <p align="justify"><strong>Video 3:</strong> <?= $video['video3'] ?></p>

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
    </div>
</body>
</html>

<script type="text/javascript">
    setTimeout(function () { window.print(); }, 500);
    window.onfocus = function () { setTimeout(function () { window.close(); }, 500); }
</script>