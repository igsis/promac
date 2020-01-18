<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

if(isset($_POST['insere']))
{
	$metodologia = addslashes($_POST['metodologia']);
	$contrapartida = addslashes($_POST['contrapartida']);
	$ingresso = addslashes($_POST['ingresso']);
	$democratizacao = addslashes($_POST['democratizacao']);
	$acessibilidade = addslashes($_POST['acessibilidade']);

	$sql_insere = "UPDATE projeto SET
		metodologia = '$metodologia',
		contrapartida = '$contrapartida',
		ingresso = '$ingresso',
		democratizacao = '$democratizacao',
		acessibilidade = '$acessibilidade'
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
							<label>Contrapartida * <button class='btn btn-default' type='button' data-toggle='modal' data-target='#infoContrapartida'
                                                           style="border-radius: 30px;"><i class="fa fa-info-circle"></i></button></label>
							<textarea name="contrapartida" class="form-control" rows="10" required><?php echo $projeto['contrapartida'] ?></textarea>
						</div>
					</div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Ingresso e forma de acesso</label>
                            <p align="justify">Aqui você deverá colocar quanto custará o ingresso para o público do seu projeto (gratuito ou preço popular) e de que maneira o público terá acesso ao projeto. Serão realizadas inscrições prévias? Serão distribuídos ingressos antes do evento? Serão vendidos ingressos em pontos de venda? Em caso de preço popular, deverá indicar quanto irá cobrar.</p>
                            <textarea name="ingresso" class="form-control" rows="10" required><?php echo $projeto['ingresso'] ?></textarea>
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Democratização de acesso</label>
                            <p align="justify">Ainda que o ingresso do projeto seja de valor baixo ou gratuito, é necessário se pensar em como democratizar o acesso às produções culturais feitas na cidade. A democratização de acesso não tem relação apenas com o preço de uma atividade, mas com a linguagem, com o espaço, com a divulgação, com a formação de público, etc. Pode estar diretamente relacionado com as contrapartidas oferecidas, por exemplo. Tente expor de que forma você considera que seu projeto está atuando no sentido da democratização da cultura.</p>
                            <textarea name="democratizacao" class="form-control" rows="10" required><?php echo $projeto['democratizacao'] ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Acessibilidade</label>
                            <p align="justify">Você deverá explicar como o projeto buscará ser acessível às pessoas com deficiência. Haverá algum tipo de auxílio no local do projeto? Haverá alguma preocupação com a linguagem dos materiais do projeto e das obras? O espaço físico é apropriado para receber pessoas com deficiências motoras?</p>
                            <textarea name="acessibilidade" class="form-control" rows="10" required><?php echo $projeto['acessibilidade'] ?></textarea>
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
    <!-- Inicio Modal Informações Orçamento -->
    <div class="modal fade" id="infoContrapartida" role="dialog" aria-labelledby="infoContrapartidaLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Atenção aos limites!!</h4>
                </div>
                <div class="modal-body" style="text-align: left;">
                    <p align="justify">Você deverá oferecer atividades que ofereçam acesso ao seu projeto a mais pessoas e a diferentes públicos, principalmente pessoas em situação de vulnerabilidade social.</p>
                    <p align="justify">Se você deseja se encaixar no cálculo previsto no Art. 53 do Decreto nº 59.119/2019, precisará atentar que as contrapartidas do seu projeto, além da gratuidade total e do atendimento a alunos da rede pública de ensino, devem incluir pelo menos uma das opções abaixo:</p>
                    <ul class="list-group">
                        <li class="list-group-item">plano de residência artística voltado a artistas moradores das Faixas 1 e 2 referidas no artigo 51;</li>
                        <li class="list-group-item">cessão de espaço do proponente para apresentações de grupos fomentados diretamente pela Secretaria Municipal da Cultura por Editais de Fomento direto, tais como Fomento à Periferia, VAI e Fomento às Linguagens Artísticas;</li>
                        <li class="list-group-item">contratação de jovens moradores dos distritos pertencentes à Faixa 1 referida no artigo 51 para prestação de serviços necessários à realização do projeto ou para outras atividades de caráter permanente da instituição;</li>
                        <li class="list-group-item">realização de atividades de difusão e democratização relacionadas ao projeto, tais como oficinas, apresentações, seminários, em distritos pertencentes às Faixas 1 e 2 referidas no artigo 51.</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim Modal Informações Orçamento -->
</section>