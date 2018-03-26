<?php
$con = bancoMysqli();
$idusuario = $_GET['id'];
$pf = recuperaDados("pessoa_fisica", "idPf", $idusuario);

if(isset($_POST['consulta']))
{
	$senha1 = $_POST['senha1'];
	$senha2 = $_POST['senha2'];
	if($senha1 == $senha2)
	{
		$passEncrypt = md5($senha1);
		$idUs = $_POST['idUs'];
		$query = "UPDATE pessoa_fisica SET senha = '$passEncrypt' WHERE idPf = '$idUs'";
		$envia = mysqli_query($con, $query);
		if($envia)
		{
			echo "<script>alert('A senha do usuário foi alterada com sucesso!')</script>";
			echo "<script>
			window.location = '/promac/visual/index_pf.php?perfil=resetar_senha';
			</script>";
		}
	} else{
		echo "<script>alert('ERRO: As duas senhas não conferem.')</script>";
		echo "<script>
			window.location = '/promac/visual/index_pf.php?perfil=resetar_senha';
			</script>";
	}
}

?>

<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Resumo do Usuário</h4>
			<div class="alert alert-warning">
				<strong>Atenção!</strong> Confirme atentamente se os dados abaixo estão corretos!
			</div>
		</div>
		 <div class = "page-header">
		 	<h5>Dados do proponente</h5>
		 </div>
		 <div class="well">
			<p align="justify"><strong>Nome:</strong> <?php echo isset($pf['nome']) ? $pf['nome'] : null; ?></p>
			<p align="justify"><strong>CPF:</strong> <?php echo isset($pf['cpf']) ? $pf['cpf'] : null; ?><p>
			<p align="justify"><strong>RG:</strong> <?php echo isset($pf['rg']) ? $pf['rg'] : null; ?><p>
			<p align="justify"><strong>Telefone:</strong> <?php echo isset($pf['telefone']) ? $pf['telefone'] : null; ?></p>
			<p align="justify"><strong>Celular:</strong> <?php echo isset($pf['celular']) ? $pf['celular'] : null; ?></p>
			<p align="justify"><strong>Email:</strong> <?php echo isset($pf['email']) ? $pf['email'] : null; ?></p>
			<p align="justify"><strong>Logradouro:</strong> <?php echo isset($pf['logradouro']) ? $pf['logradouro'] : null; ?></p>
			<p align="justify"><strong>Número:</strong> <?php echo isset($pf['numero']) ? $pf['numero'] : null; ?></p>
			<p align="justify"><strong>Complemento:</strong> <?php echo isset($pf['complemento']) ? $pf['complemento'] : null; ?></p>
			<p align="justify"><strong>Bairro:</strong> <?php echo isset($pf['bairro']) ? $pf['bairro'] : null; ?></p>
			<p align="justify"><strong>Cidade:</strong> <?php echo isset($pf['cidade']) ? $pf['cidade'] : null; ?></p>
			<p align="justify"><strong>Estado:</strong> <?php echo isset($pf['estado']) ? $pf['estado'] : null; ?></p>
			<p align="justify"><strong>CEP:</strong> <?php echo isset($pf['cep']) ? $pf['cep'] : null; ?></p>
		 </div>
	</div>
	<div class = "page-header">
		<div class="col-md-offset-5 col-md-3">
		 <h5> Alteração</h5>
		</div>
	</div>
		 <form method="POST" action="?perfil=visualiza_perfil" class="form-horizontal" role="form">
		 <div class="form-group">
			<div class="col-md-offset-5 col-md-3">
				<input type="password" name="senha1" class="form-control" placeholder="Nova senha">
				<input type="password" name="senha2" class="form-control" placeholder="Confirmação da nova senha">
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-5 col-md-3">
			<form method="POST" action="?perfil=visualiza_perfil" class="form-horizontal" role="form">
				<?php  $idPessoaFi = $pf['idPf'];
				echo "<input type='hidden' name='idUs' value='$idPessoaFi'>'"; ?>
				<br><input type="submit" name="consulta" class="btn btn-theme btn-lg btn-block" value="Alterar">

			</div>
		</div>
</section>