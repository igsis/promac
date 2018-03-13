<?php

/*
	Falta desenvolver as informações de PJ, caso seja cooperado
*/
	
$con = bancoMysqli();
$idPf = $_SESSION['idUser'];
$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
$tipoPessoa = '1';

?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">

			<h4>Resumo do Projeto</h4>
			<div class="alert alert-warning">
				<strong>Atenção!</strong> Confirme atentamente se os dados abaixo estão corretos!
			</div>
		</div>
		 <div class = "page-header">
		 	<h5>Informações legais</h5>
		 	<br>
		 </div>

		 <?php
			 $query = "SELECT * FROM projeto WHERE idPf='$idPf' AND publicado='1' ORDER BY idProjeto desc";
			 $en = mysqli_query($con, $query);
			 $row = mysqli_fetch_array($en);
		 ?>
		 <div class="well">
			<p align="justify"><strong>Referência:</strong> <?php echo $row['idProjeto']; ?></p>
			<p align="justify"><strong>Valor do projeto:</strong> <?php echo isset($row['valorProjeto']) ?? null; ?></p>
			<p align="justify"><strong>Valor do incentivo:</strong> <?php echo isset($row['valorIncentivo']) ?? null; ?><p>
			<p align="justify"><strong>Valor do financiamento:</strong> <?php echo isset($row['valorFinanciamento']) ?? null; ?><p>
			<p align="justify"><strong>Marca:</strong> <?php echo isset($row['exposicaoMarca']) ?? null; ?><p>
		</div>

		<div class = "page-header">
		 	<h5>Informações gerais do projeto</h5>
		 	<br>
		 </div>

		  <div class="well">
			<p align="justify"><strong>Resumo do projeto:</strong> <?php echo isset($row['resumoProjeto']) ?? null; ?></p>
			<p align="justify"><strong>Currículo:</strong> <?php echo isset($row['curriculo']) ?? null; ?></p>
			<p align="justify"><strong>Descrição:</strong> <?php echo isset($row['descricao']) ?? null; ?></p>
			<p align="justify"><strong>Justificativa:</strong> <?php echo isset($row['justificativa']) ?? null; ?></p>
			<p align="justify"><strong>Objetivo:</strong> <?php echo isset($row['objetivo']) ?? null; ?></p>
			<p align="justify"><strong>Metodologia:</strong> <?php echo isset($row['metodologia']) ?? null; ?></p>
			<p align="justify"><strong>Contrapartida:</strong> <?php echo isset($row['contrapartida']) ?? null; ?></p>
		 </div>

		 <div class = "page-header">
		 	<h5>Detalhamento</h5>
		 	<br>
		 </div>

		 <div class="well">
		 	<p align="justify"><strong>Público alvo:</strong> <?php echo isset($row['publicoAlvo']) ?? null; ?></p>
		 	<p align="justify"><strong>Plano de divulgação:</strong> <?php echo isset($row['planoDivulgacao']) ?? null; ?></p>
		 	<p align="justify"><strong>Início do cronograma:</strong> <?php echo isset($row['inicioCronograma']) ?? null; ?></p>
		 	<p align="justify"><strong>Fim do cronograma:</strong> <?php echo isset($row['fimCronograma']) ?? null; ?></p>
		 </div>

		 <div class = "page-header">
		 	<h5>Informações sobre custos</h5>
		 	<br>
		 </div>

		 <div class="well">
		 	<p align="justify"><strong>Pré-produção::</strong> <?php echo isset($row['totalPreProducao']) ?? null; ?></p>
		 	<p align="justify"><strong>Produção:</strong> <?php echo isset($row['totalProducao']) ?? null; ?></p>
		 	<p align="justify"><strong>Imprensa:</strong> <?php echo isset($row['totalImprensa']) ?? null; ?></p>
		 	<p align="justify"><strong>Administrativos:</strong> <?php echo isset($row['totalCustosAdministrativos']) ?? null; ?></p>
		 	<p align="justify"><strong>Impostos:</strong> <?php echo isset($row['totalImpostos']) ?? null; ?></p>
		 	<p align="justify"><strong>Agenciamento:</strong> <?php echo isset($row['totalAgenciamento']) ?? null; ?></p>
		 	<p align="justify"><strong>Outros financiamentos:</strong> <?php echo isset($row['totalOutrosFinanciamentos']) ?? null; ?></p>
		 </div>

		 <div class = "page-header">
		 	<h5>Mídias sociais</h5>
		 	<br>
		 </div>

		 <div class="well">
		 	<p align="justify"><strong>Vídeo 1:</strong> <?php echo isset($row['video1']) ?? null; ?></p>
		 	<p align="justify"><strong>Vídeo 2:</strong> <?php echo isset($row['video2']) ?? null; ?></p>
		 	<p align="justify"><strong>Vídeo 3:</strong> <?php echo isset($row['video3']) ?? null; ?></p>
		 </div>

		 <?php
		 if($row['idPj'] != NULL)
		 { 
		 ?>
		  <div class = "page-header">
		 	<h5>Informações da cooperativa</h5>
		 	<br>
		 </div>

		 <div class="well">
		 	<p align="justify"><strong>Vídeo 1:</strong> <?php echo isset($row['video1']) ?? null; ?></p>
		 	<p align="justify"><strong>Vídeo 2:</strong> <?php echo isset($row['video2']) ?? null; ?></p>
		 	<p align="justify"><strong>Vídeo 3:</strong> <?php echo isset($row['video3']) ?? null; ?></p>
		 </div>
		 <?php } ?>
	</div>
</section>