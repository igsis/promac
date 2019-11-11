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



