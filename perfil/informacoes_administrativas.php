<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];
$alterar = isset($_POST['alterar']) ? $_POST['alterar'] : null;

if($alterar == 1 || $alterar == 0)
{
	/*
		Caso esteja alterando após indeferimento, muda o status para enviado
	*/
	$queryInsert = "UPDATE projeto SET idStatus='2' WHERE idProjeto='$idProjeto'";
	$sendValue = mysqli_query($con, $queryInsert);
}

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$status = recuperaDados("status","idStatus",$projeto['idStatus']);

$ano = date('Y');
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
			<h4>Informações da Inscrição</h4>
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8" align="left">
						<ul class='list-group'>
							<li class='list-group-item list-group-item-success'>
								<li class='list-group-item'><strong>Protocolo (nº ISP):</strong> <?php echo $projeto['protocolo'] ?></li>
								<li class='list-group-item'><strong>Status:</strong> <?php echo $status['status'] ?></li>
								<li class='list-group-item'>
									<strong>Valor Aprovado:</strong>
									<?php
										if($projeto['valorAprovado'] == 0)
										{
											echo "Nenhum valor foi inserido";
										}
										else
										{
											echo "R$ ".dinheiroParaBr($projeto['valorAprovado']);
										}
									?>
								</li>
							</li>
						</ul>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/></div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8" align="left">
						<ul class='list-group'>
							<li class='list-group-item list-group-item-success'>Notas
							<?php
								$sql = "SELECT * FROM notas
										WHERE idProjeto = '$idProjeto'";
								$query = mysqli_query($con,$sql);
								$num = mysqli_num_rows($query);
								if($num > 0)
								{

									while($campo = mysqli_fetch_array($query))
									{
										echo "<li class='list-group-item'><strong>".exibirDataHoraBr($campo['data'])."</strong><br/>".$campo['nota']."</li>";
									}
								}
								else
								{
									echo "<li class='list-group-item'>Não há notas disponíveis.</li>";
								}
							?>
							</li>
						</ul>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>