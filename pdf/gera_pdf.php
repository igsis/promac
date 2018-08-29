<?php

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once("../include/lib/fpdf/fpdf.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

//CONEXÃO COM BANCO DE DADOS
$con = bancoMysqli();

$tipoPessoa = $_GET['tipo'];
$idProjeto = $_GET['projeto'];
$idPessoa = $_GET['pessoa'];

session_start();

class PDF extends FPDF
{

  // Simple table 
  function BasicTable($header, $data)
  {
      // Header
      foreach($header as $col)
          $this->Cell(40,7,$col,1);
      $this->Ln();
      // Data
      foreach($data as $row)
      {
          foreach($row as $col)
              $this->Cell(40,6,$col,1);
          $this->Ln();
      }
  }

  // Simple table
  function Cabecalho($header, $data)
  {
      // Header
      foreach($header as $col)
          $this->Cell(40,7,$col,1);
      $this->Ln();
      // Data

  }

  // Simple table
  function Tabela($header, $data)
  {
      //Data
      foreach($data as $col)
          $this->Cell(40,7,$col,1);
      $this->Ln();
      // Data

  }


  }

  $ano=date('Y');

  $queryProjeto = "SELECT * FROM projeto WHERE idProjeto = '$idProjeto'";
  $enviaP = mysqli_query($con, $queryProjeto);
  /*
    Dados gerais do projeto.
  */
  while($row = mysqli_fetch_array($enviaP))
  {
    $protocoloP = $row['protocolo'];
    $nomeProjeto = $row['nomeProjeto'];
    $idAreaAtuacao = $row['idAreaAtuacao']; //search it
    $vProjeto = $row['valorProjeto'];
    $vIncentivo = $row['valorIncentivo'];
    $vFinanciamento = $row['valorFinanciamento'];
    $idRenunciaFiscal = $row['idRenunciaFiscal']; //search it
    $exposicaoMarca = $row['exposicaoMarca'];
    $resumoProjeto = $row['resumoProjeto'];
    $curriculo = $row['curriculo'];
    $descricao = $row['descricao'];
    $justificativa = $row['justificativa'];
    $objetivo = $row['objetivo'];
    $metodologia = $row['metodologia'];
    $contrapartida = $row['contrapartida'];
    $publicoAlvo = $row['publicoAlvo'];
    $planoDivulgacao = $row['planoDivulgacao'];
    $inicioCronograma = $row['inicioCronograma'];
    $fimCronograma = $row['fimCronograma'];
    $idCronograma = $row['idCronograma']; //search it
    $totalPreProducao = $row['totalPreProducao'];
    $totalProducao = $row['totalProducao'];
    $totalImprensa = $row['totalImprensa'];
    $totalAdministrativos = $row['totalCustosAdministrativos'];
    $totalImpostos = $row['totalImpostos'];
    $totalAgenciamento = $row['totalAgenciamento'];
    $totalOutrosFinanciamentos = $row['totalOutrosFinanciamentos'];
    $video1 = $row['video1'];
    $video2 = $row['video2'];
    $video3 = $row['video3'];
    $valorAProvado = $row['valorAprovado'];
    $idStatus = $row['idStatus'];
  }

  /*
    Dados de renúncia fiscal.
  */
  $queryRen = "SELECT renunciaFiscal from renuncia_fiscal where idRenuncia = '$idRenunciaFiscal'";
  $enviaRen = mysqli_query($con, $queryRen);
  $rows = mysqli_fetch_array($enviaRen);
  $renunciaFiscal = $rows['renunciaFiscal'];

  /*
    Dados do cronograma.
  */
  $queryCrono = "SELECT * FROM cronograma WHERE idCronograma = '$idCronograma'";
  $enviaCrono = mysqli_query($con, $queryCrono);
  while($rowCron = mysqli_fetch_array($enviaCrono))
  {
    $captacaoRecurso = $rowCron['captacaoRecurso'];
    $preProducao = $rowCron['preProducao'];
    $producao = $rowCron['producao'];
    $posProducao = $rowCron['posProducao'];
    $prestacaoContas = $rowCron['prestacaoContas'];
  }

  /*
    Dados da área de atuação.
  */
  $queryAreaAt = "SELECT areaAtuacao FROM area_atuacao WHERE idArea = '$idAreaAtuacao'";
  $enviaAreaAt = mysqli_query($con, $queryAreaAt);
  $rowArea = mysqli_fetch_array($enviaAreaAt);
  $areaAtuacao = $rowArea['areaAtuacao'];

  /*
    Dados de orçamento.
  */
    $queryOrca = "SELECT * FROM orcamento WHERE idProjeto = '$idProjeto'";
    $enviaOrca = mysqli_query($con, $queryOrca);
    $o_num = 0;
    while($rowOrca = mysqli_fetch_array($enviaOrca))
    {
      $idEtapa = $rowOrca['idEtapa']; //search it
      $descricao = $rowOrca['descricao'];
      $quantidade = $rowOrca['quantidade'];
      $unidadeMedida = $rowOrca['idUnidadeMedida']; // search it
      $quantidadeUnidade = $rowOrca['quantidadeUnidade'];
      $valorUnitario = $rowOrca['valorUnitario'];
      $valorTotal = $rowOrca['valorTotal'];
      $o_num ++;
    }

    /*
      Dados da etapa;
    */
      $queryEtapa = "SELECT etapa FROM etapa WHERE idEtapa = '$idEtapa'";
      $enviaEtapa = mysqli_query($con, $queryEtapa);
      $rowEtapa = mysqli_fetch_array($enviaEtapa);
      $etapaStatus = $rowEtapa['etapa'];

    /*
      Dados da unidade de medida.
    */
      $queryUn = "SELECT unidadeMedida FROM unidade_medida WHERE idUnidadeMedida = '$unidadeMedida'";
      $enviaUn = mysqli_query($con, $queryUn);
      $rowUn = mysqli_fetch_array($enviaUn);
      $unidadeMedidaStatus = $rowUn['unidadeMedida']; 

    /*
      Dados dos locais de realização.
    */
      $queryLocal = "SELECT * FROM locais_realizacao WHERE idProjeto = '$idProjeto'";
      $enviaLocal = mysqli_query($con, $queryLocal);
      while($rowLocal = mysqli_fetch_array($enviaLocal))
      {
        $local = $rowLocal['local'];
        $estimativa = $rowLocal['estimativaPublico'];
        $idZona = $rowLocal['idZona']; //search it
      }

    /*
      Dados da zona de localização.
    */
      $queryZN = "SELECT zona FROM zona where idZona = '$idZona'";
      $enviaZN = mysqli_query($con, $queryZN);
      $rowZN = mysqli_fetch_array($enviaZN);
      $zona = $rowZN['zona'];

    /*
      Dados das notas.
    */
      $queryNota = "SELECT * FROM notas WHERE idProjeto = '$idProjeto'";
      $enviaNota = mysqli_query($con, $queryNota);
      while($rowNota = mysqli_fetch_array($enviaNota))
      {
        $dataNota = $rowNota['data'];
        $notaN = $rowNota['nota'];
      }

        //GERANDO O PDF:
    $pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
    $pdf->AliasNbPages();
    $pdf->AddPage();

    $x=20;
    $l=6; //DEFINE A ALTURA DA LINHA   
         
    $pdf->SetXY( $x , 15 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA
     
     $pdf->SetX($x);
     $pdf->SetFont('Arial','B', 16);
     $pdf->Cell(180,5,utf8_decode(strtoupper("Projeto: $nomeProjeto")),0,1,'C');
     
     $pdf->Ln();
     $pdf->Ln();
     

    if($tipoPessoa == 1) 
    {
      $pf = recuperaDados("pessoa_fisica","idPf",$idPessoa);
      $NomePF = $pf["nome"];
      $RGPF = $pf["rg"];
      $CPF = $pf["cpf"];
      $EnderecoPF = $pf ["logradouro"];
      $NumeroPF = $pf["numero"];
      $BairroPF = $pf["bairro"];
      $CidadePF = $pf["cidade"];
      $estadoPF = $pf['estado'];
      $CepPF = $pf["cep"];
      $numeroPF = $pf['numero'];
      $complementoPF = $pf['complemento'];
      $telefonePF = $pf['telefone'];
      $celularPF = $pf['celular'];
      $emailPF = $pf['email'];

      if($pf['cooperado'] == 1)
      {
        $cooperadoPF = "sim";
      }
      else if($pf['cooperado'] == 2)
      {
        $cooperadoPF = "não";
      }

      $pdf->SetX($x);
      $pdf->SetFont('Arial','B', 14);
      $pdf->Cell(180,5,utf8_decode("Dados de pessoa física"),0,1,'C');
      
      $pdf->Ln();

      $pdf->SetX($x);
      $pdf->SetFont('Arial','B', 11);
      $pdf->Cell(14,$l,utf8_decode("Nome:"),0,0,'L');
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(162,$l,utf8_decode($NomePF));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','B', 11);
      $pdf->Cell(8,$l,utf8_decode("RG:"),0,0,'L');
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode($RGPF));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','B', 11);
      $pdf->Cell(10,$l,utf8_decode("CPF:"),0,0,'L');
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode($CPF));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','B', 11);
      $pdf->Cell(20,$l,utf8_decode("Endereço:"),0,0,'L');
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(180,$l,utf8_decode($EnderecoPF.", ".$numeroPF." ".$complementoPF." - ".$CidadePF." - ".$estadoPF));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','B', 11);
      $pdf->Cell(20,$l,utf8_decode("Telefone:"),0,0,'L');
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode($telefonePF." | ".$celularPF));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','B', 11);
      $pdf->Cell(13,$l,utf8_decode("Email:"),0,0,'L');
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode($emailPF));
    }
    else if($tipoPessoa == 2)
    {
      $pj = recuperaDados("pessoa_juridica","idPj",$idPessoa);
      $razaoSocial = $pj['razaoSocial'];
      $cnpj = $pj['cnpj'];
      $logradouroPJ = $pj['logradouro'];
      $bairroPJ = $pj['bairro'];
      $cidadePJ = $pj['cidade'];
      $estadoPJ = $pj['estado'];
      $cepPJ = $pj['cep'];
      $numeroPJ = $pj['numero'];
      $complementoPJ = $pj['complemento'];
      $telefonePJ = $pj['telefone'];
      $celularPJ = $pj['celular'];
      $emailPJ = $pj['email'];

      if($pj['cooperativa'] == 1)
      {
        $cooperativa = "sim";
      } else if($pj['cooperativa'] == 2){
        $cooperativa = "não";
      }

      $idRepresentante = $pj['idRepresentanteLegal'];

      $queryRep = "SELECT * FROM representante_legal WHERE idRepresentanteLegal = '$idRepresentante'";
      $enviaRep = mysqli_query($con, $queryRep);
      while($rowRep = mysqli_fetch_array($enviaRep))
      {
        $nomeRep = $rowRep['nome'];
        $cpfRep = $rowRep['cpf'];
        $rgRep = $rowRep['rg'];
        $logradouroRep = $rowRep['logradouro'];
        $bairroRep = $rowRep['bairro'];
        $cidadeRep = $rowRep['cidade'];
        $estadoRep = $rowRep['estado'];
        $cepRep = $rowRep['cep'];
        $numeroRep = $rowRep['numero'];
        $complementoRep = $rowRep['complemento'];
        $telefoneRep = $rowRep['telefone'];
        $celularRep = $rowRep['celular'];
        $emailRep = $rowRep['email'];
      }

      $pdf->SetX($x);
      $pdf->SetFont('Arial','B', 14);
      $pdf->Cell(180,5,utf8_decode("Dados de pessoa jurídica"),0,1,'C');
      $pdf->Ln();

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Razão Social: " . $razaoSocial));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("CNPJ: " . $cnpj));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','B', 11);
      $pdf->Cell(20,$l,utf8_decode("Endereço:"),0,0,'L');
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(180,$l,utf8_decode($logradouroPJ.", ".$numeroPJ." ".$complementoPJ." - ".$bairroPJ." - ".$cidadePJ." - ".$estadoPJ));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','B', 11);
      $pdf->Cell(20,$l,utf8_decode("Telefone:"),0,0,'L');
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode($telefonePJ." | ".$celularPJ));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Email: " . $emailPJ));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','B', 12);
      $pdf->Cell(180,5,utf8_decode("Representante legal"),0,1,'C');
      $pdf->Ln();

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Nome: " . $nomeRep));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("CPF: " . $cpfRep));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("RG: " . $rgRep));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Endereço: " . $logradouroRep));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Bairro: " . $bairroRep));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Estado: " . $estadoRep));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("CEP: " . $cepRep));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Número: " . $numeroRep));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Complemento: " . $complementoRep));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Telefone: " . $telefoneRep));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Celular: " . $celularRep));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Email: " . $emailRep));
    }

    $pdf->Ln();
    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 14);
    $pdf->Cell(180,$l,utf8_decode("Dados do projeto"),0,1,'C');

    $pdf->Ln();

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(21,$l,utf8_decode("Protocolo:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(60,$l,utf8_decode($protocoloP),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(32,$l,utf8_decode("Área de atuação:"),0,1,'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial','', 11);
    $pdf->MultiCell(170,$l,utf8_decode($areaAtuacao));

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(32,$l,utf8_decode("Valor do projeto:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(60,$l,utf8_decode("R$ ".dinheiroParabr($vProjeto)),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(36,$l,utf8_decode("Valor do incentivo:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(60,$l,utf8_decode("R$ ".dinheiroParabr($vIncentivo)),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(31,$l,utf8_decode("Renúncia fiscal:"),0,0,'L');
    $pdf->SetFont('Arial','', 11);
    $pdf->Cell(60,$l,utf8_decode($renunciaFiscal),0,1,'L');

    $pdf->SetX($x);
    $pdf->SetFont('Arial','B', 11);
    $pdf->Cell(31,$l,utf8_decode("Exposição da marca:"),0,1,'L');
    $pdf->SetX($x);
    $pdf->SetFont('Arial','', 11);
    $pdf->MultiCell(170,$l,utf8_decode($exposicaoMarca));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Resumo do projeto: " . $resumoProjeto));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Currículo: " . $curriculo));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Descrição: " . $descricao));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Justificativa: " . $justificativa));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Objetivo: " . $objetivo));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Metodologia: " . $metodologia));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Contrapartida: " . $contrapartida));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Público alvo: " . $publicoAlvo));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Plano de divulgação: " . $planoDivulgacao));

     $pdf->Ln();

     $pdf->SetX($x);
     $pdf->SetFont('Arial','B', 12);
     $pdf->Cell(180,5,utf8_decode("Dados de custos e prazos"),0,1,'C');
     $pdf->Ln();

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Início do cronograma: " . $inicioCronograma));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Fim do cronograma: " . $fimCronograma));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Captão de recursos: " . $captacaoRecurso));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Pré produção: " . $preProducao));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Total pré produção: " . $totalProducao));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Produção: " . $producao));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Total produção: " . $totalProducao));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Pós produção: " . $posProducao));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Prestação de contas: " . $prestacaoContas));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Total imprensa: " . $totalImprensa));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Total dos custos administrativos: " . $totalAdministrativos));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Total ímpostos: " . $totalImpostos));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Total do agenciamento: " . $totalAgenciamento));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Total de outros financiamentos: " . $totalOutrosFinanciamentos));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Valor aprovado: " . $valorAProvado));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','B', 12);
     $pdf->Cell(180,5,utf8_decode("Orçamento"),0,1,'C');
     $pdf->Ln();

    for($i = 0; $i < $o_num; $i++)
    {
      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Etapa: " . $etapaStatus));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Descrição: " . $descricao));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','B', 10);
      $pdf->Cell(22,$l,'Quantidade:',0,0,'L');
      $pdf->SetFont('Arial','', 10);
      $pdf->MultiCell(150,$l,utf8_decode($quantidade));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Unidade de medida: " . $unidadeMedidaStatus));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Quantidade de unidades: " . $quantidadeUnidade));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Valor unitário: " . $valorUnitario));

      $pdf->SetX($x);
      $pdf->SetFont('Arial','', 11);
      $pdf->MultiCell(170,$l,utf8_decode("Valor total: " . $valorTotal));

      $pdf->Ln();
    }

     $pdf->SetX($x);
     $pdf->SetFont('Arial','B', 12);
     $pdf->Cell(180,5,utf8_decode("Mídias"),0,1,'C');
     $pdf->Ln();

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Link 1: " . $video1));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Link 2: " . $video2));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Link 3: " . $video3));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','B', 12);
     $pdf->Cell(180,5,utf8_decode("Locais de realização"),0,1,'C');
     $pdf->Ln();

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Local " . $local));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Estimativa: " . $estimativa));

     $pdf->SetX($x);
     $pdf->SetFont('Arial','', 11);
     $pdf->MultiCell(170,$l,utf8_decode("Zona: " . $zona));

     $pdf->Ln();
     $pdf->Ln();
     $pdf->Ln();


  $pdf->Output();


?>