<?php
$con = bancoMysqli();
$idIncentivador = $_SESSION['idUser'];
$tipoPessoa = $_POST['tipoPessoa'];

if ($tipoPessoa == 4)
{
    $pf = recuperaDados("incentivador_pessoa_fisica", "idPf", $idIncentivador);
    $etapaArray = recuperaDados("etapas_incentivo", "idIncentivador", $idIncentivador);

    $liberado = $pf['liberado'];
    $etapa = $etapaArray['etapa'];
}
elseif ($tipoPessoa == 5)
{
    $pj = recuperaDados("incentivador_pessoa_juridica", "idPj", $idIncentivador);
    $etapaArray = recuperaDados("etapas_incentivo", "idIncentivador", $idIncentivador);

    $liberado = $pj['liberado'];
    $etapa = $etapaArray['etapa'];
}


if(isset($_POST['incentivar_projeto']) || isset($_POST['editar'])) {
    $idProjeto = $_POST['idProjeto'];
    $valor = $_POST['valor_aportado'];

    if (isset($_POST['incentivar_projeto'])) {

        $sql_incentivar = "INSERT INTO incentivador_projeto (idIncentivador, 
                                                          tipoPessoa, 
                                                          idProjeto, 
                                                          valor_aportado) 
                                                    VALUES 
                                                          ('$idIncentivador',
                                                          '$tipoPessoa',
                                                          '$idProjeto',
                                                          '$valor')";

        if (mysqli_query($con, $sql_incentivar)) {

            $sqlEtapa = "UPDATE etapas_incentivo SET 
                                                idProjeto = '$idProjeto', 
                                                etapa = 6 
                                            WHERE 
                                                tipoPessoa = '$tipoPessoa' 
                                            AND idIncentivador = '$idIncentivador'";

            mysqli_query($con, $sqlEtapa);

        }
    }

    if (isset($_POST['editar'])) {
        $sql_incentivar = "UPDATE incentivador_projeto SET valor_aportado = '$valor' WHERE idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa'";

        if(mysqli_query($con, $sql_incentivar)) {
            $mensagem = "<font color='#01DF3A'><strong>Valor de aportamento alterado com sucesso!</strong></font>";
        }

    }

}


?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'menu_interno_pf.php' ?>
        <ul class="nav nav-tabs">
            <li class="nav active"><a href="#admIncentivador" data-toggle="tab">Administrativo</a></li>
            <li class="nav"><a href="#resumo" data-toggle="tab">Resumo do projeto</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade" id="resumo">
                <?php
                echo "<br><div class='alert alert-warning'>
                                <strong>Aviso!</strong> Seus dados já foram aceitos, portanto, não podem ser alterados.</div>";
                include 'resumo_dados_incentivador_pf.php';
                ?>
            </div>
            <div class="tab-pane fade in active" id="admIncentivador">
                <br>
                <?php
                if (isset($mensagem)) {
                    echo "<h5>" . $mensagem . "</h5>";
                }
                ?>

                <div class="well">
                    <form method="POST" action="?perfil=includes/incentivador_etapa4_buscarProjeto" enctype="multipart/form-data">
                        <div class="form-group">
                            <h4><b>5 - Quanto você deseja aportar no projeto (valor total)?</b></h4>
                            <div class="row">
                                <div class="col-md-offset-4 col-md-6">
                                    <div class="input-group">
                                        <input type="text" name="projeto" class="form-control"
                                               value="<?=$valor?>">
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-default" name="editar" style="font-size: 20px"><span class="glyphicon glyphicon-edit"></span></button>
                                        </div>
                                    </div><!-- /input-group -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    function mostraDiv() {
        let form = document.querySelector('#testeTana');
        form.style.display = 'block';

        let botoes = document.querySelector('#botoes');
        botoes.style.display = 'none';

        let resultado = document.querySelector('#resultado');
        resultado.style.display = 'none';
    }
</script>