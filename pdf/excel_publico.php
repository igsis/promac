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
$objPHPExcel->getProperties()->setTitle("Relatório de Público");
$objPHPExcel->getProperties()->setSubject("Relatório de Público");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema Pro-Mac");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Relatório de Público");

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Nº ISP')
    ->setCellValue('B1', 'Nome do projeto')
    ->setCellValue('C1', 'Local')
    ->setCellValue('D1', 'Público estimado')
    ->setCellValue('E1', 'Zona')
    ->setCellValue('F1', 'Subprefeitura')
    ->setCellValue('G1', 'Distrito')
    ->setCellValue('H1', 'Proponente');

//Colorir a primeira fila
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->getStartColor()->setARGB('#29bb04');
// Add some data
$objPHPExcel->getActiveSheet()->getStyle("A1:H1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
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
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(80);

//Dados
$sql = "SELECT
          P.idProjeto,
          P.protocolo,
          P.nomeProjeto,
          L.local,
          L.estimativaPublico,
          Z.zona,
          S.subprefeitura,
          D.distrito,
          P.tipoPessoa,
          P.idPj,
          P.idPf
        FROM projeto AS P
          LEFT JOIN locais_realizacao AS L ON P.idProjeto = L.idProjeto
          LEFT JOIN zona AS Z ON L.idZona = Z.idZona
          LEFT JOIN subprefeitura AS S ON L.idSubprefeitura = S.idSubprefeitura
          LEFT JOIN distrito AS D ON L.idDistrito = D.idDistrito
        WHERE
          P.publicado = 1
        ORDER BY P.idProjeto";
$query = mysqli_query($con,$sql);
$campo = mysqli_fetch_array($query);

$i = 2; // para começar a gravar os dados na segunda linha
while($linha = mysqli_fetch_array($query))
{
    if($linha['tipoPessoa'] == 2)
    {
        $pj = recuperaDados("pessoa_juridica","idPj",$linha['idPj']);
        $proponente = $pj['razaoSocial'];
    }
    else
    {
        $pf = recuperaDados("pessoa_fisica","idPf",$linha['idPf']);
        $proponente = $pf['nome'];
    }

    $tipoPessoa = $linha['tipoPessoa'];
    if($tipoPessoa == 1)
    {
        $tipo = "Física";
    }
    else
    {
        $tipo = "Jurídica";
    }

    $protocolo = $objPHPExcel->getActiveSheet()->getCell('A'.($i-1))->getValue();

    if ($protocolo == $linha['protocolo'])
    {
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.($i-1).':'.'A'.$i);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.($i-1).':'.'B'.$i);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.($i-1).':'.'H'.$i);
    }

    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A'.$i, $linha['protocolo'])
        ->setCellValue('B'.$i, $linha['nomeProjeto'])
        ->setCellValue('C'.$i, $linha['local'])
        ->setCellValue('D'.$i, $linha['estimativaPublico'])
        ->setCellValue('E'.$i, $linha['zona'])
        ->setCellValue('F'.$i, $linha['subprefeitura'])
        ->setCellValue('G'.$i, $linha['distrito'])
        ->setCellValue('H'.$i, $proponente);
    $i++;
}

$objPHPExcel->setActiveSheetIndex(0);
ob_end_clean();
ob_start();

$nome_arquivo = date("Y-m-d H:i:s")."_publico.xls";

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