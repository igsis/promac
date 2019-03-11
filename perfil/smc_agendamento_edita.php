<?php
$con = bancoMysqli();

if(isset($_POST['cadastrar']) || isset($_POST['edita'])) {

    $link = $_POST ['link_agendamento'];
}

if(isset($_POST['cadastrar'])) {

    $sql = "INSERT INTO agendamento (linkAgendamento,
                                      data)
                                      VALUES 
                                      ('$link',
                                      NOW())";

    if(mysqli_query($con, $sql)) {

        $idAgendamento = recuperaUltimo("agendamento");
        $mensagem = mensagem("success","Cadastrado com sucesso!");
        //gravarLog($sql);
    }else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
        //gravarLog($sql);
    }
}

if(isset($_POST['edita'])) {
    $idAgendamento = recuperaUltimo("agendamento");
    $sql = "UPDATE agendamento SET 
                               linkAgendamento = '$link',
                               data = now() 
                               WHERE id = '$idAgendamento'";

    if(mysqli_query($con, $sql)) {

        $idAgendamento = recuperaUltimo("agendamento");
        $mensagem = mensagem("success","Editado com sucesso!");
        //gravarLog($sql);
    }else{
        $mensagem = mensagem("danger","Erro ao gravar! Tente novamente.");
        //gravarLog($sql);
    }


}
$idAgendamento = recuperaUltimo("agendamento");
$agendamento = recuperaDados("agendamento", "id", $idAgendamento);


?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_smc.php'; ?>
        <div class="form-group">
            <h4>Cadastro do link de agendamento</h4>
            <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form method="POST" action="?perfil=smc_agendamento_edita" class="form-group" role="form">

                    <hr/>

                    <label for="link_agendamento">Informe o link</label><br>
                    <input type="url" name="link_agendamento" id="link_agendamento" size="75" value="<?= $agendamento['linkAgendamento'] ?>" required>

                    <hr/>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="submit" name="edita" class="btn btn-theme btn-lg btn-block" value="Editar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>