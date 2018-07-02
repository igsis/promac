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
$objPHPExcel->getProperties()->setTitle("Relatório de Depósitos");
$objPHPExcel->getProperties()->setSubject("Relatório de Depósitos");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema Pro-Mac");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Relatório de Depósitos");

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Incentivador')
    ->setCellValue('B1', 'Documento')
    ->setCellValue('C1', 'Número da Reserva')
    ->setCellValue('D1', 'Data Depósito')
    ->setCellValue('E1', 'Valor Depósito')
    ->setCellValue('F1', 'Valor Renúncia')    
    ->setCellValue('G1', 'Porcentagem do Valor Renúncia');    

//Colorir a primeira fila
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('#29bb04');
// Add some data
$objPHPExcel->getActiveSheet()->getStyle("A1:G1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
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
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);


//Dados
$sql = "SELECT
          D.idDeposito,
          D.idIncentivador,
          D.tipoPessoa,
          R.idReserva,
          R.numeroReserva,
          D.data,
          D.valorDeposito,
          D.valorRenuncia,
          D.porcentagemValorRenuncia
          FROM deposito AS D
          LEFT JOIN reserva AS R ON R.idReserva = D.idReserva
        ORDER BY D.idDeposito";
$query = mysqli_query($con,$sql);
$campo = mysqli_fetch_array($query);

$i = 2; // para começar a gravar os dados na segunda linha
while($linha = mysqli_fetch_array($query))
{
    if($linha['tipoPessoa'] == 5)
    {
        $pj = recuperaDados("incentivador_pessoa_juridica","idPj",$linha['idIncentivador']);
        $proponente = $pj['razaoSocial'];
    }
    else
    {
        $pf = recuperaDados("incentivador_pessoa_fisica","idPf",$linha['idIncentivador']);
        $proponente = $pf['nome'];
    }

    $tipoPessoa = $linha['tipoPessoa'];
    
    if($tipoPessoa == 4)
    {
        $tipo = "Física";
    }
    else
    {
        $tipo = "Jurídica";
    }

    $reserva = $objPHPExcel->getActiveSheet()->getCell('G'.($i-1))->getValue();

    if ($incentivador == $linha['numeroReserva'])
    {
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.($i-1).':'.'G'.$i);

    }

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, $proponente)
        ->setCellValue('B'.$i, $linha['tipoPessoa'])
        ->setCellValue('C'.$i, $linha['data'])
        ->setCellValue('D'.$i, $linha['valorDeposito'])
        ->setCellValue('E'.$i, $linha['valorRenuncia'])
        ->setCellValue('F'.$i, $linha['porcentagemValorRenuncia'])
        ->setCellValue('G'.$i, $linha['numeroReserva']);

    $i++;
}

$objPHPExcel->setActiveSheetIndex(0);
ob_end_clean();
ob_start();

$nome_arquivo = date("Y-m-d H:i:s")."_deposito.xls";

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