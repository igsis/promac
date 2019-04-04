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
$objPHPExcel->getProperties()->setCategory("Relatório de Projetos");

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Nº ISP')
            ->setCellValue('B1', 'Nome do projeto')
            ->setCellValue('C1', 'Área de Atuação')
            ->setCellValue('D1', 'Segmento')
            ->setCellValue('E1', 'Valor aprovado')
            ->setCellValue('F1', 'Resumo')
            ->setCellValue('G1', 'Local')
            ->setCellValue('H1', 'Público estimado')
            ->setCellValue('I1', 'Logradouro')
            ->setCellValue('J1', 'Cidade')
            ->setCellValue('K1', 'Bairro')
            ->setCellValue('L1', 'Público alvo')
            ->setCellValue('M1', 'Ficha técnica')
            ->setCellValue('N1', 'Pessoa')
            ->setCellValue('O1', 'Proponente')
            ->setCellValue('P1', 'Documento')
            ->setCellValue('Q1', 'Email')
            ->setCellValue('R1', 'Logradouro')
            ->setCellValue('S1', 'Número')
            ->setCellValue('T1', 'Complemento')
            ->setCellValue('U1', 'Bairro')
            ->setCellValue('V1', 'Cidade')
            ->setCellValue('W1', 'Estado')
            ->setCellValue('Z1', 'CEP')
            ->setCellValue('Y1', 'Etapa')
            ->setCellValue('Z1', 'Status');

//Colorir a primeira fila
$objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getFill()->getStartColor()->setARGB('#29bb04');
// Add some data
$objPHPExcel->getActiveSheet()->getStyle("A1:AA1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
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
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(80);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(80);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
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


//Dados Projeto
$sql = "SELECT idProjeto, areaAtuacao, segmento, protocolo, nomeProjeto, valorProjeto, valorIncentivo, resumoProjeto, publicoAlvo, tipoPessoa, idPj, idPf, etapaProjeto, pr.idEtapaProjeto, es.status, tipoPessoa, valorAprovado, idRenunciaFiscal
         FROM projeto AS pr
         INNER JOIN etapa_projeto AS st ON pr.idEtapaProjeto = st.idEtapaProjeto
         LEFT JOIN etapa_status AS es ON pr.idStatus = es.idStatus
         INNER JOIN area_atuacao AS area ON pr.idAreaAtuacao = area.idArea
         INNER JOIN renuncia_fiscal AS renuncia ON pr.idRenunciaFiscal = renuncia.idRenuncia
         WHERE pr.publicado = '1' ORDER BY protocolo";
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

   $sql_local = "SELECT idLocaisRealizacao, idProjeto, local, estimativaPublico, logradouro, numero, complemento, bairro, cidade, publicado FROM
locais_realizacao WHERE idProjeto = '$idProjeto' AND publicado = '1'";

     $query_local = mysqli_query($con,$sql_local);
     $num = mysqli_num_rows($query_local);
     if($num > 0)
     {
        $local = "";
        $estimativa = "";
        $logradouro = "";
        $bairro = "";
        $cidade = "";
        while($row = mysqli_fetch_array($query_local))
        {
          $local .= $row['local']."\r";
          $estimativa .= $row['estimativaPublico']."\r";
          $logradouro .= $row['logradouro']. ", ".$row['numero']." ".$row['complemento']."\r";
          $bairro .= $row['bairro']."\r";
          $cidade .= $row['cidade']."\r";

          $array = array(
            "local" => substr($local,0,-1),
            "estimativa" => substr($estimativa,0,-1),
            "logradouro" => substr($logradouro,0,-1),
            "bairro" => substr($bairro,0,-1),
            "cidade" => substr($cidade,0,-1));
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
      $email = $pj['email'];
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
      $email = $pf['email'];
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
   $objPHPExcel->getActiveSheet()->getStyle('E'.$i.'')->getNumberFormat()->setFormatCode("#,##0.00");
   $objPHPExcel->getActiveSheet()->getStyle('F'.$i.'')->getNumberFormat()->setFormatCode("#,##0.00");


   $objPHPExcel->setActiveSheetIndex(0)
               ->setCellValue('A'.$i, $row['protocolo'])
               ->setCellValue('B'.$i, $row['nomeProjeto'])
               ->setCellValue('C'.$i, $row['areaAtuacao'])
               ->setCellValue('D'.$i, $row['segmento'])
               ->setCellValue('E'.$i, $row['valorAprovado'])
               ->setCellValue('F'.$i, $row['resumoProjeto'])
               ->setCellValue('G'.$i, $lista_local['local'])
               ->setCellValue('H'.$i, $lista_local['estimativa'])
               ->setCellValue('I'.$i, $lista_local['logradouro'])
               ->setCellValue('J'.$i, $lista_local['bairro'])
               ->setCellValue('K'.$i, $lista_local['cidade'])
               ->setCellValue('L'.$i, $row['publicoAlvo'])
               ->setCellValue('M'.$i, $lista_ficha)
               ->setCellValue('N'.$i, $tipo)
               ->setCellValue('O'.$i, $proponente)
               ->setCellValue('P'.$i, $documento)
               ->setCellValue('Q'.$i, $email)
               ->setCellValue('R'.$i, $logradouro)
               ->setCellValue('S'.$i, $numero)
               ->setCellValue('T'.$i, $complemento)
               ->setCellValue('U'.$i, $bairro)
               ->setCellValue('V'.$i, $cidade)
               ->setCellValue('W'.$i, $estado)
               ->setCellValue('X'.$i, $cep)
               ->setCellValue('Y'.$i, $row['etapaProjeto'])
               ->setCellValue('Z'.$i, $row['status']);
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