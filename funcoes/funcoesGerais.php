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
    $query = mysqli_query($con, $sql);
    //query que seleciona os campos que voltarão para na matriz
    if ($query) {
        //verifica erro no banco de dados
        if (mysqli_num_rows($query) > 0) {
            // verifica se retorna usuário válido
            $user = mysqli_fetch_array($query);
            if ($user['senha'] == md5($_POST['senha'])) {
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
                while ($row = mysqli_fetch_array($envio)) {
                    $nAcesso = $row['idNivelAcesso'];
                }
                if ($nAcesso == 1)
                    header("Location: visual/index_pf.php");
                else if ($nAcesso == 2) {
                    header("Location: visual/index_pf.php?perfil=smc_index");
                    $_SESSION['tipoUsuario'] = 2;
                } else if ($nAcesso == 3 OR $nAcesso == 4)
                    header("Location:  visual/index_pf.php?perfil=comissao_index");
            } else {
                return "<font color='#FF0000'><strong>A senha está incorreta!</strong></font>";
            }
        } else {
            return "<font color='#FF0000'><strong>O usuário não existe.</strong></font>";
        }
    } else {
        return "<font color='#FF0000'><strong>Erro no banco de dados!</strong></font>";
    }
}

function autenticaloginpj($login, $senha)
{
    $sql = "SELECT * FROM pessoa_juridica AS pj
	WHERE pj.cnpj = '$login' LIMIT 0,1";
    $con = bancoMysqli();
    $query = mysqli_query($con, $sql);
    //query que seleciona os campos que voltarão para na matriz
    if ($query) {
        //verifica erro no banco de dados
        if (mysqli_num_rows($query) > 0) {
            // verifica se retorna usuário válido
            $user = mysqli_fetch_array($query);
            if ($user['senha'] == md5($_POST['senha'])) {
                // compara as senhas
                session_start();
                $_SESSION['login'] = $user['cnpj'];
                $_SESSION['nome'] = $user['razaoSocial'];
                $_SESSION['idUser'] = $user['idPj'];
                $_SESSION['tipoPessoa'] = "2";
                $log = "Fez login.";
                header("Location: visual/index_pj.php");
            } else {
                return "<font color='#FF0000'><strong>A senha está incorreta!</strong></font>";
            }
        } else {
            return "<font color='#FF0000'><strong>O usuário não existe.</strong></font>";
        }
    } else {
        return "<font color='#FF0000'><strong>Erro no banco de dados!</strong></font>";
    }
}

function autenticaloginincentivadorpf($login, $senha)
{
    $sql = "SELECT * FROM incentivador_pessoa_fisica AS pf
	WHERE pf.cpf = '$login' LIMIT 0,1";
    $con = bancoMysqli();
    $query = mysqli_query($con, $sql);
    //query que seleciona os campos que voltarão para na matriz
    if ($query) {
        //verifica erro no banco de dados
        if (mysqli_num_rows($query) > 0) {
            // verifica se retorna usuário válido
            $user = mysqli_fetch_array($query);
            if ($user['senha'] == md5($_POST['senha'])) {
                // compara as senhas
                session_start();
                $_SESSION['login'] = $user['cpf'];
                $_SESSION['nome'] = $user['nome'];
                $_SESSION['idUser'] = $user['idPf'];
                $_SESSION['tipoPessoa'] = "1";
                $log = "Fez login.";
                $cpf = $user['cpf'];
                header("Location: visual/incentivador_index_pf.php");
            } else {
                return "<font color='#FF0000'><strong>A senha está incorreta!</strong></font>";
            }
        } else {
            return "<font color='#FF0000'><strong>O usuário não existe.</strong></font>";
        }
    } else {
        return "<font color='#FF0000'><strong>Erro no banco de dados!</strong></font>";
    }
}

function autenticaloginincentivadorpj($login, $senha)
{
    $sql = "SELECT * FROM incentivador_pessoa_juridica AS pj
	WHERE pj.cnpj = '$login' LIMIT 0,1";
    $con = bancoMysqli();
    $query = mysqli_query($con, $sql);
    //query que seleciona os campos que voltarão para na matriz
    if ($query) {
        //verifica erro no banco de dados
        if (mysqli_num_rows($query) > 0) {
            // verifica se retorna usuário válido
            $user = mysqli_fetch_array($query);
            if ($user['senha'] == md5($_POST['senha'])) {
                // compara as senhas
                session_start();
                $_SESSION['login'] = $user['cnpj'];
                $_SESSION['nome'] = $user['razaoSocial'];
                $_SESSION['idUser'] = $user['idPj'];
                $_SESSION['tipoPessoa'] = "2";
                $log = "Fez login.";
                header("Location: visual/incentivador_index_pj.php");
            } else {
                return "<font color='#FF0000'><strong>A senha está incorreta!</strong></font>";
            }
        } else {
            return "<font color='#FF0000'><strong>O usuário não existe.</strong></font>";
        }
    } else {
        return "<font color='#FF0000'><strong>Erro no banco de dados!</strong></font>";
    }
}

//saudacao inicial
function saudacao()
{
    $hora = date('H');
    if (($hora > 12) AND ($hora <= 18)) {
        return "Boa tarde";
    } else if (($hora > 18) AND ($hora <= 23)) {
        return "Boa noite";
    } else if (($hora >= 0) AND ($hora <= 4)) {
        return "Boa noite";
    } else if (($hora > 4) AND ($hora <= 12)) {
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
    if ($data == '0000-00-00' || $data == NULL) {
        return "00-00-0000";
    } else {
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
    if ($data == '0000-00-00 00:00:00' || $data == NULL) {
        return "0000-00-00 00:00:00";
    } else {
        $timestamp = strtotime($data);
        return date('d/m/y - H:i:s', $timestamp);
    }
}

function returnEmptyDateCronograma($VCAM, $idProjeto)
{
    $con = bancoMysqli();
    $sql = "SELECT " . $VCAM . " FROM projeto WHERE idProjeto = '" . $idProjeto . "' LIMIT 0,1";
    $query = mysqli_query($con, $sql);
    $rnow = mysqli_num_rows($query);
    while ($campo = mysqli_fetch_array($query)) {
        return $campo[$VCAM];
    }
}

function returnEmptyDate($VCAM, $idProjeto)
{
    $con = bancoMysqli();
    $sql = "SELECT " . $VCAM . " FROM prazos_projeto WHERE idProjeto = '" . $idProjeto . "' LIMIT 0,1";
    $query = mysqli_query($con, $sql);
    $rnow = mysqli_num_rows($query);
    while ($campo = mysqli_fetch_array($query)) {
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
    list ($dia, $mes, $ano) = explode('/', $data);
    $data_mysql = $ano . '-' . $mes . '-' . $dia;
    return $data_mysql;
}

//retorna o endereço da página atual
function urlAtual()
{
    $dominio = $_SERVER['HTTP_HOST'];
    $url = "http://" . $dominio . $_SERVER['REQUEST_URI'];
    return $url;
}

//retorna valor xxx,xx para xxx.xx
function dinheiroDeBr($valor)
{
    $valor = str_ireplace(".", "", $valor);
    $valor = str_ireplace(",", ".", $valor);
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
    while (mb_detect_encoding($tmp) == "UTF-8") {
        $tmp = utf8_decode($tmp);
        $count++;
    }
    for ($i = 0; $i < $count - 1; $i++) {
        $string = utf8_decode($string);
    }
    return $string;
}

//retorna o dia da semana segundo um date(a-m-d)
function diasemana($data)
{
    $ano = substr("$data", 0, 4);
    $mes = substr("$data", 5, -3);
    $dia = substr("$data", 8, 9);
    $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
    switch ($diasemana) {
        case"0":
            $diasemana = "Domingo";
            break;
        case"1":
            $diasemana = "Segunda-Feira";
            break;
        case"2":
            $diasemana = "Terça-Feira";
            break;
        case"3":
            $diasemana = "Quarta-Feira";
            break;
        case"4":
            $diasemana = "Quinta-Feira";
            break;
        case"5":
            $diasemana = "Sexta-Feira";
            break;
        case"6":
            $diasemana = "Sábado";
            break;
    }
    return "$diasemana";
}

//soma(+) ou substrai(-) dias de um date(a-m-d)
function somarDatas($data, $dias)
{
    $data_final = date('Y-m-d', strtotime("$dias days", strtotime($data)));
    return $data_final;
}

//retorna a diferença de dias entre duas datas
function diferencaDatas($data_inicial, $data_final)
{
    // Define os valores a serem usados
    // Usa a função strtotime() e pega o timestamp das duas datas:
    $time_inicial = strtotime($data_inicial);
    $time_final = strtotime($data_final);
    // Calcula a diferença de segundos entre as duas datas:
    $diferenca = $time_final - $time_inicial; // 19522800 segundos
    // Calcula a diferença de dias
    $dias = (int)floor($diferenca / (60 * 60 * 24)); // 225 dias
    return $dias;
}

/**
 * Função grava o IP e ID do usuário junto a query
 * de inserção ou atualização na tabela "log"
 * @param string $log <p>
 * query de INSERT ou UPDATE
 * </p>
 */
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

function geraOpcao($tabela, $select, $publicado = false)
{
    if ($publicado) {
        $publicado = "WHERE publicado = '1'";
    } else {
        $publicado = "";
    }
    //gera os options de um select
    $sql = "SELECT * FROM $tabela $publicado ORDER BY 2";

    $con = bancoMysqli();
    $query = mysqli_query($con, $sql);
    while ($option = mysqli_fetch_row($query)) {
        if ($option[0] == $select) {
            echo "<option value='" . $option[0] . "' selected >" . $option[1] . "</option>";
        } else {
            echo "<option value='" . $option[0] . "'>" . $option[1] . "</option>";
        }
    }
}

function geraAreaAtuacao($tabela, $tipo, $select)
{
    //gera os options de um select
//    $sql = "SELECT * FROM $tabela WHERE tipo IN ($tipo) ORDER BY 2";
    $sql = "SELECT * FROM $tabela ORDER BY 2";
    $con = bancoMysqli();
    $query = mysqli_query($con, $sql);
    while ($option = mysqli_fetch_row($query)) {
        if ($option[0] == $select) {
            echo "<option value='" . $option[0] . "' selected >" . $option[1] . "</option>";
        } else {
            echo "<option value='" . $option[0] . "'>" . $option[1] . "</option>";
        }
    }
}

function geraUsuarioComissao($select = "")
{
    //gera os options de um select
    $sql = "SELECT * FROM `pessoa_fisica` WHERE `idNivelAcesso` IN (3,4)";

    $con = bancoMysqli();
    $query = mysqli_query($con, $sql);
    while ($option = mysqli_fetch_row($query)) {
        if ($option[0] == $select) {
            echo "<option value='" . $option[0] . "' selected >" . $option[1] . "</option>";
        } else {
            echo "<option value='" . $option[0] . "'>" . $option[1] . "</option>";
        }
    }
}

function geraCombobox($tabela, $campo, $order, $select)
{
    //gera os options de um select
    $sql = "SELECT * FROM $tabela ORDER BY $order";

    $con = bancoMysqli();
    $query = mysqli_query($con, $sql);
    while ($option = mysqli_fetch_row($query)) {
        if ($option[0] == $select) {
            echo "<option value='" . $option[0] . "' selected >" . $option[$campo] . "</option>";
        } else {
            echo "<option value='" . $option[0] . "'>" . $option[$campo] . "</option>";
        }
    }
}

function recuperaModulo($pag)
{
    $sql = "SELECT * FROM modulo WHERE pagina = '$pag'";
    $con = bancoMysqli();
    $query = mysqli_query($con, $sql);
    $modulo = mysqli_fetch_array($query);
    return $modulo;
}

function recuperaUsuarioCompleto($id)
{
    //retorna dados do usuário
    $recupera = recuperaDados('usuario_pf', 'id', $id);
    if ($recupera) {
        $x = array(
            "nome" => $recupera['nome'],
            "email" => $recupera['email'],
            "login" => $recupera['login'],
            "telefone1" => $recupera['telefone1'],
            "telefone2" => $recupera['telefone2']);
        return $x;
    } else {
        return NULL;
    }
}

/**
 * Esta função retorna um unico registro da tabela passada utilizando
 * como parametro para a clausula "WHERE", o campo passado.
 * @param string $tabela <p>
 * Tabela do banco de dados a ser Consultada
 * </p>
 * @param string $campo <p>
 * Coluna a ser utilizada como parametro "WHERE"
 * </p>
 * @param string|int $variavelCampo <p>
 * Variavel que deve ser comparada no banco de dados
 * </p>
 * @return array|null <p>
 * Retorna um unico registro da tabela consultada
 */
function recuperaDados($tabela, $campo, $variavelCampo)
{
    //retorna uma array com os dados de qualquer tabela. serve apenas para 1 registro.
    $con = bancoMysqli();
    $sql = "SELECT * FROM $tabela WHERE " . $campo . " = '$variavelCampo' LIMIT 0,1";
    $query = mysqli_query($con, $sql);
    $campo = mysqli_fetch_array($query);
    return $campo;
}

function recuperaDadosProjeto($tabela, $campo, $variavelCampo)
{
    //retorna uma array com os dados de qualquer tabela. serve apenas para 1 registro.
    $con = bancoMysqli();
    $sql = "SELECT * FROM $tabela WHERE " . $campo . " = '$variavelCampo' ORDER BY 'idProjeto' DESC LIMIT 0,1";
    $query = mysqli_query($con, $sql);
    $campo = mysqli_fetch_array($query);
    return $campo;
}

function recuperaStatus()
{
    $con = bancoMysqli();
    $dateNow = date('Y-m-d');
    $sql = "SELECT situacaoAtual, data FROM liberacao_projeto WHERE idStatus = '1'";
    $query = mysqli_query($con, $sql);
    $campo = mysqli_fetch_array($query);
    if ($campo['situacaoAtual'] == 1) {
        if ($campo['data'] <= $dateNow) {
            return "1";
        } else {
            return "2";
        }
    } else {
        if ($campo['data'] <= $dateNow) {
            return "2";
        } else {
            return "1";
        }
    }
}

function recuperaDataPublicacao($idProjeto)
{
    $con = bancoMysqli();
    $consultaProjeto = $con->query("SELECT dataPublicacaoDoc FROM projeto WHERE idProjeto = '$idProjeto'")->fetch_assoc()['dataPublicacaoDoc'];

    if ($consultaProjeto == "0000-00-00") {
        $query = "SELECT list.documento,
                   list.idListaDocumento,
                   arq.arquivo,
                   arq.idUploadArquivo AS idArquivo,
                   disp.idUploadArquivo,
                   disp.id AS 'disponibilizar',
                   arq.idStatusDocumento,
                   arq.observacoes,
                   disp.data AS dataDisponivel
                  FROM lista_documento as list
                  INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
                  LEFT JOIN disponibilizar_documento AS disp ON arq.idUploadArquivo = disp.idUploadArquivo
                  WHERE arq.idPessoa = '$idProjeto'
                    AND arq.idTipo = '9'
                    AND (list.idListaDocumento = '37' OR list.idListaDocumento = '49')
                    AND arq.publicado = '1' ORDER BY arq.idUploadArquivo DESC LIMIT 0,1";
        $dataPublicacao = $con->query($query)->fetch_assoc()['dataDisponivel'];
    } else {
        $dataPublicacao = $consultaProjeto;
    }

    return $dataPublicacao;
}

function verificaExiste($idTabela, $idCampo, $idDado, $st)
{
    //retorna uma array com indice 'numero' de registros e 'dados' da tabela
    $con = bancoMysqli();
    if ($st == 1) {
        // se for 1, é uma string
        $sql = "SELECT * FROM $idTabela WHERE $idCampo = '%$idDado%'";
    } else {
        $sql = "SELECT * FROM $idTabela WHERE $idCampo = '$idDado'";
    }
    $query = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($query);
    $dados = mysqli_fetch_array($query);
    $campo['numero'] = $numero;
    $campo['dados'] = $dados;
    return $campo;
}

function recuperaIdDado($tabela, $id)
{
    $con = bancoMysqli();
    //recupera os nomes dos campos
    $sql = "SELECT * FROM $tabela";
    $query = mysqli_query($con, $sql);
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
    if ($id == 1) {
        echo "checked";
    }
}

function valorPorExtenso($valor = 0)
{
    //retorna um valor por extenso
    $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
    $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
    $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
    $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
    $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove");
    $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
    $z = 0;
    $valor = number_format($valor, 2, ".", ".");
    $inteiro = explode(".", $valor);
    for ($i = 0; $i < count($inteiro); $i++)
        for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
            $inteiro[$i] = "0" . $inteiro[$i];
    $rt = "";
    // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
    $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
    for ($i = 0; $i < count($inteiro); $i++) {
        $valor = $inteiro[$i];
        $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
        $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
        $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";
        $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
        $t = count($inteiro) - 1 - $i;
        $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
        if ($valor == "000") $z++; elseif ($z > 0) $z--;
        if (($t == 1) && ($z > 0) && ($inteiro[0] > 0)) $r .= (($z > 1) ? " de " : "") . $plural[$t];
        if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
    }
    return ($rt ? $rt : "zero");
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
    $query = mysqli_query($con, $sql);
    $campo = mysqli_fetch_array($query);
    return $campo[0];
}

function recuperaUltimoDoUsuario($tabela, $idUser)
{
    $con = bancoMysqli();
    $sql = "SELECT * FROM $tabela WHERE idUsuario = $idUser ORDER BY 1 DESC LIMIT 0,1";
    $query = mysqli_query($con, $sql);
    $campo = mysqli_fetch_array($query);
    return $campo[0];
}

function retornaMes($mes)
{
    switch ($mes) {
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
    $meses = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
    $data = explode("-", $data);
    $mes = $data[1];
    return $meses[($mes) - 1];
}

//retorna o dia da semana segundo um date(a-m-d)
function diaSemanaBase($data)
{
    $ano = substr("$data", 0, 4);
    $mes = substr("$data", 5, -3);
    $dia = substr("$data", 8, 9);
    $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
    switch ($diasemana) {
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
    $query01 = mysqli_query($con, $sql01);
    $campo01 = mysqli_fetch_array($query01);
    $uf = "igsis_cep_" . $campo01['uf'];
    $sql02 = "SELECT * FROM $uf WHERE cep = '$cep'";
    $query02 = mysqli_query($con, $sql02);
    $campo02 = mysqli_fetch_array($query02);
    $res = mysqli_num_rows($query02);
    if ($res > 0) {
        $dados['sucesso'] = 1;
    } else {
        $dados['sucesso'] = 0;
    }
    $dados['rua'] = $campo02['tp_logradouro'] . " " . $campo02['logradouro'];
    $dados['bairro'] = $campo02['bairro'];
    $dados['cidade'] = $campo02['cidade'];
    $dados['estado'] = strtoupper($campo01['uf']);
    return $dados;
}

function verificaArquivosExistentes($idPessoa, $idDocumento)
{
    $con = bancoMysqli();
    $verificacaoArquivo = "SELECT arquivo FROM upload_arquivo WHERE idPessoa = '$idPessoa' AND idUploadListaDocumento = '$idDocumento'";
    $envio = mysqli_query($con, $verificacaoArquivo);

    if (mysqli_num_rows($envio) > 0) {
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
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
        echo "
			<table class='table table-condensed'>
			<thead>
			<tr class='list_menu'>
			<td>Tipo de arquivo</td>
			<td width='15%'></td>
			</tr>
			</thead>
			<tbody>";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['documento'], 15, 25, "...") . "</a></td>";
            echo "
				<td class='list_description'>
				<form id='apagarArq' method='POST' action='?perfil=projeto_3'>
				<input type='hidden' name='idPessoa' value='" . $idPessoa . "' />
				<input type='hidden' name='tipoPessoa' value='2' />
				<input type='hidden' name='apagar' value='" . $arquivo['idUploadArquivo'] . "' />
				<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Remover Arquivo?' data-message='Deseja realmente excluir o arquivo " . $arquivo['documento'] . "?'>Remover
															</button></td>
				</form>";
            echo "</tr>";
        }
        echo "
			</tbody>
			</table>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}

function listaArquivosPessoa($idPessoa, $tipoPessoa, $pagina)
{
    $con = bancoMysqli();
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
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
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>(" . $arquivo['documento'] . ")</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>";
            echo "
						<td class='list_description'>
							<form id='apagarArq' method='POST' action='?perfil=" . $pagina . "'>
								<input type='hidden' name='idPessoa' value='" . $idPessoa . "' />
								<input type='hidden' name='tipoPessoa' value='" . $tipoPessoa . "' />
								<input type='hidden' name='apagar' value='" . $arquivo['idUploadArquivo'] . "' />
								<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Remover Arquivo?' data-message='Deseja realmente excluir o arquivo " . $arquivo['documento'] . "?'>Remover
								</button></td>
							</form>";
            echo "</tr>";
        }
        echo "
		</tbody>
		</table>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}

function listaArquivosAnalise($tipoPessoa, $pagina)
{
    $con = bancoMysqli();
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1' ORDER BY arq.idUploadArquivo";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
        echo "
		<table class='table table-condensed text-center'>
			<thead>
				<tr class='list_menu'>
					<td>Data</td>
				</tr>
			</thead>
			<tbody>";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'><a href='uploadssmc/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['dataEnvio'], 0, 25, "...") . "</a></td>";
            echo "</tr>";
        }
        echo "
		</tbody>
		</table>";
    } else {
        echo "<p>Não há listas disponíveis no momento.<p/><br/>";
    }
}

function listaArquivosSMC($tipoPessoa, $pagina)
{
    $con = bancoMysqli();
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1' ORDER BY arq.idUploadArquivo";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
        echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Nome do arquivo</td>
					<td>Data</td>
					<td width='15%'></td>
				</tr>
			</thead>
			<tbody>";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'><a href='uploadssmc/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>";
            echo "<td class='list_description'>(" . exibirDataHoraBr($arquivo['dataEnvio']) . ")</td>";
            echo "
                  <td class='list_description'>
							<form id='apagarArq' method='POST' action='?perfil=" . $pagina . "'>
								<input type='hidden' name='tipoPessoa' value='" . $tipoPessoa . "' />
								<input type='hidden' name='apagar' value='" . $arquivo['idUploadArquivo'] . "' />
								<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Remover Arquivo?' data-message='Deseja realmente excluir o arquivo " . $arquivo['arquivo'] . "?'>Remover
								</button></td>
							</form>";
            echo "</tr>";
        }
        echo "
		</tbody>
		</table>";
    } else {
        echo "<p>Não há listas disponíveis no momento.<p/><br/>";
    }
}


function listaParecer($idPessoa, $tipoPessoa, $pagina)
{
    $con = bancoMysqli();
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1' AND list.idListaDocumento = '37'";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
        echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Nome do arquivo</td>
					<td>Status</td>
					<td>Observações</td>
				</tr>
			</thead>
			<tbody>";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>(" . $arquivo['documento'] . ")</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>";
            $sql = "SELECT * FROM `status_documento` WHERE idStatusDocumento = '" . $arquivo['idStatusDocumento'] . "'";
            $consulta = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($consulta);
            echo "<td class='list_description'>" . $row['status'] . "</td>";
            echo "<td class='list_description'>" . $arquivo['observacoes'] . "</td>";
            if ($row['idStatusDocumento'] == 2 || $row['idStatusDocumento'] == 3) {
                echo "
						<td class='list_description'>
							<form id='apagarArq' method='POST' action='?perfil=" . $pagina . "'>
								<input type='hidden' name='idPessoa' value='" . $idPessoa . "' />
								<input type='hidden' name='tipoPessoa' value='" . $tipoPessoa . "' />
								<input type='hidden' name='apagar' value='" . $arquivo['idUploadArquivo'] . "' />
						</td>
							</form>";
            }
            echo "</tr>";
        }
        echo "
		</tbody>
		</table>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).</p><br/>";
    }
}

function listaAlteracaoParecer($idPessoa, $tipoPessoa, $pagina)
{
    $con = bancoMysqli();
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1' AND list.idListaDocumento = '48'";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
        echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Nome do arquivo</td>
					<td>Status</td>
					<td>Observações</td>
					<td width='15%'></td>
				</tr>
			</thead>
			<tbody>";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>(" . $arquivo['documento'] . ")</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>";
            $sql = "SELECT * FROM `status_documento` WHERE idStatusDocumento = '" . $arquivo['idStatusDocumento'] . "'";
            $consulta = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($consulta);
            echo "<td class='list_description'>" . $row['status'] . "</td>";
            echo "<td class='list_description'>" . $arquivo['observacoes'] . "</td>";
            if ($row['idStatusDocumento'] == 2 || $row['idStatusDocumento'] == 3) {
                echo "
						<td class='list_description'>
							<form id='apagarArq' method='POST' action='?perfil=" . $pagina . "'>
								<input type='hidden' name='idPessoa' value='" . $idPessoa . "' />
								<input type='hidden' name='tipoPessoa' value='" . $tipoPessoa . "' />
								<input type='hidden' name='apagar' value='" . $arquivo['idUploadArquivo'] . "' />
								<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Remover Arquivo?' data-message='Deseja realmente excluir o arquivo " . $arquivo['documento'] . "?'>Remover
								</button></td>
							</form>";
            }
            echo "</tr>";
        }
        echo "
		</tbody>
		</table>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}


function exibirArquivoParecer($tipoPessoa, $idPessoa)
{
    $con = bancoMysqli();
    $sql = "
	   SELECT 
	     *
	  FROM 
	    lista_documento as list
	  INNER JOIN upload_arquivo AS arq 
	  ON arq.idListaDocumento = list.idListaDocumento
	  WHERE arq.idPessoa = '$idPessoa'
	  AND arq.idTipo = '$tipoPessoa'
	  AND arq.idStatusDocumento = '1'
	  -- AND arq.idListaDocumento = '37'
	  AND arq.publicado = '1'";

    $query = mysqli_query($con, $sql);

    while ($arquivo = mysqli_fetch_array($query)) {
        echo "<a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . $arquivo['arquivo'] . "</a>";

    }

}

function listaArquivosPessoaSMC($idPessoa, $tipoPessoa, $pagina)
{

    $con = bancoMysqli();

    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
        echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Nome do arquivo</td>
					<td>Status</td>
					<td>Observação</td>
					<td width='15%'></td>
				</tr>
			</thead>
			<tbody>";
        echo "<form method='POST' action='?perfil=" . $pagina . "'>";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>(" . $arquivo['documento'] . ")</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>";
            echo "<td class='list_description'>
								<select name='status' id='statusOpt'>";
            echo "<option>Selecione</option>";
            geraOpcao('status_documento', $arquivo['idStatusDocumento']);
            echo " </select>
							</td>";
            echo "<td class='list_description'>
						<input type='text' name='observacoes' maxlength='100' id='observ' value='" . $arquivo['observacoes'] . "'/>
						<input type='hidden' name='idArquivo' value='" . $arquivo['idUploadArquivo'] . "' />
						</td>";
        }
        echo "
							<td class='list_description'>	
								<input type='hidden' name='idPessoa' value='" . $idPessoa . "' />
								<button class='btn btn-theme' type='submit' name='editarParecer'>Atualizar
								</button>
							</td>";
        echo "</tr>";
        echo "</form>";
        echo "
		</tbody>
		</table>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}

function listaParecerSMC($idPessoa, $tipoPessoa, $pagina)
{
    $con = bancoMysqli();
    $sql = "SELECT documento, arquivo, arq.idUploadArquivo AS idArquivo, disp.idUploadArquivo,disp.id 'disponibilizar', idStatusDocumento,observacoes,disp.data AS dataDisponivel
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			LEFT JOIN disponibilizar_documento AS disp ON arq.idUploadArquivo = disp.idUploadArquivo
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
        echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Nome do arquivo</td>
					<td>Status</td>
					<td>Observação</td>
					<td>Data da Publicação</td>
					<td width='15%'></td>
				</tr>
			</thead>
			<tbody>";
        $x = 1;
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<form method='POST' action='?perfil=" . $pagina . "'>";
            echo "<tr>";
            echo "<td class='list_description'>(" . $arquivo['documento'] . ")</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>";
            echo "<td class='list_description'>
								<select name='status' id='statusOpt'>";
            echo "<option>Selecione</option>";
            geraOpcao('status_documento', $arquivo['idStatusDocumento']);
            echo " </select>
							</td>";
            echo "<td class='list_description'>
					<input type='text' name='observacoes' maxlength='100' id='observ' value='" . $arquivo['observacoes'] . "'/></td>";
            echo "<td class='list_description'>
					<input type='text' name='dataDisponivel' id='datepicker0" . $x . "' class='form-control' value='" . exibirDataBr($arquivo['dataDisponivel']) . "'/></td>";
            echo "<td class='list_description'>	
					<input type='hidden' name='idPessoa' value='" . $idPessoa . "' />
					<input type='hidden' name='idArquivo' value='" . $arquivo['idArquivo'] . "' />
					<input type='hidden' name='idDisponib' value='" . $arquivo['disponibilizar'] . "'/>
					<button class='btn btn-theme' type='submit' name='editarParecer'>Atualizar
					</button>
				</td>";
            echo "</tr>";
            echo "</form>";
            $x++;
        }
        echo "
		</tbody>
		</table>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}

function listaAnexosProjeto($idPessoa, $tipoPessoa, $idArquivo)
{
    $con = bancoMysqli();
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1' AND list.idListaDocumento = '$idArquivo' ";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
        echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td width='15%'></td>
				</tr>
			</thead>
			<tbody>";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['documento'], 15, 25, "...") . "</a></td>";
            echo "</tr>";
        }
        echo "
		</tbody>
		</table>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}

function listaAnexosProjetoSMC($idProjeto, $tipoPessoa, $pagina)
{
    $con = bancoMysqli();
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idProjeto'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1' AND list.idListaDocumento IN (39,40,41,42,43,44,46,47,52,53) ";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
        echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td width='15%'></td>
				</tr>
			</thead>
			<tbody>";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['documento'], 0, 100, "...") . "</a></td>";
            echo "<td class='list_description'>
					<form id='apagarArq' method='POST' action='?perfil=" . $pagina . "'>
						<input type='hidden' name='idProjeto' value='" . $idProjeto . "' />
						<input type='hidden' name='tipoPessoa' value='" . $tipoPessoa . "' />
					</form>";
            echo "</tr>";
        }
        echo "
		</tbody>
		</table>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}

function listaSolicitacaoProponente($idPessoa, $tipoPessoa, $pagina)
{
    $con = bancoMysqli();
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1' AND list.idListaDocumento IN (47) ";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
        echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Nome do arquivo</td>
					<td>Status</td>
					<td>Observação</td>
					<td width='15%'></td>
				</tr>
			</thead>
			<tbody>";
        echo "<form method='POST' action='?perfil=" . $pagina . "'>";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>(" . $arquivo['documento'] . ")</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>";
            echo "<td class='list_description'>
								<select name='status' id='statusOpt'>";
            echo "<option>Selecione</option>";
            geraOpcao('status_documento', $arquivo['idStatusDocumento']);
            echo " </select>
							</td>";
            echo "<td class='list_description'>
						<input type='text' name='observacoes' maxlength='100' id='observ' value='" . $arquivo['observacoes'] . "'/>
						<input type='hidden' name='idArquivo' value='" . $arquivo['idUploadArquivo'] . "' />
						</td>";
        }
        echo "
							<td class='list_description'>	
								<input type='hidden' name='idPessoa' value='" . $idPessoa . "' />
								<button class='btn btn-theme' type='submit' name='editarSolicitacaoProponente'>Atualizar
								</button>
							</td>";
        echo "</tr>";
        echo "</form>";
        echo "
		</tbody>
		</table>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}

function listaArquivosPessoaVisualizacao($idPessoa, $tipoPessoa, $pagina)
{
    $con = bancoMysqli();
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
        echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td width='15%'></td>
				</tr>
			</thead>
			<tbody>";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['documento'], 0, 25, "...") . "</a></td>";
        }
        echo "
		</tbody>
		</table>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}

function listaArquivosPendentePessoa($idPessoa, $tipoPessoa, $pagina)
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
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
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
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>(" . $arquivo['documento'] . ")</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>";
            echo "
						<td class='list_description'>
							<form id='apagarArq' method='POST' action='?perfil=" . $pagina . "'>
								<input type='hidden' name='idPessoa' value='" . $idPessoa . "' />
								<input type='hidden' name='tipoPessoa' value='" . $tipoPessoa . "' />
								<input type='hidden' name='apagar' value='" . $arquivo['idUploadArquivo'] . "' />
								<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Remover Arquivo?' data-message='Deseja realmente excluir o arquivo " . $arquivo['documento'] . "?'>Remover
								</button></td>
							</form>";
            echo "</tr>";
            echo "<tr>";
            echo "<td class='list_description'><button type='button' class='btn btn-warning' data-toggle='modal' data-target='#" . $arquivo['idUploadArquivo'] . "'>Observação</button></td>";
            echo "</tr>";
            // Modal para exibir dados do campo Observação
            echo "
						<div class='modal fade' id='" . $arquivo['idUploadArquivo'] . "' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
							<div class='modal-dialog' role='document'>
								<div class='modal-content'>
									<div class='modal-header'>
										<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
										<h4 class='modal-title text-primary' id='myModalLabel'>Observação</h4>
									</div>
									<div class='modal-body'>
										<h6>Arquivo: " . $arquivo['documento'] . "</h6>
										<p>" . $arquivo['observacoes'] . "	</p>
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

    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}

function listaArquivosPessoaEditor($idPessoa, $tipoPessoa, $pagina)
{
    $con = bancoMysqli();
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
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
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>(" . $arquivo['documento'] . ")</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>";
            echo "<form id='atualizaDoc' method='POST' action='?perfil=" . $pagina . "'>";
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
								<input type='hidden' name='idPessoa' value='" . $idPessoa . "' />
								<input type='hidden' name='tipoPessoa' value='" . $tipoPessoa . "' />
								<button class='btn btn-theme' type='button' data-toggle='modal'>Atualizar
								</button></td>
							</form>";
            echo "</tr>";
        }
        echo "
		</tbody>
		</table>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}


/**
 * Lista os arquivos da pessoa com o campo de status e observação para visualização
 * @param int $idPessoa
 * @param int $tipoPessoa
 */
function listaArquivosPessoaObs($idPessoa, $tipoPessoa)
{
    $con = bancoMysqli();
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
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
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>(" . $arquivo['documento'] . ")</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>";
            $queryy = "SELECT idStatusDocumento FROM upload_arquivo WHERE idUploadArquivo = '" . $arquivo['idUploadArquivo'] . "'";
            $send = mysqli_query($con, $queryy);
            $row = mysqli_fetch_array($send);
            $statusDoc = recuperaDados("status_documento", "idStatusDocumento", $row['idStatusDocumento']);

            if ($statusDoc != null) {
                echo "<td class='list_description'>" . $statusDoc['status'] . "</td>";
            } else {
                echo "<td class='list_description'></td>";
            }
            $queryOBS = "SELECT observacoes FROM upload_arquivo WHERE idUploadArquivo = '" . $arquivo['idUploadArquivo'] . "'";
            $send = mysqli_query($con, $queryOBS);
            $row = mysqli_fetch_array($send);
            echo "<td class='list_description'>" . $row['observacoes'] . "</td>";
            echo "</tr>";
        }
        echo "
		</tbody>
		</table>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}

function exibirArquivos($tipoPessoa, $idPessoa)
{
    $con = bancoMysqli();
    $sql = "
	   SELECT 
	     *
	  FROM 
	    lista_documento as list
	  INNER JOIN upload_arquivo AS arq 
	  ON arq.idListaDocumento = list.idListaDocumento
	  
	  WHERE arq.idPessoa = '$idPessoa'
	  AND arq.idTipo = '$tipoPessoa'
	  AND arq.publicado = '1'
	  AND list.idListaDocumento NOT IN (39,40,41,42,43,44)";

    $query = mysqli_query($con, $sql);
    echo "
		<table class='table table-bordered'>
			<tr>
				<td><strong>Tipo de arquivo</strong></td>
				<td><strong>Nome do arquivo</strong></td>
				<td><strong>Status</strong></td>
				<td><strong>Observações</strong></td>
			</tr>
	";
    while ($arquivo = mysqli_fetch_array($query)) {
        echo "<tr>";
        echo "<td class='list_description'>(" . $arquivo['documento'] . ")</td>";
        echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . $arquivo['arquivo'] . "</a></td>";
        $queryy = "SELECT idStatusDocumento FROM upload_arquivo WHERE idUploadArquivo = '" . $arquivo['idUploadArquivo'] . "'";
        $send = mysqli_query($con, $queryy);
        $row = mysqli_fetch_array($send);
        $statusDoc = recuperaDados("status_documento", "idStatusDocumento", $row['idStatusDocumento']);
        if ($statusDoc != null) {
            echo "<td class='list_description'>" . $statusDoc['status'] . "</td>";
        } else {
            echo "<td class='list_description'></td>";
        }
        echo "<td class='list_description'>" . $arquivo['observacoes'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

function exibirArquivosProjeto($tipoPessoa, $idProjeto)
{
    $con = bancoMysqli();
    $sql = "SELECT * FROM lista_documento as list
			INNER JOIN upload_arquivo AS arq 
			ON arq.idListaDocumento = list.idListaDocumento	  
			WHERE arq.idPessoa = '$idProjeto'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'
			AND list.idListaDocumento IN (18,19,20,21,22,23,38)";
    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);
    if ($num > 0) {
        echo "<ul class='list-group'>";
        echo "<li class='list-group-item list-group-item-success'><b>Arquivos do projeto</b></li>";
        echo "<li class='list-group-item'>";
        echo "
			<table class='table table-bordered'>
				<tr>
					<td><strong>Tipo de arquivo</strong></td>
					<td><strong>Nome do arquivo</strong></td>
				</tr>
		";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>" . $arquivo['documento'] . "</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 0, 40, "...") . "</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</li>";
        echo "</ul>";
    }
}

function exibirCertificados($tipoPessoa, $idPessoa)
{
    $con = bancoMysqli();
    $sql = "SELECT * FROM lista_documento as list
			INNER JOIN upload_arquivo AS arq 
			ON arq.idListaDocumento = list.idListaDocumento			
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'
			AND list.idListaDocumento IN (39,40,41,42,43,44)";
    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);
    if ($num > 0) {
        echo "<ul class='list-group'>";
        echo "<li class='list-group-item list-group-item-success'><b>Certificados do projeto</b></li>";
        echo "<li class='list-group-item'>";
        echo "
			<table class='table table-bordered'>
				<tr>
					<td><strong>Tipo de arquivo</strong></td>
					<td><strong>Nome do arquivo</strong></td>
				</tr>
		";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>" . $arquivo['documento'] . "</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 0, 40, "...") . "</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</li>";
        echo "</ul>";
    }
}

function exibirComplemento($tipoPessoa, $idPessoa)
{
    $con = bancoMysqli();
    $sql = "SELECT * FROM lista_documento as list
			INNER JOIN upload_arquivo AS arq 
			ON arq.idListaDocumento = list.idListaDocumento	  
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'
			AND list.idListaDocumento IN (46)";
    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);
    if ($num > 0) {
        echo "<ul class='list-group'>";
        echo "<li class='list-group-item list-group-item-success'><b>Complemento de informação</b></li>";
        echo "<li class='list-group-item'>";
        echo "
			<table class='table table-bordered'>
				<tr>
					<td><strong>Tipo de arquivo</strong></td>
					<td><strong>Nome do arquivo</strong></td>
				</tr>
		";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>" . $arquivo['documento'] . "</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 0, 40, "...") . "</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</li>";
        echo "</ul>";
    }
}

function exibirSolicitacaoAlteracao($tipoPessoa, $idPessoa)
{
    $con = bancoMysqli();
    $sql = "SELECT * FROM lista_documento as list
			INNER JOIN upload_arquivo AS arq 
			ON arq.idListaDocumento = list.idListaDocumento	  
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'
			AND list.idListaDocumento IN (47)";
    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);
    if ($num > 0) {
        echo "<ul class='list-group'>";
        echo "<li class='list-group-item list-group-item-success'><b>Solicitação de alteração</b></li>";
        echo "<li class='list-group-item'>";
        echo "
			<table class='table table-bordered'>
				<tr>
					<td><strong>Tipo de arquivo</strong></td>
					<td><strong>Nome do arquivo</strong></td>
				</tr>
		";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>" . $arquivo['documento'] . "</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 0, 40, "...") . "</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</li>";
        echo "</ul>";
    }
}

function exibirRecurso($tipoPessoa, $idProjeto)
{
    $con = bancoMysqli();
    $sql = "SELECT * FROM lista_documento as list
			INNER JOIN upload_arquivo AS arq 
			ON arq.idListaDocumento = list.idListaDocumento	  
			WHERE arq.idPessoa = '$idProjeto'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'
			AND list.idListaDocumento IN (52)";
    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);
    if ($num > 0) {
        echo "<ul class='list-group'>";
        echo "<li class='list-group-item list-group-item-success'><b>Recurso enviado</b></li>";
        echo "<li class='list-group-item'>";
        echo "
		<table class='table table-bordered'>
			<tr>
				<td><strong>Tipo de arquivo</strong></td>
				<td><strong>Nome do arquivo</strong></td>
			</tr>";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>" . $arquivo['documento'] . "</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 0, 40, "...") . "</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</li>";
        echo "</ul>";
    }
}

function exibirParecerProponente($idProjeto)
{
    $con = bancoMysqli();
    $dateNow = date('Y-m-d');
    $sql = "SELECT * FROM lista_documento as list
            INNER JOIN upload_arquivo AS arq ON arq.idListaDocumento = list.idListaDocumento
            LEFT JOIN disponibilizar_documento AS disp ON arq.idUploadArquivo = disp.idUploadArquivo	  
            WHERE arq.idPessoa = '$idProjeto'
            AND arq.idTipo = '9'
            AND arq.publicado = '1'
            AND arq.idStatusDocumento = '1'
            AND disp.data <= '$dateNow'";
    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);
    if ($num > 0) {
        echo "<ul class='list-group'>";
        echo "<li class='list-group-item list-group-item-success'><b>Parecer disponível</b></li>";
        echo "<li class='list-group-item'>";
        echo "
		<table class='table table-bordered'>
			<tr>
				<td><strong>Tipo de arquivo</strong></td>
				
			</tr>";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['documento'], 0, 190, "") . "</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</li>";
        echo "</ul>";
    }
}

// Função que valida o CPF
function validaCPF($cpf)
{
    $cpf = preg_replace('/[^0-9]/', '', (string)$cpf);
    // Valida tamanho
    if (strlen($cpf) != 11)
        return false;
    // Calcula e confere primeiro dígito verificador
    for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
        $soma += $cpf[$i] * $j;
    $resto = $soma % 11;
    if ($cpf[9] != ($resto < 2 ? 0 : 11 - $resto))
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
        $soma += $cpf[$i] * $j;
    $resto = $soma % 11;
    return $cpf[10] == ($resto < 2 ? 0 : 11 - $resto);
}

// Função que valida o CNPJ
function validaCNPJ($cnpj)
{
    $cnpj = preg_replace('/[^0-9]/', '', (string)$cnpj);
    // Valida tamanho
    if (strlen($cnpj) != 14)
        return false;
    // Valida primeiro dígito verificador
    for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
        $soma += $cnpj[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }
    $resto = $soma % 11;
    if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
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
    if (in_array($cnpj, $invalidos)) {
        return false;
    }
    // Valida segundo dígito verificador
    for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
        $soma += $cnpj[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }
    $resto = $soma % 11;
    return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
}

// Função que valida e-mails
function validaEmail($email)
{
    /* Verifica se o email e valido */
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        /* Obtem o dominio do email */
        list($usuario, $dominio) = explode('@', $email);

        /* Faz um verificacao de DNS no dominio */
        if (checkdnsrr($dominio, 'MX') == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }
}

function listaArquivos($idEvento)
{
    //lista arquivos de determinado evento
    $con = bancoMysqli();
    $sql = "SELECT * FROM upload_arquivo_com_prod WHERE idEvento = '$idEvento' AND publicado = '1'";
    $query = mysqli_query($con, $sql);
    echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Nome do arquivo</td>
					<td width='10%'></td>
				</tr>
			</thead>
			<tbody>";
    while ($campo = mysqli_fetch_array($query)) {
        echo "<tr>";
        echo "<td class='list_description'><a href='../uploads/" . $campo['arquivo'] . "' target='_blank'>" . $campo['arquivo'] . "</a></td>";
        echo "
			<td class='list_description'>
				<form method='POST' action='?perfil=arquivos_com_prod'>
					<input type='hidden' name='apagar' value='" . $campo['id'] . "' />
					<input type ='submit' class='btn btn-theme  btn-block' value='Remover'></td></form>";
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

function verificaArquivosExistentesPF($idPessoa, $idDocumento, $tipo = 1)
{
    $con = bancoMysqli();
    $verificacaoArquivo = "SELECT arquivo FROM upload_arquivo WHERE idTipo = '$tipo' AND idPessoa = '$idPessoa' AND idListaDocumento = '$idDocumento' AND publicado = '1'";
    $envio = mysqli_query($con, $verificacaoArquivo);
    if (mysqli_num_rows($envio) > 0) {
        return true;
    }
}

function verificaArquivosExistentesIncentivador($idPessoa, $idDocumento)
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
    $query = "SELECT 	             	             
	             loc_rea.local AS local,
	             loc_rea.estimativaPublico AS estimativaLocal,
                 loc_rea.logradouro AS logradouro,
                 loc_rea.numero AS número_local,
                 loc_rea.bairro AS bairro_local,
                 loc_rea.cidade AS cidade_local,
                 loc_rea.estado AS estado_local,
                 loc_rea.cep AS cep_local			 
			   FROM  
			     projeto as proj			     			   
  			   INNER JOIN 
                  locais_realizacao AS loc_rea 
               ON loc_rea.idProjeto = proj.idProjeto
  			   
  			   WHERE loc_rea.publicado = 1
  			   AND  proj.idProjeto =" . $idProjeto;

    $resultado = mysqli_query($conexao, $query);

    while ($campo = mysqli_fetch_assoc($resultado)) {
        array_push($campos, $campo);
    }

    return $campos;
}

function retornaCamposObrigatoriosFichaTecnica($idProjeto)
{
    $campos = [];

    $conexao = bancoMysqli();
    $query = "SELECT 	             	             
	             ficha_t.nome AS nomeFichaTecnica, 
  				 ficha_t.cpf AS cpfFichaTecnica, 
  				 ficha_t.funcao AS funcaoFichaTecnica  					             
			   FROM  
			     projeto as proj
			   INNER JOIN 
  			      ficha_tecnica AS ficha_t 
  			   ON ficha_t.idProjeto = proj.idProjeto
  			   
  			   WHERE ficha_t.publicado = 1
  			   AND  proj.idProjeto =" . $idProjeto;

    $resultado = mysqli_query($conexao, $query);

    while ($campo = mysqli_fetch_assoc($resultado)) {
        array_push($campos, $campo);
    }

    return $campos;
}

function retornaCamposObrigatoriosCronograma($idProjeto)
{
    $campos = [];

    $conexao = bancoMysqli();
    $query = "SELECT 	             	             
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
			   
  			   WHERE proj.idProjeto =" . $idProjeto;

    $resultado = mysqli_query($conexao, $query);

    while ($campo = mysqli_fetch_assoc($resultado)) {
        array_push($campos, $campo);
    }

    return $campos;
}

function retornaCamposObrigatoriosOrcamento($idProjeto)
{
    $campos = [];

    $conexao = bancoMysqli();
    $query = "SELECT 	             	             
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
  			   AND  proj.idProjeto =" . $idProjeto;

    $resultado = mysqli_query($conexao, $query);

    while ($campo = mysqli_fetch_assoc($resultado)) {
        array_push($campos, $campo);
    }

    return $campos;
}

function retornaCamposObrigatoriosPf($idProjeto)
{
    $campos = [];

    $conexao = bancoMysqli();
    $query = "SELECT 	             
	             pf.nome AS nomeProponente, 
	             pf.cpf AS cpfProponente, 
	             pf.rg AS rgProponente, 
	             pf.email AS emailProponente, 
	             pf.cep AS cepProponente,
	             pf.numero AS numeroProponente,	             
	             proj.idAreaAtuacao AS areaAtuacaoProjeto, 	             
	             proj.nomeProjeto AS nomeProjeto, 	             	             
	             proj.idExposicaoMarca AS exposicaoMarca, 	  
	             proj.indicacaoIngresso AS indicacaoIngresso, 	  
	             proj.resumoProjeto AS resumoCurriculoProjeto, 
	             proj.curriculo AS resumoCurriculoCvProponente, 	             
	             proj.descricao AS ObjetoDescricao,
	             proj.justificativa AS justificativaObjetoProjeto,
	             proj.objetivo AS justificativaObjetoMetas,
	             loc_rea.local AS local, 
	             loc_rea.estimativaPublico AS estimativaLocal, 
	             loc_rea.logradouro AS logradouro,
                 loc_rea.numero AS número_local,
                 loc_rea.bairro AS bairro_local,
                 loc_rea.cidade AS cidade_local,
                 loc_rea.estado AS estado_local,
                 loc_rea.cep AS cep_local,  				 
	             proj.publicoAlvo AS publicoAlvo,
	             ficha_t.nome AS nomeFichaTecnica, 
  				 ficha_t.cpf AS cpfFichaTecnica, 
  				 ficha_t.funcao AS funcaoFichaTecnica,  				
  				 crono.captacaoRecurso AS recursoConograma, 
  				 crono.preProducao AS preProducaoConograma, 
  				 crono.producao AS producaoCronograma, 
  				 crono.posProducao AS posProducaoConograma, 
  				 crono.prestacaoContas AS ContasConograma,
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
                 exposicao_marca as exp ON proj.idExposicaoMarca = exp.id
  			   
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
  			   
  			   INNER JOIN
  			   	material_divulgacao AS materialD
  			   ON materialD.projeto_id = proj.idProjeto 
  			   
  			   WHERE loc_rea.publicado = 1
  			   AND  ficha_t.publicado = 1
  			   AND  orca.publicado = 1
  			   AND  proj.idProjeto =" . $idProjeto;

    $resultado = mysqli_query($conexao, $query);

    while ($campo = mysqli_fetch_assoc($resultado)) {
        array_push($campos, $campo);
    }

    return $campos;
}

function retornaCamposObrigatoriosRepresentate($idProjeto)
{
    $campos = [];

    $conexao = bancoMysqli();
    $query = "SELECT 
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
  			   
  			   WHERE proj.idProjeto =" . $idProjeto;

    $resultado = mysqli_query($conexao, $query);

    while ($campo = mysqli_fetch_assoc($resultado)) {
        array_push($campos, $campo);
    }

    return $campos;
}

function retornaCamposObrigatoriosPj($idProjeto)
{
    $campos = [];

    $conexao = bancoMysqli();
    $query = "SELECT 
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
	             proj.idExposicaoMarca AS ValoresEnquadramentoExposicaoMarca,              
	             proj.resumoProjeto AS resumoCurriculoProjeto, 
	             proj.curriculo AS resumoCurriculoCvProponente, 	             
	             proj.descricao AS ObjetoDescricao,  
	             proj.justificativa AS justificativaObjetoProjeto, 
	             proj.objetivo AS justificativaObjetoMetas, 
	             proj.publicoAlvo AS publicoAlvo,
	             materialD.veiculo_divulgacao AS veiculoDivulgacao,	             
	             loc_rea.local AS local, 
	             loc_rea.estimativaPublico AS estimativaLocal, 
	             loc_rea.logradouro AS logradouro,
                 loc_rea.numero AS número_local,
                 loc_rea.bairro AS bairro_local,
                 loc_rea.cidade AS cidade_local,
                 loc_rea.estado AS estado_local,
                 loc_rea.cep AS cep_local,  				 
  				 ficha_t.nome AS nomeFichaTecnica, 
  				 ficha_t.cpf AS cpfFichaTecnica, 
  				 ficha_t.funcao AS funcaoFichaTecnica,  				 
  				 crono.captacaoRecurso AS recursoConograma, 
  				 crono.preProducao AS preProducaoConograma, 
  				 crono.producao AS producaoConograma, 
  				 crono.posProducao AS posProducaoConograma, 
  				 crono.prestacaoContas AS ContasConograma,
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
  			   
  			   INNER JOIN
  			    	(SELECT * FROM material_divulgacao WHERE publicado = '1') AS materialD
  			   ON materialD.projeto_id = proj.idProjeto
  			   
  			   WHERE loc_rea.publicado = 1
  			   AND  ficha_t.publicado = 1
  			   AND  orca.publicado = 1
  			   AND  proj.idProjeto =" . $idProjeto . " LIMIT 1";

    $resultado = mysqli_query($conexao, $query);

    while ($campo = mysqli_fetch_assoc($resultado)) {
        array_push($campos, $campo);
    }

    return $campos;
}

function processaDados($fields)
{
    $erros = [];

    foreach ($fields as $campos):
        foreach ($campos as $campo => $conteudo):
            if (is_string($campo)):
                validaConteudo($conteudo) ? array_push($erros, $campo) : '';
                if ($campo == 'zonaLocal'):
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

function retornaDocumentosObrigatoriosProponente($tipoPessoa, $id = null)
{
    $documentos = [];
    $conexao = bancoMysqli();
    $listaDocumentos = [
        'doc.idListaDocumento <> 27',
        'doc.idListaDocumento <> 10',
    ];

    if ($tipoPessoa == 2) {
        $cooperativa = $conexao->query("SELECT cooperativa FROM pessoa_juridica WHERE idPj = '$id'")->fetch_assoc()['cooperativa'];
        if ($cooperativa != 1) {
            array_push($listaDocumentos, 'doc.idListaDocumento <> 17');
        }
    } elseif ($tipoPessoa == 5) {
        $imposto = $conexao->query("SELECT imposto FROM incentivador_pessoa_juridica WHERE idPj = '$id'")->fetch_assoc()['imposto'];
        if ($imposto == 1) {
            array_push($listaDocumentos, 'doc.idListaDocumento <> 35');
        } elseif ($imposto == 2) {
            array_push($listaDocumentos, 'doc.idListaDocumento <> 53');
        }
    }

    $query = "SELECT doc.idListaDocumento                         
             FROM lista_documento AS doc  
  			  WHERE " . implode(' AND ', $listaDocumentos) . "
  			  AND doc.idTipoUpload = " . $tipoPessoa;

    $resultado = mysqli_query($conexao, $query);

    while ($documento = mysqli_fetch_assoc($resultado)) {
        array_push($documentos, $documento);
    }

    return $documentos;
}

/**
 * Função que retornar os documentos obrigatórios do projeto <br>
 * está inativa, caso o cliente deseje mudar a regra de negócio
 */
function retornaArquivosObrigatorios($tipoPessoa)
{
    $documentos = [];
    $conexao = bancoMysqli();
    $query = "SELECT 
               doc.idListaDocumento                         
             FROM 
               lista_documento AS doc  
  			  WHERE doc.idListaDocumento IN (20)
  			  AND doc.idTipoUpload = 3";

    $resultado = mysqli_query($conexao, $query);

    while ($documento = mysqli_fetch_assoc($resultado)) {
        array_push($documentos, $documento);
    }

    return $documentos;
}


function retornaArquivosCarregados($idUser)
{
    $documentos = [];
    $conexao = bancoMysqli();
    $query = "SELECT 	             
  			   up_arq.idListaDocumento 
			 FROM  
			   projeto as proj			 
  			 INNER JOIN 
               upload_arquivo AS up_arq 
             ON up_arq.idPessoa = '$idUser'
  			 WHERE up_arq.publicado = 1";

    $resultado = mysqli_query($conexao, $query);

    if (!empty($resultado)):
        while ($documento = mysqli_fetch_assoc($resultado)) {
            array_push($documentos, $documento);
        }
    endif;

    return $documentos;
}

function retornaAnexosCarregados($idProjeto)
{
    $documentos = [];

    $conexao = bancoMysqli();
    $query = "SELECT 	             
  			   up_arq.idListaDocumento 
			 FROM  			     			 
               upload_arquivo AS up_arq              
  			 WHERE up_arq.publicado = 1
  			   AND up_arq.idPessoa =" . $idProjeto;

    $resultado = mysqli_query($conexao, $query);

    if (!empty($resultado)):
        while ($documento = mysqli_fetch_assoc($resultado)) {
            array_push($documentos, $documento);
        }
    endif;

    return $documentos;
}

function formataDados($arrayArquivos)
{
    $tipoDoc = [];

    foreach ($arrayArquivos as $key => $conteudo):
        foreach ($conteudo as $tipo):
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

    foreach ($idDocDiferentes as $key => $conteudo):
        array_push($documentos, retornaArquivosDivergentes($conteudo));
    endforeach;

    return $documentos;

}

function retornaArquivosDivergentes($idListaDocumento)
{
    $documentos = [];
    $conexao = bancoMysqli();
    $query = "SELECT 
               doc.documento
             FROM 
               lista_documento AS doc  
  			  WHERE doc.idListaDocumento = " . $idListaDocumento;

    $resultado = mysqli_query($conexao, $query);
    $documentos = mysqli_fetch_array($resultado);

    return $documentos;
}

function arquivosExiste($urlArquivo, $extensao = '.php')
{
    $file = $urlArquivo . $extensao;
    $file_headers = @get_headers($file);
    if ($file_headers[0] == 'HTTP/1.1 404 Not Found'):
        return false;
    endif;

    return true;
}

function selecionaArquivoAnexo($http, $idListaDocumento, $extensao = '.php')
{
    $path = $http . $idListaDocumento . $extensao;
    return $path;
}

function retornaQtdProjetos($tipoPessoa, $id)
{
    $conexao = bancoMysqli();

    $editalAtivo = recuperaDados("liberacao_projeto","idStatus",1)['edital'];

    if ($tipoPessoa == 1) {
        $query = "SELECT 
                    count(idProjeto)
                    FROM 
                    projeto AS proj  
                    WHERE proj.publicado = 1
                    AND proj.idStatus != 6
                    AND proj.edital = '$editalAtivo'
                    AND   proj.idPf = '$id'";
    } elseif ($tipoPessoa == 2) {
        $query = "SELECT 
                    count(idProjeto)
                    FROM 
                    projeto AS proj  
                    INNER JOIN 
                    pessoa_juridica AS pj 
                    ON pj.idPj = proj.idPj 
                    WHERE proj.publicado = 1
                    AND proj.idStatus != 6
                    AND   pj.cooperativa = 0
                    AND proj.edital = '$editalAtivo'
                    AND   proj.idPj = '$id'";
    }
    $resultado = mysqli_query($conexao, $query);
    $qtdProjeto = mysqli_fetch_array($resultado);

    return $qtdProjeto;
}

function retornaProjeto($tipoPessoa, $id)
{
    $documentos = [];
    $conexao = bancoMysqli();

    $editalAtivo = recuperaDados("liberacao_projeto","idStatus",1)['edital'];

    if ($tipoPessoa == 1):
        $query = "SELECT 
               nomeProjeto
             FROM 
               projeto AS proj  
  			  WHERE proj.publicado = 1
  			  AND proj.idStatus != 6
              AND proj.edital = '$editalAtivo'
  			  AND   proj.idPf = '$id'";

        $resultado = mysqli_query($conexao, $query);
        $projeto = mysqli_fetch_array($resultado);

        return $projeto;

    else:
        $query = "SELECT 
               nomeProjeto
             FROM 
               projeto AS proj  
  			  WHERE proj.publicado = 1
  			  AND proj.idStatus != 6
  			  AND proj.edital = '$editalAtivo'
  			  AND   proj.idPj = '$id'";

        $resultado = mysqli_query($conexao, $query);

        if (!empty($resultado)):
            while ($documento = mysqli_fetch_assoc($resultado)) {
                array_push($documentos, $documento);
            }
            return $documentos;
        endif;
    endif;
}

function retornaEndereco($cep)
{

    $enderecos = [];
    $conexao = bancoMysqliCep();

    $resultado = mysqli_query($conexao,
        "CALL  pr_busca_cep('$cep');");

    if (!empty($resultado)):
        while ($endereco = mysqli_fetch_assoc($resultado)) {
            array_push($enderecos, $endereco);
        }
        return $enderecos;
    endif;

    return $enderecos;
}

function retornaUf($cep)
{

    $conexao = bancoMysqliCep();

    $resultado = mysqli_query($conexao,
        "CALL  pr_busca_uf('$cep');");

    $uf = mysqli_fetch_array($resultado);

    return array_unique($uf);
}

function configuraEndereco($addresses)
{
    $enderecos = [];

    if (!empty($addresses)):
        $enderecos = [
            'logradouro' => $addresses[0]['tp_logradouro'] . " " . $addresses[0]['logradouro'],
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

    $query = "SELECT 
               uf
             FROM 
               estado order by uf";

    $resultado = mysqli_query($conexao, $query);

    while ($estado = mysqli_fetch_assoc($resultado)) {
        array_push($estados, $estado);
    }
    return $estados;
}

function listaCidades()
{
    $cidades = [];
    $conexao = bancoMysqliCep();

    $query = "SELECT 
               nome
             FROM 
               cidade order by nome";

    $resultado = mysqli_query($conexao, $query);

    while ($cidade = mysqli_fetch_assoc($resultado)) {
        array_push($cidades, $cidade);
    }
    return $cidades;
}

function validaData($dtInicio, $dtFim)
{
    return $dtFim >= $dtInicio ? true : false;
}

function geraHeaderWebLog()
{
    $logs = [];
    $conexao = bancoMysqli();

    $query = "SELECT 
               log.idWebLog, 
               log.tabela, 
               log.acao, 
               log.IdRegistro,
               log.dataOcorrencia                
             FROM 
               weblogs AS log";

    $resultado = mysqli_query($conexao, $query);

    while ($log = mysqli_fetch_assoc($resultado)):
        array_push($logs, $log);
    endwhile;

    return $logs;
}


function webLogPaginacao($inicio, $qtdRegistrosPorPag)
{
    $logs = [];
    $conexao = bancoMysqli();

    $query = "SELECT 
               log.idWebLog, 
               log.tabela, 
               log.acao, 
               log.idRegistro,
               log.dataOcorrencia,                
               fn_busca_registro
                 (log.documento, log.idRegistro,
                  log.idCronograma, log.tabela) AS alteradoPor,

                 (SELECT 
                  nomeProjeto 
                 FROM 
                   projeto AS P
                 WHERE P.idProjeto = log.idRegistro) AS nomePo,                       
                 
                 (SELECT 
                  nomeProjeto 
                 FROM 
                   projeto AS p
                 INNER JOIN cronograma AS c 
                 ON c.idCronograma = p.idCronograma
                 WHERE c.idCronograma = log.idCronograma LIMIT 1) AS crono                 

             FROM 
               weblogs AS log
             ORDER BY log.idWeblog DESC
             LIMIT $inicio, $qtdRegistrosPorPag";

    $resultado = mysqli_query($conexao, $query);

    while ($log = mysqli_fetch_assoc($resultado)):
        array_push($logs, $log);
    endwhile;

    return $logs;
}

function pessoaFisicaQuery($dtInicio, $dtFim, $tabela, $nome)
{
    $query = "SELECT 
               log.idWebLog, 
               log.tabela, 
               log.acao, 
               log.IdRegistro,
               log.dataOcorrencia,                
               pf.nome as nome,
               pf.alteradoPor 
             FROM 
               weblogs AS log
             INNER JOIN pessoa_fisica AS pf
             ON pf.idPf =  log.idRegistro
             WHERE log.dataOcorrencia >= '$dtInicio'
             AND   log.dataOcorrencia <= '$dtFim'
             AND   log.tabela = '$tabela' 
             AND   pf.nome LIKE '%$nome%'";

    return $query;

}

function pessoaJuridicaQuery($dtInicio, $dtFim, $tabela, $nome)
{
    $query = "SELECT 
               log.idWebLog, 
               log.tabela, 
               log.acao, 
               log.IdRegistro,
               log.dataOcorrencia,                
               pj.razaoSocial as nome,
               pj.alteradoPor 
             FROM 
               weblogs AS log
             INNER JOIN pessoa_juridica AS pj
             ON pj.idPj =  log.idRegistro
             WHERE log.dataOcorrencia >= '$dtInicio'
             AND   log.dataOcorrencia <= '$dtFim'
             AND   log.tabela = '$tabela' 
             AND   pj.razaoSocial LIKE '%$nome%'";

    return $query;
}

function projetoQuery($dtInicio, $dtFim, $tabela, $nome)
{
    $query = "SELECT 
               log.idWebLog, 
               log.tabela, 
               log.acao, 
               log.IdRegistro,
               log.dataOcorrencia,                
               p.nomeProjeto as nome,
               p.alteradoPor 
             FROM 
               weblogs AS log
             INNER JOIN projeto AS p
             ON p.idProjeto =  log.idRegistro
             WHERE log.dataOcorrencia >= '$dtInicio'
             AND   log.dataOcorrencia <= '$dtFim'
             AND   log.tabela = '$tabela' 
             AND   p.nomeProjeto LIKE '%$nome%'";

    return $query;
}

function locaisQuery($dtInicio, $dtFim, $tabela, $nome)
{
    $query = "SELECT 
               log.idWebLog, 
               log.tabela, 
               log.acao, 
               log.IdRegistro,
               log.dataOcorrencia,                
               p.nomeProjeto as nome,
               loc.alteradoPor 
             FROM 
               weblogs AS log
             INNER JOIN locais_realizacao AS loc
             ON loc.idProjeto =  log.idRegistro
             
             INNER JOIN projeto AS p 
             ON p.idProjeto =  log.idRegistro             
             
             WHERE log.dataOcorrencia >= '$dtInicio'
             AND   log.dataOcorrencia <= '$dtFim'
             AND   log.tabela = '$tabela' 
             AND   p.nomeProjeto LIKE '%$nome%'";

    return $query;
}

function fichaQuery($dtInicio, $dtFim, $tabela, $nome)
{
    $query = "SELECT 
               log.idWebLog, 
               log.tabela, 
               log.acao, 
               log.IdRegistro,
               log.dataOcorrencia,                
               p.nomeProjeto as nome,
               f.alteradoPor 
             FROM 
               weblogs AS log
             INNER JOIN ficha_tecnica AS f
             ON f.idProjeto =  log.idRegistro
             
             INNER JOIN projeto AS p 
             ON p.idProjeto =  log.idRegistro             
             
             WHERE log.dataOcorrencia >= '$dtInicio'
             AND   log.dataOcorrencia <= '$dtFim'
             AND   log.tabela = '$tabela' 
             AND   p.nomeProjeto LIKE '%$nome%'";

    return $query;
}

function cronogramaQuery($dtInicio, $dtFim, $tabela, $nome)
{
    $query = "SELECT 
               log.idWebLog, 
               log.tabela, 
               log.acao, 
               log.IdRegistro,
               log.dataOcorrencia,                
               p.nomeProjeto as nome,
               c.alteradoPor 
             FROM 
               weblogs AS log
             INNER JOIN cronograma AS c
             ON c.idCronograma =  log.idCronograma
             
             INNER JOIN projeto AS p 
             ON p.idCronograma =  log.idCronograma
             
             WHERE log.dataOcorrencia >= '$dtInicio'
             AND   log.dataOcorrencia <= '$dtFim'
             AND   log.tabela = '$tabela' 
             AND   p.nomeProjeto LIKE '%$nome%'";

    return $query;
}

function orcamentoQuery($dtInicio, $dtFim, $tabela, $nome)
{
    $query = "SELECT 
               log.idWebLog, 
               log.tabela, 
               log.acao, 
               log.IdRegistro,
               log.dataOcorrencia,                
               p.nomeProjeto as nome,
               o.alteradoPor 
             FROM 
               weblogs AS log
             INNER JOIN orcamento AS o
             ON o.idProjeto =  log.idRegistro
             
             INNER JOIN projeto AS p 
             ON p.idProjeto =  log.idRegistro             
             
             WHERE log.dataOcorrencia >= '$dtInicio'
             AND   log.dataOcorrencia <= '$dtFim'
             AND   log.tabela = '$tabela' 
             AND   p.nomeProjeto LIKE '%$nome%'";

    return $query;
}

function incentivadorPfQuery($dtInicio, $dtFim, $tabela, $nome)
{
    $query = "SELECT 
               log.idWebLog, 
               log.tabela, 
               log.acao, 
               log.IdRegistro,
               log.dataOcorrencia,                               
               ipf.alteradoPor 
             FROM 
               weblogs AS log  

             INNER JOIN incentivador_pessoa_fisica AS ipf
             ON ipf.cpf =  log.documento                          
             
             WHERE log.dataOcorrencia >= '$dtInicio'
             AND   log.dataOcorrencia <= '$dtFim'
             AND   log.tabela = '$tabela'";

    return $query;
}

function geraHeaderWebLogParam($dtInicio, $dtFim, $tabela, $nome)
{
    $logs = [];
    $conexao = bancoMysqli();

    switch ($tabela):
        case 'pessoa_fisica':
            $query = pessoaFisicaQuery($dtInicio, $dtFim, $tabela,
                $nome);
            break;

        case 'pessoa_juridica':
            $query = pessoaJuridicaQuery($dtInicio, $dtFim, $tabela,
                $nome);
            break;

        case 'projeto':
            $query = projetoQuery($dtInicio, $dtFim, $tabela,
                $nome);
            break;

        case 'locais':
            $query = locaisQuery($dtInicio, $dtFim, $tabela,
                $nome);
            break;

        case 'ficha_tecnica':
            $query = fichaQuery($dtInicio, $dtFim, $tabela,
                $nome);
            break;

        case 'cronograma':
            $query = cronogramaQuery($dtInicio, $dtFim, $tabela,
                $nome);
            break;

        case 'orcamento':
            $query = orcamentoQuery($dtInicio, $dtFim, $tabela,
                $nome);
            break;

        case 'incentivador_pessoa_fisica':
            $query = incentivadorPfQuery($dtInicio, $dtFim, $tabela,
                $nome);
            break;

    endswitch;

    $resultado = mysqli_query($conexao, $query);

    if ($resultado):
        while ($log = mysqli_fetch_assoc($resultado)):
            array_push($logs, $log);
        endwhile;

        return $logs;
    endif;

}

function geraHeaderWebLogTodos($dtInicio, $dtFim)
{
    $logs = [];
    $conexao = bancoMysqli();

    $query = "SELECT 
               log.idWebLog, 
               log.tabela, 
               log.acao, 
               log.idRegistro,
               log.dataOcorrencia,                
               fn_busca_registro
                 (log.documento, log.idRegistro,
                  log.idCronograma, log.tabela) AS alteradoPor,                  

                 (SELECT 
                  nomeProjeto 
                 FROM 
                   projeto AS P
                 WHERE P.idProjeto = log.idRegistro) AS nomePo,

                 (SELECT 
                  nomeProjeto 
                 FROM 
                   projeto AS p
                 INNER JOIN cronograma AS c 
                 ON c.idCronograma = p.idCronograma
                 WHERE c.idCronograma = log.idCronograma LIMIT 1) AS crono                 

             FROM 
               weblogs AS log             
             WHERE log.dataOcorrencia >= '$dtInicio'
             AND   log.dataOcorrencia <= '$dtFim'
             ORDER BY idWeblog DESC";

    $resultado = mysqli_query($conexao, $query);

    if ($resultado):
        while ($log = mysqli_fetch_assoc($resultado)):
            array_push($logs, $log);
        endwhile;

        return $logs;
    endif;
}

function geraWebLogDetalhes($idWeblog)
{
    $logs = [];
    $conexao = bancoMysqli();

    $query = "SELECT 
               antes, 
               depois              
             FROM 
               weblogs AS log             
             WHERE idWebLog = " . $idWeblog;

    $resultado = mysqli_query($conexao, $query);

    while ($log = mysqli_fetch_assoc($resultado)) {
        array_push($logs, $log);
    }
    return $logs;
}

function retornaDados($logs, $tipo)
{
    foreach ($logs as $log):
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


function pr_atualizaCampos()
{
    mysqli_query(bancoMysqli(),
        "CALL  pr_atualizaCampos;");
}

function pr_limpa_registros()
{
    mysqli_query(bancoMysqli(),
        "CALL   pr_limpa_null;");

    mysqli_query(bancoMysqli(),
        "CALL  pr_exclui_iguais;");
}

function pegaUsuarioLogado()
{

    if (array_key_exists('tipoPessoa', $_SESSION)):

        if ($_SESSION['tipoPessoa'] == 1):
            $usuario = $usuarioPf = recuperaDados("pessoa_fisica", "idPf", $_SESSION['idUser']);

            return $usuario['nome'] . ' [ID=' . $usuario['idPf'] . ']';

        endif;

        $usuario = recuperaDados("pessoa_juridica", "idPj", $_SESSION['idUser']);

        return $usuario['razaoSocial'] . ' [ID=' . $usuario['idPj'] . ']';
    endif;
}

function pegaProjetoRepresentante($idProjeto)
{
    $conexao = bancoMysqli();

    $query = "
    SELECT 
      p.*, 
      rl.nome,
      rl.cpf, 
      rl.rg, 
      rl.logradouro, 
      rl.numero, 
      rl.bairro, 
      rl.cep, 
      rl.cidade, 
      rl.estado,
      rl.telefone, 
      rl.celular, 
      rl.email,
      pj.cooperativa      
    FROM projeto AS p  
    
    INNER JOIN pessoa_juridica AS pj
    ON pj.idPj = p.idPj
 
    INNER JOIN representante_legal AS rl
    ON rl.idRepresentanteLegal = pj.idRepresentanteLegal 
 
    WHERE p.idProjeto = " . $idProjeto;

    $resultado = mysqli_query($conexao, $query);
    return $pessoaFisica = mysqli_fetch_assoc($resultado);
}

function pegaProjetoPessoaFisica($idProjeto)
{
    $conexao = bancoMysqli();

    $query = "
    SELECT       
      pf.idPf,
      pf.nome,
      pf.cpf, 
      pf.rg, 
      pf.logradouro, 
      pf.numero, 
      pf.bairro, 
      pf.cep, 
      pf.cidade, 
      pf.estado,
      pf.telefone, 
      pf.celular, 
      pf.email,
      pf.cooperado
    FROM projeto AS p  
    
    INNER JOIN pessoa_fisica AS pf
    ON pf.idPf = p.idPf 
    WHERE p.idProjeto = " . $idProjeto;

    $resultado = mysqli_query($conexao, $query);
    return $pessoaFisica = mysqli_fetch_assoc($resultado);
}

function geraOpcaoComissao($temParecerista)
{
    $con = bancoMysqli();
    $sql = "SELECT * 
		FROM pessoa_fisica 
		WHERE (idNivelAcesso = '3' 
		OR idNivelAcesso = '4') 
		ORDER BY nome";
    $query = mysqli_query($con, $sql);
    if ($temParecerista == 0) {
        echo "<option value='null' selected>Selecione um parecerista</option>";
    }
    while ($user = mysqli_fetch_array($query)) {
        echo "<option value='" . $user['idPf'] . "'>" . $user['nome'] . "</option>";
    }
}

function recuperaUsuario($idPf)
{
    //retorna dados do usuário
    $recupera = recuperaDados('pessoa_fisica', $idPf, 'idPf');
    if ($recupera) {
        return $recupera;
    } else {
        return NULL;
    }
}

function uploadArquivo($idProjeto, $tipoPessoa, $pagina, $idListaDocumento, $idTipoUpload, $comissao = true)
{
    $server = "http://" . $_SERVER['SERVER_NAME'] . "/promac";
    $http = $server . "/pdf/";
    $con = bancoMysqli();
    /*
     * Início da listagem de arquivo
     */
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idProjeto'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1' AND list.idListaDocumento = '$idListaDocumento'";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($comissao) {
        echo '<div class="table-responsive list_info">
				<h6>Parecer Anexado</h6>';
        if ($linhas > 0) {
            $idParecerista = $con->query("SELECT idComissao FROM projeto WHERE idProjeto = '$idProjeto'")->fetch_assoc()['idComissao'];
            echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Data de Envio</td>
					<td>Status</td>
					<td></td>
				</tr>
			</thead>
			<tbody>";
            while ($arquivo = mysqli_fetch_array($query)) {
                echo "<tr>";
                echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['documento'], 0, 60, "...") . "</a></td>";
                $data = date_create($arquivo["dataEnvio"]);
                echo "<td class='list_description'>" . date_format($data, 'd/m/Y') . "</td>";

                if ($arquivo['idStatusDocumento'] != 3 && $_SESSION['idUser'] == $idParecerista) {
                    echo "<td class='list_description'>
								<select name='status' id='statusOpt' disabled>";
                    echo "<option>Selecione</option>";
                    geraOpcao('status_documento', $arquivo['idStatusDocumento']);
                    echo " </select>
							</td>";

                    echo "                        
						<td class='list_description'>
							<form id='apagarArq' method='POST' action='?perfil=" . $pagina . "'>
								<input type='hidden' name='idPessoa' value='" . $idProjeto . "' />
								<input type='hidden' name='tipoPessoa' value='" . $tipoPessoa . "' />
								<input type='hidden' name='apagar' value='" . $arquivo['idUploadArquivo'] . "'/>	
								<input style='margin-top: 10px' type='submit' class='btn btn-theme btn-md btn-block'  value='apagar' />
							</form>
						</td>";
                }
                echo "</tr>";
            }
            echo "
		</tbody>
		</table>";
        } else {
            echo "<p id='ofilhoeseu'>Não há arquivo(s) inserido(s).</p><br/>";
            echo "<span style='color: #ff0000'><strong><i>Obrigatório anexar parecer antes de encaminhar à SMC.</i></strong></span>";
        }

        echo "</div>";
    }
    echo '<div class="table-responsive list_info"><h6>Upload de Parecer (somente em PDF)</h6>';

    $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '$idTipoUpload' AND idListaDocumento = '$idListaDocumento'";
    $query_arquivos = mysqli_query($con, $sql_arquivos);
    while ($arq = mysqli_fetch_array($query_arquivos)) {
        echo "<tr>";
        $doc = $arq['documento'];
        $query = "SELECT idListaDocumento FROM lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='$idTipoUpload'";
        $envio = $con->query($query);
        $row = $envio->fetch_array(MYSQLI_ASSOC);

        if ($idListaDocumento != 48) {
            if (verificaArquivosExistentesPF($idProjeto, $row['idListaDocumento'])) {
                echo '<div class="alert alert-success">O arquivo ' . $doc . ' já foi enviado.</div>';
            }
        }
        echo '<form method="POST" action="?perfil=' . $pagina . '" enctype="multipart/form-data">
		<table class="table table-condensed">
			<tr class="list_menu">
				<td>Tipo de Arquivo</td>
				<td></td>
			</tr>';
        $urlArquivo = $http . $arq['idListaDocumento'];
        if (arquivosExiste($urlArquivo)) {
            echo '<td class="list_description path">';
            $path = selecionaArquivoAnexo($http, $arq['idListaDocumento']);
            echo "<a href='" . $path . "'target='_blank'>" . $arq['documento'] . "</a>
				</td>";
        } else {
            echo "<td class='list_description path'>" . $arq['documento'] . "</td>";
        }
        echo "<td class='list_description'><input type='file' required name='arquivo[" . $arq['sigla'] . "]'></td>";
        echo "</tr>";
        echo "</table><br>";
        echo "<input type='hidden' name='idPessoa' value='" . $idProjeto . "' />";
        echo "<input type='hidden' name='idTipoUpload' value='" . $idTipoUpload . "' />";
        echo "<input type='hidden' name='tipoPessoa' value='" . $tipoPessoa . "'  />";
        echo '<input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value="Fazer Upload">
		</form>	';
    }


    echo '</div>';

}

function listaNota($idPessoa, $idTipo, $interna)
{
    $con = bancoMysqli();
    $sql = "SELECT * FROM notas WHERE idPessoa = '$idPessoa' AND idTipo = '$idTipo' AND interna = '$interna'";
    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);
    if ($num > 0) {
        while ($campo = mysqli_fetch_array($query)) {
            echo "<li class='list-group-item' align='left'><strong>" . exibirDataHoraBr($campo['data']) . "</strong><br/>" . $campo['nota'] . "</li>";
        }
    } else {
        echo "<li class='list-group-item'>Não há notas disponíveis.</li>";
    }
}

function mensagem($tipo, $texto)
{
    return "
	    <div class=\"col-md-12\">
                <div class=\"box box-" . $tipo . " box-solid\">
                    <div class=\"box-header with-border\">
                        <h3 class=\"box-title\">" . $texto . "</h3>                        
                    </div>
                </div>
            </div>
	    ";
}

function dias_feriados($ano = null)
{
    if ($ano === null) {
        $ano = intval(date('Y'));
    }

    $pascoa = easter_date($ano); // Limite de 1970 ou após 2037 da easter_date PHP consulta http:www.php.net/manual/pt_BR/function.easter-date.php
    $dia_pascoa = date('j', $pascoa);
    $mes_pascoa = date('n', $pascoa);
    $ano_pascoa = date('Y', $pascoa);

    $feriados = array(
        // Tatas Fixas dos feriados Nacionail Basileiras
        mktime(0, 0, 0, 1, 1, $ano), // Confraternização Universal - Lei nº 662, de 06/04/49
        mktime(0, 0, 0, 4, 21, $ano), // Tiradentes - Lei nº 662, de 06/04/49
        mktime(0, 0, 0, 5, 1, $ano), // Dia do Trabalhador - Lei nº 662, de 06/04/49
        mktime(0, 0, 0, 9, 7, $ano), // Dia da Independência - Lei nº 662, de 06/04/49
        mktime(0, 0, 0, 10, 12, $ano), // N. S. Aparecida - Lei nº 6802, de 30/06/80
        mktime(0, 0, 0, 11, 2, $ano), // Todos os santos - Lei nº 662, de 06/04/49
        mktime(0, 0, 0, 11, 15, $ano), // Proclamação da republica - Lei nº 662, de 06/04/49
        mktime(0, 0, 0, 12, 25, $ano), // Natal - Lei nº 662, de 06/04/49
        // Feriados municipais de sp
        mktime(0, 0, 0, 7, 9, $ano),
        mktime(0, 0, 0, 11, 20, $ano),
        mktime(0, 0, 0, 1, 25, $ano),

        // These days have a date depending on easter
        mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48, $ano_pascoa), // 2ºferia Carnaval
        mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47, $ano_pascoa), // 3ºferia Carnaval
        mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2, $ano_pascoa), // 6ºfeira Santa
        mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60, $ano_pascoa), // Corpus Cirist
    );

    sort($feriados);

    return $feriados;
}

function limiteEnvioProjetos()
{
    $semanaAtual = date('W');
    $semana = recuperaDados('contagem_comissao', 'semana', $semanaAtual);
    $projetos = $semana['projetos'];

    $cont = 50 - $projetos;

    if ($cont <= 10) {
        echo "<div class='form-group'>
            <div class='alert alert-danger' role='alert'>
                <h5 class='alert-danger'>ATENÇÃO! JÁ FORAM ENVIADOS: $projetos PROJETOS PARA A COMISSÃO</h5>
                <h6 class='alert-danger'>MÁXIMO DE 50 PERMITIDOS</h6>
            </div>
        </div>";
    }
}

function retornaDadosAdicionais($idPessoa, $tipoPessoa)
{
    $con = bancoMysqli();

    if ($tipoPessoa == 2) {
        $pj = recuperaDados('pessoa_juridica', 'idPj', $idPessoa);
        $idPessoa = $pj['idRepresentanteLegal'];
    }

    $sql = "SELECT g.genero, e.etnia, lei_incentivo, nome_lei FROM pessoa_informacao_adicional AS pia
            INNER JOIN generos AS g ON pia.genero = g.id
            INNER JOIN etnias AS e ON pia.etnia = e.id
            WHERE tipo_pessoa_id = '$tipoPessoa' AND pessoa_id = '$idPessoa'";
    $informacoes = $con->query($sql);
    if ($informacoes->num_rows > 0) {
        return $informacoes->fetch_assoc();
    } else {
        return false;
    }
}

function in_array_r($needle, $haystack, $strict = false)
{
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }
    return false;
}

/**
 * <p>Transforma os registros de uma tabela em inputs tipo checkbox,
 * ajustados em duas colunas</p>
 * @param string $tabela
 * <p>Tabela para qual os registros deve ser os checkboxes.
 * <strong>Importante:</strong> o valor desta variável será
 * o valor do atributo <i>name</i> dos inputs</p>
 * @param string $tabelaRelacionamento
 * <p>Tabela de relacionamento onde deve procurar os valores
 * já cadastrados para determinado Evento / Atração</p>
 * @param string $colunaEntidadeForte
 * <p>Nome da coluna que representa a <strong>entidade forte</strong> na tabela de relacionamento</p>
 * @param null|int $idEntidadeForte [opcional]
 * <p>ID da entidade forte. <b>NULL</b> por padrão, quando informado,
 * busca os registros na tabela de relacionamento</p>
 * @param bool $publicado [opcional]
 * <p><b>FALSE</b> por padrão. Quando <b>TRUE</b>,
 * adiciona a clausula <i>"WHERE publicado = 1"
 * na listagem dos registros do checkbox</i></p>
 */
function geraCheckbox($tabela, $tabelaRelacionamento, $colunaEntidadeForte, $idEntidadeForte = null, $publicado = false)
{
    $con = bancoMysqli();
    $publicado = $publicado ? "WHERE publicado = '1'" : "";
    $sql = "SELECT * FROM $tabela $publicado ORDER BY 2";
    $consulta = $con->query($sql);

    // Parte do relacionamento
    $sqlConsultaRelacionamento = "SELECT * FROM $tabelaRelacionamento WHERE $colunaEntidadeForte = '$idEntidadeForte'";
    $relacionamentos = $con->query($sqlConsultaRelacionamento)->fetch_all(MYSQLI_ASSOC);

    foreach ($consulta->fetch_all(MYSQLI_NUM) as $checkbox) {
        foreach ($relacionamentos as $key => $item) {
            if (isset($item[$colunaEntidadeForte])) {
                unset($relacionamentos[$key][$colunaEntidadeForte]);
            }
        }
        ?>
        <div class='checkbox-grid-2'>
            <div class='checkbox'>
                <label>
                    <input class='<?= $tabela ?>' type='checkbox' name='<?= $tabela ?>[]'
                           value='<?= $checkbox[0] ?>'
                           <?= in_array_r($checkbox[0], $relacionamentos) ? "checked" : "" ?>
                           data-check="<?= $checkbox[1] ?>"> <?= $checkbox[1] ?>
                </label>
            </div>
        </div>
        <?php
    }
}

/**
 * Verifica a tabela de relacionamento passada e atualiza conforme os dados informados
 * @param string $tabela <p>Nome da tabela de relacionamento</p>
 * @param string $entidadeForte <p>Nome da coluna que representa a entidade forte <i>(tabela principal)</i></p>
 * @param int $idEntidadeForte <p>ID da entidade forte</p>
 * @param string $entidadeFraca <p>Nome da coluna que representa a entidade fraca <i>(tabela auxiliar)</i></p>
 * @param int|array $idsEntidadeFraca <p>Array com os IDs da entidade fraca</p>
 * @return bool
 */
function atualizaRelacionamento($tabela, $entidadeForte, $idEntidadeForte, $entidadeFraca, $idsEntidadeFraca)
{
    $con = bancoMysqli();
    /* Consulta a tabela de relacionamento
    para verificar se existe algum registro
    para a entidade forte informada */
    $sqlConsultaRelacionamento = "SELECT $entidadeFraca FROM $tabela WHERE $entidadeForte = '$idEntidadeForte'";
    $relacionamento = $con->query($sqlConsultaRelacionamento);

    /* Se não existe nenhum registro,apenas insere um para cada id de entidade fraca */
    if ($relacionamento->num_rows == 0) {
        /* Verifica se o ID da entidade fraca está em um array */
        if (is_array($idsEntidadeFraca)) {
            foreach ($idsEntidadeFraca as $checkbox) {
                $dadosInsert = [
                    $entidadeForte => $idEntidadeForte,
                    $entidadeFraca => $checkbox
                ];
                $sqlInsert = "INSERT INTO $tabela (" . implode(', ', array_keys($dadosInsert)) . ") VALUES (" . implode(', ', $dadosInsert) . ")";
                $insert = $con->query($sqlInsert);
                if (!$insert) {
                    return false;
                }
            }
        } else {
            $dadosInsert = [
                $entidadeForte => $idEntidadeForte,
                $entidadeFraca => $idsEntidadeFraca
            ];
            $sqlInsert = "INSERT INTO $tabela (" . implode(', ', array_keys($dadosInsert)) . ") VALUES (" . implode(', ', $dadosInsert) . ")";
            $insert = $con->query($sqlInsert);
            if (!$insert) {
                return false;
            }
        }
        return true;
    } else {
//        $relacionamentos = $relacionamento->fetchAll(PDO::FETCH_COLUMN);
        $queryRelacionamentos = $relacionamento->fetch_all(MYSQLI_ASSOC);
        foreach ($queryRelacionamentos as $valor) {
            $relacionamentos[] = $valor[$entidadeFraca];
        }
        /* Se existe registros, primeiro, verifica se
        na tabela existe algum que não tenha sido
        passado nos IDs da entidade fraca.
        Cada registro que não possui ID passado é excluído */
        if (is_array($idsEntidadeFraca)) {
            foreach ($relacionamentos as $item) {
                if (!in_array($item, $idsEntidadeFraca)) {
                    $delete = $con->query("DELETE FROM $tabela WHERE $entidadeForte = '$idEntidadeForte' AND $entidadeFraca = $item");
                    if (!$delete) {
                        return false;
                    }
                }
            }

            /* Após excluir os registros que não possuem ID passado,
            verifica se dos IDs informados, existe algum que não
            tenha registro. Caso sim, insere um novo */
            foreach ($idsEntidadeFraca as $checkbox) {
                if (!in_array($checkbox, $relacionamentos)) {
                    $dadosInsert = [
                        $entidadeForte => $idEntidadeForte,
                        $entidadeFraca => $checkbox
                    ];
                    $sqlInsertNovo = "INSERT INTO $tabela (" . implode(', ', array_keys($dadosInsert)) . ") VALUES (" . implode(', ', $dadosInsert) . ")";
                    $insertNovo = $con->query($sqlInsertNovo);
                    if (!$insertNovo) {
                        return false;
                    }
                }
            }
        } else {
            if (!in_array($idsEntidadeFraca, $relacionamentos)) {
                $delete = $con->query("DELETE FROM $tabela WHERE $entidadeForte = '$idEntidadeForte'");
                if (!$delete) {
                    return false;
                }
                $dadosInsert = [
                    $entidadeForte => $idEntidadeForte,
                    $entidadeFraca => $idsEntidadeFraca
                ];
                $sqlInsert = "INSERT INTO $tabela (" . implode(', ', array_keys($dadosInsert)) . ") VALUES (" . implode(', ', $dadosInsert) . ")";
                $insert = $con->query($sqlInsert);
                if (!$insert) {
                    return false;
                }
            }
        }
        return true;
    }
}

/**
 * <p>Função responsável por recuperar os planos e atividades cadastrados em Banco de Dados</p>
 * <p>Cria uma <i>table</i> onde cada plano gera uma linha e para cada atividade deste plano,
 * linhas são mescladas com a primeira coluna</p>
 * @param int $idProjeto
 * @param bool $edicao [opcional]
 * <p>Default <i>FALSE</i> - Quando <i>TRUE</i>, habilita os botões de inserção e remoção de atividades</p>
 */
function recuperaPlanos($idProjeto, $edicao = false)
{
    $con = bancoMysqli();
    $queryPlano = $con->query("SELECT * FROM planos WHERE projeto_id = '$idProjeto' AND publicado = '1'");
    if ($queryPlano->num_rows > 0) {
        $style = "style='width: 100%'";
        ?>
        <table class="table-condensed table-responsive table-bordered" <?= $edicao ? "" : $style ?>>
            <thead>
            <tr>
                <th>Objetivo Específico</th>
                <th>Atividade</th>
                <th>Responsável</th>
                <th>Produto</th>
                <th width="15%">Etapa</th>
                <?php if ($edicao): ?>
                    <th width="10%" colspan="3" class="text-center">Ações</th>
                <?php endif ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $planos = $queryPlano->fetch_all(MYSQLI_ASSOC);
            foreach ($planos as $plano) {
                $queryAtividades = $con->query("SELECT * FROM plano_atividades WHERE plano_id = '{$plano['id']}' AND publicado = '1'");
                $numAtividades = $queryAtividades->num_rows;
                if ($numAtividades > 0) {
                    $rowspan = "rowspan='$numAtividades'";
                    $atividades = $queryAtividades->fetch_all(MYSQLI_ASSOC);
                    $etapa = recuperaDados('etapa_planos', 'id', $atividades[0]['etapa_planos_id'])['etapa'];
                } else {
                    $rowspan = "";
                    $atividades = [];
                }
                ?>
                <tr>
                    <td <?= $rowspan ?> class="objetivo"><?= $plano['objetivo_especifico'] ?></td>
                    <?php if ($numAtividades > 0): ?>
                        <td class="atividade"><?= $atividades[0]['atividade'] ?></td>
                        <td class="responsavel"><?= $atividades[0]['responsavel'] ?></td>
                        <td class="produto"><?= $atividades[0]['produto'] ?></td>
                        <td class="etapa"><?= $etapa ?></td>
                        <?php if ($edicao): ?>
                            <td>
                                <button class="btn btn-sm btn-theme" data-toggle="modal" data-target="#novaAtividade"
                                        data-btn="editaAtividade" data-etapa="<?= $atividades[0]['etapa_planos_id'] ?>"
                                        data-id="<?= $atividades[0]['id'] ?>">
                                    Editar Atividade
                                </button>
                            </td>
                            <td>
                                <button class='btn btn-sm btn-theme' type='button'
                                        onclick="modalApagar(
                                                '#apagarPlanoAtividade',
                                                '<?= $atividades[0]['atividade'] ?>',
                                                '<?= $atividades[0]['id'] ?>',
                                                'apagaAtividade')">Remover Atividade
                                </button>
                            </td>
                        <?php endif;
                        unset($atividades[0]);
                    else: ?>
                        <td colspan="6" class="text-center">Nenhuma Atividade Cadastrada</td>
                    <?php endif;
                    if ($edicao): ?>
                        <td <?= $rowspan ?> class="text-center">
                            <button class='btn btn-theme form-control' type='button' data-toggle="modal"
                                    data-target="#novaAtividade" data-id="<?= $plano['id'] ?>">
                                Adicionar Atividade
                            </button>

                            <button class='btn btn-theme mar-top10 form-control' type='button'
                                    onclick="modalApagar(
                                            '#apagarPlanoAtividade',
                                            '<?= $plano['objetivo_especifico'] ?>',
                                            '<?= $plano['id'] ?>', 'apagaObjetivo')
                                            ">
                                Remover Objetivo
                            </button>

                            <button class='btn btn-theme mar-top10 form-control' data-toggle="modal"
                                    data-target="#novoObjetivo" data-btn="editaObjetivo" data-id="<?= $plano['id'] ?>">
                                Editar Objetivo
                            </button>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php
                if ($numAtividades > 0 && count($atividades) >= 1):
                    foreach ($atividades as $atividade) {
                        $etapa = recuperaDados('etapa_planos', 'id', $atividade['etapa_planos_id'])['etapa'];
                        ?>
                        <tr>
                            <td class="atividade"><?= $atividade['atividade'] ?></td>
                            <td class="responsavel"><?= $atividade['responsavel'] ?></td>
                            <td class="produto"><?= $atividade['produto'] ?></td>
                            <td class="etapa"><?= $etapa ?></td>
                            <?php if ($edicao): ?>
                                <td>
                                    <button class="btn btn-sm btn-theme" data-toggle="modal"
                                            data-target="#novaAtividade"
                                            data-btn="editaAtividade" data-etapa="<?= $atividade['etapa_planos_id'] ?>"
                                            data-id="<?= $atividade['id'] ?>">
                                        Editar Atividade
                                    </button>
                                </td>
                                <td>
                                    <button class='btn btn-sm btn-theme' type='button'
                                            onclick="modalApagar(
                                                    '#apagarPlanoAtividade',
                                                    '<?= $atividade['atividade'] ?>',
                                                    '<?= $atividade['id'] ?>',
                                                    'apagaAtividade')">Remover Atividade
                                    </button>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <?php
                    }
                endif;
            }
            ?>
            </tbody>
        </table>
        <?php
    } else {
        if ($edicao): ?>
            <div class="col-md-offset-2 col-md-8">
                <div class="alert alert-info">Não há registros cadastrados</div>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Não há registros cadastrados</div>
        <?php endif;
    }
}

/**
 * @param int $idProjeto
 */
function recuperaTabelaOrcamento($idProjeto)
{
    $con = bancoMysqli();
    ?>
    <table class="table table-bordered">
        <tr>
            <?php
            $colunas = $con->query("SELECT * FROM grupo_despesas")->num_rows;
            for ($i = 1; $i <= $colunas; $i++) {
                $sql_etapa = "SELECT grupo_despesas_id FROM orcamento
                    WHERE publicado > 0 AND idProjeto ='$idProjeto' AND grupo_despesas_id = '$i'
                    ORDER BY idOrcamento";
                $query_etapa = mysqli_query($con, $sql_etapa);
                $lista = mysqli_fetch_array($query_etapa);

                if ($lista == null) {
                    echo "<td><strong></strong>";
                } else {
                    $despesa = recuperaDados("grupo_despesas", "id", $lista['grupo_despesas_id']);
                    echo "<td><strong>" . $despesa['despesa'] . ":</strong>";
                }
            }
            ?>
        </tr>
        <tr>
            <?php
            for ($i = 1; $i <= $colunas; $i++) {
                $sql_etapa = "SELECT SUM(valorTotal) AS tot FROM orcamento
                    WHERE publicado > 0 AND idProjeto ='$idProjeto' AND grupo_despesas_id = '$i'
                    ORDER BY idOrcamento";
                $query_etapa = mysqli_query($con, $sql_etapa);
                $lista = mysqli_fetch_array($query_etapa);

                echo "<td>R$ " . dinheiroParaBr($lista['tot']) . "</td>";
            }
            ?>
        </tr>
        <tr>
            <?php
            $sql_total = "SELECT SUM(valorTotal) AS tot FROM orcamento
                        WHERE publicado > 0 AND idProjeto ='$idProjeto'
                        ORDER BY idOrcamento";
            $query_total = mysqli_query($con, $sql_total);
            $total = mysqli_fetch_array($query_total);
            echo "<td colspan='$colunas'><strong>TOTAL: R$ " . dinheiroParaBr($total['tot']) . "</strong></td>";
            ?>
        </tr>
    </table>
    <?php
}

function recuperaMaterial($idProjeto, $edicao = false)
{
    $con = bancoMysqli();
    $queryMaterial = $con->query("SELECT * FROM material_divulgacao WHERE projeto_id = '$idProjeto' AND publicado = '1'");
    if ($queryMaterial->num_rows > 0) {
        $style = "style='width: 100%'";
        ?>
    <table id="tbMaterial" class="table-condensed table-responsive table-bordered" <?= $edicao ? "" : $style ?>>
        <thead>
    <tr>
        <th>Material de Divulgação</th>
        <th>Quantidade</th>
        <th>Formato</th>
        <th>Onde será veiculado/divulgado</th>
        <?php
        if ($edicao):
            ?>
            <th>Ações</th>
            <?php
                endif;
            ?>
            </tr>
            </thead>
            <tbody>
            <?php
            $materiais = $queryMaterial->fetch_all(MYSQLI_ASSOC);
            foreach ($materiais as $material) {
                ?>
                <tr>
                    <td><?= $material['material_divulgacao'] ?></td>
                    <td><?= $material['quantidade'] ?></td>
                    <td><?= $material['formato'] ?></td>
                    <td><?= $material['veiculo_divulgacao'] ?></td>
                    <?php
                if ($edicao):
                    ?>
                    <td>
                        <input type="hidden" id="idMat" value="<?= $material['idMaterial'] ?>">
                        <button class="btn btn-theme" type="button" class="btn btn-theme btn-lg btn-block"
                                data-toggle="modal" data-target="#novoMaterial">Editar
                        </button>
                        <button class="btn btn-theme" data-toggle="modal" data-target="#apagarMaterial"
                                onclick="prrencherModalApagar(<?= $material['idMaterial'] ?>)">Apagar
                        </button>
                    </td>
                <?php endif; ?>
                </tr>
            <?php }
            ?>
            </tbody>
            </table>
            <?php
        } else {
        ?>
        <div class="row">
            <span class="text-center"> Nenhum material de divulgação cadastrado.</span>
        </div>
        <?php
    }

}

function recuperaTags($idProjeto)
{
    $con = bancoMysqli();
    $sqlTags = "SELECT t.tag FROM projeto_tag AS pt
                INNER JOIN tags AS t ON pt.tag_id = t.id
                WHERE pt.projeto_id = '$idProjeto'";
    $queryTags = $con->query($sqlTags)->fetch_all(MYSQLI_ASSOC);
    foreach ($queryTags as $tag) {
        $tags[] = $tag['tag'];
    }

    return $tags;
}
?>