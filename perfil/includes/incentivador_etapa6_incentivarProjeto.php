<?php
$con = bancoMysqli();
$idIncentivador = $_SESSION['idUser'];
$tipoPessoa = $_POST['tipoPessoa'] ?? $_GET['tipoPessoa'];
$gerarContrato = 0;
$qtadeParcelas = 0;

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

            $etapa = 6;

            mysqli_query($con, $sqlEtapa);
        }
    }

    if (isset($_POST['editarValor'])) {
        $sql_incentivar = "UPDATE incentivador_projeto SET valor_aportado = '$valor' WHERE idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa' AND idProjeto = '$idProjeto'";

        if (mysqli_query($con, $sql_incentivar)) {
            $mensagem = "<font color='#01DF3A'><strong>Valor de aportamento alterado com sucesso!</strong></font>";
        }
    }
}

$sqlProjeto = "SELECT * FROM incentivador_projeto WHERE idIncentivador = $idIncentivador AND tipoPessoa = $tipoPessoa";

if ($query = mysqli_query($con, $sqlProjeto)) {
    $incentivador_projeto = mysqli_fetch_array($query);

}

$idProjeto = $incentivador_projeto['idProjeto'];
$valor = $incentivador_projeto['valor_aportado'];

$impostoRegistrado = $incentivador_projeto['imposto'] ?? '';
$editalRegistrado = $incentivador_projeto['edital'] ?? '';


//verificando parcelas
$sqlParcelas = "SELECT * FROM parcelas_incentivo WHERE idProjeto = '$idProjeto' AND tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador'";
$queryParcelas = mysqli_query($con, $sqlParcelas);
$numRows = mysqli_num_rows($queryParcelas);

if ($numRows > 0) {
    $qtadeParcelas = $incentivador_projeto['numero_parcelas'];
}


if (isset($_POST['gravarInfos'])) {
    $edital = $_POST['edital'];
    $imposto = $_POST['imposto'];

    $sqlInfos = "UPDATE incentivador_projeto SET edital = '$edital', 
                                                 imposto = '$imposto'
                                             WHERE idIncentivador = '$idIncentivador' 
                                               AND tipoPessoa = '$tipoPessoa' 
                                               AND idProjeto = '$idProjeto'";

    if (mysqli_query($con, $sqlInfos) && $qtadeParcelas != 0) {
        $gerarContrato = 1;
    }
}

if (((isset($qtadeParcelas) && $qtadeParcelas != 0) && (isset($impostoRegistrado) && $impostoRegistrado != '')  && (isset($editalRegistrado) && $editalRegistrado != '')) || $gerarContrato == 1) {
    $gerarContrato = 1;
    $mensagem = "<div class='alert alert-success'>
                    <small><strong>Verifique atentamente as informações inseridas, se estiverem corretas avance para a próxima etapa utilizando o botão de avançar ao final página.</strong></small>
                 </div>";
}


?>

<style>
    .none {
        display: none;
    }

</style>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include "menu_interno_pf.php"; ?>
        <ul class="nav nav-tabs">
            <li class="nav active"><a href="#admIncentivador" data-toggle="tab">Administrativo</a></li>
            <li class="nav"><a href="#resumo" data-toggle="tab">Resumo do projeto</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade" id="resumo">
                <?php
                echo "<br><div class='alert alert-warning'>
                                <strong>Aviso!</strong> Seus dados já foram aceitos, portanto, não podem ser alterados.</div>";
                include "resumo_dados_incentivador_pf.php";
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
                            <h6 class="col-md-12"><b>5 - Quanto você deseja aportar no projeto (valor total)?</b></h6>
                            <div class="row">
                                <div class="col-md-3 text-center" style="margin-left: 38%;">
                                    <label for="valor_aportado">
                                        <div class="input-group">
                                            <input type="text" name="valor_aportado"
                                                   onkeypress="return(moeda(this, '.', ',', event))"
                                                   class="form-control"
                                                   value="<?= dinheiroParaBr($valor) ?>">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-default" name="editarValor"
                                                        style="font-size: 20px">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </button>
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

                <div class="well ">
                    <form method="POST" class="form-group"
                          action="?perfil=includes/incentivador_etapa6_incentivarProjeto" enctype="multipart/form-data">
                        <h6 class="col-md-12"><b>6 - Preencha as informações abaixo para gerar o contrato de
                                incentivo</b></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-2" style="margin-left: 28%"><label>Projeto
                                            inscrito no Edital Nº.
                                            001/</label>
                                        <br><select name="edital" id="" class="form-control">
                                            <option value="">Selecione...</option>
                                            <?php
                                            $anosEdital = [2018, 2019, 2020, 2021, 2022];
                                            $edital = isset($edital) ? $edital : $editalRegistrado;
                                            foreach ($anosEdital as $ano) {
                                                if ($ano == $edital) {
                                                    echo "<option value='$ano' selected> $ano </option>";
                                                } else {
                                                    echo "<option value='$ano'> $ano </option>";
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>O imposto a ser utilizado para dedução do incentivo será
                                            <i id="info" class="glyphicon glyphicon-question-sign text-primary"
                                               data-toggle="tooltip easyTooltip"
                                               title="Se desejar usar o outro imposto, por favor, retorne a essa etapa e preencha outro Contrato de Incentivo utilizando o imposto desejado."></i>:
                                        </label>
                                        <br/>
                                        <label for="imposto">
                                            <?php
                                            if (isset($imposto) || $impostoRegistrado != '') {
                                                $imposto = isset($imposto) ? $imposto : $impostoRegistrado;
                                                if ($imposto == "ISS") {
                                                    $iss = 'checked';
                                                    $iptu = '';
                                                } else {
                                                    $iptu = 'checked';
                                                    $iss = '';
                                                }
                                            } else {
                                                $iss = '';
                                                $iptu = '';
                                            }
                                            ?>

                                            <input type="radio" name="imposto" value="ISS" <?= $iss ?>>&nbsp;ISS
                                            &nbsp;&nbsp;&nbsp;<input type="radio" name="imposto"
                                                                     value="IPTU"<?= $iptu ?> >&nbsp;IPTU


                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-lg-offset-4 col-md-6">
                                    <input type="hidden" name="tipoPessoa" value="<?= $tipoPessoa ?>">
                                    <input type="hidden" name="idProjeto" value="<?= $idProjeto ?>">
                                    <input type="submit" name="gravarInfos" value="Gravar"
                                           class="btn btn-primary pull-center">

                                </div>
                            </div>
                        </div>

                    </form>
                    <hr>
                    <h6>Cronograma</h6>
                    <?php
                    if ($qtadeParcelas != 0) {

                        ?>
                        <div class="col-md-offset-4 col-md-6 form-group">
                            <table class="table bg-white text-center table-hover table-responsive table-condensed table-bordered">
                                <thead class="bg-success">
                                <tr class="list_menu" style="font-weight: bold;">
                                    <td>Parcela</td>
                                    <td>Data</td>
                                    <td>Valor</td>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $somaParcelas = 0;
                                while ($parcela = mysqli_fetch_array($queryParcelas)) {
                                    $arrayValores[] = dinheiroParaBr($parcela['valor']);
                                    $arrayDatas[] = $parcela['data_pagamento'];
                                    $idsParcela [] = $parcela['id'];

                                    $somaParcelas += $parcela['valor'];

                                    ?>
                                    <tr>
                                        <td class="list_description"><?= $parcela['numero_parcela'] ?></td>
                                        <td class="list_description"><?= exibirDataBr($parcela['data_pagamento']) ?></td>
                                        <td class="list_description"><?= dinheiroParaBr($parcela['valor']) ?></td>
                                    </tr>
                                    <?php
                                }
                                $StringValores = implode("|", $arrayValores);
                                $StringDatas = implode("|", $arrayDatas);
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-2">
                                        <label for="numero_parcelas">Número de Parcelas</label>
                                        <select class="form-control" id="numero_parcelas"
                                                name="numero_parcelas"
                                                required>
                                            <option value="">Selecione...</option>
                                            <?php
                                            for ($i = 1; $i <= 10; $i++) {
                                                if (isset($qtadeParcelas) && $i == $qtadeParcelas) {
                                                    echo "<option value='" . $qtadeParcelas . "' selected>$qtadeParcelas</option>";
                                                } else {
                                                    echo "<option value='$i'>$i</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="dataPagamento none">
                                        <div class='col-md-3'>
                                            <label for='data'>Data</label>
                                            <input type='date' class='form-control' name='data' value="1" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="botaoEditar">
                                        <div class="col-md-6">
                                            <button type="button" style="margin-top: 5px;"
                                                    id="adicionarParcelas" onclick="abrirModal()"
                                                    class="btn btn-primary pull-left">
                                                Editar Parcelas
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    if ($gerarContrato != 0) {
                        ?>
                        <form action='?perfil=includes/incentivador_etapa7_gerarContrato' class='form-group'
                              method='post'>
                            <div class='col-md-12'>
                                <input type='hidden' name='tipoPessoa' value='<?=$tipoPessoa?>'>
                                <input type='hidden' name='idProjeto' value='<?=$idProjeto?>'>
                                <button type='submit' name='avancar_etapa7' class='btn btn-theme pull-right'>
                                    Avançar
                                </button>
                            </div>
                        </form>
                        <?php
                    }
                ?>
            </div>
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
                                <input type="hidden" name="tipoPessoa" id="tipoPessoa" value="<?= $tipoPessoa ?>">
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
                                        <input type='text' class='form-control' value="1" name='valor'
                                               onkeypress="return(moeda(this, '.', ',', event));" required>

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


<!-- Modal -->
<div class="modal fade" id="modalParcelas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 style="margin-top: 15px;" class="modal-title text-bold" id="exampleModalLongTitle">Cronograma</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <h5 class="text-center" id="somaParcelas"><b><p id="msg"></p><b/></h5>
                </div>
                <form action="#" id="formParcela">
                </form>
                <hr width="50%">
                <div class="row">
                    <h6 class="text-center" id="valor_restante_text"><b>Valor restante</b> <em><p
                                    id="valor_restante"><?= isset($somaParcelas) ? "0,00" : dinheiroParaBr($valor) ?></p>
                        </em>
                    </h6>
                </div>
                <div class="row">
                    <h6 class="text-center" id="somaParcelas"><b>Soma das
                            parcelas</b> <em><p
                                    id="soma"><?= isset($somaParcelas) ? dinheiroParaBr($somaParcelas) : NULL ?></p>
                        </em></h6>
                </div>
                <div class="row">
                    <h6 class="text-center"><b>Valor total do contrato</b>
                        <p id="valor_total"><em><?= dinheiroParaBr($valor) ?> </em></p></h6>
                </div>
            </div>
            <div class="modal-footer">
                <div class="botoes">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" name="salvar" id="salvarModal">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/x-handlebars-template" id="templateParcela">
    <div class='row'>
        <div class='col-md-offset-1 form-group col-md-2'>
            <label for='parcela'>Parcela </label>
            <input type='number' value="{{count}}" name="parcela" class='form-control' disabled>
        </div>
        <div class='form-group col-md-4'>
            <label for='modal_data'>Data</label>
            <input type='date' id='modal_data' value="{{date}}" required name='modal_data[{{count}}]'
                   class='form-control'>
        </div>
        <div class='form-group col-md-3'>
            <label for='valor'>Valor </label>
            <input type='text' id='valor' name='valor[{{count}}]' value="{{valor}}" required
                   placeholder="R$ 20.000,00"
                   onkeypress="return(moeda(this, '.', ',', event));" onkeyup="somar()" class='form-control'>
        </div>

    </div>
</script>


<script type="text/javascript">

    $(function () {
        $('#editarModal').on('click', editarModal);
    });


    $('#modalParcelas').on('hide.bs.modal', function () {
        location.reload(true);
    });

    $('#numero_parcelas').on('change', function () {

        var optionSelect = document.querySelector("#numero_parcelas").value;
        var editarParcelas = document.querySelector('#adicionarParcelas');
        var dataPagamento = document.querySelector(".dataPagamento");

        if (optionSelect == "1" || optionSelect == 0) {
            dataPagamento.required = true;
            editarParcelas.style.display = "none";
            dataPagamento.style.display = "block";
        } else {
            $("#data_kit_pagamento").attr("required", false);
            editarParcelas.style.display = "block";
            dataPagamento.style.display = "none";
        }
    });


    function somar() {

        let restanteText = document.querySelector("#valor_restante_text");

        var parcelas = $("#numero_parcelas").val();


        var valorTotal = "<?=$valor?>";
        var restante = valorTotal;

        var arrayValor = [];
        let soma = 0;

        for (var i = 1; i <= parcelas; i++) {
            arrayValor [i] = $("input[name='valor[" + i + "]']").val().replace('.', '').replace(',', '.');

            if (arrayValor[i] == "") {
                $("input[name='valor[" + i + "]']").val("0,00");
                continue;
            }
            soma += parseFloat(arrayValor[i]);
            restante -= arrayValor[i];
        }

        $('#modalParcelas').find('#soma').html(soma.toFixed(2).replace('.', ','));
        $('#modalParcelas').find('#valor_restante').html(restante.toFixed(2).replace('.', ','));

        if (Math.sign(restante) != 0) {
            console.log(Math.sign(restante));
            $("#salvarModal").attr("disabled", true);
            $("#editarModal").attr("disabled", true);
            restanteText.style.display = "block";
            $("#modalParcelas").find('#msg').html("<em class='text-danger'>O valor das parcelas somadas devem ser igual ao valor total do contrato! </em>");
        } else {
            $("#salvarModal").attr("disabled", false);
            $("#editarModal").attr("disabled", false);
            restanteText.style.display = "none";

            var nums = "<?= isset($numRows) ? $numRows : ''; ?>";

            if (nums != '') {
                $("#modalParcelas").find('#msg').html("<em class='text-success'> Agora os valores batem! Clique em editar para continuar.");
            } else {
                $("#modalParcelas").find('#msg').html("<em class='text-success'> Agora os valores batem! Clique em salvar para continuar.");
            }
        }
    }

    function abrirModal() {

        console.log("chamou função");

        var source = document.getElementById("templateParcela").innerHTML;
        var template = Handlebars.compile(source);
        var html = '';

        var parcelasSalvas = "<?= isset($numRows) ? $numRows : ''; ?>";

        var StringValores = "<?= isset($StringValores) ? $StringValores : ''; ?>";

        var StringDatas = "<?= isset($StringDatas) ? $StringDatas : ''; ?>";

        var parcelasSelected = $("#numero_parcelas").val();

        if (parcelasSelected == '') {
            swal("Escolha a quantidade de parcelas para edita-lás!", "", "warning");

        } else {


            if (parseInt(parcelasSelected) < parseInt(parcelasSalvas)) {
                swal("Haviam  " + parcelasSalvas + " parcelas nesse pedido!", "Número de parcelas selecionadas menor que quantidade de parcelas salvas, ao edita-lás as demais seram excluídas!", "warning");
            }

            if (StringValores != "" && StringDatas != "") {

                console.log(StringDatas + StringValores);

                $(".botoes").html("<button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>" + "<button type='button' class='btn btn-primary' name='editar' id='editarModal'>Editar</button>");

                var valores = StringValores.split("|");
                var datas = StringDatas.split("|");

                var somando = 0;

                console.log(valores);

                if (parseInt(parcelasSelected) < parseInt(parcelasSalvas)) {
                    for (var count = 0; count < parcelasSelected; count++) {
                        html += template({
                            count: count + 1, // para sincronizar com o array vindo do banco
                            valor: valores [count],
                            date: datas [count],
                        });

                        var valor = valores[count].replace('.', '').replace(',', '.');
                        somando += parseFloat(valor);
                    }
                    var valorFaltando = 0;
                    for (var x = parcelasSelected; x < parcelasSalvas; x++) {
                        var valor = valores[x].replace('.', '').replace(',', '.');
                        valorFaltando += parseFloat(valor);
                    }
                    $('#modalParcelas').find('#valor_restante').html(valorFaltando.toFixed(2).replace('.', ','));

                    if ($("#valor_restante") != "0,00") {
                        $("#editarModal").attr("disabled", true);
                        $('#modalParcelas').find('#soma').html(somando.toFixed(2).replace('.', ','));
                        $("#modalParcelas").find('#msg').html("<em class='text-danger'>O valor das parcelas somadas devem ser igual ao valor total do contrato! </em>");
                    }

                } else {
                    for (var count = 0; count < parcelasSalvas; count++) {
                        html += template({
                            count: count + 1, // para sincronizar com o array vindo do banco
                            valor: valores [count],
                            date: datas [count],
                        });
                    }
                }

                if (parseInt(parcelasSalvas) < parseInt(parcelasSelected)) {
                    var faltando = parcelasSelected - parcelasSalvas;
                    var count = parcelasSalvas;
                    for (var i = 1; i <= parseInt(faltando); i++) {
                        html += template({
                            count: parseInt(count) + 1,
                        });
                        count++;
                    }
                }

                $('#modalParcelas').find('#formParcela').html(html);

                $('#editarModal').on('click', editarModal);
                $('#modalParcelas').modal('show');


            } else {

                $(".botoes").html("<button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>" + "<button type='button' class='btn btn-primary' name='salvar' id='salvarModal'>Salvar</button>");

                for (var count = 1; count <= parcelasSelected; count++) {
                    html += template({
                        count: count
                    });
                }
                $('#salvarModal').on('click', salvarModal);
                $('#modalParcelas').find('#formParcela').html(html);
                $('#modalParcelas').modal('show');
            }

        }

    };


    var salvarModal = function () {

        let idProjeto = "<?php echo $idProjeto ?>";
        let tipoPessoa = "<?php echo $tipoPessoa ?>";

        var count = 0;

        $("#formParcela input").each(function () {
            if ($(this).val() == "" || $(this).val() == "0,00") {
                count++;
            }
        });

        if (count != 0) {
            swal("Preencha todas as informações para editar as parcelas!", "", "warning");
        } else {

            var parcelas = $("#numero_parcelas").val();
            var arrayData = [];
            var arrayValor = [];

            for (var i = 1; i <= parcelas; i++) {
                arrayData [i] = $("input[name='modal_data[" + i + "]']").val();
                arrayValor [i] = $("input[name='valor[" + i + "]']").val();
            }

            var newButtons = "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>" + "<button type='button' class='btn btn-primary' name='editar' id='editarModal'>Editar</button>";

            $('#modalParcelas').slideUp();

            $.post('?perfil=includes/parcelas_cadastro', {
                parcelas: parcelas,
                arrayValor: arrayValor,
                arrayData: arrayData,
                idProjeto: idProjeto,
                tipoPessoa: tipoPessoa
            })
                .done(function () {
                    var source = document.getElementById("templateParcela").innerHTML;
                    var template = Handlebars.compile(source);
                    var html = '';

                    for (var count = 0; count < parcelas; count++) {
                        html += template({
                            count: count + 1, // para sincronizar com o array vindo do banco
                            valor: arrayValor[count],
                            date: arrayData[count],
                        });
                    }

                    $(".botoes").html(newButtons);
                    $('#editarModal').on('click', editarModal);

                    swal("" + parcelas + " parcelas gravadas com sucesso!", "", "success")
                        .then(() => {
                            $('#modalParcelas').slideDown('slow');
                            //window.location.href = "?perfil=evento&p=parcelas_cadastro";
                        });
                })
                .fail(function () {
                    swal("danger", "Erro ao gravar");
                });
        }
    };

    var editarModal = function () {

        let idProjeto = "<?php echo $idProjeto ?>";
        let tipoPessoa = "<?php echo $tipoPessoa ?>";

        var count = 0;
        $("#formParcela input").each(function () {
            if ($(this).val() == "" || $(this).val() == "0,00") {
                count++;
            }
        });

        if (count != 0) {
            swal("Preencha todas as parcelas para edita-lás!", "", "warning");

        } else {

            var parcelas = $("#numero_parcelas").val();

            var datas = new Array(1);
            var valores = new Array(1);

            for (var i = 1; i <= parcelas; i++) {
                $("input[name='modal_data[" + i + "]']").each(function () {
                    datas.push($(this).val());
                });

                $("input[name='valor[" + i + "]']").each(function () {
                    valores.push($(this).val());
                });
            }

            $('#modalParcelas').slideUp();

            $.ajax({
                url: "?perfil=includes/parcelas_edita",
                method: "POST",
                data: {
                    parcelas: parcelas,
                    valores: valores,
                    datas: datas,
                    idProjeto: idProjeto,
                    tipoPessoa: tipoPessoa
                },
            })
                .done(function () {
                    var source = document.getElementById("templateParcela").innerHTML;
                    var template = Handlebars.compile(source);
                    var html = '';

                    for (var count = 0; count < parcelas; count++) {
                        html += template({
                            count: count + 1, // para sincronizar com o array vindo do banco
                            valor: valores[count],
                            date: datas[count],
                        });
                    }

                    swal("" + parcelas + " parcelas editadas com sucesso!", "", "success")
                        .then(() => {
                            //location.reload(true);
                            $('#modalParcelas').slideDown("slow");
                        });
                })
                .fail(function () {
                    swal("danger", "Erro ao gravar");
                });
        }
    };

</script>


<!--
<script>

    $('#addParcelas').on('click', function () {
        console.log("clicou");
        let num = $('.inputs #idParcela:last').val();
        let prox = parseInt(num) + 1;

        //console.log($('.inputs #idParcela:last').val());

        $('.inputsNextDiv').append($('.inputs:first').clone(true).append("<div class='col-md-1'>\n" +
            "                                            <br>\n" +
            "                                            <button id='removeParcela' style='margin-top: 5px; margin-left: -15px; height: 33px;'\n" +
            "                                                    class='remover btn btn-danger pull-left' type='button'>\n" +
            "                                                <i class='glyphicon glyphicon-trash'\n" +
            "                                                   style='margin-bottom: 2px; margin-left: 2px;'></i></button>\n" +
            "                                        </div>"));


        $('.inputs #idParcela:last').val(prox);

    });

    $('.inputsNextDiv').on('click', 'button.remover', function () {

        let numAtual = $(this).parent().parents('#idParcela').val();

        console.log($(this).parents('.inputs').parents($("#idParcela")));

        //console.log($(this).parents('.inputs'));
        $(this).parents('.inputs').remove();

    })

</script>-->