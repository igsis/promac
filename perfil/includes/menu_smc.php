<?php
//geram o insert pro framework da igsis
$pasta = "?perfil=";
 ?>

<div class="menu-area">
	<div id="dl-menu" class="dl-menuwrapper">
		<button class="dl-trigger">Open Menu</button>
		<ul class="dl-menu">
			<li><a href="#">Liberação de acesso</a>
				<ul class="dl-submenu">
					<li><a href="<?php echo $pasta ?>smc_lista_liberacao_acesso_pf">Pessoa Física</a></li>
					<li><a href="<?php echo $pasta ?>smc_lista_liberacao_acesso_pj">Pessoa Jurídica</a></li>
				</ul>
			</li>
			<li><a href="<?php echo $pasta ?>frm_busca_dataenvio">Filtro por Data de Envio</a></li>
			<li><a href="#">Especiais</a>
				<ul class="dl-submenu">
					<li><a href="<?php echo $pasta ?>frm_lista_pedidocontratacao_pf&enviados=1">Formação</a></li>
					<li><a href="<?php echo $pasta ?>frm_lista_pedidocontratacao_emia_pf&enviados=1">Emia</a></li>
					<li><a href="#">Virada</a>
						<ul class="dl-submenu">
							<li><a href="<?php echo $pasta ?>frm_lista_projeto&atribuido=0">Sem nº Processo</a>
							<li><a href="<?php echo $pasta ?>frm_lista_projeto&atribuido=1">Com nº Processo</a>
							<li><a href="<?php echo $pasta ?>frm_lista_projeto&atribuido=3">Geral</a>
						</ul>
					</li>
				</ul>
			</li>
			<li style="color:white;">-------------------------</li>
			<li><a href="index.php?secao=perfil">Carregar módulos</a></li>
			<li><a href="http://smcsistemas.prefeitura.sp.gov.br/igsis/manual/index.php/modulo-contratos/">Ajuda</a></li>
			<li><a href="../index.php">Sair</a></li>
		</ul>
	</div>
</div>