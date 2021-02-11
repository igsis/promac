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
    ->setCellValue('A1', "Edital")
    ->setCellValue('B1', "Nº  de Protocolo")
    ->setCellValue('C1', "Nome do Projeto")
    ->setCellValue('D1', "Nome do Proponente")
    ->setCellValue('E1', "Documento")
    ->setCellValue('F1', "Área de Atuação")
    ->setCellValue('G1', "Status")
    ->setCellValue('H1', "Local");


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
        tipoPessoa, idPj, idPf, st.etapaProjeto, pr.idEtapaProjeto, es.status, pr.edital,
        pr.resumoProjeto,pr.tipoPessoa
         FROM projeto AS pr
         LEFT JOIN etapa_projeto AS st ON pr.idEtapaProjeto = st.idEtapaProjeto
         LEFT JOIN etapa_status AS es ON pr.idStatus = es.idStatus
         LEFT JOIN area_atuacao AS area ON pr.idAreaAtuacao = area.idArea
         WHERE pr.publicado = '1' AND (pr.idPj > 0 OR pr.idPf > 0) AND protocolo != '' AND nomeProjeto NOT LIKE '%TESTE%' ORDER BY pr.edital, pr.protocolo";
$query = mysqli_query($con, $sql);
$campo = mysqli_fetch_array($query);

$i = 2; // para começar a gravar os dados na segunda linha
while ($row = mysqli_fetch_array($query)) {

    if ($row['tipoPessoa'] == 2) {
        $pj = recuperaDados("pessoa_juridica", "idPj", $row['idPj']);
        $proponente = $pj != null ? $pj['razaoSocial'] : '';
        $documento = $pj != null ? $pj['cnpj'] : '';
    } else {
        $pf = recuperaDados("pessoa_fisica", "idPf", $row['idPf']);
        $proponente = $pf != null ? $pf['nome'] : '';
        $documento = $pf != null ? $pf['rg'] : '';
        $email = $pf != null ? $pf['email'] : '';
    }

    $tipoPessoa = $row['tipoPessoa'];
    if ($tipoPessoa == 1) {
        $tipo = "Física";
        $sqlTipo = "SELECT ge.genero, et.etnia 
                    FROM pessoa_informacao_adicional as pi 
						  LEFT JOIN etnias as et ON pi.etnia = et.id 
						  LEFT JOIN generos AS ge ON pi.genero = ge.id  
                    WHERE pi.tipo_pessoa_id = {$tipoPessoa} AND pi.pessoa_id = {$row['idPf']}";
    } else {
        $tipo = "Jurídica";
        $sqlTipo = "SELECT ge.genero, et.etnia 
                    FROM pessoa_informacao_adicional as pi 
						  LEFT JOIN etnias as et ON pi.etnia = et.id 
						  LEFT JOIN generos AS ge ON pi.genero = ge.id  
                    WHERE pi.tipo_pessoa_id = {$tipoPessoa} AND pi.pessoa_id = {$row['idPj']}";
    }

    $query4 = mysqli_query($con, $sqlTipo);
    $infoPessoa = mysqli_fetch_array($query4);

    $sqlEnd = "SELECT lr.*, d.distrito, d.faixa , s.subprefeitura
                    FROM locais_realizacao AS lr
                    LEFT JOIN distrito d on lr.idDistrito = d.idDistrito
                    LEFT JOIN subprefeitura s ON  lr.idSubprefeitura = s.idSubprefeitura
                    WHERE lr.publicado = 1 AND lr.idProjeto = ". $row['idProjeto'] . " GROUP BY idProjeto";

    $queryEnd = mysqli_query($con, $sqlEnd);
    $end = mysqli_fetch_array($queryEnd);
    $local = '';
    if ($end['logradouro'] == ''){
        $local .= $end['subprefeitura'];
    } else{
        $local = $end['logradouro'] . ", " . $end['numero'] . " " . $end['complemento'] . " " . $end['bairro'] . ", " . $end['cidade'] . " - " . $end['estado'] . ", CEP " . $end['cep'];
    }


    $objPHPExcel->getActiveSheet()->getStyle('A' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel->getActiveSheet()->getStyle('E' . $i . '')->getNumberFormat()->setFormatCode("#,##0.00");
    $objPHPExcel->getActiveSheet()->getStyle('F' . $i . '')->getNumberFormat()->setFormatCode("#,##0.00");


    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $i, $row['edital'])
        ->setCellValue('B' . $i, $row['protocolo'])
        ->setCellValue('C' . $i, $row['nomeProjeto'])
        ->setCellValue('D' . $i, $proponente)
        ->setCellValue('E' . $i, $documento)
        ->setCellValue('F' . $i, $row['areaAtuacao'])
        ->setCellValue('G' . $i, $row['etapaProjeto'])
        ->setCellValue('H' . $i, $local);

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