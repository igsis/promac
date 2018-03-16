<?php
$pasta = "?perfil=";
?>
<div class="menu-area">
	<div id="dl-menu" class="dl-menuwrapper">
		<button class="dl-trigger">Open Menu</button>
		<ul class="dl-menu">
			<li><a href="<?php echo $pasta ?>smc_index">Home</a></li>
			<li><a href="#">Liberação de envio de projeto</a>
				<ul class="dl-submenu">
					<li><a href="<?php echo $pasta ?>smc_lista_liberacao&tipo=1">Pessoa Física</a></li>
					<li><a href="<?php echo $pasta ?>smc_lista_liberacao&tipo=2">Pessoa Jurídica</a></li>
				</ul>
			</li>
			<li><a href="#">Pesquisas</a>
				<ul class="dl-submenu">
					<li><a href="<?php echo $pasta ?>smc_pesquisa_geral">Geral</a></li>
					<li><a href="<?php echo $pasta ?>smc_pesquisa_prazos">Prazos</a></li>
				</ul>
			</li>
			<li><a href="<?php echo $pasta ?>smc_pesquisa_nome">Nivel de acesso</a></li>
			<li style="color:white;">-------------------------</li>
			<li><a href="index.php?secao=perfil">Início</a></li>
			<li><a href="../manual" target="_blank">Ajuda</a></li>
			<li><a href="../include/logoff.php">Sair</a></li>
		</ul>
	</div>
</div>