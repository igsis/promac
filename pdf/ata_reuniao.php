<?php
//require '../include/';
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

$con = bancoMysqli();

$data = exibirDataMysql($_POST['data']);

/*
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=carta_intencao.doc");
*/
?>

<html>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<body>
		<h4 align="center">COMISSÃO JULGADORA DE PROJETOS CULTURAIS<br/>
			ATA DA REUNIÃO ORDINÁRIA de
		</h4>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p align="justify">Após análise e discussão a CJP - Comissão Julgadora de Projetos Culturais decidiu pela <strong>APROVAÇÃO</strong> dos projetos abaixo relacionados, nos seguintes segmentos:</p>
		
		<?php
		$sql_area = "SELECT DISTINCT idAreaAtuacao, areaAtuacao FROM `projeto`
					INNER JOIN area_atuacao ON idAreaAtuacao = idArea 
					WHERE `dataReuniao` = '$data' AND idStatus = 5"; //status aprovado
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
                        AND p.idAreaAtuacao = '". $x['idArea']. "' AND p.idStatus = 5";
            $query = mysqli_query($con,$sql);

            foreach ($query as $projeto)
			{
                echo "<p><strong>Nome do projeto:</strong> ".$projeto['nomeProjeto']."</p>";
                echo "<p><strong>Protocolo:</strong> ".$projeto['protocolo']."</p>";
                echo "<p><strong>Valor total aprovado:</strong> ".$projeto['valorAprovado']."</p>";
                echo "<p><strong>Percentual de renúncia:</strong> ".$projeto['renunciaFiscal']."</p>";
                echo "<p>&nbsp;</p>";
            }
		}
		?>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p align="justify">A CJP - Comissão Julgadora de Projetos Culturais decidiu <strong>REPROVAR</strong> os projetos abaixo relacionados, nos seguintes segmentos:</p>

        <?php
        $sql_area = "SELECT DISTINCT idAreaAtuacao, areaAtuacao FROM `projeto`
					INNER JOIN area_atuacao ON idAreaAtuacao = idArea 
					WHERE `dataReuniao` = '$data' AND idStatus = 6"; //status reprovado
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
                        AND p.idAreaAtuacao = '". $x['idArea']. "' AND p.idStatus = 6";
            $query = mysqli_query($con,$sql);

            foreach ($query as $projeto)
            {
                echo "<p><strong>Nome do projeto:</strong> ".$projeto['nomeProjeto']."</p>";
                echo "<p><strong>Protocolo:</strong> ".$projeto['protocolo']."</p>";
                echo "<p><strong>Valor total aprovado:</strong> ".$projeto['valorAprovado']."</p>";
                echo "<p><strong>Percentual de renúncia:</strong> ".$projeto['renunciaFiscal']."</p>";
                echo "<p>&nbsp;</p>";
            }
        }
        ?>


		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p><div style="text-align: center;">São Paulo, __ de ____ de 2018.</div></p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
</body>
</html>

