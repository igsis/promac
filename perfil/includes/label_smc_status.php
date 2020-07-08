<div role="tabpanel" class="tab-pane fade" id="status">
    <div class="form-group">
        <h5>
            <?php if(isset($mensagem)){echo $mensagem;}; ?>
        </h5>

        <div class="row">
            <div class="form-group">
                <div class="col-md-offset-1 col-md-2">
                    <h6>ATUAL:</h6>
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

        <div class="form-group">
            <div class="col-md-offset-1 col-md-3">
                <h6>ALTERAR PARA:</h6>
            </div>
            <form method="POST" id='alteraStatus' action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
                <div class="col-md-5">
                    <select class="form-control" name="idEtapa" required>
                        <option value="">Selecione uma etapa</option>
                        <?php
                        $query = $con->query("SELECT * FROM etapa_projeto ORDER BY ordem");
                        while ($option = mysqli_fetch_row($query)) {
                            echo "<option value='" . $option[0] . "'>" . $option[1] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type='hidden' name='idProjeto' value='<?php echo $idProjeto ?>'>
                    <button type='submit' class='btn btn-danger btn-sm' style="border-radius: 10px;" name="alteraStatus">Confirmar</button>
                </div>
            </form>
        </div>

    </div>
</div>