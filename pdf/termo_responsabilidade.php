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

function escreverExtenso($valor = 0){

    function escreverExtenso($valor = 0){
        //Vai formatar como no Ex: 1.000.650,99
        $valor = number_format($valor,2,",",".");

        //Separa centavos da parte inteira
        $separado = explode(",",$valor);
        $inteiro = $separado[0];
        $centavos = $separado[1];

        //
        $singular = array("","centavo", "real", "mil", "milhão", "bilhão", "trilhão");
        $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões");

        //Casas decimais
        $centena = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $dezena = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
        $uidade = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
        $zero = 0;

        $inteiro = explode(".",$inteiro);
        switch (count($inteiro)) {
            case 1:
                
                break;
            case 2:

                break;
            case 3:

                break;
            case 4:

                break;
            default:
                echo "Erro";
                break;
        }

        return $inteiro;
    }

    echo (escreverExtenso(50000000.90));
}

?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <style>
        *{
            font-family: calibri, sans-serif;
        }
        h2{
            font-size: 12pt;
        }
        h3{
            text-align: center;
            font-size: 14pt;
        }
        p{
            font-size: 11pt;
        }
        .centro{
            text-align: center;
            clear: both;
            clear: left;
        }
        .direita{
            display: block;
            float: left;
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
<p>Valor Aprovado: R$ <?= str_replace(".",",",$proponente['valorAprovado'])?> (_____________________________________ mil reais)</p>
<p>Percentual de Renúncia <?= $proponente['renunciaFiscal'] ?></p>
<p>Data da Aprovação: ___ / ___ / ____</p>
<br><br>

<h2>CABERÁ AO PROPONENTE:</h2>
<p>a)	Executar o projeto conforme proposta aprovada; </p>
<p>b)	Realizar a aplicação financeira do recurso, que deverá ser de liquidez imediata, composta majoritariamente por títulos públicos com classificação de baixo nível de risco;</p>
<p>c)	Abrir duas contas no Banco do Brasil para depósito e movimentação exclusivos dos recursos do projeto aprovado: uma conta de captação e outra conta de movimentação;</p>
<p>d)	Não movimentar a conta de captação, sendo esta destinada apenas para fins de depósito do incentivador;</p>
<p>e)	Solicitar à Secretaria Municipal de Cultura autorização para efetuar a transferência da conta de captação para a conta de movimentação, após a captação haver atingido ao menos 35% (trinta e cinco por cento) do valor aprovado e enviar juntamente à solicitação os extratos da conta de captação e da conta de movimentação; </p>
<p>f)	Responsabilizar-se pela movimentação bancária, na conta de movimentação;</p>
<p>g)	Expor a logomarca no projeto, conforme Manual de Utilização da Marca;</p>
<p>h)	Arrecadar os valores necessários à execução do projeto no período restante do exercício fiscal em que tiver sido aprovado e responsabilizar-se pela captação de outras fontes de recursos, caso tenha informado no projeto aprovado;</p>
<p>i)	Solicitar à Secretaria Municipal de Cultura prorrogação do prazo de captação, que poderá ser estendo por até 01 (um) ano. A solicitação deverá ser feita no mínimo 30 (trinta) dias antes do término do prazo de captação;</p>
<p>j)	Caso seja cancelado o projeto, solicitar à Secretaria Municipal de Cultura, antes do término do prazo de captação e após anuência do incentivador, a transferência do recurso a outro projeto do mesmo proponente ou para outro que esse indicar;</p>
<p>k)	Realizar o projeto dentro do prazo de 18 (dezoito) meses, após a liberação do recurso;</p>
<p>l)	Enviar à Coordenadoria de Incentivo à Cultura, com no mínimo 10 (dez) dias de antecedência, o cronograma completo das estreias, apresentações, exposições, entre outros, contendo a definição do(s) local(is) e horário(s);</p>
<p>m)	Solicitar à Secretaria Municipal de Cultura, caso necessite, prorrogação do prazo de execução, que poderá ser estendo por até 06 (seis) meses, no mínimo 30 (trinta) dias antes do término do prazo de execução;</p>
<p>n)	Responsabilizar-se pelos compromissos e encargos de natureza trabalhista, previdenciária, fiscal, comercial, bancária, intelectual (direito autoral, inclusive os conexos, e de propriedade industrial), bem como quaisquer outros resultantes deste ajuste;</p>
<p>o)	Prestar contas dentro das normas previstas na Portaria SMC – 39/2018, em até 30 (trinta) dias contados do encerramento da execução do projeto;</p>
<p>p)	Caso seja notificado pela Secretaria Municipal de Cultura, o proponente deverá apresentar esclarecimentos, encaminhar documentos e regularizar a situação referente à prestação de contas, no prazo de até 20 (vinte) dias corridos da notificação;</p>
<p>q)	Aguardar a aprovação de prestação de contas para inscrever novo projeto. Caso a Secretaria Municipal de Cultura não se manifeste em até 30 (trinta) dias corridos após a entrega da prestação de contas, o proponente poderá inscrever novo projeto, que será cancelado caso seja julgado irregularidade na prestação de contas;</p>
<p>r)	Informar ao incentivador que é de sua estrita responsabilidade efetuar o cálculo da renúncia e realizar os depósitos dentro dos prazos previstos;</p>
<p>s)	Manter todos os dados cadastrais devidamente atualizados no Sistema Pro-Mac;</p>
<p>t)	Estar ciente que sua responsabilidade sobre o projeto é indelegável;</p>
<p>u)	Ter ciência que a notificação por correspondência eletrônica é um meio de correspondência oficial.</p>
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
<p>DECLARO ter conhecimento das vedações constantes no artigo 2º do Decreto nº 58.041, de 20 de Dezembro de 2018, que estabelece:</p>
<br>
<p>II - proponente: pessoa física ou jurídica, com ou sem fins lucrativos, que apresenta projeto cultural visando à captação de recursos por meio do incentivo fiscal para sua realização e que atenda cumulativamente às seguintes exigências:</p>
<br>
<p>a) não tenha qualquer associação ou vínculo direto ou indireto com empresas de serviços de radiodifusão de som e imagem ou operadoras de comunicação eletrônica aberta ou por assinatura;<br>
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

