<?php
//require '../include/';
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

$con = bancoMysqli();

$idProjeto = $_REQUEST['idProjeto'];

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=termo-de-responsabilidade.doc");
setlocale(LC_TIME,'portuguese');
date_default_timezone_set('America/Sao_Paulo');


function valor_por_extenso( $v ){

    //$v = filter_var($v, FILTER_SANITIZE_NUMBER_INT);

    $sin = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
    $plu = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");

    $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
    $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
    $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
    $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");

    $z = 0;

    $v = number_format( $v, 2, ".", "." );
    $int = explode( ".", $v );

    for ( $i = 0; $i < count( $int ); $i++ )
    {
        for ( $ii = mb_strlen( $int[$i] ); $ii < 3; $ii++ )
        {
            $int[$i] = "0" . $int[$i];
        }
    }

    $rt = null;
    $fim = count( $int ) - ($int[count( $int ) - 1] > 0 ? 1 : 2);
    for ( $i = 0; $i < count( $int ); $i++ )
    {
        $v = $int[$i];
        $rc = (($v > 100) && ($v < 200)) ? "cento" : $c[$v[0]];
        $rd = ($v[1] < 2) ? "" : $d[$v[1]];
        $ru = ($v > 0) ? (($v[1] == 1) ? $d10[$v[2]] : $u[$v[2]]) : "";

        $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
        $t = count( $int ) - 1 - $i;
        $r .= $r ? " " . ($v > 1 ? $plu[$t] : $sin[$t]) : "";
        if ( $v == "000")
            $z++;
        elseif ( $z > 0 )
            $z--;

        if ( ($t == 1) && ($z > 0) && ($int[0] > 0) )
            $r .= ( ($z > 1) ? " de " : "") . $plu[$t];

        if ( $r )
            $rt = $rt . ((($i > 0) && ($i <= $fim) && ($int[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
    }

    $rt = mb_substr( $rt, 1 );

    return($rt ? trim( $rt ) : "zero");

}


?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <style>
        h2{
            font-size: 12pt;
        }
        h3{
            text-align: center;
            font-size: 14pt;
        }

        .centro{
            text-align: center;
            clear: both;
            clear: left;
            font-family: calibri, sans-serif;
        }
        .direita{
            display: block;
            float: left;
            font-family: calibri, sans-serif;
        }

        .paragrafo{
            text-align: justify;
            font-size: 11pt;
            font-family: calibri, sans-serif;
        }

    </style>
</head>
<body>
<h3 style='text-align: center;font-family: calibri;font-size: 14pt;'>TERMO DE RESPONSABILIDADE DE REALIZAÇÃO DE PROJETO CULTURAL</h3>
</br>

<?php

    $sqlPj = "SELECT  pj.razaoSocial 'nome',
                      pro.nomeProjeto 'nomeProjeto',
                      pj.cnpj 'documentacao',
                      pro.valorAprovado,
                      re.renunciaFiscal
              FROM pessoa_juridica pj INNER JOIN projeto pro ON pj.idPj = pro.idPj
              INNER JOIN renuncia_fiscal re ON re.idRenuncia=pro.idRenunciaFiscal 
              WHERE pro.idProjeto = '$idProjeto'";

    $sqlPf = "SELECT pf.nome,
                   pro.nomeProjeto 'nomeProjeto',
                   pf.cpf 'documentacao',
                   pro.valorAprovado,
                   re.renunciaFiscal
            FROM pessoa_fisica pf INNER JOIN projeto pro ON pf.idPf = pro.idPf
            INNER JOIN renuncia_fiscal re ON re.idRenuncia=pro.idRenunciaFiscal 
            WHERE pro.idProjeto = '$idProjeto'";

    $resultPj = mysqli_query($con,$sqlPj);

    $resultPf = mysqli_query($con,$sqlPf);

    $contPj = mysqli_num_rows($resultPj);
    $contPf = mysqli_num_rows($resultPf);

    if ($contPj != 0){
        $proponente = mysqli_fetch_array($resultPj);
    }elseif ($contPf != 0){
        $proponente = mysqli_fetch_array($resultPf);
    }


?>



<p>Proponente: <?= $proponente['nome']?> </p>
<p>Projeto: <?=$proponente['nomeProjeto']?></p>
<p>CPF/CNPJ nº <?= $proponente['documentacao'] ?></p>
<p>Valor Aprovado: R$ <?= str_replace(".",",",$proponente['valorAprovado'])?> (<?= valor_por_extenso($proponente['valorAprovado'])?>)</p>
<p>Percentual de Renúncia  <?= $proponente['renunciaFiscal'] ?></p>
<p>Data da Aprovação: ___ / ___ / ____</p>
<br><br>

<h2 style="font-family: calibri;">CABERÁ AO PROPONENTE:</h2>
<p class="paragrafo">a)	Executar o projeto conforme proposta aprovada; </p>
<p class="paragrafo">b)	Realizar a aplicação financeira do recurso, que deverá ser de liquidez imediata, composta majoritariamente por títulos públicos com classificação de baixo nível de risco;</p>
<p class="paragrafo">c)	Abrir duas contas no Banco do Brasil para depósito e movimentação exclusivos dos recursos do projeto aprovado: uma conta de captação e outra conta de movimentação;</p>
<p class="paragrafo">d)	Não movimentar a conta de captação, sendo esta destinada apenas para fins de depósito do incentivador;</p>
<p class="paragrafo">e)	Solicitar à Secretaria Municipal de Cultura autorização para efetuar a transferência da conta de captação para a conta de movimentação, após a captação haver atingido ao menos 35% (trinta e cinco por cento) do valor aprovado e enviar juntamente à solicitação os extratos da conta de captação e da conta de movimentação; </p>
<p class="paragrafo">f)	Responsabilizar-se pela movimentação bancária, na conta de movimentação;</p>
<p class="paragrafo">g)	Expor a logomarca no projeto, conforme Manual de Utilização da Marca;</p>
<p class="paragrafo">h)	Arrecadar os valores necessários à execução do projeto no período restante do exercício fiscal em que tiver sido aprovado e responsabilizar-se pela captação de outras fontes de recursos, caso tenha informado no projeto aprovado;</p>
<p class="paragrafo">i)	Solicitar à Secretaria Municipal de Cultura prorrogação do prazo de captação, que poderá ser estendo por até 01 (um) ano. A solicitação deverá ser feita no mínimo 30 (trinta) dias antes do término do prazo de captação;</p>
<p class="paragrafo">j)	Caso seja cancelado o projeto, solicitar à Secretaria Municipal de Cultura, antes do término do prazo de captação e após anuência do incentivador, a transferência do recurso a outro projeto do mesmo proponente ou para outro que esse indicar;</p>
<p class="paragrafo">k)	Realizar o projeto dentro do prazo de 18 (dezoito) meses, após a liberação do recurso;</p>
<p class="paragrafo">l)	Enviar à Coordenadoria de Incentivo à Cultura, com no mínimo 10 (dez) dias de antecedência, o cronograma completo das estreias, apresentações, exposições, entre outros, contendo a definição do(s) local(is) e horário(s);</p>
<p class="paragrafo">m)	Solicitar à Secretaria Municipal de Cultura, caso necessite, prorrogação do prazo de execução, que poderá ser estendo por até 06 (seis) meses, no mínimo 30 (trinta) dias antes do término do prazo de execução;</p>
<p class="paragrafo">n)	Responsabilizar-se pelos compromissos e encargos de natureza trabalhista, previdenciária, fiscal, comercial, bancária, intelectual (direito autoral, inclusive os conexos, e de propriedade industrial), bem como quaisquer outros resultantes deste ajuste;</p>
<p class="paragrafo">o)	Prestar contas dentro das normas previstas na Portaria SMC – 39/2018, em até 30 (trinta) dias contados do encerramento da execução do projeto;</p>
<p class="paragrafo">p)	Caso seja notificado pela Secretaria Municipal de Cultura, o proponente deverá apresentar esclarecimentos, encaminhar documentos e regularizar a situação referente à prestação de contas, no prazo de até 20 (vinte) dias corridos da notificação;</p>
<p class="paragrafo">q)	Aguardar a aprovação de prestação de contas para inscrever novo projeto. Caso a Secretaria Municipal de Cultura não se manifeste em até 30 (trinta) dias corridos após a entrega da prestação de contas, o proponente poderá inscrever novo projeto, que será cancelado caso seja julgado irregularidade na prestação de contas;</p>
<p class="paragrafo">r)	Informar ao incentivador que é de sua estrita responsabilidade efetuar o cálculo da renúncia e realizar os depósitos dentro dos prazos previstos;</p>
<p class="paragrafo">s)	Manter todos os dados cadastrais devidamente atualizados no Sistema Pro-Mac;</p>
<p class="paragrafo">t)	Estar ciente que sua responsabilidade sobre o projeto é indelegável;</p>
<p class="paragrafo">u)	Ter ciência que a notificação por correspondência eletrônica é um meio de correspondência oficial.</p>
<br>
<p style="text-align: center">São Paulo, ______ de __________________, 2018.</p><br>
<br><br><br>
<span class="centro"><p>____________________________________ <br>
          (Nome completo) <br>
          PROPONENTE</p>
        </span><br><br><br>
<span class="direita" style="clear:both"><p class="centro">_________________________________________ <br>
              Anuente <br>
              (em caso de cooperativa, o cooperado deve assinar)</p>
        </span><br><br><br><br>
<h2 class="centro">ANEXO I</h2>
<br>
<br>
<h2 class="centro">DECLARAÇÃO</h2>
<br>
<br>
<p class="paragrafo">DECLARO ter conhecimento das vedações constantes no artigo 2º do Decreto nº 58.041, de 20 de Dezembro de 2018, que estabelece:</p>
<br>
<p class="paragrafo">II - proponente: pessoa física ou jurídica, com ou sem fins lucrativos, que apresenta projeto cultural visando à captação de recursos por meio do incentivo fiscal para sua realização e que atenda cumulativamente às seguintes exigências:</p>
<br>
<p class="paragrafo">a) não tenha qualquer associação ou vínculo direto ou indireto com empresas de serviços de radiodifusão de som e imagem ou operadoras de comunicação eletrônica aberta ou por assinatura;<br>
    b) não tenha qualquer associação ou vínculo direto ou indireto com o contribuinte incentivador do projeto apresentado, ressalvadas as hipóteses a que aludem o inciso XX do artigo 4º e o inciso III do artigo 7º da Lei nº 15.948, de 2013.</p>
<br>
<br>
<br>
<p>___/____/_____</p>
<br>
<p>__________________________ <br>
    Assinatura do Proponente</p>
<p>RG:<br>
    CPF:</p>



</body>
</html>

