<?php
 
$con = bancoMysqli();
$idUsuario = $_SESSION['idUser'];
$tipoPessoa = $_SESSION['tipoPessoa'];
if ($tipoPessoa == "1")
{
	$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
}
else
{
	$pj = recuperaDados("pessoa_juridica","idPj",$idUsuario);
}
$alterar = 0;

?>
<section id="list_items" class="home-section bg-white">
	<div class="container">
		<?php
    	if($_SESSION['tipoPessoa'] == 1)
		{
			$idPf= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pf.php';
		}
		else
		{
			$idPj= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pj.php';
		}
    	?>

		 <?php
		 	if ($tipoPessoa == "1") // Se Pessoa Fisica
			{
				?>
				<div class='well'>
						<p align='justify'><strong>Nome:</strong> <?php echo isset($pf['nome']) ? $pf['nome'] : null; ?></p>
						<p align='justify'><strong>CPF:</strong> <?php echo isset($pf['cpf']) ? $pf['cpf'] : null; ?></p>
						<p align='justify'><strong>RG:</strong> <?php echo isset($pf['rg']) ? $pf['rg'] : null; ?></p>
						<p align='justify'><strong>Endereço:</strong> <?php echo isset($pf['logradouro']) ? $pf['logradouro'] : null; ?><p>
						<p align='justify'><strong>Bairro:</strong> <?php echo isset($pf['bairro']) ? $pf['bairro'] : null; ?><p>
						<p align='justify'><strong>Cidade:</strong> <?php echo isset($pf['cidade']) ? $pf['cidade'] : null; ?><p>
						<p align='justify'><strong>Estado:</strong> <?php echo isset($pf['estado']) ? $pf['estado'] : null; ?><p>
						<p align='justify'><strong>CEP:</strong> <?php echo isset($pf['cep']) ? $pj['numero'] : null; ?><p>
						<p align='justify'><strong>Número:</strong> <?php echo isset($pf['numero']) ? $pf['numero'] : null; ?><p>
						<p align='justify'><strong>Complemento:</strong> <?php echo isset($pf['complemento']) ? $pf['complemento'] : null; ?><p>
						<p align='justify'><strong>Telefone:</strong> <?php echo isset($pf['telefone']) ? $pf['telefone'] : null; ?><p>
						<p align='justify'><strong>Celular:</strong> <?php echo isset($pf['celular']) ? $pf['celular'] : null; ?><p>
						<p align='justify'><strong>Email:</strong> <?php echo isset($pf['email']) ? $pf['email'] : null; ?><p>
						</div>
						
						<div class="form-group">
							<div class="col-md-12">
								<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
									<?php listaArquivosPessoaSApagar($pf['idPf'],'1',"resumo_usuario"); ?>
								</div>
							</div>
						</div>
						<?php
					
			}
				else // Se Pessoa Juridica
				{ ?>
					<div class='well'>
						<p align='justify'><strong>Razão Social:</strong> <?php echo isset($pj['razaoSocial']) ? $pj['razaoSocial'] : null; ?></p>
						<p align='justify'><strong>CNPJ:</strong> <?php echo isset($pj['cnpj']) ? $pj['cnpj'] : null; ?></p>
						<p align='justify'><strong>Endereço:</strong> <?php echo isset($pj['logradouro']) ? $pj['logradouro'] : null; ?></p>
						<p align='justify'><strong>Bairro:</strong> <?php echo isset($pj['bairro']) ? $pj['bairro'] : null; ?><p>
						<p align='justify'><strong>Cidade:</strong> <?php echo isset($pj['cidade']) ? $pj['cidade'] : null; ?><p>
						<p align='justify'><strong>Estado:</strong> <?php echo isset($pj['estado']) ? $pj['estado'] : null; ?><p>
						<p align='justify'><strong>CEP:</strong> <?php echo isset($pj['cep']) ? $pj['cep'] : null; ?><p>
						<p align='justify'><strong>Número:</strong> <?php echo isset($pj['numero']) ? $pj['numero'] : null; ?><p>
						<p align='justify'><strong>Complemento:</strong> <?php echo isset($pj['complemento']) ? $pj['complemento'] : null; ?><p>
						<p align='justify'><strong>Telefone:</strong> <?php echo isset($pj['telefone']) ? $pj['telefone'] : null; ?><p>
						<p align='justify'><strong>Celular:</strong> <?php echo isset($pj['celular']) ? $pj['celular'] : null; ?><p>
						<p align='justify'><strong>Email:</strong> <?php echo isset($pj['email']) ? $pj['email'] : null; ?><p>
						</div>
						
						<div class="form-group">
							<div class="col-md-12">
								<div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
									<?php listaArquivosPessoaSApagar($pj['idPj'],'2',"resumo_usuario"); ?>
								</div>
							</div>
						</div>
				<?php }
		 ?>
</section>



