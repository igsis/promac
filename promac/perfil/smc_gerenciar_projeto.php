<?php
$con = bancoMysqli();
/*
$situa = $_GET['id'];

if($situa == 1)
{
	$sql = "UPDATE statusprojeto SET situacaoAtual = '$situa', descricaoSituacao = 'LIBERADO'";
	$send =  mysqli_query($con, $sql);
	if($send)
		gravarLog($sql);
		echo "<script>alert('Os cadastros de projeto foram liberados.')</script>";
		echo "<script>window.location.replace('?perfil=smc_index')</script>";
}
else
{
	$sql = "UPDATE statusprojeto SET situacaoAtual = '$situa', descricaoSituacao = 'BLOQUEADO'";
	$send =  mysqli_query($con, $sql);
	if($send)
		gravarLog($sql);
		echo "<script>alert('Os cadastros de projeto foram bloqueados.')</script>";
		echo "<script>window.location.replace('?perfil=smc_index')</script>";
}
*/
if(isset($_POST['bloquear'])){
	$data = exibirDataMysql($_POST['dataLiberacao']);
	$sql = "UPDATE liberacao_projeto SET situacaoAtual = 2, descricaoSituacao = 'BLOQUEADO', data = '$data'";
    if(mysqli_query($con,$sql))
    {
        $mensagem = "<span style=\"color: #01DF3A; \"><strong>As incrições para novos projetos serão bloqueadas no dia " . exibirDataBr($data)."</strong></span>";
        gravarLog($sql);
    }
    else
    {
        $mensagem = "<span style=\"color: #FF0000; \"><strong>Erro ao gravar! Tente novamente.</strong></span>";
        gravarLog($sql);
    }
}
if(isset($_POST['liberar'])){
    $data = exibirDataMysql($_POST['dataLiberacao']);
    $sql = "UPDATE liberacao_projeto SET situacaoAtual = 1, descricaoSituacao = 'LIBERADO', data = '$data'";
    if(mysqli_query($con,$sql))
    {
        $mensagem = "<span style=\"color: #01DF3A; \"><strong>As incrições para novos projetos seram liberadas no dia " . exibirDataBr($data).". Lembre-se de informar o Ano do Edital no menu lateral em 'Gerenciamento do sistema' > 'Escolher Ano do Edita Ativo'</strong></span>";
        gravarLog($sql);
    }
    else
    {
        $mensagem = "<span style=\"color: #FF0000; \"><strong>Erro ao gravar! Tente novamente.</strong></span>";
        gravarLog($sql);
    }
}

$liberacao = recuperaDados("liberacao_projeto","idStatus",1);

if($liberacao['situacaoAtual'] == 1){
	$proximaSituacao = "BLOQUEAR";
	$nomeBotao = "bloquear";
}
else{
    $proximaSituacao = "LIBERAR";
    $nomeBotao = "liberar";
}
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include 'includes/menu_smc.php'; ?>
        <p align="left"><strong><?php echo saudacao(); ?>, <?php echo $_SESSION['nome']; ?></strong></p>
        <div class="form-group">
            <h5 class="alert alert-info" role="alert">
                Situação do cadastro de projetos: <?= $liberacao['descricaoSituacao'] ?> a partir <?= exibirDataBr($liberacao['data']) ?>
            </h5>
            <h5>
                <?php if (isset($mensagem)) {echo $mensagem;} ?>
            </h5>
        </div>
        <div class="form-group">
            <div class="row">
				<div class='col-md-12'>
					<label><h6>Informe uma data para <b class='text-danger'><?= $proximaSituacao ?></b> cadastros de novos projetos</h6></label>
				</div>
				<div class='col-md-offset-4 col-md-2 col-md-push-1'>
					<form method='post' action='?perfil=smc_gerenciar_projeto' class='form-group' role='form'>
						<input type='text' name='dataLiberacao' id='datepicker08' class='form-control text-center' required>
						<br><input type='submit' name='<?= $nomeBotao ?>' class='btn btn-theme btn-md btn-block' value='Gravar data'>
					</form>
				</div>
            </div>
        </div>
    </div>
</section>
