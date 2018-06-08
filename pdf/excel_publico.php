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
$sql = "SELECT idProjeto, protocolo, nomeProjeto, tipoPessoa, idPj, idPf
         FROM projeto WHERE publicado = 1 ORDER BY idProjeto";
$query = mysqli_query($con,$sql);
$campo = mysqli_fetch_array($query);

//Recupera todos os locais daquele projeto
function listaLocal($idProjeto)
{
   $con = bancoMysqli();

   $sql_local = "SELECT idLocaisRealizacao, idProjeto, local, estimativaPublico, idZona, idSubprefeitura, idDistrito, publicado FROM
locais_realizacao WHERE idProjeto = '$idProjeto' AND publicado = '1'";

     $query_local = mysqli_query($con,$sql_local);
     $num = mysqli_num_rows($query_local);
     if($num > 0)
     {
        $local = "";
        $estimativa = "";
        $zona = "";
        $subprefeitura = "";
        $distrito = "";
        while($row = mysqli_fetch_array($query_local))
        {
          $t_zona = recuperaDados("zona","idZona",$row['idZona']);
          $t_subprefeitura = recuperaDados("subprefeitura","idSubprefeitura",$row['idSubprefeitura']);
          $t_distrito = recuperaDados("distrito","idDistrito",$row['idDistrito']);

          $local .= $row['local']."\r";
          $estimativa .= $row['estimativaPublico']."\r";
          $zona .= $t_zona['zona']."\r";
          $subprefeitura .= $t_subprefeitura['subprefeitura']."\r";
          $distrito .= $t_distrito['distrito']."\r";

          $array = array(
            "local" => substr($local,0,-1),
            "estimativa" => substr($estimativa,0,-1),
            "zona" => substr($zona,0,-1),
            "subprefeitura" => substr($subprefeitura,0,-1),
            "distrito" => substr($distrito,0,-1));
        }
      return $array;
      }
}

$i = 2; // para começar a gravar os dados na segunda linha
while($row = mysqli_fetch_array($query))
{
   if($row['tipoPessoa'] == 2)
   {
      $pj = recuperaDados("pessoa_juridica","idPj",$row['idPj']);
      $proponente = $pj['razaoSocial'];
   }
   else
   {
      $pf = recuperaDados("pessoa_fisica","idPf",$row['idPf']);
      $proponente = $pf['nome'];
   }

   $lista_local = listaLocal($row['idProjeto']);

   $tipoPessoa = $row['tipoPessoa'];
   if($tipoPessoa == 1)
   {
      $tipo = "Física";
   }
   else
   {
      $tipo = "Jurídica";
   }
  
   $objPHPExcel->setActiveSheetIndex(0)
               ->setCellValue('A'.$i, $row['protocolo'])
               ->setCellValue('B'.$i, $row['nomeProjeto'])
               ->setCellValue('C'.$i, $lista_local['local'])
               ->setCellValue('D'.$i, $lista_local['estimativa'])
               ->setCellValue('E'.$i, $lista_local['zona'])
               ->setCellValue('F'.$i, $lista_local['subprefeitura'])
               ->setCellValue('G'.$i, $lista_local['distrito'])
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