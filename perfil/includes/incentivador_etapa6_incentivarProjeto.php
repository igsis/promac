<?php
$con = bancoMysqli();
$idIncentivador = $_SESSION['idUser'];
$tipoPessoa = $_POST['tipoPessoa'] ?? $_GET['tipoPessoa'];


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


if ($tipoPessoa == 4) {
    $pf = recuperaDados("incentivador_pessoa_fisica", "idPf", $idIncentivador);
    $sqlEtapa = "SELECT * FROM etapas_incentivo WHERE idIncentivador = $idIncentivador AND tipoPessoa = $tipoPessoa";
    $queryEtapa = mysqli_query($con, $sqlEtapa);
    $etapaArray = mysqli_fetch_array($queryEtapa);

    $liberado = $pf['liberado'];
    $etapa = $etapaArray['etapa'];

} elseif ($tipoPessoa == 5) {
    $pj = recuperaDados("incentivador_pessoa_juridica", "idPj", $idIncentivador);
    $sqlEtapa = "SELECT * FROM etapas_incentivo WHERE idIncentivador = $idIncentivador AND tipoPessoa = $tipoPessoa";
    $queryEtapa = mysqli_query($con, $sqlEtapa);
    $etapaArray = mysqli_fetch_array($queryEtapa);

    $liberado = $pj['liberado'];
    $etapa = $etapaArray['etapa'];
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

<style>
    .none {
        display: none;
    }

</style>

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
                                                <button type="submit" class="btn btn-default" name="editar"
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
                        <h6 class="col-md-12"><b>6 - Preencha as informações abaixo para gerar o contrato de incentivo</b></h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-2" style="margin-left: 28%"><label>Projeto inscrito no Edital Nº.
                                            001/</label>
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
                                        <label for="imposto">
                                            <input type="radio" name="imposto" value="ISS">&nbsp;ISS
                                            &nbsp;&nbsp;&nbsp;<input type="radio" name="imposto" value="IPTU">&nbsp;IPTU
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h6>Cronograma</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class='inputs' style="display: none;">
                                            <div class="col-md-offset-3 col-md-1">
                                                <label for='parcela'>Parcela</label>
                                                <input type='number' class='form-control' id="idParcela" name='parcela' value='1'
                                                       disabled>
                                            </div>
                                            <div class='col-md-3'>
                                                <label for='data'>Data</label>
                                                <input type='date' class='form-control' name='data' value="1" required>
                                            </div>
                                            <div class='col-md-2'>
                                                <label for='valor'>Valor</label>
                                                <input type='text' class='form-control' value="1" name='valor'
                                                       onkeypress="return(moeda(this, '.', ',', event));" required>
                                            </div>
                                        </div>
                                 <div class="col-md-offset-4 col-md-2">
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
                                 <div class="col-md-6">
                                     <button type="button" style="margin-top: 5px;"
                                             id="adicionarParcelas" onclick="abrirModal()" class="btn btn-primary pull-left">
                                         Editar Parcelas
                                     </button>
                                 </div>
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
                <h3 style="margin-top: 15px;" class="modal-title text-bold" id="exampleModalLongTitle">Editar
                    Parcelas</h3>
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
        $('#numero_parcelas').on('change', ocultarBotao);

       // $('#adicionarParcelas').on('click', abrirModal);



        $('#editarModal').on('click', editarModal);
    });


    $('#modalParcelas').on('hide.bs.modal', function () {
        location.reload(true);
    });


/*    $('#  addParcelas').on('click', function () {

        console.log('chamou a functionnnnn');
    });*/



    $('#numero_parcelas').on('change', function () {

        var optionSelect = document.querySelector("#numero_parcelas").value;
        var editarParcelas = document.querySelector('#adicionarParcelas');
        var inputs = document.querySelector(".inputs");

        if (optionSelect == "1" || optionSelect == 0) {
            inputs.required = true;
            editarParcelas.style.display = "none";
            inputs.style.display = "block";
        } else {
            $("#data_kit_pagamento").attr("required", false);
            editarParcelas.style.display = "block";
            inputs.style.display = "none";
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

            var parcelasSelected = $("#numero_parcelas").val();

            if (parcelasSelected == '') {
                swal("Escolha a quantidade de parcelas para edita-lás!", "", "warning");
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


    };


    var salvarModal = function () {
        var idAtracao = "<?= isset($oficina) ? $oficina : '' ?>";

        var count = 0;
        $("#formParcela input").each(function () {
            if ($(this).val() == "" || $(this).val() == "0,00") {
                count++;
            }
        });

        if (count != 0) {
            swal("Preencha todas as informações para editar as parcelas!", "", "warning");
        } else {

            if (idAtracao == 4) {
                if ($("#numero_parcelas").val() == 4) {
                    // $("#numero_parcelas").val("3");
                    var parcelas = $("#numero_parcelas").val() - 1;

                } else if ($("#numero_parcelas").val() == 3) {
                    //$("#numero_parcelas").val("2");
                    var parcelas = $("#numero_parcelas").val() - 1;

                } else {
                    var parcelas = $("#numero_parcelas").val();
                }

                var arrayKit = [];
                var arrayValor = [];
                var arrayInicial = [];
                var arrayFinal = [];
                var horas = [];

                for (var i = 1; i <= parcelas; i++) {
                    arrayKit [i] = $("input[name='modal_data_kit_pagamento[" + i + "]']").val();
                    arrayValor [i] = $("input[name='valor[" + i + "]']").val();
                    arrayInicial [i] = $("input[name='inicial[" + i + "]']").val();
                    arrayFinal[i] = $("input[name='final[" + i + "]']").val();
                    horas[i] = $("input[name='horas[" + i + "]']").val();
                }

                $('#modalOficina').slideUp();

                $.post('?perfil=evento&p=parcelas_cadastro', {
                    parcelas: parcelas,
                    arrayValor: arrayValor,
                    arrayKit: arrayKit,
                    arrayInicial: arrayInicial,
                    arrayFinal: arrayFinal,
                    horas: horas
                })
                    .done(function () {
                        var sourceOficina = document.getElementById("templateOficina").innerHTML;
                        var templateOficina = Handlebars.compile(sourceOficina);
                        var html = '';

                        for (var count = 0; count < parcelas; count++) {
                            html += templateOficina({
                                count: count + 1, // para sincronizar com o array vindo do banco
                                valor: arrayValor [count],
                                kit: arrayKit [count],
                                inicial: arrayInicial [count],
                                final: arrayFinal [count],
                                horas: horas [count],
                            });
                        }

                        swal("" + parcelas + " parcelas gravadas com sucesso!", "", "success")
                            .then(() => {
                                // location.reload(true);
                                //$('#modalOficina').slideDown('slow');
                            });
                    })
                    .fail(function () {
                        swal("danger", "Erro ao gravar");
                    });

            } else {

                var parcelas = $("#numero_parcelas").val();
                var arrayKit = [];
                var arrayValor = [];

                for (var i = 1; i <= parcelas; i++) {
                    arrayKit [i] = $("input[name='modal_data_kit_pagamento[" + i + "]']").val();
                    arrayValor [i] = $("input[name='valor[" + i + "]']").val();
                }

                var newButtons = "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>" + "<button type='button' class='btn btn-primary' name='editar' id='editarModal'>Editar</button>";

                $('#modalParcelas').slideUp();

                $.post('?perfil=evento&p=parcelas_cadastro', {
                    parcelas: parcelas,
                    arrayValor: arrayValor,
                    arrayKit: arrayKit
                })
                    .done(function () {
                        var source = document.getElementById("templateParcela").innerHTML;
                        var template = Handlebars.compile(source);
                        var html = '';

                        for (var count = 0; count < parcelas; count++) {
                            html += template({
                                count: count + 1, // para sincronizar com o array vindo do banco
                                valor: arrayValor[count],
                                kit: arrayKit[count],
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
        }
    };

    var editarModal = function () {

        var count = 0;
        $("#formParcela input").each(function () {
            if ($(this).val() == "" || $(this).val() == "0,00") {
                count++;
            }
        });

        if (count != 0) {
            swal("Preencha todas as parcelas para edita-lás!", "", "warning");

        } else {
            var idAtracao = "<?= isset($oficina) ? $oficina : ''?>";

            if (idAtracao == 4) {
                if ($("#numero_parcelas").val() == 4) {
                    // $("#numero_parcelas").val("3");
                    var parcelas = $("#numero_parcelas").val() - 1;

                } else if ($("#numero_parcelas").val() == 3) {
                    //$("#numero_parcelas").val("2");
                    var parcelas = $("#numero_parcelas").val() - 1;

                } else {
                    var parcelas = $("#numero_parcelas").val();
                }
                var arrayKit = [];
                var arrayValor = [];
                var arrayInicial = [];
                var arrayFinal = [];
                var horas = [];

                for (var i = 1; i <= parcelas; i++) {
                    arrayKit [i] = $("input[name='modal_data_kit_pagamento[" + i + "]']").val();
                    arrayValor [i] = $("input[name='valor[" + i + "]']").val();
                    arrayInicial [i] = $("input[name='inicial[" + i + "]']").val();
                    arrayFinal[i] = $("input[name='final[" + i + "]']").val();
                    horas[i] = $("input[name='horas[" + i + "]']").val();
                }

                var sourceOficina = document.getElementById("templateOficina").innerHTML;
                var templateOficina = Handlebars.compile(sourceOficina);
                var html = '';

                var newButtons = "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Fechar</button>" + "<button type='button' class='btn btn-primary' name='editar' id='editarModalOficina'>Editar</button>";

                $('#modalOficina').slideUp();

                $.post('?perfil=evento&p=parcelas_edita', {
                    parcelas: parcelas,
                    valores: arrayValor,
                    datas: arrayKit,
                    arrayInicial: arrayInicial,
                    arrayFinal: arrayFinal,
                    horas: horas
                })
                    .done(function () {
                        for (var count = 0; count < parcelas; count++) {
                            html += templateOficina({
                                count: count + 1, // para sincronizar com o array vindo do banco
                                valor: arrayValor [count],
                                kit: arrayKit [count],
                                inicial: arrayInicial [count],
                                final: arrayFinal [count],
                                horas: horas [count],
                            });
                        }

                        $(".botoes").html(newButtons);
                        $('#editarModalOficina').on('click', editarModal);

                        swal("" + parcelas + " parcelas gravadas com sucesso!", "", "success")
                            .then(() => {
                                //location.reload(true);
                                $('#modalOficina').slideDown("slow");
                            });
                    })
                    .fail(function () {
                        swal("danger", "Erro ao gravar");
                    });

            } else {

                var parcelas = $("#numero_parcelas").val();

                var datas = new Array(1);
                var valores = new Array(1);

                for (var i = 1; i <= parcelas; i++) {
                    $("input[name='modal_data_kit_pagamento[" + i + "]']").each(function () {
                        datas.push($(this).val());
                    });

                    $("input[name='valor[" + i + "]']").each(function () {
                        valores.push($(this).val());
                    });
                }

                $('#modalParcelas').slideUp();

                $.ajax({
                    url: "?perfil=evento&p=parcelas_edita",
                    method: "POST",
                    data: {
                        parcelas: parcelas,
                        valores: valores,
                        datas: datas
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
                                kit: datas[count],
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