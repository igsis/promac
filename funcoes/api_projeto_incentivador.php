<?php
include "../funcoes/funcoesConecta.php";

$con = bancoMysqli();
//mysqli_set_charset($con,"utf8");

$projetos = [];

$sql = "SELECT  idProjeto,
                nomeProjeto,
                agencia,
                contaCaptacao,
                contaMovimentacao              
		FROM projeto
		WHERE publicado = 1
        ORDER BY nomeProjeto";
        
$res = mysqli_query($con,$sql);

while ( $row = mysqli_fetch_array( $res ) ) {
    $projetos[] = [
        'idProjeto'	        => $row['idProjeto'],
        'nomeProjeto'	    => $row['nomeProjeto'],
        'agencia'	        => $row['agencia'],
        'contaCaptacao' 	=> $row['contaCaptacao'],
        'contaMovimentacao'	=> $row['contaMovimentacao'],
    ];
}

echo( json_encode( $projetos ) );