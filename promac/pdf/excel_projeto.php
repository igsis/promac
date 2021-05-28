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
    ->setCellValue('A1', "Ano do Edital")
    ->setCellValue('B1', "Nº  de Protocolo")
    ->setCellValue('C1', "Nome do Projeto")
    ->setCellValue('D1', "Resumo do projeto")
    ->setCellValue('E1', "Distrito")
    ->setCellValue('F1', "Etapa do Projeto")
    ->setCellValue('G1', "Orçamento")
    ->setCellValue('H1', "Status do Projeto")
    ->setCellValue('I1', "Nome do Proponente")
    ->setCellValue('J1', "Endereço Proponente")
    ->setCellValue('K1', "Gênero")
    ->setCellValue('L1', "Etnia")
    ->setCellValue('M1', "Tipo de Pessoa")
    ->setCellValue('N1', "Documento (CPF/CNPJ)")
    ->setCellValue('O1', "Subprefeitura")
    ->setCellValue('P1', "Distrito")
    ->setCellValue('Q1', "E-mail")
    ->setCellValue('R1', "Area de Atuação")
    ->setCellValue('S1', "Tags")
    ->setCellValue('T1', "POSTO DE TRABALHO")
    ->setCellValue('U1', "MÉDIA DE REMUNERAÇÃO");


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
         LEFT JOIN etapa_projeto AS st ON pr.idEtapaProjeto = st.idEtapaProjeto
         LEFT JOIN etapa_status AS es ON pr.idStatus = es.idStatus
         LEFT JOIN area_atuacao AS area ON pr.idAreaAtuacao = area.idArea
         WHERE pr.publicado = '1' AND (pr.idPj > 0 OR pr.idPf > 0) AND nomeProjeto NOT LIKE '%TESTE%' ORDER BY pr.edital, pr.protocolo";
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

    $query_local = mysqli_query($con, $sql_local);
    $num = mysqli_num_rows($query_local);
    if ($num > 0) {
        $local = "";
//        $estimativa = "";
//        $logradouro = "";
//        $bairro = "";
//        $cidade = "";
        while ($row = mysqli_fetch_array($query_local)) {
            $local .= $row['distrito'] . "; \r";
//            $estimativa .= $row['estimativaPublico']."\r";
//            $logradouro .= $row['logradouro']. ", ".$row['numero']." ".$row['complemento']."\r";
//            $bairro .= $row['bairro']."\r";
//            $cidade .= $row['cidade']."\r";

            $array = array(
                "local" => substr($local, 0, -1),
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

    $sql_orc = "SELECT SUM(orc.valorTotal) as valorTotal
                    FROM orcamento AS orc LEFT JOIN projeto AS pr ON pr.idProjeto = orc.idProjeto
                    WHERE orc.publicado = '1' AND orc.idProjeto = {$row['idProjeto']}";
    $query3 = mysqli_query($con, $sql_orc);
    $orcamento = mysqli_fetch_array($query3);

    if ($row['tipoPessoa'] == 2) {
        $pj = recuperaDados("pessoa_juridica", "idPj", $row['idPj']);
        $proponente = $pj != null ? $pj['razaoSocial'] : '';
        $documento = $pj != null ? $pj['cnpj'] : '';
        $email = $pj != null ? $pj['email'] : '';
        $logradouro = $pj != null ? $pj['logradouro'] : '';
        $numero = $pj != null ? $pj['numero'] : '';
        $complemento = $pj != null ? $pj['complemento'] : '';
        $bairro = $pj != null ? $pj['bairro'] : '';
        $cidade = $pj != null ? $pj['cidade'] : '';
        $estado = $pj != null ? $pj['estado'] : '';
        $cep = $pj != null ? $pj['cep'] : '';

        $endereco = "$logradouro , $numero - $bairro, $estado - $cep";
        if ($pj != null) {
            $subprefeitura = $pj['idSubprefeitura'] ? recuperaDados('subprefeitura','idSubprefeitura',$pj['idSubprefeitura']) : '';
            $distrito = $pj['idDistrito'] ? recuperaDados('distrito','idDistrito',$pj['idDistrito']) : '';
        }
    } else {
        $pf = recuperaDados("pessoa_fisica", "idPf", $row['idPf']);
        $proponente = $pf != null ? $pf['nome'] : '';
        $documento = $pf != null ? $pf['cpf'] : '';
        $email = $pf != null ? $pf['email'] : '';
        $logradouro = $pf != null ? $pf['logradouro'] : '';
        $numero = $pf != null ? $pf['numero'] : '';
        $complemento = $pf != null ? $pf['complemento'] : '';
        $bairro = $pf != null ? $pf['bairro'] : '';
        $cidade = $pf != null ? $pf['cidade'] : '';
        $estado = $pf != null ? $pf['estado'] : '';
        $cep = $pf != null ? $pf['cep'] : '';

        $endereco = "$logradouro , $numero - $bairro, $estado - $cep";

        if ($pf != null){
            $subprefeitura = $pf['idSubprefeitura'] ? recuperaDados('subprefeitura','idSubprefeitura',$pf['idSubprefeitura']) : '';
            $distrito = $pf['idDistrito'] ? recuperaDados('distrito','idDistrito',$pf['idDistrito']) : '';
        }
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

    $tags = gerarTag($row['idProjeto']);
    $lista_local = listaLocal($row['idProjeto']);
    $posto_trabalho = recuperaDados("postos_trabalho", "idProjeto", $row['idProjeto']);

    $objPHPExcel->getActiveSheet()->getStyle('A' . $i . '')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
    $objPHPExcel->getActiveSheet()->getStyle('E' . $i . '')->getNumberFormat()->setFormatCode("#,##0.00");
    $objPHPExcel->getActiveSheet()->getStyle('F' . $i . '')->getNumberFormat()->setFormatCode("#,##0.00");


    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A' . $i, $row['edital'])
        ->setCellValue('B' . $i, $row['protocolo'])
        ->setCellValue('C' . $i, $row['nomeProjeto'])
        ->setCellValue('D' . $i, $row['resumoProjeto'])
        ->setCellValue('E' . $i, $lista_local ? $lista_local['local'] : '')
        ->setCellValue('F' . $i, $row['etapaProjeto'])
        ->setCellValue('G' . $i, $orcamento['valorTotal'] != null ? dinheiroParaBr($orcamento['valorTotal']) : '')
        ->setCellValue('H' . $i, $row['status'])
        ->setCellValue('I' . $i, $proponente)
        ->setCellValue('J' . $i, $endereco)
        ->setCellValue('K' . $i, $infoPessoa != null ? $infoPessoa['genero'] : '')
        ->setCellValue('L' . $i, $infoPessoa != null ? $infoPessoa['etnia'] : '')
        ->setCellValue('M' . $i, $tipo)
        ->setCellValue('N' . $i, $documento)
        ->setCellValue('O' . $i, $subprefeitura ? $subprefeitura['subprefeitura'] : '')
        ->setCellValue('P' . $i, $distrito ? $distrito['distrito'] : '')
        ->setCellValue('Q' . $i, $email)
        ->setCellValue('R' . $i, $row['areaAtuacao'])
        ->setCellValue('S' . $i, $tags)
        ->setCellValue('T' . $i, $posto_trabalho != null ? $posto_trabalho['quantidade'] : '')
        ->setCellValue('U' . $i, $posto_trabalho != null ? dinheiroParaBr($posto_trabalho['media_valor']) : '');

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