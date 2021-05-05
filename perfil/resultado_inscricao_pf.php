<?php
$con = bancoMysqli();
$tipoPessoa = '1';

// Gerar documentos
$server = "http://".$_SERVER['SERVER_NAME']."/promac";
$http = $server."/pdf/";

$idPf = $_SESSION['idUser'];
$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
$campos = array($pf['nome'], $pf['cpf'], $pf['rg'], $pf['email'], $pf['cep'], $pf['numero']);
$cpo = false;

foreach ($campos as $cpos)
{
	if ($cpos == null)
	{
		$cpo = true;
	}
}

/**Arquivos Obrigatórios**/
if(isset($tipoPessoa)):
  $tipoDoc = 'proponente';
  $idUser = $idPf;
  $idProjeto = 0; /*Incluso devido a busca pelos anexos*/
  require_once('validacaoArquivosObrigatorios.php');
endif;

if(isset($_POST['liberacao']))
{
	$date = date('Y:m:d H:i:s');
	$sql_liberacao = "UPDATE pessoa_fisica SET liberado = 1, dataInscricao = '$date' WHERE idPf = '$idPf'";
	if(mysqli_query($con,$sql_liberacao))
	{
		$mensagem = "<font color='#01DF3A'><strong>Sua inscrição foi enviada à SMC!</strong></font>";
		$pf['liberado'] = "1";
		gravarLog($sql_liberacao);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font> <br/>";
	}
}

if(isset($_POST["enviar"]))
{
	$sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '1'";
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
						$sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipo`, `idPessoa`, `idListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('$tipoPessoa', '$idPf', '$y', '$new_name', '$hoje', '1'); ";
						$query = mysqli_query($con,$sql_insere_arquivo);
						if($query)
						{
							$mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
							gravarLog($sql_insere_arquivo);

                            // Script para evitar reenvio dos arquivos qdo user atualiza a pagina logo após o envio
                            $urlAtual = urlAtual();
                            echo "<script>window.location = '$urlAtual';</script>";
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

?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			    <?php
				    if(($pf['liberado'] == NULL) || ($pf['liberado'] == 2) || ($pf['liberado'] == 4))
				    {
					    include 'includes/resumo_pf.php';
				    }
                    elseif ($pf['liberado'] == 1) // foi solicitada a liberação, porém a SMC não analisou ainda.
                    {
                ?>
                        <div class="alert alert-success">
                            <strong>Sua solicitação de inscrição foi enviada com sucesso à Secretaria Municipal de Cultura. Aguarde a análise da documentação.</strong>
                        </div>
			    <?php
                    }
                    else // a inscrição foi aceita pela SMC.
                    {
                ?>
					<div class="alert alert-success">
						<strong>Sua inscrição foi aceita pela Secretaria Municipal de Cultura.</strong>
					</div>
                <?php
                    }
                ?>
                <ul class='list-group'>
                    <li class='list-group-item list-group-item-success'>Notas</li>
                    <?php
                        $sql = "SELECT * FROM notas WHERE idPessoa = '$idPf' AND idTipo = '1' AND interna = '1'";
                        $query = mysqli_query($con,$sql);
                        $num = mysqli_num_rows($query);
                        if($num > 0)
                        {
                            while($campo = mysqli_fetch_array($query))
                            {
                                echo "<li class='list-group-item' align='left'><strong>".exibirDataHoraBr($campo['data'])."</strong><br/>".$campo['nota']."</li>";
                            }
                        }
                        else
                        {
                            echo "<li class='list-group-item'>Não há notas disponíveis.</li>";
                        }
                    ?>
                </ul>

                <div>
                    <?php listaArquivosPessoaObs($idPf,1) ?>
                </div>
            </div>


			<?php
				if(($pf['liberado'] == NULL) || ($pf['liberado'] == 2) || ($pf['liberado'] == 4)) {
                    if($pf['liberado'] != NULL) { ?>
                            <!-- Exibir arquivos -->
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="table-responsive list_info"><h6>Documentos não aprovados</h6>
                                        <?php listaArquivosPendentePessoa($idPf, $tipoPessoa, "resultado_inscricao_pf"); ?>
                                    </div>
                                </div>
                            </div>
                    <?php } ?>

                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="table-responsive list_info"><h6>Upload de Arquivo(s) Somente em PDF</h6>
                                <form method="POST" action="?perfil=resultado_inscricao_pf" enctype="multipart/form-data">
                                    <?php
                                        $documentos = [];
                                        $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '$tipoPessoa' AND publicado = 1";
                                        $query_arquivos = mysqli_query($con,$sql_arquivos);
                                        while($arq = mysqli_fetch_array($query_arquivos))
                                        {
                                            $doc = $arq['documento'];
                                            $query = "SELECT idListaDocumento FROM lista_documento WHERE documento='$doc' AND publicado='1' AND idTipoUpload='1'";
                                            $envio = $con->query($query);
                                            $row = $envio->fetch_array(MYSQLI_ASSOC);

                                            if(verificaArquivosExistentesPF($idPf,$row['idListaDocumento']))
                                            {
                                                echo '<div class="alert alert-success">O arquivo ' . $doc . ' já foi enviado.</div>';
                                            }
                                            else
                                            {

                                                $documento = (object)
                                                [
                                                    'idListaDocumento' 	=>  $arq['idListaDocumento'] ?? null,
                                                    'nomeDocumento'		=>	$arq['documento'],
                                                    'sigla' 			=>	$arq['sigla']
                                                ];
                                                array_push($documentos, $documento);
                                            }
                                        }

                                        if ($documentos)
                                        {
                                    ?>
                                            <table class='table table-condensed'>
                                                <tr class='list_menu'>
                                                    <td>Tipo de Arquivo</td>
                                                    <td></td>
                                                </tr>

                                                <?php
                                                    foreach ($documentos as $documento)
                                                    {
                                                        $urlArquivo = $http.$documento->idListaDocumento;
                                                        echo "<tr>";
                                                        /** Bloco retirado por causar lentidão no sistema */
//                                                        if(arquivosExiste($urlArquivo))
//                                                        {
//                                                            echo "<td class='list_description path'>";
//                                                            $path = selecionaArquivoAnexo($http, $documento->idListaDocumento);
//                                                            echo "<a href='$path' target='_blank'>$documento->nomeDocumento</a>";
//                                                            echo "</td>";
//                                                        }
//                                                        else
//                                                        {
//                                                            echo "<td class='list_description'><label>$documento->nomeDocumento</label></td>";
//                                                        }
                                                        echo "<td class='list_description'><label>$documento->nomeDocumento</label></td>";
                                                        echo "<td class='list_description'><input type='file' name='arquivo[$documento->sigla]'></td>";
                                                        echo "</tr>";
                                                    }
                                                ?>
                                            </table>
                                            <input type="hidden" name="idPessoa" value="<?php echo $idPf; ?>"  />
                                            <input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"  />
                                            <input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value='Enviar'>
                                    <?php
                                        }
                                    ?>
							    </form>
						    </div>
					    </div>
				    </div>
				    <!-- Fim Upload de arquivo -->
				    <!-- Confirmação de Exclusão -->
					<div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title">Excluir Arquivo?</h4>
								</div>
								<div class="modal-body">
									<p>Confirma?</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
									<button type="button" class="btn btn-danger" id="confirm">Remover</button>
								</div>
							</div>
						</div>
					</div>

                    <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
				    <?php if ($cpo == false) {/*
						$idPess = $pf['idPf'];
						$queryArquivos =
						  "SELECT
						    idUploadArquivo
						   FROM
						     upload_arquivo
						   WHERE
						     idPessoa = $idPess
						   AND idTipo = '1' AND publicado = '1'";

						$enviaArquivos = mysqli_query($con, $queryArquivos);
						$numRow = mysqli_num_rows($enviaArquivos);
						if($numRow == 6)
						{ */
                     $query_valida = "SELECT *
                                      FROM upload_arquivo 
                                      WHERE idPessoa = '$idPf' AND publicado = 1 AND idTipo= 1";
                     if ($resuldato = mysqli_query($con,$query_valida)){
                         $num_linhas = mysqli_num_rows($resuldato);
                         if ($num_linhas == 7){
                             ?>
                             <form class="form-horizontal" role="form" action="?perfil=resultado_inscricao_pf" method="post">
                                 <input type="submit" name="liberacao" value="Concluir inscrição do proponente" class="btn btn-theme btn-lg btn-block">
                             </form>
                             <?php
                         }else{
                             echo "<div class='alert alert-warning'>
                            <strong>Erro: </strong> Você deve enviar toda a documentação necessaria para prosseguir.
                            </div>";
                         }
                     }else{
                         echo "<div class='alert alert-danger'>
                            <strong>Erro: </strong> Na validação dos arquivos tente novamente... ".die(mysqli_error($con))."
                            </div>";
                     }

                    ?>

					<?php
					} else {
						echo "<div class='alert alert-warning'>
						<strong>Erro: </strong> Você deve preencher todos os campos obrigatórios para prosseguir.
						</div>";
					}
				} ?>
			</div>
		</div>
		<!-- Confirmação de Exclusão -->
			<div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Excluir Arquivo?</h4>
						</div>
						<div class="modal-body">
							<p>Confirma?</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							<button type="button" class="btn btn-danger" id="confirm">Remover</button>
						</div>
					</div>
				</div>
			</div>
		<!-- Fim Confirmação de Exclusão -->
	</div>
</section>