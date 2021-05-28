<?php
$pasta = "?perfil=";
?>
<div class="menu-area">
	<div id="dl-menu" class="dl-menuwrapper">
		<button class="dl-trigger">Open Menu</button>
		<ul class="dl-menu">
			<li><a href="<?php echo $pasta ?>comissao_index">Home</a></li>
			<li><a href="<?php echo $pasta ?>comissao_pesquisa">Pesquisa</a></li>
			<li><a href="#">Relatórios</a>
				<ul class="dl-submenu">
					<li><a href="../pdf/excel_comissao.php">Comissão</a></li>
				</ul>
			</li>
			<li style="color:white;">-------------------------</li>
			<li><a href="index_pf.php?perfil=comissao_index">Início</a></li>
			<li><a href="<?php echo $pasta ?>senha">Alterar senha</a></li>
			<li><a href="../manual" target="_blank">Ajuda</a></li>
			<li><a href="../include/logoff.php">Sair</a></li>
		</ul>
	</div>
</div>