<div role="tabpanel" class="tab-pane fade" id="historico">
    <br/>
    <ul class='list-group'>
        <li class='list-group-item list-group-item-success'><strong>HISTÓRICO DE ETAPA</strong></li>
    </ul>
    <table class='table table-condensed'>
        <thead>
            <tr>
                <th>Data</th>
                <th>Etapa do projeto</th>
            </tr>
        </thead>
            <?php
            $sql_lista_historico = "SELECT et.etapaProjeto, he.data AS data FROM historico_etapa AS he INNER JOIN etapa_projeto AS et ON he.idEtapaProjeto = et.idEtapaProjeto WHERE he.idProjeto = '$idProjeto' ORDER BY he.data,he.idEtapaProjeto";
            $query_lista_historico = mysqli_query($con,$sql_lista_historico);
            $num = mysqli_num_rows($query_lista_historico);
            if($num > 0){
                while($historico = mysqli_fetch_array($query_lista_historico))
                {
                    echo "<tr>";
                    echo "<td>".exibirDataHoraBr($historico['data'])."</td>";
                    echo "<td>".$historico['etapaProjeto']."</td>";
                    echo "</tr>";
                }
            }
            else
            {
                    echo "<tr><td>Não há registros disponíveis.</td></tr>";
            }
            ?>
    </table>
    <br/>

    <ul class='list-group'>
        <li class='list-group-item list-group-item-success'><strong>SOLICITAÇÕES DO PROPONENTE JÁ ANALISADAS</strong></li>
    </ul>
    <table class='table table-condensed'>
        <thead>
            <tr class='list_menu'>
                <td>Tipo de arquivo</td>
                <td>Data de Envio</td>
            </tr>
        </thead>
        <tbody>
        <?php listaAnexosAnalisadosProjetoSMC($idProjeto, 3, "smc_detalhes_projeto"); ?>
        </tbody>
    </table>

    <br/>
    <table class='table table-condensed'>
        <ul class='list-group'>
            <li class='list-group-item list-group-item-success'><strong>HISTÓRICO DO PARECERISTA</strong></li>
        </ul>
        <thead>
        <tr>
            <th>Data</th>
            <th>Etapa do projeto</th>
            <th>Data da reunião</th>
            <th>Status de análise</th>
            <th>Parecerista</th>
            <th>Usuário</th>
        </tr>
        </thead>
        <?php
        $sql_lista_historico = "
          SELECT ep.etapaProjeto AS h_ep, rn.data AS dt, rn.dataReuniao, pr.status AS pr_s, cm.nome, us.nome AS user 
          FROM historico_reuniao AS rn 
          LEFT JOIN pessoa_fisica AS cm ON rn.idComissao = cm.idPf 
          INNER JOIN status_parecerista AS pr ON rn.idStatusParecerista = pr.idStatusParecerista 
          INNER JOIN pessoa_fisica AS us ON rn.idUsuario = us.idPf 
          INNER JOIN etapa_projeto AS ep ON rn.idEtapaProjeto = ep.idEtapaProjeto 
          WHERE rn.idProjeto = '$idProjeto' ORDER BY rn.data,rn.idEtapaProjeto";
        $query_lista_historico = mysqli_query($con,$sql_lista_historico);
        $num = mysqli_num_rows($query_lista_historico);
        if($num > 0)
        {
            while($historico = mysqli_fetch_array($query_lista_historico))
            {
                echo "<tr>";
                echo "<td>".exibirDataHoraBr($historico['dt'])."</td>";
                echo "<td>".$historico['h_ep']."</td>";
                echo "<td>".exibirDataBr($historico['dataReuniao'])."</td>";
                echo "<td>".$historico['pr_s']."</td>";
                echo "<td>".$historico['nome']."</td>";
                echo "<td>".$historico['user']."</td>";
                echo "</tr>";
            }
        }
        else
        {
            echo "<tr><td>Não há registros disponíveis.</td></tr>";
        }
        ?>
    </table>
    <br/>
</div>
