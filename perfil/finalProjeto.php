<?php

$con = bancoMysqli();
$idUsuario = $_SESSION['idUser'];
$idProjeto = $_SESSION['idProjeto'];
$tipoPessoa = $_SESSION['tipoPessoa'];

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$area = recuperaDados("area_atuacao","idArea",$projeto['idAreaAtuacao']);
$renuncia = recuperaDados("renuncia_fiscal","idRenuncia",$projeto['idRenunciaFiscal']);
$cronograma = recuperaDados("cronograma","idCronograma",$projeto['idCronograma']);
$video = recuperaDados("projeto","idProjeto",$idProjeto);
$v = array($video['video1'], $video['video2'], $video['video3']);

if ($tipoPessoa == "1")
{
	$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
}
else
{
	$pj = recuperaDados("pessoa_juridica","idPj",$idUsuario);
}
$alterar = 0;


if($projeto['idStatus'] == 6)
	$alterar = 1;

?>
<section id="list_items" class="home-section bg-white">
	<div class="container">
		<?php
    	if($_SESSION['tipoPessoa'] == 1)
		{
			$idPf= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pf.php';
		}
		else
		{
			$idPj= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pj.php';
		}
    	?>
		<div class="form-group">
			<h4>Resumo do Projeto</h4>
			<div class="alert alert-warning">
				<strong>Atenção!</strong> Confirme atentamente se os dados abaixo estão corretos!
			</div>
		</div>

		<div class="form-group">
		<?php
			/**Campos Obrigatórios**/
			if(isset($idProjeto)):
			  require_once('validacaoCamposObrigatorios.php');
			endif;

			/**Arquivos Obrigatórios**/
			if(isset($tipoPessoa) && isset($idProjeto)):
			  require_once('validacaoArquivosObrigatorios.php');
			endif;
		?>
		</div>

		<div class = "page-header">
		 	<h5>Informações do projeto</h5>
		</div>

		<div class="well">
			<p align="justify"><strong>Nome do Projeto:</strong> <?php echo $projeto['nomeProjeto']; ?></p>
			<p align="justify"><strong>Valor do projeto:</strong> R$ <?php echo dinheiroParaBr($projeto['valorProjeto']); ?></p>
			<p align="justify"><strong>Valor do incentivo:</strong> R$ <?php echo dinheiroParaBr($projeto['valorIncentivo']); ?><p>
			<p align="justify"><strong>Valor do financiamento:</strong> R$ <?php echo dinheiroParaBr($projeto['valorFinanciamento']); ?><p>
		  	<p align="justify"><strong>Área de atuação:</strong> <?php echo $area['areaAtuacao'] ?></p>
			<p align="justify"><strong>Renúncia Fiscal:</strong> <?php echo $renuncia['renunciaFiscal'] ?></p>
		  	<p align="justify"><strong>Exposição da Marca:</strong> <?php echo $projeto['exposicaoMarca']; ?></p>
			<p align="justify"><strong>Resumo do projeto:</strong> <?php echo isset($projeto['resumoProjeto']) ? $projeto['resumoProjeto'] : null; ?></p>
			<p align="justify"><strong>Currículo:</strong> <?php echo isset($projeto['curriculo']) ? $projeto['curriculo'] : null; ?></p>
			<p align="justify"><strong>Descrição:</strong> <?php echo isset($projeto['descricao']) ? $projeto['descricao'] : null; ?></p>
			<p align="justify"><strong>Justificativa:</strong> <?php echo isset($projeto['justificativa']) ? $projeto['justificativa'] : null; ?></p>
			<p align="justify"><strong>Objetivo:</strong> <?php echo isset($projeto['objetivo']) ? $projeto['objetivo'] : null; ?></p>
			<p align="justify"><strong>Metodologia:</strong> <?php echo isset($projeto['metodologia']) ? $projeto['metodologia'] : null; ?></p>
			<p align="justify"><strong>Contrapartida:</strong> <?php echo isset($projeto['contrapartida']) ? $projeto['contrapartida'] : null; ?></p>
		</div>

		<div class="well">
			<ul class="list-group">
				<li class="list-group-item list-group-item-success"><b>Local</b></li>
				<li class="list-group-item">
					<table class="table table-bordered">
						<tr>
							<th>Local</th>
							<th>Público estimado</th>
							<th>Zona</th>
						</tr>
						<?php
						$sql = "SELECT * FROM locais_realizacao
								WHERE publicado = 1 AND idProjeto = ".$projeto['idProjeto']."";
						$query = mysqli_query($con,$sql);
						while($campo = mysqli_fetch_array($query))
						{
							$zona = recuperaDados("zona","idZona",$campo['idZona']);
							echo "<tr>";
							echo "<td>".$campo['local']."</td>";
							echo "<td>".$campo['estimativaPublico']."</td>";
							echo "<td>".$zona['zona']."</td>";
							echo "</tr>";
						}
						?>
					</table>
				</li>
			</ul>
		</div>

		<div class="well">
		 	<p align="justify"><strong>Público alvo:</strong> <?php echo isset($projeto['publicoAlvo']) ? $projeto['publicoAlvo'] : null; ?></p>
		 	<p align="justify"><strong>Plano de divulgação:</strong> <?php echo isset($projeto['planoDivulgacao']) ? $projeto['planoDivulgacao'] : null; ?></p>
		</div>

		<div class="well">
			<ul class="list-group">
				<li class="list-group-item list-group-item-success"><b>Ficha Técnica</b></li>
				<li class="list-group-item">
					<table class="table table-bordered">
						<tr>
							<th>Nome</th>
							<th>CPF</th>
							<th>Função</th>
						</tr>
						<?php
						$sql = "SELECT * FROM ficha_tecnica
								WHERE publicado = 1 AND idProjeto = '$idProjeto'";
						$query = mysqli_query($con,$sql);
						while($campo = mysqli_fetch_array($query))
						{
							echo "<tr>";
							echo "<td class='list_description'>".$campo['nome']."</td>";
							echo "<td class='list_description'>".$campo['cpf']."</td>";
							echo "<td class='list_description'>".$campo['funcao']."</td>";
							echo "</tr>";
						}?>
					</table>
				</li>
			</ul>
		</div>

		<div class = "page-header">
		 	<h5>Cronograma</h5>
		</div>

		<div class="well">
		 	<p align="justify"><strong>Início do projeto:</strong> <?php echo isset($projeto['inicioCronograma']) ? $projeto['inicioCronograma'] : null; ?></p>
		 	<p align="justify"><strong>Fim do projeto:</strong> <?php echo isset($projeto['fimCronograma']) ? $projeto['fimCronograma'] : null; ?></p>
		 	<table class="table table-bordered">
				<tr>
					<td><strong>Início do cronograma:</strong> <?php echo exibirDataBr($projeto['inicioCronograma']) ?></td>
					<td><strong>Fim do cronograma:</strong> <?php echo exibirDataBr($projeto['fimCronograma']) ?></td>
				</tr>
				<tr>
					<td><strong>Captação de recursos:</strong> <?php echo $cronograma['captacaoRecurso'] ?></td>
					<td><strong>Pré-Produção:</strong> <?php echo $cronograma['preProducao'] ?></td>
				</tr>
				<tr>
					<td><strong>Produção:</strong> <?php echo $cronograma['producao'] ?></td>
					<td><strong>Pós-Produção:</strong> <?php echo $cronograma['posProducao'] ?></td>
				</tr>
				<tr>
					<td colspan="2"><strong>Prestação de Contas:</strong> <?php echo $cronograma['prestacaoContas'] ?></td>
				</tr>
			</table>
		</div>

		<div class = "page-header">
		 	<h5>Orçamento</h5>
		</div>

		<div class="well">
			<table class="table table-bordered">
				<tr>
				<?php
					for ($i = 1; $i <= 7; $i++)
					{
						$sql_etapa = "SELECT idEtapa FROM orcamento
							WHERE publicado > 0 AND idProjeto ='$idProjeto' AND idEtapa = '$i'
							ORDER BY idOrcamento";
						$query_etapa = mysqli_query($con,$sql_etapa);
						$lista = mysqli_fetch_array($query_etapa);

						$etapa = recuperaDados("etapa","idEtapa",$lista['idEtapa']);
						echo "<td><strong>".$etapa['etapa'].":</strong>";
					}
				?>
				</tr>
				<tr>
				<?php
					for ($i = 1; $i <= 7; $i++)
					{
						$sql_etapa = "SELECT SUM(valorTotal) AS tot FROM orcamento
							WHERE publicado > 0 AND idProjeto ='$idProjeto' AND idEtapa = '$i'
							ORDER BY idOrcamento";
						$query_etapa = mysqli_query($con,$sql_etapa);
						$lista = mysqli_fetch_array($query_etapa);

						echo "<td>R$ ".dinheiroParaBr($lista['tot'])."</td>";
					}
				?>
				</tr>
				<tr>
				<?php
					$sql_total = "SELECT SUM(valorTotal) AS tot FROM orcamento
								WHERE publicado > 0 AND idProjeto ='$idProjeto'
								ORDER BY idOrcamento";
						$query_total = mysqli_query($con,$sql_total);
						$total = mysqli_fetch_array($query_total);
						echo "<td colspan='7'><strong>TOTAL: R$ ".dinheiroParaBr($total['tot'])."</strong></td>";
				?>
				</tr>
			</table>
			<li class="list-group-item">
				<table class="table table-bordered">
					<tr>
						<td width='25%'><strong>Etapa</strong></td>
						<td><strong>Descrição</strong></td>
						<td width='5%'><strong>Qtde</strong></td>
						<td width='5%'><strong>Unid. Med.</strong></td>
						<td width='5%'><strong>Qtde Unid.</strong></td>
						<td><strong>Valor Unit.</strong></td>
						<td><strong>Valor Total</strong></td>
					</tr>
					<?php
					$sql = "SELECT * FROM orcamento
							WHERE publicado > 0 AND idProjeto ='$idProjeto'
							ORDER BY idEtapa";
					$query = mysqli_query($con,$sql);
					while($campo = mysqli_fetch_array($query))
					{
						$etapa = recuperaDados("etapa","idEtapa",$campo['idEtapa']);
						$medida = recuperaDados("unidade_medida","idUnidadeMedida",$campo['idUnidadeMedida']);
						echo "<tr>";
						echo "<td class='list_description'>".$etapa['etapa']."</td>";
						echo "<td class='list_description'>".$campo['descricao']."</td>";
						echo "<td class='list_description'>".$campo['quantidade']."</td>";
						echo "<td class='list_description'>".$medida['unidadeMedida']."</td>";
						echo "<td class='list_description'>".$campo['quantidadeUnidade']."</td>";
						echo "<td class='list_description'>".dinheiroParaBr($campo['valorUnitario'])."</td>";
						echo "<td class='list_description'>".dinheiroParaBr($campo['valorTotal'])."</td>";
						echo "</tr>";
					}?>
				</table>
			</li>
		</div>

		<div class = "page-header">
		 	<h5>Mídias sociais</h5>
		</div>

		<div class="well">
		 	<ul class="list-group">
				<li class="list-group-item list-group-item-success"><b>Mídias sociais</b></li>
				<li class="list-group-item">
					<?php

					if(!empty($video['video1'] || $video['video2'] || $video['video3']))
					{
						 ?>
						<table class='table table-condensed'>
						<?php
						foreach ($v as $key => $m)
						{
							if (!empty($m))
							{
								if(isYoutubeVideo($m) == "youtube")
								{
									$desc = "https://www.youtube.com/oembed?format=json&url=".$m;
									$obj =	json_decode(file_get_contents($desc), true);
								} else{
									echo "<div class='alert alert-danger'>
										  <strong>Erro!</strong> O link ($m) não pode ser aberto, a plataforma aceita somente YouTube.
										</div>";
								}
										if(isYoutubeVideo($m) == "youtube"){ ?>
								<tr>
									<td>
										<img src="<?php echo $obj['thumbnail_url']; ?>" style='width: 150px;'>
									</td>
									<td>
										<?php echo $obj['title']; ?><br/>
										<?php echo $m ?>
									</td>
								</tr>
								<?php } ?>
						<?php
							}
						}?>
							</table>
					<?php
					}
					else
					{
						echo "<p>Não há video(s) inserido(s).<p/><br/>";
					}
					?>
				</li>
			</ul>
		</div>

		<div class = "page-header">
		 	<h5>Arquivos do Projeto</h5>
		</div>

		<div class="well">
			<ul class="list-group">
				<li class="list-group-item"><?php exibirArquivos(3,$idProjeto); ?></li>
			</ul>
		</div>

		<?php
		if($projeto['idPj'] != NULL)
		{
			$pj = recuperaDados("pessoa_juridica","idPj",$projeto['idPj']);
		?>
			<div class = "page-header">
			 	<h5>Pessoa Jurídica</h5>
			</div>

			<div class="well">
			 	<p align="justify"><strong>Razão social:</strong> <?php echo isset($pj['razaoSocial']) ? $pj['razaoSocial'] : null; ?></p>
			 	<p align="justify"><strong>CNPJ:</strong> <?php echo isset($pj['cnpj']) ? $pj['cnpj'] : null; ?></p>
				<p align="justify"><strong>CCM:</strong> <?php echo isset($pj['ccm']) ? $pj['ccm'] : null; ?></p>
				<p align="justify"><strong>Logradouro:</strong> <?php echo isset($pj['logradouro']) ? $pj['logradouro'] : null; ?></p>
				<p align="justify"><strong>Bairro:</strong> <?php echo isset($pj['bairro']) ? $pj['bairro'] : null; ?></p>
				<p align="justify"><strong>Cidade:</strong> <?php echo isset($pj['cidade']) ? $pj['cidade'] : null; ?></p>
				<p align="justify"><strong>Estado:</strong> <?php echo isset($pj['estado']) ? $pj['estado'] : null; ?></p>
				<p align="justify"><strong>CEP:</strong> <?php echo isset($pj['cep']) ? $pj['cep'] : null; ?></p>
				<p align="justify"><strong>Número:</strong> <?php echo isset($pj['numero']) ? $pj['numero'] : null; ?></p>
				<p align="justify"><strong>Telefone:</strong> <?php echo isset($pj['telefone']) ? $pj['telefone'] : null; ?></p>
				<p align="justify"><strong>Celular:</strong> <?php echo isset($pj['celular']) ? $pj['celular'] : null; ?></p>
				<p align="justify"><strong>Email:</strong> <?php echo isset($pj['email']) ? $pj['email'] : null; ?></p>
			</div>
		<?php
		}
		?>
	</div>
    <!--Inicio do termo do contrato-->
    <?php if(sizeof($erros) == 0 && sizeof($arqPendentes) == 0) : ?>
    <div class="container">
        <a href="#">
          	<div class="termoContrato">
           		<input type="hidden" name="termos" id="termo" value="false">
           		<a href="#" data-toggle="modal" data-target="#myModal">Veja o termo de aceite para prosseguir</a>
          	</div>
        </a>
        <div class="modal fade" id="myModal" role="dialog">
          	<div class="modal-dialog">
            	<div class="modal-content">
              		<div class="modal-header">
                		<button type="button" class="close" data-dismiss="modal">&times;</button>
               			<h4 class="modal-title">Termo de aceite</h4>
              		</div>

	              	<div class="modal-body">
	                	<p>Li e aceito as condições para participação no Pro-Mac previstas na Lei nº 15.948/2013, Decreto nº 58.041/2017, bem como demais atos regulamentares.</p>
	              	</div>

		            <div class="modal-footer">
		                <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnRejeitar">Rejeitar</button>
		                <button type="button" class="btn btn-success" data-dismiss="modal" id="btnAceitar">Aceitar</button>
		            </div>
		        </div>
		    </div>
        </div>
    </div>
    <?php endif ?>
    <!--Fim do termo do contrato-->
    </div>
    <!-- Botão para Prosseguir -->
	  <div class="form-group">
	    <div class="col-md-offset-5 col-md-2">
		  <form class="form-horizontal" role="form" action="?perfil=informacoes_administrativas" method="post">
		   <?php
		     if($alterar == 1){ ?>
			    <input type="hidden" name="alterar" value="<?php echo $alterar; ?>">
		    <?php } ?>
			<button id="inptEnviar" class="btn btn-theme btn-lg" type="button" data-toggle="modal" data-target="#confirmApagar" data-title="Inscrever Projeto?" data-message="Deseja realmente inscrever o projeto <?= $projeto['nomeProjeto'] ?>" style="display: none;">Inscrever Projeto</button>

			<!-- <input type="hidden" value="Inscrever Projeto" id="inptEnviar"
			       class="btn btn-theme btn-lg btn-block"> -->
		  </form>
		  <!-- INICIO Modal de confirmação de envio do projeto -->
		  <div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Inscrever Projeto?</h4>
						</div>
						<div class="modal-body">
							<p>Confirma?</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
							<button type="button" class="btn btn-success" id="confirm">Inscrever</button>
						</div>
					</div>
				</div>
			</div>
			<!-- FIM Modal de confirmação de envio do projeto -->
		</div>
	  </div>
</section>