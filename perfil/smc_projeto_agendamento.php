<?php
$con = bancoMysqli();

$idProjeto = $_POST['idProjeto'];

if(isset($_POST['gravar'])){
    $agendamento_data = exibirDataMysql($_POST['agendamento_data']);
    $agendamento_hora = $_POST['agendamento_hora'];
    $sql = "INSERT INTO projeto_agendamento (idProjeto, data, hora) VALUES ('$idProjeto','$agendamento_data','$agendamento_hora')";
    if(mysqli_query($con,$sql))
    {
        $mensagem = "<span style=\"color: #01DF3A; \"><strong>Gravado com sucesso!</strong></span>";
        gravarLog($sql);
    }
    else
    {
        $mensagem = "<span style=\"color: #FF0000; \"><strong>Erro ao gravar! Tente novamente.</strong></span>";
    }
}

if(isset($_POST['editar'])){
    $agendamento_data = exibirDataMysql($_POST['agendamento_data']);
    $agendamento_hora = $_POST['agendamento_hora'];
    $sql = "UPDATE projeto_agendamento SET idProjeto = '$idProjeto', data = '$agendamento_data', hora = '$agendamento_hora'";
    if(mysqli_query($con,$sql))
    {
        $mensagem = "<span style=\"color: #01DF3A; \"><strong>Gravado com sucesso!</strong></span>";
        gravarLog($sql);
    }
    else
    {
        $mensagem = "<span style=\"color: #FF0000; \"><strong>Erro ao gravar! Tente novamente.</strong></span>";
    }
}

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
if($projeto['tipoPessoa'] == 2){
    $pj = recuperaDados("pessoa_juridica","idPj", $projeto['idPj']);
    $proponente = $pj['razaoSocial'];
}
else{
    $pf = recuperaDados("pessoa_fisica","idPf", $projeto['idPf']);
    $proponente = $pf['nome'];
}
$agendamento = recuperaDados("projeto_agendamento","idProjeto",$idProjeto);
?>
<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_smc.php'; ?>
        <div class="form-group">
            <h4>Cadastro do agendamento</h4>
            <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
        </div>
        <table class="table table-bordered">
            <tr>
                <td>
                    <strong>Protocolo (nº ISP):</strong>
                    <span data-mask = "0000.00.00/0000000"><?= $projeto['protocolo'] ?></span>
                </td>
                <td><strong>Tipo:</strong>
                    <?php
                    if ($projeto['tipoPessoa'] == 1) {
                        echo "Pessoa Física";
                    } else {
                        echo "Pessoa Jurídica";
                    } ?>
                </td>
                <td><strong>Proponente:</strong> <?= $proponente ?></td>
            </tr>
            <tr>
                <td colspan="3"><strong>Nome do Projeto:</strong>
                    <?php echo isset($projeto['nomeProjeto']) ? $projeto['nomeProjeto'] : null; ?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><strong>Resumo do projeto:</strong>
                    <?php echo isset($projeto['resumoProjeto']) ? $projeto['resumoProjeto'] : null; ?>
                </td>
            </tr>
        </table>
        <form method="POST" action="?perfil=smc_projeto_agendamento" class="form-group" role="form">
            <hr/>
            <div class="row">
                <div class="col-md-offset-2 col-md-6">
                    <label for="datepicker01">Informe a data</label><br>
                    <input type="text" name="agendamento_data" id="datepicker01"  value="<?= exibirDataBr($agendamento['data']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="hora">Informe a hora</label><br>
                    <input type="time" name="agendamento_hora" id="hora"  value="<?= $agendamento['hora'] ?>" required>
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <input type='hidden' name='idProjeto' value='<?=$idProjeto?>' />
                    <?php
                    if($agendamento == NULL) {
                    ?>
                        <input type="submit" name="gravar" class="btn btn-theme btn-lg btn-block" value="Gravar">
                    <?php
                    }
                    else {
                    ?>
                        <input type="submit" name="editar" class="btn btn-theme btn-lg btn-block" value="Editar">
                    <?php
                    }
                    ?>
                </div>
            </div>
        </form>
    </div>
</section>
