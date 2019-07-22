<div role="tabpanel" class="tab-pane fade" id="financeiro">
    <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
        <h5>
            <?php if(isset($mensagem)){echo $mensagem;}; ?>
        </h5>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-8"><br/></div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-6"><label>Valor Aprovado</label><br/>
            <input type="text" name="valorAprovado" id='valor' class="form-control" value="<?php echo dinheiroParaBr($projeto['valorAprovado']) ?>">
        </div>
        <div class="col-md-6"><label>Valor da Renúncia</label><br/>
            <select class="form-control" name="idRenunciaFiscal">
                <?php echo geraOpcao("renuncia_fiscal",$projeto['idRenunciaFiscal']) ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-6"><label>Nº do Processo no SEI</label><br/>
            <input type="text" name="processoSei" class="form-control" value="<?php echo $projeto['processoSei'] ?>">
        </div>

        <div class="col-md-6"><label>Assinatura do Termo de Responsabilidade</label>
            <input type="text" name="assinaturaTermo" id='datepicker07' class="form-control" placeholder="DD/MM/AA ou MM/AAAA" required value="<?php echo exibirDataBr($projeto['assinaturaTermo']) ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-8"><label>Observações</label><br/>
            <input type="text" name="observacoes" class="form-control" value="<?php echo $projeto['observacoes'] ?>">
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-md-offset-2 col-md-2"><label>Agência BB Nº</label><br/>
            <input type="text" name="agencia" class="form-control" value="<?php echo $projeto['agencia'] ?>">
        </div>

        <div class="col-md-3"><label>Nº da Conta de Captação</label><br/>
            <input type="text" name="contaCaptacao" class="form-control" value="<?php echo $projeto['contaCaptacao'] ?>">
        </div>

        <div class="col-md-3"><label>Nº da Conta de Movimentação</label><br/>
            <input type="text" name="contaMovimentacao" class="form-control" value="<?php echo $projeto['contaMovimentacao'] ?>">
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

<form method="POST" action="?perfil=insere_incentivador_projeto&idProjeto=<?=$idProjeto?>" class="form-horizontal" role="form">
    <div class="form-group">
        <h4>Incentivadores do Projeto</h4>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-8">
            <input type="submit" name="insereIncentivador" class="btn btn-theme btn-md btn-block" value="INSERIR INCENTIVADOR">
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
    if($num > 0)
        { ?>
            <div class="row" id="">
                <div class="col-md-12">
                    <div class="table-responsive list_info">
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
                                        <td width='10%'></td>
                                    </tr>
                                </thead>
                                <tbody>";

                            while ($campo = mysqli_fetch_array($query)) {
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

                                $sqlIncentivadorProjeto = "SELECT I_P.valor_aportado, I_P.edital, I_P.imposto, parcelas.data_pagamento, parcelas.valor, parcelas.numero_parcela, parcelas.comprovante_deposito, parcelas.extrato_conta_projeto, upDocs.dataEnvio 
                                                FROM incentivador_projeto AS I_P 
                                                INNER JOIN parcelas_incentivo AS parcelas ON parcelas.idIncentivadorProjeto = I_P.idIncentivadorProjeto 
                                                INNER JOIN upload_arquivo AS upDocs ON I_P.idIncentivadorProjeto = upDocs.idPessoa AND idListaDocumento IN (55,56) AND upDocs.publicado = 1
                                                WHERE I_P.idIncentivadorProjeto = '" . $campo['idIncentivadorProjeto'] ."' AND I_P.publicado = 1
                                                ORDER BY upDocs.dataEnvio DESC LIMIT 1";

                                $queryIncentivar = mysqli_query($con, $sqlIncentivadorProjeto);
                                $infos = mysqli_fetch_assoc($queryIncentivar);

                                $proponente = isset($pf['nome']) ? $pf['nome'] : $pj['razaoSocial'];
                                $nomeIncentivador = isset($incentivador['nome']) ? $incentivador['nome'] : $incentivador['razaoSocial'];

                                echo "<tr> 
                            <form method='POST' action='?perfil=smc_detalhes_projeto'>";
                                echo "<td class='list_description'>"  . $projeto['nomeProjeto'] . "</td>";
                                echo "<td class='list_description'> $proponente </td>";
                                echo "<td class='list_description'> $nomeIncentivador </td>";
                                echo "<td class='list_description'>"  . $infos['numero_parcela'] . "ª</td>";
                                echo "<td class='list_description'>R$ " . dinheiroParaBr($infos['valor']) . "</td>";
                                echo "<td class='list_description'>" . exibirDataBr($infos['data_pagamento']) . "</td>";
                                echo "<td class='list_description'>" . exibirDataBr($infos['dataEnvio']) . "</td>";

                                if ($infos['comprovante_deposito'] == 1 && $infos['extrato'] == 1) {
                                    $valorConcedido = $in
                                }

                                echo " 
                                            <td class='list_description'>                                     
                                                <input type='hidden' name='idProjeto'
                                                       value='".$campo['idProjeto'] ."'/>
                                                <input type='submit' class='btn btn-success btn-block'
                                                       value='Conceder'>
                                                       <input type='submit' class='btn btn-danger btn-block'
                                                       value='Negar'>
                                                </form>
                                            </td>";
                                //  echo "<tr  style='display: none;' class='list_description' id='obs'><td></td><td></td><td class='list_description text-center'><b>Observações </b></td><td class='list_description' colspan='2'><textarea class='form-control' type='text' id='observacao'></textarea></td></tr>";

                            }
                            echo "</tr>";
                            echo "</tbody>
                                </table>";
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive list_info">
                        <table class="table table-condensed">
                            <tr>
                                <td>Valor Total das Autorizações Concedidas</td>
                                <td>Valor Previsto de Incentivo (soma das Cartas de Incentivo)</td>
                                <td>Valor restante a ser autorizado</td>

                            </tr>
                        </table>
                    </div>

                </div>
            </div>

<?php }
else {
    ?>
            <h4>Não existem incentivadores para este projeto</h4>
            <?php } ?>
</div>
