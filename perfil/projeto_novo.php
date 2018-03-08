<?php
$con = bancoMysqli();
$idPf= $_SESSION['idUser'];
?>
<section id="inserir" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h4>PASSSO 1:</h4>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=evento_edicao" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Área de atuação *</label>
							<select class="form-control" name="idAreaAtuacao" >
								<option value="1"></option>
								<?php echo geraOpcao("area_atuacao","") ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-3 col-md-2">
							<label>Valor total do <br/>projeto</label>
							<input type="text" name="nomeGrupo" class="form-control" maxlength="100" id="inputSubject" placeholder="Nome do coletivo, grupo teatral, etc." />
						</div>
						<div class="col-md-2">
							<label>Valor solicitado como incentivo</label>
							<input type="text" name="nomeGrupo" class="form-control" maxlength="100" id="inputSubject" placeholder="Nome do coletivo, grupo teatral, etc." />
						</div>
						<div class="col-md-2">
							<label>Valor de outros financiamentos</label>
							<input type="text" name="nomeGrupo" class="form-control" maxlength="100" id="inputSubject" placeholder="Nome do coletivo, grupo teatral, etc." />
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-7">
							<label>Enquadramento da renúncia fiscal *</label>
							<select class="form-control" name="idAreaAtuacao" >
								<option value="1"></option>
								<?php echo geraOpcao("area_atuacao","") ?>
							</select>
						</div>
						<div class="col-md-1"><br/>? Ícone
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Resumo do projeto*</label>
							<textarea name="resumoProjeto" class="form-control" rows="10" maxlength="500"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Currículo do proponente*</label>
							<p>Experiências na área, parcerias anteriores</p>
							<textarea name="curriculo" class="form-control" rows="10" maxlength="25000"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Descrição do Objeto*</label>
							<p>Considerando a realidade no qual está inserido, devendo ser demonstrado o nexo entre essa realidade e as atividades ou projetos e metas a serem atingidas.</p>
							<textarea name="descricao" class="form-control" rows="10"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Justificativa do projeto*</label>
							<p>Considerando a realidade no qual está inserido, devendo ser demonstrado o nexo entre essa realidade e as atividades ou projetos e metas a serem atingidas.</p>
							<textarea name="justificativa" class="form-control" rows="10" maxlength="10000"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Objetivos e metas*</label>
							<p>Considerando a realidade no qual está inserido, devendo ser demonstrado o nexo entre essa realidade e as atividades ou projetos e metas a serem atingidas.</p>
							<textarea name="objetivo" class="form-control" rows="10" maxlength="10000"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Metodologia*</label>
							<p>Parâmetros a serem utilizados para aferição do cumprimento das metas.</p>
							<textarea name="metodologia" class="form-control" rows="10" maxlength="10000"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Local de realização*</label>
							<p>Fazer botão.</p>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Público alvo*</label>
							<textarea name="publicoAlvo" class="form-control" rows="10"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Plano de divulgação*</label>
							<textarea name="planoDivulgacao" class="form-control" rows="10" maxlength="15000"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<label>Ficha técnica*</label>
							<p>Fazer botão.</p>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="insere" />
							<input type="submit" class="btn btn-theme btn-lg btn-block" value="Gravar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>