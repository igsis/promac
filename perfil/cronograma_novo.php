<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
?>

<style>
.menos, .mais{
	cursor: pointer;
}
</style>

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
			<h4>Cronograma</h4>
		</div>
		<div class="row">
			<div class=" col-md-12">
				<form method="POST" action="?perfil=cronograma" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<label>ETAPA</label>
						</div>
						<div class="col-md-6">
							<label>MÊS (Período)</label>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<label>Captação de recursos *</label>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-sm-1">
									<a class="menos"><span class="glyphicon glyphicon-minus"></span></a>
								</div>
								<div class="col-sm-8">
									<div class="progress">
										<div id="captacaoRecurso" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">0 Mês
										</div>
									</div>
								</div>
								<div class="col-sm-1">
									<a class="mais"><span class="glyphicon glyphicon-plus"></span></a>
								</div>
							</div>
														
							<!-- <input type="text" name="captacaoRecurso" class="form-control" maxlength="50" placeholder="DD/MM/AA a DD/MM/AA" required> -->
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<label>Pré-Produção *</label>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-sm-1">
									<a class="menos"><span class="glyphicon glyphicon-minus"></span></a>
								</div>
								<div class="col-sm-8">
									<div class="progress">
										<div id="preProducao" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">0 Mês
										</div>
									</div>
								</div>
								<div class="col-sm-1">
									<a class="mais"><span class="glyphicon glyphicon-plus"></span></a>
								</div>
							</div>
							
							<!-- <input type="text" name="preProducao" class="form-control" maxlength="50" placeholder="DD/MM/AA a DD/MM/AA" required> -->
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<label>Produção *</label>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-sm-1">
									<a class="menos"><span class="glyphicon glyphicon-minus"></span></a>
								</div>
								<div class="col-sm-8">
									<div class="progress">
										<div id="producao" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">0 Mês
										</div>
									</div>
								</div>
								<div class="col-sm-1">
									<a class="mais"><span class="glyphicon glyphicon-plus"></span></a>
								</div>
							</div>
							
							<!-- <input type="text" name="producao" class="form-control" maxlength="50" placeholder="DD/MM/AA a DD/MM/AA" required> -->
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<label>Pós-Produção *</label>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-sm-1">
									<a class="menos"><span class="glyphicon glyphicon-minus"></span></a>
								</div>
								<div class="col-sm-8">
									<div class="progress">
										<div id="posProducao" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">0 Mês
										</div>
									</div>
								</div>
								<div class="col-sm-1">
									<a class="mais"><span class="glyphicon glyphicon-plus"></span></a>
								</div>
							</div>
							
							<!-- <input type="text" name="posProducao" class="form-control" maxlength="50" placeholder="DD/MM/AA a DD/MM/AA" required> -->
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<label>Prestação de Contas *</label>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-sm-1">
									<a class="menos"><span class="glyphicon glyphicon-minus"></span></a>
								</div>
								<div class="col-sm-8">
									<div class="progress">
										<div id="prestacaoContas" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">0 Mês
										</div>
									</div>
								</div>
								<div class="col-sm-1">
									<a class="mais"><span class="glyphicon glyphicon-plus"></span></a>
								</div>
							</div>	

							<!-- <input type="text" name="prestacaoContas" class="form-control" maxlength="50" placeholder="DD/MM/AA a DD/MM/AA" required> -->
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="insereCronograma" class="btn btn-theme btn-lg btn-block" value="Inserir">
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>

<script>

	let btnsMenos = document.querySelectorAll('.menos') // pega todos os buttons .menos
	let btnsMais = document.querySelectorAll('.mais') // pega todos os buttons .mais
	let captacaoRecurso = document.querySelector('#captacaoRecurso')
	var totalMes = 0
	
	function menos(barra){
		let val = barra.style.width.replace('%','')

		if(val > '0' && totalMes > 0){
			val = (parseFloat(val) - parseFloat('6.25%'))
			barra.style.width = `${val}%`
			totalMes = (parseFloat(totalMes) - parseFloat('.5'))
			console.log(totalMes);
		}
	}

	function mais(barra){
		let val = barra.style.width.replace('%','')

		if(val < parseFloat('100') && totalMes < 8){
			val = (parseFloat(val) + parseFloat('6.25%'))
			barra.style.width = `${val}%`
			totalMes = (parseFloat(totalMes) + parseFloat('.5'))
			console.log(totalMes);
		}
	}
	


	for(let btn of btnsMenos){

		btn.addEventListener('click', () => {
			let barra = btn.parentNode.parentNode.children[1].querySelector('.progress .progress-bar')			
			menos(barra)
		})

	}
	

	for(let btn of btnsMais){
		btn.addEventListener('click', () => {			
			let barra = btn.parentNode.parentNode.children[1].querySelector('.progress .progress-bar')			
			mais(barra)
		})
	}


	// captacaoRecurso.innerHTML = captacaoRecurso.style.width


</script>