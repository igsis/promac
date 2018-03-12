<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

$idOrcamento = $_POST['carregar'];
$orcamento = recuperaDados("orcamento","idOrcamento",$idOrcamento);

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
								<?php echo geraOpcao("etapa",$orcamento['idEtapa']) ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Descrição: *</strong><br/>
							<input type="text" class="form-control" name="descricao" placeholder="Descrição da etapa" maxlength="255" value="<?php echo $orcamento['descricao'] ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-2"><strong>Quantidade:</strong><br/>
							<input type="text" class="form-control" name="quantidade" placeholder="Quantidade" value="<?php echo $orcamento['quantidade'] ?>">
						</div>
						<div class="col-md-2"><strong>Unidade Medida:</strong><br/>
							<select class="form-control" name="idUnidadeMedida" >
								<option value="0"></option>
								<?php echo geraOpcao("unidade_medida",$orcamento['idUnidadeMedida']) ?>
							</select>
						</div>
						<div class="col-md-2"><strong>Qtde Unidade:</strong><br/>
							<input type="text" class="form-control" name="quantidadeUnidade" placeholder="Quantidade das Unidades" value="<?php echo $orcamento['quantidadeUnidade'] ?>">
						</div>
						<div class="col-md-2"><strong>Valor Unitário:</strong><br/>
							<input type="text" class="form-control" id='valor' name="valorUnitario" value="<?php echo dinheiroParaBr($orcamento['valorUnitario']) ?>">
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="editaOrcamento" value="<?php echo $idOrcamento ?>">
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</section>