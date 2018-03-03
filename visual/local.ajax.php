<?php
//Imprime erros com o banco
@ini_set('display_errors', '1');
error_reporting(E_ALL);

//header( 'Cache-Control: no-cache' );
//header( 'Content-type: application/xml; charset="utf-8"', true );

$con = mysqli_connect('200.237.5.34','root','lic54eca','igsis');
//mysqli_set_charset($con,"utf8");

$cod = mysqli_real_escape_string( $con,$_GET['instituicao'] );

$cidades = array();

$sql = "SELECT *
		FROM ig_local
		WHERE idInstituicao = '$cod'
		ORDER BY sala";
$res = mysqli_query($con,$sql);

while ( $row = mysqli_fetch_array( $res ) ) {
	$cidades[] = array(
		'idEspaco'	=> $row['idLocal'],
		'espaco'			=> (utf8_encode($row['sala'])),
	);
}

echo( json_encode( $cidades ) );

?>