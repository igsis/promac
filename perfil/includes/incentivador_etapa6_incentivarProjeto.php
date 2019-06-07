<?php
$con = bancoMysqli();
$idIncentivador = $_SESSION['idUser'];
$tipoPessoa = $_POST['tipoPessoa'] ?? $_GET['tipoPessoa'];

if ($tipoPessoa == 4) {
    $pf = recuperaDados("incentivador_pessoa_fisica", "idPf", $idIncentivador);
    $etapaArray = recuperaDados("etapas_incentivo", "idIncentivador", $idIncentivador);

    $liberado = $pf['liberado'];
    $etapa = $etapaArray['etapa'];
} elseif ($tipoPessoa == 5) {
    $pj = recuperaDados("incentivador_pessoa_juridica", "idPj", $idIncentivador);
    $etapaArray = recuperaDados("etapas_incentivo", "idIncentivador", $idIncentivador);

    $liberado = $pj['liberado'];
    $etapa = $etapaArray['etapa'];
}

if (isset($_POST['incentivar_projeto']) || isset($_POST['editar'])) {
    $idProjeto = $_POST['idProjeto'];
    $valor = dinheiroDeBr($_POST['valor_aportado']);

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
        $sql_incentivar = "UPDATE incentivador_projeto SET valor_aportado = '$valor' WHERE idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa' AND idProjeto = '$idProjeto'";

        if (mysqli_query($con, $sql_incentivar)) {
            $mensagem = "<font color='#01DF3A'><strong>Valor de aportamento alterado com sucesso!</strong></font>";
        }
    }
}


if ($etapa == 6) {
    $sqlProjeto = "SELECT * FROM incentivador_projeto WHERE idIncentivador = $idIncentivador AND tipoPessoa = $tipoPessoa";

    if ($query = mysqli_query($con, $sqlProjeto)) {
        $incentivador_projeto = mysqli_fetch_array($query);

    }

}

$idProjeto = $incentivador_projeto['idProjeto'];
$valor = $incentivador_projeto['valor_aportado'];


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
                    <form method="POST" action="?perfil=includes/incentivador_etapa6_incentivarProjeto"
                          enctype="multipart/form-data">
                        <div class="form-group">
                            <h6><b>5 - Quanto você deseja aportar no projeto (valor total)?</b></h6>
                            <div class="row">
                                <div class="col-md-offset-4 col-md-6 text-center">
                                    <label for="valor_aportado">
                                        <div class="input-group">
                                            <input type="text" name="valor_aportado"
                                                   onkeypress="return(moeda(this, '.', ',', event))"
                                                   class="form-control"
                                                   value="<?= dinheiroParaBr($valor) ?>">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-default" name="editar"
                                                        style="font-size: 20px"><span
                                                            class="glyphicon glyphicon-edit"></span></button>
                                            </div>
                                        </div>
                                    </label>

                                    <input type="hidden" name="tipoPessoa" value="<?= $tipoPessoa ?>">
                                    <input type="hidden" name="idProjeto" value="<?= $idProjeto ?>">
                                    <!-- /input-group -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!--<div class="well">
                    <form method="POST" class="form-group" action="?perfil=includes/incentivador_etapa6_incentivarProjeto" enctype="multipart/form-data">
                        <h6><b>6 - Preencha as informações abaixo para gerar o contrato de incentivo</b></h6>
                        <div class="row">
                            <div class="col-md-offset-4 col-md-6 text-center">
                                <label for="editais">Projeto inscrito no Edital Nº. 001/
                                    <select name="editais" id="" class="form-control">
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                        <option value="2022">2022</option>
                                    </select>
                                </label>
                                <hr>
                            </div> /input-group
                        </div>

                        <div class="row">
                            <div class="col-md-offset-4 col-md-6 text-center">
                                <label for="impostos">O imposto a ser utilizado para dedução do incentivo será:
                                </label>
                            </div>
                            <div class="col-lg-offset-5 col-md-2">
                                <select name="impostos" class="form-control">
                                    <option value="ISS">ISS</option>
                                    <option value="IPTU">IPTU</option>
                                </select>
                            </div>

                             /input-group
                        </div>
                        <input type="hidden" name="tipoPessoa" value="<? /*=$tipoPessoa*/ ?>">
                        <input type="hidden" name="idProjeto" value="<? /*=$idProjeto*/ ?>">

                    </form>
                </div>-->

                <div class="well">
                    <form method="POST" class="form-group"
                          action="?perfil=includes/incentivador_etapa6_incentivarProjeto" enctype="multipart/form-data">
                        <h6><b>6 - Preencha as informações abaixo para gerar o contrato de incentivo</b></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-6"><label>Projeto inscrito no Edital Nº.
                                            001/</label><br/>
                                        <br><select name="editais" id="" class="form-control">
                                            <option value="">Selecione...</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>O imposto a ser utilizado para dedução do incentivo será
                                            <i id="info" class="glyphicon glyphicon-question-sign text-primary"
                                               data-toggle="tooltip easyTooltip"
                                               title="Se desejar usar o outro imposto, por favor, retorne a essa etapa e preencha outro Contrato de Incentivo utilizando o imposto desejado."></i>:
                                        </label>
                                        <br/>
                                        <select name="impostos" class="form-control text-center">
                                            <option value="ISS">ISS</option>
                                            <option value="IPTU">IPTU</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h6>Cronograma</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-offset-3 col-md-4">
                                        <label for="numero_parcelas">Número de Parcelas</label>
                                        <select class="form-control" id="numero_parcelas" name="numero_parcelas"
                                                required>
                                            <option value="">Selecione...</option>
                                            <?php
                                            for ($i = 1; $i <= 10; $i++) {
                                                echo "<option value='$i'>$i</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <br>
                                    <div class="col-md-2">
                                        <button style="margin-top: 5px;" id="editarParcelas" class="btn btn-primary"
                                                type='button' data-toggle='modal' data-id="teste" data-target='#addParcelas'>Editar
                                            Parcelas
                                        </button>
                                        <!--<button type="button" style="margin-top: 5px;" id="editarParcelas" class="btn btn-primary">

                                        </button>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                <!-- Button trigger modal -->

            </div>

            <input type="hidden" name="tipoPessoa" value="<? /*=$tipoPessoa*/ ?>">
            <input type="hidden" name="idProjeto" value="<? /*=$idProjeto*/ ?>">
            </form>
        </div>
    </div>


    <!-- valor que deseja aportar no projeto -->
    <div class="modal fade" id="addParcelas" role="dialog" aria-labelledby="editarParcelasLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h4 class="modal-title">Cronograma</h4>
                </div>
                <form action="?perfil=includes/incentivador_etapa6_incentivarProjeto" method="post" class="form-group">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="idProjeto" id="idProjeto" value="">
                                <input type="hidden" name="tipoPessoa" id="tipoPessoa" value="<?=$tipoPessoa?>">
                                <div class="inputs">
                                    <div class='form-group col-md-offset-1 col-md-2'>
                                        <label for='parcela'>Parcela</label>
                                        <input type='number' class='form-control' name='parcela1' value='1' disabled>
                                    </div>
                                    <div class='form-group col-md-4'>
                                        <label for='data'>Data</label>
                                        <input type='date' class='form-control' name='data' value="1" required>

                                    </div>
                                    <div class='form-group col-md-4'>
                                        <label for='valor'>Valor</label>
                                        <input type='text' class='form-control' value="1" name='valor' onkeypress="return(moeda(this, '.', ',', event));" required>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success" name="incentivar_projeto">Prosseguir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Fim do modal -->

</section>


<script>

    console.log("Testesss");

    $('#addParcelas').on('shown', function () {

        let numero_parcelas = $("#numero_parcelas").val();

        let firstChild = ('#.inputs'):firstChild;

        console.log("testaaaando " + numero_parcelas);

        for (let i = 2; i <= numero_parcelas; i++) {

            console.log(i);

            $('#inputs').after("<label for='parcela'>Parcela</label><input type='number' class='form-control' name='parcela"+ i +"' value='" + i +"' >" + "<label for='data'>Data</label><input type='date' class='form-control' name='data'>" + "<label for='valor'>Valor</label><input type='text' class='form-control' name='valor'>");


        }
    });

</script>