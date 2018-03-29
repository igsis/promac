<?php 
	session_start();
	   @ini_set('display_errors', '1');
	error_reporting(E_ALL); 	
   
   // INSTALAÇÃO DA CLASSE NA PASTA FPDF.
	require_once("../include/lib/fpdf/fpdf.php");


header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=carta_intencao.doc");

?>

<html>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">
<body>
<style type='text/css'>
.style_01 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
</style>

<center><h3>MODELO SUGESTIVO DE CARTA DE INTENÇÃO</h3></center>

<p>&nbsp;</p>
<p>&nbsp;</p>

<p><center>A empresa incentivadora ___________, sediada à __________________. São Paulo/SP, contribuinte do C.C.M.  nº _________ vem por meio desta afirmar a intenção de patrocinar no valor de R$______ (_______ mil reais) em ____  vez(ES) o projeto “_________” aprovado no Programa Municipal de Apoio a Projetos Culturais, para o imposto ________.</center></p>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<p><center>São Paulo, __ de ____ de 2018.</center></p>
<br /><br />

<p>&nbsp;</p>
<p>&nbsp;</p>


<p><center>_____________________________________________</center><br />
<strong><center>Proponente</center></strong>

<p>&nbsp;</p>
<p>&nbsp;</p>	
 
<p><center>______________________________________________</center><br />
<strong><center>Incentivador</center><strong>
 

</body>
</html>

