<?php
$con = bancoMysqli();

$situa = $_GET['id'];

if($situa == 1)
{
	$send =  mysqli_query($con, "UPDATE statusProjeto SET situacaoAtual = '$situa', descricaoSituacao = 'liberado'");
	if($send)
		echo "<script>alert('Os cadastros de projeto foram liberados.')</script>";
		echo "<script>window.location.replace('?perfil=smc_index')</script>";
}
else
{
	$send =  mysqli_query($con, "UPDATE statusProjeto SET situacaoAtual = '$situa', descricaoSituacao = 'bloqueado'");
	if($send)
		echo "<script>alert('Os cadastros de projeto foram bloqueados.')</script>";
		echo "<script>window.location.replace('?perfil=smc_index')</script>";
}

?>