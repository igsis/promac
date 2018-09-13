<?php
$con = bancoMysqli();

if(isset($_POST['idProjeto']))
{
	$idProjeto = $_POST['idProjeto'];
	$_SESSION['idProjeto'] = $idProjeto;
}
else
{
	if(isset($_SESSION['idProjeto']))
	{
		$idProjeto = $_SESSION['idProjeto'];
	}
	else
	{
		$idProjeto = null;
	}
}

// $idProjeto = isset($_POST['idProjeto'])?$_POST['idProjeto']:null;
// $_SESSION['idProjeto'] = $idProjeto;
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);

// Gerar documentos
$server = "http://".$_SERVER['SERVER_NAME']."/promac/";
$http = $server."/pdf/";
$link1 = $http."rlt_projeto.php";
$tipoPessoa = '9';


if(isset($_POST['gravarPrazos']))
{
	$prazoCaptacao = exibirDataMysql($_POST['prazoCaptacao']);
	$prorrogacaoCaptacao = $_POST['prorrogacaoCaptacao'];
	$finalCaptacao = exibirDataMysql($_POST['finalCaptacao']);
	$inicioExecucao = exibirDataMysql($_POST['inicioExecucao']);
	$fimExecucao = exibirDataMysql($_POST['fimExecucao']);
	$prorrogacaoExecucao = $_POST['prorrogacaoExecucao'];
	$finalProjeto = exibirDataMysql($_POST['finalProjeto']);
	$prestarContas = exibirDataMysql($_POST['prestarContas']);

	$prazos = recuperaDados("prazos_projeto","idProjeto",$idProjeto);
	if($prazos == NULL)
	{
		$sql_insere = "INSERT INTO prazos_projeto (idProjeto, prazoCaptacao, prorrogacaoCaptacao, finalCaptacao, inicioExecucao, fimExecucao, prorrogacaoExecucao, finalProjeto, prestarContas, publicado) VALUES ('$idProjeto', '$prazoCaptacao', '$prorrogacaoCaptacao', '$finalCaptacao', '$inicioExecucao', '$fimExecucao', '$prorrogacaoExecucao', '$finalProjeto', '$prestarContas', 0)";
		if(mysqli_query($con,$sql_insere))
		{
			$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Utilize o menu para avançar.</strong></font>";
			gravarLog($sql_insere);
		}	
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
		}
	}
	else
	{
		$sql_edita = "UPDATE prazos_projeto SET
		prazoCaptacao = '$prazoCaptacao',
		prorrogacaoCaptacao = '$prorrogacaoCaptacao',
		finalCaptacao = '$finalCaptacao',
		inicioExecucao = '$inicioExecucao',
		fimExecucao = '$fimExecucao',
		prorrogacaoExecucao = '$prorrogacaoExecucao',
		finalProjeto = '$finalProjeto',
		prestarContas = '$prestarContas'
		WHERE idProjeto = '$idProjeto'";
		if(mysqli_query($con,$sql_edita))
		{
			$mensagem = "<font color='#01DF3A'><strong>Editado com sucesso!</strong></font>";
			gravarLog($sql_edita);
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao editar! Tente novamente.</strong></font>";
		}
	}
}

if(isset($_POST['gravarAdm']))
{
    $idStatus = $_POST['idStatus'];
    $valorAprovado = dinheiroDeBr($_POST['valorAprovado']);
    $renunciaFiscal = $_POST['idRenunciaFiscal'];
    $statusParecerista = $_POST['idStatusParecerista'];
    if($_POST['dataReuniao'] == 0000-00-00)
    {
        $dataReuniao = '';
    }
    else
    {
        $dataReuniao = exibirDataMysql($_POST['dataReuniao']);
    }
    $data = date('Y-m-d h:i:s');
    $idUsuario = $_SESSION['idUser'];
	$sql_gravarAdm = "UPDATE projeto SET valorAprovado = '$valorAprovado', idRenunciaFiscal = '$renunciaFiscal', idStatusParecerista = '$statusParecerista', dataReuniao = '$dataReuniao' WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_gravarAdm))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
		gravarLog($sql_gravarAdm);
        $idComissao = $projeto['idComissao'];
        $sql_historico_reuniao = "INSERT INTO historico_reuniao (idProjeto,idStatus,dataReuniao,idStatusParecerista,idComissao,data,idUsuario) VALUES ('$idProjeto','$idStatus','$dataReuniao','$statusParecerista','$idComissao','$data','$idUsuario')";
        if(mysqli_query($con,$sql_historico_reuniao))
        {
            $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
            gravarLog($sql_historico_reuniao);
        }
        else
        {
            $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
        }
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
	}
}

if(isset($_POST['gravarNota']))
{
	if ($idProjeto != 0)
	{
		$dateNow = date('Y:m:d h:i:s');
		$nota = addslashes($_POST['nota']);
		$sql_nota = "INSERT INTO notas (idProjeto, data, nota, interna) VALUES ('$idProjeto', '$dateNow', '$nota', '2')";
		if(mysqli_query($con,$sql_nota))
		{
			$mensagem = "<font color='#01DF3A'><strong>Nota inserida com sucesso!</strong></font>";
			gravarLog($sql_nota);
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao inserir nota! Tente novamente.</strong></font>";
		}
	}
}


if(isset($_POST['finalizaComissao']))
{
	$idP = $_POST['IDP'];

	$projeto = recuperaDados("projeto","idProjeto",$idP);

    switch ($projeto['idStatus']) {
        case 7:
            $idStatus = 10;
            break;
        case 19:
            $idStatus = 20;
            break;
        case 24:
            $idStatus = 25;
            break;
        case 30:
            $idStatus = 31;
            break;
        case 34:
            $idStatus = 15;
            break;
    }
	$dateNow = date('Y:m:d h:i:s');
	$sql_finalizaComissao = "UPDATE projeto SET idStatus = '$idStatus', finalizacaoComissao = '$dateNow' WHERE idProjeto = '$idP' ";
	if(mysqli_query($con,$sql_finalizaComissao))
	{
        $sql_historico = "INSERT INTO historico_status (idProjeto, idStatus, data) VALUES ('$idProjeto', '$idStatus', '$dateNow')";
        $query_historico = mysqli_query($con, $sql_historico);
        $mensagem = "<font color='#01DF3A'><strong>Finalizado com sucesso!</strong></font>";
		echo "<script>window.location = '?perfil=comissao_index';</script>";
		gravarLog($sql_finalizaComissao);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao reabrir! Tente novamente.</strong></font>";
	}
}

if(isset($_POST["enviar"]))
{
    $idTipoUpload = $_POST['idTipoUpload'];
    $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '$idTipoUpload'";
	$query_arquivos = mysqli_query($con,$sql_arquivos);
	while($arq = mysqli_fetch_array($query_arquivos))
	{
		$y = $arq['idListaDocumento'];
		$x = $arq['sigla'];
		$nome_arquivo = isset($_FILES['arquivo']['name'][$x]) ? $_FILES['arquivo']['name'][$x] : null;
		$f_size = isset($_FILES['arquivo']['size'][$x]) ? $_FILES['arquivo']['size'][$x] : null;

		//Extensões permitidas
		$ext = array("PDF","pdf"); 
		
		if($f_size > 5242880) // 5MB em bytes
		{
			$mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></font>";
		}
		else
		{
			if($nome_arquivo != "")
			{
				$nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
				$new_name = date("YmdHis")."_".semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
				$hoje = date("Y-m-d H:i:s");
				$dir = '../uploadsdocs/'; //Diretório para uploads
				$allowedExts = array(".pdf", ".PDF"); //Extensões permitidas
				$ext = strtolower(substr($nome_arquivo,-4));

				if(in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas
				{
					if(move_uploaded_file($nome_temporario, $dir.$new_name))
					{
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipo`, `idPessoa`, `idListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idProjeto', '$y', '$new_name', '$hoje', '1'); ";
						$query = mysqli_query($con,$sql_insere_arquivo);
						if($query)
						{
							$mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
							gravarLog($sql_insere_arquivo);
						}
						else
						{
							$mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco.</strong></font>";
						}
					}
					else
					{
						$mensagem = "<font color='#FF0000'><strong>Erro no upload! Tente novamente.</strong></font>";
					}
				}
				else
				{
					$mensagem = "<font color='#FF0000'><strong>Erro no upload! Anexar documentos somente no formato PDF.</strong></font>";
				}
			}
		}
	}
}
if(isset($_POST['apagar']))
{
	$idArquivo = $_POST['apagar'];
	$sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE idUploadArquivo = '$idArquivo'";
	if(mysqli_query($con,$sql_apagar_arquivo))
	{
		$mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
		gravarLog($sql_apagar_arquivo);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
	}
}

if($projeto['tipoPessoa'] == 1)
{
	$pf = recuperaDados("pessoa_fisica","idPf",$projeto['idPf']);
}
else
{
	$pj = recuperaDados("pessoa_juridica","idPj",$projeto['idPj']);
}

if(isset($_POST['atualizaResponsavel']))
{
	$con = bancoMysqli();
	$idComissao = $_POST['idComissao'];
	$idProjeto = $_POST['idProjeto'];
	$sql_atualiza_comissao = "UPDATE projeto SET idComissao = '$idComissao' WHERE idProjeto = '$idProjeto'";
	$query_atualiza_comissao = mysqli_query($con,$sql_atualiza_comissao);
	if($query_atualiza_comissao)
	{
		$mensagem = "Parecerista responsável pelo projeto atualizado!";
	}
	else
	{
		$mensagem = "Erro o atribuir! Tente novamente.";
	}
}

if(isset($_POST['editarAnexoProjeto']))
{
    $status = $_POST['status'];
    $observacoes = $_POST['observacoes'];
    $idProjeto = $_POST['idPessoa'];
    $idArquivo = $_POST['idArquivo'];

    $query = "UPDATE upload_arquivo SET idStatusDocumento = '".$status."', observacoes = '".$observacoes."' WHERE idUploadArquivo = '".$idArquivo."' ";
    $envia = mysqli_query($con, $query);
    if($envia)
    {
        echo "<script>window.location.href = 'index_pf.php?perfil=comissao_detalhes_projeto&idFF=".$idProjeto."';</script>";
        $mensagem = "<font color='#01DF3A'><strong>Os arquivos foram atualizados com sucesso!</strong></font>";
    }
    else
    {
        echo "<script>window.location.href = 'index_pf.php?perfil=comissao_detalhes_projeto&idFF=".$idProjeto."';</script>";
        echo "<script>alert('Erro durante o processamento, entre em contato com os responsáveis pelo sistema para maiores informações.')</script>";
    }
}

$representante = pegaProjetoRepresentante($idProjeto);
$pessoaFisica = pegaProjetoPessoaFisica($idProjeto);

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$prazos = recuperaDados("prazos_projeto","idProjeto",$idProjeto);
$area = recuperaDados("area_atuacao","idArea",$projeto['idAreaAtuacao']);
$renuncia = recuperaDados("renuncia_fiscal","idRenuncia",$projeto['idRenunciaFiscal']);
$cronograma = recuperaDados("cronograma","idCronograma",$projeto['idCronograma']);
$video = recuperaDados("projeto","idProjeto",$idProjeto);
$v = array($video['video1'], $video['video2'], $video['video3']);
$idStatus = $projeto['idStatus'];
?>
    <section id="list_items" class="home-section bg-white">
        <div class="container">
            <?php include 'includes/menu_comissao.php'; ?>
            <div class="form-group">
                <h4>Ambiente Comissão</h4>
                <h6><?= $projeto['nomeProjeto'] ?></h6>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <div role="tabpanel">
                        <!-- LABELS -->
                        <ul class="nav nav-tabs">
                            <li class="nav active"><a href="#adm" data-toggle="tab">Administrativo</a></li>
                            <li class="nav"><a href="#projeto" data-toggle="tab">Projeto</a></li>
		                        <?php if(isset($representante)):?>
		                        <li class="nav"><a href="#J" data-toggle="tab">Pessoa Jurídica</a></li>
		                        <?php else: ?>
		                        <li class="nav"><a href="#F" data-toggle="tab">Pessoa Física</a></li>
		                        <?php endif ?>
                            <li class="nav"><a href="#historico" data-toggle="tab">Histórico</a></li>

                        </ul>

                        <div class="tab-content">

                            <!-- LABEL ADMINISTRATIVO -->
                            <?php include "includes/label_comissao_adm.php"; ?>

                            <!-- LABEL PROJETO -->
                            <?php include "includes/label_projeto.php"; ?>

                             <!-- LABEL PESSOA JURÍDICA -->
                       		 <?php include "includes/label_comissao_pj.php"; ?>

                       		 <!--LABEL PESSOA FISICA-->
                       		 <?php include "includes/label_comissao_pf.php"; ?>

                 	   		 <!-- LABEL HISTÓRICO -->
                            <?php include "includes/label_historico.php"; ?>
                           

                        </div>
                        <!-- class="tab-content" -->
                    </div>
                    <!-- role="tabpanel" -->
                </div>
            </div>
        </div>
    </section>
