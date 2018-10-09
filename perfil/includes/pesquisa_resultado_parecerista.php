<?php
$array_status = array(7, 10, 15, 19, 20, 24, 25, 34); //status
foreach ($array_status as $idStatus)
{
    $sqlStatus = "SELECT idStatus, status, ordem FROM status WHERE idStatus = '$idStatus'";
    $sqlHistorico = "SELECT
                         hr.idProjeto,
                         p.protocolo,
                         p.nomeProjeto,
                         hr.idStatus,
                         s.status,
                         pf.nome AS 'parecerista',
                         hr.dataReuniao,
                         hr.data AS 'dataRegistro'
                        FROM historico_reuniao AS hr
                         INNER JOIN projeto AS p ON p.idProjeto = hr.idProjeto
                         INNER JOIN status AS s ON s.idStatus = hr.idStatus
                         INNER JOIN pessoa_fisica AS pf ON pf.idPf = hr.idComissao
                        WHERE hr.idComissao = ".$_POST['idComissao']."
                        AND hr.idStatus = '$idStatus'";
    $queryHistorico = mysqli_query($con,$sqlHistorico);
    $queryStatus = mysqli_query($con,$sqlStatus);
    $num = mysqli_num_rows($queryHistorico);

    foreach ($queryStatus as $status)
    {
        $i = 0;
        ?>
        <div class='form-group'>
            <h5>Projetos com Status "<?=$status['status']?>"</h5>
            <form method="POST" action="<?= ($pf['idNivelAcesso'] == 2) ? "?perfil=smc_pesquisa_geral_resultado" : "?perfil=comissao_pesquisa_resultado"?>" class="form-horizontal" role="form">
                <button type="submit" class="label label-warning" name="idStatus" value="<?=$status['idStatus']?>">
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
                                    <td class='list_description'><?= $campo['protocolo'] ?></td>
                                    <td class='list_description'><?= $campo['nomeProjeto'] ?></td>
                                    <td class='list_description'><?= $campo['status'] ?></td>
                                    <td class='list_description'><?= $campo['parecerista'] ?></td>
                                    <td class='list_description'><?= date_create_from_format('d/m/Y', $campo['dataReuniao']) ?></td>
                                    <td class='list_description'><?= date_create_from_format('d/m/Y', $campo['dataRegistro']) ?></td>
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