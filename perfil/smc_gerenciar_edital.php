<?php
$con = bancoMysqli();

if(isset($_POST['atualizar'])){
    $anoEdital = ($_POST['anoEdital']);
    $sql = "UPDATE liberacao_projeto SET edital = '$anoEdital'";

    if(mysqli_query($con,$sql)) {
        $mensagem = "<span style=\"color: #01DF3A; \"><strong>Gravado com Sucesso!</strong></span>";
        $mensagem .= "<div class='alert alert-success'>
                        Os projetos serão inscritos referente ao edital de <strong>$anoEdital</strong>. <strong>Lembre-se de liberar ou bloquear</strong> as incrições no menu lateral em 'Gerenciamento do sistema' > 'Liberar/Bloquear projetos'
                    </div>";

        gravarLog($sql);
    } else {
        $mensagem = "<span style=\"color: #FF0000; \"><strong>Erro ao gravar! Tente novamente.</strong></span>";
        gravarLog($sql);
    }
}

$editalAtivo = recuperaDados("liberacao_projeto","idStatus",1)['edital'];
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include 'includes/menu_smc.php'; ?>
        <p align="left"><strong><?php echo saudacao(); ?>, <?php echo $_SESSION['nome']; ?></strong></p>
        <div class="form-group">
            <h5>
                <?php if (isset($mensagem)) {echo $mensagem;} ?>
            </h5>
        </div>
        <div class="form-group">
            <div class="row">
				<div class='col-md-12'>
					<label><h6>No campo abaixo, grave o ano do Edital ativo para os Projetos</label>
				</div>
				<div class='col-md-offset-4 col-md-2 col-md-push-1'>
					<form method='post' action='?perfil=smc_gerenciar_edital' class='form-group' role='form'>
						<input type='number' name='anoEdital' class='form-control text-center'
                               max="9999" min="<?=date('Y')?>" required value="<?=$editalAtivo?>">

                        <br>
                        <input type='submit' name='atualizar' class='btn btn-theme btn-md btn-block' value='Gravar data'>
					</form>
				</div>
            </div>
        </div>
    </div>
</section>
