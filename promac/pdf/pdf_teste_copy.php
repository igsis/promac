<?php
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

//CONEXÃO COM BANCO DE DADOS

$con = bancoMysqli();

$tipoPessoa = $_GET['tipo'];
$idProjeto = $_GET['projeto'];
$idPessoa = $_GET['pessoa'];

$ano = date('Y');

$queryProjeto = "SELECT * FROM projeto WHERE idProjeto = '$idProjeto' AND publicado = 1";
$enviaP = mysqli_query($con, $queryProjeto);
/*
  Dados gerais do projeto.
*/
while ($row = mysqli_fetch_array($enviaP)) {
    $protocoloP = $row['protocolo'];
    $nomeProjeto = $row['nomeProjeto'];
    $idAreaAtuacao = $row['idAreaAtuacao']; //search it
    $vProjeto = $row['valorProjeto'];
    $vIncentivo = $row['valorIncentivo'];
    $vFinanciamento = $row['valorFinanciamento'];
    $idRenunciaFiscal = $row['idRenunciaFiscal']; //search it
    $exposicaoMarca = $row['exposicaoMarca'];
    $resumoProjeto = $row['resumoProjeto'];
    $curriculo = $row['curriculo'];
    $descricao = $row['descricao'];
    $justificativa = $row['justificativa'];
    $objetivo = $row['objetivo'];
    $metodologia = $row['metodologia'];
    $contrapartida = $row['contrapartida'];
    $publicoAlvo = $row['publicoAlvo'];
    $planoDivulgacao = $row['planoDivulgacao'];
    $inicioCronograma = $row['inicioCronograma'];
    $fimCronograma = $row['fimCronograma'];
    $idCronograma = $row['idCronograma']; //search it
    $totalPreProducao = $row['totalPreProducao'];
    $totalProducao = $row['totalProducao'];
    $totalImprensa = $row['totalImprensa'];
    $totalAdministrativos = $row['totalCustosAdministrativos'];
    $totalImpostos = $row['totalImpostos'];
    $totalAgenciamento = $row['totalAgenciamento'];
    $totalOutrosFinanciamentos = $row['totalOutrosFinanciamentos'];
    $video1 = $row['video1'];
    $video2 = $row['video2'];
    $video3 = $row['video3'];
    $valorAProvado = $row['valorAprovado'];
    $idStatus = $row['idEtapaProjeto'];
}

/*
  Dados dos locais de realização.
*/
$queryLocal = "SELECT * FROM locais_realizacao AS LOC
                LEFT JOIN zona ON LOC.idZona =  zona.idZona
                LEFT JOIN subprefeitura ON LOC.idSubprefeitura = subprefeitura.idSubprefeitura
                LEFT JOIN distrito ON LOC.idDistrito = distrito.idDistrito
                WHERE idProjeto = '$idProjeto' AND publicado = 1";
$enviaLocal = mysqli_query($con, $queryLocal);


/*
  Dados de renúncia fiscal.
*/
$queryRen = "SELECT renunciaFiscal from renuncia_fiscal where idRenuncia = '$idRenunciaFiscal'";
$enviaRen = mysqli_query($con, $queryRen);
$rows = mysqli_fetch_array($enviaRen);
$renunciaFiscal = $rows['renunciaFiscal'];

/*
  Dados do cronograma.
*/
$queryCrono = "SELECT * FROM cronograma WHERE idCronograma = '$idCronograma'";
$enviaCrono = mysqli_query($con, $queryCrono);
while ($rowCron = mysqli_fetch_array($enviaCrono)) {
    $captacaoRecurso = $rowCron['captacaoRecurso'];
    $preProducao = $rowCron['preProducao'];
    $producao = $rowCron['producao'];
    $posProducao = $rowCron['posProducao'];
    $prestacaoContas = $rowCron['prestacaoContas'];
}

/*
  Dados da área de atuação.
*/
$queryAreaAt = "SELECT areaAtuacao FROM area_atuacao WHERE idArea = '$idAreaAtuacao'";
$enviaAreaAt = mysqli_query($con, $queryAreaAt);
$rowArea = mysqli_fetch_array($enviaAreaAt);
$areaAtuacao = $rowArea['areaAtuacao'];

/*
  Dados de orçamento.
*/
$queryOrca = "SELECT * FROM orcamento AS ORC
              LEFT JOIN etapa ON ORC.idEtapa = etapa.idEtapa
              LEFT JOIN unidade_medida ON ORC.idUnidadeMedida = unidade_medida.idUnidadeMedida
              WHERE idProjeto = '$idProjeto' AND publicado = 1 ORDER BY idOrcamento ASC";
$enviaOrca = mysqli_query($con, $queryOrca);

$countTabela = mysqli_num_rows($enviaOrca);

/*
  Ficha técnica
*/
$queryFicha = "SELECT * FROM ficha_tecnica WHERE idProjeto = '$idProjeto' AND publicado = 1";
$enviaFicha = mysqli_query($con, $queryFicha);

/*
  Dados das notas.
*/
$queryNota = "SELECT * FROM notas WHERE idPessoa = '$idProjeto'";
$enviaNota = mysqli_query($con, $queryNota);
while ($rowNota = mysqli_fetch_array($enviaNota)) {
    $dataNota = $rowNota['data'];
    $notaN = $rowNota['nota'];
}

if ($tipoPessoa == 1) {
    $pf = recuperaDados("pessoa_fisica", "idPf", $idPessoa);
    $NomePF = $pf["nome"];
    $RGPF = $pf["rg"];
    $CPF = $pf["cpf"];
    $EnderecoPF = $pf ["logradouro"];
    $NumeroPF = $pf["numero"];
    $BairroPF = $pf["bairro"];
    $CidadePF = $pf["cidade"];
    $estadoPF = $pf['estado'];
    $CepPF = $pf["cep"];
    $numeroPF = $pf['numero'];
    $complementoPF = $pf['complemento'];
    $telefonePF = $pf['telefone'];
    $celularPF = $pf['celular'];
    $emailPF = $pf['email'];

    if ($pf['cooperado'] == 1) {
        $cooperadoPF = "sim";
    } else if ($pf['cooperado'] == 2) {
        $cooperadoPF = "não";
    }
}
if ($tipoPessoa == 2) {
    $pj = recuperaDados("pessoa_juridica", "idPj", $idPessoa);
    $razaoSocial = $pj['razaoSocial'];
    $cnpj = $pj['cnpj'];
    $logradouroPJ = $pj['logradouro'];
    $bairroPJ = $pj['bairro'];
    $cidadePJ = $pj['cidade'];
    $estadoPJ = $pj['estado'];
    $cepPJ = $pj['cep'];
    $numeroPJ = $pj['numero'];
    $complementoPJ = $pj['complemento'];
    $telefonePJ = $pj['telefone'];
    $celularPJ = $pj['celular'];
    $emailPJ = $pj['email'];

    if ($pj['cooperativa'] == 1) {
        $cooperativa = "sim";
    } else if ($pj['cooperativa'] == 2) {
        $cooperativa = "não";
    }

    $idRepresentante = $pj['idRepresentanteLegal'];

    $queryRep = "SELECT * FROM representante_legal WHERE idRepresentanteLegal = '$idRepresentante'";
    $enviaRep = mysqli_query($con, $queryRep);
    while ($rowRep = mysqli_fetch_array($enviaRep)) {
        $nomeRep = $rowRep['nome'];
        $cpfRep = $rowRep['cpf'];
        $rgRep = $rowRep['rg'];
        $logradouroRep = $rowRep['logradouro'];
        $bairroRep = $rowRep['bairro'];
        $cidadeRep = $rowRep['cidade'];
        $estadoRep = $rowRep['estado'];
        $cepRep = $rowRep['cep'];
        $numeroRep = $rowRep['numero'];
        $complementoRep = $rowRep['complemento'];
        $telefoneRep = $rowRep['telefone'];
        $celularRep = $rowRep['celular'];
        $emailRep = $rowRep['email'];
    }
}
?>
<html lang="br">
<head>
    <title>SMC / Pro-Mac - Programa Municipal de Apoio a Projetos Culturais</title>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- JQuery -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="../visual/js/jquery.js"></script>
    <script type="text/javascript">
        $(function () {
            window.print();
            window.close();
        });
    </script>
    <!-- CSS -->
    <style>

        body {
            font-size: 15px;
            font-family: Arial;
            margin-top: 30px;
        }

        @page {
            margin: 0mm;
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

        <br>
        <h2 style="text-transform: uppercase;"><b>Projeto: <?= $nomeProjeto ?> </b></h2><br>
        <?php
        if ($tipoPessoa == 1) {
            ?>
            <h3><b>
                    <center>Dados de pessoa física</center>
                </b></h3>

            <p><b>Nome: </b> <?= $NomePF ?> </p>
            <p><b>RG: </b> <?= $RGPF ?> </p>
            <p><b>CPF: </b> <?= $CPF ?></p>
            <p>
                <b>Endereço: </b> <?= $EnderecoPF . ", " . $NumeroPF . " " . $complementoPF . " - " . $CidadePF . " - " . $estadoPF ?>
            </p>
            <p><b>Telefones: </b> <?= $telefonePF . " | " . $celularPF ?> </p>
            <p><b>E-mail: </b><?= $emailPF ?></p>
            <?php
        } else {
            ?>
            <h3><b>
                    <center>Dados de pessoa jurídica</center>
                </b></h3>

            <p><b>Razão social: </b> <?= $razaoSocial ?> </p>
            <p><b>CNPJ: </b> <?= $cnpj ?> </p>
            <p>
                <b>Endereço: </b> <?= $logradouroPJ . ", " . $numeroPJ . " " . $complementoPJ . " - " . $cidadePJ . " - " . $estadoPJ ?>
            </p>
            <p><b>Telefones: </b> <?= $telefonePJ . " | " . $celularPJ ?> </p>
            <p><b>E-mail: </b><?= $emailPJ ?></p><br>

            <h3><b>
                    <center>Dados do representante legal</center>
                </b></h3>

            <p><b>Nome: </b> <?= $nomeRep ?> </p>
            <p><b>RG: </b> <?= $rgRep ?> </p>
            <p><b>CPF: </b> <?= $cpfRep ?></p>
            <p>
                <b>Endereço: </b> <?= $logradouroRep . ", " . $numeroRep . " " . $complementoRep . " - " . $cidadeRep . " - " . $estadoRep ?>
            </p>
            <p><b>Telefones: </b> <?= $telefoneRep . " | " . $celularRep ?> </p>
            <p><b>E-mail: </b><?= $emailRep ?></p>
            <?php
        }
        ?>

        <br><br>
        <h3><b>
                <center>Dados do projeto</center>
            </b></h3>

        <p><b>Protocolo:</b> <span data-mask="0000.00.00/0000000"><?= $protocoloP ?></span></p>
        <p><b>Área de atuação:</b> <?= $areaAtuacao ?></p>
        <p><b>Valor total do projeto:</b> R$ <?= dinheiroParaBr($vProjeto) ?></p>
        <p><b>Valor do Incentivo solicitado no Pro-Mac:</b> R$ <?= dinheiroParaBr($vIncentivo) ?></p>
        <p><b>Enquadramento da renúncia fiscal:</b><?= $renunciaFiscal ?></p>

        <p><b>Descrição da exposição da marca e indicação do valor do ingresso: </b><?= $exposicaoMarca ?></p>

        <br><br>
        <div>
            <b style="font-size: 16px;">Resumo do projeto: </b>
            <hr/>
            <?= $resumoProjeto ?> </div>
        <br><br>

        <div>
            <b style="font-size: 16px;">Curriculo: </b>
            <hr/>
            <?= $curriculo ?> </div>
        <br><br>

        <h3>Descrição do objeto e atividades: </h3>
            <hr/>
            <?= $descricao ?>

        <br><br>

        <div><b style="font-size: 16px;">Justificativa do projeto: </b>
            <hr/>
            <?= $justificativa ?> </div>
        <br><br>

        <div style="margin-top: 20px;"><b style="font-size: 16px;">Objetivos e metas: </b>
            <hr/>
            <?= $objetivo ?> </div>
        <br><br>

        <div><b style="font-size: 16px;">Metodologia e parâmetros a serem utilizados para aferição do cumprimento de
                metas: </b>
            <hr/>
            <?= $metodologia ?> </div>
        <br><br>

        <div><b style="font-size: 16px;">Descrição da contrapartida: </b>
            <hr/>
            <?= $contrapartida ?> </div>
        <br><br>

        <div style="margin-top: 30px;"><b style="font-size: 16px;">Locais: </b>
            <hr/>
            <?php
            while ($rowLocal = mysqli_fetch_array($enviaLocal)) {
                echo "<p><b>Local: </b>" . $rowLocal['local'] . "</p>";
                echo "<p><b>Público estimado: </b>" . $rowLocal['estimativaPublico'] . "</p>";
                echo "<p><b>Zona: </b>" . $rowLocal['zona'] . "</p>";
                echo "<p><b>Prefeitura Regional:  </b>" . $rowLocal['subprefeitura'] . "</p>";
                echo "<p><b>Distrito:  </b>" . $rowLocal['distrito'] . "</p><br>";
            }
            ?>
        </div>


        <div><b style="font-size: 16px;">Público alvo: </b>
            <hr/>
            <?= $publicoAlvo ?> </div>
        <br><br>

        <div><b style="font-size: 16px;">Plano de divulgação: </b>
            <hr/>
            <?= $planoDivulgacao ?></div>
        <br><br>

        <div><b style="font-size: 16px;">Ficha técnica: </b>
            <hr/>

            <?php
            while ($rowFicha = mysqli_fetch_array($enviaFicha)) {
                $nomeFicha = $rowFicha['nome'];
                $cpfFicha = $rowFicha['cpf'];
                $funcaoFicha = $rowFicha['funcao'];

                echo "<p><b>Nome: </b>" . $nomeFicha . "</p>";
                echo "<p><b>CPF: </b>" . $cpfFicha . "</p>";
                echo "<p><b>Função: </b>" . $funcaoFicha . "</p>";
            }

            ?>
        </div>
        <table border="1" style="border-collapse: collapse; margin-top: 20px;">
            <tr>
                <th colspan="7" bgcolor="red" style="font-size: 18px; align-items: center;"><b>CRONOGRAMA</b></th>
            </tr>

            <tr>
                <td align='center'><b>Início do cronograma</b></td>
                <td align='center'><b>Fim do cronograma</b></td>
                <td align='center'><b>Captação de recursos</b></td>
                <td align='center'><b>Pré-Produção</b></td>
                <td align='center'><b>Produção</b></td>
                <td align='center'><b>Pós-Produção</b></td>
                <td align='center'><b>Prestação de contas</b></td>
            </tr>
            <tr>
                <td class='list_description'> <?= $inicioCronograma ?> </td>
                <td class='list_description'> <?= $fimCronograma ?> </td>
                <td class='list_description'> <?= str_replace('a', '', $captacaoRecurso) ?> </td>
                <td class='list_description'> <?= str_replace('a', '', $preProducao) ?> </td>
                <td class='list_description'> <?= str_replace('a', '', $producao) ?> </td>
                <td class='list_description'> <?= str_replace('a', '', $posProducao) ?> </td>
                <td class='list_description'> <?= str_replace('a', '', $prestacaoContas) ?> </td>
            </tr>
        </table>
        <br>
        <hr/>
        <br>
        <table border="1" style="border-collapse: collapse;">
            <tr>
                <th colspan="7" bgcolor="red" style="font-size: 18px; align-content: center;"><b>ORÇAMENTO</b></th>
            </tr>
            <tr>
                <td width='25%' align='center'><b>Etapa</b></td>
                <td align='center'><b>Descrição</b></td>
                <td width='5%' align='center'><b>Qtde</b></td>
                <td width='5%' align='center'><b>Unid. Med.</b></td>
                <td width='5%' align='center'><b>Qtde Unid.</b></td>
                <td align='center'><b>Valor Unit.</b></td>
                <td align='center'><b>Valor Total</b></td>
            </tr>

            <?php

            $count = 0;

            // for ($i=0; $i < $countTabela; $i++) {}

            while ($rowOrca = mysqli_fetch_array($enviaOrca)) {

                $count++;

                echo "<tr>";
                echo "<td class='list_description'>" . $rowOrca['etapa'] . "</td>";
                echo "<td class='list_description'>" . $rowOrca['descricao'] . "</td>";
                echo "<td class='list_description'>" . $rowOrca['quantidade'] . "</td>";
                echo "<td class='list_description'>" . $rowOrca['unidadeMedida'] . "</td>";
                echo "<td class='list_description'>" . $rowOrca['quantidadeUnidade'] . "</td>";
                echo "<td class='list_description'>" . dinheiroParaBr($rowOrca['valorUnitario']) . "</td>";
                echo "<td class='list_description'>" . dinheiroParaBr($rowOrca['valorTotal']) . "</td>";
                echo "</tr>";

                if ($count == 14) {
                    echo "<table  border='1' style='page-break-before: always; border-collapse: collapse;'>
                            <tr>    
                <th colspan=\"7\" bgcolor=\"red\" style= \"font-size: 18px;\"><b>CONTINUAÇÃO</b></th>
            </tr>
                                <tr>
                                    <td width='25%' align='center'><b>Etapa</b></td>
                                    <td align='center'><b>Descrição</b></td>
                                    <td width='5%' align='center'><b>Qtde</b></td>
                                    <td width='5%' align='center'><b>Unid. Med.</b></td>
                                    <td width='5%' align='center'><b>Qtde Unid.</b></td>
                                    <td align='center'><b>Valor Unit.</b></td>
                                    <td align='center'><b>Valor Total</b></td>
                                </tr>";


                    while ($rowOrca = mysqli_fetch_array($enviaOrca)) {
                        echo "<tr>";
                        echo "<td class='list_description'>" . $rowOrca['etapa'] . "</td>";
                        echo "<td class='list_description'>" . $rowOrca['descricao'] . "</td>";
                        echo "<td class='list_description'>" . $rowOrca['quantidade'] . "</td>";
                        echo "<td class='list_description'>" . $rowOrca['unidadeMedida'] . "</td>";
                        echo "<td class='list_description'>" . $rowOrca['quantidadeUnidade'] . "</td>";
                        echo "<td class='list_description'>" . dinheiroParaBr($rowOrca['valorUnitario']) . "</td>";
                        echo "<td class='list_description'>" . dinheiroParaBr($rowOrca['valorTotal']) . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            }
            echo "</table>";
            ?>
    </div>
    <br><br>

    <div><b style="font-size: 16px;">Totais: </b>
        <hr/>
        <p><b>Pré-Produção: </b><?= $totalPreProducao ?> </p>
        <p><b>Produção: </b><?= $totalProducao ?> </p>
        <p><b>Assessoria de Imprensa, Divulgação e Mídia: </b><?= $totalImprensa ?> </p>
        <p><b>Custos Administrativos: </b><?= $totalAdministrativos ?></p>
        <p><b>Impostos, taxas, tarifas bancárias, contribuições e seguros: </b><?= $totalImpostos ?></p>
        <p><b>Elaboração e Agenciamento: </b><?= $totalAgenciamento ?> </p>
        <p><b>Outros Financiamentos: </b><?= $totalOutrosFinanciamentos ?> </p>
    </div>
    <br><br>

    <div><b style="font-size: 16px;">Link do Youtube: </b>
        <hr/>
        <p><b>Link 1: </b><?= $video1 ?> </p>
        <p><b>Link 2: </b><?= $video2 ?> </p>
        <p><b>Link 3: </b><?= $video3 ?> </p>
    </div>

</body>
</html>