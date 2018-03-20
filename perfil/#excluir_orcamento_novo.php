<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];
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
			<h4>Orçamento</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=orcamento" method="post">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Etapa *</label>
							<select class="form-control" name="idEtapa" >
								<option value="0"></option>
								<?php echo geraOpcao("etapa","") ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Descrição: *</strong><br/>
							<input type="text" class="form-control" name="descricao" placeholder="Descrição da etapa" maxlength="255" >
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-2"><strong>Quantidade:</strong><br/>
							<input type="text" class="form-control" name="quantidade" placeholder="Quantidade">
						</div>
						<div class="col-md-2"><strong>Unidade Medida:</strong><br/>
							<select class="form-control" name="idUnidadeMedida" >
								<option value="0"></option>
								<?php echo geraOpcao("unidade_medida","") ?>
							</select>
						</div>
						<div class="col-md-2"><strong>Qtde Unidade:</strong><br/>
							<input type="text" class="form-control" name="quantidadeUnidade" placeholder="Quantidade das Unidades">
						</div>
						<div class="col-md-2"><strong>Valor Unitário:</strong><br/>
							<input type="text" class="form-control" id='valor' name="valorUnitario">
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="insereOrcamento" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>

			</div>
		</div>
		<!-- Inicio Modal Informações Orçamento -->
			<div class="modal fade" id="infoOrcamento" role="dialog" aria-labelledby="infoOrcamentoLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Atenção aos limites!!</h4>
						</div>
						<div class="modal-body" style="text-align: left;">
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Conforme art. 53 do Decreto 58.041/2017</b></li>
								<li class="list-group-item">Os projetos culturais poderão acolher despesas de administração de até 20% (vinte por cento) do valor total do projeto, englobando gastos administrativos e serviços de captação de recursos.</li>
								<li class="list-group-item">Para fins de composição das despesas de administração, deverão ser considerados os tetos de 15% (quinze por cento) para gastos administrativos e de 10% (dez por cento) para o serviço de captação de recursos</li>
							</ul>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
						</div>
					</div>
				</div>
			</div>
		<!-- Fim Modal Informações Orçamento -->
	</div>
</section>