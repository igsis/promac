<div role="tabpanel" class="tab-pane fade" id="status">
    <div class="form-group">
        <h5>
            <?php if(isset($mensagem)){echo $mensagem;}; ?>
        </h5>


        <div class="row">
            <div class="form-group">
                <div class="col-md-offset-1 col-md-2">
                    <label>ATUAL:</label>
                </div>
                <div class="col-md-4">
                    <label>Etapa:</label> <?= $etapa['etapaProjeto'] ?>
                </div>
                <div class="col-md-4">
                    <label>Status:</label> <?= $status['status'] ?>
                </div>
            </div>
        </div>

        <hr/>

        <h6>Alterar para:</h6>
        <div class="form-group">
            <form method="POST" id='cancelarProjeto' action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                <label>Etapa:</label>
                <select class="form-control" name="idEtapa" required>
                    <option value="">Selecione...</option>
                    <?php echo geraOpcao("etapa_projeto","") ?>
                </select>
                <div class="modal-footer">
                    <input type='hidden' name='idProjeto' value='<?php echo $idProjeto ?>'>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Voltar</button>
                    <button type='submit' class='btn btn-danger btn-sm' style="border-radius: 10px;" name="cancelarProjeto">Confirmar</button>
                </div>
            </form>
        </div>

    </div>
</div>