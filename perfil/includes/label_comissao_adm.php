<div role="tabpanel" class="tab-pane fade in active" id="adm">
    <div class="form-group">
        <div class="col-md-offset-1 col-md-10"></div>
    </div>
    <!-- Diretor da Comissão -->
    <?php
    $direcao = recuperaDados("pessoa_fisica", "idPf", $_SESSION['idUser']);
    if ($direcao['idNivelAcesso'] == 3) {
        ?>
        <form class="form-horizontal" role="form" action="?perfil=comissao_detalhes_projeto" method="post">
            <div class="form-group">
                <div class="col-md-offset-2 col-md-5"><strong>Parecerista responsável no Setor de
                        Comissão:</strong><br/>
                    <select class="form-control" name="idComissao" id="">
                        <?php
                        $temParecerista = 0;
                        if ($projeto['idComissao'] != NULL) {
                            $pfParecer = recuperaDados("pessoa_fisica", "idPf", $projeto['idComissao']);
                            $temParecerista = 1;
                        } ?>

                        <option value="<?php echo $projeto['idComissao']; ?>" select="disable" selected
                                hidden><?php echo $pfParecer['nome']; ?></option>

                        <?php geraOpcaoComissao($temParecerista); ?>
                    </select>
                </div>
                <div class="col-md-3"><br/>
                    <input type="hidden" name="idProjeto" value="<?php echo $idProjeto; ?>"/>
                    <input type="submit" class="btn btn-theme  btn-block" value="Atualizar responsável"
                           name="atualizaResponsavel">
                </div>
            </div>
        </form>
        <?php
    }
    ?>
    <form method="POST" action="?perfil=comissao_detalhes_projeto" class="form-horizontal" role="form">
        <div class="form-group">
            <?php
            if ($projeto['idStatusParecerista'] != '0' AND $projeto['dataReuniao'] != '0000-00-00') {
                ?>
                <div class="col-md-offset-2 col-md-6" align="right"><br/><label>Finalizar projeto e enviar à SMC?</label><br>
                    <?php echo exibirDataHoraBr($projeto['finalizacaoComissao']) ?>
                </div>
                <div class="col-md-2"><br/>
                    <form id='finalizacaoComissao' method='POST' action='?perfil=comissao_detalhes_projeto'>
                        <input name='finalizaComissao' type='hidden'>
                        <input type='hidden' name='IDP' value='<?= $idProjeto ?>'>
                        <button class='btn btn-theme' type='button' data-toggle='modal' data-target='#confirmApagar' data-title='Confirmação de envio' data-message='Deseja realmente finalizar e enviar à SMC?'>SIM</button>
                        </td>
                    </form>
                </div>
                <?php
            }
            else{
            ?>
                <div class="col-md-offset-2 col-md-8"><span style="color: #ff0000; "> <i>Insira todas as informações antes de encaminhar à SMC.</i></span></div>
                <?php
            }
            ?>
        </div>
    </form>

    <form method="POST" action="?perfil=comissao_detalhes_projeto" class="form-horizontal" role="form">
        <h5>
            <?php if (isset($mensagem)) {echo $mensagem;}; ?>
        </h5>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-4"><label>Valor Aprovado *</label><br/>
                <input type="text" name="valorAprovado" id='valor' required class="form-control"
                       value="<?php echo dinheiroParaBr($projeto['valorAprovado']) ?>">
            </div>
            <div class="col-md-4"><label>Valor da Renúncia *</label><br/>
                <select class="form-control" name="idRenunciaFiscal" required>
                    <option value="">Selecione...</option>
                    <?php echo geraOpcao("renuncia_fiscal", $projeto['idRenunciaFiscal']) ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-4"><label>Análise do Parecerista *</label><br/>
                <select class="form-control" name="idStatusParecerista" required>
                    <option value="">Selecione...</option>
                    <?php echo geraOpcao("status_parecerista", $projeto['idStatusParecerista']) ?>
                </select>
            </div>
            <div class="col-md-4"><label>Data da Reunião *</label>
                <input type="text" name="dataReuniao" id='datepicker08' class="form-control" required
                       value="<?php echo exibirDataBr($projeto['dataReuniao']) ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
                <input type="hidden" name="idStatus" value="<?= $projeto['idStatus'] ?>">
                <input type="hidden" name="idProjeto" value="<?php echo $idProjeto ?>">
                <input type="submit" name="gravarAdm" class="btn btn-theme btn-md btn-block" value="Gravar">
            </div>
        </div>
    </form>

    <div class="form-group">
        <div class="col-md-offset-1 col-md-10">
            <hr/>
        </div>
    </div>

    <!-- Exibir arquivos -->
    <?php
    switch ($idStatus) {
        case 7: //Projeto enviado à Comissão
            $idArquivo = 0;
            $idListaDocumento = 37;
            break;
        case 19: //Complemento enviado à Comissão
            $idArquivo = 46;
            $idListaDocumento = 49;
            break;
        case 24: //Recurso encaminhado à Comissão
            $idArquivo = 52;
            $idListaDocumento = 50;
            break;
        case 30: //Complementação de recurso encaminhado à Comissão
            $idArquivo = 53;
            $idListaDocumento = 51;
            break;
        case 34: //Solicitação de alteração encaminhada à Comissão
            $idArquivo = 47;
            $idListaDocumento = 48;
            break;
        /*
        * Default provisório até descobrir qual status não está aparecendo o botão
        */
        default:
            $idArquivo = 0;
            $idListaDocumento = 37;
            break;
        /*
        default:
        $idArquivo = 0;
        $idListaDocumento = 0;
        break;*/
    }
    ?>
    <div class="form-group">
        <div class="col-md-offset-1 col-md-10">
            <div class="table-responsive list_info">
                <h6>Solicitações do proponente</h6>
                <?php listaAnexosProjeto($idProjeto, 3, $idArquivo); ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-offset-1 col-md-10">
            <?php uploadArquivo($idProjeto, 9, "comissao_detalhes_projeto", $idListaDocumento, 9); ?>
        </div>
    </div>

    <!-- Confirmação de Exclusão -->
    <div class="modal fade" id="confirmApagar" role="dialog"
         aria-labelledby="confirmApagarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;
                    </button>
                    <h4 class="modal-title"><p>Confirma?</p></h4>
                </div>
                <div class="modal-body">
                    <p>Confirma?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-danger" id="confirm">Confirmar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim Confirmação de Exclusão -->


    <div class="form-group">
        <div class="col-md-offset-1 col-md-10">
            <hr/>
        </div>
    </div>

    <form method="POST" action="?perfil=comissao_detalhes_projeto" class="form-horizontal" role="form">
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8"><label>Notas</label><br/>
                <textarea name="nota" class="form-control" rows="10"
                          placeholder="Insira neste campo informações de notificações para o usuário."></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-8">
                <input type="submit" name="gravarNota" class="btn btn-theme btn-md btn-block" value="Gravar">
            </div>
        </div>
    </form>
    <ul class='list-group'>
        <div class="col-md-offset-2 col-md-8">
            <li class='list-group-item list-group-item-success'>Notas
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
            </li>
        </div>
    </ul>
</div>