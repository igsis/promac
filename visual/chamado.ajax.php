<?php
//Imprime erros com o banco
@ini_set('display_errors', '1');
error_reporting(E_ALL);

//header( 'Cache-Control: no-cache' );
//header( 'Content-type: application/xml; charset="utf-8"', true );

$con = mysqli_connect('localhost','root','','igsis');
//mysqli_set_charset($con,"utf8");

$cod = mysqli_real_escape_string( $con,$_GET['tipoChamado'] );


switch($cod){

case 1:
$cidades = array(
	
);



$sql = "SELECT *
		FROM igsis_chamado
		WHERE idTipoChamado = '$cod'
		ORDER BY espaco";
$res = mysqli_query($con,$sql);

while ( $row = mysqli_fetch_array( $res ) ) {
	$cidades[] = array(
		'id'	=> $row['idEspaco'],
		'select'			=> (utf8_encode($row['espaco'])),
	);
}

echo( json_encode( $cidades ) );
break;

case 2:

break;
case 3:

break;


}
?>