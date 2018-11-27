<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];
$usuarioLogado = pegaUsuarioLogado();

if(isset($_POST['insere']))
{
	
	$inicioCronograma =$_POST['inicioCronograma'];
	$fimCronograma = $_POST['fimCronograma'];
	
	if (strtotime($inicioCronograma) <= strtotime($fimCronograma)){
		$sql_insere = "UPDATE projeto SET
		inicioCronograma = '$inicioCronograma',
		fimCronograma = '$fimCronograma'
		WHERE idProjeto = '$idProjeto'";
		if(mysqli_query($con,$sql_insere))
		{
			$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! </strong></font>";
			gravarLog($sql_insere);
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
		}
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>A data final deve ser após a data de início!.</strong></font>";
	}
}

if(isset($_POST['insereCronograma']))
{
	$captacaoRecurso = $_POST['captacaoRecurso'];
	$preProducao = $_POST['preProducao'];
	$producao = $_POST['producao'];
	$posProducao = $_POST['posProducao'];
	$prestacaoContas = $_POST['prestacaoContas'];


	if($captacaoRecurso != null  && $preProducao != null &&  $producao != null && $posProducao != null && $prestacaoContas != null){

		$sql_insere_cronograma = "INSERT INTO `cronograma`(captacaoRecurso, preProducao, producao, posProducao, prestacaoContas) VALUES ('$captacaoRecurso', '$preProducao', '$producao', '$posProducao', '$prestacaoContas')";

		if(mysqli_query($con,$sql_insere_cronograma))
		{
			$sql_ultimo = "SELECT idCronograma FROM cronograma ORDER BY idCronograma DESC LIMIT 0,1";
			$query_ultimo = mysqli_query($con,$sql_ultimo);
			$ultimoCronograma = mysqli_fetch_array($query_ultimo);
			$idCronograma = $ultimoCronograma['idCronograma'];
			$sql_insere_cronograma_evento = "UPDATE projeto SET idCronograma = '$idCronograma' WHERE idProjeto = '$idProjeto'";
			if(mysqli_query($con,$sql_insere_cronograma_evento))
			{
				$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
				gravarLog($sql_insere_cronograma_evento);
			}
			else
			{
				$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
			}
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
		}
	}else{
		$mensagem = "<font color='#FF0000'><strong>Necessário preencher todos as etapas!</strong></font>";
	}
}

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$idCronograma = $projeto['idCronograma'];
$cronograma = recuperaDados("cronograma","idCronograma",$idCronograma);

if(isset($_POST['editaCronograma']))
{
	$captacaoRecurso = $_POST['captacaoRecurso'];
	$preProducao = $_POST['preProducao'];
	$producao = $_POST['producao'];
	$posProducao = $_POST['posProducao'];
	$prestacaoContas = $_POST['prestacaoContas'];

	if($captacaoRecurso != '0'  && $preProducao != '0' &&  $producao != '0' && $posProducao != '0' && $prestacaoContas != '0'){
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
		}
		else
		{
			$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
		}
	}else{
		$mensagem = "<font color='#FF0000'><strong>Necessário preencher todos as etapas!</strong></font>";
	}
}

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
			<h5 id="mensagem"><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" id="formCronograma" action="?perfil=cronograma" class="form-horizontal" role="form">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-3"><label>Data estimada de início do projeto</label>
							<input type="date" name="inicioCronograma" minlength=10 maxlength="10" class="form-control" placeholder= "DD/MM/AA" required value="<?= ($projeto['inicioCronograma'] != "") ? $projeto['inicioCronograma'] : "" ?>">
						</div>
						<div class="col-md-offset-2 col-md-3"><label>Data estimada do final do projeto</label>
							<input type="date" name="fimCronograma" minlength=10 maxlength="10" class="form-control" placeholder="DD/MM/AA" required value="<?= ($projeto['fimCronograma'] != "") ? $projeto['fimCronograma'] : "" ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="insere" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><br/></div>
				</div>

	
				<div class="row">
					<div class=" col-md-12">

						<form method="POST" action="?perfil=cronograma" class="form-horizontal" role="form">
							<div class="form-group">
								<h4>Etapas</h4>
							</div>

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
												<input type="hidden" name="captacaoRecurso" class="form-control" maxlength="50" placeholder="DD/MM/AA a DD/MM/AA" required value="<?= ($cronograma['captacaoRecurso'] != "") ? $cronograma['captacaoRecurso'] : "" ?>">
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
												<input type="hidden" name="preProducao" class="form-control" maxlength="50" placeholder="DD/MM/AA a DD/MM/AA" required value="<?= ($cronograma['preProducao'] != "") ? $cronograma['preProducao'] : "" ?>">
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
												<input type="hidden" name="producao" class="form-control" maxlength="50" placeholder="DD/MM/AA a DD/MM/AA" required value="<?= ($cronograma['producao'] != "") ? $cronograma['producao'] : "" ?>">
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
												<input type="hidden" name="posProducao" class="form-control" maxlength="50" placeholder="DD/MM/AA a DD/MM/AA" required value="<?= ($cronograma['posProducao'] != "") ? $cronograma['posProducao'] : "" ?>">
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
												<input type="hidden" name="prestacaoContas" class="form-control" maxlength="50" placeholder="DD/MM/AA a DD/MM/AA" required value="<?= ($cronograma['prestacaoContas'] != "") ? $cronograma['prestacaoContas'] : "" ?>">
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
									<?php 
										if($idCronograma){
											echo "<input type='submit' name='editaCronograma' class='btn btn-theme btn-lg btn-block' value='Inserir'>";
										}else{
											echo "<input type='submit' name='insereCronograma' class='btn btn-theme btn-lg btn-block' value='Inserir'>";
										}
									?>
									
								</div>
							</div>
						</form>

					</div>
				</div>		

				<div class="table-responsive list_info">
					<table class='table table-condensed'>
						<thead>
							<tr class='list_menu'>
								<td colspan='2'>Etapas</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class='list_description'>ETAPA</td>
								<td class='list_description'>MÊS (Período)</td>
							</tr>
							<tr>
								<td class='list_description'>Captação de recursos</td>
								<td class='list_description exibir'><?= $cronograma['captacaoRecurso'] ?? '' ?></td>
							</tr>
							<tr>
								<td class='list_description'>Pré-Produção</td>
								<td class='list_description exibir'><?= $cronograma['preProducao'] ?? '' ?></td>
							</tr>
							<tr>
								<td class='list_description'>Produção</td>
								<td class='list_description exibir'><?= $cronograma['producao'] ?? '' ?></td>
							</tr>
							<tr>
								<td class='list_description'>Pós-Produção</td>
								<td class='list_description exibir'><?= $cronograma['posProducao'] ?? '' ?></td>
							</tr>
							<tr>
								<td class='list_description'>Prestação de Contas</td>
								<td class='list_description exibir'><?= $cronograma['prestacaoContas'] ?? '' ?></td>
							</tr>
						</tbody>
					</table>
				</div>	
			</div>
		</div>
	</div>
</section>

<script>

	let btnsMenos = document.querySelectorAll('.menos') // pega todos os buttons .menos
	let btnsMais = document.querySelectorAll('.mais') // pega todos os buttons .mais
	let captacaoRecurso = document.querySelector('#captacaoRecurso')					
	let etapas = document.querySelectorAll('.progress input')
	let btnInserir = document.querySelector('input[name="insereCronograma"]')
	let listaEtapas = document.querySelectorAll('.exibir') // lista


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
		else{				// meses e meio
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
		
		preencher(etapa)
	}				

	const menos = (barra) => {
		let val = barra.style.width.replace('%','')
		if(val > '0'){
			val = (parseFloat(val) - parseFloat('6.25%'))
			barra.style.width = `${val}%`
			barra.innerHTML = quantidadeMes(val)
			barra.parentNode.children[1].value = (val / 12.50) // insere no value do input						
		}
	}

	const mais = (barra) => {
		let val = barra.style.width.replace('%','')
		if(val < parseFloat('100')){
			val = (parseFloat(val) + parseFloat('6.25%'))
			barra.style.width = `${val}%`
			barra.innerHTML = quantidadeMes(val)
			barra.parentNode.children[1].value = (val / 12.50) // insere no value do input							
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

	for(let etapa of listaEtapas){	
		etapa.innerHTML = quantidadeMes(parseFloat((etapa.innerHTML / .5) * 6.25))
	}

</script>