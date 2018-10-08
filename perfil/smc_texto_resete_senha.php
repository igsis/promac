<?php
$con = bancoMysqli();

$id = $_POST['id'];
$tipoPessoa = $_POST['tipoPessoa'];
$senha = MD5('promac2018');

switch ($tipoPessoa)
{
    case 1:
        $tabela = "pessoa_fisica";
        break;

    case 2:
        $tabela = "pessoa_juridica";
        break;

    case 4:
        $tabela = "incentivador_pessoa_fisica";
        break;

    case 5:
        $tabela = "incentivador_pessoa_juridica";
}

if(($tipoPessoa == 1) || ($tipoPessoa == 4))
{
	$sql = "UPDATE `$tabela` SET senha = '$senha' WHERE `idPf` = '$id'";
	if(mysqli_query($con,$sql))
	{
		$pf = recuperaDados($tabela,"idPf",$id);
		$mensagem = "
			<h5>Texto para o envio de email</h5>
			<p align='justify'><strong>Endereço de e-mail para resposta:</strong> ".$pf['email']."</p>
			<br/><br/>
			<p align='left'><strong>".saudacao()."!</strong></p>
			<br/>
			<p align='justify'>Sua senha foi reiniciada com sucesso! Para acessar o sistema, utilize as seguintes informações:</p>
			<p align='justify'><strong>Login:</strong> ".$pf['cpf']."</p>
			<p align='justify'><strong>Senha:</strong> promac2018</p>
			<p align='justify'><strong>Endereço de acesso:</strong> <a href='http://smcsistemas.prefeitura.sp.gov.br/promac/'>http://smcsistemas.prefeitura.sp.gov.br/promac</a></p>
			<br/>
			<p align='justify'><strong>Atenção: Pedimos que, para sua segurança, altere sua senha no primeiro login, através do MENU -> Trocar minha senha</strong></p>
			<br/>
			<p align='justify'>Att.</p>
		";
		gravarLog($sql);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao reiniciar a senha! Tente novamente.</strong></font>";
	}
}
else
{
	$sql = "UPDATE `$tabela` SET senha = '$senha' WHERE `idPj` = '$id'";
	if(mysqli_query($con,$sql))
	{
		$pj = recuperaDados($tabela,"idPj",$id);
		$mensagem = "
			<h5>Texto para o envio de email</h5>
			<p align='justify'><strong>Endereço de e-mail para resposta:</strong> ".$pj['email']."</p>
			<br/><br/>
			<p align='left'><strong>".saudacao()."!</strong></p>
			<br/>
			<p align='justify'>Sua senha foi reiniciada com sucesso! Para acessar o sistema, utilize as seguintes informações:</p>
			<p align='justify'><strong>Login:</strong> ".$pj['cnpj']."</p>
			<p align='justify'><strong>Senha:</strong> promac2018</p>
			<p align='justify'><strong>Endereço de acesso:</strong> <a href='http://smcsistemas.prefeitura.sp.gov.br/promac/'>http://smcsistemas.prefeitura.sp.gov.br/promac</a></p>
			<br/>
			<p align='justify'><strong>Atenção: Pedimos que, para sua segurança, altere sua senha no primeiro login, através do MENU -> Trocar minha senha</strong></p>
			<br/>
			<p align='justify'>Att.</p>
		";
		gravarLog($sql);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao reiniciar a senha! Tente novamente.</strong></font>";
	}
}

?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<?php echo isset($mensagem) ? $mensagem : ''; ?>
				<p align="justify"></p>
			</div>
		</div>
	</div>
</section>