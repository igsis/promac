<div role="tabpanel" class="tab-pane fade" id="impressoes" align="left">
    <div class="col-md-offset-2 col-md-8">
        <li class="list-group-item list-group-item-success">
            <div style="text-align: center;"><b>Impressões</b></div>
        </li>
        <table class="table table-bordered">
            <tr>
                <td>
                    <strong>Termo de Responsabilidade de Realização de Projeto Cultural</strong>
                </td>
                <td width="15%">
                    <form method="POST" target="_blank" action="../pdf/pdf_termo_responsabilidade_realizacao.php" class="form-horizontal" role="form">
                        <button type="submit" style="border-radius: 5px;" class="btn btn-theme btn-sm btn-block" name="idProjeto" value="<?= $idProjeto ?>">Abrir</button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Certificado de Captação</strong>
                </td>
                <td>
                    <form method="POST" target="_blank" action="../pdf/pdf_certificado_captacao.php" class="form-horizontal" role="form">
                        <button type="submit" style="border-radius: 5px;" class="btn btn-theme btn-sm btn-block" name="idProjeto" value="<?= $idProjeto ?>">Abrir</button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Ofício Banco do Brasil</strong>
                </td>
                <td>
                    <form method="POST" target="_blank" action="../pdf/pdf_oficio_bb.php" class="form-horizontal" role="form">
                        <button type="submit" style="border-radius: 5px;" class="btn btn-theme btn-sm btn-block" name="idProjeto" value="<?= $idProjeto ?>">Abrir</button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Prorrogação de Captação</strong>
                </td>
                <td>
                    <form method="POST" target="_blank" action="../pdf/pdf_prorrogacao_captacao.php" class="form-horizontal" role="form">
                        <button type="submit" style="border-radius: 5px;" class="btn btn-theme btn-sm btn-block" name="idProjeto" value="<?= $idProjeto ?>">Abrir</button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Protocolo de Comparecimento</strong>
                </td>
                <td>
                    <form method="POST" target="_blank" action="../pdf/pdf_protocolo_comparecimento.php" class="form-horizontal" role="form">
                        <button type="submit" style="border-radius: 5px;" class="btn btn-theme btn-sm btn-block" name="idProjeto" value="<?= $idProjeto ?>">Abrir</button>
                    </form>
                </td>
            </tr>
        </table>
    </div>
</div>