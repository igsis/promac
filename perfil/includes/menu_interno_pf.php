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
				| <a href="?perfil=projeto_2">2</a>
				| <a href="?perfil=projeto_3">3</a>
				| <a href="?perfil=projeto_4">4</a>
				| <a href="?perfil=projeto_5">5</a>
				| <a href="?perfil=projeto_6">6</a>
				| <a href="?perfil=local">7 Local</a>
				| <a href="?perfil=projeto_8">8</a>
				| <a href="?perfil=ficha_tecnica">9 Ficha Técnica</a>
				| <a href="?perfil=cronograma">10 Cronograma</a>
				| <a href="?perfil=orcamento">11 Orçamento</a>
				| <a href="?perfil=anexos">12 PDF</a>
				| <a href="?perfil=projeto_13">13 Link do Youtube</a>
				| <a href="?perfil=finalProjeto">Finalização</a>
				| <a href="?perfil=informacoes_administrativas">Informações Administrativas</a>
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