<?php
$con = bancoMysqli();

//verifica a página atual caso seja informada na URL, senão atribui como 1ª página
$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;
$sql_lista = "SELECT protocolo,nomeProjeto,nome,observacao,data,acao 
            FROM historico_cancelamento as hst 
            INNER JOIN pessoa_fisica AS usr ON hst.idUsuario = usr.idPf 
            INNER JOIN projeto AS prj ON hst.idProjeto = prj.idProjeto
            ORDER BY data DESC, hst.idProjeto ASC";
$query_lista = mysqli_query($con,$sql_lista);

//conta o total de itens
$total_geral = mysqli_num_rows($query_lista);

//seta a quantidade de itens por página
$registros = 50;

//calcula o número de páginas arredondando o resultado para cima
$numPaginas = ceil($total_geral/$registros);

//variavel para calcular o início da visualização com base na página atual
$inicio = ($registros*$pagina)-$registros;

//seleciona os itens por página
$sql_lista = "SELECT hst.idProjeto AS id,protocolo,nomeProjeto,nome,observacao,data,acao 
            FROM historico_cancelamento as hst 
            INNER JOIN pessoa_fisica AS usr ON hst.idUsuario = usr.idPf 
            INNER JOIN projeto AS prj ON hst.idProjeto = prj.idProjeto
            ORDER BY data DESC, hst.idProjeto ASC LIMIT $inicio,$registros";
$query_lista = mysqli_query($con,$sql_lista);

//conta o total de itens
$total = mysqli_num_rows($query_lista);
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
        <ul class='list-group'>
            <li class='list-group-item list-group-item-success'><strong>HISTÓRICO DE PROJETOS CANCELADOS</strong></li>
        </ul>
        <hr>
        <div class="form-group">
			<h6 class="text-success"><?php echo $mensagem ?? '' ;?></h6>
		</div>

        <table class='table table-condensed'>
            <thead>
                <th>Protocolo</th>
                <th>Nome projeto</th>
                <th>Usuário responsável</th>
                <th>Motivo</th>
                <th>Data</th>
            </thead>
            <?php
            echo "<tbody>";
            $num = mysqli_num_rows($query_lista);
            if($num > 0){
                while($historico = mysqli_fetch_array($query_lista))
                {
                    echo "<tr>";
                    echo "<td>".$historico['protocolo']."</td>";
                    echo "<td>". mb_strimwidth($historico['nomeProjeto'], 0 ,35,"..." )."</td>";
                    echo "<td>".$historico['nome']."</td>";
                    echo "<td>".$historico['observacao']."</td>";
                    echo "<td>".exibirDataHoraBr($historico['data'])."</td>";
                    ?>
                <?php
                }
                echo "<tr>";
                echo "<td colspan=\"7\" bgcolor=\"#DEDEDE\">";
                    echo "<strong>Páginas</strong>";
                    echo "<table>";
                    echo "<tr>";
                    for($i = 1; $i < $numPaginas + 1; $i++)
                    {
                        echo "<td>";
                        echo "<form method='POST' action='?perfil=smc_historico_cancelamento&pagina=$i'>";
                        echo "<button class='btn btn-theme btn-xs' type='submit' style='border-radius: 30px;' name='consulta' value='1'>$i</button>";
                        echo "</form>";
                        echo "</td>";
                    }
                    echo "</tr>";
                    echo "</table>";
                echo "</td>";
                echo "</tr>";
            }
            else
            {
                echo "<tr><td>Não há registros disponíveis.</td></tr>";
            }
            echo "</tbody>";
            ?>
        </table>
    </div>
</section>