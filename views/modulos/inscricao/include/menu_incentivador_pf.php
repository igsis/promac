<?php
require_once "./controllers/IncentivadorPfController.php";
$pfObj = new IncentivadorPfController();
$pf = $pfObj->recuperaIncentivadorPf($_SESSION['usuario_id_p']);
?>

<li class="nav-header">INSCRIÇÃO</li>
<li class="nav-item">
    <a href="<?= SERVERURL ?>inicio/inicio" class="nav-link" id="inicio_inicio">
        <i class="fa fa-info nav-icon"></i>
        <p>Início</p>
    </a>
</li>
<?php if ($pf->liberado == 0 || $pf->liberado == 3): ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>inscricao/incentivador_pf_cadastro" class="nav-link" id="incentivador_pf_cadastro">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados pessoais</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>inscricao/incentivador_pf_documentos" class="nav-link" id="incentivador_pf_documentos">
            <i class="far fa-circle nav-icon"></i>
            <p>Documentos</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>inscricao/finalizar" class="nav-link" id="finalizar">
            <i class="far fa-circle nav-icon"></i>
            <p>Finalizar inscrição</p>
        </a>
    </li>
<?php endif; ?>