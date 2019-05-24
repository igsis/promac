<?php
$con = bancoMysqli();
$idPf = $_SESSION['idUser'];
$enviado = 0;
$tipoPessoa = 3;

if (isset($_POST['enviarSMC'])) {
    $idPf = $_POST['idPf'];
    $sql = "UPDATE incentivador_pessoa_fisica SET liberado = 4 WHERE idPf = $idPf";

    if (mysqli_query($con, $sql)) {
        $enviado = 1;
        $mensagem = "<font color='#01DF3A'><strong>Suas certidões de regularidade fiscal foram enviadas à SMC!</strong></font>";
        gravarLog($sql);

    }
}


if ($enviado == 0) {
    ?>
    <form method="POST">
        <div class="well">
            <label for="admResposta">Você deseja incentivar um projeto agora?</label><br>
            <input type="radio" name="admResposta" value="1" class="resposta" id="sim" onclick="verificaResposta()"> Sim
            <input type="radio" name="admResposta" value="0" class="resposta" id="nao" onclick="verificaResposta()"> Não

            <div id="aviso" style="display: none;">
                <hr>
                <div class='alert alert-warning'>
                    Para encontrar um projeto para incentivar, continue buscando os projetos aprovados semanalmente na
                    Consulta Pública disponível na Home do site PROMAC.<br> Depois de escolher o projeto que deseja
                    incentivar, retorne a essa página, por gentileza.
                </div>
            </div>
        </div>
    </form>
    <?php
} else {
    ?>

    <section id="list_items" class="home-section">
        <div class="container">
            <div class="form-group">
                <div class="col-md-12">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-success"><strong>Acompanhe o andamento da análise de sua
                                regularidade
                                fiscal pelo sistema.</strong></li>
                    </ul>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <div class="table-responsive list_info"><h6>Arquivo(s) Anexado(s)</h6>
                        <?php
                        listaArquivosPessoa($idPf, $tipoPessoa, "includes/documentos_fiscais_incentivador_pf", "39, 40, 41, 42, 43, 53");
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
}
?>

<script>
    function verificaResposta() {
        if ($('#nao').is(':checked')) {
            $('#aviso').css('display', 'block');
            $('#incentivar').css('display', 'none');
        } else if ($('#sim').is(':checked')) {
            //$('#aviso').css('display', 'none');
            location.href = '?perfil=includes/documentos_fiscais_incentivador_pf'
        }
    }
</script>