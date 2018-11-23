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
                                <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
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
                <?php
                $etapas_envio_comissao = array(2,10,13,20,23,25,14,15);
                if(in_array($projeto['idEtapaProjeto'],$etapas_envio_comissao)) {
                    ?>
                    <!-- Botão Enviar pra Comissão -->
                    <div class="col-md-offset-1 col-md-4">
                        <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                            <input type='hidden' name='idProjeto' value='<?php echo $idProjeto ?>'>
                            <input type="submit" name="envioComissao" class="btn btn-theme btn-sm btn-block"
                                   value="Enviar projeto pra comissão">
                        </form>
                        Último envio: <?php echo exibirDataHoraBr($projeto['envioComissao']) ?>
                    </div>
                <?php
                }
                ?>
                <div class="col-md-3">
                </div>
                <!-- Botões Aprova/Reprova/Complemento -->
                <?php
                $etapas_finais = array(10,20,25,15);
                if(in_array($projeto['idEtapaProjeto'],$etapas_finais)){
                ?>
                    <div class="col-md-3">
                        <button class='btn btn btn-success btn-sm btn-block' style="border-radius: 10px;" type='button'
                                data-toggle='modal' data-target='#confirmAprovar'>Aprovar Projeto
                        </button>
                        <button class='btn btn btn-danger btn-sm btn-block' style="border-radius: 10px;" type='button'
                                data-toggle='modal' data-target='#confirmReprovar'>Reprovar Projeto
                        </button>
                        <?php
                        if ($projeto['idEtapaProjeto'] == 10) {
                            ?>
                            <button class='btn btn btn-inverse btn-sm btn-block' style="border-radius: 10px;" type='button'
                                    data-toggle='modal' data-target='#confirmComplemento'>Complemento de Informação
                            </button>
                            <?php
                        }
                        ?>
                    </div>
                <?php
                }
                ?>
                <!-- Confirmação de Aprovação -->
                <div class="modal fade" id="confirmAprovar" role="dialog" aria-labelledby="confirmAprovarLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id='aprovaProjeto' action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"><p>Aprovação de projeto</p></h4>
                                </div>
                                <div class="modal-body">
                                    <p><span style="color: red; "><strong>ATENÇÃO: Verifique se o Parecer está Aprovado!</strong></span></p>
                                    <p>Confirma a aprovação do projeto?</p>
                                </div>
                                <div class="modal-footer">
                                    <input type='hidden' name='idProjeto' value='<?php echo $idProjeto ?>'>
                                    <input type='hidden' name='idEtapaProjeto' value='<?= $projeto['idEtapaProjeto'] ?>'>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type='submit' class='btn btn-success btn-sm' style="border-radius: 10px;" name="aprovaProjeto">Confirmar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Fim Confirmação de Aprovação -->
                <!-- Confirmação de Reprovação -->
                <div class="modal fade" id="confirmReprovar" role="dialog" aria-labelledby="confirmReprovarLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id='reprovaProjeto' action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"><p>Reprovação de projeto</p></h4>
                                </div>
                                <div class="modal-body">
                                    <p><span style="color: red; "><strong>ATENÇÃO: Verifique se o Parecer está Aprovado!</strong></span></p>
                                    <p>Confirma a reprovação do projeto?</p>
                                </div>
                                <div class="modal-footer">
                                    <input type='hidden' name='idProjeto' value='<?php echo $idProjeto ?>'>
                                    <input type='hidden' name='idEtapaProjeto' value='<?= $projeto['idEtapaProjeto'] ?>'>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type='submit' class='btn btn-success btn-sm' style="border-radius: 10px;" name="reprovaProjeto">Confirmar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Fim Confirmação de Reprovação -->
                <!-- Confirmação de Complemento -->
                <div class="modal fade" id="confirmComplemento" role="dialog" aria-labelledby="confirmComplementoLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" id='reprovaProjeto' action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title"><p>Complemento de informações do projeto</p></h4>
                                </div>
                                <div class="modal-body">
                                    <p><span style="color: red; "><strong>ATENÇÃO: Verifique se o Parecer está Aprovado!</strong></span></p>
                                    <p>Confirma a solicitação de complemento de informações do projeto?</p>
                                </div>
                                <div class="modal-footer">
                                    <input type='hidden' name='idProjeto' value='<?php echo $idProjeto ?>'>
                                    <input type='hidden' name='idEtapaProjeto' value='<?= $projeto['idEtapaProjeto'] ?>'>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <button type='submit' class='btn btn-inverse btn-sm' style="border-radius: 10px;" name="complementaProjeto">Confirmar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Fim Confirmação de Complemento -->
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