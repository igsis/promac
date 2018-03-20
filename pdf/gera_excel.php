<?php

require_once "../funcoes/funcoesConecta.php";
require_once '../include/phpexcel/Classes/PHPExcel.php';

$con = bancoMysqli();

$tipoPessoa = $_GET['tipo'];
$idProjeto = $_GET['projeto'];
$idPessoa = $_GET['pessoa'];

if($tipoPessoa == 1)
{
	$objPHPExcel = new PHPExcel(); // instância da classe

	$objPHPExcel->getProperties()->setCreator("PROMAC")
	->setLastModifiedBy("Secretaria da Cultura")
	->setTitle("Relatório de Projeto");

	$query = "SELECT * FROM pessoa_fisica WHERE idPf = '$idPessoa'";
	$queryP = "SELECT * FROM projeto WHERE idProjeto = '$idProjeto'";
	$queryLocal = "SELECT local FROM locais_realizacao WHERE idProjeto = '$idProjeto' AND publicado='1'";

	$envio = mysqli_query($con, $query);
	while($row = mysqli_fetch_array($envio))
	{
		$nome = $row['nome'];
		$cpf = $row['cpf'];
		$rg = $row['rg'];
		$cep = $row['cep'];
		$endereco = $row['logradouro'];
		$telefone = $row['telefone'];
		$celular = $row['celular'];
		$email = $row['email'];

		if($row['cooperado'] == 1)
			$cooperado = 'sim';
		else
			$cooperado = 'não';
	}
	$envioP = mysqli_query($con, $queryP);
	while($rowP = mysqli_fetch_array($envioP))
	{
		$idAreaAtuacao = $rowP['idAreaAtuacao'];
		$valorTotal = $rowP['valorProjeto'];
		$valorIncentivo = $rowP['valorIncentivo'];
		$valorOutros = $rowP['valorFinanciamento'];
		$enquadramentoFiscal = $rowP['idRenunciaFiscal'];
		$descricaoExposicao = $rowP['exposicaoMarca'];
		$resumoProjeto = $rowP['resumoProjeto'];
		$dataInicio = $rowP['inicioCronograma'];
		$dataFim = $rowP['fimCronograma'];

	}
	$envioLocal = mysqli_query($con, $queryLocal);
	$rowL = mysqli_fetch_array($envioLocal);
	$local = $rowL['local'];

	$queryAtuacao = "SELECT areaAtuacao FROM area_atuacao WHERE idArea = '$idAreaAtuacao'";
	$envioAtuacao = mysqli_query($con, $queryAtuacao);
	$rowA = mysqli_fetch_array($envioAtuacao);
	$atuacao = $rowA['areaAtuacao'];

	$queryRenuncia = "SELECT renunciaFiscal FROM renuncia_fiscal WHERE idRenuncia = '$enquadramentoFiscal'";
	$envioRenuncia = mysqli_query($con, $queryRenuncia);
	$rowR = mysqli_fetch_array($envioRenuncia);
	$renuncia = $rowR['renunciaFiscal'];

	$objPHPExcel->setActiveSheetIndex(0) // define folha 0
	->setCellValue('A1', 'Nome')
	->setCellValue('A2', $nome)

	->setCellValue('A4', 'Área de Atuação')
	->setCellValue('A5',  $atuacao)

	->setCellValue('B1', 'CPF')
	->setCellValue('B2', $cpf)

	->setCellValue('B4', 'Valor total do projeto')
	->setCellValue('B5', $valorTotal)

	->setCellValue('C1', 'RG')
	->setCellValue('C2', $rg)

	->setCellValue('C4', 'Valor solicitado como incentivo')
	->setCellValue('C5', $valorIncentivo)

	->setCellValue('D1', 'CEP')
	->setCellValue('D2', $cep)

	->setCellValue('D4', 'Valor de outros incentivos')
	->setCellValue('D5', $valorOutros)

	->setCellValue('E1', 'Endereço')
	->setCellValue('E2', $endereco)

	->setCellValue('E4', 'Enquadramento da renúncia fiscal')
	->setCellValue('E5', $renuncia)

	->setCellValue('F1', 'Telefone')
	->setCellValue('F2', $telefone)

	->setCellValue('F4', 'Descrição da exposição da marca')
	->setCellValue('F5', $descricaoExposicao)

	->setCellValue('G1', 'Celular')
	->setCellValue('G2', $celular)

	->setCellValue('G4', 'Resumo do projeto')
	->setCellValue('G5', $resumoProjeto)

	->setCellValue('H1', 'Email')
	->setCellValue('H2', $email)

	->setCellValue('H4', 'Local de realização')
	->setCellValue('H5', $local)

	->setCellValue('I1', 'Cooperado')
	->setCellValue('I2', $cooperado)

	->setCellValue('I4', 'Data de início')
	->setCellValue('I5', $dataInicio)

	->setCellValue('J4', 'Data de fim')
	->setCellValue('J5', $dataFim);


	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); // redimensionamento automático
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true); // negrito
	$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('E4')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('F4')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('G4')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('H4')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('I4')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('J4')->getFont()->setBold(true);


	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); // indicação p criar ficheiro

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="pessoaFisica.xls"');
	header('Cache-Control: max-age=0');
} 
else if($tipoPessoa == 2)
{
	$objPHPExcel = new PHPExcel(); // instância da classe

	$objPHPExcel->getProperties()->setCreator("PROMAC")
	->setLastModifiedBy("Secretaria da Cultura")
	->setTitle("Relatório de Projeto");

	$query = "SELECT * FROM pessoa_juridica WHERE idPj = '$idPessoa'";
	$queryP = "SELECT * FROM projeto WHERE idProjeto = '$idProjeto'";
	$queryLocal = "SELECT local FROM locais_realizacao WHERE idProjeto = '$idProjeto' AND publicado='1'";

	$envio = mysqli_query($con, $query);
	while($row = mysqli_fetch_array($envio))
	{
		$razaoSocial= $row['razaoSocial'];
		$cnpj = $row['cnpj'];
		$cep = $row['cep'];
		$enderecoPJ = $row['logradouro'];
		$telefonePJ = $row['telefone'];
		$celularPJ = $row['celular'];
		$emailPJ = $row['email'];

		if($row['cooperativa'] == 1)
			$cooperativa = 'sim';
		else
			$cooperativa = 'não';

		$representante = $row['idRepresentanteLegal'];
	}

	$queryRep = "SELECT * FROM representante_legal WHERE idRepresentanteLegal = '$representante'";
	$envioRep = mysqli_query($con, $queryRep);
	while($rowRep = mysqli_fetch_array($envioRep))
	{
		$nomeRepresentante = $rowRep['nome'];
		$cpfRepresentante = $rowRep['cpf'];
		$rgRepresentante = $rowRep['rg'];
		$cepRepresentante = $rowRep['cep'];
		$enderecoRepresentante = $rowRep['logradouro'];
		$telefoneRepresentante = $rowRep['telefone'];
		$celularRepresentante = $rowRep['celular'];
		$emailRepresentante = $rowRep['email'];

	}

	$envioP = mysqli_query($con, $queryP);
	while($rowP = mysqli_fetch_array($envioP))
	{
		$idAreaAtuacao = $rowP['idAreaAtuacao'];
		$valorTotal = $rowP['valorProjeto'];
		$valorIncentivo = $rowP['valorIncentivo'];
		$valorOutros = $rowP['valorFinanciamento'];
		$enquadramentoFiscal = $rowP['idRenunciaFiscal'];
		$descricaoExposicao = $rowP['exposicaoMarca'];
		$resumoProjeto = $rowP['resumoProjeto'];
		$dataInicio = $rowP['inicioCronograma'];
		$dataFim = $rowP['fimCronograma'];

	}
	$envioLocal = mysqli_query($con, $queryLocal);
	$rowL = mysqli_fetch_array($envioLocal);
	$local = $rowL['local'];

	$queryAtuacao = "SELECT areaAtuacao FROM area_atuacao WHERE idArea = '$idAreaAtuacao'";
	$envioAtuacao = mysqli_query($con, $queryAtuacao);
	$rowA = mysqli_fetch_array($envioAtuacao);
	$atuacao = $rowA['areaAtuacao'];

	$queryRenuncia = "SELECT renunciaFiscal FROM renuncia_fiscal WHERE idRenuncia = '$enquadramentoFiscal'";
	$envioRenuncia = mysqli_query($con, $queryRenuncia);
	$rowR = mysqli_fetch_array($envioRenuncia);
	$renuncia = $rowR['renunciaFiscal'];

	$objPHPExcel->setActiveSheetIndex(0) // define folha 0
	->setCellValue('A1', 'Razão Social')
	->setCellValue('A2', $razaoSocial)

	->setCellValue('B1', 'CNPJ')
	->setCellValue('B2',  $cnpj)

	->setCellValue('C1', 'CEP')
	->setCellValue('C2', $cep)

	->setCellValue('D1', 'Endereço')
	->setCellValue('D2', $enderecoPJ)

	->setCellValue('E1', 'Telefone')
	->setCellValue('E2', $telefonePJ)

	->setCellValue('F1', 'Celular')
	->setCellValue('F2', $celularPJ)

	->setCellValue('G1', 'Email')
	->setCellValue('G2', $emailPJ)

	->setCellValue('H1', 'Cooperativa')
	->setCellValue('H2', $cooperativa)

	->setCellValue('I1', 'Responsável legal')
	->setCellValue('I2', $nomeRepresentante)

	->setCellValue('J1', 'CPF')
	->setCellValue('J2', $cpfRepresentante)

	->setCellValue('K1', 'Telefone')
	->setCellValue('K2', $telefoneRepresentante)

	->setCellValue('L1', 'Celular')
	->setCellValue('L2', $celularRepresentante)

	->setCellValue('A4', 'Área de Atuação')
	->setCellValue('A5',  $atuacao)

	->setCellValue('B4', 'Valor total do projeto')
	->setCellValue('B5', $valorTotal)

	->setCellValue('C4', 'Valor solicitado como incentivo')
	->setCellValue('C5', $valorIncentivo)


	->setCellValue('D4', 'Valor de outros incentivos')
	->setCellValue('D5', $valorOutros)

	->setCellValue('E4', 'Enquadramento da renúncia fiscal')
	->setCellValue('E5', $renuncia)

	->setCellValue('F4', 'Descrição da exposição da marca')
	->setCellValue('F5', $descricaoExposicao)

	->setCellValue('G4', 'Resumo do projeto')
	->setCellValue('G5', $resumoProjeto)

	->setCellValue('H4', 'Local de realização')
	->setCellValue('H5', $local)

	->setCellValue('I4', 'Data de início')
	->setCellValue('I5', $dataInicio)

	->setCellValue('J4', 'Data de fim')
	->setCellValue('J5', $dataFim);


	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true); // redimensionamento automático
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

	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true); // negrito
	$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('E4')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('F4')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('G4')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('H4')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle('I4')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true); 
	$objPHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true); 

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); // indicação p criar ficheiro

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="pessoaJuridica.xls"');
	header('Cache-Control: max-age=0');

}

$objWriter->save('php://output');

?>
