<?php
set_time_limit(1200);
$cinza = "#EBEBEB";

if (isset($_POST['envioComissao'])) {
    $idProjeto = $_POST['idProjeto'];
    $projeto = recuperaDados("projeto", "idProjeto", $idProjeto);
    $idEtapa = $projeto['idEtapaProjeto'];
    $semanaAtual = date('W');
    $semana = recuperaDados('contagem_comissao', 'semana', $semanaAtual);
    $projetos = $semana['projetos'];

    if ($projetos == 0) {
        $con->query("UPDATE contagem_comissao SET projetos = '0' WHERE semana != $semanaAtual");
    }

    switch ($idEtapa) {
        case 2:
            $statusEnvio = 7;
            break;
        case 10:
            $statusEnvio = 7;
            break;
        case 13:
            $statusEnvio = 19;
            break;
        case 20:
            $statusEnvio = 19;
            break;
        case 14:
            $statusEnvio = 34;
            break;
        case 15:
            $statusEnvio = 34;
            break;
        case 23:
            $statusEnvio = 24;
            break;
        case 25:
            $statusEnvio = 24;
            break;
    }


    $dateNow = date('Y-m-d H:i:s');
    $sql_envioComissao = "UPDATE projeto SET idEtapaProjeto = '$statusEnvio', envioComissao = '$dateNow', idStatus = '2' WHERE idProjeto = '$idProjeto'";
    if (mysqli_query($con, $sql_envioComissao)) {
        $sql_contagem_comissao = "UPDATE `contagem_comissao` SET `projetos` = '" . ($projetos + 1) . "' WHERE `semana` = '$semanaAtual'";
        $con->query($sql_contagem_comissao);
        $sql_historico = "INSERT INTO historico_etapa (idProjeto, idEtapaProjeto, data) VALUES ('$idProjeto', '$statusEnvio', '$dateNow')";
        $query_historico = mysqli_query($con, $sql_historico);
        $mensagem = "<span style='color: #01DF3A; '><strong>Enviado com sucesso!</strong></span>";
        gravarLog($sql_historico);
        gravarLog($sql_envioComissao);
    } else {
        $mensagem = "<span style='color: #FF0000; '><strong>Erro ao enviar! Tente novamente.</strong></span>";
    }
}
if (isset($_POST['arquivar'])) {
    $idProjeto = $_POST['idProjeto'];
    $query = "UPDATE projeto SET publicado = 0 WHERE idProjeto = '$idProjeto' ";
    if (mysqli_query($con, $query)) {
        $mensagem = "<span style='color: #01DF3A; '><strong>Projeto arquivado com sucesso</strong></span>";
    } else {
        $mensagem = "<span style='color: #FF0000; '><strong>Erro ao arquivar o projeto</strong></span>";
    }
}

if (isset($_POST['gravarAnaliseCarta'])) {
    $status = $_POST['statusDoc'];
    $data = exibirDataMysql($_POST['dataRecebimento']);
    $idArquivo = $_POST['idArquivo'];
    $idIncentivadorProjeto = $_POST['idIncentivadorProjeto'];
    $idProjeto = $_POST['idProjeto'];
    $tipoPessoa = $_POST['tipoPessoa'];
    $obs = $_POST['observacao'] ?? null;

    $data_recebimento = new DateTime (exibirDataMysql($_POST['dataRecebimento']));
    $data_1Parcela = new DateTime ($_POST['primeiraParcela']);

    $sqlAtualiza = "UPDATE upload_arquivo SET idStatusDocumento = $status, observacoes = '$obs' WHERE idUploadArquivo = '$idArquivo'";

    if (mysqli_query($con, $sqlAtualiza)) {
        $sqlData = "UPDATE incentivador_projeto SET data_recebimento_carta = '$data' WHERE idIncentivadorProjeto = '$idIncentivadorProjeto'";

        if (mysqli_query($con, $sqlData)) {

            if ($status == 1) {
                $sqlEtapa = "UPDATE incentivador_projeto SET etapa = 9 WHERE idIncentivadorProjeto = '$idIncentivadorProjeto'";
                mysqli_query($con, $sqlEtapa);
                $mensagem = "<span style='color: #01DF3A;'><strong>Análise gravada com sucesso!</strong></span>";

            } else {
                $sqlEtapa = "UPDATE incentivador_projeto SET etapa = 8 WHERE idIncentivadorProjeto = '$idIncentivadorProjeto'";
                mysqli_query($con, $sqlEtapa);
                $mensagem = "<span style='color: #FFA500; '><strong>A análise foi gravada com sucesso, o usuario será notificado sua carta foi negada e permanecerá na etapa de envio da mesma.</strong></span>";
            }
        }
    }
}


if ($pf['idNivelAcesso'] == 2) {
    $sql = "SELECT * FROM pessoa_fisica WHERE liberado = 1";
    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);
    ?>
    <!-- Lista 1 -->
    <style>
        .none {
            display: none;
        }
    </style>
    <div class="form-group">
        <h5><strong><?php if (isset($mensagem)) {
                    echo $mensagem;
                } ?></strong></h5>
        <button type="button" id="button_incricoes_PF" onclick="mostrarDiv('inscricoes_PF')" style="font-size: 20px;"
                class="btn bg-white">Inscrições de pessoa física a liberar
            &nbsp;<span id="icon_inscricoes_PF"><span class="glyphicon glyphicon-chevron-right"></span></span></button>

        <form method='POST' action='?perfil=smc_pesquisa_pf_resultado' class='form-horizontal' role='form'>
            <button type="submit" class="label label-warning" name="liberado" value="1">
                <span>Total: <?= $num ?></span>
            </button>
        </form>

        <div class="row none" id="inscricoes_PF">
            <div class="col-md-12">
                <div class="table-responsive list_info">
                    <?php
                    if ($num > 0) {
                        echo "
                            <table class='table table-condensed'>
                                <thead>
                                    <tr class='list_menu'>
                                        <td>Nome</td>
                                        <td>CPF</td>
                                        <td>RG</td>
                                        <td>Email</td>
                                        <td>Telefone</td>
                                        <td width='10%'></td>
                                    </tr>
                                </thead>
                                <tbody>";
                        $i = 0;
                        while ($campo = mysqli_fetch_array($query)) {
                            if ($i < 10) {
                                echo "<tr>";
                                echo "<td class='list_description'>" . $campo['nome'] . "</td>";
                                echo "<td class='list_description'>" . $campo['cpf'] . "</td>";
                                echo "<td class='list_description'>" . $campo['rg'] . "</td>";
                                echo "<td class='list_description'>" . $campo['email'] . "</td>";
                                echo "<td class='list_description'>" . $campo['telefone'] . "</td>";
                                echo "
                                            <td class='list_description'>
                                                <form method='POST' action='?perfil=smc_visualiza_perfil_pf'>
                                                    <input type='hidden' name='liberado' value='" . $campo['idPf'] . "' />
                                                    <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                                </form>
                                            </td>";
                            }
                            $i++;
                        }
                        echo "</tr>";
                        echo "</tbody>
                                </table>";
                    } else {
                        echo "Não há resultado no momento.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <hr width="50%">

    <?php
    $sql = "SELECT * FROM pessoa_juridica WHERE liberado = 1";
    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);
    ?>
    <!-- Lista 2 -->
    <div class="form-group">
        <button type="button" id="button_incricoes_PJ" onclick="mostrarDiv('inscricoes_PJ')" style="font-size: 20px;"
                class="btn bg-white">Inscrições de pessoa jurídica a liberar
            &nbsp;<span id="icon_inscricoes_PJ"><span class="glyphicon glyphicon-chevron-right"></span></span></button>
        <form method='POST' action='?perfil=smc_pesquisa_pj_resultado' class='form-horizontal' role='form'>
            <button type="submit" class="label label-warning" name="liberado" value="1">
                <span>Total: <?= $num ?></span>
            </button>
        </form>

        <div class="row none" id="inscricoes_PJ">
            <div class="col-md-12">
                <div class="table-responsive list_info">
                    <?php
                    if ($num > 0) {
                        echo "
                            <table class='table table-condensed'>
                                <thead>
                                    <tr class='list_menu'>
                                        <td>Razão Social</td>
                                        <td>CNPJ</td>
                                        <td>Email</td>
                                        <td>Telefone</td>
                                        <td width='10%'></td>
                                    </tr>
                                </thead>
                                <tbody>";
                        $i = 0;
                        while ($campo = mysqli_fetch_array($query)) {
                            if ($i < 10) {
                                echo "<tr>";
                                echo "<td class='list_description'>" . $campo['razaoSocial'] . "</td>";
                                echo "<td class='list_description'>" . $campo['cnpj'] . "</td>";
                                echo "<td class='list_description'>" . $campo['email'] . "</td>";
                                echo "<td class='list_description'>" . $campo['telefone'] . "</td>";
                                echo "
                                            <td class='list_description'>
                                                <form method='POST' action='?perfil=smc_visualiza_perfil_pj'>
                                                    <input type='hidden' name='liberado' value='" . $campo['idPj'] . "' />
                                                    <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                                </form>
                                            </td>";
                            }
                            $i++;
                        }
                        echo "</tr>";
                        echo "</tbody>
                                </table>";
                    } else {
                        echo "Não há resultado no momento.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <hr width="50%" size="10px">

    <?php
    $sql = "SELECT * FROM incentivador_pessoa_fisica WHERE liberado = 1";
    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);
    ?>
    <!-- Lista 3 -->
    <div class="form-group">
        <button type="button" id="button_incricoes_PJ" onclick="mostrarDiv('incentivador_PF')" style="font-size: 20px;"
                class="btn bg-white">
            Inscrições de incentivador pessoa física a liberar
            &nbsp;<span id="icon_incentivador_PF"><span class="glyphicon glyphicon-chevron-right"></span></span>
        </button>
        <form method='POST' action='?perfil=smc_pesquisa_incentivador_pf_resultado' class='form-horizontal' role='form'>
            <button type="submit" class="label label-warning" name="liberado" value="1">
                <span>Total: <?= $num ?></span>
            </button>
        </form>

        <div class="row none" id="incentivador_PF">
            <div class="col-md-12">
                <div class="table-responsive list_info">
                    <?php
                    if ($num > 0) {
                        echo "
                            <table class='table table-condensed'>
                                <thead>
                                    <tr class='list_menu'>
                                        <td>Nome</td>
                                        <td>CPF</td>
                                        <td>Email</td>
                                        <td>Telefone</td>
                                        <td width='10%'></td>
                                    </tr>
                                </thead>
                                <tbody>";
                        $i = 0;
                        while ($campo = mysqli_fetch_array($query)) {
                            if ($i < 10) {
                                echo "<tr>";
                                echo "<td class='list_description'>" . $campo['nome'] . "</td>";
                                echo "<td class='list_description'>" . $campo['cpf'] . "</td>";
                                echo "<td class='list_description'>" . $campo['email'] . "</td>";
                                echo "<td class='list_description'>" . $campo['telefone'] . "</td>";
                                echo "
                                            <td class='list_description'>
                                                <form method='POST' action='?perfil=smc_visualiza_incentivadores_pf'>
                                                    <input type='hidden' name='liberado' value='" . $campo['idPf'] . "' />
                                                    <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                                </form>
                                            </td>";
                            }
                            $i++;
                        }
                        echo "</tr>";
                        echo "</tbody>
                                </table>";
                    } else {
                        echo "Não há resultado no momento.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <hr width="50%">

    <?php
    $sql = "SELECT * FROM incentivador_pessoa_juridica WHERE liberado = 1";
    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);
    ?>
    <!-- Lista 5 -->
    <div class="form-group">
        <button type="button" onclick="mostrarDiv('incentivador_PJ')" style="font-size: 20px;" class="btn bg-white">
            Inscrições de incentivador pessoa jurídica a liberar
            &nbsp;<span id="icon_incentivador_PJ"><span class="glyphicon glyphicon-chevron-right"></span></span>
        </button>

        <form method='POST' action='?perfil=smc_pesquisa_incentivador_pj_resultado' class='form-horizontal' role='form'>
            <button type="submit" class="label label-warning" name="liberado" value="1">
                <span>Total: <?= $num ?></span>
            </button>
        </form>

        <div class="row none" id="incentivador_PJ">
            <div class="col-md-12">
                <div class="table-responsive list_info">
                    <?php
                    if ($num > 0) {
                        echo "
                            <table class='table table-condensed'>
                                <thead>
                                    <tr class='list_menu'>
                                        <td>Razão Social</td>
                                        <td>CNPJ</td>
                                        <td>Email</td>
                                        <td>Telefone</td>
                                        <td width='10%'></td>
                                    </tr>
                                </thead>
                                <tbody>";
                        while ($campo = mysqli_fetch_array($query)) {
                            echo "<tr>";
                            echo "<td class='list_description'>" . $campo['razaoSocial'] . "</td>";
                            echo "<td class='list_description'>" . $campo['cnpj'] . "</td>";
                            echo "<td class='list_description'>" . $campo['email'] . "</td>";
                            echo "<td class='list_description'>" . $campo['telefone'] . "</td>";
                            echo "
                                    <td class='list_description'>
                                        <form method='POST' action='?perfil=smc_visualiza_incentivadores_pj'>
                                            <input type='hidden' name='liberado' value='" . $campo['idPj'] . "' />
                                            <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                        </form>
                                    </td>";

                        }
                        echo "</tr>";
                        echo "</tbody>
                                </table>";
                    } else {
                        echo "Não há resultado no momento.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <hr width="50%">
    <?php
}

$array_status = array(2, 3, 10, 12, 13, 20, 23, 25, 14, 15, 11); //status

foreach ($array_status as $idStatus) {
    $sqlStatus = "SELECT idEtapaProjeto, etapaProjeto, ordem FROM etapa_projeto WHERE idEtapaProjeto = '$idStatus'";
    $sqlProjeto = "SELECT he.data, pro.idProjeto, nomeProjeto, protocolo, idComissao, pro.dataParecerista, pf.nome, pf.cpf, razaoSocial, cnpj, areaAtuacao, pfc.nome AS comissao, etapaProjeto, pro.idEtapaProjeto AS idEtapaProjeto, pro.publicado, pro.idStatus
                    FROM projeto AS pro
                           LEFT JOIN pessoa_fisica AS pf ON pro.idPf = pf.idPf
                           LEFT JOIN pessoa_juridica AS pj ON pro.idPj = pj.idPj
                           INNER JOIN area_atuacao AS ar ON pro.idAreaAtuacao = ar.idArea
                           LEFT JOIN pessoa_fisica AS pfc ON pro.idComissao = pfc.idPf
                           INNER JOIN etapa_projeto AS st ON pro.idEtapaProjeto = st.idEtapaProjeto
                           LEFT JOIN (
                             SELECT MAX(data) AS data, idProjeto FROM historico_etapa GROUP BY idProjeto
                          ) AS he ON pro.idProjeto = he.idProjeto
                    WHERE pro.publicado = 1 AND pro.idEtapaProjeto = '$idStatus' ORDER BY he.data, protocolo";
    $queryProjeto = mysqli_query($con, $sqlProjeto);
    $queryStatus = mysqli_query($con, $sqlStatus);
    $num = mysqli_num_rows($queryProjeto);

    foreach ($queryStatus as $status) {
        $i = 0;
        ?>
        <div class='form-group'>
            <!--<h5>Projetos com Etapa "<?/*= $status['etapaProjeto'] */ ?>"</h5>-->
            <button type="button" onclick="mostrarDiv('projeto<?= $status['idEtapaProjeto'] ?>')"
                    style="font-size: 20px;" class="btn bg-white">
                Projetos com Etapa "<?= $status['etapaProjeto'] ?>"
                &nbsp;<span id="icon_projeto<?= $status['idEtapaProjeto'] ?>"><span
                            class="glyphicon glyphicon-chevron-right"></span></span>
            </button>
            <?php
            if ($pf['idNivelAcesso'] == 2) {
                echo "<form method='POST' action='?perfil=smc_pesquisa_geral_resultado' class='form-horizontal' role='form'>";
            }
            ?>

            <button type="submit" class="label label-warning" name="idEtapaProjeto"
                    value="<?= $status['idEtapaProjeto'] ?>">
                <span>Total: <?= $num ?></span>
            </button>
            </form>
        </div>
        <div class="row none" id="projeto<?= $status['idEtapaProjeto'] ?>">
            <div class="col-md-12">
                <div class="table-responsive list_info">
                    <?php
                    if ($num > 0)
                    {
                    ?>

                    <table class='table table-condensed'>
                        <thead>
                        <tr class='list_menu'>
                            <td>Protocolo (nº ISP)</td>
                            <?php
                            if (($status['idEtapaProjeto'] == 2) || ($status['idEtapaProjeto'] == 13) || ($status['idEtapaProjeto'] == 23) || ($status['idEtapaProjeto'] == 14) || ($status['idEtapaProjeto'] == 10)) {
                                ?>
                                <td>Data do envio</td>
                                <?php
                            }
                            ?>
                            <td>Nome do Projeto</td>
                            <td>Proponente</td>
                            <td>Documento</td>
                            <td>Área de Atuação</td>
                            <?= ($status['ordem'] >= 5) ? "<td>Parecerista</td>" : NULL ?>
                            <?php
                            if (($status['idEtapaProjeto'] == 23) || ($status['idEtapaProjeto'] == 13)) {
                                ?>
                                <td>Arquivo</td>
                                <td>Enviado à</td>
                                <?php
                            }
                            ?>
                            <?= ($status['idEtapaProjeto'] == '2' || $status['idEtapaProjeto'] == '13' || $status['idEtapaProjeto'] == '14' || $status['idEtapaProjeto'] == '23') ? "<td></td>" : NULL ?>
                            <td colspan='2' width='10%'></td>
                        </tr>
                        </thead>
                        <?php
                        while ($campo = mysqli_fetch_array($queryProjeto)) {
                            ?>
                            <tr style="background: <?= ($campo['idStatus'] == 6 && $campo['publicado'] == 1 ? $cinza : "white") ?>">
                                <td class='list_description maskProtocolo'
                                    data-mask="0000.00.00/0000000"><?= $campo['protocolo'] ?></td>
                                <?php
                                if ($status['idEtapaProjeto'] == 2) {

                                    $dataEtapa = new DateTime ($campo['data']);

                                    echo "<td class='list_description'>" . date_format($dataEtapa, "d/m/Y H:i:s") . "</td>";

                                } elseif ($status['idEtapaProjeto'] == 10) {

                                    $dataEtapa = new DateTime ($campo['data']);

                                    echo "<td class='list_description'>" . date_format($dataEtapa, "d/m/Y H:i:s") . "</td>";
                                } elseif ($status['idEtapaProjeto'] == 13) {

                                    $dataEtapa = new DateTime ($campo['data']);

                                    echo "<td class='list_description'>" . date_format($dataEtapa, "d/m/Y H:i:s") . "</td>";

                                } elseif ($status['idEtapaProjeto'] == 14) {
                                    $dataEtapa = new DateTime ($campo['data']);

                                    echo "<td class='list_description'>" . date_format($dataEtapa, "d/m/Y H:i:s") . "</td>";

                                } elseif ($status['idEtapaProjeto'] == 23) {

                                    $dataEtapa = new DateTime ($campo['data']);

                                    echo "<td class='list_description'>" . date_format($dataEtapa, "d/m/Y H:i:s") . "</td>";
                                }
                                ?>


                                <td class='list_description'><?= $campo['nomeProjeto'] ?></td>
                                <td class='list_description'><?= isset($campo['nome']) ? $campo['nome'] : $campo['razaoSocial'] ?></td>
                                <td class='list_description'><?= isset($campo['cpf']) ? $campo['cpf'] : $campo['cnpj'] ?></td>
                                <td class='list_description'><?= mb_strimwidth($campo['areaAtuacao'], 0, 38, "...") ?></td>
                                <?= ($status['ordem'] >= 5) ? "<td class='list_description'>" . $campo['comissao'] . "</td>" : NULL ?>
                                <?php
                                /*TODO: Transformar este bloco de if/elseif em função*/
                                if ($status['idEtapaProjeto'] == 23) {
                                    $sqlRecurso = "SELECT DISTINCT `arquivo`, `dataEnvio` FROM `upload_arquivo` WHERE `idTipo` = '3' AND `idPessoa` = '" . $campo['idProjeto'] . "' AND `idListaDocumento` = '52' AND `publicado` = '1'";
                                    $recurso = mysqli_fetch_array(mysqli_query($con, $sqlRecurso));
                                    $dataEnvio = date_create($recurso['dataEnvio']);
                                    $dataAtual = date_create(date("Y-m-d"));
                                    $dias = date_diff($dataEnvio, $dataAtual);


                                    echo "<td><a href='../uploadsdocs/" . $recurso['arquivo'] . "' target='_blank'>" . mb_strimwidth($recurso['arquivo'], 15, 38, "...") . "</a></td>";
                                    echo "<td>" . $dias->format("%a dias") . "</td>";
                                } elseif (($status['idEtapaProjeto'] == 13)) {
                                    $sqlComplemento = "SELECT DISTINCT `arquivo`, `dataEnvio` FROM `upload_arquivo` WHERE `idTipo` = '3' AND `idPessoa` = '" . $campo['idProjeto'] . "' AND `idListaDocumento` = '46' AND `publicado` = '1'";
                                    $complemento = mysqli_fetch_array(mysqli_query($con, $sqlComplemento));
                                    $dataEnvio = date_create($complemento['dataEnvio']);
                                    $dataAtual = date_create(date("Y-m-d"));
                                    $dias = date_diff($dataEnvio, $dataAtual);

                                    echo "<td><a href='../uploadsdocs/" . $complemento['arquivo'] . "' target='_blank'>" . mb_strimwidth($complemento['arquivo'], 15, 25, "...") . "</a></td>";
                                    echo "<td>" . $dias->format("%a dias") . "</td>";
                                }
                                if ($pf['idNivelAcesso'] == 2) {
                                    if ($campo['idStatus'] != 6) {
                                        ?>
                                        <td class='list_description'>
                                            <form method='POST' action='?perfil=smc_detalhes_projeto'>
                                                <input type='hidden' name='idProjeto'
                                                       value='<?= $campo['idProjeto'] ?>'/>
                                                <input type='submit' class='btn btn-theme btn-block'
                                                       value='Visualizar'>
                                            </form>
                                        </td>
                                        <td class='list_description'>
                                            <?php
                                            if ($status['idEtapaProjeto'] == '2' || $status['idEtapaProjeto'] == '13' || $status['idEtapaProjeto'] == '14' || $status['idEtapaProjeto'] == '23') {
                                                ?>
                                                <form method="POST" action=''>
                                                    <input type='button' data-id="<?= $campo['idProjeto'] ?>"
                                                           name='envioComissao' class='btn btn-theme btn-block'
                                                           value='Enviar para comissão' data-toggle='modal'
                                                           data-target='#enviarComissao'>
                                                </form>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <?php
                                    } elseif ($campo['idStatus'] == 6) {
                                        if ($status['idEtapaProjeto'] == '2' || $status['idEtapaProjeto'] == '13' || $status['idEtapaProjeto'] == '14' || $status['idEtapaProjeto'] == '23') {
                                            echo "<td style='color: #942a25;text-align: center;font-weight: bold;'>
                                                <form method='POST' action='?perfil=cancelado_visualizacao'>
                                                    <input type='hidden' name='idProjeto'
                                                           value='" . $campo['idProjeto'] . "'>
                                                    <input style='margin-top: 14px' type='submit' class='btn btn-warning btn-block'
                                                           value='Resumo'><small>Cancelado</small>
                                                </form>
                                                    </td>";
                                            echo "<td style='color: #942a25;text-align: center;font-weight: bold'>
                                                        <button class='btn btn-danger btn-block' data-id='" . $campo['idProjeto'] . "' name='arquivar' data-toggle='modal' data-target='#arquivar'>Arquivar</button><small>Cancelado</small>";
                                        } else {
                                            echo "<td style='color: #942a25;text-align: center;font-weight: bold'><small>Cancelado</small>
                                                        <form method='POST' action='?perfil=cancelado_visualizacao'>
                                                            <input type='hidden' name='idProjeto' value='" . $campo['idProjeto'] . "'>
                                                            <input type='submit' class='btn btn-warning btn-block'  value='Resumo'>
                                                        </form>
                                                        <button class='btn btn-danger btn-block'  data-id='" . $campo['idProjeto'] . "' name='arquivar' data-toggle='modal' data-target='#arquivar'>Arquivar</button>
                                                     </td>";
                                        }
                                    }
                                    ?>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php

                        }
                        }
                        else {
                            echo "Não há resultado no momento.";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <hr width="50%">
        <?php
    }
}
?>

<?php
$sql = "SELECT * FROM incentivador_pessoa_fisica WHERE liberado = 4";
$query = mysqli_query($con, $sql);
$num = mysqli_num_rows($query);
?>
<!-- Lista 4 -->
<div class="form-group">
    <button type="button" onclick="mostrarDiv('certidoes_incentivador_PF')" style="font-size: 20px;"
            class="btn bg-white">
        Incentivador Pessoa Física com certidões de regularidade fiscal anexadas.
        &nbsp;<span id="icon_certidoes_incentivador_PF"><span class="glyphicon glyphicon-chevron-right"></span></span>
    </button>

    <form method='POST' action='?perfil=smc_pesquisa_incentivador_pf_resultado' class='form-horizontal' role='form'>
        <button type="submit" class="label label-warning" name="liberado" value="4">
            <span>Total: <?= $num ?></span>
        </button>
    </form>
</div>
<div class="row none" id="certidoes_incentivador_PF">
    <div class="col-md-12">
        <div class="table-responsive list_info">
            <?php
            if ($num > 0) {
                echo "
                            <table class='table table-condensed'>
                                <thead>
                                    <tr class='list_menu'>
                                        <td>Nome</td>
                                        <td>CPF</td>
                                        <td>Email</td>
                                        <td>Telefone</td>
                                        <td width='10%'></td>
                                    </tr>
                                </thead>
                                <tbody>";
                $i = 0;
                while ($campo = mysqli_fetch_array($query)) {
                    if ($i < 10) {
                        echo "<tr>";
                        echo "<td class='list_description'>" . $campo['nome'] . "</td>";
                        echo "<td class='list_description'>" . $campo['cpf'] . "</td>";
                        echo "<td class='list_description'>" . $campo['email'] . "</td>";
                        echo "<td class='list_description'>" . $campo['telefone'] . "</td>";
                        echo "
                                            <td class='list_description'>
                                                <form method='POST' action='?perfil=smc_certidoes_incentivadores_pf'>
                                                    <input type='hidden' name='idPf' value='" . $campo['idPf'] . "' />
                                                    <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                                </form>
                                            </td>";
                    }
                    $i++;
                }
                echo "</tr>";
                echo "</tbody>
                                </table>";
            } else {
                echo "Não há resultado no momento.";
            }
            ?>
        </div>
    </div>
</div>

<?php
$sql = "SELECT * FROM incentivador_pessoa_juridica WHERE liberado = 4";
$query = mysqli_query($con, $sql);
$num = mysqli_num_rows($query);
?>

<!-- Lista 6 -->
<div class="form-group">
    <button type="button" onclick="mostrarDiv('certidoes_incentivador_PJ')" style="font-size: 20px;"
            class="btn bg-white">
        Incentivador Pessoa Jurídica com certidões de regularidade fiscal anexadas.
        &nbsp;<span id="icon_certidoes_incentivador_PJ"><span class="glyphicon glyphicon-chevron-right"></span></span>
    </button>

    <form method='POST' action='?perfil=smc_pesquisa_incentivador_pj_resultado' class='form-horizontal' role='form'>
        <button type="submit" class="label label-warning" name="liberado" value="4">
            <span>Total: <?= $num ?></span>
        </button>
    </form>
</div>
<div class="row none" id="certidoes_incentivador_PJ">
    <div class="col-md-12">
        <div class="table-responsive list_info">
            <?php
            if ($num > 0) {
                echo "
                            <table class='table table-condensed'>
                                <thead>
                                    <tr class='list_menu'>
                                        <td>Razão Social</td>
                                        <td>CNPJ</td>
                                        <td>Email</td>
                                        <td>Telefone</td>
                                        <td width='10%'></td>
                                    </tr>
                                </thead>
                                <tbody>";
                $i = 0;
                while ($campo = mysqli_fetch_array($query)) {
                    if ($i < 10) {
                        echo "<tr>";
                        echo "<td class='list_description'>" . $campo['razaoSocial'] . "</td>";
                        echo "<td class='list_description'>" . $campo['cnpj'] . "</td>";
                        echo "<td class='list_description'>" . $campo['email'] . "</td>";
                        echo "<td class='list_description'>" . $campo['telefone'] . "</td>";
                        echo "
                                            <td class='list_description'>
                                                <form method='POST' action='?perfil=smc_certidoes_incentivadores_pj'>
                                                    <input type='hidden' name='idPj' value='" . $campo['idPj'] . "' />
                                                    <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                                </form>
                                            </td>";
                    }
                    $i++;
                }
                echo "</tr>";
                echo "</tbody>
                                </table>";
            } else {
                echo "Não há resultado no momento.";
            }
            ?>
        </div>
    </div>
</div>


<?php

$sqlContratos = "SELECT * FROM upload_arquivo WHERE idListaDocumento = 18 AND publicado = 1 AND dataEnvio LIKE '2019%' AND idStatusDocumento IS NULL";
$queryContratos = mysqli_query($con, $sqlContratos);
$numCartas = mysqli_num_rows($queryContratos);

?>


<div class="form-group">
    <button type="button" onclick="mostrarDiv('cartas_incentivo')" style="font-size: 20px;" class="btn bg-white">
        Cartas de incentivo anexadas
        &nbsp;<span id="icon_cartas_incentivo"><span class="glyphicon glyphicon-chevron-right"></span></span>
    </button>

    <form method='POST' action='?perfil=smc_pesquisa_pf_resultado' class='form-horizontal' role='form'>
        <button type="submit" class="label label-warning" name="liberado" value="1">
            <span>Total: <?= $numCartas ?></span>
        </button>
    </form>
</div>
<div class="row none" id="cartas_incentivo">
    <div class="col-md-12">
        <div class="table-responsive list_info">
            <?php

            if ($numCartas > 0):
                $today = date("d/m/Y");
                echo "
                            <table class='table table-condensed' id='cartaDeIncentivo'>
                                <thead>
                                    <tr class='list_menu'>
                                        <td>Incentivador</td>
                                        <td>Documento</td>
                                        <td>Nome do Projeto</td>
                                        <td>Carta de incentivo</td>
                                        <td>1ª parcela de aporte</td>
                                        <td>Edital</td>
                                        <td>Imposto</td>
                                        <td width='10%'></td>
                                    </tr>
                                </thead>
                                <tbody>";

                while ($campo = mysqli_fetch_array($queryContratos)) {
                    $idIncentivadorProjeto = $campo['idPessoa'];

                    $sqlIncentivador = "SELECT I_P.valor_aportado, I_P.edital, I_P.imposto, I_P.tipoPessoa, I_P.idPessoa, P.nomeProjeto, P.idProjeto, parcelas.data_pagamento 
                                            FROM incentivador_projeto AS I_P 
                                            INNER JOIN projeto AS P ON I_P.idProjeto = P.idProjeto
                                            INNER JOIN parcelas_incentivo AS parcelas ON parcelas.idIncentivadorProjeto = I_P.idIncentivadorProjeto
                                            WHERE I_P.idIncentivadorProjeto = '$idIncentivadorProjeto' AND I_P.publicado = 1
                                            ORDER BY parcelas.data_pagamento limit 1";

                    if (!$queryIncentivar = mysqli_query($con, $sqlIncentivador)) {
                        echo $sqlIncentivador;
                    }
                    $infos = mysqli_fetch_assoc($queryIncentivar);
                    $idPessoa = $infos['idPessoa'];

                    if ($infos['tipoPessoa'] == 4) {
                        $incentivador = recuperaDados("incentivador_pessoa_fisica", "idPf", $idPessoa);
                        $docPessoa = $incentivador['cpf'];
                    } elseif ($infos['tipoPessoa'] == 5) {
                        $incentivador = recuperaDados("incentivador_pessoa_juridica", "idPj", $idPessoa);
                        $docPessoa = $incentivador['cnpj'];
                    }


                    echo "<tr> 
                            <form method='POST' action=''>";
                    echo "<td class='list_description'>" . $incentivador['nome'] . "</td>";
                    echo "<td class='list_description'> $docPessoa </td>";
                    echo "<td class='list_description'>" . $infos['nomeProjeto'] . "</td>";
                    echo "<td class='list_description'><a href='../uploadsdocs/" . $campo['arquivo'] . "' target='_blank'>" . mb_strimwidth($campo['arquivo'], 15, 25, "...") . "</a></td>";

                    //$queryy = ";
                    $send = mysqli_query($con, "SELECT idStatusDocumento FROM upload_arquivo WHERE idUploadArquivo = '" . $campo['idUploadArquivo'] . "'");
                    $row = mysqli_fetch_array($send);

                    /* echo "<td class='list_description'>
                             <select class='colorindo' name='statusDoc' id='statusOpt' value='teste'>";
                     echo "<option value=''>Selecione</option>";
                     geraOpcao('status_documento', $row['idStatusDocumento']);
                     echo " </select>
                         </td>";*/

                    echo "<td class='list_description'>" . exibirDataBr($infos['data_pagamento']) . "</td>";
                    echo "<td class='list_description'>" . $infos['edital'] . "</td>";

                    //echo "<td class='list_description'><input type='text' name='dataRecebimento' class='form-control datepicker' value='$today'>  </td>";
                    echo "<td class='list_description'>" . $infos['imposto'] . " </td>";

                    echo "
                                            <td class='list_description'>                                                
                                                    <input type='hidden' name='idPessoa' value='" . $campo['idPessoa'] . "' />
                                                    <input type='hidden' name='idArquivo' value='" . $campo['idUploadArquivo'] . "' />                                                   
                                                    <input type='hidden' name='idProjeto' value='" . $infos['idProjeto'] . "' />
                                                    <input type='hidden' name='tipoPessoa' value='" . $campo ['idTipo'] . "' />
                                                    <!-- <input type ='submit' name='gravarAnaliseCarta' class='btn btn-theme btn-block' value='Gravar'> -->
                                                     <input type='button' name='cartaIncentivo' data-idIncentivadorProjeto='$idIncentivadorProjeto' data-idArquivo='" . $campo['idUploadArquivo'] . "'
                                                      data-idProjeto='" . $infos['idProjeto'] . "' data-tipoPessoa='" . $campo['idTipo'] . "' data-primeiraParcela='" . $infos['data_pagamento'] . "' 
                                                      class='btn btn-theme' data-toggle='modal' data-target='#cartaIncentivo' value='Análise' > 
                                                </form>
                                            </td>";
                    //  echo "<tr  style='display: none;' class='list_description' id='obs'><td></td><td></td><td class='list_description text-center'><b>Observações </b></td><td class='list_description' colspan='2'><textarea class='form-control' type='text' id='observacao'></textarea></td></tr>";

                }
                echo "</tr>";
                echo "</tbody>
                                </table>";

            else:
                echo "Não há resultado no momento.";
            endif;
            ?>
        </div>
    </div>
</div>

<?php

$sqlAutorizacaoDeposito = "SELECT * FROM incentivador_projeto WHERE etapa = 11 AND publicado = 1";

//echo $sqlAutorizacaoDeposito;
$queryAutorizacaoDeposito  = mysqli_query($con, $sqlAutorizacaoDeposito);
$numAutorizacaoDeposito = mysqli_num_rows($queryAutorizacaoDeposito);

?>


<div class="form-group">
    <button type="button" onclick="mostrarDiv('autorizacaoDeposito')" style="font-size: 20px;" class="btn bg-white">
        PROJETOS QUE SOLICITARAM AUTORIZAÇÃO DE DEPÓSITO
        &nbsp;<span id="icon_autorizacaoDeposito"><span class="glyphicon glyphicon-chevron-right"></span></span>
    </button>

    <form method='POST' action='?perfil=smc_pesquisa_pf_resultado' class='form-horizontal' role='form'>
        <button type="submit" class="label label-warning" name="liberado" value="1">
            <span>Total: <?= $numAutorizacaoDeposito ?></span>
        </button>
    </form>
</div>
<div class="row none" id="autorizacaoDeposito">
    <div class="col-md-12">
        <div class="table-responsive list_info">
            <?php

            if ($numAutorizacaoDeposito > 0):
                $today = date("d/m/Y");
                echo "
                            <table class='table table-condensed' id='cartaDeIncentivo'>
                                <thead>
                                    <tr class='list_menu'>
                                        <td>Projeto</td>
                                        <td>Proponente</td>
                                        <td>Incentivador</td>
                                        <td>Parcela</td>
                                        <td>Valor</td>
                                        <td width='13%'>Data do Vencimento do Tributo</td>
                                        <td width='12%'>Data da solicitacao da Autorizacao</td>                                     
                                        <td width='10%'></td>
                                    </tr>
                                </thead>
                                <tbody>";

                while ($campo = mysqli_fetch_array($queryAutorizacaoDeposito)) {
                    $projeto = recuperaDados('projeto', 'idProjeto', $campo['idProjeto']);
                    if ($projeto['tipoPessoa'] == 1) {
                        $idPessoa = $projeto['idPf'];
                        $pf = recuperaDados("pessoa_fisica", "idPf", $idPessoa);
                    } elseif ($campo['tipoPessoa'] == 2) {
                        $idPessoa = $projeto['idPj'];
                        $pj = recuperaDados("pessoa_juridica", "idPj", $idPessoa);
                    }

                    if ($campo['tipoPessoa'] == 4) {
                        $incentivador = recuperaDados('incentivador_pessoa_fisica', 'idPf', $campo['idPessoa']);
                    } elseif ($campo['tipoPessoa'] == 5) {
                        $incentivador = recuperaDados('incentivador_pessoa_juridica', 'idPj', $campo['idPessoa']);
                    }

                    $sqlIncentivadorProjeto = "SELECT I_P.valor_aportado, I_P.edital, I_P.imposto, parcelas.data_pagamento, parcelas.valor, parcelas.numero_parcela, upDocs.dataEnvio 
                                                FROM incentivador_projeto AS I_P 
                                                INNER JOIN parcelas_incentivo AS parcelas ON parcelas.idIncentivadorProjeto = I_P.idIncentivadorProjeto AND parcelas.comprovante_deposito = 0 AND parcelas.extrato_conta_projeto = 0
                                                INNER JOIN upload_arquivo AS upDocs ON I_P.idIncentivadorProjeto = upDocs.idPessoa AND idListaDocumento IN (55,56) AND upDocs.publicado = 1
                                                WHERE I_P.idIncentivadorProjeto = '" . $campo['idIncentivadorProjeto'] ."' AND I_P.publicado = 1
                                                ORDER BY upDocs.dataEnvio DESC LIMIT 1";

                    $queryIncentivar = mysqli_query($con, $sqlIncentivadorProjeto);
                    $infos = mysqli_fetch_assoc($queryIncentivar);

                    $proponente = isset($pf['nome']) ? $pf['nome'] : $pj['razaoSocial'];
                    $nomeIncentivador = isset($incentivador['nome']) ? $incentivador['nome'] : $incentivador['razaoSocial'];

                    //print_r($infos);


                    echo "<tr> 
                            <form method='POST' action='?perfil=smc_detalhes_projeto'>";
                    echo "<td class='list_description'>"  . $projeto['nomeProjeto'] . "</td>";
                    echo "<td class='list_description'>$proponente</td>";
                    echo "<td class='list_description'>$nomeIncentivador</td>";
                    echo "<td class='list_description'>"  . $infos['numero_parcela'] . "ª</td>";
                    echo "<td class='list_description'>R$ " . dinheiroParaBr($infos['valor']) . "</td>";
                    echo "<td class='list_description'>" . exibirDataBr($infos['data_pagamento']) . "</td>";
                    echo "<td class='list_description'>" . exibirDataBr($infos['dataEnvio']) . "</td>";

                    echo " 
                                            <td class='list_description'>                                     
                                                <input type='hidden' name='idProjeto' value='".$campo['idProjeto'] ."'/>
                                                <input type='hidden' name='idIncentivadorProjeto' value='".$campo['idIncentivadorProjeto'] ."'/>
                                                <input type='submit' class='btn btn-theme btn-block'
                                                       value='Visualizar'>
                                                </form>
                                            </td>";
                    //  echo "<tr  style='display: none;' class='list_description' id='obs'><td></td><td></td><td class='list_description text-center'><b>Observações </b></td><td class='list_description' colspan='2'><textarea class='form-control' type='text' id='observacao'></textarea></td></tr>";

                }
                echo "</tr>";
                echo "</tbody>
                                </table>";

            else:
                echo "Não há resultado no momento.";
            endif;
            ?>
        </div>
    </div>
</div>


<!-- Modal Enviar a Comissão -->
<div class="modal fade" id="enviarComissao" tabindex="-1" role="dialog" aria-labelledby="enviarComissao">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="enviarComissao">Enviar para comissão?</h4>
            </div>
            <div class="modal-body">
                <p>Para confirmar clique no botão SIM!</p>
            </div>
            <div class="modal-footer">
                <form method='POST' action='' id='formEnviar'>
                    <input type='hidden' name='idProjeto'>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <button type="submit" name='envioComissao' class="btn btn-primary">SIM</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para arquivar projeto -->
<div class="modal fade" id="arquivar" tabindex="-1" role="dialog" aria-labelledby="arquivar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="arquivar">Deseja arquivar esse projeto?</h4>
            </div>
            <div class="modal-body">
                <p>Para confirmar clique no botão SIM!</p>
            </div>
            <div class="modal-footer">
                <form method='POST' action='' id="formArquivar">
                    <input type='hidden' name='idProjeto' value="<?= $campo['idProjeto'] ?>">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <button type="submit" name='arquivar' class="btn btn-danger">SIM</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal carta de incentivo -->
<div class="modal fade" id="cartaIncentivo" tabindex="-1" role="dialog" aria-labelledby="cartaIncentivo">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="enviarComissao">Análise da carta de incentivo</h4>
            </div>
            <div class="modal-body" id="modalIncentivo">
              <!--  <div class="row">
                    <h5 class="text-center" id="diffDates"><b><p id="diff">A data de vencimento do tributo é  </p><b/></h5>
                </div>-->
                <form action="" method="post" id="formCartaIncentivo">
                    <?php
                    $send = mysqli_query($con, "SELECT idStatusDocumento FROM upload_arquivo WHERE idUploadArquivo = '" . $campo['idUploadArquivo'] . "'");
                    $row = mysqli_fetch_array($send);

                    ?>
                    <div class="table-responsive list_info">
                        <table class="table table-condensed table-hover">
                            <thead>
                            <tr class="list_menu text-center">
                                <td>Data Recebimento</td>
                                <td>Status</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="list_description">
                                    <input type='text' name='dataRecebimento'
                                           class='input-group form-control datepicker'
                                           value='<?= $today ?>'>
                                </td>
                                <td class="list_description" width="50%">
                                    <select class='colorindo form-control' name='statusDoc' id='statusOpt'
                                            value='teste'>
                                        <option value=''>Selecione</option>
                                        <?= geraOpcao('status_documento', $status); ?>
                                    </select>
                                </td>
                            </tr>
                            <thead class="none" id="observacao">
                            <tr style="height: 15px;"></tr>
                            <tr class="text-center list_menu">
                                <td colspan="2">Observações</td>
                            </tr>
                            </thead>

                            <tr class="none text-center" id="observacaotext">
                                <td class="list_description" colspan="2">
                                    <textarea class="form-control" name="observacao" id="observacao" rows="3"
                                              placeholder="Informe o motivo para o documento está sendo negado..."></textarea>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                        <input type='hidden' name='idIncentivadorProjeto' value=''/>
                        <input type='hidden' name='idArquivo' value=''/>
                        <input type='hidden' name='idProjeto' value=''/>
                        <input type='hidden' name='tipoPessoa' value=''/>
                        <input type='hidden' name='primeiraParcela' value=''/>
                        <input type='submit' name='gravarAnaliseCarta' class='btn btn-success' value='Gravar'>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    $('#statusOpt').on('change', function () {
        if ($('#statusOpt').val() == 3) {
            $('#observacao').show();
            $('#observacaotext').show();
        } else {
            $('#observacao').hide();
            $('#observacaotext').hide();
        }
    });

    $('.datepicker').datepicker({
        minDate: 0
    });

    // Alimenta o modal com o idProjeto
    $('#enviarComissao').on('show.bs.modal', function (e) {
        let idProjeto = $(e.relatedTarget).attr('data-id');
        $(this).find('#formEnviar input[name="idProjeto"]').attr('value', idProjeto);

    });
    $('#arquivar').on('show.bs.modal', function (e) {
        let idProjeto = $(e.relatedTarget).attr('data-id');
        $(this).find('#formArquivar input[name="idProjeto"]').attr('value', idProjeto);

    });

    $('#cartaIncentivo').on('show.bs.modal', function (e) {
        let idIncentivadorProjeto = $(e.relatedTarget).attr('data-idIncentivadorProjeto');
        let idArquivo = $(e.relatedTarget).attr('data-idArquivo');
        let idProjeto = $(e.relatedTarget).attr('data-idProjeto');
        let tipoPessoa = $(e.relatedTarget).attr('data-tipoPessoa');
        let first = $(e.relatedTarget).attr('data-primeiraParcela');

        $(this).find('#formCartaIncentivo input[name="idIncentivadorProjeto"]').attr('value', idIncentivadorProjeto);
        $(this).find('#formCartaIncentivo input[name="idArquivo"]').attr('value', idArquivo);
        $(this).find('#formCartaIncentivo input[name="idProjeto"]').attr('value', idProjeto);
        $(this).find('#formCartaIncentivo input[name="tipoPessoa"]').attr('value', tipoPessoa);
        $(this).find('#formCartaIncentivo input[name="primeiraParcela"]').attr('value', first);

    });

    let statusAll = document.querySelectorAll(".colorindo")

    for (let status of statusAll) {

        if (status.options[status.selectedIndex].value == "") {
            status.style.backgroundColor = "yellow"
        }
    }

    for (let status of statusAll) {

        status.addEventListener("change", () => {
            if (status.options[status.selectedIndex].value == "") {
                status.style.backgroundColor = "yellow"
            } else {
                status.style.backgroundColor = "#F0F0E9"
            }
        })
    }

    function mostrarDiv(divId) {
        if ($('#' + divId).is(':visible')) {
            $('#' + divId).slideUp();
            $('#icon_' + divId).html("<span class='glyphicon glyphicon-chevron-right'></span>");
        } else {
            $('#' + divId).slideDown('slow');
            $('#icon_' + divId).html("<span class='glyphicon glyphicon-chevron-down'></span>");
        }
    }
</script>