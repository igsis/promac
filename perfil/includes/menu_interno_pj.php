<div class="row">
	<div class="form-group">
		<div class="col-md-offset-2 col-md-8">
			<strong>
			| <a href="?perfil=informacoes_iniciais_pj">Informações Iniciais</a>
			| <a href="?perfil=endereco_pj">Endereço</a>
			| <a href="?perfil=representante1_pj">Representante #1</a>
			| <a href="?perfil=representante2_pj">Representante #2</a>
			| <a href="?perfil=dados_bancarios_pj">Dados Bancários</a>
			<?php
			if(isset($_SESSION['idEvento']))
			{
			?>
				| <a href="?perfil=artista_pj">Artista</a>
				| <a href="?perfil=grupo">Integrantes do Elenco</a>
			<?php
			}
			?>
			| <a href="?perfil=anexos_pj">Demais Anexos</a>
			<?php
			if(isset($_SESSION['idEvento']))
			{
			?>
				| <a href="?perfil=evento_edicao">Evento</a>
				| <a href="?perfil=finalizar">Finalizar</a>
			<?php
			}
			?>
			| <a href="?secao=perfil">Início</a>
			| <a href="../manual" target="_blank">Ajuda</a>
			| <a href="../include/logoff.php">Sair</a> |</strong><br/>
		</div>
	</div>
</div>
<br/>