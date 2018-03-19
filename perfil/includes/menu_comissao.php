<?php
$pasta = "?perfil=";
?>
<div class="menu-area">
	<div id="dl-menu" class="dl-menuwrapper">
		<button class="dl-trigger">Open Menu</button>
		<ul class="dl-menu">
			<li><a href="<?php echo $pasta ?>comissao_index">Home</a></li>
			<li><a href="<?php echo $pasta ?>comissao_pesquisa">Pesquisa</a></li>
			<li style="color:white;">-------------------------</li>
			<li><a href="index.php?secao=perfil">Início</a></li>
			<li><a href="<?php echo $pasta ?>minha_conta">Minha conta</a></li>
			<li><a href="../manual" target="_blank">Ajuda</a></li>
			<li><a href="../include/logoff.php">Sair</a></li>
		</ul>
	</div>
</div>