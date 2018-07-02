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
$objPHPExcel->getProperties()->setTitle("Relatório de Reservas");
$objPHPExcel->getProperties()->setSubject("Relatório de Reservas");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema Pro-Mac");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Relatório de Reservas");

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Nome do projeto')
    ->setCellValue('B1', 'Data')
    ->setCellValue('C1', 'Valor')
    ->setCellValue('D1', 'Número da Reserva');

//Colorir a primeira fila
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFill()->getStartColor()->setARGB('#29bb04');
// Add some data
$objPHPExcel->getActiveSheet()->getStyle("A1:D1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$styleArray = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
    ),
    'alignment' => array(
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);
$objPHPExcel->getDefaultStyle()->applyFromArray($styleArray);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

//Dados
$sql = "SELECT
          P.idProjeto,
          P.nomeProjeto,
          R.data,
          R.valor,
          R.numeroReserva
        FROM reserva AS R
          LEFT JOIN projeto AS P ON R.idProjeto = P.idProjeto
        WHERE
          P.publicado = 1
        ORDER BY P.idProjeto";
$query = mysqli_query($con,$sql);
$campo = mysqli_fetch_array($query);

$i = 2; // para começar a gravar os dados na segunda linha
while($linha = mysqli_fetch_array($query))
{
    $projeto = $objPHPExcel->getActiveSheet()->getCell('A'.($i-1))->getValue();

    if ($projeto == $linha['nomeProjeto'])
    {
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.($i-1).':'.'A'.$i);
    }

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, $linha['nomeProjeto'])
        ->setCellValue('B'.$i, $linha['data'])
        ->setCellValue('C'.$i, $linha['valor'])
        ->setCellValue('D'.$i, $linha['numeroReserva']);
    $i++;
}

$objPHPExcel->setActiveSheetIndex(0);
ob_end_clean();
ob_start();

$nome_arquivo = date("Y-m-d H:i:s")."_reserva.xls";

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