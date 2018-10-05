<?php
$con = bancoMysqli();

$situa = $_GET['id'];

if($situa == 1)
{
	$sql = "UPDATE statusprojeto SET situacaoAtual = '$situa', descricaoSituacao = 'LIBERADO'";
	$send =  mysqli_query($con, $sql);
	if($send)
		gravarLog($sql);
		echo "<script>alert('Os cadastros de projeto foram liberados.')</script>";
		echo "<script>window.location.replace('?perfil=smc_index')</script>";
}
else
{
	$sql = "UPDATE statusprojeto SET situacaoAtual = '$situa', descricaoSituacao = 'BLOQUEADO'";
	$send =  mysqli_query($con, $sql);
	if($send)
		gravarLog($sql);
		echo "<script>alert('Os cadastros de projeto foram bloqueados.')</script>";
		echo "<script>window.location.replace('?perfil=smc_index')</script>";
}

?>
