<?php
//geram o insert pro framework da igsis
$pasta = "?perfil=";
?>

<div class="menu-area">
	<div id="dl-menu" class="dl-menuwrapper">
		<button class="dl-trigger">Open Menu</button>
		<ul class="dl-menu">
			<li><a href="<?php echo $pasta ?>smc_acesso_administrativo">Acesso administrativo</a></li>
			<li><a href="#">Liberação de envio de projeto</a>
				<ul class="dl-submenu">
					<li><a href="<?php echo $pasta ?>smc_lista_liberacao_projeto_pf">Pessoa Física</a></li>
					<li><a href="<?php echo $pasta ?>smc_lista_liberacao_projeto_pj">Pessoa Jurídica</a></li>
				</ul>
			</li>
			<li><a href="#">Pesquisas</a>
				<ul class="dl-submenu">
					<li><a href="<?php echo $pasta ?>smc_pesquisa_geral">Geral</a></li>
					<li><a href="<?php echo $pasta ?>smc_pesquisa_prazos">Prazos</a></li>
				</ul>
			</li>
			<li><a href="#">Nivel de acesso</a>
				<ul class="dl-submenu">
					<li><a href="<?php echo $pasta ?>smc_pesquisa_nome">Tipo de Acesso</a></li>
					
				</ul>
			</li>
			<li style="color:white;">-------------------------</li>
			<li><a href="index.php?secao=perfil">Início</a></li>
			<li><a href="../manual" target="_blank">Ajuda</a></li>
			<li><a href="../include/logoff.php">Sair</a></li>
		</ul>
	</div>
</div>