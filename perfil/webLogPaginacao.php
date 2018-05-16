<?php 
  $logsTotal = geraHeaderWebLog(); 

  $pagina = isset($_GET['pagina'])
    ? $_GET['pagina']
    : 1;

  $totalRegistros = sizeof($logsTotal);
  $qtdRegistrosPorPag = 10;
  $numPaginas = ceil($totalRegistros/$qtdRegistrosPorPag); 

  $inicio = $qtdRegistrosPorPag*$pagina-$qtdRegistrosPorPag;
  $logs = webLogPaginacao($inicio, $qtdRegistrosPorPag); 