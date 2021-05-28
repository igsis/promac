<?php

@ini_set('display_errors', '1');
error_reporting(E_ALL); 

require_once "../funcoes/funcoesConecta.php";
$path = "../../promac/uploadsdocs/";

$con = bancoMysqli();
$idPessoa = $_GET['idPessoa'];
$tipoPessoa = $_GET['tipo'];

$sql = "SELECT * FROM upload_arquivo WHERE idPessoa = '$idPessoa' AND idTipo = '$tipoPessoa' AND publicado = '1'";
$query = mysqli_query($con,$sql);
$data = date('YmdHis');
$nome_arquivo = $data.".zip";


// Criando o objeto
$z = new ZipArchive();

// Criando o pacote chamado "teste.zip"
$criou = $z->open($nome_arquivo, ZipArchive::CREATE);
if ($criou === true)
{
    // Criando um diretorio chamado "teste" dentro do pacote
    //$z->addEmptyDir('teste');

    // Criando um TXT dentro do diretorio "teste" a partir do valor de uma string
    //$z->addFromString('teste/texto.txt', 'Conteúdo do arquivo de Texto');

    // Criando outro TXT dentro do diretorio "teste"
    //$z->addFromString('teste/outro.txt', 'Outro arquivo');

    // Copiando um arquivo do HD para o diretorio "teste" do pacote
	while($arquivo = mysqli_fetch_array($query))
	{
		$file = $path.$arquivo['arquivo'];
		$file2 = $arquivo['arquivo'];
    	$z->addFile($file, $file2);
	}
    // Apagando o segundo TXT
    //$z->deleteName('teste/outro.txt');

    // Salvando o arquivo
    $z->close();

	//SETANDO OS HEADERS NECESSARIOS
	// Enviando para o cliente fazer download
	// Configuramos os headers que serão enviados para o browser
	header('Content-Description: File Transfer');
	header('Content-Disposition: attachment; filename="'.$nome_arquivo.'"');
	header('Content-Type: application/octet-stream');
	header('Content-Transfer-Encoding: binary');
	header('Content-Length: ' . filesize($nome_arquivo));
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Expires: 0');
	// Envia o arquivo para o cliente
	//echo $nome_arquivo;
	ob_end_clean(); //essas duas linhas antes do readfile
	flush();

	readfile($nome_arquivo);

	//ABRINDO O ARQUIVO
}
else
{
    echo 'Erro: '.$criou;
}
?>