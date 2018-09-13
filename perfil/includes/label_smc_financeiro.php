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

<?php
    $sql = "SELECT * FROM incentivador_projeto WHERE idProjeto = '$idProjeto' AND publicado = '1'";
    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);
    if($num > 0) 
        { ?>
        <div class="table-responsive list_info">
            <table class='table table-condensed'>
                <thead>
                    <tr class='list_menu'>
                        <td>Incentivador</td>
                        <td>Documento</td>
                        <td></td>
                    </tr>
                </thead>
    <tbody>
            <?php while ($linha = mysqli_fetch_array($query)) {
                    if($linha['tipoPessoa'] == 4)
                        {
                            $incentivadorPF = "incentivador_pessoa_fisica";
                            $pf = recuperaDados($incentivadorPF, 'idPf', $linha['idIncentivador']);
                            $incentivadorProjeto = $linha['idIncentivadorProjeto'];
                        }
                    else
                        {
                            $incentivadorPJ = "incentivador_pessoa_juridica";
                            $pj = recuperaDados($incentivadorPJ, 'idPj', $linha['idIncentivador']);
                            $incentivadorProjeto = $linha['idIncentivadorProjeto'];
                        }
            ?>
        <tr>
            <td class="list_description">
                <?=($linha['tipoPessoa'] == 4 ? $pf['nome'] : $pj['razaoSocial'])?>
            </td>
            <td class="list_description">
                <?=($linha['tipoPessoa'] == 4 ? $pf['cpf'] : $pj['cnpj'])?>
            </td>
            <td>
                <form method='POST' action='?perfil=smc_detalhes_projeto&idFF=<?=$idP?>'>
                    <?php echo "<input type='hidden' name='IIP' value='".$linha['idIncentivadorProjeto']."'>";
                        echo "<input type='hidden' name='IDP' value='$idProjeto'>"; ?>
                        <input type="hidden" name="removerIncentivador" value="<?php $linha['idIncentivadorProjeto']; ?>">
                        <button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-message="<?=$linha['tipoPessoa'] == 4 ? $pf['nome'] : $pj['razaoSocial']?>">Remover</button>
                </form>
            </td>
        </tr>

        <div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Deseja remover o icentivador do projeto?</h4>
                    </div>
            <div class="modal-body">
                 <p>a</p>
            </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirm">Remover</button>
                    </div>
                </div>
            </div>
        </div>

        <?php } ?>
    </tbody>
</table>
</div>

<?php }
else {
    ?>
            <h4>Não existem incentivadores para este projeto</h4>
            <?php } ?>
</div>
