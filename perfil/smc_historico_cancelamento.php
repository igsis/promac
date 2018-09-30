<?php
$con = bancoMysqli();

if(isset($_POST['reativarProjeto'])){
    $idProjeto = $_POST['idProjeto'];
    $observacao= $_POST['observacao'];
    $idUser = $_SESSION['idUser'];
    $dateNow = date('Y-m-d H:i:s');

    $sql_cancelar = "UPDATE projeto SET publicado = 1 WHERE idProjeto = '$idProjeto'";
    if(mysqli_query($con,$sql_cancelar)){
        $sql_historico_cancelamento = "INSERT INTO historico_cancelamento (idProjeto, observacao, idUsuario, data, acao) VALUES ('$idProjeto', '$observacao','$idUser','$dateNow',2)";
        if(mysqli_query($con,$sql_historico_cancelamento)){
            $mensagem = "<span style=\"color: #01DF3A; \"><strong>Projeto reativado com sucesso!<br/>Aguarde....</strong></span>";
            gravarLog($sql_historico_cancelamento);
            echo "<meta HTTP-EQUIV='refresh' CONTENT='0.5;URL=?perfil=smc_historico_cancelamento'>";
        }
        else{
            $mensagem = "<span style=\"color: #FF0000; \"><strong>Erro ao reativar projeto. Tente novamente!</strong></span>";
        }
    }
}

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
            <li class='list-group-item list-group-item-success'><strong>HISTÓRICO DE PROJETOS CANCELADOS E REATIVADOS</strong></li>
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
                <th>Ação</th>
                <th></th>
            </tr>
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
                    if($historico['acao'] == 1){
                        echo "<td>Cancelado</td>";
                    }
                    else{
                        echo "<td>Reativado</td>";
                    }
                    echo "<td><button class='btn btn-danger btn-sm' style=\"border-radius: 10px;\" type='button' data-toggle='modal' data-target='#confirmReativar' >Reativar</button></td>";
                    echo "</tr>";
                    ?>
                    <!-- Confirmação de Reativação -->
                    <div class="modal fade" id="confirmReativar" role="dialog" aria-labelledby="confirmReativarLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" id='cancelarProjeto' action="?perfil=smc_historico_cancelamento" class="form-horizontal" role="form">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title"><p>Reativação de projeto</p></h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Qual o motivo da reativação do projeto?</p>
                                        <input type="text" name="observacao" class="form-control" required maxlength="120">
                                    </div>
                                    <div class="modal-footer">
                                        <input type='hidden' name='idProjeto' value='<?= $historico['id'] ?>'>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                        <button type='submit' class='btn btn-danger btn-sm' style="border-radius: 10px;" name="reativarProjeto">Confirmar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Fim Confirmação de Reativação -->
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