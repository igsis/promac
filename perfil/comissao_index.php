<?php
$con = bancoMysqli();

$idPf = $_SESSION['idUser'];
$pf = recuperaDados("pessoa_fisica", "idPf", $idPf);

if ($pf['idNivelAcesso'] == 2) {
    echo "<script>window.location = '?perfil=smc_index';</script>";
}
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">

        <?php include 'includes/menu_comissao.php'; ?>
        <p align="left"><strong><?php echo saudacao(); ?>, <?php echo $_SESSION['nome']; ?></strong></p>

        <ul class="nav nav-tabs">
            <li class="nav active"><a href="#comissao" data-toggle="tab">Área Comissão</a></li>
            <?php
            if ($pf['idNivelAcesso'] != 4)
            {
            ?>
            <li class="nav"><a href="#smc" data-toggle="tab">Área SMC</a></li>

                <div class="tab-content">
                    <div class="tab-pane fade in active" id="comissao">
                        <?php include "includes/comissao_area_index.php"; ?>
                    </div>

            <div class="tab-pane fade" id="smc">
                <?php include "includes/smc_area_index.php"; ?>
            </div>

    </div>
            <?php
            } else if ($pf['idNivelAcesso'] == 4) {
                ?>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="comissao">
                        <?php include "includes/comissao_index_smc.php"; ?>
                    </div>
                </div>
                <?php
            }
    ?>
    </ul>


    </div>
</section>
