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
$objPHPExcel->getProperties()->setTitle("Relatório de Pessoa Jurídica");
$objPHPExcel->getProperties()->setSubject("Relatório de Pessoa Jurídica");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema Pro-Mac");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Pessoa Jurídica");

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Razão Social')
            ->setCellValue('B1', 'CNPJ')
            ->setCellValue('C1', 'Logradouro')
            ->setCellValue('D1', 'Nº')
            ->setCellValue('E1', 'Complemento')
            ->setCellValue('F1', 'Bairro')
            ->setCellValue('G1', 'Cidade')
            ->setCellValue('H1', 'Estado')
            ->setCellValue('I1', 'CEP')
            ->setCellValue('J1', 'Telefone')
            ->setCellValue('K1', 'Celular')
            ->setCellValue('L1', 'E-mail')
            ->setCellValue('M1', 'Cooperativa')
            ->setCellValue('N1', 'Representante')
            ->setCellValue('O1', 'CPF')
            ->setCellValue('P1', 'RG')
            ->setCellValue('Q1', 'Logradouro')
            ->setCellValue('R1', 'Nº')
            ->setCellValue('S1', 'Complemento')
            ->setCellValue('T1', 'Bairro')
            ->setCellValue('U1', 'Cidade')
            ->setCellValue('V1', 'Estado')
            ->setCellValue('W1', 'CEP')
            ->setCellValue('X1', 'Telefone')
            ->setCellValue('Y1', 'Celular')
            ->setCellValue('Z1', 'E-mail')
            ->setCellValue('AA1', 'Status')
            ->setCellValue('AB1', 'Data da Inscrição');

//Colorir a primeira fila
$objPHPExcel->getActiveSheet()->getStyle('A1:AB1')->applyFromArray(
   array(
      'fill' => array(
         'type' => PHPExcel_Style_Fill::FILL_SOLID,
         'color' => array('rgb' => 'E0EEEE')
      ),
   )
);


//Dados
$sql = "SELECT * FROM pessoa_juridica ORDER BY razaoSocial";
$query = mysqli_query($con,$sql);

$i = 2; // para começar a gravar os dados na segunda linha
while($row = mysqli_fetch_array($query))
{
   if($row['cooperativa'] == 1)
      $cooperativa = 'Sim';
   else
      $cooperativa = 'Não';

   if(($row['liberado'] == 0) || ($row['liberado'] == NULL))
   {
      $status = "Em Elaboração";
   }
   elseif ($row['liberado'] == 1)
   {
      $status = "Liberação Solicitada";
   }
   elseif ($row['liberado'] == 2)
   {
      $status = "Proponente Reprovado";
   }
   elseif ($row['liberado'] == 3)
   {
      $status = "Proponente Aprovado";  
   }
   else
   {
      $status = "Cadastro Liberado para Edição";
   }
   $dataInscricao = $row['dataInscricao'];
   $dataInscricao = retornaDataSemHora($dataInscricao);

   $rl = recuperaDados("representante_legal","idRepresentanteLegal",$row['idRepresentanteLegal']);

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
   $aa = "AA".$i;
   $ab = "AB".$i;

   $objPHPExcel->setActiveSheetIndex(0)
               ->setCellValue($a, $row['razaoSocial'])
               ->setCellValue($b, $row['cnpj'])
               ->setCellValue($c, $row['logradouro'])
               ->setCellValue($d, $row['numero'])
               ->setCellValue($e, $row['complemento'])
               ->setCellValue($f, $row['bairro'])
               ->setCellValue($g, $row['cidade'])
               ->setCellValue($h, $row['estado'])
               ->setCellValue($I, $row['cep'])
               ->setCellValue($j, $row['telefone'])
               ->setCellValue($k, $row['celular'])
               ->setCellValue($l, $row['email'])
               ->setCellValue($m, $cooperativa)
               ->setCellValue($n, $rl['nome'])
               ->setCellValue($o, $rl['cpf'])
               ->setCellValue($p, $rl['rg'])
               ->setCellValue($q, $row['logradouro'])
               ->setCellValue($r, $row['numero'])
               ->setCellValue($s, $row['complemento'])
               ->setCellValue($t, $row['bairro'])
               ->setCellValue($u, $row['cidade'])
               ->setCellValue($v, $row['estado'])
               ->setCellValue($w, $row['cep'])
               ->setCellValue($x, $row['telefone'])
               ->setCellValue($y, $row['celular'])
               ->setCellValue($z, $row['email'])
               ->setCellValue($aa, $status)
               ->setCellValue($ab, $dataInscricao)
               ;
   $i++;
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

$nome_arquivo = date("Y-m-d")."_pessoa_juridica.xls";

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