<?php
$con = bancoMysqli();

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$razaoSocial = $_POST['razaoSocial'];
$cnpj = $_POST['cnpj'];

// Inicio Pessoa Física
if($nome != '' || $cpf != '')
{
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

	$sql = "SELECT * FROM pessoa_fisica WHERE idPf > 1 $filtro_nome $filtro_cpf";
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0)
	{
		$i = 0;
		while($lista = mysqli_fetch_array($query))
		{
			$x[$i]['id'] = $lista['idPf'];
			$x[$i]['pessoa'] = $lista['nome'];
			$x[$i]['documento'] = $lista['cpf'];
			$x[$i]['email'] = $lista['email'];
			$x[$i]['telefone'] = $lista['telefone'];
			$x[$i]['tipoPessoa'] = 1;
			$i++;
		}
		$x['num'] = $i;
	}
	else
	{
		$x['num'] = 0;
	}
}
// Inicio Pessoa Jurídica
elseif($razaoSocial != '' || $cnpj != '')
{
	if($razaSocial != '')
	{
		$filtro_razaSocial = " AND razaoSocial LIKE '%$razaoSocial%'";
	}
	else
	{
		$filtro_razaSocial = "";
	}

	if($cnpj != '')
	{
		$filtro_cnpj = " AND cnpj = '$cnpj'";
	}
	else
	{
		$filtro_cnpj = "";
	}
	$sql = "SELECT * FROM pessoa_juridica WHERE idPj > 1 $filtro_razaoSocial $filtro_cnpj";
	$query = mysqli_query($con,$sql);
	$num = mysqli_num_rows($query);
	if($num > 0)
	{
		$i = 0;
		while($lista = mysqli_fetch_array($query))
		{
			$x[$i]['id'] = $lista['idPj'];
			$x[$i]['pessoa'] = $lista['razaoSocial'];
			$x[$i]['documento'] = $lista['cnpj'];
			$x[$i]['email'] = $lista['email'];
			$x[$i]['telefone'] = $lista['telefone'];
			$x[$i]['tipoPessoa'] = 2;
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
			<h4>Pesquisar Projetos</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
			<h5><a href="?perfil=smc_pesquisa_reseta_senha">Fazer outra busca</a></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="table-responsive list_info">
					<table class='table table-condensed'>
						<thead>
							<tr class='list_menu'>
								<td>Pessoa</td>
								<td>Documento</td>
								<td>Email</td>
								<td>Telefone</td>
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
								echo "<td class='list_description'>
										<form method='POST' action='?perfil=smc_texto_resete_senha'>
											<input type='hidden' name='id' value='".$x[$h]['id']."' />
											<input type='hidden' name='tipoPessoa' value='".$x[$h]['tipoPessoa']."' />
											<input type ='submit' class='btn btn-theme btn-block' value='Reiniciar Senha'>
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
		<div class="modal fade" id="confirmResetar" role="dialog" aria-labelledby="confirmResetarLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Reiniciar senha</h4>
					</div>
					<div class="modal-body">
						<p>Confirma o reinício da senha para <strong>capac2018</strong>?</p>
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