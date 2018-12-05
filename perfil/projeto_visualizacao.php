<?php

$con = bancoMysqli();

if (isset($_POST['carregar'])) {
    $_SESSION['idProjeto'] = $_POST['carregar'];
}
$idProjeto = $_SESSION['idProjeto'];

$projeto = recuperaDados("projeto", "idProjeto", $idProjeto);
$status = recuperaDados("etapa_status", "idStatus", $projeto['idStatus']);
$idEtapa = $projeto['idEtapaProjeto'];

//para o projeto
$area = recuperaDados("area_atuacao", "idArea", $projeto['idAreaAtuacao']);
$renuncia = recuperaDados("renuncia_fiscal", "idRenuncia", $projeto['idRenunciaFiscal']);
$cronograma = recuperaDados("cronograma", "idCronograma", $projeto['idCronograma']);
$video = recuperaDados("projeto", "idProjeto", $idProjeto);
$v = array($video['video1'], $video['video2'], $video['video3']);

$dateNow = date('Y-m-d');
$dataPublicacaoDoc = $projeto['dataPublicacaoDoc'];
$dataRecurso = date('Y-m-d', strtotime("+5 weekdays", strtotime($dataPublicacaoDoc))); // Calcula a diferença em segundos entre as datas do recurso e publicação

function DiasUteis() {

    $idProjeto = $_SESSION['idProjeto'];

    $projeto = recuperaDados("projeto", "idProjeto", $idProjeto);

    $suaConsulta = $projeto['dataPublicacaoDoc'];

    $dtSuaData = DateTime::createFromFormat("Y-m-d", $suaConsulta); //isso vai fazer um obj datetime da sua data no banco

    $contadorUteis = 0; //essa variavel vai contar os dias uteis

   while( $contadorUteis < 5 ){

      $dtSuaData->setTimestamp(strtotime('+1 weekday', $dtSuaData->getTimestamp()));

      $feriados = [];

      $ano_ = date("Y");
      foreach(dias_feriados($ano_) as $a)
      {
          array_push($feriados, date("d/m/Y", $a));
      }

       if (in_array(date_format($dtSuaData, "d/m/Y"), $feriados)) {
           continue;
       }

       $contadorUteis++;  //aqui vc incrementa como dia util caso não seja feriado nem fds..
    }

    return $dtSuaData->format('d/m/Y');//retorna sua data modo americano

}

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
                        <li class="nav active"><a href="#info" data-toggle="tab" onclick="remove_label_projeto()">Informações
                                da Inscrição</a></li>
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
                                        <li class="list-group-item"><strong>Protocolo (nº
                                                ISP):</strong> <?= $projeto['protocolo'] ?></li>
                                        <li class="list-group-item"><strong>Status do
                                                projeto:</strong> <?= $status['status'] ?></li>
                                        <li class='list-group-item'>
                                            <strong>Valor Aprovado:</strong>
                                            <?php
                                            if ($projeto['idStatus'] == 3) { //caso aprovado
                                                echo "R$ " . dinheiroParaBr($projeto['valorAprovado']);
                                            }
                                            echo "<hr>" . diasUteis();

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
                                <div class="col-md-offset-2 col-md-8">
                                    <ul class='list-group'>
                                        <li class='list-group-item list-group-item-success'><strong>Arquivos do
                                                proponente</strong></li>
                                        <li class='list-group-item'><?php listaAnexosProjetoSMC($idProjeto, 3, ""); ?></li>
                                    </ul>
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
                            if ($projeto['idStatus'] == 3) {
                                ?>
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-6">
                                        <form class="form-horizontal" role="form"
                                              action="?perfil=certificados&idProjeto=<?= $idProjeto ?>" method="post">
                                            <button type="submit" class="btn btn-success btn-block"
                                                    style="border-radius: 7px;">Anexar Certificados
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <!-- Botão para solicitar alteração do projeto -->
                            <?php

                            if ($projeto['idStatus'] == 3 && DiasUteis() < $dateNow) {
                                ?>
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-6">
                                        <form class="form-horizontal" role="form"
                                              action="?perfil=alteracao_projeto&idProjeto=<?= $idProjeto ?>"
                                              method="post">
                                            <button type="submit" class="btn btn-success btn-block"
                                                    style="border-radius: 7px;">solicitar alteração do projeto
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <!-- Botão para agendar a entrega -->

                            <?php

                            if ($projeto['idStatus'] == 3 && (DiasUteis() >= -7 && DiasUteis() <= 7)) {
                                ?>
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-6">
                                        <form class="form-horizontal" role="form"
                                              action="#"
                                              method="post">
                                            <button type="submit" class="btn btn-success btn-block"
                                                    style="border-radius: 7px;">agendar entrega pessoalmente
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                            <!-- Botão para anexar complemento de informações -->
                            <?php
                            if ($projeto['idStatus'] == 5) {
                                ?>
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-6">
                                        <form class="form-horizontal" role="form"
                                              action="?perfil=complemento_informacoes&idProjeto=<?= $idProjeto ?>"
                                              method="post">
                                            <button type="submit" class="btn btn-success btn-block"
                                                    style="border-radius: 7px;">anexar complementos
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <?php

                            }
                            ?>
                            <div class="form-group">
                                <div class="col-md-offset-4 col-md-6">
                                    <button class="btn btn-danger btn-block" type='button' data-toggle='modal' data-target='#cancelarProjeto' data-title="Cancelar projeto" data-message="Você está cancelando um projeto">Cancelar projeto</button>
                                </div>
                            </div>
                            <!-- Botão para anexar recurso -->
                            <?php
                            if ($idEtapa != 26 && $idEtapa != 27) {

                                if(DiasUteis() < $dateNow) {
                                    ?>
                                    <div class="form-group">
                                        <div class="col-md-offset-4 col-md-6">
                                            <h5 class="alert alert-danger">Data para enviar recurso expirada</h5>
                                        </div>
                                    </div>
                                    <?php
                                }

                                if (($projeto['dataPublicacaoDoc'] != "0000-00-00" && (diasUteis() > $dateNow)) && ($projeto['idStatus'] == 4 || $projeto['idStatus'] == 3)) {
                                    ?>
                                    <div class="form-group">
                                        <div class="col-md-offset-4 col-md-6">
                                            <form class="form-horizontal" role="form"
                                                  action="?perfil=envio_recursos&idProjeto=<?= $idProjeto ?>"
                                                  method="post">
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
                    if ($projeto['tipoPessoa'] == 1) {
                        echo "<form class='form-horizontal' role='form' action='?perfil=projeto_pf' method='post'>";
                    } else {
                        echo "<form class='form-horizontal' role='form' action='?perfil=projeto_pj' method='post'>";
                    }
                    ?>
                    <input type="submit" value="Voltar" class="btn btn-theme btn-md btn-block">
                    </form>
                </div>
            </div>
        </div>
</section>
<div class="modal fade" id="cancelarProjeto" role="dialog" aria-labelledby="confirmApagarLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Cancelar projeto</h4>
            </div>
            <div class="modal-body">
                <p>Deseja cancelar esse projeto mesmo?</p>
            </div>
            <form class="form-horizontal" role="form"
                  action="?perfil=projeto_pf" method="post">
                <input type="hidden" name="projeto" value="<?= $idProjeto ?>">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
                    <button type="submit" class="btn btn-danger" name="cancelar" id="confirm">Cancelar</button>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    var projeto = document.getElementById('projeto_label');

    function label_projeto() {
        if (projeto.classList.contains("hidden")) {
            projeto.classList.remove("hidden");
        }
    }

    function remove_label_projeto() {
        if (!projeto.classList.contains("hidden")) {
            projeto.classList.add("hidden");
        }
    }
</script>