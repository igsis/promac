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
                                        <li class="list-group-item">
                                            <strong>Protocolo (nº ISP):</strong>
                                            <span data-mask = "0000.00.00/0000000"><?= $projeto['protocolo'] ?></span>
                                        </li>
                                        <li class="list-group-item"><strong>Status do projeto:</strong>  <?= $status['status'] ?></li>
                                        <li class='list-group-item'>
                                            <strong>Valor Aprovado:</strong>
                                            <?php
                                            if($projeto['idStatus'] == 3){ //caso aprovado
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
                                <div class="col-md-offset-2 col-md-8">
                                    <ul class='list-group'>
                                        <li class='list-group-item list-group-item-success'><strong>Arquivos do proponente</strong></li>
                                        <li class='list-group-item'><?php listaAnexosProjetoSMC($idProjeto, 3, ""); ?></li>
                                    </ul>
                                </div>
                            </div>


                            <!-- Botão para anexar certidões -->
                            <?php
                            if ($projeto['idStatus'] == 3){
                            ?>
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-6">
                                        <button class='btn btn-default' type='button' data-toggle='modal' data-target='#certidaoFiscal' style="border-radius: 30px;"><i class="fa fa-question-circle"></i></button>
                                        <form class="form-horizontal" role="form" action="?perfil=certificados&idProjeto=<?= $idProjeto ?>" method="post">
                                            <button type="submit" class="btn btn-success btn-block" style="border-radius: 7px;">Anexar Certidões Fiscais</button>
                                        </form>
                                        <button class='btn btn-default' type='button' data-toggle='modal' data-target='#termoResponsabilidade' style="border-radius: 30px;"><i class="fa fa-question-circle"></i></button>
                                        <form class="form-horizontal" role="form" action="../pdf/TERMO_DE_RESPONSABILIDADE_FINAL.docx" method="post">
                                            <button type="submit" class="btn btn-success btn-block" style="border-radius: 7px;">Imprimir termo de responsabilidade</button>
                                        </form>
                                        <form class="form-horizontal" role="form" action="https://docs.google.com/forms/<?= $idProjeto ?>" target="_blank" method="post">
                                            <button type="submit" class="btn btn-success btn-block" style="border-radius: 7px;">Link do agendamento Google Forms</button>
                                        </form>
                                        <button class='btn btn-default' type='button' data-toggle='modal' data-target='#cartaIntencaoIncentivo' style="border-radius: 30px;"><i class="fa fa-question-circle"></i></button>
                                        <form class="form-horizontal" role="form" action="../pdf/CARTA_DE_INTENCAO_DE_INCENTIVO.docx" method="post">
                                            <button type="submit" class="btn btn-success btn-block" style="border-radius: 7px;">Download modelo da carta de incentivo</button>
                                        </form>
                                        <form class="form-horizontal" role="form" action="?perfil=carta_incentivo&idProjeto=<?= $idProjeto ?>" method="post">
                                            <button type="submit" class="btn btn-success btn-block" style="border-radius: 7px;">Inserir carta de incentivo</button>
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
                                        <form class="form-horizontal" role="form" action="?perfil=alteracao_projeto&idProjeto=<?= $idProjeto ?>" method="post">
                                            <button type="submit" class="btn btn-success btn-block" style="border-radius: 7px;">solicitar alteração do projeto</button>
                                        </form>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                            <!-- Botão para agendar a entrega -->

                            <?php
                            if($projeto['idStatus'] == 5) {
                            ?>
                                    <div class="form-group">
                                        <div class="col-md-offset-4 col-md-6">
                                            <form class="form-horizontal" role="form" action="?perfil=complemento_informacoes&idProjeto=<?= $idProjeto ?>"
                                                  method="post">
                                                <button type="submit" class="btn btn-success btn-block" style="border-radius: 7px;">anexar complementos</button>
                                            </form>
                                        </div>
                                    </div>
                            <?php
                            }
                            ?>

                            <!-- Botão para anexar complemento de informações -->
                            <?php
                            if($projeto['idStatus'] == 5) {
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

                            <?php
                            $sql = "SELECT *
                                        FROM lista_documento as list
                                        INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
                                        WHERE arq.idPessoa = '$idProjeto'
                                        AND arq.idTipo = 3
                                        AND arq.publicado = '1' AND list.idListaDocumento IN (39,40,41,42,43,44,46,47,52,53) ";
                            $query = mysqli_query($con,$sql);
                            $linhas = mysqli_num_rows($query);
                                if($projeto['idStatus'] == 3 && $linhas == 6){
                            ?>
                                    <div class="form-group">
                                        <div class="col-md-offset-4 col-md-6">
                                            <form class="form-horizontal" role="form"
                                                  action="../pdf/termo_responsabilidade.php"
                                                  method="post">
                                                <input type="hidden" value="<?= $idProjeto ?>" name="idProjeto">
                                                <button type="submit" class="btn btn-success btn-block"
                                                        style="border-radius: 7px;">termo de responsabilidade
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
                            if($idEtapa != 26 && $idEtapa != 27){
                                if($projeto['idStatus'] == 4){
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
                <br><input type="submit" value="Voltar" class="btn btn-theme btn-md btn-block">
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
<div class="modal fade" id="termoResponsabilidade" role="dialog" aria-labelledby="termoResponsabilidade" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Termo de Responsabilidade</h4>
            </div>
            <div class="modal-body" style="text-align: left;">
                <div role="tabpanel">
                    <div class="tab-content">
                        <!-- TABELA -->
                        <div role="tabpanel" class="tab-pane fade in active" id="tabela">
                            <br>
                            <div class="well">
                                O documento deve ser entregue na SMC pelo proponente ou por um representante com a devida procuração simples original;<br/>Em caso de Cooperativa, a Cooperativa deve assinar e o Proponente como anuente.<br/>No momento da entrega do termo será expedido o ofício da abertura de conta e a autorização de captação.
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="certidaoFiscal" role="dialog" aria-labelledby="certidaoFiscal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Certidões Fiscais</h4>
            </div>
            <div class="modal-body" style="text-align: left;">
                <div role="tabpanel">
                    <div class="tab-content">
                        <!-- TABELA -->
                        <div role="tabpanel" class="tab-pane fade in active" id="tabela">
                            <br>
                            <div class="well">
                                Não será aceito nenhum protocolo de pagamento ou correlado. Somente são válidas certidões negativas ou positivas com efeito de negativa.
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cartaIntencaoIncentivo" role="dialog" aria-labelledby="cartaIntencaoIncentivo" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Carta de Intenção de Incentivo</h4>
            </div>
            <div class="modal-body" style="text-align: left;">
                <div role="tabpanel">
                    <div class="tab-content">
                        <!-- TABELA -->
                        <div role="tabpanel" class="tab-pane fade in active" id="tabela">
                            <br>
                            <div class="well">
                                Quando houver um incentivador, favor preencher a carta de incentivo, conforme modelo em anexo e entregar pessoalmente na SMC nos casos de incentivo iguais ou acima de R$ 80 mil.                                                        </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
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
