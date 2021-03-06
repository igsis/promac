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

function listaArquivosPessoaSApagar($idPessoa,$tipoPessoa,$pagina)
{
	$con = bancoMysqli();
	$sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'";
	$query = mysqli_query($con,$sql);
	$linhas = mysqli_num_rows($query);

	if ($linhas > 0)
	{
	echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Nome do arquivo</td>
					<td width='15%'></td>
				</tr>
			</thead>
			<tbody>";
				while($arquivo = mysqli_fetch_array($query))
				{
					echo "<tr>";
					echo "<td class='list_description'>(".$arquivo['documento'].")</td>";
					echo "<td class='list_description'><a href='../uploadsdocs/".$arquivo['arquivo']."' target='_blank'>". mb_strimwidth($arquivo['arquivo'], 15 ,25,"..." )."</a></td>";
				}
				echo "
		</tbody>
		</table>";
	}
	else
	{
		echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
	}
}

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
				<p align='justify'><strong>Endereço:</strong> <?php echo isset($pf['logradouro']) ? $pf['logradouro'] : null; ?></p>
				<p align='justify'><strong>Bairro:</strong> <?php echo isset($pf['bairro']) ? $pf['bairro'] : null; ?></p>
				<p align='justify'><strong>Cidade:</strong> <?php echo isset($pf['cidade']) ? $pf['cidade'] : null; ?></p>
				<p align='justify'><strong>Estado:</strong> <?php echo isset($pf['estado']) ? $pf['estado'] : null; ?></p>
				<p align='justify'><strong>CEP:</strong> <?php echo isset($pf['cep']) ? $pj['cep'] : null; ?></p>
				<p align='justify'><strong>Número:</strong> <?php echo isset($pf['numero']) ? $pf['numero'] : null; ?></p>
				<p align='justify'><strong>Complemento:</strong> <?php echo isset($pf['complemento']) ? $pf['complemento'] : null; ?></p>
				<p align='justify'><strong>Telefone:</strong> <?php echo isset($pf['telefone']) ? $pf['telefone'] : null; ?></p>
				<p align='justify'><strong>Celular:</strong> <?php echo isset($pf['celular']) ? $pf['celular'] : null; ?></p>
				<p align='justify'><strong>Email:</strong> <?php echo isset($pf['email']) ? $pf['email'] : null; ?></p>

				<p align="justify"><strong>Cooperado:</strong>
				<?php
					if ($pf['cooperado'] == 0)
					{
						echo "Não";
					}
					else
					{
						echo "Sim";
					}
				?>
				</p>
                <?php
                $dados = retornaDadosAdicionais($pf['idPf'], 1);
                if ($dados) {
                    ?>
                    <div class="text-center"><h5>Informações Adicionais</h5></div>
                    <p align="justify"><strong>Gênero:</strong> <?= $dados['genero'] ?></p>
                    <p align="justify"><strong>Cor / Raça:</strong> <?= $dados['etnia'] ?></p>
                    <p align="justify"><strong>Participou de outras leis de incentivo à cultura?:</strong> <?= $dados['lei_incentivo'] == 1 ? "Sim" : "Não" ?></p>
                    <?php if($dados['lei_incentivo'] == 1) { ?>
                        <p align="justify"><strong>Qual:</strong> <?= $dados['nome_lei'] ?></p>
                    <?php } ?>
                <?php } else { ?>
                    <div class="alert alert-danger"><strong>Informações Adicionais ainda não cadastradas</strong></div>
                <?php } ?>
			</div>
		<?php
		}
		else // Se Pessoa Juridica
		{

		?>
			<div class='well'>
				<p align='justify'><strong>Razão Social:</strong> <?php echo isset($pj['razaoSocial']) ? $pj['razaoSocial'] : null; ?></p>
				<p align='justify'><strong>CNPJ:</strong> <?php echo isset($pj['cnpj']) ? $pj['cnpj'] : null; ?></p>
				<p align='justify'><strong>Endereço:</strong> <?php echo isset($pj['logradouro']) ? $pj['logradouro'] : null; ?></p>
				<p align='justify'><strong>Bairro:</strong> <?php echo isset($pj['bairro']) ? $pj['bairro'] : null; ?></p>
				<p align='justify'><strong>Cidade:</strong> <?php echo isset($pj['cidade']) ? $pj['cidade'] : null; ?></p>
				<p align='justify'><strong>Estado:</strong> <?php echo isset($pj['estado']) ? $pj['estado'] : null; ?></p>
				<p align='justify'><strong>CEP:</strong> <?php echo isset($pj['cep']) ? $pj['cep'] : null; ?></p>
				<p align='justify'><strong>Número:</strong> <?php echo isset($pj['numero']) ? $pj['numero'] : null; ?></p>
				<p align='justify'><strong>Complemento:</strong> <?php echo isset($pj['complemento']) ? $pj['complemento'] : null; ?></p>
				<p align='justify'><strong>Telefone:</strong> <?php echo isset($pj['telefone']) ? $pj['telefone'] : null; ?></p>
				<p align='justify'><strong>Celular:</strong> <?php echo isset($pj['celular']) ? $pj['celular'] : null; ?></p>
				<p align='justify'><strong>Email:</strong> <?php echo isset($pj['email']) ? $pj['email'] : null; ?></p>
				
				<p align="justify"><strong>Cooperativa:</strong>
				<?php
					if ($pj['cooperativa'] == 0)
					{
						echo "Não";
					}
					else
					{
						echo "Sim";
					}
				?>
				</p>

			</div>
		<?php
		}
 		?>
	</div>
</section>
