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
					$query = "SELECT * FROM projeto WHERE idPf='$idUsuario' AND publicado='1' AND idProjeto='$idProjeto'";
					$en = mysqli_query($con, $query);
			 	while($row = mysqli_fetch_array($en, MYSQLI_ASSOC))
			 	{?>
						<div class='well'>
						<p align='justify'><strong>Referência:</strong> <?php echo $row['idProjeto']; ?></p>
						<p align='justify'><strong>Nome do Projeto:</strong> <?php echo isset($row['nomeProjeto']) ? $row['nomeProjeto'] : null; ?></p>
						<p align='justify'><strong>Valor do projeto:</strong> <?php echo isset($row['valorProjeto']) ? $row['valorProjeto'] : null; ?></p>
						<p align='justify'><strong>Valor do incentivo:</strong> <?php echo isset($row['valorIncentivo']) ? $row['valorIncentivo'] : null; ?><p>
						<p align='justify'><strong>Valor do financiamento:</strong> <?php echo isset($row['valorFinanciamento']) ? $row['valorFinanciamento'] : null; ?><p>
						<p align='justify'><strong>Marca:</strong> <?php echo isset($row['exposicaoMarca']) ? $row['exposicaoMarca'] : null; ?><p>
					</div>
					
					<?php
				}
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
									<?php listaArquivosPessoa($pj['idPj'],'2',"resumo_usuario"); ?>
								</div>
							</div>
						</div>
				<?php }
		 ?>
</section>



