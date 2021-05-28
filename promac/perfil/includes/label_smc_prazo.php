<div role="tabpanel" class="tab-pane fade" id="prazo">
    <form method="POST" action="?perfil=smc_detalhes_projeto" class="form-horizontal" role="form">
            <h5>
                <?php if(isset($mensagem)){echo $mensagem;}; ?>
            </h5>
        <div class="form-group">
            <div class="col-md-offset-2 col-md-8"><br/>
            </div>
        </div>
        
<div class="form-group">
         <div class="col-md-offset-2 col-md-3">
            <label>Data inicial de Captação</label><br/>
            <input type="text" name="prazoCaptacao" id="datepicker01" class="form-control" value="<?php 
             if(returnEmptyDate('prazoCaptacao', $idProjeto) > 0 ) 
                 { $var = strtotime(returnEmptyDate('prazoCaptacao', $idProjeto));
                        echo date(" d ",$var) . "/ ";
                        echo date("m ",$var) . "/ ";
                        echo date("Y ",$var); 
                 }
             else{
                    echo "00/00/0000 ";
                 }?>">
        </div>

    <div class="col-md-2"><label>Prorrogação</label><br/>
        <select class="form-control" name="prorrogacaoCaptacao" value="">
            <option value="<?php echo $prazos['prorrogacaoCaptacao'] ?>" selected >
              <?php
                    if($prazos['prorrogacaoCaptacao'] == 1)
                        { 
                            echo "Sim"; 
                        }
                        else 
                            { 
                                echo "Não"; 
                            }
                ?>
            </option>
            <option value="0">Não</option>
            <option value="1">Sim</option>
        </select>
    </div>

    <div class="col-md-3">
        <label>Data Final da Captação</label>
            <input type="text" name="finalCaptacao" id="datepicker02" class="form-control" value="<?php 
            if(returnEmptyDate('finalCaptacao', $idProjeto) > 0 )
                { 
                    $var = strtotime(returnEmptyDate('finalCaptacao', $idProjeto));
                    echo date(" d ",$var) . "/ ";
                    echo date("m ",$var) . "/ ";
                    echo date("Y ",$var); } 
            else
                {
                    echo "00/00/0000 ";
                } ?>">
    </div>
</div>

    <div class="form-group">
        <div class="col-md-offset-2 col-md-6"><label>Início da execução do projeto</label>
            <input type="text" name="inicioExecucao" id="datepicker03" class="form-control" value="<?php if(returnEmptyDate('inicioExecucao', $idProjeto) > 0 ){ $var = strtotime(returnEmptyDate('inicioExecucao', $idProjeto));
                echo date(" d ",$var) . "/ ";
                echo date("m ",$var) . "/ ";
                echo date("Y ",$var); } 
                else
                {
                    echo "00/00/0000 ";
                } ?>">
        </div>
        <div class="col-md-6"><label>Fim da execução do projeto</label>
            <input type="text" name="fimExecucao" id="datepicker04" class="form-control" value="<?php
                if(returnEmptyDate('fimExecucao', $idProjeto) > 0 ){ $var = strtotime(returnEmptyDate('fimExecucao', $idProjeto));
                    echo date(" d ",$var) . "/ ";
                    echo date("m ",$var) . "/ ";
                    echo date("Y ",$var);} 
                    else
                    {
                        echo "00/00/0000 ";
                    } ?>">
        </div>
    </div>

<div class="form-group">
    <div class="col-md-offset-2 col-md-2">
            <label>Prorrogação</label><br/>
    <select class="form-control" name="prorrogacaoExecucao">
         <option value="<?php echo $prazos['prorrogacaoExecucao'] ?>" selected >
            <?php
            if($prazos['prorrogacaoExecucao'] == 1)
                { 
                    echo "Sim"; 
                }
            else 
                 { 
                     echo "Não"; 
                 }
        ?>
        </option>
             <option value="0">Não</option>
             <option value="1">Sim</option>
    </select>
    </div>
            <?php
            if($prazos['prorrogacaoExecucao'] == 1)
                {
            ?>
            <div class="col-md-3">
                <label>Data final do projeto</label>
                    <input type="text" name="finalProjeto" id="datepicker05" class="form-control" value="<?php
                        if(returnEmptyDate('finalProjeto', $idProjeto) > 0 )
                        {
                            $var = strtotime(returnEmptyDate('finalProjeto', $idProjeto));
                            echo date(" d ",$var) . "/ ";
                            echo date("m ",$var) . "/ ";
                            echo date("Y ",$var);
                        } 
                        else
                        {
                            echo "00/00/0000 ";
                        } ?>">
            </div>
            <?php 
                }
                else
                    {
                        ?>
            <div class="col-md-3">
                <label>Data final do projeto</label><br/>
                    <i>Não há prorrogração</i>
            </div>
                <?php
                    }
                        ?>
             <div class="col-md-3">
                <label>Data para prestar contas</label>
                <input type="text" name="prestarContas" id="datepicker06" class="form-control" value="<?php if(returnEmptyDate('prestarContas', $idProjeto) > 0 ){ $var = strtotime(returnEmptyDate('prestarContas', $idProjeto)); echo date(" d ",$var) . "/ "; echo date("m ",$var) . "/ "; echo date("Y ",$var); } 
                else
                {
                    echo "00/00/0000 ";
                } ?>">
             </div>
</div>
            <div class="form-group">
                <div class="col-md-offset-2 col-md-8">
                    <?php
                        echo "<input type='hidden' name='IDP' value='$idProjeto'>"; 
                    ?>
            <input type="submit" name="gravarPrazos" class="btn btn-theme btn-lg btn-block" value="Gravar">
                </div>
            </div>
     </form>
</div>