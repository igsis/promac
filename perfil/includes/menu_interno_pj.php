<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-8">
			<strong>
			| <a href="?perfil=informacoes_iniciais_pj">Informações Iniciais</a>
			| <a href="?perfil=representante_pj">Representante</a>
			| <a href="?perfil=arquivos_pj">Arquivos Pessoais</a>
			| <a href="?perfil=projeto_pj">Projeto</a> |
			<?php
			if(isset($_SESSION['idProjeto']))
			{
			?>
				 <a href="?perfil=artista_pj">Artista</a>
				| <a href="?perfil=grupo">Integrantes do Elenco</a>
				| <a href="?perfil=informacoes_administrativas_pj">Informações Administrativas</a><br/>
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