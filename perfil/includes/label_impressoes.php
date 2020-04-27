<div role="tabpanel" class="tab-pane fade" id="impressoes" align="left">
    <div class="col-md-offset-2 col-md-8">
        <li class="list-group-item list-group-item-success">
            <div style="text-align: center;"><b>Impressões</b></div>
        </li>
        <table class="table table-bordered">
            <tr>
                <td>
                    <strong>Protocolo de Comparecimento</strong>
                </td>
                <td>
                    <form method="POST" target="_blank" action="../pdf/pdf_protocolo_comparecimento.php"
                          class="form-horizontal" role="form">
                        <button type="submit" style="border-radius: 5px;" class="btn btn-theme btn-sm btn-block"
                                name="idProjeto" value="<?= $idProjeto ?>">Abrir
                        </button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Autorização de Captação</strong>
                </td>
                <td>
                    <form method="POST" target="_blank" action="../pdf/pdf_autorizacao_captacao.php"
                          class="form-horizontal" role="form">
                        <button type="submit" style="border-radius: 5px;" class="btn btn-theme btn-sm btn-block"
                                name="idProjeto" value="<?= $idProjeto ?>">Abrir
                        </button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Ofício de Abertura de Conta</strong>
                </td>
                <td>
                    <form method="POST" target="_blank" action="../pdf/pdf_abertura_conta.php" class="form-horizontal"
                          role="form">
                        <button type="submit" style="border-radius: 5px;" class="btn btn-theme btn-sm btn-block"
                                name="idProjeto" value="<?= $idProjeto ?>">Abrir
                        </button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Autorização Única de Depósito</strong>
                </td>
                <td>
                    <form method="get" target="_blank" action="../pdf/autorizacao_unica_deposito.doc" class="form-horizontal"
                          role="form">
                        <button type="submit" style="border-radius: 5px;" class="btn btn-theme btn-sm btn-block"
                                name="idProjeto">Abrir
                        </button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Certificado de Incentivo</strong>
                </td>
                <td>
                    <form method="get" target="_blank" action="../pdf/Certificado_Incetivo.doc" class="form-horizontal"
                          role="form">
                        <button type="submit" style="border-radius: 5px;" class="btn btn-theme btn-sm btn-block"
                                name="idProjeto">Abrir
                        </button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Contrato de Incentivo</strong>
                </td>
                <td>
                    <form method="get" target="_blank" action="../pdf/Contrato_incentivo.docx" class="form-horizontal"
                          role="form">
                        <button type="submit" style="border-radius: 5px;" class="btn btn-theme btn-sm btn-block"
                                name="idProjeto">Abrir
                        </button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Termo de Responsabilidade de Execução de Projeto Cultural</strong>
                </td>
                <td>
                    <form method="get" target="_blank"
                          action="../pdf/termo_responsabilidade_execucao_projeto_cultural.docx" class="form-horizontal"
                          role="form">
                        <button type="submit" style="border-radius: 5px;" class="btn btn-theme btn-sm btn-block"
                                name="idProjeto">Abrir
                        </button>
                    </form>
                </td>
            </tr>
        </table>
    </div>
</div>