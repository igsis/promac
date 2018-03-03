<?php
$con = bancoMysqli();
$idPessoaFisica = $_SESSION['idUser'];


if(isset($_POST['cadastrarFisica']))
{
	$idPessoaFisica = $_POST['cadastrarFisica'];
	$Nome = addslashes($_POST['nome']);
	$NomeArtistico = addslashes($_POST['nomeArtistico']);
	$IdEstadoCivil = $_POST['idEstadoCivil'];
	$DataNascimento = exibirDataMysql($_POST['dataNascimento']);
	$Nacionalidade = $_POST['nacionalidade'];
	$Telefone1 = $_POST['telefone1'];
	$Telefone2 = $_POST['telefone2'];
	$Telefone3 = $_POST['telefone3'];
	$Email = $_POST['email'];
	
	$sql_insere_pf = "INSERT INTO usuario_pf (`nome`, `nomeArtistico`, `idEstadoCivil`, `dataNascimento`, `nacionalidade`, `telefone1`, `telefone2`, `telefone3`, `email`, `login`, `senha`) VALUES
	('$Nome', '$NomeArtistico','$IdEstadoCivil', '$DataNascimento', '$Nacionalidade', '$Telefone1', '$Telefone2', '$Telefone3', '$Email', '$Login', '$Senha')";	
	
	if(mysqli_query($con,$sql_insere_pf))
	{
		$mensagem = "Atualizado com sucesso!";	
	}
	else
	{
		$mensagem = "Erro ao atualizar! Tente novamente.";
	}	
}

$pf = recuperaDados("usuario_pf","id",$idPessoaFisica);
?>

<section id="contact" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
		<div class="form-group">
			<h3>INFORMAÇÕES INICIAIS</h3>
			<p><b>Código de cadastro:</b> <?php echo $idPessoaFisica; ?> | <b>Nome:</b> <?php echo $pf['nome']; ?></p>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
			<form class="form-horizontal" role="form" action="?insere_pf.php" method="post">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
						<input type="text" class="form-control" name="nome" placeholder="Insira seu nome completo" value="<?php echo $pf['nome']; ?>" >
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nome Artístico:</strong><br/>
						<input type="text" class="form-control" name="nomeArtistico" placeholder="Nome Artístico" value="<?php echo $pf['nomeArtistico']; ?>">
					</div>
				</div>
				  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #1 *:</strong><br/>
						<input type="text" class="form-control" name="telefone1" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone1']; ?>">
					</div>
					<div class="col-md-6"><strong>Telefone #2:</strong><br/>
						<input type="text" class="form-control" name="telefone2" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone2']; ?>">
					</div>
				</div>
						  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Telefone #3:</strong><br/>
						<input type="text" class="form-control" name="telefone3" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php echo $pf['telefone3']; ?>" >
					</div>
					<div class="col-md-6"><strong>E-mail:</strong><br/>
						<input type="text" class="form-control" name="email" placeholder="E-mail" value="<?php echo $pf['email']; ?>" >
					</div>
				</div>	  
		  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-6"><strong>Estado civil:</strong><br/>
						<select class="form-control" name="idEstadoCivil" >
							<?php geraOpcao("estado_civil",$pf['idEstadoCivil'],""); ?>  
						</select>
					</div>				  
					<div class=" col-md-6"><strong>Data de nascimento:</strong><br/>
						<input type="text" class="form-control" id="datepicker01" name="dataNascimento" placeholder="Data de Nascimento" value="<?php echo exibirDataBr($pf['dataNascimento']); ?>">
					</div>
				</div>
		  
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><strong>Nacionalidade:</strong><br/>
						<input type="text" class="form-control" name="nacionalidade" placeholder="Nacionalidade" value="<?php echo $pf['nacionalidade']; ?>">
					</div>	
				</div>
		  
				<!-- Botão para Gravar -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<input type="hidden" name="cadastrarFisica" value="<?php echo $idPessoaFisica ?>">
						<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
					</div>
				</div>
			</form>
			
			
				<!-- Botão para Prosseguir -->
				<div class="form-group">
					<form class="form-horizontal" role="form" action="?perfil=documentos_pf" method="post">
						<div class="col-md-offset-8 col-md-2">
							<input type="submit" value="Avançar" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPessoaFisica ?>">
						</div>
					</form>
				</div>
			
		
			</div>
		</div>
	</div>
</section>  