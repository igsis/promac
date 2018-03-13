<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

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
			<h4>Informações Administrativas</h4>
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<ul class='list-group'>
							<li class='list-group-item list-group-item-success'>
								<li class='list-group-item'><strong>Protocolo:</strong> <?php echo $ano." - ".$idProjeto ?></li>
								<li class='list-group-item'><strong>Status:</strong> <?php echo $status['status'] ?></li>
								<li class='list-group-item'><strong>Valor Aprovado:</strong> <?php echo dinheiroParaBr($projeto['valorAprovado']) ?></li>
							</li>
						</ul>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<strong>Notas:</strong>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>