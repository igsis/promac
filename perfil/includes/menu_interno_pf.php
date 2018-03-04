<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-8">
			<strong>
			| <a href="?perfil=informacoes_iniciais_pf">Informações Iniciais</a>
			| <a href="?perfil=endereco_pf">Endereço</a>
			| <a href="?perfil=arquivos_pf">Arquivos Pessoais</a>
			| <a href="?perfil=projeto">Projeto</a>
			<?php
			if(isset($_SESSION['idProjeto']))
			{
			?>
				| <a href="?perfil=evento_edicao">Evento</a>
				| <a href="?perfil=finalizar">Finalizar</a>
			<?php
			}
			?>
			| <a href="?perfil=informacoes_administrativas_pf">Informações Administrativas</a><br/>
			| <a href="?secao=perfil">Início</a>
			| <a href="../manual" target="_blank">Ajuda</a>
			| <a href="../include/logoff.php">Sair</a> |</strong><br/>
		</div>
	</div>
</div>
<br/>