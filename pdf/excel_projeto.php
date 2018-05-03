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
$objPHPExcel->getProperties()->setCategory("Pessoa Física");

// Add some data
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
            ->setCellValue('J1', 'Nome/Razão Social')
            ->setCellValue('K1', 'CPF/CNPJ')
            ->setCellValue('L1', 'Logradouro')
            ->setCellValue('M1', 'Número')
            ->setCellValue('N1', 'Complemento')
            ->setCellValue('O1', 'Bairro')
            ->setCellValue('P1', 'Cidade')
            ->setCellValue('Q1', 'Estado')
            ->setCellValue('R1', 'CEP');

//Colorir a primeira fila
$objPHPExcel->getActiveSheet()->getStyle('A1:R1')->applyFromArray(
   array(
      'fill' => array(
         'type' => PHPExcel_Style_Fill::FILL_SOLID,
         'color' => array('rgb' => 'E0EEEE')
      ),
   )
);


//Dados
$sql = "SELECT nomeProjeto, valorProjeto, valorIncentivo, resumoProjeto FROM projeto ORDER BY protocolo";
$query = mysqli_query($con,$sql);
$campo = mysqli_fetch_array($query);

$sql_ficha = "SELECT nome FROM ficha_tecnica WHERE idProjeto = ''";

$sql_

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
               ->setCellValue($k, $row['telefone'])
               ->setCellValue($l, $row['celular'])
               ->setCellValue($m, $row['email'])
               ->setCellValue($n, $cooperado)
               ->setCellValue($o, $nivelAcesso)
               ->setCellValue($p, $status)
               ->setCellValue($q, $row['dataInscricao']);
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