<?php
//require '../include/';
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

$con = bancoMysqli();

$data = exibirDataMysql($_POST['data']);


header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=ata-reuniao-".$_POST['data'].".doc");
setlocale(LC_TIME, 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

$status_aprovado = array(5, 21, 26, 16, 11);
$status_reprovado = array(6, 22, 27, 17);

?>

<html>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<body>
    <?=strtoupper("<h4 style=\"text-align: center; font-family: sans-serif;\">COMISSÃO JULGADORA DE PROJETOS CULTURAIS<br/>
			ATA DA REUNIÃO ORDINÁRIA DE ".strftime('%d DE %B DE %Y', strtotime($data))."</h4>")?>
		<p>&nbsp;</p>
    <p style="text-align:justify; font-family: sans-serif;">Após análise e discussão a CJP - Comissão Julgadora de Projetos Culturais decidiu pela <strong>APROVAÇÃO</strong> dos projetos abaixo relacionados, nos seguintes segmentos:</p>

		<?php
		$sql_area = "SELECT DISTINCT idAreaAtuacao, areaAtuacao FROM `projeto`
					INNER JOIN area_atuacao ON idAreaAtuacao = idArea 
					WHERE `dataReuniao` = '$data' AND idEtapaProjeto = 5"; //status aprovado
		$query_area = mysqli_query($con,$sql_area);
		while($campo = mysqli_fetch_array($query_area))
		{
		    $x['area'] = $campo['areaAtuacao'];
		    $x['idArea'] = $campo['idAreaAtuacao'];
		    $area = $x['area'];
		    $idArea = $x['idArea'];
            echo "<h4>".strtoupper($area)."</h4>";
            $sql = "SELECT
                      p.nomeProjeto,
                      p.protocolo,
                      p.valorAprovado,
                      rf.renunciaFiscal,
                      pf.nome as 'nomePf',
                      pj.razaoSocial as 'nomePj'
                      FROM projeto as p
                      INNER JOIN renuncia_fiscal as rf ON p.idRenunciaFiscal = rf.idRenuncia
                      LEFT JOIN pessoa_fisica as pf ON p.idPf = pf.idPf
                      LEFT JOIN pessoa_juridica as pj ON p.idPj = pj.idPj
                      WHERE p.dataReuniao = '$data'
                        AND p.idAreaAtuacao = '". $x['idArea']. "' AND p.idEtapaProjeto = 5";
            $query = mysqli_query($con,$sql);

            foreach ($query as $projeto) {
                $proponente = $projeto['nomePf'] == true ? $projeto['nomePf'] : $projeto['nomePj'];
                ?>
                <p><strong>Proponente:</strong> <?=$proponente?></p>
                <p><strong>Projeto:</strong> <?=$projeto['nomeProjeto']?></p>
                <p><strong>Protocolo:</strong> <?=$projeto['protocolo']?></p>
                <p><strong>Valor total aprovado:</strong> <?=$projeto['valorAprovado']?></p>
                <p><strong>Percentual de renúncia:</strong> <?=$projeto['renunciaFiscal']?></p>
                <p>&nbsp;</p>
<?php       }
		}
		?>
		<p>&nbsp;</p>
        <p style="text-align:justify; font-family: sans-serif;">A CJP - Comissão Julgadora de Projetos Culturais decidiu <strong>REPROVAR</strong> os projetos abaixo relacionados, nos seguintes segmentos:</p>

    <?php
    $sql_area = "SELECT DISTINCT idAreaAtuacao, areaAtuacao FROM `projeto`
					INNER JOIN area_atuacao ON idAreaAtuacao = idArea 
					WHERE `dataReuniao` = '$data' AND idEtapaProjeto = 6"; //status reprovado
    $query_area = mysqli_query($con,$sql_area);
    while($campo = mysqli_fetch_array($query_area))
    {
        $x['area'] = $campo['areaAtuacao'];
        $x['idArea'] = $campo['idAreaAtuacao'];
        $area = $x['area'];
        $idArea = $x['idArea'];
        echo "<h4>".strtoupper($area)."</h4>";
        $sql = "SELECT
                      p.nomeProjeto,
                      p.protocolo,
                      p.valorAprovado,
                      rf.renunciaFiscal,
                      pf.nome as 'nomePf',
                      pj.razaoSocial as 'nomePj'
                      FROM projeto as p
                      INNER JOIN renuncia_fiscal as rf ON p.idRenunciaFiscal = rf.idRenuncia
                      LEFT JOIN pessoa_fisica as pf ON p.idPf = pf.idPf
                      LEFT JOIN pessoa_juridica as pj ON p.idPj = pj.idPj
                      WHERE p.dataReuniao = '$data'
                        AND p.idAreaAtuacao = '". $x['idArea']. "' AND p.idEtapaProjeto = 6";
        $query = mysqli_query($con,$sql);

        foreach ($query as $projeto) {
            $proponente = $projeto['nomePf'] == true ? $projeto['nomePf'] : $projeto['nomePj'];
            ?>
            <p><strong>Proponente:</strong> <?=$proponente?></p>
            <p><strong>Projeto:</strong> <?=$projeto['nomeProjeto']?></p>
            <p><strong>Protocolo:</strong> <?=$projeto['protocolo']?></p>
            <p>&nbsp;</p>
        <?php       }
    }
    ?>

            <p style="text-align:justify; font-family: sans-serif;">A partir do primeiro dia útil após a publicação desta Ata no Diário Oficial da Cidade,
            poderão ser conhecidos os pareceres da comissão quanto a REPROVAÇÃO, SOLICITAÇÃO
            DE COMPLEMENTAÇÃO DE INFORMAÇÕES e APROVAÇÃO no site do Sistema Pro-Mac:
            <a href="http://smcsistemas.prefeitura.sp.gov.br/promac/">http://smcsistemas.prefeitura.sp.gov.br/promac/</a></p>

            <p style="text-align:justify; font-family: sans-serif;">Poderão os proponentes entrar em contato com o Pro-Mac nos telefones (11) 3397-0063,
            3397-0062, 3397-0061 e 3397-0028, ou pelo email <a href="mailto:promac@prefeitura.sp.gov.br">promac@prefeitura.sp.gov.br</a>, para ter
            conhecimento da situação dos projetos inscritos no Programa.</p>

            <p style="text-align:justify; font-family: sans-serif;">Em caso de APROVAÇÃO a Secretaria Municipal de Cultura convocará através do Sistema
            Pro-Mac os proponentes que tiveram o projeto aprovado para assinar o Termo de
            Responsabilidade de Realização de Projeto Cultural em até 15 (quinze) dias ocorridos após
            a publicação da aprovação de projeto no Diário Oficial da Cidade – D.O.C. Para a realização
            este procedimento os proponentes deverão realizar um agendamento prévio através do
            email do Pro-Mac <a href="mailto:promac@prefeitura.sp.gov.br">promac@prefeitura.sp.gov.br</a></p>

            <p style="text-align:justify; font-family: sans-serif;">Em casos de SOLICITAÇÃO DE COMPLEMENTO DE INFORMAÇÕES, o prazo é de 20 dias.
            Não atendidos os prazos de COMPLEMENTO DE INFORMAÇÕES e REPROVAÇÃO, os
            projetos e outras solicitações serão indeferidos.</p>

            <p style="text-align:justify; font-family: sans-serif;">Em casos de REPROVAÇÃO, os proponentes têm 05 dias corridos, a partir do primeiro dia
            útil após a data da publicação, para entrar com recurso.</p>

            <p style="text-align:justify; font-family: sans-serif;">ATENÇÃO! Os pareceres estarão disponíveis sempre no primeiro dia útil após a data da
            publicação em Diário Oficial da Cidade na plataforma do Sistema Pro-Mac.</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>

		<p><div style="text-align: center;">São Paulo, __ de ____ de 2018.</div></p>
		<p>&nbsp;</p>
</body>
</html>

