<section id="list_items" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="form-group">
				<div class="col-md-offset-2 col-md-8">
					<strong>
						<a href="../include/logoff.php">Voltar a Tela de Login</a>
					</strong>
				</div>
			</div>
		</div>
		<div class="form-group">
			<h4>Consulta Pública</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>

		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="well">
					Nesta área, você pode consultar os projetos já aprovados!
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=consulta_publica_resultado" class="form-horizontal" role="form">
					<hr/>

					<label>PESSOA FÍSICA</label>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-5"><label>Nome</label>
							<input type="text" name="nome" class="form-control" placeholder="">
						</div>
						<div class="col-md-3"><label>CPF</label>
							<input type="text" name="cpf" id="cpf" class="form-control" placeholder="">
						</div>
					</div>
					<hr/>

					<label>PESSOA JURÍDICA</label>
					<div class="form-group">
						<div class="col-md-offset-2 col-md-5"><label>Razão Social</label>
							<input type="text" name="razaoSocial" class="form-control" placeholder="">
						</div>
						<div class="col-md-3"><label>CNPJ</label>
							<input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="">
						</div>
					</div>
					<hr/>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Nome do projeto</label>
							<input type="text" name="nomeProjeto" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Protocolo</label>
							<input type="text" name="protocolo" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Área atuação</label>
							<select class="form-control" name="idAreaAtuacao" >
								<option value="0"></option>
								<?php echo geraOpcao("area_atuacao","") ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Valor Aprovado</label>
							<input type="text" name="valorAprovado" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="pesquisar" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>