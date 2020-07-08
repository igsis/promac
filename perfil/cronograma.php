<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];
$usuarioLogado = pegaUsuarioLogado();

if(isset($_POST['insere']))
{
	
	$inicioCronograma = $_POST['inicioCronograma'];
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
	$preProducao = $_POST['preProducao'];
	$producao = $_POST['producao'];
	$posProducao = $_POST['posProducao'];
    $tempoTotal = $_POST['preProducao'] + $_POST['producao'] + $_POST['posProducao'];

	if($preProducao != null &&  $producao != null && $posProducao != null){

		$sql_insere_cronograma = "INSERT INTO `cronograma`(preProducao, producao, posProducao, totalExecucao) VALUES ('$preProducao', '$producao', '$posProducao', '$tempoTotal')";

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


if(isset($_POST['editaCronograma']))
{
	$preProducao = $_POST['preProducao'];
	$producao = $_POST['producao'];
	$posProducao = $_POST['posProducao'];
    $tempoTotal = $_POST['preProducao'] + $_POST['producao'] + $_POST['posProducao'];
	if($preProducao != '0' &&  $producao != '0' && $posProducao != '0'){
		$sql_edita_cronograma = "UPDATE `cronograma` SET
		preProducao = '$preProducao',
		producao = '$producao',
		posProducao = '$posProducao',
		totalExecucao = '$tempoTotal',
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
			<h5 id="mensagem"><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
            <div class="col-md-offset-1 col-md-10">
                <div class="well">
                    O cronograma deve ser pensado em meses, divididos nas etapas de Pré-Produção, Produção e
                    Pós-Produção. Deve englobar as atividades especificadas no Plano de Trabalho de maneira mais
                    localizada no tempo. As etapas não deverão ser simultâneas no seu planejamento, ou seja, uma etapa
                    apenas começa após o término da anterior. Assim, o total de meses necessários para a execução do seu
                    projeto será a somatória dos meses de cada etapa. Legalmente, o cronograma começará a correr a
                    partir da data da emissão da Autorização de Movimentação de Recursos. Você não deverá incluir no
                    cronograma o período de captação de recursos, que é incerto, nem o período para entregar a prestação
                    de contas, que tem um prazo de entrega automático após o término do projeto.
                </div>
            </div>
		</div>
		
		<div class="row">
			<div class="col-md-offset-1 col-md-10">

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
									<label>Pré-Produção *</label>
								</div>
								<div class="col-md-6">

                                    <input class="slider" type="text" name="preProducao" value="<?= $cronograma['preProducao'] ?? "" ?>">

                                </div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-6">
									<label>Produção *</label>
								</div>
								<div class="col-md-6">
                                    <input class="slider" type="text" name="producao" value="<?= $cronograma['producao'] ?? "" ?>">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-offset-2 col-md-6">
									<label>Pós-Produção *</label>
								</div>
								<div class="col-md-6">
                                    <input class="slider" type="text" name="posProducao" value="<?= $cronograma['posProducao'] ?? "" ?>">
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
                                <td class='list_description'><strong>Total em Meses da Execução:</strong></td>
                                <td class='list_description exibir'><?= $cronograma['totalExecucao'] ?? '' ?></td>
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
        if((val / 5) == 1) // meio
        {
            return `Metade de um mês`
        }
        else if((val / 5) == 2) // um
        {
            return `${(val / 10)} Mês`
        }
        else if((val / 5) == 3) 	// um e meio
        {
            return `${parseInt(val / 10)} Mês e Meio`;
        }
        else if((val / 5) % 2 == 0) 	// par meses
        {
            return `${(val / 10)} Meses`
        }
        else{				// meses e meio
            return `${parseInt(val / 10)} Meses e Meio`
        }
    }

    const preencher = (item) => {
        let val = parseFloat(item.value)
        if(!isNaN(val)){
            elemento = item.parentNode.children[0]
            elemento.style.width = ((val / .5) * 5) + `%`
            elemento.innerHTML = quantidadeMes(parseFloat((val / .5) * 5)) // exibe qtd de meses
        }
    }

    for(let etapa of etapas){

        preencher(etapa)
    }

    const menos = (barra) => {
        let val = barra.style.width.replace('%','')
        if(val > '0'){
            val = (parseFloat(val) - parseFloat('5%'))
            barra.style.width = `${val}%`
            barra.innerHTML = quantidadeMes(val)
            barra.parentNode.children[1].value = (val / 10) // insere no value do input
        }
    }

    const mais = (barra) => {
        let val = barra.style.width.replace('%','')
        if(val < parseFloat('100')){
            val = (parseFloat(val) + parseFloat('5%'))
            barra.style.width = `${val}%`
            barra.innerHTML = quantidadeMes(val)
            barra.parentNode.children[1].value = (val / 10) // insere no value do input
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
        etapa.innerHTML = quantidadeMes(parseFloat((etapa.innerHTML / .5) * 5))
    }

</script>