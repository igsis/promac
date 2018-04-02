<?php

// INSTALAÇÃO DA CLASSE NA PASTA FPDF.
require_once("../include/lib/fpdf/fpdf.php");
require_once("../funcoes/funcoesConecta.php");
require_once("../funcoes/funcoesGerais.php");

session_start();

//CONEXÃO COM BANCO DE DADOS
$con = bancoMysqli();

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
  function Cabecalho($header)
  {
   // Column widths
    $w = array(70, 25, 25, 30, 30);
    // Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
  }

  function Tabela($data)
  {
    // Column widths
    $w = array(70, 25, 25, 30, 30);
    for($i=0;$i<count($data);$i++)
        $this->Cell($w[$i],10,$data[$i],1,0,'L');
    $this->Ln();
    // Data
  }
}

function fichaTecnica($idProjeto)
{
  $con = bancoMysqli();
  $sql = "SELECT * FROM ficha_tecnica WHERE idProjeto = '$idProjeto' AND publicado = 1";
  $query = mysqli_query($con,$sql);
  $a = array();
  $i = 0;
  while($row = mysqli_fetch_array($query))
  {
    $a[$i]['nome'] = $row['nome'];
    $a[$i]['cpf'] = $row['cpf'];
    $a[$i]['funcao'] = $row['funcao'];
    $i++;
  }
  $a['numero'] = $i;
  return $a;
}

//CONSULTA
$idProjeto = $_SESSION["idProjeto"];
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$nomeProjeto = $projeto["nomeProjeto"];

$ficha = fichaTecnica($idProjeto);


//GERANDO O PDF:
$pdf = new PDF('P','mm','A4'); //CRIA UM NOVO ARQUIVO PDF NO TAMANHO A4
$pdf->AliasNbPages();
$pdf->AddPage();

$x=20;
$l=7; //DEFINE A ALTURA DA LINHA

$pdf->SetXY( $x , 35 );// SetXY - DEFINE O X (largura) E O Y (altura) NA PÁGINA

$pdf->SetX($x);
$pdf->SetFont('Arial','B', 14);
$pdf->Cell(180,5,utf8_decode("CARTA(S) DE ANUÊNCIA DO(S) PRINCIPAL(IS) PARTICIPANTE(S)"),0,1,'C');

$pdf->Ln();
$pdf->Ln();

$pdf->SetX($x);
$pdf->SetFont('Arial','', 11);
$pdf->MultiCell(180,$l,utf8_decode("Os profissionais listados abaixo declaram ter ciência e concordam em participar do projeto denominado ´´".$nomeProjeto."``, caso seja contemplado."));

$pdf->Ln();
$pdf->Ln();

// Column headings
$header = array('NOME', 'CPF', 'CONTATO', 'FUNCAO','ASSINATURA');
$data = array($ficha);

$pdf->SetX($x);
$pdf->SetFont('Arial','',8);

$pdf->Cabecalho($header);

for($i = 0;$i < $ficha['numero']; $i++)
{
  $data = array(utf8_decode($ficha[$i]['nome']), $ficha[$i]['cpf'],"", $ficha[$i]['funcao'],"");
  $pdf->SetX($x);
  $pdf->Tabela($data);
}

$pdf->Output();
?>