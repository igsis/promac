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
$cacheSettings = array(' memoryCacheSize ' => '8MB');
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
    ->setCellValue('A1', "Nº  de Protocolo")
    ->setCellValue('B1', "Nome do Projeto")
    ->setCellValue('C1', "Resumo do projeto")
    ->setCellValue('D1', "Distrito")
    ->setCellValue('E1', "Etapa do Projeto")
    ->setCellValue('F1', "Orçamento")
    ->setCellValue('G1', "Status")
    ->setCellValue('H1', "Ano do Edital")
    ->setCellValue('I1', "Nome do Proponente")
    ->setCellValue('J1', "Tipo de Pessoa")
    ->setCellValue('K1', "Documento (CPF/CNPJ)")
    ->setCellValue('L1', "E-mail")
    ->setCellValue('M1', "Area de Atuação")
    ->setCellValue('N1', "Tags");


//Colorir a primeira fila
$objPHPExcel->getActiveSheet()->getStyle('A1:AD1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:AD1')->getFill()->getStartColor()->setARGB('#29bb04');
// Add some data
$objPHPExcel->getActiveSheet()->getStyle("A1:AD1")->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:AD1')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);


$styleArray = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN
        )
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
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);


//Dados Projeto
$sql = "SELECT 	pr.idProjeto, pr.protocolo,  pr.nomeProjeto, area.areaAtuacao, pr.valorProjeto,
        tipoPessoa, idPj, idPf, st.etapaProjeto, pr.idEtapaProjeto, es.status, pr.edital,pr.resumoProjeto,pr.tipoPessoa
         FROM projeto AS pr
         INNER JOIN etapa_projeto AS st ON pr.idEtapaProjeto = st.idEtapaProjeto
         LEFT JOIN etapa_status AS es ON pr.idStatus = es.idStatus
         INNER JOIN area_atuacao AS area ON pr.idAreaAtuacao = area.idArea
         WHERE pr.publicado = '1' AND (pr.idPj > 0 OR pr.idPf > 0) ORDER BY pr.edital, pr.protocolo";
$query = mysqli_query($con, $sql);
$campo = mysqli_fetch_array($query);

function gerarTag($idProjeto)
{
    $con = bancoMysqli();
    $sql = "SELECT tag 
            FROM tags AS tg LEFT JOIN projeto_tag AS pt ON tg.id = pt.tag_id
            WHERE tg.publicado = 1 AND pt.projeto_id = {$idProjeto}";
    $query = mysqli_query($con, $sql);
    $tags = '';
    while ($tag = mysqli_fetch_array($query)) {
        $tags .= "{$tag['tag']};";
    }
    return $tags;
}

//Recupera todos os locais daquele projeto
function listaLocal($idProjeto)
{
    $con = bancoMysqli();

    $sql_local = "SELECT d.distrito FROM locais_realizacao AS l RIGHT JOIN distrito AS d ON d.idDistrito = l.idDistrito WHERE l.idProjeto = '{$idProjeto}' AND l.publicado = '1' ";

    $query_local = mysqli_query($con,$sql_local);
    $num = mysqli_num_rows($query_local);
    if($num > 0)
    {
        $local = "";
//        $estimativa = "";
//        $logradouro = "";
//        $bairro = "";
//        $cidade = "";
        while($row = mysqli_fetch_array($query_local))
        {
            $local .= $row['distrito']."; \r";
//            $estimativa .= $row['estimativaPublico']."\r";
//            $logradouro .= $row['logradouro']. ", ".$row['numero']." ".$row['complemento']."\r";
//            $bairro .= $row['bairro']."\r";
//            $cidade .= $row['cidade']."\r";

            $array = array(
                "local" => substr($local,0,-1),
//                "estimativa" => substr($estimativa,0,-1),
//                "logradouro" => substr($logradouro,0,-1),
//                "bairro" => substr($bairro,0,-1),
//                "cidade" => substr($cidade,0,-1)
            );
        }
        return $array;
    }
    return false;
}



$i = 2; // para começar a gravar os dados na segunda linha
while ($row = mysqli_fetch_array($query)) {
        if ($row['tipoPessoa'] == 2) {
            $pj = recuperaDados("pessoa_juridica", "idPj", $row['idPj']);
            $proponente = $pj != null ?$pj['razaoSocial'] : '';
            $documento = $pj != null ?$pj['cnpj'] : '';
            $email = $pj != null ?$pj['email'] : '';
            $logradouro = $pj != null ?$pj['logradouro'] : '';
            $numero = $pj != null ?$pj['numero'] : '';
            $complemento = $pj != null ?$pj['complemento'] : '';
            $bairro = $pj != null ?$pj['bairro'] : '';
            $cidade = $pj != null ?$pj['cidade'] : '';
            $estado = $pj != null ?$pj['estado'] : '';
            $cep = $pj != null ?$pj['cep'] : '';
        } else {
            $pf = recuperaDados("pessoa_fisica", "idPf", $row['idPf']);
            $proponente = $pf != null ? $pf['nome']:'';
            $documento = $pf != null ? $pf['cpf']:'';
            $email = $pf != null ? $pf['email']:'';
            $logradouro = $pf != null ? $pf['logradouro']:'';
            $numero = $pf != null ? $pf['numero']:'';
            $complemento = $pf != null ? $pf['complemento']:'';
            $bairro = $pf != null ? $pf['bairro']:'';
            $cidade = $pf != null ? $pf['cidade']:'';
            $estado = $pf != null ? $pf['estado']:'';
            $cep = $pf != null ? $pf['cep']:'';
        }

        $tipoPessoa = $row['tipoPessoa'];
        if ($tipoPessoa == 1) {
            $tipo = "Física";
        } else {
            $tipo = "Jurídica";
        }
        $tags = gerarTag($row['idProjeto']);
        $lista_local = listaLocal($row['idProjeto']);

//            $objPHPExcel->getActiveSheet()->getStyle('A'.$i.'')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('E' . $i . '')->getNumberFormat()->setFormatCode("#,##0.00");
        $objPHPExcel->getActiveSheet()->getStyle('F' . $i . '')->getNumberFormat()->setFormatCode("#,##0.00");


        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, $row['protocolo'])
            ->setCellValue('B' . $i, $row['nomeProjeto'])
            ->setCellValue('C' . $i, $row['resumoProjeto'])
            ->setCellValue('D'.$i, $lista_local ? $lista_local['local']:'')
            ->setCellValue('E' . $i, $row['etapaProjeto'])
            ->setCellValue('F' . $i, $row['valorProjeto'])
            ->setCellValue('G' . $i, $row['status'])
            ->setCellValue('H' . $i, $row['edital'])
            ->setCellValue('I' . $i, $proponente)
            ->setCellValue('J' . $i, $tipo)
            ->setCellValue('K'.$i, $documento)
            ->setCellValue('L'.$i, $email)
            ->setCellValue('M' . $i, $row['areaAtuacao'])
            ->setCellValue('N' . $i, $tags);
        $i++;
}

$objPHPExcel->setActiveSheetIndex(0);
ob_end_clean();
ob_start();

$nome_arquivo = date("Y-m-d H:i:s") . "_projetos.xls";

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: text/html; charset=ISO-8859-1');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $nome_arquivo . '"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');