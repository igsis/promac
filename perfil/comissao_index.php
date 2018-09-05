<?php
$con = bancoMysqli();
?>
    <section id="list_items" class="home-section bg-white">
        <div class="container">
            <?php include 'includes/menu_comissao.php'; ?>
            <p align="left"><strong><?php echo saudacao(); ?>, <?php echo $_SESSION['nome']; ?></strong></p>
            <div class="form-group">
                <h5>Lista de projetos enviados.</h5>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <div class="table-responsive list_info">
                        <?php
                        $direcao = recuperaDados("pessoa_fisica","idPf", $_SESSION['idUser']);
						if($direcao['idNivelAcesso'] == 3)
						{
						$sql = "SELECT * FROM projeto WHERE publicado = 1 AND idStatus = 7 OR idStatus = 14 ORDER BY envioComissao ";
							}
							else
							{
						$sql = "SELECT * FROM projeto WHERE publicado = 1 AND idComissao = $idPf AND idStatus = 7 OR idStatus = 14 ORDER BY envioComissao ";	
						}
					$query = mysqli_query($con,$sql);
					$num = mysqli_num_rows($query);
					if($num > 0)
					{
						echo "
							<table class='table table-condensed'>
								<thead>
									<tr class='list_menu'>
										<td>Protocolo (nº ISP)</td>
										<td>Nome do Projeto</td>
										<td>Proponente</td>
										<td>Documento</td>
										<td>Área de Atuação</td>
										<td>Parecerista</td>
										<td>Etapa do Projeto</td>
										<td width='10%'></td>
									</tr>
								</thead>
								<tbody>";

								while($campo = mysqli_fetch_array($query))
								{
									$area = recuperaDados("area_atuacao","idArea",$campo['idAreaAtuacao']);
									$status = recuperaDados("status","idStatus",$campo['idStatus']);
									$pf = recuperaDados("pessoa_fisica","idPf",$campo['idPf']);
									$pj = recuperaDados("pessoa_juridica","idPj",$campo['idPj']);
                                    if($campo['idComissao'] != NULL){                                        			$comissao = recuperaDados("pessoa_fisica", "idPf", $campo['idComissao']);
                                    }else{
                                        $comissao['nome'] = " ";
                                    }


									echo "<tr>";
									echo "<td class='list_description'>".$campo['protocolo']."</td>";
									echo "<td class='list_description'>".$campo['nomeProjeto']."</td>";
									if($campo['tipoPessoa'] == 1)
									{
										echo "<td class='list_description'>".$pf['nome']."</td>";
										echo "<td class='list_description'>".$pf['cpf']."</td>";
									}
									if($campo['tipoPessoa'] == 2)
									{
										echo "<td class='list_description'>".$pj['razaoSocial']."</td>";
										echo "<td class='list_description'>".$pj['cnpj']."</td>";
									}
									echo "<td class='list_description'>".$area['areaAtuacao']."</td>";
									echo "<td class='list_description'>".$comissao['nome']."</td>";
									echo "<td class='list_description'>".$status['status']."</td>";
									echo "
										<td class='list_description'>
											<form method='POST' action='?perfil=comissao_detalhes_projeto'>
												<input type='hidden' name='idProjeto' value='".$campo['idProjeto']."' />
												<input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
											</form>
										</td>";
									}
									echo "</tr>";
						echo "
							</tbody>
							</table>";
						}
						else
						{
							echo "Nada consta.";
						}
					?>
                    </div>
                </div>
            </div>
        </div>
    </section>
