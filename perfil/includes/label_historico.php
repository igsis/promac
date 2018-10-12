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
</div>
