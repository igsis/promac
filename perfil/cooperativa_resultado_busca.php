<?php
$con = bancoMysqli();

if(isset($_POST['busca']))
{
	//validação
	$validacao = validaCNPJ($_POST['busca']);
	$validacao = true;
	if($validacao == false)
	{
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=erros&p=erro_cooperativa'>";
	}
	else
	{
		$busca = $_POST['busca'];
		$sql_busca = "SELECT * FROM pessoa_juridica WHERE cnpj = '$busca' ORDER BY razaoSocial";
		$query_busca = mysqli_query($con,$sql_busca);
		$num_busca = mysqli_num_rows($query_busca);
	}
}

if(isset($_POST['insereCooperativa']))
{
	$idPj = $_POST['insereCooperativa'];
	$sql_busca = "SELECT * FROM pessoa_juridica WHERE idPj = '$idPj' ORDER BY razaoSocial";
	$query_busca = mysqli_query($con,$sql_busca);
	$num_busca = mysqli_num_rows($query_busca);
	$idProjeto = $_SESSION['idProjeto'];
	$sql_insere_cooperativa = "UPDATE projeto SET idPj = '$idPj' WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_insere_cooperativa))
	{
		$num_busca = 1;
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Utilize o menu para avançar.</strong></font>";
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0.5;URL=?perfil=projeto_2'>";
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao inserir! Tente novamente.</strong></font> <br/>";
	}
}

if($num_busca > 0)
{ // Se exisitr, lista a resposta.
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
			<div class="form-group">
				<h4>Empresa</h4>
				<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
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
											<td class='list_description'>
												<form method='POST' action='?perfil=cooperativa_resultado_busca'>
													<input type='hidden' name='insereCooperativa' value='".$descricao['idPj']."'>
													<input type ='submit' class='btn btn-theme btn-md btn-block' value='escolher'>
												</form>
											</td>
										</tr>
									";
								}
							?>
							</tbody>
						</table>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<a href="?perfil=projeto_novo"><input type="submit" value="Pesquisar outro CNPJ" class="btn btn-theme btn-block"></a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>

<?php
}
else
{ // se não existir o cpf, imprime um formulário.
?>
	<section id="contact" class="home-section bg-white">
		<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
			<div class="form-group">
				<h4>Empresa</h4>
				<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							Não foi encontrada nenhuma empresa com esse CNPJ cadastrada no sistema. Entre em contato com o representante da empresa e solicite que o cadastro seja efetuado para que você possa prosseguir com o preenchimento do seu projeto.
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6">
							<a href="?perfil=projeto_novo"><input type="submit" value="Pesquisar outro CNPJ" class="btn btn-theme btn-block"></a>
						</div>
						<div class="col-md-6">
							<a href="?perfil=informacoes_iniciais_pf"><input type="submit" value="Voltar" class="btn btn-theme btn-block"></a>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
<?php
}
?>
