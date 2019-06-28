<?php
$con = bancoMysqli();
$idIncentivador = $_SESSION['idUser'];
$tipoPessoa = $_POST['tipoPessoa'] ?? $_GET['tipoPessoa'];

if (isset($_POST['idProjeto'])) {
    $idProjeto = $_POST['idProjeto'];

} else {
    $sqlProject = "SELECT idProjeto FROM etapas_incentivo WHERE tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador' AND etapa = '9'";
    $queryProject = mysqli_query($con, $sqlProject);
    $arr = mysqli_fetch_assoc($queryProject);
    $idProjeto = $arr['idProjeto'];
}

$sqlIP = "SELECT * FROM incentivador_projeto WHERE idProjeto = '$idProjeto' AND idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa'";
$queryIP = mysqli_query($con, $sqlIP);
$infos = mysqli_fetch_assoc($queryIP);


$sqlParcelas = "SELECT * FROM parcelas_incentivo WHERE idProjeto = '$idProjeto' AND idIncentivador = '$idIncentivador' AND tipoPessoa = '$tipoPessoa' ORDER BY 'numero_parcela' ASC LIMIT 1";
$queryParcelas = mysqli_query($con, $sqlParcelas);
$parcelas = mysqli_fetch_assoc($queryParcelas);

print_r($parcelas);


?>


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
            </div>
        </div>

        <!-- Confirmação de Exclusão -->
        <div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                        </button>
                        <h4 class="modal-title">Excluir Arquivo?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Confirma?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirm">Remover</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim Confirmação de Exclusão -->


    </div>
    </div>
    </div>
</section>

<script>
    let envioArq = "<?=$arqAnexado?>";

    function loadOtherPage() {
        let idProjeto = "<?=$idProjeto?>";
        let tipoPessoa = "<?=$tipoPessoa?>";
        let idIncentivador = "<?=$idIncentivador?>";

        console.log("idProjeto" + idProjeto);

        let link = "../pdf/pdf_incentivar_projeto.php?tipoPessoa=" + tipoPessoa + "&idPessoa=" + idIncentivador + "&idProjeto=" + idProjeto + "";

        $("<iframe>")                             // create a new iframe element
            .hide()                               // make it invisible
            .attr("src", link) // point the iframe to the page you want to print
            .appendTo("body");                    // add iframe to the DOM to cause it to load the page

        let printed = 1;

        if (printed == 1 || envioArq == 'block') {
            $('#etapa8').show();
            $('#etapa7').hide();
        }
    }


</script>