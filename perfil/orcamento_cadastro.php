<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];
?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<h4>Orçamento</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=#" method="post">

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

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Botão para Voltar e Prosseguir -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=endereco_pj" method="post">
							<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</form>
					</div>
					<div class="col-md-offset-4 col-md-2">
						<form class="form-horizontal" role="form" action="?perfil=arquivos_pj" method="post">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</section>