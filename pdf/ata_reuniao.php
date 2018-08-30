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
		$i = 0;
		while($campo = mysqli_fetch_array($query_area))
		{
		    $x[$i]['area'] = $campo['areaAtuacao'];
		    $area = $x[$i]['area'];
			$sql = "SELECT * FROM projeto WHERE idAreaAtuacao = '$area' ORDER BY idAreaAtuacao";
			$query = mysqli_query($con,$sql);
			echo "<h4>".strtoupper($area)."</h4>";

			while($projeto = mysqli_fetch_array($query))
			{
			    $renuncia = recuperaDados("renuncia_fiscal","idRenuncia",$projeto['idRenunciaFiscal']);
			    if($projeto['tipoPessoa'] == 1)
			    {
			    	$pf = recuperaDados("pessoa_fisica","idPf",$projeto['idPf']);
			    	$projeto['proponente'] = $pf['nome'];
			    }
			    else
			    {
			    	$pj = recuperaDados("pessoa_juridica","idPj",$projeto['idPj']);
			    	$projeto['proponente'] = $pj['razaoSocial'];
			    }
			    $projeto['nomeProjeto'] = $projeto['nomeProjeto'];
			    $projeto['protocolo'] = $projeto['protocolo'];
			    $projeto['valorAprovado'] = $projeto['valorAprovado'];
			    $projeto['renuncia'] = $renuncia['renunciaFiscal'];

			    echo "<p><strong>Nome do projeto:</strong> ".$projeto['proponente']."</p>";
			    echo "<p><strong>Protocolo:</strong> ".$projeto['protocolo']."</p>";
			    echo "<p><strong>Valor total aprovado:</strong> ".$projeto['valorAprovado']."</p>";
			    echo "<p><strong>Percentual de renúncia:</strong> ".$projeto['renuncia']."</p>";
			    echo "<p>&nbsp;</p>";
			}
			
		    $i++;
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
		$i = 0;
		while($campo = mysqli_fetch_array($query_area))
		{
		    $x[$i]['area'] = $campo['areaAtuacao'];
		    $area = $x[$i]['area'];
			$sql = "SELECT * FROM projeto WHERE idAreaAtuacao = '$area' ORDER BY idAreaAtuacao";
			$query = mysqli_query($con,$sql);
			echo "<h4>".strtoupper($area)."</h4>";

			while($projeto = mysqli_fetch_array($query))
			{
			    $renuncia = recuperaDados("renuncia_fiscal","idRenuncia",$projeto['idRenunciaFiscal']);
			    if($projeto['tipoPessoa'] == 1)
			    {
			    	$pf = recuperaDados("pessoa_fisica","idPf",$projeto['idPf']);
			    	$projeto['proponente'] = $pf['nome'];
			    }
			    else
			    {
			    	$pj = recuperaDados("pessoa_juridica","idPj",$projeto['idPj']);
			    	$projeto['proponente'] = $pj['razaoSocial'];
			    }
			    $projeto['nomeProjeto'] = $projeto['nomeProjeto'];
			    $projeto['protocolo'] = $projeto['protocolo'];
			    $projeto['valorAprovado'] = $projeto['valorAprovado'];
			    $projeto['renuncia'] = $renuncia['renunciaFiscal'];

			    echo "<p><strong>Nome do projeto:</strong> ".$projeto['proponente']."</p>";
			    echo "<p><strong>Protocolo:</strong> ".$projeto['protocolo']."</p>";
			    echo "<p><strong>Valor total aprovado:</strong> ".$projeto['valorAprovado']."</p>";
			    echo "<p><strong>Percentual de renúncia:</strong> ".$projeto['renuncia']."</p>";
			    echo "<p>&nbsp;</p>";
			}
			
		    $i++;
		}
		?>


		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p><center>São Paulo, __ de ____ de 2018.</center></p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
</body>
</html>

