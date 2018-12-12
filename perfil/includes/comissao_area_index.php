<?php

$array_etapa = array(7, 19, 24, 34); //etapa
foreach ($array_etapa as $idEtapaProjeto)
{
    $sqlEtapaProjeto = "SELECT idEtapaProjeto, etapaProjeto, ordem FROM etapa_projeto WHERE idEtapaProjeto = '$idEtapaProjeto'";
    if (($pf['idNivelAcesso'] == 2) || ($pf['idNivelAcesso'] == 3))
    {
        $parecerista = NULL;
    }
    else
    {
        $parecerista = " AND idComissao = $idPf";
    }
    $sqlProjeto = "SELECT idProjeto, nomeProjeto, protocolo,  idComissao, pro.dataParecerista,pro.idStatus, pf.nome, pf.cpf, razaoSocial, cnpj, areaAtuacao, pro.publicado, pfc.nome AS comissao, etapaProjeto, pro.idEtapaProjeto AS idEtapaProjeto 
                    FROM projeto AS pro
                    LEFT JOIN pessoa_fisica AS pf ON pro.idPf = pf.idPf
                    LEFT JOIN pessoa_juridica AS pj ON pro.idPj = pj.idPj
                    INNER JOIN area_atuacao AS ar ON pro.idAreaAtuacao = ar.idArea
                    LEFT JOIN pessoa_fisica AS pfc ON pro.idComissao = pfc.idPf 
                    INNER JOIN etapa_projeto AS etapa ON pro.idEtapaProjeto = etapa.idEtapaProjeto
                    WHERE pro.idEtapaProjeto = '$idEtapaProjeto'" .$parecerista." ORDER BY protocolo";
    $queryProjeto = mysqli_query($con,$sqlProjeto);
    $queryEtapaProjeto = mysqli_query($con,$sqlEtapaProjeto);
    $num = mysqli_num_rows($queryProjeto);

    foreach ($queryEtapaProjeto as $etapa_projeto)
    {
        $i = 0;
        ?>
        <div class='form-group'>
            <h5>Projetos com Etapa "<?=$etapa_projeto['etapaProjeto']?>"</h5>
            <form method="POST" action="<?= ($pf['idNivelAcesso'] == 2) ? "?perfil=smc_pesquisa_geral_resultado" : "?perfil=comissao_pesquisa_resultado"?>" class="form-horizontal" role="form">
                <button type="submit" class="label label-warning" name="idEtapaProjeto" value="<?=$etapa_projeto['idEtapaProjeto']?>">
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
                            <?=($etapa_projeto['idEtapaProjeto'] == 7 || $etapa_projeto['idEtapaProjeto'] == 19 || $etapa_projeto['idEtapaProjeto'] == 24 || $etapa_projeto['idEtapaProjeto'] == 34) ? "<td>Parecerista atribuido à</td>" : "<td></td>" ?>
                            <td width='10%'></td>
                        </tr>
                        </thead>
                        <?php
                        while ($campo = mysqli_fetch_array($queryProjeto))
                        {
                            $idComissao = $campo ['idComissao'];
                            $idProjeto = $campo['idProjeto'];

                            if (($idComissao != 0) && ($campo['dataParecerista'] != "0000-00-00")) {

                                $dataParecerista = new DateTime($campo['dataParecerista']);
                                $dateNow = new DateTime();
                                $diff = $dataParecerista->diff($dateNow);

                                if ($diff->days >= 30){

                                    $limite = 1;

                                } else {

                                    $limite = 0;

                                }

                            }
                            else
                            {
                                $limite = 0;
                            }

                            if ($i < 15) {

                                if ($campo['idStatus'] == 6) {

                                    echo "<tr style='background: #c3c3c3'>";

                                } elseif(isset($limite) && $limite == 1) {

                                    echo "<tr class='danger'>";

                                } else {

                                    echo "<tr>";

                                }

                                ?>

                                    <td class='list_description maskProtocolo' data-mask = "0000.00.00/0000000"><?= $campo['protocolo'] ?></td>
                                    <td class='list_description'><?= $campo['nomeProjeto'] ?></td>
                                    <td class='list_description'><?= isset($campo['nome']) ? $campo['nome'] : $campo['razaoSocial'] ?></td>
                                    <td class='list_description'><?= isset($campo['cpf']) ? $campo['cpf'] : $campo['cnpj'] ?></td>
                                    <td class='list_description'><?= mb_strimwidth($campo['areaAtuacao'], 0, 38, "...") ?></td>
                                    <td class='list_description'><?=$campo['comissao']?></td>
                                    <?= ($campo['dataParecerista'] != 0) ? "<td class='list_description'>".$diff->format("%a dias")."</td>" : "<td class='list_description'></td>" ?>
                                    <?php
                                    if ($campo['idStatus'] != 6) {
                                        ?>
                                        <td class='list_description'>
                                            <form method='POST'
                                                  action='<?= ($pf['idNivelAcesso'] == 2) ? "?perfil=smc_detalhes_projeto" : "?perfil=comissao_detalhes_projeto" ?>'>
                                                <input type='hidden' name='idProjeto'
                                                       value='<?= $campo['idProjeto'] ?>'/>
                                                <input type='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                            </form>
                                        </td>
                                        <?php
                                    }else{
                                        echo "<td colspan='2' style='color: #942a25;text-align: center;font-weight: bold'>Cancelado </td>";
                                    }
                                    ?>
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