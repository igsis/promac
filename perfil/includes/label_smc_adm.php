<div role="tabpanel" class="tab-pane fade in active" id="adm">
    <div class="form-group">
        <h5>
            <?php if(isset($mensagem)){echo $mensagem;}; ?>
        </h5>

        <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
            <div class="form-group">
                <div class="col-md-offset-3 col-md-3" align="right"><br/><label>Enviar projeto para comissão</label><br>
                    <?php echo exibirDataHoraBr($projeto['envioComissao'])?>
                </div>
                <div class="col-md-2"><br/>
                    <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                        <input type='hidden' name='idProjeto' value='<?php echo $idProjeto?>'>
                        <input type="submit" name="envioComissao" class="btn btn-theme btn-lg btn-block" value="Sim">
                    </form>
                </div>

                <!-- Se existir um parecerista -->
                <?php if($projeto['idComissao'] > 0): ?>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8" align="left"><br/>
                            <strong>Parecerista Responsável:</strong> <?php echo isset($comissao['nome']) ? $comissao['nome'] : null ?>
                        </div>
                    </div>
                <?php endif ?>

                <div class="form-group">
                    <div class="col-md-12">
                        <hr/>
                    </div>
                </div>
            </div>
        </form>

        <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8"><label>Etapa do Projeto</label><br/>
                    <select class="form-control" name="idStatus">
                        <?php echo geraOpcao("status",$projeto['idStatus']) ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-4"><label>Valor Aprovado</label><br/>
                    <input type="text" name="valorAprovado" id='valor' class="form-control" value="<?php echo dinheiroParaBr($projeto['valorAprovado']) ?>">
                </div>
                <div class="col-md-4"><label>Porcentagem Renúncia</label><br/>
                    <select class="form-control" name="idRenunciaFiscal">
                        <?php echo geraOpcao("renuncia_fiscal",$projeto['idRenunciaFiscal']) ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-6"><label>Status de Análise</label><br/>
                    <select class="form-control" name="idStatusParecerista">
                        <option value="0"></option>
                        <?php echo geraOpcao("status_parecerista",$projeto['idStatusParecerista']) ?>
                    </select>
                </div>
                <div class="col-md-6"><label>Data da Reunião</label>
                    <input type="text" name="dataReuniao" id='datepicker08' class="form-control" required value="<?php echo exibirDataBr($projeto['dataReuniao']) ?>">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-3"><label>Data Publicação DOC</label>
                    <input type="text" name="dataPublicacaoDoc" id='datepicker09' class="form-control" value="<?php echo exibirDataBr($projeto['dataPublicacaoDoc']) ?>">
                </div>
                <div class="col-md-5"><label>Link Publicação DOC</label>
                    <input type="text" name="linkPublicacaoDoc" class="form-control" value="<?php echo $projeto['linkPublicacaoDoc'] ?>">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <?php echo "<input type='hidden' name='IDP' value='$idProjeto'>"; ?>
                    <input type="submit" name="gravarAdm" class="btn btn-theme btn-md btn-block" value="Gravar">
                </div>
            </div>

            <br/>
        </form>

        <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8"><label>Notas</label><br/>
                    <textarea name="nota" class="form-control" rows="10" placeholder="Insira neste campo informações de notificações para o usuário."></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <?php echo "<input type='hidden' name='IDP' value='$idProjeto'>"; ?>
                    <input type="submit" name="gravarNota" class="btn btn-theme btn-md btn-block" value="Gravar">
                </div>
            </div>
        </form>

        <ul class='list-group'>
            <li class='list-group-item list-group-item-success'>Notas</li>
            <?php
                $sql = "SELECT * FROM notas WHERE idProjeto = '$idProjeto'";
                $query = mysqli_query($con,$sql);
                $num = mysqli_num_rows($query);
                if($num > 0)
                {
                    while($campo = mysqli_fetch_array($query))
                    {
                        echo "<li class='list-group-item' align='left'><strong>".exibirDataHoraBr($campo['data'])."</strong><br/>".$campo['nota']."</li>";
                    }
                }
                else
                {
                    echo "<li class='list-group-item'>Não há notas disponíveis.</li>";
                }
            ?>
        </ul>

        <!-- Exibir arquivos -->
        <div class="form-group">
            <div class="col-md-12">
                <div class="table-responsive list_info">
                    <h6>Arquivo(s) Anexado(s)</h6>
                    <?php listaArquivosPessoaSMC($idProjeto,9,"smc_detalhes_projeto"); ?>
                </div>
            </div>
        </div>
    </div>
</div>