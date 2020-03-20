<?php
$array_etapa = array(7, 10, 15, 19, 20, 24, 25, 34); //status
foreach ($array_etapa as $idEtapa)
{
    $sqlStatus = "SELECT idEtapaProjeto, etapaProjeto, ordem FROM etapa_projeto WHERE idEtapaProjeto = '$idEtapa'";
    $sqlHistorico = "SELECT
                         hr.idProjeto,
                         p.protocolo,
                         p.nomeProjeto,
                         p.idEtapaProjeto,
                         s.etapaProjeto,
                         pf.nome AS 'parecerista',
                         hr.dataReuniao,
                         hr.data AS 'dataRegistro'
                        FROM historico_reuniao AS hr
                         INNER JOIN projeto AS p ON p.idProjeto = hr.idProjeto
                         INNER JOIN etapa_projeto AS s ON s.idEtapaProjeto = p.idEtapaProjeto
                         INNER JOIN pessoa_fisica AS pf ON pf.idPf = hr.idComissao
                        WHERE hr.idComissao = ".$_POST['idComissao']."
                        AND p.idEtapaProjeto = '$idEtapa'";
    $queryHistorico = mysqli_query($con,$sqlHistorico);
    $queryStatus = mysqli_query($con,$sqlStatus);
    $num = mysqli_num_rows($queryHistorico);

    foreach ($queryStatus as $etapa)
    {
        $i = 0;
        ?>
        <div class='form-group'>
            <h5>Projetos com Etapa "<?=$etapa['etapaProjeto']?>"</h5>
            <form method="POST" action="<?= ($usuario['idNivelAcesso'] == 2) ? "?perfil=smc_pesquisa_geral_resultado" : "?perfil=comissao_pesquisa_resultado"?>" class="form-horizontal" role="form">
                <button type="submit" class="label label-warning" name="idStatus" value="<?=$etapa['idEtapaProjeto']?>">
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
                            <td>Status</td>
                            <td>Parecerista</td>
                            <td>Data da Reunião</td>
                            <td>Data de Registro</td>
                            <td width='10%'></td>
                        </tr>
                        </thead>
                        <?php
                        while ($campo = mysqli_fetch_array($queryHistorico))
                        {

                            if ($i < 15) {
                                ?>
                                <tr>
                                    <td class='list_description' data-mask = "0000.00.00/0000000"><?= $campo['protocolo'] ?></td>
                                    <td class='list_description'><?= $campo['nomeProjeto'] ?></td>
                                    <td class='list_description'><?= $campo['etapaProjeto'] ?></td>
                                    <td class='list_description'><?= $campo['parecerista'] ?></td>
                                    <td class='list_description'>
                                        <?php
                                        if ($campo['dataReuniao'] == "0000-00-00")
                                        {
                                            echo "Data não Registrada";
                                        }
                                        else
                                        {
                                            echo date_format(date_create($campo['dataReuniao']), 'd/m/Y');
                                        }
                                        ?>
                                    </td>
                                    <td class='list_description'><?= date_format(date_create($campo['dataRegistro']), 'd/m/Y') ?></td>
                                        <td class='list_description'>
                                            <form method='POST' action='<?= ($usuario['idNivelAcesso'] == 2) ? "?perfil=smc_detalhes_projeto" : "?perfil=comissao_detalhes_projeto"?>'>
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