<?php

include "visual/cabecalho_index.php";
include "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";

$con = bancoMysqli();
$tipoPessoa = '6';

?>

<section id="list_items" class="home-section bg-white">
	<div class="container">
		<div class="form-group">
			<div class="col-md-offset-2 col-md-8">
				<strong>
					<a href="include/logoff.php">VOLTAR À TELA DE INÍCIO</a>
				</strong>
			</div>
		</div>
		<br/>
		<div class="form-group">
			<h4>Projetos Aprovados</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<!-- Exibir arquivos -->
				<div class="form-group">
					<div class="col-md-12">
						<div class="table-responsive list_info">
							<?php listaArquivosAnalise($tipoPessoa,"analise_projeto"); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
