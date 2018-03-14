<?php

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

			 $query = "SELECT * FROM projeto WHERE idPf='$idPf' AND publicado='1' AND idProjeto=(SELECT MAX(idProjeto) FROM projeto)";
			 $en = mysqli_query($con, $query);
			 while($row = mysqli_fetch_array($en, MYSQLI_ASSOC)){
		 ?>
		 <div class="well">
			<p align="justify"><strong>Referência:</strong> <?php echo $row['idProjeto']; ?></p>
			<p align="justify"><strong>Valor do projeto:</strong> <?php echo isset($row['valorProjeto']) ? $row['valorProjeto'] : null; ?></p>
			<p align="justify"><strong>Valor do incentivo:</strong> <?php echo isset($row['valorIncentivo']) ? $row['valorIncentivo'] : null; ?><p>
			<p align="justify"><strong>Valor do financiamento:</strong> <?php echo isset($row['valorFinanciamento']) ? $row['valorFinanciamento'] : null; ?><p>
			<p align="justify"><strong>Marca:</strong> <?php echo isset($row['exposicaoMarca']) ? $row['exposicaoMarca'] : null; ?><p>
		</div>

		<div class = "page-header">
		 	<h5>Informações gerais do projeto</h5>
		 	<br>
		 </div>

		  <div class="well">
			<p align="justify"><strong>Resumo do projeto:</strong> <?php echo isset($row['resumoProjeto']) ? $row['resumoProjeto'] : null; ?></p>
			<p align="justify"><strong>Currículo:</strong> <?php echo isset($row['curriculo']) ? $row['curriculo'] : null; ?></p>
			<p align="justify"><strong>Descrição:</strong> <?php echo isset($row['descricao']) ? $row['descricao'] : null; ?></p>
			<p align="justify"><strong>Justificativa:</strong> <?php echo isset($row['justificativa']) ? $row['justificativa'] : null; ?></p>
			<p align="justify"><strong>Objetivo:</strong> <?php echo isset($row['objetivo']) ? $row['objetivo'] : null; ?></p>
			<p align="justify"><strong>Metodologia:</strong> <?php echo isset($row['metodologia']) ? $row['metodologia'] : null; ?></p>
			<p align="justify"><strong>Contrapartida:</strong> <?php echo isset($row['contrapartida']) ? $row['contrapartida'] : null; ?></p>
		 </div>

		 <div class = "page-header">
		 	<h5>Detalhamento</h5>
		 	<br>
		 </div>

		 <div class="well">
		 	<p align="justify"><strong>Público alvo:</strong> <?php echo isset($row['publicoAlvo']) ? $row['publicoAlvo'] : null; ?></p>
		 	<p align="justify"><strong>Plano de divulgação:</strong> <?php echo isset($row['planoDivulgacao']) ? $row['planoDivulgacao'] : null; ?></p>
		 	<p align="justify"><strong>Início do cronograma:</strong> <?php echo isset($row['inicioCronograma']) ? $row['inicioCronograma'] : null; ?></p>
		 	<p align="justify"><strong>Fim do cronograma:</strong> <?php echo isset($row['fimCronograma']) ? $row['fimCronograma'] : null; ?></p>
		 </div>

		 <div class = "page-header">
		 	<h5>Informações sobre custos</h5>
		 	<br>
		 </div>

		 <div class="well">
		 	<p align="justify"><strong>Pré-produção:</strong> <?php echo isset($row['totalPreProducao']) ? $row['totalPreProducao'] : null; ?></p>
		 	<p align="justify"><strong>Produção:</strong> <?php echo isset($row['totalProducao']) ? $row['totalProducao'] : null; ?></p>
		 	<p align="justify"><strong>Imprensa:</strong> <?php echo isset($row['totalImprensa']) ? $row['totalImprensa'] : null; ?></p>
		 	<p align="justify"><strong>Administrativos:</strong> <?php echo isset($row['totalCustosAdministrativos']) ? $row['totalCustosAdministrativos'] : null; ?></p>
		 	<p align="justify"><strong>Impostos:</strong> <?php echo isset($row['totalImpostos']) ? $row['totalImpostos'] : null; ?></p>
		 	<p align="justify"><strong>Agenciamento:</strong> <?php echo isset($row['totalAgenciamento']) ? $row['totalAgenciamento'] : null; ?></p>
		 	<p align="justify"><strong>Outros financiamentos:</strong> <?php echo isset($row['totalOutrosFinanciamentos']) ? $row['totalOutrosFinanciamentos'] : null; ?></p>
		 </div>

		 <div class = "page-header">
		 	<h5>Mídias sociais</h5>
		 	<br>
		 </div>

		 <div class="well">
		 	<p align="justify"><strong>Vídeo 1:</strong> <?php echo isset($row['video1']) ? $row['video1'] : null; ?></p>
		 	<p align="justify"><strong>Vídeo 2:</strong> <?php echo isset($row['video2']) ? $row['video2'] : null; ?></p>
		 	<p align="justify"><strong>Vídeo 3:</strong> <?php echo isset($row['video3']) ? $row['video3'] : null; ?></p>
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
			 <?php
			 $pj = $row['idPj'];
			 $query = "SELECT * FROM pessoa_juridica WHERE idPj='$pj'";
			 $send = mysqli_query($con, $query);
			 while($rowPJ = mysqli_fetch_array($send, MYSQLI_ASSOC)){?>
		 	<p align="justify"><strong>Referência:</strong> <?php echo isset($row['idPj']) ?? null; ?></p>
		 	<p align="justify"><strong>Razão social:</strong> <?php echo isset($rowPJ['razaoSocial']) ? $rowPJ['razaoSocial'] : null; ?></p>
		 	<p align="justify"><strong>CNPJ:</strong> <?php echo isset($rowPJ['cnpj']) ? $rowPJ['cnpj'] : null; ?></p>
			<p align="justify"><strong>CCM:</strong> <?php echo isset($rowPJ['ccm']) ? $rowPJ['ccm'] : null; ?></p>
			<p align="justify"><strong>Logradouro:</strong> <?php echo isset($rowPJ['logradouro']) ? $rowPJ['logradouro'] : null; ?></p>
			<p align="justify"><strong>Bairro:</strong> <?php echo isset($rowPJ['bairro']) ? $rowPJ['bairro'] : null; ?></p>
			<p align="justify"><strong>Cidade:</strong> <?php echo isset($rowPJ['cidade']) ? $rowPJ['cidade'] : null; ?></p>
			<p align="justify"><strong>Estado:</strong> <?php echo isset($rowPJ['estado']) ? $rowPJ['estado'] : null; ?></p>
			<p align="justify"><strong>CEP:</strong> <?php echo isset($rowPJ['cep']) ? $rowPJ['cep'] : null; ?></p>
			<p align="justify"><strong>Número:</strong> <?php echo isset($rowPJ['numero']) ? $rowPJ['numero'] : null; ?></p>
			<p align="justify"><strong>Telefone:</strong> <?php echo isset($rowPJ['telefone']) ? $rowPJ['telefone'] : null; ?></p>
			<p align="justify"><strong>Celular:</strong> <?php echo isset($rowPJ['celular']) ? $rowPJ['celular'] : null; ?></p>
			<p align="justify"><strong>Email:</strong> <?php echo isset($rowPJ['email']) ? $rowPJ['email'] : null; ?></p>
		 </div>
		 <?php }
	 }
	 }?>
	</div>

<!-- Botão para Prosseguir -->
	<div class="form-group">
		<div class="col-md-offset-2 col-md-2">
			<form class="form-horizontal" role="form" action="?perfil=projeto_13" method="post">
				<input type="submit" value="Voltar" class="btn btn-theme btn-lg btn-block">
			</form>
		</div>
		<div class="col-md-offset-4 col-md-2">
			<form class="form-horizontal" role="form" action="?perfil=informacoes_administrativas" method="post">
				<input type="submit" value="Enviar" class="btn btn-theme btn-lg btn-block">
			</form>
		</div>
	</div>
</section>
