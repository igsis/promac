<?php
$con = bancoMysqli();

if(isset($_POST['pesquisar']))
{

}
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Pesquisar Projetos</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=pesquisa_geral" class="form-horizontal" role="form">
					<label>Período do dia dd/mm/aaaa até dd/mm/aaaa (cronograma)</label>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><label>Início</label>
							<input type="text" name="" class="form-control" placeholder="">
						</div>
						<div class="col-md-6"><label>Fim</label>
							<input type="text" name="" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Proponente</label>
							<input type="text" name="" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>CPF /CNPJ</label>
							<input type="text" name="" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Área atuação</label>
							<input type="text" name="" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Código do projeto</label>
							<input type="text" name="" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Status</label>
							<input type="text" name="" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="pesquisar" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>