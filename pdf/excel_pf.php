﻿<?php
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
$objPHPExcel->getProperties()->setTitle("Relatório de Pessoa Física");
$objPHPExcel->getProperties()->setSubject("Relatório de Pessoa Física");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema Pro-Mac");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Pessoa Física");

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nome')
            ->setCellValue('B1', 'CPF')
            ->setCellValue('C1', 'RG')
            ->setCellValue('D1', 'Logradouro')
            ->setCellValue('E1', 'Nº')
            ->setCellValue('F1', 'Complemento')
            ->setCellValue('G1', 'Bairro')
            ->setCellValue('H1', 'Cidade')
            ->setCellValue('I1', 'Estado')
            ->setCellValue('J1', 'CEP')
            ->setCellValue('K1', 'Prefeitura Regional')
            ->setCellValue('L1', 'Dsitrito')
            ->setCellValue('M1', 'Telefone')
            ->setCellValue('N1', 'Celular')
            ->setCellValue('O1', 'E-mail')
            ->setCellValue('P1', 'Cooperado')
            ->setCellValue('Q1', 'Nível de Acesso')
            ->setCellValue('R1', 'Status')
            ->setCellValue('S1', 'Data da Inscrição');

//Colorir a primeira fila
$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->applyFromArray(
   array(
      'fill' => array(
         'type' => PHPExcel_Style_Fill::FILL_SOLID,
         'color' => array('rgb' => 'E0EEEE')
      ),
   )
);


//Dados
$sql = "SELECT * FROM pessoa_fisica ORDER BY nome";
$query = mysqli_query($con,$sql);

$i = 2; // para começar a gravar os dados na segunda linha
while($row = mysqli_fetch_array($query))
{
   if($row['cooperado'] == 1)
      $cooperado = 'Sim';
   else
      $cooperado = 'Não';

   if($row['idNivelAcesso'] == 1)
      {$nivelAcesso = 'Proponente';}
   elseif($row['idNivelAcesso'] == 2)
      {$nivelAcesso = 'SMC';}
   else
      {$nivelAcesso = 'Comissão';}

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

   $subprefeitura = recuperaDados("subprefeitura","idSubprefeitura",$row['idSubprefeitura']);
   $distrito = recuperaDados("distrito","idDistrito",$row['idDistrito']);

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

   $objPHPExcel->setActiveSheetIndex(0)
               ->setCellValue($a, $row['nome'])
               ->setCellValue($b, $row['cpf'])
               ->setCellValue($c, $row['rg'])
               ->setCellValue($d, $row['logradouro'])
               ->setCellValue($e, $row['numero'])
               ->setCellValue($f, $row['complemento'])
               ->setCellValue($g, $row['bairro'])
               ->setCellValue($h, $row['cidade'])
               ->setCellValue($I, $row['estado'])
               ->setCellValue($j, $row['cep'])
               ->setCellValue($k, $subprefeitura['subprefeitura'])
               ->setCellValue($l, $distrito['distrito'])
               ->setCellValue($m, $row['telefone'])
               ->setCellValue($n, $row['celular'])
               ->setCellValue($o, $row['email'])
               ->setCellValue($p, $cooperado)
               ->setCellValue($q, $nivelAcesso)
               ->setCellValue($r, $status)
               ->setCellValue($s, $row['dataInscricao']);
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

$nome_arquivo = date("Y-m-d")."_pessoa_fisica.xls";

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