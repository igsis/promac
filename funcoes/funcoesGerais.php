<?php
function habilitarErro()
{
	@ini_set('display_errors', '1');
	error_reporting(E_ALL);
}

function isYoutubeVideo($link)
{
	$find = "/youtube/";
	$objetivo = array();

	$resultado = preg_match($find, $link, $objetivo);
	return isset($objetivo[0]) ? $objetivo[0] : null;
}

function autenticaloginpf($login, $senha)
{
	$sql = "SELECT * FROM pessoa_fisica AS pf
	WHERE pf.cpf = '$login' LIMIT 0,1";
	$con = bancoMysqli();
	$query = mysqli_query($con,$sql);
	//query que seleciona os campos que voltarão para na matriz
	if($query)
	{
		//verifica erro no banco de dados
		if(mysqli_num_rows($query) > 0)
		{
			// verifica se retorna usuário válido
			$user = mysqli_fetch_array($query);
			if($user['senha'] == md5($_POST['senha']))
			{
				// compara as senhas
				session_start();
				$_SESSION['login'] = $user['cpf'];
				$_SESSION['nome'] = $user['nome'];
				$_SESSION['idUser'] = $user['idPf'];
				$_SESSION['tipoPessoa'] = "1";
				$log = "Fez login.";
				$cpf = $user['cpf'];
				$query = "SELECT idNivelAcesso FROM pessoa_fisica WHERE cpf='$cpf'";
				$envio = mysqli_query($con, $query);
				while($row = mysqli_fetch_array($envio))
				{
					$nAcesso = $row['idNivelAcesso'];
				}
				if($nAcesso == 1)
					header("Location: visual/index_pf.php");
				else if($nAcesso == 2){
					header("Location: visual/index_pf.php?perfil=smc_index");
					$_SESSION['tipoUsuario'] = 2;
				}
				else if($nAcesso == 3)
					header("Location:  visual/index_pf.php?perfil=comissao_index");
			}
			else
			{
				return "<font color='#FF0000'><strong>A senha está incorreta!</strong></font>";
			}
		}
		else
		{
			return "<font color='#FF0000'><strong>O usuário não existe.</strong></font>";
		}
	}
	else
	{
		return "<font color='#FF0000'><strong>Erro no banco de dados!</strong></font>";
	}
}

function autenticaloginpj($login, $senha)
{
	$sql = "SELECT * FROM pessoa_juridica AS pj
	WHERE pj.cnpj = '$login' LIMIT 0,1";
	$con = bancoMysqli();
	$query = mysqli_query($con,$sql);
	//query que seleciona os campos que voltarão para na matriz
	if($query)
	{
		//verifica erro no banco de dados
		if(mysqli_num_rows($query) > 0)
		{
			// verifica se retorna usuário válido
			$user = mysqli_fetch_array($query);
			if($user['senha'] == md5($_POST['senha']))
			{
				// compara as senhas
				session_start();
				$_SESSION['login'] = $user['cnpj'];
				$_SESSION['nome'] = $user['razaoSocial'];
				$_SESSION['idUser'] = $user['idPj'];
				$_SESSION['tipoPessoa'] = "2";
				$log = "Fez login.";
				header("Location: visual/index_pj.php");
			}
			else
			{
				return "<font color='#FF0000'><strong>A senha está incorreta!</strong></font>";
			}
		}
		else
		{
			return "<font color='#FF0000'><strong>O usuário não existe.</strong></font>";
		}
	}
	else
	{
		return "<font color='#FF0000'><strong>Erro no banco de dados!</strong></font>";
	}
}

function autenticaloginincentivadorpf($login, $senha)
{
	$sql = "SELECT * FROM incentivador_pessoa_fisica AS pf
	WHERE pf.cpf = '$login' LIMIT 0,1";
	$con = bancoMysqli();
	$query = mysqli_query($con,$sql);
	//query que seleciona os campos que voltarão para na matriz
	if($query)
	{
		//verifica erro no banco de dados
		if(mysqli_num_rows($query) > 0)
		{
			// verifica se retorna usuário válido
			$user = mysqli_fetch_array($query);
			if($user['senha'] == md5($_POST['senha']))
			{
				// compara as senhas
				session_start();
				$_SESSION['login'] = $user['cpf'];
				$_SESSION['nome'] = $user['nome'];
				$_SESSION['idUser'] = $user['idPf'];
				$_SESSION['tipoPessoa'] = "1";
				$log = "Fez login.";
				$cpf = $user['cpf'];
				header("Location: visual/incentivador_index_pf.php");
			}
			else
			{
				return "<font color='#FF0000'><strong>A senha está incorreta!</strong></font>";
			}
		}
		else
		{
			return "<font color='#FF0000'><strong>O usuário não existe.</strong></font>";
		}
	}
	else
	{
		return "<font color='#FF0000'><strong>Erro no banco de dados!</strong></font>";
	}
}

function autenticaloginincentivadorpj($login, $senha)
{
	$sql = "SELECT * FROM incentivador_pessoa_juridica AS pj
	WHERE pj.cnpj = '$login' LIMIT 0,1";
	$con = bancoMysqli();
	$query = mysqli_query($con,$sql);
	//query que seleciona os campos que voltarão para na matriz
	if($query)
	{
		//verifica erro no banco de dados
		if(mysqli_num_rows($query) > 0)
		{
			// verifica se retorna usuário válido
			$user = mysqli_fetch_array($query);
			if($user['senha'] == md5($_POST['senha']))
			{
				// compara as senhas
				session_start();
				$_SESSION['login'] = $user['cnpj'];
				$_SESSION['nome'] = $user['razaoSocial'];
				$_SESSION['idUser'] = $user['idPj'];
				$_SESSION['tipoPessoa'] = "2";
				$log = "Fez login.";
				header("Location: visual/incentivador_index_pj.php");
			}
			else
			{
				return "<font color='#FF0000'><strong>A senha está incorreta!</strong></font>";
			}
		}
		else
		{
			return "<font color='#FF0000'><strong>O usuário não existe.</strong></font>";
		}
	}
	else
	{
		return "<font color='#FF0000'><strong>Erro no banco de dados!</strong></font>";
	}
}

//saudacao inicial
function saudacao()
{
	$hora = date('H');
	if(($hora > 12) AND ($hora <= 18))
	{
		return "Boa tarde";
	}
	else if(($hora > 18) AND ($hora <= 23))
	{
		return "Boa noite";
	}
	else if(($hora >= 0) AND ($hora <= 4))
	{
		return "Boa noite";
	}
	else if(($hora > 4) AND ($hora <=12))
	{
		return "Bom dia";
	}
}
// Formatação de datas, valores
// Retira acentos das strings
function semAcento($string)
{
	$newstring = preg_replace("/[^a-zA-Z0-9_.]/", "", strtr($string, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
	return $newstring;
}
//retorna data d/m/y de mysql/date(a-m-d)
function exibirDataBr($data)
{
	if($data == '0000-00-00' || $data == NULL)
	{
		return "00-00-0000";
	}
	else
	{
		$timestamp = strtotime($data);
		return date('d/m/Y', $timestamp);
	}
}
// retorna datatime sem hora
function retornaDataSemHora($data)
{
	$semhora = substr($data, 0, 10);
	return $semhora;
}
//retorna data d/m/y de mysql/datetime(a-m-d H:i:s)
function exibirDataHoraBr($data)
{
	if($data == '0000-00-00 00:00:00')
	{
		return "0000-00-00 00:00:00";
	}
	else
	{
		$timestamp = strtotime($data);
		return date('d/m/y - H:i:s', $timestamp);
	}
}
function returnEmptyDateCronograma($VCAM, $idProjeto)
{
	$con = bancoMysqli();
	$sql = "SELECT " . $VCAM ." FROM projeto WHERE idProjeto = '" . $idProjeto ."' LIMIT 0,1";
	$query = mysqli_query($con,$sql);
	$rnow = mysqli_num_rows($query);
	while($campo = mysqli_fetch_array($query)){
		return $campo[$VCAM];
	}
}

function returnEmptyDate($VCAM, $idProjeto)
{
	$con = bancoMysqli();
	$sql = "SELECT " . $VCAM ." FROM prazos_projeto WHERE idProjeto = '" . $idProjeto ."' LIMIT 0,1";
	$query = mysqli_query($con,$sql);
	$rnow = mysqli_num_rows($query);
	while($campo = mysqli_fetch_array($query)){
		return $campo[$VCAM];
	}
}
//retorna hora H:i de um datetime
function exibirHora($data)
{
	$timestamp = strtotime($data);
	return date('H:i', $timestamp);
}
//retorna data mysql/date (a-m-d) de data/br (d/m/a)
function exibirDataMysql($data)
{
	list ($dia, $mes, $ano) = explode ('/', $data);
	$data_mysql = $ano.'-'.$mes.'-'.$dia;
	return $data_mysql;
}
//retorna o endereço da página atual
function urlAtual()
{
	$dominio= $_SERVER['HTTP_HOST'];
	$url = "http://" . $dominio. $_SERVER['REQUEST_URI'];
	return $url;
}
//retorna valor xxx,xx para xxx.xx
function dinheiroDeBr($valor)
{
	$valor = str_ireplace(".","",$valor);
	$valor = str_ireplace(",",".",$valor);
	return $valor;
}
//retorna valor xxx.xx para xxx,xx
function dinheiroParaBr($valor)
{
	$valor = number_format($valor, 2, ',', '.');
	return $valor;
}
//use em problemas de codificacao utf-8
function _utf8_decode($string)
{
	$tmp = $string;
	$count = 0;
	while (mb_detect_encoding($tmp)=="UTF-8")
	{
		$tmp = utf8_decode($tmp);
		$count++;
	}
	for ($i = 0; $i < $count-1 ; $i++)
	{
		$string = utf8_decode($string);
	}
	return $string;
}
//retorna o dia da semana segundo um date(a-m-d)
function diasemana($data)
{
	$ano =  substr("$data", 0, 4);
	$mes =  substr("$data", 5, -3);
	$dia =  substr("$data", 8, 9);
	$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
	switch($diasemana)
	{
		case"0": $diasemana = "Domingo";       break;
		case"1": $diasemana = "Segunda-Feira"; break;
		case"2": $diasemana = "Terça-Feira";   break;
		case"3": $diasemana = "Quarta-Feira";  break;
		case"4": $diasemana = "Quinta-Feira";  break;
		case"5": $diasemana = "Sexta-Feira";   break;
		case"6": $diasemana = "Sábado";        break;
	}
	return "$diasemana";
}

//soma(+) ou substrai(-) dias de um date(a-m-d)
function somarDatas($data,$dias)
{
	$data_final = date('Y-m-d', strtotime("$dias days",strtotime($data)));
	return $data_final;
}

//retorna a diferença de dias entre duas datas
function diferencaDatas($data_inicial,$data_final)
{
	// Define os valores a serem usados
	// Usa a função strtotime() e pega o timestamp das duas datas:
	$time_inicial = strtotime($data_inicial);
	$time_final = strtotime($data_final);
	// Calcula a diferença de segundos entre as duas datas:
	$diferenca = $time_final - $time_inicial; // 19522800 segundos
	// Calcula a diferença de dias
	$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
	return $dias;
}

function gravarLog($log)
{
	//grava na tabela log os inserts e updates
	$logTratado = addslashes($log);
	$idUser = $_SESSION['idUser'];
	$ip = $_SERVER["REMOTE_ADDR"];
	$data = date('Y-m-d H:i:s');
	$sql = "INSERT INTO `log` (`id`, `idUsuario`, `enderecoIP`, `dataLog`, `descricao`)
		VALUES (NULL, '$idUser', '$ip', '$data', '$logTratado')";
	$mysqli = bancoMysqli();
	$mysqli->query($sql);
}

function gravarLogSenha($log, $idUsuario)
{
	//grava na tabela log os inserts e updates
	$logTratado = addslashes($log);
	$ip = $_SERVER["REMOTE_ADDR"];
	$data = date('Y-m-d H:i:s');
	$sql = "INSERT INTO `log` (`id`, `idUsuario`, `enderecoIP`, `dataLog`, `descricao`)
		VALUES (NULL, '$idUsuario', '$ip', '$data', '$logTratado')";
	$mysqli = bancoMysqli();
	$mysqli->query($sql);
}

function geraOpcao($tabela,$select)
{
	//gera os options de um select
	$sql = "SELECT * FROM $tabela ORDER BY 2";

	$con = bancoMysqli();
	$query = mysqli_query($con,$sql);
	while($option = mysqli_fetch_row($query))
	{
		if($option[0] == $select)
		{
			echo "<option value='".$option[0]."' selected >".$option[1]."</option>";
		}
		else
		{
			echo "<option value='".$option[0]."'>".$option[1]."</option>";
		}
	}
}

function geraAreaAtuacao($tabela,$tipo,$select)
{
	//gera os options de um select
	$sql = "SELECT * FROM $tabela WHERE tipo IN ($tipo) ORDER BY 2";

	$con = bancoMysqli();
	$query = mysqli_query($con,$sql);
	while($option = mysqli_fetch_row($query))
	{
		if($option[0] == $select)
		{
			echo "<option value='".$option[0]."' selected >".$option[1]."</option>";
		}
		else
		{
			echo "<option value='".$option[0]."'>".$option[1]."</option>";
		}
	}
}

function geraCombobox($tabela,$campo,$order,$select)
{
	//gera os options de um select
	$sql = "SELECT * FROM $tabela ORDER BY $order";

	$con = bancoMysqli();
	$query = mysqli_query($con,$sql);
	while($option = mysqli_fetch_row($query))
	{
		if($option[0] == $select)
		{
			echo "<option value='".$option[0]."' selected >".$option[$campo]."</option>";
		}
		else
		{
			echo "<option value='".$option[0]."'>".$option[$campo]."</option>";
		}
	}
}

function recuperaModulo($pag)
{
	$sql = "SELECT * FROM modulo WHERE pagina = '$pag'";
	$con = bancoMysqli();
	$query = mysqli_query($con,$sql);
	$modulo = mysqli_fetch_array($query);
	return $modulo;
}

function recuperaUsuarioCompleto($id)
{
	//retorna dados do usuário
	$recupera = recuperaDados('usuario_pf','id',$id);
	if($recupera)
	{
		$x = array(
			"nome" => $recupera['nome'],
			"email" => $recupera['email'],
			"login" => $recupera['login'],
			"telefone1" => $recupera['telefone1'],
			"telefone2" => $recupera['telefone2']);
		return $x;
	}
	else
	{
		return NULL;
	}
}

function recuperaDados($tabela,$campo,$variavelCampo)
{
	//retorna uma array com os dados de qualquer tabela. serve apenas para 1 registro.
	$con = bancoMysqli();
	$sql = "SELECT * FROM $tabela WHERE ".$campo." = '$variavelCampo' LIMIT 0,1";
	$query = mysqli_query($con,$sql);
	$campo = mysqli_fetch_array($query);
	return $campo;
}

function recuperaDadosProjeto($tabela,$campo,$variavelCampo)
{
	//retorna uma array com os dados de qualquer tabela. serve apenas para 1 registro.
	$con = bancoMysqli();
	$sql = "SELECT * FROM $tabela WHERE ".$campo." = '$variavelCampo' ORDER BY 'idProjeto' DESC LIMIT 0,1";
	$query = mysqli_query($con,$sql);
	$campo = mysqli_fetch_array($query);
	return $campo;
}

function recuperaStatus($tabela)
{
	$con = bancoMysqli();
	$sql = "SELECT situacaoAtual FROM $tabela WHERE idStatus = '1'";
	$query = mysqli_query($con,$sql);
	$campo = mysqli_fetch_array($query);
	return $campo['situacaoAtual'];
}

function verificaExiste($idTabela,$idCampo,$idDado,$st)
{
	//retorna uma array com indice 'numero' de registros e 'dados' da tabela
	$con = bancoMysqli();
	if($st == 1)
	{
		// se for 1, é uma string
		$sql = "SELECT * FROM $idTabela WHERE $idCampo = '%$idDado%'";
	}
	else
	{
		$sql = "SELECT * FROM $idTabela WHERE $idCampo = '$idDado'";
	}
	$query = mysqli_query($con,$sql);
	$numero = mysqli_num_rows($query);
	$dados = mysqli_fetch_array($query);
	$campo['numero'] = $numero;
	$campo['dados'] = $dados;
	return $campo;
}

function recuperaIdDado($tabela,$id)
{
	$con = bancoMysqli();
	//recupera os nomes dos campos
	$sql = "SELECT * FROM $tabela";
	$query = mysqli_query($con,$sql);
	$campo01 = mysqli_field_name($query, 0);
	$campo02 = mysqli_field_name($query, 1);
	$sql = "SELECT * FROM $tabela WHERE $campo01 = $id";
	$query = mysql_query($sql);
	$campo = mysql_fetch_array($query);
	return $campo[$campo02];
}

function checar($id)
{
	//funcao para imprimir checked do checkbox
	if($id == 1)
	{
		echo "checked";
	}
}

function valorPorExtenso($valor=0)
{
	//retorna um valor por extenso
	$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
	$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
	$c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
	$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
	$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
	$u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
	$z=0;
	$valor = number_format($valor, 2, ".", ".");
	$inteiro = explode(".", $valor);
	for($i=0;$i<count($inteiro);$i++)
		for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
			$inteiro[$i] = "0".$inteiro[$i];
	$rt = "";
	// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
	$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
	for ($i=0;$i<count($inteiro);$i++)
	{
		$valor = $inteiro[$i];
		$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
		$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
		$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
		$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
		$t = count($inteiro)-1-$i;
		$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
		if ($valor == "000")$z++; elseif ($z > 0) $z--;
		if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
		if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
	}
	return($rt ? $rt : "zero");
}

function analisaArray($array)
{
	//imprime o conteúdo de uma array
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

function recuperaUltimo($tabela)
{
	$con = bancoMysqli();
	$sql = "SELECT * FROM $tabela ORDER BY 1 DESC LIMIT 0,1";
	$query =  mysqli_query($con,$sql);
	$campo = mysqli_fetch_array($query);
	return $campo[0];
}

function recuperaUltimoDoUsuario($tabela,$idUser)
{
	$con = bancoMysqli();
	$sql = "SELECT * FROM $tabela WHERE idUsuario = $idUser ORDER BY 1 DESC LIMIT 0,1";
	$query =  mysqli_query($con,$sql);
	$campo = mysqli_fetch_array($query);
	return $campo[0];
}

function retornaMes($mes)
{
	switch($mes)
	{
		case "01":
			return "Janeiro";
		break;
		case "02":
			return "Fevereiro";
		break;
		case "03":
			return "Março";
		break;
		case "04":
			return "Abril";
		break;
		case "05":
			return "Maio";
		break;
		case "06":
			return "Junho";
		break;
		case "07":
			return "Julho";
		break;
		case "08":
			return "Agosto";
		break;
		case "09":
			return "Setembro";
		break;
		case "10":
			return "Outubro";
		break;
		case "11":
			return "Novembro";
		break;
		case "12":
			return "Dezembro";
		break;
	}
}

function retornaMesExtenso($data)
{
	$meses = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
	$data = explode("-", $dataMysql);
	$mes = $data[1];
	return $meses[($mes) - 1];
}

//retorna o dia da semana segundo um date(a-m-d)
function diaSemanaBase($data)
{
	$ano =  substr("$data", 0, 4);
	$mes =  substr("$data", 5, -3);
	$dia =  substr("$data", 8, 9);
	$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
	switch($diasemana)
	{
		case"0":
			$diasemana = "domingo";
		break;
		case"1":
			$diasemana = "segunda";
		break;
		case"2":
			$diasemana = "terca";
		break;
		case"3":
			$diasemana = "quarta";
		break;
		case"4":
			$diasemana = "quinta";
		break;
		case"5":
			$diasemana = "sexta";
		break;
		case"6":
			$diasemana = "sabado";
		break;
	}
	return "$diasemana";
}

function soNumero($str)
{
	return preg_replace("/[^0-9]/", "", $str);
}

// Gera o endereço no PDF
function enderecoCEP($cep)
{
	$con = bancoMysqliCEP();
	$cep_index = substr($cep, 0, 5);
	$dados['sucesso'] = 0;
	$sql01 = "SELECT * FROM igsis_cep_cep_log_index WHERE cep5 = '$cep_index' LIMIT 0,1";
	$query01 = mysqli_query($con,$sql01);
	$campo01 = mysqli_fetch_array($query01);
	$uf = "igsis_cep_".$campo01['uf'];
	$sql02 = "SELECT * FROM $uf WHERE cep = '$cep'";
	$query02 = mysqli_query($con,$sql02);
	$campo02 = mysqli_fetch_array($query02);
	$res = mysqli_num_rows($query02);
	if($res > 0)
	{
		$dados['sucesso'] = 1;
	}
	else
	{
		$dados['sucesso'] = 0;
	}
	$dados['rua']     = $campo02['tp_logradouro']." ".$campo02['logradouro'];
	$dados['bairro']  = $campo02['bairro'];
	$dados['cidade']  = $campo02['cidade'];
	$dados['estado']  = strtoupper($campo01['uf']);
	return $dados;
}

function verificaArquivosExistentes($idPessoa,$idDocumento)
{
	$con = bancoMysqli();
	$verificacaoArquivo = "SELECT arquivo FROM upload_arquivo WHERE idPessoa = '$idPessoa' AND idUploadListaDocumento = '$idDocumento'";
	$envio = mysqli_query($con, $verificacaoArquivo);

	if (mysqli_num_rows($envio)>0) {
		return true;
	}
}

function listaArquivosEvento($idPessoa, $tipoPessoa, $pagina)
{
	$con = bancoMysqli();
	$sql = "SELECT * FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.publicado = '1'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.idListaDocumento IN (18,19)";
			$query = mysqli_query($con,$sql);
			$linhas = mysqli_num_rows($query);

		if ($linhas > 0)
		{
			echo "
			<table class='table table-condensed'>
			<thead>
			<tr class='list_menu'>
			<td>Tipo de arquivo</td>
			<td>Nome do arquivo</td>
			<td width='15%'></td>
			</tr>
			</thead>
			<tbody>";
			while($arquivo = mysqli_fetch_array($query))
			{
				echo "<tr>";
				echo "<td class='list_description'>(".$arquivo['documento'].")</td>";
				echo "<td class='list_description'><a href='../uploadsdocs/".$arquivo['arquivo']."' target='_blank'>". mb_strimwidth($arquivo['arquivo'], 15 ,25,"..." ) ."</a></td>";
				echo "
				<td class='list_description'>
				<form id='apagarArq' method='POST' action='?perfil=projeto_3'>
				<input type='hidden' name='idPessoa' value='".$idPessoa."' />
				<input type='hidden' name='tipoPessoa' value='2' />
				<input type='hidden' name='apagar' value='".$arquivo['idUploadArquivo']."' />
				<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Remover Arquivo?' data-message='Deseja realmente excluir o arquivo ".$arquivo['documento']."?'>Remover
															</button></td>
				</form>";
				echo "</tr>";
			}
			echo "
			</tbody>
			</table>";
		}
		else
		{
			echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
	}
}

function listaArquivosPessoa($idPessoa,$tipoPessoa,$pagina)
{
	$con = bancoMysqli();
	$sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'";
	$query = mysqli_query($con,$sql);
	$linhas = mysqli_num_rows($query);

	if ($linhas > 0)
	{
	echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Nome do arquivo</td>
					<td width='15%'></td>
				</tr>
			</thead>
			<tbody>";
				while($arquivo = mysqli_fetch_array($query))
				{
					echo "<tr>";
					echo "<td class='list_description'>(".$arquivo['documento'].")</td>";
					echo "<td class='list_description'><a href='../uploadsdocs/".$arquivo['arquivo']."' target='_blank'>". mb_strimwidth($arquivo['arquivo'], 15 ,25,"..." )."</a></td>";
					echo "
						<td class='list_description'>
							<form id='apagarArq' method='POST' action='?perfil=".$pagina."'>
								<input type='hidden' name='idPessoa' value='".$idPessoa."' />
								<input type='hidden' name='tipoPessoa' value='".$tipoPessoa."' />
								<input type='hidden' name='apagar' value='".$arquivo['idUploadArquivo']."' />
								<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Remover Arquivo?' data-message='Deseja realmente excluir o arquivo ".$arquivo['documento']."?'>Remover
								</button></td>
							</form>";
					echo "</tr>";
				}
				echo "
		</tbody>
		</table>";
	}
	else
	{
		echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
	}
}

function listaArquivosPendentePessoa($idPessoa,$tipoPessoa,$pagina)
{
	$con = bancoMysqli();
	$sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.idStatusDocumento != 'null'
			AND arq.idStatusDocumento != '1'
			AND arq.publicado = '1'";
	$query = mysqli_query($con,$sql);
	$linhas = mysqli_num_rows($query);

	if ($linhas > 0)
	{
	echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Nome do arquivo</td>
					<td width='15%'></td>
				</tr>
			</thead>
			<tbody>";
				while($arquivo = mysqli_fetch_array($query))
				{
					echo "<tr>";
					echo "<td class='list_description'>(".$arquivo['documento'].")</td>";
					echo "<td class='list_description'><a href='../uploadsdocs/".$arquivo['arquivo']."' target='_blank'>". mb_strimwidth($arquivo['arquivo'], 15 ,25,"..." )."</a></td>";
					echo "
						<td class='list_description'>
							<form id='apagarArq' method='POST' action='?perfil=".$pagina."'>
								<input type='hidden' name='idPessoa' value='".$idPessoa."' />
								<input type='hidden' name='tipoPessoa' value='".$tipoPessoa."' />
								<input type='hidden' name='apagar' value='".$arquivo['idUploadArquivo']."' />
								<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Remover Arquivo?' data-message='Deseja realmente excluir o arquivo ".$arquivo['documento']."?'>Remover
								</button></td>
							</form>";
					echo "</tr>";
					echo "<tr>";
					echo "<td class='list_description'><button type='button' class='btn btn-warning' data-toggle='modal' data-target='#".$arquivo['idUploadArquivo']."'>Observação</button></td>";
					echo "</tr>";
					// Modal para exibir dados do campo Observação
					echo "
						<div class='modal fade' id='".$arquivo['idUploadArquivo']."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
							<div class='modal-dialog' role='document'>
								<div class='modal-content'>
									<div class='modal-header'>
										<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
										<h4 class='modal-title text-primary' id='myModalLabel'>Observação</h4>
									</div>
									<div class='modal-body'>
										<h6>Arquivo: ".$arquivo['documento']."</h6>
										<p>".$arquivo['observacoes']."	</p>
									</div>
									<div class='modal-footer'>
										<button type='button' class='btn btn-secondary' data-dismiss='modal'>Sair</button>
									</div>
								</div>
							</div>
						</div>";
				}
				echo "
		</tbody>
		</table>";

	}
	else
	{
		echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
	}
}

function listaArquivosPessoaEditor($idPessoa,$tipoPessoa,$pagina)
{
	$con = bancoMysqli();
	$sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'";
	$query = mysqli_query($con,$sql);
	$linhas = mysqli_num_rows($query);

	if ($linhas > 0)
	{
	echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Nome do arquivo</td>
					<td>Status</td>
					<td>Observações</td>
					<td>Ação</td>
				</tr>
			</thead>
			<tbody>";
				while($arquivo = mysqli_fetch_array($query))
				{
					echo "<tr>";
					echo "<td class='list_description'>(".$arquivo['documento'].")</td>";
					echo "<td class='list_description'><a href='../uploadsdocs/".$arquivo['arquivo']."' target='_blank'>". mb_strimwidth($arquivo['arquivo'], 15 ,25,"..." )."</a></td>";
					echo "<form id='atualizaDoc' method='POST' action='?perfil=".$pagina."'>";
					echo "<td class='list_description'>
							<select name='status' id='statusOpt'>
							    <option value='0'>Aprovado</option>
							    <option value='1'>Complementação</option>
							    <option value='2'>Reprovado</option>
							</select>
						</td>";
					echo "<td class='list_description'>
					<input type='text' name='observ' maxlength='100'>
					</td>";

					echo "
						<td class='list_description'>
								<input type='hidden' name='idPessoa' value='".$idPessoa."' />
								<input type='hidden' name='tipoPessoa' value='".$tipoPessoa."' />
								<button class='btn btn-theme' type='button' data-toggle='modal'>Atualizar
								</button></td>
							</form>";
					echo "</tr>";
				}
				echo "
		</tbody>
		</table>";
	}
	else
	{
		echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
	}
}

//Lista os arquivos da pessoa com o campo de status e observação para visualização
function listaArquivosPessoaObs($idPessoa,$tipoPessoa)
{
	$con = bancoMysqli();
	$sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'";
	$query = mysqli_query($con,$sql);
	$linhas = mysqli_num_rows($query);

	if ($linhas > 0)
	{
	echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td><strong>Tipo de arquivo</strong></td>
					<td><strong>Nome do arquivo</strong></td>
					<td><strong>Status</strong></td>
					<td><strong>Observações</strong></td>
				</tr>
			</thead>
			<tbody>";
				while($arquivo = mysqli_fetch_array($query))
				{
					echo "<tr>";
					echo "<td class='list_description'>(".$arquivo['documento'].")</td>";
					echo "<td class='list_description'><a href='../uploadsdocs/".$arquivo['arquivo']."' target='_blank'>". mb_strimwidth($arquivo['arquivo'], 15 ,25,"..." )."</a></td>";
					$queryy = "SELECT idStatusDocumento FROM upload_arquivo WHERE idUploadArquivo = '".$arquivo['idUploadArquivo']."'";
					$send = mysqli_query($con, $queryy);
					$row = mysqli_fetch_array($send);
					$statusDoc = recuperaDados("status_documento","idStatusDocumento",$row['idStatusDocumento']);

					echo "<td class='list_description'>".$statusDoc['status']."</td>";
					$queryOBS = "SELECT observacoes FROM upload_arquivo WHERE idUploadArquivo = '".$arquivo['idUploadArquivo']."'";
					$send = mysqli_query($con, $queryOBS);
					$row = mysqli_fetch_array($send);
					echo "<td class='list_description'>".$row['observacoes']."</td>";
					echo "</tr>";
				}
				echo "
		</tbody>
		</table>";
	}
	else
	{
		echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
	}
}

function exibirArquivos($tipoPessoa,$idPessoa)
{
	$con = bancoMysqli();
	$sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'";
	$query = mysqli_query($con,$sql);
	echo "
		<table class='table table-bordered'>
			<tr>
				<td><strong>Tipo de arquivo</strong></td>
				<td><strong>Nome do arquivo</strong></td>
				<td><strong>Status</strong></td>
				<td><strong>Observações</strong></td>
			</tr>
	";
	while($arquivo = mysqli_fetch_array($query))
	{
		echo "<tr>";
		echo "<td class='list_description'>(".$arquivo['documento'].")</td>";
		echo "<td class='list_description'><a href='../uploadsdocs/".$arquivo['arquivo']."' target='_blank'>".$arquivo['arquivo']."</a></td>";
		$queryy = "SELECT idStatusDocumento FROM upload_arquivo WHERE idUploadArquivo = '".$arquivo['idUploadArquivo']."'";
		$send = mysqli_query($con, $queryy);
		$row = mysqli_fetch_array($send);
		$statusDoc = recuperaDados("status_documento","idStatusDocumento",$row['idStatusDocumento']);
		echo "<td class='list_description'>".$statusDoc['status']."</td>";
		echo "<td class='list_description'>".$arquivo['observacoes']."</td>";
		echo "</tr>";
	}
	echo "</table>";
}

// Função que valida o CPF
function validaCPF($cpf)
{
	$cpf = preg_replace('/[^0-9]/', '', (string) $cpf);
	// Valida tamanho
	if (strlen($cpf) != 11)
		return false;
	// Calcula e confere primeiro dígito verificador
	for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
		$soma += $cpf{$i} * $j;
	$resto = $soma % 11;
	if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto))
		return false;
	// Lista de CPFs inválidos
	$invalidos = array(
		'11111111111',
		'22222222222',
		'33333333333',
		'44444444444',
		'55555555555',
		'66666666666',
		'77777777777',
		'88888888888',
		'99999999999');
	// Verifica se o CPF está na lista de inválidos
	if (in_array($cpf, $invalidos))
		return false;
	// Calcula e confere segundo dígito verificador
	for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
		$soma += $cpf{$i} * $j;
	$resto = $soma % 11;
	return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
}

// Função que valida o CNPJ
function validaCNPJ($cnpj)
{
	$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
	// Valida tamanho
	if (strlen($cnpj) != 14)
		return false;
	// Valida primeiro dígito verificador
	for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
	{
		$soma += $cnpj{$i} * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
	if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
		return false;
	// Lista de CNPJs inválidos
	$invalidos = array(
		'11111111111111',
		'22222222222222',
		'33333333333333',
		'44444444444444',
		'55555555555555',
		'66666666666666',
		'77777777777777',
		'88888888888888',
		'99999999999999'
	);
	// Verifica se o CNPJ está na lista de inválidos
	if (in_array($cnpj, $invalidos))
	{
		return false;
	}
	// Valida segundo dígito verificador
	for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
	{
		$soma += $cnpj{$i} * $j;
		$j = ($j == 2) ? 9 : $j - 1;
	}
	$resto = $soma % 11;
	return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
}

// Função que valida e-mails
function validaEmail($email)
{
	/* Verifica se o email e valido */
	if (filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		/* Obtem o dominio do email */
		list($usuario, $dominio) = explode('@', $email);

		/* Faz um verificacao de DNS no dominio */
		if (checkdnsrr($dominio, 'MX') == 1)
		{
			return TRUE;
		}
		else
		{
		return FALSE;
		}
	}
	else
	{
		return FALSE;
	}
}

function listaArquivos($idEvento)
{
	//lista arquivos de determinado evento
	$con = bancoMysqli();
	$sql = "SELECT * FROM upload_arquivo_com_prod WHERE idEvento = '$idEvento' AND publicado = '1'";
	$query = mysqli_query($con,$sql);
	echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Nome do arquivo</td>
					<td width='10%'></td>
				</tr>
			</thead>
			<tbody>";
	while($campo = mysqli_fetch_array($query))
	{
		echo "<tr>";
		echo "<td class='list_description'><a href='../uploads/".$campo['arquivo']."' target='_blank'>".$campo['arquivo']."</a></td>";
		echo "
			<td class='list_description'>
				<form method='POST' action='?perfil=arquivos_com_prod'>
					<input type='hidden' name='apagar' value='".$campo['id']."' />
					<input type ='submit' class='btn btn-theme  btn-block' value='Remover'></td></form>"	;
		echo "</tr>";
	}
	echo "
		</tbody>
		</table>";
}

function geraProtocolo($id)
{
	date_default_timezone_set('America/Sao_Paulo');
	$date = date('Ymd');
	$preencheZeros = str_pad($id, 5, '0', STR_PAD_LEFT);
	return $date . $preencheZeros;
}

function verificaArquivosExistentesPF($idPessoa,$idDocumento)
{
	$con = bancoMysqli();
	$verificacaoArquivo = "SELECT arquivo FROM upload_arquivo WHERE idPessoa = '$idPessoa' AND idListaDocumento = '$idDocumento' AND publicado = '1'";
	$envio = mysqli_query($con, $verificacaoArquivo);
	if (mysqli_num_rows($envio) > 0) {
		return true;
	}
}

function verificaArquivosExistentesIncentivador($idPessoa,$idDocumento)
{
	$con = bancoMysqli();
	$verificacaoArquivo = "SELECT arquivo FROM upload_arquivo WHERE idPessoa = '$idPessoa' AND idListaDocumento = '$idDocumento' AND publicado = '1'";
	$envio = mysqli_query($con, $verificacaoArquivo);
	if (mysqli_num_rows($envio) > 0) {
		return true;
	}
}

function retornaCamposObrigatoriosLocais($idProjeto)
{
	$campos = [];

	$conexao = bancoMysqli();
	$query =  "SELECT 	             	             
	             loc_rea.local AS local, 
	             loc_rea.estimativaPublico AS estimativaLocal, 
	             loc_rea.idZona AS zonaLocal  				 
			   FROM  
			     projeto as proj			     			   
  			   INNER JOIN 
                  locais_realizacao AS loc_rea 
               ON loc_rea.idProjeto = proj.idProjeto
  			   
  			   WHERE loc_rea.publicado = 1
  			   AND  proj.idProjeto =".$idProjeto;

	$resultado = mysqli_query($conexao,$query);		

	while($campo = mysqli_fetch_assoc($resultado)) 
    {
      array_push($campos, $campo);
    }	  

    return $campos;
}	

function retornaCamposObrigatoriosFichaTecnica($idProjeto)
{
	$campos = [];

	$conexao = bancoMysqli();
	$query =  "SELECT 	             	             
	             ficha_t.nome AS nomeFichaTecnica, 
  				 ficha_t.cpf AS cpfFichaTecnica, 
  				 ficha_t.funcao AS funcaoFichaTecnica  					             
			   FROM  
			     projeto as proj
			   INNER JOIN 
  			      ficha_tecnica AS ficha_t 
  			   ON ficha_t.idProjeto = proj.idProjeto
  			   
  			   WHERE ficha_t.publicado = 1
  			   AND  proj.idProjeto =".$idProjeto;

	$resultado = mysqli_query($conexao,$query);		

	while($campo = mysqli_fetch_assoc($resultado)) 
    {
      array_push($campos, $campo);
    }	  

    return $campos;
}	

function retornaCamposObrigatoriosCronograma($idProjeto)
{
	$campos = [];

	$conexao = bancoMysqli();
	$query =  "SELECT 	             	             
  				 crono.captacaoRecurso AS recursoConograma, 
  				 crono.preProducao AS preProducaoConograma, 
  				 crono.producao AS producaoConograma, 
  				 crono.posProducao AS posProducaoConograma, 
  				 crono.prestacaoContas AS ContasConograma  			     
			   FROM  
			     projeto as proj
			   INNER JOIN 
  			     cronograma AS crono 
  			   ON crono.idCronograma = proj.idCronograma			   
			   
  			   WHERE proj.idProjeto =".$idProjeto;  			   

	$resultado = mysqli_query($conexao,$query);		

	while($campo = mysqli_fetch_assoc($resultado)) 
    {
      array_push($campos, $campo);
    }	  

    return $campos;
}	

function retornaCamposObrigatoriosOrcamento($idProjeto)
{
	$campos = [];

	$conexao = bancoMysqli();
	$query =  "SELECT 	             	             
  			     orca.idEtapa AS EtapaOrcamento, 
  			     orca.descricao AS 'descricaoOrcamento',
  			     orca.quantidade AS 'quantidadeOrcamento',
  			     orca.idUnidadeMedida AS 'UnidadeOrcamento',
  			     orca.quantidadeUnidade AS 'qtdUnidadeOrcamento',
  			     orca.valorUnitario AS 'valorUnitarioOrcamento'
			   FROM  
			     projeto as proj
			   INNER JOIN 
  			     orcamento AS orca 
  			   ON orca.idProjeto = proj.idProjeto  
  			   
  			   WHERE orca.publicado = 1  			   
  			   AND  proj.idProjeto =".$idProjeto;

	$resultado = mysqli_query($conexao,$query);		

	while($campo = mysqli_fetch_assoc($resultado)) 
    {
      array_push($campos, $campo);
    }	  

    return $campos;
}	

function retornaCamposObrigatoriosPf($idProjeto)
{
	$campos = [];

	$conexao = bancoMysqli();
	$query =  "SELECT 	             
	             pf.nome AS nomeProponente, 
	             pf.cpf AS cpfProponente, 
	             pf.rg AS rgProponente, 
	             pf.email AS emailProponente, 
	             pf.cep AS cepProponente,
	             pf.numero AS numeroProponente,	             
	             proj.idAreaAtuacao AS areaAtuacaoProjeto, 	             
	             proj.nomeProjeto AS nomeProjeto, 	             	             
	             proj.idRenunciaFiscal AS ValoresEnquadramentoRenunciaFiscal, 
	             proj.exposicaoMarca AS ValoresEnquadramentoExposicaoMarca, 	  
	             proj.resumoProjeto AS resumoCurriculoProjeto, 
	             proj.curriculo AS resumoCurriculoCvProponente, 	             
	             proj.descricao AS ObjetoDescricao,
	             proj.justificativa AS justificativaObjetoProjeto,
	             proj.objetivo AS justificativaObjetoMetas,
	             proj.metodologia AS MetodologiaContrapartida, 
	             proj.contrapartida AS MetodologiaContrapartidaDescricao,
	             loc_rea.local AS local, 
	             loc_rea.estimativaPublico AS estimativaLocal, 
	             loc_rea.idZona AS zonaLocal,  				 
	             proj.publicoAlvo AS publicoAlvo,
	             proj.planoDivulgacao as publicoAlvoDivulgacao,
	             ficha_t.nome AS nomeFichaTecnica, 
  				 ficha_t.cpf AS cpfFichaTecnica, 
  				 ficha_t.funcao AS funcaoFichaTecnica,  				
	             proj.inicioCronograma AS inicioConogramaProjeto, 
	             proj.fimCronograma AS fimConogramaProjeto,  
  				 crono.captacaoRecurso AS recursoConograma, 
  				 crono.preProducao AS preProducaoConograma, 
  				 crono.producao AS producaoConograma, 
  				 crono.posProducao AS posProducaoConograma, 
  				 crono.prestacaoContas AS ContasConograma,
  			     orca.idEtapa AS EtapaOrcamento, 
  			     orca.descricao AS 'descricaoOrcamento',
  			     orca.quantidade AS 'quantidadeOrcamento',
  			     orca.idUnidadeMedida AS 'UnidadeOrcamento',
  			     orca.quantidadeUnidade AS 'qtdUnidadeOrcamento',
  			     orca.valorUnitario AS 'valorUnitarioOrcamento'
			   FROM  
			     projeto as proj
			   INNER JOIN 
                 pessoa_fisica AS pf ON pf.idPf = proj.idPf
  			   
  			   INNER JOIN 
                  locais_realizacao AS loc_rea 
               ON loc_rea.idProjeto = proj.idProjeto
			   
			   INNER JOIN 
  			      ficha_tecnica AS ficha_t 
  			   ON ficha_t.idProjeto = proj.idProjeto
			   
			   INNER JOIN 
  			     cronograma AS crono 
  			   ON crono.idCronograma = proj.idCronograma
			   
			   INNER JOIN 
  			     orcamento AS orca 
  			   ON orca.idProjeto = proj.idProjeto 
  			   
  			   WHERE loc_rea.publicado = 1
  			   AND  ficha_t.publicado = 1
  			   AND  orca.publicado = 1
  			   AND  proj.idProjeto =".$idProjeto;

	$resultado = mysqli_query($conexao,$query);		

	while($campo = mysqli_fetch_assoc($resultado)) 
    {
      array_push($campos, $campo);
    }	  

    return $campos;
}	

function retornaCamposObrigatoriosRepresentate($idProjeto)
{
	$campos = [];

	$conexao = bancoMysqli();
	$query =  "SELECT 
	             rep_leg.nome AS nomeRepresentate, 
	             rep_leg.rg AS rgRepresentate, 
	             rep_leg.cpf AS cpfRepresentate, 
	             rep_leg.email AS emailRepresentate, 
	             rep_leg.cep AS cepRepresentate, 
	             rep_leg.numero AS numeroRepresentate	             
			   FROM  
			     projeto as proj
			   INNER JOIN 
                 pessoa_juridica AS pj ON pj.idPj = proj.idPj 
               
               INNER JOIN 
  			     representante_legal AS rep_leg 
  			   ON rep_leg.idRepresentanteLegal = pj.idRepresentanteLegal
  			   
  			   WHERE proj.idProjeto =".$idProjeto;   			   

	$resultado = mysqli_query($conexao,$query);		

	while($campo = mysqli_fetch_assoc($resultado)) 
    {
      array_push($campos, $campo);
    }	  

    return $campos;
}	

function retornaCamposObrigatoriosPj($idProjeto)
{
	$campos = [];

	$conexao = bancoMysqli();
	$query =  "SELECT 
	             pj.idRepresentanteLegal, 
	             pj.razaoSocial AS razaoSocialProponente, 
	             pj.email AS emailProponente, 
	             pj.cep AS cepProponente,
	             pj.numero AS numeroProponente,
	             rep_leg.nome AS nomeRepresentate, 
	             rep_leg.rg AS rgRepresentate, 
	             rep_leg.cpf AS cpfRepresentate, 
	             rep_leg.email AS emailRepresentate, 
	             rep_leg.cep AS cepRepresentate, 
	             rep_leg.numero AS numeroRepresentate,
	             proj.idAreaAtuacao AS areaAtuacaoProjeto, 
	             proj.contratoGestao AS contratoGestaoProjeto, 
	             proj.nomeProjeto AS nomeProjeto, 	             
	             proj.idRenunciaFiscal AS ValoresEnquadramentoRenunciaFiscal, 
	             proj.exposicaoMarca AS ValoresEnquadramentoExposicaoMarca,              
	             proj.resumoProjeto AS resumoCurriculoProjeto, 
	             proj.curriculo AS resumoCurriculoCvProponente, 	             
	             proj.descricao AS ObjetoDescricao,  
	             proj.justificativa AS justificativaObjetoProjeto, 
	             proj.objetivo AS justificativaObjetoMetas, 
	             proj.contrapartida AS MetodologiaContrapartida, 
	             proj.metodologia AS MetodologiaContrapartidaDescricao,	             
	             proj.publicoAlvo AS publicoAlvo,
	             proj.planoDivulgacao as publicoAlvoDivulgacao, 	             
	             proj.inicioCronograma AS inicioConogramaProjeto, 
	             proj.fimCronograma AS fimConogramaProjeto,  
	             loc_rea.local AS local, 
	             loc_rea.estimativaPublico AS estimativaLocal, 
	             loc_rea.idZona AS zonaLocal,  				 
  				 ficha_t.nome AS nomeFichaTecnica, 
  				 ficha_t.cpf AS cpfFichaTecnica, 
  				 ficha_t.funcao AS funcaoFichaTecnica,  				 
  				 crono.captacaoRecurso AS recursoConograma, 
  				 crono.preProducao AS preProducaoConograma, 
  				 crono.producao AS producaoConograma, 
  				 crono.posProducao AS posProducaoConograma, 
  				 crono.prestacaoContas AS ContasConograma,
  			     orca.idEtapa AS EtapaOrcamento, 
  			     orca.descricao AS 'descricaoOrcamento',
  			     orca.quantidade AS 'quantidadeOrcamento',
  			     orca.idUnidadeMedida AS 'UnidadeOrcamento',
  			     orca.quantidadeUnidade AS 'qtdUnidadeOrcamento',
  			     orca.valorUnitario AS 'valorUnitarioOrcamento'
			   FROM  
			     projeto as proj
			   INNER JOIN 
                 pessoa_juridica AS pj ON pj.idPj = proj.idPj 
               
               INNER JOIN 
  			     representante_legal AS rep_leg 
  			   ON rep_leg.idRepresentanteLegal = pj.idRepresentanteLegal
  			   
  			   INNER JOIN 
                  locais_realizacao AS loc_rea 
               ON loc_rea.idProjeto = proj.idProjeto
			   
			   INNER JOIN 
  			      ficha_tecnica AS ficha_t 
  			   ON ficha_t.idProjeto = proj.idProjeto
			   
			   INNER JOIN 
  			     cronograma AS crono 
  			   ON crono.idCronograma = proj.idCronograma
			   
			   INNER JOIN 
  			     orcamento AS orca 
  			   ON orca.idProjeto = proj.idProjeto  
  			   
  			   WHERE loc_rea.publicado = 1
  			   AND  ficha_t.publicado = 1
  			   AND  orca.publicado = 1
  			   AND  proj.idProjeto =".$idProjeto;

	$resultado = mysqli_query($conexao,$query);		

	while($campo = mysqli_fetch_assoc($resultado)) 
    {
      array_push($campos, $campo);
    }	  

    return $campos;
}	

function processaDados($fields)
{
  $erros = [];  

  foreach($fields as $campos):
    foreach($campos as $campo => $conteudo):
      if(is_string($campo)):                       
        validaConteudo($conteudo) ? array_push($erros, $campo) : '';
        if($campo == 'zonaLocal'):
          validaLocalZona($conteudo) ? array_push($erros, $campo) : '';	
        endif;	
      endif;
     endforeach;
   endforeach;	
  
   return $erros;
}

function validaConteudo($conteudo)
{
   $numeros = strlen(preg_replace("/[^0-9]/", "", $conteudo));
   $letras = strlen(preg_replace("/[^A-Za-z]/", "", $conteudo));
  
   return $numeros == $letras ? true : false;    
}

function validaLocalZona($conteudo)
{
  return $conteudo == 0 ? true : false;  
}

function retornaDocumentosObrigatoriosProponente($tipoPessoa)
{
  $documentos = [];
  $conexao = bancoMysqli();
  $query =  "SELECT 
               doc.idListaDocumento                         
             FROM 
               lista_documento AS doc  
  			  WHERE doc.idListaDocumento <> 27
  			  AND   doc.idListaDocumento <> 16
  			  AND   doc.idListaDocumento <> 17
  			  AND doc.idTipoUpload = ".$tipoPessoa;  			  

  $resultado = mysqli_query($conexao,$query);
  
  while($documento = mysqli_fetch_assoc($resultado)) 
  {
    array_push($documentos, $documento);
  }	  

  return $documentos;
}

/*Função que retornar os documentos obrigatórios do projeto
  está inativa, caso o cliente deseje mudar a regra de negócio*/
function retornaArquivosObrigatorios($tipoPessoa)
{
  $documentos = [];
  /*$conexao = bancoMysqli();
  $query =  "SELECT 
               doc.idListaDocumento                         
             FROM 
               lista_documento AS doc  
  			  WHERE doc.idListaDocumento <> 20  	  			  
  			  AND doc.idTipoUpload = 3";

  $resultado = mysqli_query($conexao,$query);
  
  while($documento = mysqli_fetch_assoc($resultado)) 
  {
    array_push($documentos, $documento);
  }*/	  

  return $documentos;
}


function retornaArquivosCarregados($idUser)
{
  $documentos = [];
  $conexao = bancoMysqli();
  $query =  "SELECT 	             
  			   up_arq.idListaDocumento 
			 FROM  
			   projeto as proj			 
  			 INNER JOIN 
               upload_arquivo AS up_arq 
             ON up_arq.idPessoa = '$idUser'
  			 WHERE up_arq.publicado = 1";

  $resultado = mysqli_query($conexao,$query);
	
  if(!empty($resultado)):
    while($documento = mysqli_fetch_assoc($resultado)) 
    {
      array_push($documentos, $documento);
    }  
  endif;  
  
  return $documentos;
}

function retornaAnexosCarregados($idProjeto)
{
  $documentos = [];
  
  $conexao = bancoMysqli();
  $query =  "SELECT 	             
  			   up_arq.idListaDocumento 
			 FROM  			     			 
               upload_arquivo AS up_arq              
  			 WHERE up_arq.idPessoa =".$idProjeto;

  $resultado = mysqli_query($conexao,$query);
	
  if(!empty($resultado)):
    while($documento = mysqli_fetch_assoc($resultado)) 
    {
      array_push($documentos, $documento);
    }  
  endif;  
  
  return $documentos;
}

function formataDados($arrayArquivos)
{
  $tipoDoc = [];

  foreach($arrayArquivos as $key => $conteudo):
    foreach($conteudo as $tipo):
     array_push($tipoDoc, $tipo);
    endforeach;	
  endforeach;

  return $tipoDoc;
}	

function analiseArquivos($arqObrigatorio, $arqEnviado)
{
  $idDocDiferentes = array_diff($arqObrigatorio, $arqEnviado);

  return pegaIdDocumento($idDocDiferentes);
}

function pegaIdDocumento($idDocDiferentes)
{
  $documentos = [];

  foreach($idDocDiferentes as $key => $conteudo):
    array_push($documentos, retornaArquivosDivergentes($conteudo));
  endforeach;		

  return $documentos;
 
}

function retornaArquivosDivergentes($idListaDocumento)
{
  $documentos = [];
  $conexao = bancoMysqli();
  $query =  "SELECT 
               doc.documento
             FROM 
               lista_documento AS doc  
  			  WHERE doc.idListaDocumento = ".$idListaDocumento;		

  $resultado = mysqli_query($conexao,$query);
  $documentos = mysqli_fetch_array($resultado);

  return $documentos;
}

function arquivosExiste($urlArquivo, $extensao = '.php')
{
  $file = $urlArquivo.$extensao;
  $file_headers = @get_headers($file);
  if($file_headers[0] == 'HTTP/1.1 404 Not Found'):
    return false;
  endif;
  
  return true;
}

function selecionaArquivoAnexo($http, $idListaDocumento, $extensao = '.php')
{
   $path = $http.$idListaDocumento.$extensao;   
   return $path;
}

function retornaQtdProjetos($tipoPessoa, $id)
{
  $conexao = bancoMysqli();

  if($tipoPessoa == 1):    
    $query =  "SELECT 
               count(idProjeto)
             FROM 
               projeto AS proj  
  			  WHERE proj.publicado = 1
  			  AND   proj.idPf = ".$id;
    
    elseif ($tipoPessoa == 2):
  	  
  	  $query =  "SELECT 
               count(idProjeto)
             FROM 
               projeto AS proj  
             INNER JOIN 
               pessoa_juridica AS pj 
             ON pj.idPj = proj.idPj  
  			 
  			 WHERE proj.publicado = 1
  			 AND   pj.cooperativa = 0
  			 AND   proj.idPj = ".$id;
    
  endif;	


  $resultado = mysqli_query($conexao,$query);
  $qtdProjeto = mysqli_fetch_array($resultado);
  
  return $qtdProjeto;
}

function retornaProjeto($tipoPessoa, $id)
{
  $documentos = [];
  $conexao = bancoMysqli();
  
  if($tipoPessoa == 1):    
    $query =  "SELECT 
               nomeProjeto
             FROM 
               projeto AS proj  
  			  WHERE proj.publicado = 1
  			  AND   proj.idPf = ".$id;
  	
  	$resultado = mysqli_query($conexao,$query);
    $projeto = mysqli_fetch_array($resultado);

    return $projeto;
		  	
  else:
  	$query =  "SELECT 
               nomeProjeto
             FROM 
               projeto AS proj  
  			  WHERE proj.publicado = 1
  			  AND   proj.idPj = ".$id;	

    $resultado = mysqli_query($conexao,$query);

    if(!empty($resultado)):
      while($documento = mysqli_fetch_assoc($resultado)) 
      {
        array_push($documentos, $documento);
      }  
      return $documentos;  			  
    endif;  
  endif;   
}

function retornaEndereco($cep){  
  
  $enderecos = [];
  $conexao = bancoMysqliCep();
    
  $resultado = mysqli_query($conexao, 
     "CALL  pr_busca_cep('$cep');"); 

  if(!empty($resultado)):
    while($endereco = mysqli_fetch_assoc($resultado)) 
    {
      array_push($enderecos, $endereco);
    }  
    return $enderecos;  			  
  endif;  
  
  return $enderecos;  
}

function retornaUf($cep){    
  
  $conexao = bancoMysqliCep();
    
  $resultado = mysqli_query($conexao, 
     "CALL  pr_busca_uf('$cep');"); 

  $uf = mysqli_fetch_array($resultado);  
  
  return array_unique($uf);  			  
}

function configuraEndereco($addresses)
{
  $enderecos = [];

  if(!empty($addresses)):
    $enderecos = [
       'logradouro' => $addresses[0]['tp_logradouro']." ".$addresses[0]['logradouro'],
       'cidade' => $addresses[0]['cidade'],
       'bairro' => $addresses[0]['bairro'],
       'cep' => $addresses[0]['cep']
      ]; 
   return $enderecos;
  endif;   

  return $enderecos;
  
}

function listaEstados()
{
  $estados = [];  
  $conexao = bancoMysqliCep();

  $query =  "SELECT 
               uf
             FROM 
               estado order by uf";

  $resultado = mysqli_query($conexao,$query);
    
  while($estado = mysqli_fetch_assoc($resultado)) 
  {
    array_push($estados, $estado);
  }  
  return $estados;  			    
}

function listaCidades()
{
  $cidades = [];  
  $conexao = bancoMysqliCep();

  $query =  "SELECT 
               nome
             FROM 
               cidade order by nome";

  $resultado = mysqli_query($conexao,$query);
    
  while($cidade = mysqli_fetch_assoc($resultado)) 
  {
    array_push($cidades, $cidade);
  }  
  return $cidades;  			    
}

function validaData($dtInicio, $dtFim)
{
  return $dtFim >= $dtInicio ? true : false;      
}

function cleanerWeblog()
{
  $logs = [];  
  $conexao = bancoMysqli();  

  $query =  "SELECT 
               log.idWebLog, 
               log.antes,
               log.depois
             FROM 
               weblogs AS log             
             WHERE log.antes = log.depois";

  $resultado = mysqli_query($conexao,$query);

  if($resultado):
    while($log = mysqli_fetch_assoc($resultado)):
      array_push($logs, $log);
    endwhile;     
  endif;  

  return $logs;  
}

function geraHeaderWebLog()
{
  $logs = [];  
  $conexao = bancoMysqli();  

  $query =  "SELECT 
               log.idWebLog, 
               log.tabela, 
               log.acao, 
               log.IdRegistro,
               log.dataOcorrencia, 
               log.usuario,
               pf.nome 
             FROM 
               weblogs AS log
             INNER JOIN pessoa_fisica AS pf
             ON pf.idPf =  log.idRegistro
             WHERE dataOcorrencia >= DATE_ADD(curdate(), interval -15 day)
             AND   dataOcorrencia <= NOW()";             

  $resultado = mysqli_query($conexao,$query);

  while($log = mysqli_fetch_assoc($resultado)):
    array_push($logs, $log);
  endwhile;  
  
  return $logs;  
}

function geraHeaderWebLogParam($dtInicio, $dtFim, $tabela, $nome) 
{
  $logs = [];  
  $conexao = bancoMysqli();  

  $query =  "SELECT 
               log.idWebLog, 
               log.tabela, 
               log.acao, 
               log.IdRegistro,
               log.dataOcorrencia, 
               log.usuario,
               pf.nome 
             FROM 
               weblogs AS log
             INNER JOIN pessoa_fisica AS pf
             ON pf.idPf =  log.idRegistro
             WHERE log.dataOcorrencia >= '$dtInicio'
             AND   log.dataOcorrencia <= '$dtFim'
             AND   log.tabela = '$tabela' 
             AND   pf.nome LIKE '%$nome%'";             

  $resultado = mysqli_query($conexao,$query);  

  if($resultado):
    while($log = mysqli_fetch_assoc($resultado)):
      array_push($logs, $log);
    endwhile;    
    
    return $logs;  
  endif;  
}

function geraHeaderWebLogTodos($dtInicio, $dtFim) 
{
  $logs = [];  
  $conexao = bancoMysqli();  

  $query =  "SELECT 
               log.idWebLog, 
               log.tabela, 
               log.acao, 
               log.IdRegistro,
               log.dataOcorrencia, 
               log.usuario,
               pf.nome 
             FROM 
               weblogs AS log
             INNER JOIN pessoa_fisica AS pf
             ON pf.idPf =  log.idRegistro
             WHERE log.dataOcorrencia >= '$dtInicio'
             AND   log.dataOcorrencia <= '$dtFim'";             

  $resultado = mysqli_query($conexao,$query);  

  if($resultado):
    while($log = mysqli_fetch_assoc($resultado)):
      array_push($logs, $log);
    endwhile;    
    
    return $logs;  
  endif;  
}

function geraWebLogDetalhes($idWeblog)
{
  $logs = [];  
  $conexao = bancoMysqli();  

  $query =  "SELECT 
               antes, 
               depois
             FROM 
               weblogs 
             WHERE idWebLog = ".$idWeblog;             

  $resultado = mysqli_query($conexao,$query);
    
  while($log = mysqli_fetch_assoc($resultado)) 
  {
    array_push($logs, $log);
  }  
  return $logs;  			    	
}

function retornaDados($logs, $tipo)
{
  foreach($logs as $log):
    $array = explode('|', $log[$tipo]);        
  endforeach;   

  return $array;
}  

function limpaRegistrosSemAlteracoes($idLog)
{
  $conexao = bancoMysqli();  

  $query = "DELETE FROM weblogs WHERE idWebLog = {$idLog}";
  return mysqli_query($conexao, $query);    
}

function buscaRegistrosSemAlteracoes($logs)
{
  foreach($logs as $log):          
    $ids = geraWebLogDetalhes($log['idWebLog']); 
    $old = retornaDados($ids, 'antes');
    $new = retornaDados($ids, 'depois');
    $numLinhas = array_diff($old, $new);  

    sizeof($numLinhas) == 0 
        ? limpaRegistrosSemAlteracoes($log['idWebLog'])
        : '';     
  endforeach;
}

function limpaRegistrosNulos()
{
  $logs = [];  
  $conexao = bancoMysqli();  

  $query =  "SELECT 
               idWeblog               
             FROM 
               weblogs
             WHERE antes is null
             OR    depois is null";

  $resultado = mysqli_query($conexao,$query);
    
  while($log = mysqli_fetch_assoc($resultado)) 
  {
    array_push($logs, $log);    
  }  

  if($resultado):
    foreach($logs as $log):
      foreach($log as $idWeblog):
        limpaRegistrosSemAlteracoes($idWeblog);  	
      endforeach;	
    endforeach; 	
  endif;	  
}

function getLogs($logs)
{  
  return geraHeaderWebLog();
}

?>