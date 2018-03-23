<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

if(isset($_POST['insere']))
{
	$video1 = $_POST['video1'];
	$video2 = $_POST['video2'];
	$video3 = $_POST['video3'];

	$sql_insere = "UPDATE projeto SET
		video1 = '$video1',
		video2 = '$video2',
		video3 = '$video3'
		WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_insere))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Utilize o menu para avançar.</strong></font>";
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}

if(isset($_POST['videoApagar']))
{
	$indice = "video".$_POST['videoApagar'];
	$video[$indice] = "";

	$sql_insere = "UPDATE projeto SET
		$indice = '$video[$indice]'
		WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_insere))
	{
		$mensagem = "<font color='#01DF3A'><strong>Apagado com sucesso!</strong></font>";
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}

$video = recuperaDados("projeto","idProjeto",$idProjeto);
$v = array($video['video1'], $video['video2'], $video['video3']);
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
			<h4>Cadastro de Projeto</h4>
			<h6>Link do YouTube</h6>
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=projeto_13" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Video 1</label>
							<input class="form-control" type="url" name="video1" placeholder="Link YouTube" value="<?php echo $video['video1']; ?>" style="text-align: center;">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Video 2</label>
							<input class="form-control" type="url" name="video2" placeholder="Link YouTube" value="<?php echo $video['video2']; ?>" style="text-align: center;">
						</div>
					</div>

					<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
							<label>Video 3</label>
							<input class="form-control" type="url" name="video3" placeholder="Link YouTube" value="<?php echo $video['video3']; ?>" style="text-align: center;">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="insere" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>
				<!-- Exibir arquivos -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<div class="table-responsive list_info"><h6>Video(s) Enviado(s)</h6>
								<?php
								if(!empty($video['video1'] || $video['video2'] || $video['video3']))
								{?>
											<table class='table table-condensed'>
												<thead>
													<tr class='list_menu'>
													<td>Imagem</td>
													<td>Nome do Video</td>
													<td width='15%'></td>
													</tr>
												</thead>
												<tbody>
									<?php
									foreach ($v as $key => $m)
									{
										if (!empty($m))
										{
											if(isYoutubeVideo($m) == "youtube")
											{
												$desc = "https://www.youtube.com/oembed?format=json&url=".$m;
												$obj =	json_decode(file_get_contents($desc), true);
											}
											else{
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
															<?php echo $obj['title']; ?>
														</td>
														<td>
															<form method="POST" action="?perfil=projeto_13">
															<input type="hidden" name="videoApagar" value="<?php echo $key+1; ?>">
															<button name="apagar" class="btn btn-theme" type="button" data-toggle="modal" data-target="#confirmApagar" data-title="Excluir Projeto?" data-message="Deseja realmente excluir o video <?= $obj['title']; ?>?">Apagar
																</button>
															</form>
														</td>
													</tr>
									<?php
								}
										}
									}?>
												</tbody>
											</table>
								<?php
								}
								else
								{
									echo "<p>Não há video(s) inserido(s).<p/><br/>";
								}
								?>
							</div>
						</div>
					</div>
				<!-- Fim Exibir Arquivo -->
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
						<button type="button" class="btn btn-danger" id="confirm">Apagar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Fim Confirmação de Exclusão -->
			</div>
		</div>
	</div>
</section>
