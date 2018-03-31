<?php
ini_set('session.gc_maxlifetime', 60*60); // 60 minutos
session_start();

if(!isset ($_SESSION['login']) == true) //verifica se há uma sessão, se não, volta para área de login
{
	if(!isset($_POST['consulta']))
	{
		unset($_SESSION['login']);
		header('location:../index.php');
	}
	else
	{
		$_SESSION['idUser'] = "Consulta Publica";
		$_SESSION['consulta'] = true;
	}
}
else
{
	$logado = $_SESSION['login'];
}
?>

<html>
	<head>
		<title>SMC / Pro-Mac - Programa Municipal de Apoio a Projetos Culturais</title>
		<meta charset="utf-8" />
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- css -->
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="css/style.css" rel="stylesheet" media="screen">
		<link href="color/default.css" rel="stylesheet" media="screen">
		<link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<?php include "../include/script.php"; ?>
    </head>
	<body>
		<div id="bar">
			<p id="p-bar"><img src="images/logo_cultura_h.png" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Pro-Mac</b>
			</p>
		</div>
<?php
# Menu progresso
include_once '../visual/smart_wizard.php';
?>