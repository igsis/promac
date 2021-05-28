<?php include "visual/cabecalho_index.php" ?>
		<section id="list_items" class="home-section bg-white">
			<div class="container">
				<div class="row">
					<div class="col-md-offset-2 col-md-8">
						<div class="section-heading">
							<h4><font color='red'>CPF inválido! Por favor, insira o número correto!</font></h4>
							<h4><font color='red'>Redirecionando...</font></h4>
							<p></p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
			echo "<meta HTTP-EQUIV='refresh' CONTENT='3.5;URL=verifica_pf.php'>";
		?>
	</body>
</html>