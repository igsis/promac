<?php
$con = bancoMysqli();

// Inicio Pessoa Física - Incentivador ou Proponente
if(isset($_POST['pesquisaPf']))
{
	$nome = $_POST['nome'];
	$cpf = $_POST['cpf'];
	$tabela = $_POST['tipo'];
	
	if($tabela == "pessoa_fisica")
	{
		$tipoPessoa = 1;
	}
	else
	{
		$tipoPessoa = 4;
	}
	
	if($nome != '')
	{
		$filtro_nome = " AND nome LIKE '%$nome%'";
	}
	else
	{
		$filtro_nome = "";
	}

	if($cpf != '')
	{
		$filtro_cpf = " AND cpf = '$cpf'";
	}
	else
	{
		$filtro_cpf = "";
	}

	$sql = "SELECT * FROM $tabela WHERE idPf > 0 $filtro_nome $filtro_cpf";
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0)
	{
		$i = 0;
		while($lista = mysqli_fetch_array($query))
		{
			$frase = recuperaDados("frase_seguranca","id",$lista['idFraseSeguranca']);
			$x[$i]['id'] = $lista['idPf'];
			$x[$i]['pessoa'] = $lista['nome'];
			$x[$i]['documento'] = $lista['cpf'];
			$x[$i]['email'] = $lista['email'];
			$x[$i]['telefone'] = $lista['telefone'];
			$x[$i]['frase'] = $frase['frase_seguranca'];
			$x[$i]['resposta'] = $lista['respostaFrase'];
			$x[$i]['tipoPessoa'] = $tipoPessoa;
			$i++;
		}
		$x['num'] = $i;
	}
	else
	{
		$x['num'] = 0;
	}
}
// Inicio Pessoa Jurídica - Incentivador ou Proponente
if(isset($_POST['pesquisaPj']))
{
	$razaoSocial = $_POST['razaoSocial'];
	$cnpj = $_POST['cnpj'];
	$tabela = $_POST['tipo'];
	
	if($tabela == "pessoa_juridica")
	{
		$tipoPessoa = 2;
	}
	else
	{
		$tipoPessoa = 5;
	}

	if($razaoSocial != '')
	{
		$filtro_razaoSocial = " AND razaoSocial LIKE '%$razaoSocial%'";
	}
	else
	{
		$filtro_razaoSocial = "";
	}

	if($cnpj != '')
	{
		$filtro_cnpj = " AND cnpj = '$cnpj'";
	}
	else
	{
		$filtro_cnpj = "";
	}
	$sql = "SELECT * FROM $tabela WHERE idPj > 0 $filtro_razaoSocial $filtro_cnpj";
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0)
	{
		$i = 0;
		while($lista = mysqli_fetch_array($query))
		{
			$frase = recuperaDados("frase_seguranca","id",$lista['idFraseSeguranca']);
			$x[$i]['id'] = $lista['idPj'];
			$x[$i]['pessoa'] = $lista['razaoSocial'];
			$x[$i]['documento'] = $lista['cnpj'];
			$x[$i]['email'] = $lista['email'];
			$x[$i]['telefone'] = $lista['telefone'];
			$x[$i]['frase'] = $frase['frase_seguranca'];
			$x[$i]['resposta'] = $lista['respostaFrase'];
			$x[$i]['tipoPessoa'] = $tipoPessoa;
			$i++;
		}
		$x['num'] = $i;
	}
	else
	{
		$x['num'] = 0;
	}
}

$mensagem = "Foram encontrados ".$x['num']." resultados";
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Pesquisar Pessoas</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
			<h5><a href="?perfil=smc_pesquisa_reseta_senha">Fazer outra busca</a></h5>
		</div>
		<div class="row">
			<div>
				<div class="table-responsive list_info">
					<table class='table table-condensed'>
						<thead>
							<tr class='list_menu'>
								<td>Pessoa</td>
								<td>Documento</td>
								<td>Email</td>
								<td>Telefone</td>
								<td>Frase</td>
								<td>Resposta</td>
								<td width='10%'></td>
							</tr>
						</thead>
						<tbody>
							<?php
							for($h = 0; $h < $x['num']; $h++)
							{
								echo "<tr>";
								echo "<td class='list_description'>".$x[$h]['pessoa']."</td>";
								echo "<td class='list_description'>".$x[$h]['documento']."</td>";
								echo "<td class='list_description'>".$x[$h]['email']."</td>";
								echo "<td class='list_description'>".$x[$h]['telefone']."</td>";
								echo "<td class='list_description'>".$x[$h]['frase']."</td>";
								echo "<td class='list_description'>".$x[$h]['resposta']."</td>";
								echo "<td class='list_description'>
										<form method='POST' action='?perfil=smc_texto_resete_senha'>
											<input type='hidden' name='id' value='".$x[$h]['id']."' />
											<input type='hidden' name='tipoPessoa' value='".$x[$h]['tipoPessoa']."' />
											<button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Reiniciar Senha de ".$x[$h]['pessoa']."?'>Reiniciar Senha</button>
										</form>
									</td>";
								echo "</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- INICIO Modal de confirmação de resete de senha -->
		<div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Reiniciar senha</h4>
					</div>
					<div class="modal-body">
						<p>Confirma o reinício da senha para <strong>promac2018</strong>?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-success" id="confirm">Reiniciar</button>
					</div>
				</div>
			</div>
		</div>
		<!-- FIM Modal de confirmação de resete de senha -->
	</div>
</section>