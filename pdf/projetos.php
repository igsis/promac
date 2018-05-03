<?php
//require '../include/';
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");
require_once("../include/phpexcel/Classes/PHPExcel.php");

//CONEXÃO COM BANCO DE DADOS
$con = bancoMysqli();

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
$cacheSettings = array( ' memoryCacheSize ' => '8MB');
PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
$objPHPExcel->getProperties()->setCreator("Sistema Pro-Mac");
$objPHPExcel->getProperties()->setLastModifiedBy("Sistema Pro-Mac");
$objPHPExcel->getProperties()->setTitle("Relatório de Projetos");
$objPHPExcel->getProperties()->setSubject("Relatório de Projetos");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema Pro-Mac");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Projetos");

//Dados
$sql = "SELECT * FROM projeto";
$query = mysqli_query($con,$sql);

$i = 2; // para começar a gravar os dados na segunda linha
while($row = mysqli_fetch_array($query))
{
  $a = "A".$i;
  $b = "B".$i;
  $c = "C".$i;
  $d = "D".$i;
  $e = "E".$i;
  $f = "F".$i;
  $g = "G".$i;
  $h = "H".$i;
  $I = "I".$i;
  $j = "J".$i;
  $k = "K".$i;
  $l = "L".$i;
  $m = "M".$i;
  $n = "N".$i;
  $o = "O".$i;
  $p = "P".$i;
  $q = "Q".$i;
  $r = "R".$i;
  $s = "S".$i;
  $t = "T".$i;
  $u = "U".$i;
  $v = "V".$i;
  $w = "W".$i;
  $x = "X".$i;
  $y = "Y".$i;
  $z = "Z".$i;
  $i++;

  $idP = $row['idProjeto'];/*
  $queryL = "SELECT local, estimativaPublico FROM locais_realizacao WHERE idProjeto = '$idP'";
  $enviaL = mysqli_query($con, $idP);
  if (!$enviaL) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
  }*/
  $queryL = "SELECT local, estimativaPublico FROM locais_realizacao WHERE idProjeto = '$idP'";
  $enviaL = mysqli_query($con, $idP);
  while($rowL = mysqli_fetch_array($enviaL))
  {
    $localR = $rowL['local'];
    $estimativaP = $rowL['estimativaPublico'];
  }

  $queryR = "SELECT idZona FROM locais_realizacao WHERE idProjeto = '$idP'";
  $idZona = mysqli_query($con, $queryR);
  while($idz = mysqli_fetch_array($idZona))
  {
    $idZZ = $idz['idZona'];
      $queryZ = "SELECT zona FROM zona WHERE idZona = '$idZZ'";
      $enviaZ = mysqli_query($con, $queryZ);
      while($zonas = mysqli_fetch_array($enviaZ))
      {
          $zonaString = $zonas['zona'];
      }
  }



  $queryF = "SELECT nome FROM ficha_tecnica WHERE idProjeto = '$idP'";
  $enviaF = mysqli_query($con, $queryF);
  while($fichaS = mysqli_fetch_array($enviaF))
  {
    $ficha = $fichaS['nome'];
  }

  $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Nome do projeto')
    ->setCellValue('B1', 'Valor total')
    ->setCellValue('C1', 'Valor incentivo')
    ->setCellValue('D1', 'Resumo')
    ->setCellValue('E1', 'Local')
    ->setCellValue('F1', 'Público estimado')
    ->setCellValue('G1', 'Zona')
    ->setCellValue('H1', 'Público alvo')
    ->setCellValue('I1', 'Ficha técnica');

  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue($a, $row['nomeProjeto'])
              ->setCellValue($b, $row['valorFinanciamento']+$row['valorIncentivo'])
              ->setCellValue($c, $row['valorIncentivo'])
              ->setCellValue($d, $row['resumoProjeto'])
              ->setCellValue($e, $localR)
              ->setCellValue($f, $estimativaP)
              ->setCellValue($g, $zonaString)
              ->setCellValue($h, $row['publicoAlvo'])
              ->setCellValue($I, $ficha);


  $objPHPExcel->setActiveSheetIndex(0)
              ->setCellValue('J1', 'Nome/Razão Social')
              ->setCellValue('K1', 'CPF/CNPJ')
              ->setCellValue('L1', 'Logradouro')
              ->setCellValue('M1', 'Número')
              ->setCellValue('N1', 'Complemento')
              ->setCellValue('O1', 'Bairro')
              ->setCellValue('P1', 'Cidade')
              ->setCellValue('Q1', 'Estado')
              ->setCellValue('R1', 'CEP');

  $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true); //negrito
  $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('N1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('P1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('Q1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('R1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('S1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('T1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('U1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('V1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('X1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('W1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('Y1')->getFont()->setBold(true);
  $objPHPExcel->getActiveSheet()->getStyle('Z1')->getFont()->setBold(true);

  //Colorir a primeira fila
  $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray(
     array(
        'fill' => array(
           'type' => PHPExcel_Style_Fill::FILL_SOLID,
           'color' => array('rgb' => 'E0EEEE')
        ),
     )
  );
   if($row['tipoPessoa'] == 1)
   {
     $idPFF = $row['idProjeto'];

     $queryPF = "SELECT * FROM pessoa_fisica WHERE idPf = '$idPFF'";
     $enviaPF = mysqli_query($con, $queryPF);

     // Add some data
     while($rowPF = mysqli_fetch_array($enviaPF))
     {
       $objPHPExcel->setActiveSheetIndex(0)
                   ->setCellValue($j, $rowPF['nome'])
                   ->setCellValue($k, $rowPF['cpf'])
                   ->setCellValue($l, $rowPF['logradouro'])
                   ->setCellValue($m, $rowPF['numero'])
                   ->setCellValue($n, $rowPF['complemento'])
                   ->setCellValue($o, $rowPF['bairro'])
                   ->setCellValue($p, $rowPF['cidade'])
                   ->setCellValue($q, $rowPF['estado'])
                   ->setCellValue($r, $rowPF['cep']);
        }
    }
   else if($row['tipoPessoa'] == 2)
   {
       $idPJ = $row['idPj'];

      $queryPJ = "SELECT * FROM pessoa_juridica WHERE idPj = '$idPJ'";
      $enviaPJ = mysqli_query($con, $queryPJ);

      $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('S1', 'Representante')
                  ->setCellValue('T1', 'CPF')
                  ->setCellValue('U1', 'Logradouro')
                  ->setCellValue('V1', 'Número')
                  ->setCellValue('X1', 'Complemento')
                  ->setCellValue('W1', 'Bairro')
                  ->setCellValue('Y1', 'Cidade')
                  ->setCellValue('Z1', 'Estado');

        while($rowPJ = mysqli_fetch_array($enviaPJ))
        {
          $idRepresentante = $rowPJ['idRepresentanteLegal'];
          $queryRep = "SELECT * from representante_legal WHERE idRepresentanteLegal = '$idRepresentante'";
          $enviaRep = mysqli_query($con, $queryRep);

          while($rowRep = mysqli_fetch_array($enviaRep))
          {
            $objPHPExcel->setActiveSheetIndex(0)
                      ->setCellValue($s, $rowRep['nome'])
                      ->setCellValue($t, $rowRep['cpf'])
                      ->setCellValue($u, $rowRep['logradouro'])
                      ->setCellValue($v, $rowRep['numero'])
                      ->setCellValue($x, $rowRep['complemento'])
                      ->setCellValue($w, $rowRep['bairro'])
                      ->setCellValue($y, $rowRep['cidade'])
                      ->setCellValue($z, $rowRep['estado']);
          }
          $objPHPExcel->setActiveSheetIndex(0)
                      ->setCellValue($j, $rowPJ['razaoSocial'])
                      ->setCellValue($k, $rowPJ['cnpj'])
                      ->setCellValue($l, $rowPJ['logradouro'])
                      ->setCellValue($m, $rowPJ['numero'])
                      ->setCellValue($n, $rowPJ['complemento'])
                      ->setCellValue($o, $rowPJ['bairro'])
                      ->setCellValue($p, $rowPJ['cidade'])
                      ->setCellValue($q, $rowPJ['estado'])
                      ->setCellValue($r, $rowPJ['cep']);

           }
    }
}
foreach (range('A', $objPHPExcel->getActiveSheet()->getHighestDataColumn()) as $col)
{
   $objPHPExcel->getActiveSheet()
               ->getColumnDimension($col)
               ->setAutoSize(true);
}

$objPHPExcel->setActiveSheetIndex(0);
ob_end_clean();
    ob_start();

$nome_arquivo = date("Y-m-d")."_projeto.xls";

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: text/html; charset=ISO-8859-1');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$nome_arquivo.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>
