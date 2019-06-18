<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];
$idPf = $_SESSION['idUser'];

if(isset($_POST['gravarInfos']))
{
    $captacao= $_POST['captacao'];
    $movimentacao = $_POST['movimento'];

    $sql_insere = "UPDATE projeto SET contaCaptacao = '$captacao',
                                            contaMovimentacao = '$movimentacao'
                                            WHERE idProjeto = '$idProjeto'";
    if(mysqli_query($con,$sql_insere))
    {
        $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Utilize o menu para avançar.</strong></font>";
        gravarLog($sql_insere);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
    }
}

$pf = recuperaDados("pessoa_fisica", "idPf", $idPf);



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
            <h4>Contas do Projeto</h4>
            <p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form method="POST" action="?perfil=infos_adicionais_pf" class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Conta de Captação</label>
                            <input class="form-control" type="text" name="captacao" placeholder="Ex.: Banco do Brasil – Ag 0453-3 CC 60777-7" value="<?= $captacao ?? ''; ?>" style="text-align: center;">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Conta Movimento</label>
                            <input class="form-control" type="text" name="movimento" placeholder="Ex.: Banco do Brasil – Ag 0453-3 CC 60777-7" value="<?= $movimentacao ?? '' ?>" style="text-align: center;">
                        </div>
                    </div>
                    <?php
                    if ($pf['profissao'] == '' || $pf['estado_civil'] == '') {

                        ?>
                        <hr width="50%">
                        <h6>Informações Adicionais</h6>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-4">
                                <label>Estado Civil</label>
                                <select name="estadoCivil" class="form-control">
                                    <option value="">Selecione...</option>
                                    <?php
                                    $estadosCivis = ['Solteiro', 'Casado', 'Separado', 'Divorciado', 'Viúvo'];
                                    $estadoCivil = isset($estadoCivil) ? $estadoCivil : '';

                                    foreach ($estadosCivis as $estado) {
                                        if ($estado == $estadoCivil) {
                                            echo "<option value='$estadoCivil' selected> $estadoCivil </option>";
                                        } else {
                                            echo "<option value='$estado'> $estado </option>";
                                        }
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Nacionalidade</label>
                                <select name="nacionalidade" class="form-control">
                                    <option value="">Selecione...</option>
                                    <?php echo geraOpcao("nacionalidades", $nacionalidade ?? ''); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Profissão</label>
                                <input class="form-control" type="text" name="profissao"
                                       placeholder="Exs.: Desenvolvedora, Dentista, Médico, Professora, etc...  "
                                       value="<?php $profissao ?? '' ?>" style="text-align: center;">
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="submit" name="gravarInfos" class="btn btn-theme btn-lg btn-block" value="Gravar">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
