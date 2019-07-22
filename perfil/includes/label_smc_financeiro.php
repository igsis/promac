<?php

if (isset($_POST['atualizar'])) {
    // // array com os inputs
    $dados = $_POST['dado'];

    //atualiza todos os campos
    foreach ($dados as $dado) {
        if (isset($dado['observ'])) {
            $observacao = $dado['observ'];
        } else {
            $observacao = '';
        }

        $query = "UPDATE upload_arquivo SET idStatusDocumento = '" . $dado['status'] . "', observacoes = '$observacao' WHERE idUploadArquivo = '" . $dado['idArquivo'] . "' ";
        $envia = mysqli_query($con, $query);

        if ($envia) {
            $mensagem = "<font color='#01DF3A'><strong>Os status dos arquivos foram atualizados com sucesso!</strong></font>";
            gravarLog($query);
        } else {
            echo "<script>alert('Erro durante o processamento, entre em contato com os responsáveis pelo sistema para maiores informações.')</script>";
            echo "<script>window.location.href = 'index_pf.php?perfil=smc_index';</script>";
        }
    }
}



function listaArquivosPessoaEditorr($idPessoa, $tipoPessoa)
{
    $con = bancoMysqli();
    $sql = "SELECT *
                    FROM lista_documento as list
                    INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
                    WHERE arq.idPessoa = '$idPessoa'
                    AND arq.idListaDocumento IN (55,56)
                    AND arq.idTipo = '$tipoPessoa'
                    AND arq.publicado = '1'";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
        echo "
		<table class='table table-condensed table-hover text-center'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Nome do arquivo</td>
					<td>Status</td>
					<td>Observações</td>
				</tr>
			</thead>
			<tbody>";
        echo "<form id='atualizaDoc' method='POST' action=''>";
        $count = 0;
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>(" . $arquivo['documento'] . ")</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>";
            $queryy = "SELECT idStatusDocumento FROM upload_arquivo WHERE idUploadArquivo = '" . $arquivo['idUploadArquivo'] . "'";
            $send = mysqli_query($con, $queryy);
            $row = mysqli_fetch_array($send);

            echo "<td class='list_description'>
							<select class='colorindo' onchange='colorindo()' name='dado[$count][status]' id='statusOpt' value='teste'>";
            echo "<option value=''>Selecione</option>";
            geraOpcao('status_documento', $row['idStatusDocumento']);
            echo " </select>
						</td>";
            $queryOBS = "SELECT observacoes FROM upload_arquivo WHERE idUploadArquivo = '" . $arquivo['idUploadArquivo'] . "'";
            $send = mysqli_query($con, $queryOBS);
            $row = mysqli_fetch_array($send);
            echo "<td class='list_description'>
					<input type='text' name='dado[$count][observ]' maxlength='100' class='observacao' disabled id='observ' value='" . $row['observacoes'] . "'/>
					</td>";


            echo "
						
								<input type='hidden' name='dado[$count][idPessoa]' value='$idPessoa' />
								<input type='hidden' name='dado[$count][idListaDocumento]' value='" . $arquivo['idListaDocumento'] . "' />
								<input type='hidden' name='dado[$count][idArquivo]' value='" . $arquivo['idUploadArquivo'] . "' />								
								";
            echo "</tr>";
            $count++;
        }
        echo "
		</tbody>
		</table>";
        echo "<input type='hidden' name='idPf' class='btn btn-theme btn-lg' value='$idPessoa'>";
        echo "<input type='submit' name='atualizar' class='btn btn-theme btn-lg' value='Gravar análise'><br><br>";
        echo "</form>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}


?>

<div role="tabpanel" class="tab-pane fade" id="financeiro">
    <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
        <h5>
            <?php if (isset($mensagem)) {
                echo $mensagem;
            }; ?>
        </h5>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8"><br/></div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-6"><label>Valor Aprovado</label><br/>
                <input type="text" name="valorAprovado" id='valor' class="form-control"
                       value="<?php echo dinheiroParaBr($projeto['valorAprovado']) ?>">
            </div>
            <div class="col-md-6"><label>Valor da Renúncia</label><br/>
                <select class="form-control" name="idRenunciaFiscal">
                    <?php echo geraOpcao("renuncia_fiscal", $projeto['idRenunciaFiscal']) ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-6"><label>Nº do Processo no SEI</label><br/>
                <input type="text" name="processoSei" class="form-control"
                       value="<?php echo $projeto['processoSei'] ?>">
            </div>

            <div class="col-md-6"><label>Assinatura do Termo de Responsabilidade</label>
                <input type="text" name="assinaturaTermo" id='datepicker07' class="form-control"
                       placeholder="DD/MM/AA ou MM/AAAA" required
                       value="<?php echo exibirDataBr($projeto['assinaturaTermo']) ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8"><label>Observações</label><br/>
                <input type="text" name="observacoes" class="form-control"
                       value="<?php echo $projeto['observacoes'] ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-2"><label>Agência BB Nº</label><br/>
                <input type="text" name="agencia" class="form-control" value="<?php echo $projeto['agencia'] ?>">
            </div>

            <div class="col-md-3"><label>Nº da Conta de Captação</label><br/>
                <input type="text" name="contaCaptacao" class="form-control"
                       value="<?php echo $projeto['contaCaptacao'] ?>">
            </div>

            <div class="col-md-3"><label>Nº da Conta de Movimentação</label><br/>
                <input type="text" name="contaMovimentacao" class="form-control"
                       value="<?php echo $projeto['contaMovimentacao'] ?>">
            </div>
        </div>

        <div class="form-group">
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <?php echo "<input type='hidden' name='IDP' value='$idProjeto'>"; ?>
                    <input type="submit" name="gravarFin" class="btn btn-theme btn-md btn-block" value="Gravar">
                </div>
            </div>
        </div>
    </form>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-8"><br/></div>
    </div>

    <form method="POST" action="?perfil=insere_incentivador_projeto&idProjeto=<?= $idProjeto ?>" class="form-horizontal"
          role="form">
        <div class="form-group">
            <h4>Incentivadores do Projeto</h4>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
                <input type="submit" name="insereIncentivador" class="btn btn-theme btn-md btn-block"
                       value="INSERIR INCENTIVADOR">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <hr/>
            </div>
        </div>
    </form>


    <div class="form-group">
        <h4>Solicitações de Autorização de Depósito </h4>
    </div>
    <?php
    $sql = "SELECT * FROM incentivador_projeto WHERE idIncentivadorProjeto = '$idIncentivadorProjeto' AND publicado = '1'";
    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);
    if ($num > 0) { ?>
        <div class="row" id="">
            <div class="col-md-12">
                <div class="list_info">
                    <?php
                    $today = date("d/m/Y");
                    echo "
                            <table class='table table-condensed table-hover text-center' id='cartaDeIncentivo'>
                                <thead>
                                    <tr class='list_menu'>
                                        <td>Projeto</td>
                                        <td>Proponente</td>
                                        <td>Incentivador</td>
                                        <td>Parcela</td>
                                        <td width='10%'>Valor</td>
                                        <td>Data do Vencimento do Tributo</td>
                                        <td>Data da solicitacao da Autorizacao</td>                                     
                                        <td width='10%'>Status da Autorização</td>
                                    </tr>
                                </thead>
                                <tbody>";

                    $campo = mysqli_fetch_array($query);
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

                    $sqlIncentivadorProjeto = "SELECT I_P.valor_aportado, I_P.edital, I_P.imposto, 
                                                    parcelas.data_pagamento, parcelas.valor, parcelas.numero_parcela, parcelas.data_solicitacao_autorizacao AS data_solicita, parcelas.status_solicitacao
                                                    FROM incentivador_projeto AS I_P 
                                                    INNER JOIN parcelas_incentivo AS parcelas ON parcelas.idIncentivadorProjeto = I_P.idIncentivadorProjeto 
                                                    WHERE I_P.idIncentivadorProjeto = '" . $campo['idIncentivadorProjeto'] . "' AND I_P.publicado = 1
                                                    ORDER BY parcelas.data_solicitacao_autorizacao DESC";

                    $queryIncentivar = mysqli_query($con, $sqlIncentivadorProjeto);

                    $valorConcedido = 0;

                    while ($infos = mysqli_fetch_array($queryIncentivar)) {
                        if ($infos['status_solicitacao'] == 1) {
                            $status = "<button class='text-center'><span style='font-size: 17px;' class='glyphicon glyphicon-ok text-success'></span><i></i> <b style='color: white'>Concedida</b></button>";

                            $valorConcedido += $infos['valor'];

                        } elseif ($infos['status_solicitacao'] == 0) {
                            $status = " <input type='hidden' name='idProjeto'
                                                       value='" . $campo['idProjeto'] . "'/>
                                                <input type='submit' class='btn btn-success btn-block' name='conceder'
                                                       value='Conceder'>
                                                       <input type='submit' class='btn btn-danger btn-block' name='negar'
                                                       value='Negar'>";
                            $break = 1;
                        }

                        $valorTotalIncentivo = $infos['valor_aportado'];
                        $valorAautorizar = $infos['valor_aportado'] - $valorConcedido;

                        // echo $sqlIncentivadorProjeto;

                        $proponente = isset($pf['nome']) ? $pf['nome'] : $pj['razaoSocial'];
                        $nomeIncentivador = isset($incentivador['nome']) ? $incentivador['nome'] : $incentivador['razaoSocial'];

                        echo "<tr> 
                            <form method='POST' action='?perfil=smc_detalhes_projeto'>";
                        echo "<td class='list_description'>" . $projeto['nomeProjeto'] . "</td>";
                        echo "<td class='list_description'> $proponente </td>";
                        echo "<td class='list_description'> $nomeIncentivador </td>";
                        echo "<td class='list_description'>" . $infos['numero_parcela'] . "ª</td>";
                        echo "<td class='list_description'>R$ " . dinheiroParaBr($infos['valor']) . "</td>";
                        echo "<td class='list_description'>" . exibirDataBr($infos['data_pagamento']) . "</td>";
                        echo "<td class='list_description'>" . exibirDataBr($infos['data_solicita']) . "</td>";

                        echo " 
                                            <td class='list_description'>                                     
                                                $status
                                                </form>
                                            </td>";
                        //  echo "<tr  style='display: none;' class='list_description' id='obs'><td></td><td></td><td class='list_description text-center'><b>Observações </b></td><td class='list_description' colspan='2'><textarea class='form-control' type='text' id='observacao'></textarea></td></tr>";

                        if ($break == 1) {
                            break;
                        }

                    }
                    echo "</tr>";
                    echo "</tbody>
                                </table>";
                    ?>

                </div>
            </div>
        </div>
        <button id="BTNinfosValores" class="btn btn-theme" style="margin-top: -30px;">Informacoes dos valores autorizado e a autorizar <span id="setinha"><span class="glyphicon glyphicon-arrow-down"></span></span></button>
        <br>
        <br>
        <div class="row" id="infosValores" style="display: none;">
            <div class="col-md-offset-3" style="width: 50%">
                <table class="table table-striped table-bordered table-responsive">
                    <tr>
                        <td width="50%">Valor Total das Autorizações Concedidas</td>
                        <td>R$ <?= dinheiroParaBr($valorConcedido) ?></td>
                    </tr>
                    <tr>
                        <td>Valor Previsto de Incentivo (soma das Cartas de Incentivo)</td>
                        <td>R$ <?= dinheiroParaBr($valorTotalIncentivo) ?></td>
                    </tr>
                    <tr>
                        <td>Valor restante a ser autorizado</td>
                        <td>R$ <?= dinheiroParaBr($valorAautorizar) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 ">
                <div class="table-responsive list_info">
                    <?php
                        listaArquivosPessoaEditorr($idIncentivadorProjeto, 3);
                    ?>
                </div>
            </div>
        </div>


    <?php } else {
        ?>
        <h4>Não existem incentivadores para este projeto</h4>
    <?php } ?>
</div>

<script>
    window.onload = colorindo;

    function colorindo() {

        let statusAll = document.querySelectorAll(".colorindo");

        for (let status of statusAll) {
            if (status.options[status.selectedIndex].value == "") {
                status.style.backgroundColor = "#fdff72"
            }
        }

        let observacoes = document.querySelectorAll(".observacao");
        var i = 0;

        for (let status of statusAll) {
            let id = status.name.substr(5, 1);
            if (status.options[status.selectedIndex].value == "") {
                status.style.backgroundColor = "#fdff72"
                observacoes[id].disabled = true;

            } else if (status.options[status.selectedIndex].value == 3) {
                status.style.backgroundColor = "#F0F0E9"
                observacoes[id].disabled = false;

                console.log(observacoes[id]);



            } else if (status.options[status.selectedIndex].value == 1) {
                status.style.backgroundColor = "#F0F0E9"
                observacoes[id].disabled = true;
            }
            i++;
        }
    }
</script>

<script>
    $('#BTNinfosValores').on('click', function () {
        if ($('#infosValores').is(':visible')) {
            $('#infosValores').hide();
            $('#setinha').html("<span class='glyphicon glyphicon-arrow-down'></span>");
        } else {
            $('#infosValores').show();
            $('#setinha').html("<span class='glyphicon glyphicon-arrow-left'></span>");
        }
    });
</script>
