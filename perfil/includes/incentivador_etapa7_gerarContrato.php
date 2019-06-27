<?php
$con = bancoMysqli();

$idIncentivador = $_SESSION['idUser'];
$tipoPessoa = $_POST['tipoPessoa'] ?? $_GET['tipoPessoa'];


if (isset($_POST['idProjeto'])) {
    $idProjeto = $_POST['idProjeto'];
} else {
    $sqlProject = "SELECT idProjeto FROM etapas_incentivo WHERE tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador' AND etapa = 7";
    $queryProject = mysqli_query($con, $sqlProject);
    $arr = mysqli_fetch_assoc($queryProject);
    $idProjeto = $arr['idProjeto'];
}

if (isset($_POST['avancar_etapa7'])) {
    $sqlEtapa = "UPDATE etapas_incentivo SET etapa = 7 WHERE idProjeto = '$idProjeto' AND tipoPessoa = '$tipoPessoa' AND idIncentivador = '$idIncentivador'";
    mysqli_query($con, $sqlEtapa);

}


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
                <h6><b>7 - Impressão do Contrato de Incentivo</b></h6>
                <div class="well">
                    <strong style="color: red">ATENÇÃO</strong>
                    <p>Após a impressão desta carta de incentivo, você deve colher as assinaturas do proponente e
                        do incentivador (ou de seus respectivos responsáveis legais, em caso de pessoas jurídicas),
                        digitalizar a carta assinada em pdf e subir o arquivo aqui neste sistema, na próxima etapa. Em
                        seguida, você deve
                        encaminhar a Carta de Intenção ORIGINAL para a Secretaria Municipal de Cultura – PROMAC,
                        pessoalmente, via portador ou Correios, no seguinte endereço: Rua Líbero Badaró, 346 – 3º andar
                        –
                        PROMAC. Recebimento das 9h às 17h.</p>

                    <hr width="50%">

                    <div class="row">
                        <form action="../pdf/pdf_incentivar_projeto.php" method="post" class="form-group">
                            <div class='col-md-12'>
                                <button type="button" onclick="loadOtherPage()"
                                   class="btn btn-theme">CLIQUE AQUI PARA GERAR PDF DA CARTA DE
                                    INCENTIVO PREENCHIDA PARA IMPRESSÃO <!-- href='< ?php echo "../pdf/pdf_incentivar_projeto.php?tipoPessoa=$tipoPessoa&idPessoa=$idIncentivador&idProjeto=$idProjeto"; ?>'
                                   target='_blank' -->></button><br/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function loadOtherPage() {
        let idProjeto = "<?=$idProjeto?>";
        let tipoPessoa = "<?=$tipoPessoa?>";
        let idIncentivador = "<?=$idIncentivador?>";

        let link = "../pdf/pdf_incentivar_projeto.php?tipoPessoa=" + tipoPessoa + "&idPessoa=" + idIncentivador + "&idProjeto=" + idProjeto +"";

        $("<iframe>")                             // create a new iframe element
            .hide()                               // make it invisible
            .attr("src", link) // point the iframe to the page you want to print
            .appendTo("body");                    // add iframe to the DOM to cause it to load the page

    }


</script>