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
            $sql_lista_historico = "SELECT st.status, hs.data AS data FROM historico_status AS hs INNER JOIN status AS st ON hs.idStatus = st.idStatus WHERE hs.idProjeto = '$idProjeto' ORDER BY hs.data,hs.idStatus";
            $query_lista_historico = mysqli_query($con,$sql_lista_historico);
            $num = mysqli_num_rows($query_lista_historico);
            if($num > 0){
                while($historico = mysqli_fetch_array($query_lista_historico))
                {
                    echo "<tr>";
                    echo "<td>".exibirDataHoraBr($historico['data'])."</td>";
                    echo "<td>".$historico['status']."</td>";
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
    <table class='table table-condensed'>
        <ul class='list-group'>
            <li class='list-group-item list-group-item-success'><strong>HISTÓRICO DE REUNIÃO</strong></li>
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
        $sql_lista_historico = "SELECT st.status AS h_st, rn.data AS dt, rn.dataReuniao, pr.status AS pr_s, cm.nome, us.nome AS user FROM historico_reuniao AS rn LEFT JOIN pessoa_fisica AS cm ON rn.idComissao = cm.idPf INNER JOIN status_parecerista AS pr ON rn.idStatusParecerista = pr.idStatusParecerista INNER JOIN pessoa_fisica AS us ON rn.idUsuario = us.idPf INNER JOIN status AS st ON rn.idStatus = st.idStatus WHERE rn.idProjeto = '$idProjeto' ORDER BY rn.data,rn.idStatus";
        $query_lista_historico = mysqli_query($con,$sql_lista_historico);
        $num = mysqli_num_rows($query_lista_historico);
            if($num > 0)
            {
                while($historico = mysqli_fetch_array($query_lista_historico))
                {
                    echo "<tr>";
                    echo "<td>".exibirDataHoraBr($historico['dt'])."</td>";
                    echo "<td>".$historico['h_st']."</td>";
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

    <table class='table table-condensed'>
        <ul class='list-group'>
            <li class='list-group-item list-group-item-success'><strong>HISTÓRICO DE PUBLICAÇÃO</strong></li>
        </ul>
    <thead>
        <tr>
            <th>Data</th>
            <th>Etapa do projeto</th>
            <th>Data da publicação</th>
            <th>Link da publicação</th>
            <th>Usuário</th>
        </tr>
    </thead>

  <?php
    $sql_lista_historico = "SELECT st.status AS h_st, rn.data AS dt, rn.dataPublicacao, rn.linkPublicacao, us.nome AS user FROM historico_publicacao AS rn INNER JOIN pessoa_fisica AS us ON rn.idUsuario = us.idPf INNER JOIN status AS st ON rn.idStatus = st.idStatus WHERE rn.idProjeto = '$idProjeto' ORDER BY rn.data,rn.idStatus";
            $query_lista_historico = mysqli_query($con,$sql_lista_historico);
            $num = mysqli_num_rows($query_lista_historico);
                if($num > 0)
                    {
                        while($historico = mysqli_fetch_array($query_lista_historico))
                        {
                            echo "<tr>";
                            echo "<td>".exibirDataHoraBr($historico['dt'])."</td>";
                            echo "<td>".$historico['h_st']."</td>";
                            echo "<td>".exibirDataBr($historico['dataPublicacao'])."</td>";
                            echo "<td>".$historico['linkPublicacao']."</td>";
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
</div>
