<?php
// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once("../include/lib/fpdf/fpdf.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

//CONEXÃO COM BANCO DE DADOS
$con = bancoMysqli();

setlocale(LC_TIME, 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

session_start();

class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        $this->Image('../visual/images/brasao.jpg',20,15,15);
        $this->Ln(3);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,8,utf8_decode("PREFEITURA DO MUNICÍCIO DE SÃO PAULO"),0,1,'C');
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,8,utf8_decode("SECRETARIA MUNICIPAL DE CULTURA"),0,1,'C');
        $this->Cell(80);
        // Title
        $this->Cell(30,8,utf8_decode("Coordenadoria de Incentivo à Cultura - Pro-Mac"),0,1,'C');
        // Line break
        $this->Ln(10);
    }
}
$idProjeto = $_POST['idProjeto'];

$dateNow = date('d/m/Y');
$rodape = strftime('%d de %B de %Y', strtotime($dateNow));

$queryProjeto = "SELECT nomeProjeto, tipoPessoa,idPf,idPj, valorAprovado, idRenunciaFiscal, dataPublicacaoDoc FROM projeto WHERE idProjeto = '$idProjeto' AND publicado = 1";
$enviaP = mysqli_query($con, $queryProjeto);
$row = mysqli_fetch_array($enviaP);
$nomeProjeto = $row['nomeProjeto'];
$tipoPessoa  = $row['tipoPessoa'];
$idPf  = $row['idPf'];
$idPj  = $row['idPj'];
$valorAprovado  = $row['valorAprovado'];
$idRenunciaFiscal = $row['idRenunciaFiscal'];
$dataPublicacaoDoc = $row['dataPublicacaoDoc'];


if($tipoPessoa == 1) {
    $sql_pf = "SELECT * FROM pessoa_fisica WHERE idPf = '$idPf'";
    $query_pf = mysqli_query($con, $sql_pf);
    $pf = mysqli_fetch_array($query_pf);
    $proponente = $pf["nome"];
    $documento = $pf["cpf"];
}
else{
    $sql_pj = "SELECT * FROM pessoa_juridica WHERE idPj = '$idPj'";
    $query_pj = mysqli_query($con, $sql_pj);
    $pj = mysqli_fetch_array($query_pj);
    $proponente = $pj["razaoSocial"];
    $documento = $pj["cnpj"];
}

$renuncia = recuperaDados("renuncia_fiscal","idRenuncia",$idRenunciaFiscal);


//GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

$x=20;
$l=6; //DEFINE A ALTURA DA LINHA


$pdf->SetXY( $x , 35 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->Ln(15);

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(170,$l,utf8_decode("TERMO DE RESPONSABILIDADE DE REALIZAÇÃO DE PROJETO CULTURAL"),0,1,'C');

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(25,$l,utf8_decode("Proponente:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode($proponente));

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(16,$l,utf8_decode("Projeto:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(170,$l,utf8_decode($nomeProjeto));

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(22,$l,utf8_decode("CPF/CNPJ:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(170,$l,utf8_decode($documento),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(31,$l,utf8_decode("Valor aprovado:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(170,$l,utf8_decode("R$ ".dinheiroParaBr($valorAprovado)),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(46,$l,utf8_decode("Porcentual da renúncia:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(170,$l,utf8_decode($renuncia['renunciaFiscal']),0,1,'L');

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(32,$l,utf8_decode("Data aprovação:"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->Cell(170,$l,exibirDataBr($dataPublicacaoDoc),0,1,'L');

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(32,$l,utf8_decode("CABERÁ AO PROPONENTE:"),0,1,'L');

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(5,$l,utf8_decode("a) "),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Executar o projeto conforme proposta aprovada;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("b) "),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Realizar a aplicação financeira do recurso, que deverá ser de liquidez imediata, composta majoritariamente por títulos públicos com classificação de baixo nível de risco;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("c) "),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Abrir duas contas no Banco do Brasil para depósito e movimentação exclusivos dos recursos do projeto aprovado: uma conta de captação e outra conta de movimentação;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("d)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Não movimentar a conta de captação, sendo esta destinada apenas para fins de depósito do incentivador;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("e)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Solicitar à Secretaria Municipal de Cultura autorização para efetuar a transferência da conta de captação para a conta de movimentação, após a captação haver atingido ao menos 35% (trinta e cinco por cento) do valor aprovado e enviar juntamente à solicitação os extratos da conta de captação e da conta de movimentação;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("f)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Responsabilizar-se pela movimentação bancária, na conta de movimentação;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("g)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Expor a logomarca no projeto, conforme Manual de Utilização da Marca;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("h)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Arrecadar os valores necessários à execução do projeto no período restante do exercício fiscal em que tiver sido aprovado e responsabilizar-se pela captação de outras fontes de recursos, caso tenha informado no projeto aprovado;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("i)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Solicitar à Secretaria Municipal de Cultura prorrogação do prazo de captação, que poderá ser estendo por até 01 (um) ano. A solicitação deverá ser feita no mínimo 30 (trinta) dias antes do término do prazo de captação;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("j)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Caso seja cancelado o projeto, solicitar à Secretaria Municipal de Cultura, antes do término do prazo de captação e após anuência do incentivador, a transferência do recurso a outro projeto do mesmo proponente ou para outro que esse indicar;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("k)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Realizar o projeto dentro do prazo de 18 (dezoito) meses, após a liberação do recurso;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("l)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Enviar à Coordenadoria de Incentivo à Cultura, com no mínimo 10 (dez) dias de antecedência, o cronograma completo das estreias, apresentações, exposições, entre outros, contendo a definição do(s) local(is) e horário(s);"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("m)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Solicitar à Secretaria Municipal de Cultura, caso necessite, prorrogação do prazo de execução, que poderá ser estendo por até 06 (seis) meses, no mínimo 30 (trinta) dias antes do término do prazo de execução;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("n)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Responsabilizar-se pelos compromissos e encargos de natureza trabalhista, previdenciária, fiscal, comercial, bancária, intelectual (direito autoral, inclusive os conexos, e de propriedade industrial), bem como quaisquer outros resultantes deste ajuste;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("o)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Prestar contas dentro das normas previstas na Portaria SMC - 39/2018, em até 30 (trinta) dias contados do encerramento da execução do projeto;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("p)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Caso seja notificado pela Secretaria Municipal de Cultura, o proponente deverá apresentar esclarecimentos, encaminhar documentos e regularizar a situação referente à prestação de contas, no prazo de até 20 (vinte) dias corridos da notificação;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("q)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Aguardar a aprovação de prestação de contas para inscrever novo projeto. Caso a Secretaria Municipal de Cultura não se manifeste em até 30 (trinta) dias corridos após a entrega da prestação de contas, o proponente poderá inscrever novo projeto, que será cancelado caso seja julgado irregularidade na prestação de contas;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("r)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Informar ao incentivador que é de sua estrita responsabilidade efetuar o cálculo da renúncia e realizar os depósitos dentro dos prazos previstos;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("s)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Manter todos os dados cadastrais devidamente atualizados no Sistema Pro-Mac;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("t)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Estar ciente que sua responsabilidade sobre o projeto é indelegável;"));

$pdf->SetX($x);;
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(6,$l,utf8_decode("u)	"),0,0,'L');
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("Ter ciência que a notificação por correspondência eletrônica é um meio de correspondência oficial."));

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->Cell(170,$l,utf8_decode("Em São Paulo, $rodape."),0,1,'C');

$pdf->Ln(20);

$pdf->SetX($x);
$pdf->Cell(40,$l,"",0,0,'L');
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(90,$l,utf8_decode($proponente),'T',1,'C');
$pdf->SetX($x);
$pdf->Cell(40,$l,"",0,0,'L');
$pdf->Cell(90,$l,utf8_decode($documento),'0',0,'C');

$pdf->Ln(35);

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(100,$l,"Anuente",'T',1,'C');
$pdf->SetX($x);
$pdf->Cell(100,$l,"(em caso de cooperativa, o cooperado deve assinar)",'0',0,'C');


//	QUEBRA DE PÁGINA
$pdf->AddPage('','');
$pdf->SetXY( $x , 35 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->Ln(25);

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(170,$l,utf8_decode("ANEXO I"),0,1,'C');

$pdf->Ln(15);

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(170,$l,utf8_decode("DECLARAÇÃO"),0,1,'C');

$pdf->Ln(15);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("DECLARO ter conhecimento das vedações constantes no artigo 2º do Decreto nº 58.041, de 20 de Dezembro de 2018, que estabelece:"));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("II - proponente: pessoa física ou jurídica, com ou sem fins lucrativos, que apresenta projeto cultural visando à captação de recursos por meio do incentivo fiscal para sua realização e que atenda cumulativamente às seguintes exigências:"));

$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("a) não tenha qualquer associação ou vínculo direto ou indireto com empresas de serviços de radiodifusão de som e imagem ou operadoras de comunicação eletrônica aberta ou por assinatura;"));

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(165,$l,utf8_decode("b) não tenha qualquer associação ou vínculo direto ou indireto com o contribuinte incentivador do projeto apresentado, ressalvadas as hipóteses a que aludem o inciso XX do artigo 4º e o inciso III do artigo 7º da Lei nº 15.948, de 2013."));

$pdf->Ln(10);

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->Cell(170,$l,utf8_decode("São Paulo, $rodape."),0,1,'C');

$pdf->Ln(20);

$pdf->SetX($x);
$pdf->Cell(40,$l,"",0,0,'L');
$pdf->SetFont('Arial','B', 11);
$pdf->Cell(90,$l,utf8_decode($proponente),'T',1,'C');
$pdf->SetX($x);
$pdf->Cell(40,$l,"",0,0,'L');
$pdf->Cell(90,$l,utf8_decode($documento),'0',0,'C');


$pdf->Output();