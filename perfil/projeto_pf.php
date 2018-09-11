<?php
$con = bancoMysqli();
unset($_SESSION['idProjeto']);
$tipoPessoa = '1';

$idPf = $_SESSION['idUser'];
$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
$statusProjeto = recuperaStatus("statusprojeto");


if(isset($_POST['apagar']))
{
	$idProjeto = $_POST['apagar'];
	$sql_apaga = "UPDATE projeto SET publicado = '0' WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_apaga))
	{
		$mensagem = "<font color='#01DF3A'><strong>Projeto apagado com sucesso!</strong></font>";
		gravarLog($sql_apaga);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao apagar projeto! Tente novamente.</strong></font>";
	}
}

?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include '../perfil/includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<?php			
				if($pf['liberado'] != NULL)
				echo "<h4>Projetos</h4>";
				?>
				<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
				<?php
					if ($pf['liberado'] == NULL OR $pf['liberado'] == 2 OR $pf['liberado'] == 4)
					{
						echo "<div class='alert alert-warning'>
				  		<strong></strong>Aguardando Aprovação da Inscrição.
						</div>";
					}
					if($pf['liberado'] == 1)// foi solicitado liberação, porém a SMC não analisou ainda.
					{
				?>
						<div class="alert alert-success">
							<strong>Sua solicitação de inscrição foi enviada com sucesso à Secretaria Municipal de Cultura. Aguarde a análise da documentação.</strong>
						</div>
				<?php
					}
					if ($pf['liberado'] == 3)
					{
				?>
				<!--Inicio da validação numero de projetos-->
				<?php
				if($statusProjeto == 1){
				$qtd = retornaQtdProjetos($tipoPessoa,$idPf);
				$numProjetos = (int) $qtd[0];

				$projeto = retornaProjeto($tipoPessoa, $idPf);
				$numProjeto = $projeto[0];

				if($numProjetos == 0): ?>
				  <div class="form-group">
				    <div class="col-md-offset-2 col-md-8">
				      <form class="form-horizontal" role="form" action="?perfil=projeto_novo" method="post">
					   <input type="submit" value="Inscrever Projeto" class="btn btn-theme btn-lg btn-block">
					  </form>
				    </div>
				  </div>
				<?php else: ?>
				  <div class="alert alert-danger">
				   <p>Você possui o projeto
				   	  <b><?=$numProjeto?></b> em andamento. Este é o
				   	  seu limite.
				   	</p>
				  </div>
				 <?php endif?>
				 <!--Fim da validação numero de projetos-->

				</div>

						<div class="form-group">
							<div class="col-md-offset-2 col-md-8"><br></div>
						</div>

						<div class="col-md-offset-1 col-md-10">
							<div class="table-responsive list_info">
							<?php
								$sql = "SELECT * FROM projeto
										WHERE publicado > 0 AND idPf ='$idPf' AND tipoPessoa = 1
										ORDER BY idProjeto DESC";
								$query = mysqli_query($con,$sql);
								$num = mysqli_num_rows($query);
								if($num > 0)
								{
									echo "
										<table class='table table-condensed'>
											<thead>
												<tr class='list_menu'>
													<td>Nome do Projeto</td>
													<td>Área de Atuação</td>
													<td width='10%'></td>
													<td></td>
												</tr>
											</thead>
											<tbody>";
											while($campo = mysqli_fetch_array($query))
											{
												$area = recuperaDados("area_atuacao","idArea",$campo['idAreaAtuacao']);
												echo "<tr>";
												echo "<td class='list_description'>".$campo['nomeProjeto']."</td>";
												echo "<td class='list_description'>".$area['areaAtuacao']."</td>";
												$idCampo = $campo['idStatus'];
                                                $status = "SELECT status FROM status WHERE idStatus='$idCampo'";
                                                $envio = mysqli_query($con, $status);
                                                $rowStatus = mysqli_fetch_array($envio);
                                                if ($campo['idStatus'] == 1) {
                                                    echo "
                                                    <td class='list_description'>
                                                        <form method='POST' action='?perfil=projeto_edicao'>
                                                            <input type='hidden' name='carregar' value='".$campo['idProjeto']."' />
                                                            <input type ='submit' class='btn btn-theme btn-block' value='carregar'>
                                                        </form>
                                                    </td>";
                                                            echo "
                                                    <td class='list_description'>
                                                        <form method='POST' action='?perfil=projeto_pf'>
                                                            <input type='hidden' name='apagar' value='".$campo['idProjeto']."' />
                                                            <button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Excluir Projeto?' data-message='Deseja realmente excluir o projeto nº ".$campo['idProjeto']."?'>Remover
                                                                    </button>
                                                        </form>
                                                    </td>";
                                                }else {
                                                    echo "
                                                    <td class='list_description'>
                                                        <form method='POST' action='?perfil=projeto_visualizacao'>
                                                            <input type='hidden' name='carregar' value='" . $campo['idProjeto'] . "' />
                                                            <input type ='submit' class='btn btn-theme btn-block' value='visualizar'>
                                                        </form>
                                                    </td>";
                                                }
                                                    echo "</tr>";
                                            }
									echo "
										</tbody>
										</table>";
								}
								?>
							</div>
						</div>
					<?php
								} 

			else{
				echo "<div class='alert alert-warning'>
				  <strong>Aviso: </strong>O cadastro de novos projetos está desabilitado temporariamente pela SMC.
				</div>";
			}

					}
					?>
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