<?php
require_once "./controllers/IncentivadorPjController.php";
$pjObj = new IncentivadorPjController();
$pj = $pjObj->recuperaIncentivadorPJ($_SESSION['usuario_id_p']);
?>

<li class="nav-header">INSCRIÇÃO</li>
<li class="nav-item">
    <a href="<?= SERVERURL ?>inicio/inicio" class="nav-link" id="inicio_inicio">
        <i class="fa fa-info nav-icon"></i>
        <p>Início</p>
    </a>
</li>
<?php if ($pj->liberado == 0 || $pj->liberado == 3): ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>inscricao/proponente_pj_cadastro" class="nav-link" id="proponente_pf_cadastro">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados pessoais</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>inscricao/representante" class="nav-link" id="proponente_pf_cadastro">
            <i class="far fa-circle nav-icon"></i>
            <p>Representante legal</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>inscricao/proponente_pj_documentos" class="nav-link" id="proponente_pf_documentos">
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