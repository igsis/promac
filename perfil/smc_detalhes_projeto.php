<?php
$con = bancoMysqli();

$idProjeto = $_POST['idProjeto'];
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);

if($projeto['tipoPessoa'] == 1)
{
	$pf = recuperaDados("pessoa_fisica","idPf",$lista['idPf']);
}
else
{
	$pj = recuperaDados("pessoa_juridica","idPj",$lista['idPj']);
}
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Ambiente SMC</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<!-- LABELS -->
						<ul class="nav nav-tabs">
    						<li class="nav active"><a href="#prazo" data-toggle="tab">Prazos</a></li>
    						<li class="nav"><a href="#projeto" data-toggle="tab">Projeto</a></li>
    						<li class="nav"><a href="#F" data-toggle="tab">Pessoa Fisica</a></li>
    						<li class="nav"><a href="#J" data-toggle="tab">Pessoa Jurídica</a></li>
						</ul>

						<!-- LABEL PRAZOS -->
						<div class="tab-pane fade in active" id="prazo">
							<br>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Informações iniciais</b></li>
								<li class="list-group-item">Razão Social</li>
								<li class="list-group-item">CNPJ</li>
							</ul>
						</div>

						<!-- LABEL PROJETO -->
						<div class="tab-pane fade in active" id="projeto">
							<br>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Informações legais</b></li>
								<li class="list-group-item"><strong>Referência:</strong> <?php echo $projeto['idProjeto']; ?></li>
								<li class="list-group-item"><strong>Valor do projeto:</strong> <?php echo isset($projeto['valorProjeto']) ? $projeto['valorProjeto'] : null; ?></li>
								<li class="list-group-item"><strong>Valor do incentivo:</strong> <?php echo isset($projeto['valorIncentivo']) ? $projeto['valorIncentivo'] : null; ?></li>
								<li class="list-group-item"><strong>Valor do financiamento:</strong> <?php echo isset($projeto['valorFinanciamento']) ? $projeto['valorFinanciamento'] : null; ?></li>
								<li class="list-group-item"><strong>Marca:</strong> <?php echo isset($projeto['exposicaoMarca']) ? $projeto['exposicaoMarca'] : null; ?></li>
							</ul>
						</div>

						<!-- LABEL PESSOA FÍSICA -->
						<div class="tab-pane fade in active" id="F">
							<br>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Informações iniciais</b></li>
								<li class="list-group-item">Nome</li>
								<li class="list-group-item">CNPJ</li>
							</ul>
						</div>

						<!-- LABEL PESSOA JURÍDICA -->
						<div class="tab-pane fade in active" id="P">
							<br>
							<ul class="list-group">
								<li class="list-group-item list-group-item-success"><b>Informações iniciais</b></li>
								<li class="list-group-item">Razão Social</li>
								<li class="list-group-item">CNPJ</li>
							</ul>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>