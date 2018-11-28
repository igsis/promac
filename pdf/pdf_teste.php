<html>
<head>
    <title>SMC / Pro-Mac - Programa Municipal de Apoio a Projetos Culturais</title>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- css -->
    <link href="../visual/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="../visual/css/style.css" rel="stylesheet" media="screen">
    <link href="../visual/color/default.css" rel="stylesheet" media="screen">
    <link rel="icon" type="image/png" sizes="16x16" href="../visual/images/favicon.png">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="../visual/css/font-awesome.min.css">
    <?php include "../include/script.php"; ?>
    <script type="text/javascript" src="../visual/js/jquery.js"></script>
    <script type="text/javascript">
        $(function(){
            print();
        });
    </script>
</head>




<?php
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

//CONEXÃO COM BANCO DE DADOS
$con = bancoMysqli();

$tipoPessoa = $_GET['tipo'];
$idProjeto = $_GET['projeto'];
$idPessoa = $_GET['pessoa'];

$ano=date('Y');

$queryProjeto = "SELECT * FROM projeto WHERE idProjeto = '$idProjeto' AND publicado = 1";
$enviaP = mysqli_query($con, $queryProjeto);
/*
  Dados gerais do projeto.
*/
while($row = mysqli_fetch_array($enviaP))
{
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
while($rowCron = mysqli_fetch_array($enviaCrono))
{
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



/*
  Ficha técnica
*/
$queryFicha = "SELECT * FROM ficha_tecnica WHERE idProjeto = '$idProjeto' AND publicado = 1";
$enviaFicha = mysqli_query($con,$queryFicha);

/*
  Dados das notas.
*/
$queryNota = "SELECT * FROM notas WHERE idPessoa = '$idProjeto'";
$enviaNota = mysqli_query($con, $queryNota);
while($rowNota = mysqli_fetch_array($enviaNota))
{
    $dataNota = $rowNota['data'];
    $notaN = $rowNota['nota'];
}

if($tipoPessoa == 1)
{
    $pf = recuperaDados("pessoa_fisica","idPf",$idPessoa);
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

    if($pf['cooperado'] == 1)
    {
        $cooperadoPF = "sim";
    }
    else if($pf['cooperado'] == 2)
    {
        $cooperadoPF = "não";
    }

    ?>

    <section id='list_items' class='home-section bg-white'>
        <div class='container' style='height: 800px;'>

            <title><center>PDF DO PROJETO</center></title><br>

            <h1><strong>Projeto: <?= $nomeProjeto ?> </strong></h1>

            <h2><strong><center>Dados de pessoa física</center></strong></h2>

            <p><strong>Nome: </strong> <?= $NomePF ?> </p>
            <p><strong>RG: </strong> <?= $RGPF ?> </p>
            <p><strong>CPF: </strong> <?= $CPF ?></p>
            <p><strong>Endereço: </strong> <?=  $EnderecoPF . ", " . $NumeroPF . " " . $complementoPF . " - " . $CidadePF  . " - " . $estadoPF ?> </p>
            <p><strong>Telefones: </strong> <?= $telefonePF . " | " . $celularPF  ?> </p>
            <p><strong>E-mail: </strong><?= $emailPF ?></p>

            <h2><strong><center>Dados do projeto</center></strong></h2>

            <p><strong>Protocolo: </strong> <?= $protocoloP ?></p>
            <p><strong>Área de atuação: </strong> <?= $areaAtuacao ?></p>
            <p><strong>Valor total do projeto: </strong> <?= $vProjeto ?></p>
            <p><strong>Valor do Incentivo solicitado no Pro-Mac: </strong> <?= $vIncentivo ?></p>
            <p><strong>Valor de outros finaciamentos: </strong> <?= $vFinanciamento ?></p>
            <p><strong>Enquadramento da renúncia fiscal: </strong><?= $renunciaFiscal ?></p>
            <p><strong>Descrição da exposição da marca e indicação do valor do ingresso: </strong><?= $exposicaoMarca ?></p>

            <br><br>
            <strong style="font-size: 18px">Resumo do projeto: </strong>
            <hr/>
            <?= $resumoProjeto ?> <br><br><br>

            <strong style="font-size: 18px">Curriculo: </strong>
            <hr/>
            <?= $curriculo ?> <br><br><br>

            <strong style="font-size: 18px">Descrição do objeto e atividades:  </strong>
            <hr/>
            <?= $descricao ?> <br><br><br>

            <strong style="font-size: 18px">Justificativa do projeto:  </strong>
            <hr/>
            <?= $justificativa?> <br><br><br>

            <strong style="font-size: 18px">Objetivos e metas: </strong>
            <hr/>
            <?= $objetivo ?> <br><br><br>

            <strong style="font-size: 18px">Metodologia e parâmetros a serem utilizados para aferição do cumprimento de metas:  </strong>
            <hr/>
            <?= $metodologia ?> <br><br><br>

            <strong style="font-size: 18px">Descrição da contrapartida:  </strong>
            <hr/>
            <?= $contrapartida ?> <br><br><br>

            <strong style="font-size: 18px">Locais: </strong>
            <hr/>
            <?php
            while ($rowLocal = mysqli_fetch_array($enviaLocal)) {
                echo "<p><strong>Local: </strong>" . $rowLocal['local']. "</p>";
                echo "<p><strong>Público estimado: </strong>" . $rowLocal['estimativaPublico'] . "</p>";
                echo "<p><strong>Zona: </strong>" .$rowLocal['zona'] ."</p>";
                echo "<p><strong>Prefeitura Regional:  </strong>" . $rowLocal['subprefeitura'] . "</p>";
                echo "<p><strong>Distrito:  </strong>" . $rowLocal['distrito'] . "</p><br>";
            }
            ?>

            <strong style="font-size: 18px">Público alvo: </strong>
            <hr/>
            <?= $publicoAlvo ?> <br><br><br>

            <strong style="font-size: 18px">Plano de divulgação: </strong>
            <hr/>
            <?= $planoDivulgacao?> <br><br>

            <strong style="font-size: 18px">Ficha técnica: </strong>
            <hr/>

            <?php
            while($rowFicha = mysqli_fetch_array($enviaFicha))
            {
                $nomeFicha = $rowFicha['nome'];
                $cpfFicha = $rowFicha['cpf'];
                $funcaoFicha = $rowFicha['funcao'];

                echo "<p><strong>Nome: </strong>" . $nomeFicha . "</p>";
                echo "<p><strong>CPF: </strong>" . $cpfFicha . "</p>";
                echo "<p><strong>Função: </strong>" . $funcaoFicha . "</p><br>";
            }

            ?>
                    <table border="1" style="border-collapse: collapse">
                        <tr>
                            <th colspan="7" bgcolor="red" style= "font-size: 18px"><b>ORÇAMENTO</b></th>
                        </tr>

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
                        ?>
                    </table>
        </div>
    </section>





<?php

}
else if($tipoPessoa == 2) {
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

</html>