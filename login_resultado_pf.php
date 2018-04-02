<?php

include "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";

$con = bancoMysqli();

if(isset($_POST['busca']))
{
	//validação
	$validacao = validaCPF($_POST['busca']);
	if($validacao == false)
	{
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=erro_login_pf.php'>";
	}
	else
	{
		$busca = $_POST['busca'];
		$sql_busca = "SELECT * FROM pessoa_fisica WHERE cpf = '$busca' ORDER BY nome";
		$query_busca = mysqli_query($con,$sql_busca);
		$num_busca = mysqli_num_rows($query_busca);
	}
}

if($num_busca > 0)
{ // Se exisitr, lista a resposta.
	include "visual/cabecalho_index.php";
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container">
			<div class="form-group">
				<h3>USUÁRIO JÁ POSSUI CADASTRO</h3>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<div class="table-responsive list_info">
						<table class="table table-condensed">
							<thead>
								<tr class="list_menu">
									<td>Nome</td>
									<td>CPF</td>
									<td width="15%"></td>
								</tr>
							</thead>
							<tbody>
							<?php
								while($descricao = mysqli_fetch_array($query_busca))
								{
									echo "
										<tr>
											<td class='list_description'><b>".$descricao['nome']."</b></td>
											<td class='list_description'>".$descricao['cpf']."</td>
											<td><a href='https://drive.google.com/open?id=11W-UF7HakT6lKZt-0qAJ9b0DCactPHsyuLCUSxdcWwo'><input type='submit' value='Esqueci a Senha' class='btn btn-theme btn-block'></a></td>
										</tr>
									";
								}
							?>
							</tbody>
						</table>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<a href="index.php"><input type="submit" value="Entrar com outro usuário" class="btn btn-theme btn-block"></a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
<?php
	include "visual/rodape_index.php";
}
else
{ // se não existir o cpf, imprime um formulário.
	$busca = $_POST['busca'];
	include "visual/cabecalho_index.php";
?>
	<section id="contact" class="home-section bg-white">
		<div class="container">
			<div class="form-group">
				<h4>Cadastro de Pessoa Física</h4>
				<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="login_cadastro_pf.php" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
							<input type="text" class="form-control" name="nome" placeholder="Nome completo">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Senha: *</strong>
							<input type="password" name="senha01" class="form-control" id="inputName" placeholder="">
						</div>
						<div class=" col-md-6"><strong>Redigite a senha: *</strong>
							<input type="password" name="senha02" class="form-control" id="inputEmail" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CPF: *</strong><br/>
							<input type="text" readonly class="form-control" name="cpf" value="<?php echo $busca ?>" placeholder="CPF">
						</div>
						<div class="col-md-6"><strong>Email: *</strong><br/>
							<input type="email" class="form-control" name="email" placeholder="Email">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Escolha uma pergunta secreta, para casos de recuperação de senha:</strong><br/>
							<select class="form-control" name="idFraseSeguranca" id="idFraseSeguranca" required>
								<option>Selecione...</option>
								<?php geraOpcao("frase_seguranca","");	?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Resposta:</strong><br/>
							<input type="text" class="form-control" id="respostaFrase" maxlength="10" name="respostaFrase" required/>
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" value="<?php echo $busca ?>">
							<input type="hidden" name="cadastraNovoPf">
							<input type="submit" value="Enviar" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
				</form>

				</div>
			</div>
		</div>
	</section>
<?php
	include "visual/rodape_index.php";
}
?>