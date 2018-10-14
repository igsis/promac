<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];
$alterar = isset($_POST['alterar']) ? $_POST['alterar'] : null;

$protocolo = geraProtocolo($idProjeto);
if($alterar == 1 || $alterar == 0)
{
    /*
        Caso esteja alterando após indeferimento, muda o status para enviado
    */
    $sql = "UPDATE projeto SET idEtapaProjeto = 2, idStatus = 1, protocolo = '$protocolo' WHERE idProjeto='$idProjeto'";
    if(mysqli_query($con, $sql))
    {
        gravarLog($sql);
        $data = date('Y-m-d H:i:s');
        $sql_historico = "INSERT INTO `historico_etapa`(`idProjeto`, `idEtapaProjeto`, `data`) VALUES ('$idProjeto', 2, '$data')";
        if(mysqli_query($con,$sql_historico))
        {
            gravarLog($sql_historico);
			$mensagem = "Projeto enviado com sucesso! Aguarde que você será redirecionado para a página de informações do projeto";
			 echo "<script type=\"text/javascript\">
				  window.setTimeout(\"location.href='?perfil=projeto_visualizacao';\", 4000);
				</script>";
		}
		else
		{
			$mensagem = "Erro ao cadastrar. Tente novamente.";
		}
    }
}

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
$status = recuperaDados("etapa_projeto","idEtapaProjeto",$projeto['idEtapaProjeto']);

$ano = date('Y');
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
		<div class="form-group">
			<h4>Informações da Inscrição</h4>
            <h5><span style="color: #01DF3A; "><?php if(isset($mensagem)){echo $mensagem;}; ?></span></h5>
            <p>Acompanhe através do sistema o resultado da análise da comissão sobre o seu projeto, e em caso de aprovação compareça na Secretaria Municipal de Cultura para assinatura do termo de responsabilidade.</strong></strong></p>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8" align="left">
						<ul class='list-group'>
							<li class='list-group-item list-group-item-success'>
								<li class='list-group-item'><strong>Protocolo (nº ISP):</strong> <?php echo $projeto['protocolo'] ?></li>
						</ul>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/></div>
				</div>

			</div>
		</div>
	</div>
</section>