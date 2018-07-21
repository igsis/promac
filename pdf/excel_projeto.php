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
$objPHPExcel->getProperties()->setTitle("Relatório de Projetos");
$objPHPExcel->getProperties()->setSubject("Relatório de Projetos");
$objPHPExcel->getProperties()->setDescription("Gerado automaticamente a partir do Sistema Pro-Mac");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Relatório de Projetos");

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nº ISP')
            ->setCellValue('B1', 'Nome do projeto')
            ->setCellValue('C1', 'Área de Atuação')
            ->setCellValue('D1', 'Valor total')
            ->setCellValue('E1', 'Valor incentivo')
            ->setCellValue('F1', 'Resumo')
            ->setCellValue('G1', 'Local')
            ->setCellValue('H1', 'Público estimado')
            ->setCellValue('I1', 'Zona')
            ->setCellValue('J1', 'Subprefeitura')
            ->setCellValue('K1', 'Distrito')
            ->setCellValue('L1', 'Público alvo')
            ->setCellValue('M1', 'Ficha técnica')
            ->setCellValue('N1', 'Pessoa')
            ->setCellValue('O1', 'Proponente')
            ->setCellValue('P1', 'Documento')
            ->setCellValue('Q1', 'Logradouro')
            ->setCellValue('R1', 'Número')
            ->setCellValue('S1', 'Complemento')
            ->setCellValue('T1', 'Bairro')
            ->setCellValue('U1', 'Cidade')
            ->setCellValue('V1', 'Estado')
            ->setCellValue('W1', 'CEP')
            ->setCellValue('X1', 'Status')
            ->setCellValue('Y1', 'Início da captação')
            ->setCellValue('Z1', 'Prorrogação Captação')
            ->setCellValue('A1', 'Final da captação')
            ->setCellValue('AB1', 'Início da execução')
            ->setCellValue('AC1', 'Fim da execução')
            ->setCellValue('AD1', 'Prorrogação Execução')
            ->setCellValue('AE1', 'Data para prestar contas');

//Colorir a primeira fila
$objPHPExcel->getActiveSheet()->getStyle('A1:AE1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:AE1')->getFill()->getStartColor()->setARGB('#29bb04');
// Add some data
$objPHPExcel->getActiveSheet()->getStyle("A1:AE1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:AE1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
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
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setAutoSize(true);


//Dados Projeto
$sql = "SELECT idProjeto, idAreaAtuacao, protocolo, nomeProjeto, valorProjeto, valorIncentivo, resumoProjeto, publicoAlvo, tipoPessoa, idPj, idPf, status, tipoPessoa, valorAprovado, idRenunciaFiscal
         FROM projeto AS pr
         INNER JOIN status AS st ON pr.idStatus = st.idStatus
         INNER JOIN area_atuacao AS aa pr.idAreaAtuacao = aa.idArea
         INNER JOIN renuncia_fiscal AS renuncia ON pr.idRenunciaFiscal = renuncia.idRenuncia
         WHERE publicado = 1 ORDER BY protocolo";
$query = mysqli_query($con,$sql);
$campo = mysqli_fetch_array($query);

//Recupera todos os integrantes daquele projeto
function listaFicha($idProjeto)
{
  $con = bancoMysqli();
  $sql_ficha = "SELECT * FROM ficha_tecnica WHERE idProjeto = '$idProjeto' AND publicado = '1'";
  $query_ficha = mysqli_query($con,$sql_ficha);
  $num = mysqli_num_rows($query_ficha);
  if($num > 0)
  {
    $txt = "";
    while($row = mysqli_fetch_array($query_ficha))
    {
      $txt .= $row['nome']." CPF: ".$row['cpf']." Função: ".$row['funcao']."\r";
    }
    return substr($txt,0,-1);
  }
}

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
      $documento = $pj['cnpj'];
      $logradouro = $pj['logradouro'];
      $numero = $pj['numero'];
      $complemento = $pj['complemento'];
      $bairro = $pj['bairro'];
      $cidade = $pj['cidade'];
      $estado = $pj['estado'];
      $cep = $pj['cep'];
   }
   else
   {
      $pf = recuperaDados("pessoa_fisica","idPf",$row['idPf']);
      $proponente = $pf['nome'];
      $documento = $pf['cpf'];
      $logradouro = $pf['logradouro'];
      $numero = $pf['numero'];
      $complemento = $pf['complemento'];
      $bairro = $pf['bairro'];
      $cidade = $pf['cidade'];
      $estado = $pf['estado'];
      $cep = $pf['cep'];
   }

   $lista_ficha = listaFicha($row['idProjeto']);
   $lista_local = listaLocal($row['idProjeto']);
   $lista_prazos = recuperaDados("prazos_projeto","idProjeto",$row['idProjeto']);

   $tipoPessoa = $row['tipoPessoa'];
   if($tipoPessoa == 1)
   {
   		$tipo = "Física";
   }
   else
   {
   		$tipo = "Jurídica";
   }
   //$objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

   $objPHPExcel->getActiveSheet()->getStyle('C'.$i.'')->getNumberFormat()->setFormatCode("#,##0.00");
   $objPHPExcel->getActiveSheet()->getStyle('D'.$i.'')->getNumberFormat()->setFormatCode("#,##0.00");
   $objPHPExcel->getActiveSheet()->getStyle('AI'.$i.'')->getNumberFormat()->setFormatCode("#,##0.00");
   $objPHPExcel->getActiveSheet()->getStyle('AJ'.$i.'')->getNumberFormat()->setFormatCode("#,##0.00");
   $objPHPExcel->getActiveSheet()->getStyle('AM'.$i.'')->getNumberFormat()->setFormatCode("#,##0.00");
   $objPHPExcel->getActiveSheet()->getStyle('AP'.$i.'')->getNumberFormat()->setFormatCode("#,##0.00");
   $objPHPExcel->getActiveSheet()->getStyle('AS'.$i.'')->getNumberFormat()->setFormatCode("#,##0.00");


   $objPHPExcel->setActiveSheetIndex(0)
               ->setCellValue('A'.$i, $row['protocolo'])
               ->setCellValue('B'.$i, $row['nomeProjeto'])
               ->setCellValue('C'.$i, $row['idAreaAtuacao'])
               ->setCellValue('D'.$i, $row['valorProjeto'])
               ->setCellValue('E'.$i, $row['valorIncentivo'])
               ->setCellValue('F'.$i, $row['resumoProjeto'])
               ->setCellValue('G'.$i, $lista_local['local'])
               ->setCellValue('H'.$i, $lista_local['estimativa'])
               ->setCellValue('I'.$i, $lista_local['zona'])
               ->setCellValue('J'.$i, $lista_local['subprefeitura'])
               ->setCellValue('K'.$i, $lista_local['distrito'])
               ->setCellValue('L'.$i, $row['publicoAlvo'])
               ->setCellValue('M'.$i, $lista_ficha)
               ->setCellValue('N'.$i, $tipo)
               ->setCellValue('O'.$i, $proponente)
               ->setCellValue('P'.$i, $documento)
               ->setCellValue('Q'.$i, $logradouro)
               ->setCellValue('R'.$i, $numero)
               ->setCellValue('S'.$i, $complemento)
               ->setCellValue('T'.$i, $bairro)
               ->setCellValue('U'.$i, $cidade)
               ->setCellValue('V'.$i, $estado)
               ->setCellValue('W'.$i, $cep)
               ->setCellValue('X'.$i, $row['status'])
               ->setCellValue('Y'.$i, $lista_prazos['prazoCaptacao'])
               ->setCellValue('Z'.$i, $lista_prazos['prorrogacaoCaptacao'])
               ->setCellValue('AA'.$i, $lista_prazos['finalCaptacao'])
               ->setCellValue('AB'.$i, $lista_prazos['inicioExecucao'])
               ->setCellValue('AC'.$i, $lista_prazos['fimExecucao'])
               ->setCellValue('AD'.$i, $lista_prazos['prorrogacaoExecucao'])
               ->setCellValue('AE'.$i, $lista_prazos['prestarContas']);


   $i++;
}

$objPHPExcel->setActiveSheetIndex(0);
ob_end_clean();
ob_start();

$nome_arquivo = date("Y-m-d H:i:s")."_projetos.xls";

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