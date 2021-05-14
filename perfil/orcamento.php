<?php

function exibePlanilhaCompleta($idPessoa, $idListaDocumento, $pagina)
{
    $con = bancoMysqli();
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idListaDocumento = '$idListaDocumento'
			AND arq.publicado = '1'";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
        echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Nome do arquivo</td>
					<td width='15%'></td>
				</tr>
			</thead>
			<tbody>";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>(" . $arquivo['documento'] . ")</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>";
            echo "<td class='list_description'>
                    <input type='hidden' name='apagar' value='{$arquivo['idUploadArquivo']}'>
                    <button class='btn btn-theme' type='button' id='btnRemover' data-toggle='modal' data-target='#confirmApagar' data-message='Deseja realmente remover o arquivo?'>Remover
								</button></td>";
            echo "</tr>";
        }
        echo "
		</tbody>
		</table>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}

$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];
$projeto = recuperaDados('projeto', 'idProjeto',    $idProjeto);

if ($projeto['idAreaAtuacao'] == 22 || $projeto['idAreaAtuacao'] == 13) {
    $valorMax = 1000000;
} else {
    $valorMax = 600000;
}

$atualizarValor = false;

$sql_total = "SELECT SUM(valorTotal) AS tot FROM orcamento
                WHERE publicado > 0 AND idProjeto ='{$idProjeto}'
                ORDER BY idOrcamento";

$queryMax = mysqli_query($con, $sql_total);
$resultadoMax = mysqli_fetch_array($queryMax)[0];

$usuarioLogado = pegaUsuarioLogado();

$tipoPessoa = '3';

// Gerar documentos
$server = "http://" . $_SERVER['SERVER_NAME'] . "/promac";
$http = $server . "/pdf/";

if (isset($_POST['insereOrcamento']) || isset($_POST['editaOrcamento'])) {
    $descricao = addslashes($_POST['descricao']);
    $quantidade = $_POST['quantidade'];
    $quantidadeUnidade = $_POST['quantidadeUnidade'];
    $valorUnitario = dinheiroDeBr($_POST['valorUnitario']);
    $valorTotal = $valorUnitario * $quantidadeUnidade * $quantidade;
    $resultadoMax = $resultadoMax + $valorTotal;

    if ($resultadoMax <= $valorMax){
        $atualizarValor = true;
    }
}

if (isset($resultadoMax) && $atualizarValor) {
    if (isset($_POST['insereOrcamento'])) {
        $observacoes = addslashes($_POST['obs']);
        $idDespesa = $_POST['idDespesa'];
        $idUnidadeMedida = $_POST['idUnidadeMedida'];

        $sql_insere = "INSERT INTO `orcamento`(`idProjeto`, `grupo_despesas_id`, `descricao`, `quantidade`, `idUnidadeMedida`, `quantidadeUnidade`, `valorUnitario`, `valorTotal`, `observacoes`, `publicado`) VALUES ('$idProjeto', '$idDespesa', '$descricao', '$quantidade', '$idUnidadeMedida', '$quantidadeUnidade', '$valorUnitario', '$valorTotal', '$observacoes','1')";

        if (mysqli_query($con, $sql_insere)) {
            $mensagem = "<font color='#01DF3A'><strong>Inserido com sucesso! Utilize o menu para avançar.</strong></font>";
            gravarLog($sql_insere);
        } else {
            $mensagem = "<font color='#FF0000'><strong>Erro ao inserir! Tente novamente.</strong></font>" . $sql_insere;
        }
    }

    if (isset($_POST['editaOrcamento'])) {
        $despesas = $_POST['idDespesa'];
        $und_medida = $_POST['idUnidadeMedida'];
        $observacoes = $_POST['observacoes'];
        $idOrcamento = $_POST['editaOrcamento'];
        $quantidadeUnidade = $_POST['quantidadeUnidade'];

        $sql_edita = "UPDATE orcamento SET
	grupo_despesas_id = '$despesas',
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
} else if(isset($resultadoMax)){
    if ($resultadoMax >= $valorMax){
        $limite = dinheiroParaBr($valorMax);
        $mensagem = "<font color='#FF0000'><strong>Este valor ultrapassa o limite de orçamento para está linguagem.</strong></font><br>
                 <font color='#FF0000'><strong>O limite no orçamento é de R$ {$limite}.</strong></font>";
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

if ((isset($_POST['insereOrcamento']) || isset($_POST['editaOrcamento'])) || isset($_POST['apagaOrcamento'])) {
    $query_total = mysqli_query($con, $sql_total);
    $total = mysqli_fetch_array($query_total);
    $valorProjeto = $total['tot'];

    $sql_projeto = "UPDATE projeto SET valorProjeto = '$valorProjeto' WHERE idProjeto = '$idProjeto'";
    $query_projeto = mysqli_query($con, $sql_projeto);
    if (mysqli_query($con, $sql_projeto)) {
        $mensagem .= "<br/><font color='#01DF3A'><strong>Valor total do incentivo atualizado!</strong></font>";
        gravarLog($sql_projeto);
    } else {
        $mensagem .= "<br/><font color='#FF0000'><strong>Erro ao atualizar o valor total do incentivo! Tente novamente.</strong></font>";
    }
}

if (isset($_POST["enviar"])) {
    $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '3' AND idListaDocumento = 38";
    $query_arquivos = mysqli_query($con, $sql_arquivos);
    while ($arq = mysqli_fetch_array($query_arquivos)) {
        $y = $arq['idListaDocumento'];
        $x = $arq['sigla'];
        $nome_arquivo = isset($_FILES['arquivo']['name'][$x]) ? $_FILES['arquivo']['name'][$x] : null;
        $f_size = isset($_FILES['arquivo']['size'][$x]) ? $_FILES['arquivo']['size'][$x] : null;

        //Extensões permitidas
        $ext = array("PDF", "pdf");

        if ($f_size > 5242880) // 5MB em bytes
        {
            $mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></font>";
        } else {
            if ($nome_arquivo != "") {
                $nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
                $new_name = date("YmdHis") . "_" . semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
                $hoje = date("Y-m-d H:i:s");
                $dir = '../uploadsdocs/'; //Diretório para uploads
                $allowedExts = array(".pdf", ".PDF"); //Extensões permitidas
                $ext = strtolower(substr($nome_arquivo, -4));

                if (in_array($ext, $allowedExts)) //Pergunta se a extensão do arquivo, está presente no array das extensões permitidas
                {
                    if (move_uploaded_file($nome_temporario, $dir . $new_name)) {
                        $sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipo`, `idPessoa`, `idListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('3', '$idProjeto', '$y', '$new_name', '$hoje', '1'); ";
                        $query = mysqli_query($con, $sql_insere_arquivo);
                        if ($query) {
                            $mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";

                            $sql_insere_arquivo .= " Arquivo: orcamento.php";
                            gravarLog($sql_insere_arquivo);
                        } else {
                            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco.</strong></font>";
                        }
                    } else {
                        $mensagem = "<font color='#FF0000'><strong>Erro no upload! Tente novamente.</strong></font>";
                    }
                } else {
                    $mensagem = "<font color='#FF0000'><strong>Erro no upload! Anexar documentos somente no formato PDF.</strong></font>";
                }
            }
        }
    }
}

if (isset($_POST['apagar'])) {
    $idArquivo = $_POST['apagar'];
    $sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE idUploadArquivo = '$idArquivo'";
    if (mysqli_query($con, $sql_apagar_arquivo)) {
        $mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
        gravarLog($sql_apagar_arquivo);
    } else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
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

        <div class="alert alert-warning">
            O orçamento deve ser detalhado. Coloque 1 item de despesa por linha do orçamento, não agrupe despesas
            distintas em uma única linha.
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <div class="table-responsive list_info">
                        <h6>Upload de Arquivo(s) Somente em PDF com tamanho máximo de 5MB.</h6>
                        <div class="well">
                            se houver outras fontes de recursos do projeto além do PROMAC, anexe a planilha do projeto
                            completo, indicando com qual fonte de recurso cada rubrica ser
                        </div>
                        <div class="col-md-offset-2 col-md-8">
                            <form method="POST" action="?perfil=orcamento" class="form-horizontal" role="form"
                                  enctype="multipart/form-data">
                                <?php if (verificaArquivosExistentesPF($idProjeto, 38, 3)): ?>
                                    <label>Planilha completa do projeto</label>
                                    <?php exibePlanilhaCompleta($idProjeto, '38', 'projeto_edicao') ?>
                                <?php else: ?>
                                    <div class="form-group">
                                        <label>Planilha completa do projeto</label>
                                        <input class="form-control" type="file" name="arquivo[planorc]" required>
                                    </div>


                                    <div class="form-group"><input type="hidden" name="idPessoa"
                                                                   value="<?php echo $idProjeto; ?>"/>
                                        <input type="hidden" name="tipoPessoa" value="<?php echo $tipoPessoa; ?>"/>
                                        <input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block"
                                               value='Enviar'>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Início Resumo Orçamento -->
                <ul class="list-group">
                    <li class="list-group-item list-group-item-success"><b>Resumo</b></li>
                    <li class="list-group-item">
                        <?php recuperaTabelaOrcamento($idProjeto); ?>
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
                            <div class="col-md-3">
                                <br/><strong>Grupos de despesa *</strong>
                                <select class="form-control" name="idDespesa">

                                    <option value="0"></option>
                                    <?php echo geraOpcao("grupo_despesas", "") ?>
                                </select>
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
							ORDER BY grupo_despesas_id";
                $query = mysqli_query($con, $sql);
                $num = mysqli_num_rows($query);
                if ($num > 0) {
                    echo "
							<table class='table table-condensed'>
								<thead>
									<tr class='list_menu'>
										<td width='20%'>Etapa</td>
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
                        $despesa = recuperaDados("grupo_despesas", "id", $campo['grupo_despesas_id']);
                        $medida = recuperaDados("unidade_medida", "idUnidadeMedida", $campo['idUnidadeMedida']);
                        echo "<tr>";
                        echo "<td class='list_description'>" . $despesa['despesa'] . "</td>";
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
												<button style='margin-top: 13px' class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Excluir Etapa?' data-message='Deseja realmente excluir a etapa " . $despesa['despesa'] . "?'>Remover</button>
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