<?php

if (($pf['idNivelAcesso'] == 2) || ($pf['idNivelAcesso'] == 3))
{
    $parecerista = NULL;
}
else
{
    $parecerista = " AND idComissao = $idPf";
}
$etapas = [
    "Novos e com Solicitação de Alteração" => "7, 34",
    "com Complemento e Recurso" => "19, 24"];

$sqlProjetoVerificado = "SELECT idProjeto, nomeProjeto, protocolo,  idComissao, pro.envioComissao, pro.dataParecerista, pro.idStatus, pf.nome, pf.cpf, razaoSocial, cnpj, areaAtuacao, pro.publicado, pfc.nome AS comissao, etapaProjeto, pro.idEtapaProjeto AS idEtapaProjeto 
                    FROM projeto AS pro
                    LEFT JOIN pessoa_fisica AS pf ON pro.idPf = pf.idPf
                    LEFT JOIN pessoa_juridica AS pj ON pro.idPj = pj.idPj
                    INNER JOIN area_atuacao AS ar ON pro.idAreaAtuacao = ar.idArea
                    LEFT JOIN pessoa_fisica AS pfc ON pro.idComissao = pfc.idPf 
                    INNER JOIN etapa_projeto AS etapa ON pro.idEtapaProjeto = etapa.idEtapaProjeto
                    WHERE pro.idStatus != 6 AND pro.idEtapaProjeto IN (".implode(", ", $etapas).") $parecerista AND pro.verificadoComissao = '1'
                    ORDER BY pro.envioComissao ASC";
$queryProjetoVerificado = mysqli_query($con, $sqlProjetoVerificado);
$numVerificado = mysqli_num_rows($queryProjetoVerificado);

foreach ($etapas as $texto => $etapa) {
    $sqlProjeto = "SELECT idProjeto, nomeProjeto, protocolo,  idComissao, pro.envioComissao, pro.dataParecerista, pro.idStatus, pf.nome, pf.cpf, razaoSocial, cnpj, areaAtuacao, pro.publicado, pfc.nome AS comissao, etapaProjeto, pro.idEtapaProjeto AS idEtapaProjeto 
                    FROM projeto AS pro
                    LEFT JOIN pessoa_fisica AS pf ON pro.idPf = pf.idPf
                    LEFT JOIN pessoa_juridica AS pj ON pro.idPj = pj.idPj
                    INNER JOIN area_atuacao AS ar ON pro.idAreaAtuacao = ar.idArea
                    LEFT JOIN pessoa_fisica AS pfc ON pro.idComissao = pfc.idPf 
                    INNER JOIN etapa_projeto AS etapa ON pro.idEtapaProjeto = etapa.idEtapaProjeto
                    WHERE pro.idStatus != 6 AND pro.idEtapaProjeto IN ($etapa) $parecerista AND pro.verificadoComissao = '0'
                    ORDER BY pro.envioComissao ASC";
    $queryProjeto = mysqli_query($con, $sqlProjeto);
    $num = mysqli_num_rows($queryProjeto);
    ?>
    <div class="row">
        <div class="col-md-12">

            <div class='form-group'>
                <h5>Projetos <?= $texto ?> Encaminhados a Comissão</h5> <br>
                <span class="label label-warning">Total: <?=$num?></span>
            </div>

            <div class="table-responsive list_info">
                <?php
                if($num > 0)
                {
                ?>

                    <table class='table table-condensed'>
                        <thead>
                        <tr class='list_menu'>
                            <td>Encaminhado dia</td>
                            <td>Protocolo (nº ISP)</td>
                            <td>Nome do Projeto</td>
                            <td>Proponente</td>
                            <td>Documento</td>
                            <td>Área de Atuação</td>
                            <td>Parecerista</td>
                            <td>Projetos com Etapa</td>
                            <td>Ação</td>
                        </tr>
                        </thead>
                        <?php
                        $i = 0;
                        while ($campo = mysqli_fetch_array($queryProjeto))
                        {
                            $idComissao = $campo ['idComissao'];
                            $idProjeto = $campo['idProjeto'];

                            $dataEnvio = new DateTime ($campo['envioComissao']);
                            ?>
                            <tr>
                                <td class='list_description'><?= date_format($dataEnvio, "d/m/Y") ?></td>
                                <td class='list_description maskProtocolo' data-mask = "0000.00.00/0000000"><?= $campo['protocolo'] ?></td>
                                <td class='list_description'><?= $campo['nomeProjeto'] ?></td>
                                <td class='list_description'><?= isset($campo['nome']) ? $campo['nome'] : $campo['razaoSocial'] ?></td>
                                <td class='list_description'><?= isset($campo['cpf']) ? $campo['cpf'] : $campo['cnpj'] ?></td>
                                <td class='list_description'><?= mb_strimwidth($campo['areaAtuacao'], 0, 38, "...") ?></td>
                                <td class='list_description'><?=$campo['comissao']?></td>
                                <td> <?= recuperaDados('etapa_projeto', 'idEtapaProjeto', $campo['idEtapaProjeto'])['etapaProjeto'] ?> </td>
                                <td class='list_description'>
                                    <form method='POST'
                                          action='<?= ($pf['idNivelAcesso'] == 2) ? "?perfil=smc_detalhes_projeto" : "?perfil=comissao_detalhes_projeto" ?>'>
                                        <input type='hidden' name='idProjeto'
                                               value='<?= $campo['idProjeto'] ?>'/>
                                        <input type='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                    </form>
                                </td>
                            </tr>
                        <?php
                        $i++;
                        }
                    echo "</table>";
                }
                else
                {
                    echo "Não há resultado no momento.";
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}
?>
<div class="row">
    <div class="col-md-12">

        <div class='form-group'>
            <h5>Projetos já verificados e atribuídos à pareceristas</h5> <br>
            <span class="label label-warning">Total: <?=$numVerificado?></span>
        </div>

        <div class="table-responsive list_info">
            <?php
            if($numVerificado > 0)
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
                        <td>Projetos com Etapa</td>
                    </tr>
                    </thead>
                    <?php
                    $i = 0;
                    while ($campo = mysqli_fetch_array($queryProjetoVerificado))
                    {

                        $idComissao = $campo ['idComissao'];
                        $idProjeto = $campo['idProjeto'];

                        ?>
                        <tr>
                            <td class='list_description maskProtocolo' data-mask = "0000.00.00/0000000"><?= $campo['protocolo'] ?></td>
                            <td class='list_description'><?= $campo['nomeProjeto'] ?></td>
                            <td class='list_description'><?= isset($campo['nome']) ? $campo['nome'] : $campo['razaoSocial'] ?></td>
                            <td class='list_description'><?= isset($campo['cpf']) ? $campo['cpf'] : $campo['cnpj'] ?></td>
                            <td class='list_description'><?= mb_strimwidth($campo['areaAtuacao'], 0, 38, "...") ?></td>
                            <td class='list_description'><?=$campo['comissao']?></td>
                            <td> <?= recuperaDados('etapa_projeto', 'idEtapaProjeto', $campo['idEtapaProjeto'])['etapaProjeto'] ?> </td>
                        </tr>
                        <?php
                        $i++;
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
