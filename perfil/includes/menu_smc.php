<?php
$pasta = "?perfil=";

// Gerar documentos
$server = "http://".$_SERVER['SERVER_NAME']."/promac/";
$http = $server."/pdf/";
$link1 = $http."excel_pf.php";
$link2 = $http."excel_pj.php";
?>
<div class="menu-area">
	<div id="dl-menu" class="dl-menuwrapper">
		<button class="dl-trigger">Open Menu</button>
		<ul class="dl-menu">
			<li><a href="<?php echo $pasta ?>smc_index">Home</a></li>
			<li><a href="#">Usuários</a>
				<ul class="dl-submenu">
					<li><a href="<?php echo $pasta ?>smc_pesquisa_nome">Nível de acesso</a></li>
					<li><a href="<?php echo $pasta ?>smc_pesquisa_reseta_senha">Reiniciar senha</a></li>
				</ul>
			</li>
			<li><a href="#">Pesquisas</a>
				<ul class="dl-submenu">
					<li><a href="<?php echo $pasta ?>smc_pesquisa_pf">Pessoa Física</a></li>
					<li><a href="<?php echo $pasta ?>smc_pesquisa_pj">Pessoa Jurídica</a></li>
					<li><a href="<?php echo $pasta ?>smc_pesquisa_prazos">Prazos</a></li>
					<li><a href="<?php echo $pasta ?>smc_pesquisa_geral">Projetos</a></li>
					<li><a href="<?php echo $pasta ?>smc_pesquisa_incentivadores_pf">Incentivador PF</a></li>
					<li><a href="<?php echo $pasta ?>smc_pesquisa_incentivador_pj">Incentivador PJ</a></li>
				</ul>
			</li>
			<li><a href="#">Relatórios</a>
				<ul class="dl-submenu">
					<li><a href="<?php echo $link1 ?>">Pessoa Física</a></li>
					<li><a href="<?php echo $link2 ?>">Pessoa Jurídica</a></li>
					<li><a href="../pdf/projetos.php">Projetos</a></li>
					<li><a href="../perfil/webLog.php" target="_blank">WebLog</a></li>

				</ul>
			</li>
			<li><a href="?perfil=informacoes_iniciais_pf">Módulo Proponente (provisório)</a></li>
			<li><a href="<?php echo $pasta ?>comissao_index">Módulo Comissão (provisório)</a></li>
			<li><a href="#">Cadastro de projetos</a>
				<ul class="dl-submenu">
					<li><a href="?perfil=smc_gerenciar_projeto&id=1">Liberar</a></li>
					<li><a href="?perfil=smc_gerenciar_projeto&id=2">Bloquear</a></li>
				</ul>
			</li>
			<li style="color:white;">-------------------------</li>
			<li><a href="index.php?secao=perfil">Início</a></li>
			<li><a href="<?php echo $pasta ?>senha">Alterar senha</a></li>
			<li><a href="../manual" target="_blank">Ajuda</a></li>
			<li><a href="../include/logoff.php">Sair</a></li>
		</ul>
	</div>
</div>
