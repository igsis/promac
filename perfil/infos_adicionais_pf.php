<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

if(isset($_POST['insere']))
{
    $midia1 = $_POST['midia_social_1'];
    $midia2 = $_POST['midia_social_2'];
    $video1 = $_POST['video1'];
    $video2 = $_POST['video2'];
    $video3 = $_POST['video3'];

    $sql_insere = "UPDATE projeto SET
		midia_social_1 = '$midia1',
        midia_social_2 = '$midia2',
        video1 = '$video1',
		video2 = '$video2',
		video3 = '$video3'
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

if(isset($_POST['videoApagar']))
{
    $indice = "video".$_POST['videoApagar'];
    $video[$indice] = "";

    $sql_insere = "UPDATE projeto SET
		$indice = '$video[$indice]'
		WHERE idProjeto = '$idProjeto'";
    if(mysqli_query($con,$sql_insere))
    {
        $mensagem = "<font color='#01DF3A'><strong>Apagado com sucesso!</strong></font>";
        gravarLog($sql_insere);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
    }
}

$video = recuperaDados("projeto","idProjeto",$idProjeto);
$v = array($video['video1'], $video['video2'], $video['video3']);
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
            <h4>Informações Adicionais</h4>
            <h6>Dados do Proponente</h6>
            <p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form method="POST" action="?perfil=projeto_13" class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-4">
                            <label>Estado Civil</label>
                            <select name="estadoCivil" class="form-control">
                                <option value="">Selecione...</option>
                                <option value="solteiro">Solteiro</option>
                                <option value="casado">Casado</option>
                                <option value="separado">Separado</option>
                                <option value="divorciado">Divorciado</option>
                                <option value="viuvo">Viúvo</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Nacionalidade</label>
                            <select name="estadoCivil" class="form-control">
                                <option value="">Selecione...</option>
                                <?php echo geraOpcao("nacionalidades", $nacionalidade ?? ''); ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Profissão</label>
                            <input class="form-control" type="url" name="profissao" placeholder="Exs.: Desenvolvedora, Dentista, Médico, Professora, etc...  " value="<?php echo $video['video1']; ?>" style="text-align: center;">
                        </div>
                    </div>

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
