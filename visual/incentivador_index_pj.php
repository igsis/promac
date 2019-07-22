<?php
//Imprime erros com o banco
@ini_set('display_errors', '1');
error_reporting(E_ALL);

//define a session como 60 min
session_cache_expire(60);

date_default_timezone_set('America/Sao_Paulo');

//carrega as funcoes gerais
require "../funcoes/funcoesConecta.php";
require "../funcoes/funcoesGerais.php";

//carrega o cabeçalho
require "cabecalho.php";

// carrega o perfil
if(isset($_GET['perfil']))
{
	include "../perfil/".$_GET['perfil'].".php";
}
else
{
	include "../perfil/cadastro_incentivador_pj.php";
}

 //carrega o rodapé
include "rodape.php";

?>