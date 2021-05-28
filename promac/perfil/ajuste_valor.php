<?php
$con = bancoMysqli();

if(isset($_POST['executar'])){
    $projetos = $con->query("SELECT idProjeto, valorProjeto FROM projeto WHERE edital = 2020")->fetch_all(MYSQLI_ASSOC);

    foreach ($projetos as $projeto) {

        if ($projeto['valorProjeto'] == 0.00) {
            $sqlOrcamento = "SELECT SUM(valorTotal) AS tot FROM orcamento
                            WHERE publicado > 0 AND idProjeto = {$projeto['idProjeto']}
                            ORDER BY idOrcamento;";
            $valorTotal = $con->query($sqlOrcamento)->fetch_assoc()['tot'];
            $valorTotal = $valorTotal == null ? '0.00' : $valorTotal;
            $sqlValorTotal = "UPDATE projeto SET valorProjeto = '$valorTotal' WHERE idProjeto = {$projeto['idProjeto']}";
            $queryValorTotal = $con->query($sqlValorTotal);
        }
    }
}


?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include 'includes/menu_smc.php'; ?>
        <p align="left"><strong><?php echo saudacao(); ?>, <?php echo $_SESSION['nome']; ?></strong></p>
        <div class="form-group">
            <h5>
                <?php if (isset($mensagem)) {echo $mensagem;} ?>
            </h5>
        </div>
        <div class="form-group">
            <div class="row">
                <div class='col-md-12'>
                    <label><h6>Bora Executa sáparada</label>
                </div>
                <div class='col-md-offset-4 col-md-2 col-md-push-1'>
                    <form method='post' action='?perfil=ajuste_valor' class='form-group' role='form'>
                        <input type='submit' name='executar' class='btn btn-theme btn-md btn-block' value='Olho no Lance'>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
