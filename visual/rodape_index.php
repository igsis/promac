
<footer>
	<div class="container">
		<table width="100%">
			<tr>
				<td align="center"><font color="#ccc">2018 @ Pro-Mac - Programa Municipal de Apoio a Projetos Culturais<br/>Secretaria Municipal de Cultura<br/>Prefeitura de São Paulo</font></td>
			</tr>
		</table>
		<div class="row">
			<div class="col-md-12">
			<?php
				echo "<strong>SESSION</strong><pre>", var_dump($_SESSION), "</pre>";
				echo "<strong>POST</strong><pre>", var_dump($_POST), "</pre>";
				echo "<strong>GET</strong><pre>", var_dump($_GET), "</pre>";
				echo "<strong>FILES</strong><pre>", var_dump($_FILES), "</pre>";
				echo ini_get('session.gc_maxlifetime')/60; // em minutos
			?>
			</div>
		</div>
	</div>
</footer>

<script src="visual/js/bootstrap.min.js"></script>
<script src="visual/js/jquery.smooth-scroll.min.js"></script>
<script src="visual/js/jquery.dlmenu.js"></script>
<script src="visual/js/wow.min.js"></script>
<script src="visual/js/custom.js"></script>
<script src="visual/js/scriptbaixo.js"></script>
</body>
</html>