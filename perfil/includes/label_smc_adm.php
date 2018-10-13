<div role="tabpanel" class="tab-pane fade in active" id="adm">
    <div class="form-group">
        <h5>
            <?php if(isset($mensagem)){echo $mensagem;}; ?>
        </h5>

        <?php
        if($projeto['idEtapaProjeto'] > 1) {
        ?>
            <div class="form-group">
                <div class="col-md-offset-1 col-md-4">
                    <label>Etapa:</label> <?= $etapa['etapaProjeto'] ?>
                </div>
                <div class="col-md-3">
                    <label>Status:</label> <?= $status['status'] ?>
                </div>
                <div class="col-md-3">
                    <button class='btn btn-danger btn-sm' style="border-radius: 10px;" type='button' data-toggle='modal' data-target='#confirmCancelar' data-title='Cancelamento de projeto' data-message='Você realmete deseja cancelar o projeto?'>Cancelar Projeto</button>
                </div>
            </div>
            <!-- Confirmação de Cancelamento -->
            <div class="modal fade" id="confirmCancelar" role="dialog" aria-labelledby="confirmCancelarLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" id='cancelarProjeto' action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><p>Cancelamento de projeto</p></h4>
                            </div>
                            <div class="modal-body">
                                <p><span style="color: red; "><strong>ATENÇÃO: A ação não poderá ser desfeita!</strong></span></p>
                                <p>Qual o motivo do cancelamento do projeto?</p>
                                <input type="text" name="observacao" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <input type='hidden' name='idProjeto' value='<?php echo $idProjeto ?>'>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type='submit' class='btn btn-danger btn-sm' style="border-radius: 10px;" name="cancelarProjeto">Confirmar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fim Confirmação de Exclusão -->
        <?php
        }
        ?>

        <?php
        $array_envio_comissao = array(2,10,13,20,14,15,23,25,29,31);
        if(in_array($projeto['idEtapaProjeto'], $array_envio_comissao )) {
        ?>
            <div class="form-group">
                <div class="col-md-12"><hr/></div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-1 col-md-4">
                    <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                        <input type='hidden' name='idProjeto' value='<?php echo $idProjeto ?>'>
                        <input type="submit" name="envioComissao" class="btn btn-theme btn-sm btn-block" value="Enviar projeto pra comissão">
                    </form>
                    Último envio: <?php echo exibirDataHoraBr($projeto['envioComissao']) ?>
                </div>
                <div class="col-md-3">
                    <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                        <input type='hidden' name='idProjeto' value='<?php echo $idProjeto ?>'>
                        <input type="submit" name="aprovaProjeto" class="btn btn btn-success btn-sm btn-block" style="border-radius: 10px;" value="Aprovar Projeto">
                    </form>
                </div>
                <div class="col-md-3">
                    <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                        <input type='hidden' name='idProjeto' value='<?php echo $idProjeto ?>'>
                        <input type="submit" name="reprovaProjeto" class="btn btn-danger btn-sm btn-block" style="border-radius: 10px;" value="Reprovar Projeto">
                    </form>
                </div>
            </div>
        <?php
        }
        ?>

        <!-- Se existir um parecerista -->
        <?php if($projeto['idComissao'] > 0): ?>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8" align="left"><br/>
                    <strong>Parecerista Responsável:</strong> <?php echo isset($comissao['nome']) ? $comissao['nome'] : null ?>
                </div>
            </div>
        <?php endif ?>

        <div class="form-group">
            <div class="col-md-12"><hr/></div>
        </div>

        <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
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
                <div class="col-md-offset-2 col-md-6"><label>Análise do Parecerista</label><br/>
                    <select class="form-control" name="idStatusParecerista">
                        <option value="">Selecione..</option>
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
                    <textarea name="nota" class="form-control" rows="5" placeholder="Insira neste campo informações de notificações para o usuário."></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <?php echo "<input type='hidden' name='IDP' value='$idProjeto'>"; ?>
                    <input type="submit" name="gravarNota" class="btn btn-theme btn-md btn-block" value="Gravar">
                </div>
            </div>
        </form>

        <div class="col-md-offset-2 col-md-8">
            <ul class='list-group'>
                <li class='list-group-item list-group-item-success'>Notas</li>
                <?php
                    $sql = "SELECT * FROM notas WHERE idPessoa = '$idProjeto'";
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
        </div>

        <div class="form-group">
            <div class="col-md-offset-1 col-md-10">
                <div class="table-responsive list_info">
                    <h6>Solicitações do proponente</h6>
                    <?php listaAnexosProjetoSMC($idProjeto, 3, "smc_detalhes_projeto"); ?>
                </div>
            </div>
        </div>    

         <!-- Exibir arquivos -->
        <div class="form-group">
            <div class="col-md-12">
                <div class="table-responsive list_info">
                    <h6>Arquivo(s) Anexado(s)</h6>
                    <?php listaParecerSMC($idProjeto,9,"smc_detalhes_projeto"); ?>
                </div>  
            </div>
        </div>

       <!-- Upload do Arquivo -->
           <div class="form-group">
                <div class="col-md-offset-1 col-md-10">
                    <?php uploadArquivo($idProjeto,9, "smc_detalhes_projeto&idFF=$idProjeto", $idListaDocumento, 9); ?>
                </div>
           </div>         

        

        <!-- Confirmação de Exclusão -->
        <div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">
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
</div>