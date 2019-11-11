<?php

include "funcoes/funcoesGerais.php";
require "funcoes/funcoesConecta.php";

$con = bancoMysqli();

if(isset($_POST['busca']))
{
	//validação
	$validacao = validaCNPJ($_POST['busca']);
	if($validacao == false)
	{
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=erro_login_pj.php'>";
	}
	else
	{
		$busca = $_POST['busca'];
		$sql_busca = "SELECT * FROM pessoa_juridica WHERE cnpj = '$busca' ORDER BY razaoSocial";
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
									<td>Razão Social</td>
									<td>CNPJ</td>
									<td width="15%"></td>
								</tr>
							</thead>
							<tbody>
							<?php
								while($descricao = mysqli_fetch_array($query_busca))
								{
									echo "
										<tr>
											<td class='list_description'><b>".$descricao['razaoSocial']."</b></td>
											<td class='list_description'>".$descricao['cnpj']."</td>
											<td><a href='recuperar_senha_pj.php'><input type='submit' value='Esqueci a Senha' class='btn btn-theme btn-block'></a></td>
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
    <h5 class="alert alert-danger">Pessoa Jurídica não pode ser orgão público nem MEI.</h5>

	<section id="contact" class="home-section bg-white">
		<div class="container">
			<div class="form-group">
				<h4>Cadastro de Pessoa Jurídica</h4>
				<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="login_cadastro_pj.php" method="post">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Razão Social: *</strong><br/>
							<input type="text" class="form-control" name="razaoSocial" placeholder="Razão Social" required>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Senha: *</strong>
							<input type="password" name="senha01" class="form-control" id="inputName" placeholder="" required>
						</div>
						<div class=" col-md-6"><strong>Redigite a senha: *</strong>
							<input type="password" name="senha02" class="form-control" id="inputEmail" placeholder="" required>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CNPJ: *</strong><br/>
							<input type="text" readonly class="form-control" name="cnpj" value="<?php echo $busca ?>" placeholder="CNPJ">
						</div>
						<div class="col-md-6"><strong>Email: *</strong><br/>
							<input type="email" class="form-control" name="email" placeholder="Email" maxlength="50" required>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Escolha uma pergunta secreta, para casos de recuperação de senha:</strong><br/>
							<select class="form-control" name="idFraseSeguranca" id="idFraseSeguranca" required>
								<option value=''>Selecione...</option>
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
							<input type="hidden" name="cadastraNovoPj">
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