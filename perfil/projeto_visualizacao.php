<?php

$con = bancoMysqli();

if (isset($_POST['carregar'])) {
    $_SESSION['idProjeto'] = $_POST['carregar'];
}
$idProjeto = $_SESSION['idProjeto'];

$projeto = recuperaDados("projeto", "idProjeto", $idProjeto);
$area = recuperaDados("area_atuacao", "idArea", $projeto['idAreaAtuacao']);
$renuncia = recuperaDados("renuncia_fiscal", "idRenuncia", $projeto['idRenunciaFiscal']);
$cronograma = recuperaDados("cronograma", "idCronograma", $projeto['idCronograma']);
$video = recuperaDados("projeto", "idProjeto", $idProjeto);
$v = array($video['video1'], $video['video2'], $video['video3']);
$status = recuperaDados("status", "idStatus", $projeto['idStatus']);
$idStatus = $projeto['idStatus'];
$dateNow = date('Y-m-d');
$dataPublicacaoDoc = $projeto['dataPublicacaoDoc'];
$dataRecurso = date('Y-m-d', strtotime("+7 days", strtotime($dataPublicacaoDoc)));
// Calcula a diferença em segundos entre as datas do recurso e publicação
$diferenca = strtotime($dateNow) - strtotime($dataRecurso);
$dias = floor($diferenca / (60 * 60 * 24));//Calcula a diferença em dias

$status_aprovado = array(5, 21, 26, 16, 11);
$status_reprovado = array(6, 22, 27, 17);
$status_visivel = array(2, 12, 13, 23, 14);
$status_analise = array(3,7,10,19,20,24,25,34,15);
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php
        if ($_SESSION['tipoPessoa'] == 1) {
            $idPf = $_SESSION['idUser'];
            include '../perfil/includes/menu_interno_pf.php';
        } else {
            $idPj = $_SESSION['idUser'];
            include '../perfil/includes/menu_interno_pj.php';
        }
        ?>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div role="tabpanel">
                    <!-- LABELS -->
                    <ul class="nav nav-tabs">
                        <li class="nav active"><a href="#info" data-toggle="tab" onclick="remove_label_projeto()">Informações da Inscrição</a></li>
                        <li class="nav"><a href="#projeto" data-toggle="tab" onclick="label_projeto()">Projeto</a></li>
                    </ul>
                    <div class="tab-content">
                        <!--
                            LABEL INFORMAÇÕES
                         -->
                        <div role="tabpanel" class="tab-pane fade in active" id="info">
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8" align="left">
                                    <ul class='list-group'>
                                        <li class='list-group-item list-group-item-success'></li>
                                        <li class="list-group-item"><strong>Protocolo (nº ISP):</strong> <?= $projeto['protocolo'] ?></li>
                                        <li class="list-group-item"><strong>Etapa do projeto:</strong>
                                            <?php
                                            if (in_array($idStatus, $status_aprovado)) {
                                                echo "Aprovado";
                                            }
                                            if (in_array($idStatus, $status_reprovado)) {
                                                echo "Reprovado";
                                            }
                                            if (in_array($idStatus, $status_visivel)) {
                                                echo $status['status'];
                                            }
                                            if (in_array($idStatus, $status_analise)) {
                                                echo "Projeto em análise";
                                            }
                                            ?>
                                        </li>
                                        <li class='list-group-item'>
                                            <strong>Valor Aprovado:</strong>
                                            <?php
                                            if (in_array($idStatus, $status_aprovado)) {
                                                echo "R$ " . dinheiroParaBr($projeto['valorAprovado']);
                                            }
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <?php exibirParecerProponente($idProjeto) ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8" align="left">
                                    <ul class='list-group'>
                                        <li class='list-group-item list-group-item-success'>Notas</li>
                                        <?php
                                        $sql = "SELECT * FROM notas
                                                    WHERE idPessoa = '$idProjeto' AND interna = 0";
                                        $query = mysqli_query($con, $sql);
                                        $num = mysqli_num_rows($query);
                                        if ($num > 0) {
                                            while ($campo = mysqli_fetch_array($query)) {
                                                echo "<li class='list-group-item'><strong>" . exibirDataHoraBr($campo['data']) . "</strong><br/>" . $campo['nota'] . "</li>";
                                            }
                                        } else {
                                            echo "<li class='list-group-item'>Não há notas disponíveis.</li>";
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>

                            <!-- Botão para anexar certificados -->
                            <?php
                            if (in_array($idStatus, $status_aprovado)){
                            ?>
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-6">
                                        <form class="form-horizontal" role="form" action="?perfil=certificados&idProjeto=<?= $idProjeto ?>" method="post">
                                            <button type="submit" class="btn btn-success btn-block" style="border-radius: 7px;">Anexar Certificados</button>
                                        </form>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                            <!-- Botão para solicitar alteração do projeto -->
                            <?php
                            if(in_array($idStatus, $status_aprovado)){
                            ?>
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-6">
                                        <form class="form-horizontal" role="form" action="?perfil=alteracao_projeto&idProjeto=<?= $idProjeto ?>" method="post">
                                            <button type="submit" class="btn btn-success btn-block" style="border-radius: 7px;">solicitar alteração do projeto</button>
                                        </form>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                            <!-- Botão para anexar complemento de informações -->
                            <?php
                            if(($idStatus == 12) || ($idStatus == 13)) {
                            ?>
                                    <div class="form-group">
                                        <div class="col-md-offset-4 col-md-6">
                                            <form class="form-horizontal" role="form" action="?perfil=complemento_informacoes&idProjeto=<?= $idProjeto ?>"
                                                  method="post">
                                                <button type="submit" class="btn btn-success btn-block" style="border-radius: 7px;">anexar complementos</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                            <!-- Botão para anexar recurso -->
                            <?php
                            if($idStatus != 26 && $idStatus != 27){
                                if(in_array($idStatus, $status_reprovado)){
                            ?>
                                    <div class="form-group">
                                        <div class="col-md-offset-4 col-md-6">
                                            <form class="form-horizontal" role="form"
                                                  action="?perfil=envio_recursos&idProjeto=<?= $idProjeto ?>" method="post">
                                                <button type="submit" class="btn btn-success btn-block"
                                                        style="border-radius: 7px;">anexar recurso
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                        ?>
                    </div>

                <!-- LABEL PROJETO -->

                <?php include "includes/label_projeto.php"; ?>

                <!-- FIM LABEL PROJETO -->
                </div>
            </div>
        </div>
        <!-- Botão para Voltar -->
        <div class="form-group">
            <div class="col-md-offset-4 col-md-6">
                <?php
                if ($projeto['tipoPessoa'] == 1){
                    echo "<form class='form-horizontal' role='form' action='?perfil=projeto_pf' method='post'>";
                }
                else{
                    echo "<form class='form-horizontal' role='form' action='?perfil=projeto_pj' method='post'>";
                }
                ?>
                <input type="submit" value="Voltar" class="btn btn-theme btn-md btn-block">
                        </form>
            </div>
        </div>
    </div>
</section>

<script>
    var projeto = document.getElementById('projeto_label');

    function  label_projeto() {
        if(projeto.classList.contains("hidden")){
            projeto.classList.remove("hidden");
        }
    }

    function remove_label_projeto() {
        if(!projeto.classList.contains("hidden")){
            projeto.classList.add("hidden");
        }
    }
</script>