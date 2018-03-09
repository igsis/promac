<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-8">
			<strong>
			| <a href="?perfil=informacoes_iniciais_pf">Informações Iniciais</a>
			| <a href="?perfil=arquivos_pf">Arquivos Pessoais</a>
			| <a href="?perfil=projeto_pf">Projeto</a>
			<?php
			if(isset($_SESSION['idProjeto']))
			{
			?>
				| <a href="?perfil=projeto_novo_pf">Projeto Novo</a>
				| <a href="?perfil=projeto_2">Projeto 2</a>
				| <a href="?perfil=informacoes_administrativas_pf">Informações Administrativas</a>
			<?php
			}
			?>
			<br/>
			| <a href="?secao=perfil">Início</a>
			| <a href="../manual" target="_blank">Ajuda</a>
			| <a href="../include/logoff.php">Sair</a> |</strong><br/>
		</div>
	</div>
</div>
<br/>