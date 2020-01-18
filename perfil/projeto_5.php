<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

if(isset($_POST['insere']))
{
	$justificativa = addslashes($_POST['justificativa']);
	$objetivo = addslashes($_POST['objetivo']);
	$objetivoEspecifico = addslashes($_POST['objetivoEspecifico']);

	$sql_insere = "UPDATE projeto SET
		justificativa = '$justificativa',
		objetivo = '$objetivo',
        objetivoEspecifico = '$objetivoEspecifico'
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
			<h4>Cadastro de Projeto <br>
            <h5>Objetivos a serem alcançados com o projeto</h5></h4>
			<p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=projeto_5" class="form-horizontal" role="form">

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>1. Objetivos Gerais</label>
                            <p align="justify">Estão relacionados com questões mais gerais, por exemplo, em um documentário sobre uma região da cidade, um objetivo geral possível seria “contribuir com o resgate histórico do desenvolvimento da região x”.</p>
                            <textarea name="objetivo" class="form-control" rows="10" required><?php echo $projeto['objetivo'] ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>2. Objetivos Específicos</label>
                            <p align="justify">São objetivos mais concretos para cada objetivo geral, que se relacionam com objetos culturais do projeto. Podem ser vários objetivos específicos. No mesmo exemplo do documentário acima poderiam ser objetivos específicos: “Produzir um documentário sobre o tema X”; “Promover o debate acerca do tema X a partir da exibição do documentário produzido”, etc.</p>
                            <textarea name="objetivoEspecifico" class="form-control" rows="10" required><?php echo $projeto['objetivoEspecifico'] ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Justificativa do projeto*</label>
                            <p align="justify">Você deverá falar sobre a relevância do seu projeto e sobre o contexto no qual ele está sendo proposto. Como ele se relaciona com outras produções? De que forma ele contribui com a produção cultural na cidade de São Paulo? De que forma ele contribui com a sociedade e com a cidade de São Paulo? Por que ele deve ter apoio público?</p>
                            <textarea name="justificativa" class="form-control" rows="10" required><?php echo $projeto['justificativa'] ?></textarea>
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