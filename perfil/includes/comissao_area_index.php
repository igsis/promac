<?php
$array_status = array(7, 19, 24, 34); //status
foreach ($array_status as $idStatus)
{
    $sqlStatus = "SELECT idEtapaProjeto, etapaProjeto, ordem FROM etapa_projeto WHERE idEtapaProjeto = '$idStatus'";
    if (($pf['idNivelAcesso'] == 2) || ($pf['idNivelAcesso'] == 3))
    {
        $parecerista = NULL;
    }
    else
    {
        $parecerista = " AND idComissao = $idPf";
    }
    $sqlProjeto = "SELECT idProjeto, nomeProjeto, protocolo, pf.nome, pf.cpf, razaoSocial, cnpj, areaAtuacao, pfc.nome AS comissao, etapaProjeto, pro.idEtapaProjeto AS idEtapaProjeto 
                    FROM projeto AS pro
                    LEFT JOIN pessoa_fisica AS pf ON pro.idPf = pf.idPf
                    LEFT JOIN pessoa_juridica AS pj ON pro.idPj = pj.idPj
                    INNER JOIN area_atuacao AS ar ON pro.idAreaAtuacao = ar.idArea
                    LEFT JOIN pessoa_fisica AS pfc ON pro.idComissao = pfc.idPf 
                    INNER JOIN etapa_projeto AS st ON pro.idEtapaProjeto = st.idEtapaProjeto
                    WHERE pro.publicado = 1 AND pro.idEtapaProjeto = '$idStatus'" .$parecerista." ORDER BY idProjeto DESC";
    $queryProjeto = mysqli_query($con,$sqlProjeto);
    $queryStatus = mysqli_query($con,$sqlStatus);
    $num = mysqli_num_rows($queryProjeto);

    foreach ($queryStatus as $status)
    {
        $i = 0;
        ?>
        <div class='form-group'>
            <h5>Projetos com Status "<?=$status['status']?>"</h5>
            <form method="POST" action="<?= ($pf['idNivelAcesso'] == 2) ? "?perfil=smc_pesquisa_geral_resultado" : "?perfil=comissao_pesquisa_resultado"?>" class="form-horizontal" role="form">
                <button type="submit" class="label label-warning" name="idEtapaProjeto" value="<?=$status['idEtapaProjeto']?>">
                    <span>Total: <?=$num?></span>
                </button>
            </form>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="table-responsive list_info">
                    <?php
                    if($num > 0)
                    {
                    ?>

                    <table class='table table-condensed'>
                        <thead>
                        <tr class='list_menu'>
                            <td>Protocolo (nº ISP)</td>
                            <td>Nome do Projeto</td>
                            <td>Proponente</td>
                            <td>Documento</td>
                            <td>Área de Atuação</td>
                            <td>Parecerista</td>
                            <td width='10%'></td>
                        </tr>
                        </thead>
                        <?php
                        while ($campo = mysqli_fetch_array($queryProjeto))
                        {

                            if ($i < 15) {
                                ?>
                                <tr>
                                    <td class='list_description'><?= $campo['protocolo'] ?></td>
                                    <td class='list_description'><?= $campo['nomeProjeto'] ?></td>
                                    <td class='list_description'><?= isset($campo['nome']) ? $campo['nome'] : $campo['razaoSocial'] ?></td>
                                    <td class='list_description'><?= isset($campo['cpf']) ? $campo['cpf'] : $campo['cnpj'] ?></td>
                                    <td class='list_description'><?= mb_strimwidth($campo['areaAtuacao'], 0, 38, "...") ?></td>
                                    <td class='list_description'><?=$campo['comissao']?></td>
                                        <td class='list_description'>
                                            <form method='POST' action='<?= ($pf['idNivelAcesso'] == 2) ? "?perfil=smc_detalhes_projeto" : "?perfil=comissao_detalhes_projeto"?>'>
                                                <input type='hidden' name='idProjeto'
                                                       value='<?= $campo['idProjeto'] ?>'/>
                                                <input type='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                            </form>
                                        </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        }
                        }
                        else
                        {
                            echo "Não há resultado no momento.";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }
}
?>