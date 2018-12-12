<?php
$con = bancoMysqli();
unset($_SESSION['idProjeto']);
$tipoPessoa = '1';

$idPf = $_SESSION['idUser'];
$pf = recuperaDados("pessoa_fisica", "idPf", $idPf);
$statusProjeto = recuperaStatus("statusprojeto");


if (isset($_POST['apagar'])) {
    $idProjeto = $_POST['apagar'];
    $sql_apaga = "UPDATE projeto SET publicado = '0' WHERE idProjeto = '$idProjeto'";
    if (mysqli_query($con, $sql_apaga)) {
        $mensagem = "<font color='#01DF3A'><strong>Projeto apagado com sucesso!</strong></font>";
        gravarLog($sql_apaga);
    } else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar projeto! Tente novamente.</strong></font>";
    }
}

if (isset($_POST['cancelar'])){
    $idProjeto = $_POST['projeto'];
    $dateNow = date('Y-m-d H:i:s');

    $query = "UPDATE `projeto` SET projeto.idEtapaProjeto = '6' WHERE idProjeto = '$idProjeto'";
    $historico = "INSERT INTO historico_cancelamento (idProjeto, idUsuario, data, acao) VALUES ('$idProjeto','$idPf','$dateNow',1)";
    if (mysqli_query($con,$query)){
        if (mysqli_query($con,$historico)){
            $mensagem = "<font color='#01DF3A'><strong>Projeto apagado com sucesso!</strong></font>";
        }
        else{
            $mensagem = "<font color='#FF0000'><strong>Erro ao apagar projeto! Tente novamente.</strong></font>";
        }
    }else{
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar projeto! Tente novamente.</strong></font>";
    }

}

?>
<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include '../perfil/includes/menu_interno_pf.php'; ?>
        <div class="form-group">
            <?php
            if ($pf['liberado'] != NULL) echo "<h4>Projetos</h4>";
            ?>
            <h5><?php if (isset($mensagem)) {echo $mensagem;}; ?></h5>
        </div>
        <!-- Início Lista Projetos Cancelados pela SMC -->
        <?php
        $sql_cancelados = "SELECT distinct prj.idProjeto, nomeProjeto, protocolo, acao, observacao, data FROM projeto AS prj 
                            INNER JOIN historico_cancelamento AS hst ON prj.idProjeto = hst.idProjeto
                            WHERE idPf = '$idPf' AND publicado = 6 AND acao = 1";
        $query_cancelados = mysqli_query($con,$sql_cancelados);
        $num = mysqli_num_rows($query_cancelados);
        if($num > 0){
            echo "<div class='well'>";
            echo "<strong>Há projetos cancelados</strong><br/><br/>";
            echo "<table class='table table-condensed'>
                                <thead>
                                    <tr class='list_menu'>
                                        <td>Protocolo</td>
                                        <td>Nome do Projeto</td>
                                        <td>Observação</td>
                                        <td>Data</td>
                                        <td width='10%'></td>
                                    </tr>
                                </thead>
                                <tbody>";
            while ($cancelados = mysqli_fetch_array($query_cancelados)){
                echo "<tr>";
                echo "<td class='list_description'>" . $cancelados['protocolo'] . "</td>";
                echo "<td class='list_description'>" . $cancelados['nomeProjeto'] . "</td>";
                echo "<td class='list_description'>" . $cancelados['observacao'] . "</td>";
                echo "<td class='list_description'>" . exibirDataHoraBr($cancelados['data']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
            echo "<i>Para detalhes, entre em contato com a equipe da SMC.</i>";
            echo "</div>";
        }
        ?>
        <!-- Fim Lista Projetos Cancelados pela SMC -->
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <?php
                if ($pf['liberado'] == 2 OR $pf['liberado'] == 4 OR $pf['liberado'] == NULL) {
                    echo "<div class='alert alert-warning'>
				  		<strong></strong>Aguardando preenchimento e envio da Inscrição.
						</div>";
                } elseif ($pf['liberado'] == 1)// foi solicitado liberação, porém a SMC não analisou ainda.
                {
                    ?>
                    <div class="alert alert-success">
                        <strong>Sua solicitação de inscrição foi enviada com sucesso à Secretaria Municipal de Cultura.
                            Aguarde a análise da documentação.</strong>
                    </div>
                    <?php
                }
                if ($pf['liberado'] == 3)
                {
                ?>
                <!--Inicio da validação numero de projetos-->
                <?php
                $qtd = retornaQtdProjetos($tipoPessoa, $idPf);
                $numProjetos = (int)$qtd[0];

                $projeto = retornaProjeto($tipoPessoa, $idPf);
                $numProjeto = $projeto[0];
                if ($statusProjeto == 1) {
                    if ($numProjetos == 0) { ?>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <form class="form-horizontal" role="form" action="?perfil=projeto_novo" method="post">
                                    <input type="submit" value="Inscrever Projeto"
                                           class="btn btn-theme btn-lg btn-block">
                                </form>
                            </div>
                        </div>
                        <?php
                    } else { ?>
                        <div class="alert alert-danger">
                            <p>Você possui o projeto <b><?= $numProjeto ?></b> em andamento. Este é o seu limite.</p>
                        </div>
                        <?php
                    }
                } else { ?>
                    <div class='alert alert-warning'>
                        <strong>Aviso: </strong>O cadastro de novos projetos está desabilitado temporariamente pela SMC.
                    </div>
                <?php
                }
                ?>
                <!--Fim da validação numero de projetos-->
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-8"><br></div>
            </div>

            <div class="col-md-offset-1 col-md-10">
                <div class="table-responsive list_info">
                    <?php
                    $sql = "SELECT * FROM projeto
										WHERE idEtapaProjeto != 6 AND idPf ='$idPf' AND tipoPessoa = 1 
										ORDER BY idProjeto DESC";
                    $query = mysqli_query($con, $sql);
                    $num = mysqli_num_rows($query);
                    if ($num > 0) {
                        echo "<table class='table table-condensed'>
                                <thead>
                                    <tr class='list_menu'>
                                        <td>Nome do Projeto</td>
                                        <td>Área de Atuação</td>
                                        <td width='10%'></td>
                                        <td></td>
                                    </tr>
                                </thead>
                                <tbody>";
                        while ($campo = mysqli_fetch_array($query)) {
                            $area = recuperaDados("area_atuacao", "idArea", $campo['idAreaAtuacao']);
                            echo "<tr>";
                            echo "<td class='list_description'>" . $campo['nomeProjeto'] . "</td>";
                            echo "<td class='list_description'>" . $area['areaAtuacao'] . "</td>";
                            $idCampo = $campo['idEtapaProjeto'];
                            $status = "SELECT etapaProjeto FROM etapa_projeto WHERE idEtapaProjeto='$idCampo'";
                            $envio = mysqli_query($con, $status);
                            $rowStatus = mysqli_fetch_array($envio);
                            if($campo['idStatus'] == 6){
                                echo "<td colspan='2' style='color: #942a25;text-align: center;font-weight: bold'>Cancelado </td>";
                            }
                            else if ($campo['idEtapaProjeto'] == 1) {
                                echo "
                                                    <td class='list_description'>
                                                        <form method='POST' action='?perfil=projeto_edicao'>
                                                            <input type='hidden' name='carregar' value='" . $campo['idProjeto'] . "' />
                                                            <input type ='submit' class='btn btn-theme btn-block' value='carregar'>
                                                        </form>
                                                    </td>";
                                echo "
                                                    <td class='list_description'>
                                                        <form method='POST' action='?perfil=projeto_pf'>
                                                            <input type='hidden' name='apagar' value='" . $campo['idProjeto'] . "' />
                                                            <button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Excluir Projeto?' data-message='Deseja realmente excluir o projeto nº " . $campo['idProjeto'] . "?'>Remover
                                                                    </button>
                                                        </form>
                                                    </td>";
                            } else {
                                echo "
                                                    <td class='list_description'>
                                                        <form method='POST' action='?perfil=projeto_visualizacao'>
                                                            <input type='hidden' name='carregar' value='" . $campo['idProjeto'] . "' />
                                                            <input type ='submit' class='btn btn-theme btn-block' value='visualizar'>
                                                        </form>
                                                    </td>";
                            }
                            echo "</tr>";
                        }
                        echo "
										</tbody>
										</table>";
                    }
                    ?>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
        <!-- Confirmação de Exclusão -->
        <div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
</section>