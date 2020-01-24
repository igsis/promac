<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];
$usuarioLogado = pegaUsuarioLogado();

if (isset($_POST['insereOrcamento']) || isset($_POST['editaOrcamento'])) {
    $descricao = addslashes($_POST['descricao']);
    $quantidade = $_POST['quantidade'];
    $quantidadeUnidade = $_POST['quantidadeUnidade'];
    $valorUnitario = dinheiroDeBr($_POST['valorUnitario']);
    $valorTotal = $valorUnitario * $quantidadeUnidade * $quantidade;
}

if (isset($_POST['insereOrcamento'])) {
    $observacoes = addslashes($_POST['obs']);
    $observacoesEtapa = addslashes($_POST['obsEtapa']);
    $idEtapa = $_POST['idEtapa'];
    $idUnidadeMedida = $_POST['idUnidadeMedida'];

    $sql_insere = "INSERT INTO `orcamento`(`idProjeto`, `idEtapa`, `observacoesEtapa`, `descricao`, `quantidade`, `idUnidadeMedida`, `quantidadeUnidade`, `valorUnitario`, `valorTotal`, `observacoes`, `publicado`) VALUES ('$idProjeto', '$idEtapa', '$observacoesEtapa','$descricao', '$quantidade', '$idUnidadeMedida', '$quantidadeUnidade', '$valorUnitario', '$valorTotal', '$observacoes','1')";

    if (mysqli_query($con, $sql_insere)) {
        $mensagem = "<font color='#01DF3A'><strong>Inserido com sucesso! Utilize o menu para avançar.</strong></font>";
        gravarLog($sql_insere);
    } else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao inserir! Tente novamente.</strong></font>" . $sql_insere;
    }
}

if (isset($_POST['editaOrcamento'])) {
    $etapas = $_POST['idEtapa'];
    $obs_etapa = $_POST['observacoesEtapa'];
    $und_medida = $_POST['idUnidadeMedida'];
    $observacoes = $_POST['observacoes'];
    $idOrcamento = $_POST['editaOrcamento'];
    $quantidadeUnidade = $_POST['quantidadeUnidade'];

    $sql_edita = "UPDATE orcamento SET
	idEtapa = '$etapas',
	observacoesEtapa = '$obs_etapa',
	descricao = '$descricao',
	quantidade = '$quantidade',
	idUnidadeMedida = $und_medida,
	quantidadeUnidade = '$quantidadeUnidade',
	valorUnitario = '$valorUnitario',
	valorTotal = '$valorTotal',
	observacoes = '$observacoes',
	alteradoPor = '$usuarioLogado'		
	WHERE idOrcamento = '$idOrcamento'";
    if (mysqli_query($con, $sql_edita)) {
        $mensagem = "<font color='#01DF3A'><strong>Editado com sucesso! Utilize o menu para avançar.</strong></font>";
        gravarLog($sql_edita);
    } else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao editar! Tente novamente.</strong></font>";
    }
}

if (isset($_POST['apagaOrcamento'])) {
    $idOrcamento = $_POST['apagaOrcamento'];
    $sql_apaga = "UPDATE orcamento SET publicado = 0 WHERE idOrcamento = '$idOrcamento'";
    if (mysqli_query($con, $sql_apaga)) {
        $mensagem = "<font color='#01DF3A'><strong>Apagado com sucesso!</strong></font>";
        gravarLog($sql_apaga);
    } else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['insereOrcamento']) || isset($_POST['editaOrcamento'])) {
    $sql_total = "SELECT SUM(valorTotal) AS tot FROM orcamento
                WHERE publicado > 0 AND idProjeto ='$idProjeto'
                ORDER BY idOrcamento";
    $query_total = mysqli_query($con, $sql_total);
    $total = mysqli_fetch_array($query_total);
    $valorIncentivo = $total['tot'];

    $sql_incentivo = "UPDATE projeto SET valorIncentivo = '$valorIncentivo' WHERE idProjeto = '$idProjeto'";
    $query_incentivo = mysqli_query($con, $sql_incentivo);
    if (mysqli_query($con, $sql_incentivo)) {
        $mensagem .= "<br/><font color='#01DF3A'><strong>Valor total do incentivo atualizado!</strong></font>";
        gravarLog($sql_incentivo);
    } else {
        $mensagem .= "<br/><font color='#FF0000'><strong>Erro ao atualizar o valor total do incentivo! Tente novamente.</strong></font>";
    }
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
        <div class="form-group">
            <h4>Orçamento
                <button class='btn btn-default' type='button' data-toggle='modal' data-target='#infoOrcamento'
                        style="border-radius: 30px;"><i class="fa fa-info-circle"></i></button>
            </h4>
            <h5><?php if (isset($mensagem)) {
                    echo $mensagem;
                }; ?></h5>
        </div>
        <div class="well">
            O orçamento descritivo do projeto deve ser apresentado dividido por grupos de despesa e indicando os
            itens e valores a serem gastos em cada um deles. Você pode prever itens de despesa de acordo com a
            realidade do seu projeto, mas é importante que isso esteja justificado ao longo do projeto ou na
            planilha complementar de orçamento em anexo. Por exemplo, se você vai produzir um documentário e não
            inclui equipamentos no seu orçamento, deve deixar claro de que forma terá equipamentos para realizar as
            atividades propostas. Por isso, em caso de projetos que tenham mais de uma fonte de recursos, ou seja,
            não sejam feitos com recursos apenas do PROMAC, é imprescindível que seja anexada a planilha completa do
            projeto em campo específico
        </div>
        <div class="table-responsive list_info">
            <h8>
                <strong>Observação:</strong> Caso o projeto contemple outras fontes de recurso, poderá enviar uma
                planilha orçamentária completa em formato PDF na etapa ANEXOS (campo de upload <strong>Planilha
                    Orçamentária Complementar</strong>).
            </h8>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- Início Resumo Orçamento -->
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success"><b>Resumo</b></li>
                    <li class="list-group-item">
                        <table class="table table-bordered">
                            <tr>
                                <?php
                                for ($i = 1; $i <= 8; $i++) {
                                    $sql_etapa = "SELECT idEtapa FROM orcamento
										WHERE publicado > 0 AND idProjeto ='$idProjeto' AND idEtapa = '$i'
										ORDER BY idOrcamento";
                                    $query_etapa = mysqli_query($con, $sql_etapa);
                                    $lista = mysqli_fetch_array($query_etapa);

                                    $etapa = recuperaDados("etapa", "idEtapa", $lista['idEtapa']);
                                    echo "<td><strong>" . $etapa['etapa'] . ":</strong>";
                                }
                                ?>
                            </tr>
                            <tr>
                                <?php
                                for ($i = 1; $i <= 8; $i++) {
                                    $sql_etapa = "SELECT SUM(valorTotal) AS tot FROM orcamento
										WHERE publicado > 0 AND idProjeto ='$idProjeto' AND idEtapa = '$i'
										ORDER BY idOrcamento";
                                    $query_etapa = mysqli_query($con, $sql_etapa);
                                    $lista = mysqli_fetch_array($query_etapa);

                                    echo "<td>R$ " . dinheiroParaBr($lista['tot']) . "</td>";
                                }
                                ?>
                            </tr>
                            <tr>
                                <?php
                                $sql_total = "SELECT SUM(valorTotal) AS tot FROM orcamento
											WHERE publicado > 0 AND idProjeto ='$idProjeto'
											ORDER BY idOrcamento";
                                $query_total = mysqli_query($con, $sql_total);
                                $total = mysqli_fetch_array($query_total);
                                echo "<td colspan='8'><strong>TOTAL: R$ " . dinheiroParaBr($total['tot']) . "</strong></td>";
                                ?>
                            </tr>
                        </table>
                    </li>
                </ul>
                <!-- Fim Resumo Orçamento -->

                <div class="form-group"><br>
                    <hr/>
                </div>

                <!-- Início Para inserir item de Orçamento -->
                <form class="form-horizontal" role="form" action="?perfil=orcamento" method="post">

                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-1">
                                <br/><strong>Etapa* </strong>
                                <select class="form-control" name="idEtapa">

                                    <option value="0"></option>
                                    <?php echo geraOpcao("etapa", "") ?>
                                </select>
                            </div>

                            <div class="col-md-2"><strong>Observação
                                    <font size="-2"><br>da etapa </font></strong>
                                <input type="text" class="form-control" name="obsEtapa">
                            </div>

                            <div class="col-md-2"><br/><strong>Descrição *</strong>
                                <input type="text" class="form-control" name="descricao"
                                       placeholder="Descrição da etapa"
                                       maxlength="255" required>
                            </div>

                            <div class="col-md-1"><br/><strong>Qtde </strong>
                                <input type="text" class="form-control" name="quantidade" required>
                            </div>

                            <div class="col-md-1"><strong>Unidade <br>Medida </strong>
                                <select class="form-control" name="idUnidadeMedida" required>
                                    <option value="0"></option>
                                    <?php echo geraOpcao("unidade_medida", "") ?>
                                </select>
                            </div>

                            <div class="col-md-2"><strong>Observação
                                    <font size="-2"><br>da unidade de medida </font></strong>
                                <input type="text" class="form-control" name="obs">
                            </div>

                                <div class="col-md-1"><strong>Qtde Unidade </strong>
                                    <input type="text" class="form-control" name="quantidadeUnidade" required>
                                </div>

                                <div class="col-md-2"><strong><br/>Valor Unitário </strong>
                                    <input type="text" class="form-control" id='valor' name="valorUnitario" required>
                                </div>
                            </div>
                        </div>
                    </div>
                        <!-- Botão para Gravar -->
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="submit" name="insereOrcamento" value="GRAVAR"
                                       class="btn btn-theme btn-lg btn-block">
                            </div>
                        </div>
                </form>
                <!-- Fim Para inserir item de Orçamento -->

                <div class="form-group"><br>
                    <hr/>
                </div>

            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8"><br></div>
            </div>
            <div class="col-md-12">
                <div class="table-responsive list_info">
                    <?php
                    $sql = "SELECT * FROM orcamento
							WHERE publicado > 0 AND idProjeto ='$idProjeto'
							ORDER BY idEtapa";
                    $query = mysqli_query($con, $sql);
                    $num = mysqli_num_rows($query);
                    if ($num > 0) {
                        echo "
							<table class='table table-condensed'>
								<thead>
									<tr class='list_menu'>
										<td width='20%'>Etapa</td>
										<td>Observações etapa</td>
										<td width='30%'>Descrição</td>
										<td width='10%'>Qtde</td>
										<td width='10%'>Unid. Med.</td>
                                        <td>Observações <font size=\"-2\"><br>da unidade de medida: </font></strong>
                                        </td>
										<td width='10%'>Qtde Unid.</td>
										<td width='10%'>Valor Unit.</td>
										<td>Valor Total</td>
										<td width='10%'></td>
										<td width='10%'></td>
									</tr>
								</thead>
								<tbody>";
                        while ($campo = mysqli_fetch_array($query)) {
                            $etapa = recuperaDados("etapa", "idEtapa", $campo['idEtapa']);
                            $medida = recuperaDados("unidade_medida", "idUnidadeMedida", $campo['idUnidadeMedida']);
                            echo "<tr>";
                            echo "<td class='list_description'>" . $etapa['etapa']. "</td>";
                            echo "<td class='list_description'>" . $campo['observacoesEtapa'] . "</td>";

                            echo "<td class='list_description'>" . $campo['descricao'] . "</td>";
                            echo "<td class='list_description'>" . $campo['quantidade'] . "</td>";
                            echo "<td class='list_description'>" . $medida['unidadeMedida'] . "</td>";
                            echo "<td class='list_description'>" . $campo['observacoes'] . "</td>";
                            echo "<td class='list_description'>" . $campo['quantidadeUnidade'] . "</td>";
                            echo "<td class='list_description'>" . dinheiroParaBr($campo['valorUnitario']) . "</td>";
                            echo "<td class='list_description'>" . dinheiroParaBr($campo['valorTotal']) . "</td>";
                            echo "<td class='list_description'>
											<form method='POST' action='?perfil=orcamento'>
												<input type='hidden' name='apagaOrcamento' value='" . $campo['idOrcamento'] . "' />
												<button style='margin-top: 13px' class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Excluir Etapa?' data-message='Deseja realmente excluir a etapa " . $etapa['etapa'] . "?'>Remover</button>
											</form>
										</td>";
                            echo "</tr>";
                        }
                        echo "
							</tbody>
							</table>";

                    }
                    ?>
                </div>
            </div>
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
            <!-- Inicio Modal Informações Orçamento -->
            <div class="modal fade" id="infoOrcamento" role="dialog" aria-labelledby="infoOrcamentoLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Atenção aos limites!!</h4>
                        </div>
                        <div class="modal-body" style="text-align: left;">
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Conforme art. 53 do Decreto
                                        58.041/2017</b></li>
                                <li class="list-group-item">Os projetos culturais poderão acolher despesas de
                                    administração de até 20% (vinte por cento) do valor total do projeto, englobando
                                    gastos administrativos e serviços de captação de recursos.
                                </li>
                                <li class="list-group-item">Para fins de composição das despesas de administração,
                                    deverão ser considerados os tetos de 15% (quinze por cento) para gastos
                                    administrativos e de 10% (dez por cento) para o serviço de captação de recursos
                                </li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fim Modal Informações Orçamento -->
        </div>
</section>
