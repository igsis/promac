<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];
$usuarioLogado = pegaUsuarioLogado();

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$idCronograma = $projeto['idCronograma'];

if(isset($_POST['editaCronograma']))
{
	$captacaoRecurso = $_POST['captacaoRecurso'];
	$preProducao = $_POST['preProducao'];
	$producao = $_POST['producao'];
	$posProducao = $_POST['posProducao'];
	$prestacaoContas = $_POST['prestacaoContas'];

	$sql_edita_cronograma = "UPDATE `cronograma` SET
	captacaoRecurso = '$captacaoRecurso',
	preProducao = '$preProducao',
	producao = '$producao',
	posProducao = '$posProducao',
	prestacaoContas = '$prestacaoContas',
	alteradoPor = '$usuarioLogado'
	WHERE idCronograma = '$idCronograma'";
	if(mysqli_query($con,$sql_edita_cronograma))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Utilize o menu para avançar.</strong></font>";
        gravarLog($sql_edita_cronograma);
        echo "<meta HTTP-EQUIV='refresh' CONTENT='0.5;URL=?perfil=cronograma'>";
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}


$cronograma = recuperaDados("cronograma","idCronograma",$idCronograma);
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
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=cronograma_edicao" class="form-horizontal" role="form">

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
										<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">0 Mês
										</div>
										<input type="hidden" name="captacaoRecurso" class="form-control" maxlength="50" value="<?php echo $cronograma['captacaoRecurso'] ?>" required>									
									</div>
								</div>
								<div class="col-sm-1">
									<a class="mais"><span class="glyphicon glyphicon-plus"></span></a>
								</div>
							</div>							
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
										<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">0 Mês
										</div>
										<input type="hidden" name="preProducao" class="form-control" value="<?php echo $cronograma['preProducao'] ?>">
									</div>
								</div>
								<div class="col-sm-1">
									<a class="mais"><span class="glyphicon glyphicon-plus"></span></a>
								</div>
							</div>							
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
										<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">0 Mês
										</div>
										<input type="hidden" name="producao" class="form-control" value="<?php echo $cronograma['producao'] ?>">
									</div>
								</div>
								<div class="col-sm-1">
									<a class="mais"><span class="glyphicon glyphicon-plus"></span></a>
								</div>
							</div>							
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
										<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">0 Mês
										</div>
										<input type="hidden" name="posProducao" class="form-control" value="<?php echo $cronograma['posProducao'] ?>">
									</div>
								</div>
								<div class="col-sm-1">
									<a class="mais"><span class="glyphicon glyphicon-plus"></span></a>
								</div>
							</div>							
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
										<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%">0 Mês
										</div>
										<input type="hidden" name="prestacaoContas" class="form-control" value="<?php echo $cronograma['prestacaoContas'] ?>">
									</div>
								</div>
								<div class="col-sm-1">
									<a class="mais"><span class="glyphicon glyphicon-plus"></span></a>
								</div>
							</div>							
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="editaCronograma" class="btn btn-theme btn-lg btn-block" value="Gravar">
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
	let etapas = document.querySelectorAll('.progress input')


	const quantidadeMes = (val) => {
	
		if((val / 6.25) == 1) // meio
		{ 
			return `Metade de um mês`
		}
		else if((val / 6.25) == 2) // um 
		{ 
			return `${(val / 12.5)} Mês`
		}
		else if((val / 6.25) == 3) 	// um e meio
		{ 
			return `${parseInt(val / 12.5)} Mês e Meio`
		}
		else if((val / 6.25) % 2 == 0) 	// par meses
		{ 
			return `${(val / 12.5)} Meses`
		}
		else{ 							// meses e meio
			return `${parseInt(val / 12.5)} Meses e Meio`
		}
	}

	const preencher = (item) => {
		let val = parseFloat(item.value)
		if(!isNaN(val)){
			elemento = item.parentNode.children[0]
			elemento.style.width = ((val / .5) * 6.25) + `%`
			elemento.innerHTML = quantidadeMes(parseFloat((val / .5) * 6.25)) // exibe qtd de meses
		}

	}

	for(let etapa of etapas){
		console.log(parseFloat(etapa.value));

		// totalMes  parseFloat(etapa.value) 
		
		preencher(etapa)
	}

	
	function menos(barra){
		let val = barra.style.width.replace('%','')

		if(val > '0' && totalMes > 0){
			val = (parseFloat(val) - parseFloat('6.25%'))
			barra.style.width = `${val}%`
			barra.innerHTML = quantidadeMes(val)
			barra.parentNode.children[1].value = (val / 12.50) // insere no value do input
			totalMes = (parseFloat(totalMes) - parseFloat('.5'))
		}
	}

	function mais(barra){
		let val = barra.style.width.replace('%','')

		if(val < parseFloat('100') && totalMes < 8){
			val = (parseFloat(val) + parseFloat('6.25%'))
			barra.style.width = `${val}%`
			barra.innerHTML = quantidadeMes(val)
			barra.parentNode.children[1].value = (val / 12.50) // insere no value do input
			totalMes = (parseFloat(totalMes) + parseFloat('.5'))
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

</script>