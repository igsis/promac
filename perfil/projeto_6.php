<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

if(isset($_POST['insere']))
{
	$metodologia = addslashes($_POST['metodologia']);
	$contrapartida = addslashes($_POST['contrapartida']);

	$sql_insere = "UPDATE projeto SET
		metodologia = '$metodologia',
		contrapartida = '$contrapartida'
		WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_insere))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Utilize o menu para avançar.</strong></font>";
		gravarLog($sql_insere);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
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
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=projeto_6" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Plano de Trabalho</label>
                            <p align="justify">Aqui você deverá elencar de forma organizada as atividades a serem desenvolvidas para atingir cada objetivo específico elencado no item Objetivos a serem alcançados com o projeto, quanto tempo levará para executar cada uma delas e qual produto será entregue para confirmar a execução. O plano de trabalho ajuda você a se organizar quanto ao que deve fazer para realizar seu projeto e ajuda SMC a entender o que será realizado e entregue. O modelo de Plano de Trabalho se encontra no Anexo VII do Edital do PROMAC 2020</p>
							<textarea name="metodologia" class="form-control" rows="10" required><?php echo $projeto['metodologia'] ?></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Descrição da contrapartida*</label>
							<textarea name="contrapartida" class="form-control" rows="10" required><?php echo $projeto['contrapartida'] ?></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="insere" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>