<?php
require_once "./controllers/ProponentePfController.php";
$pfObj = new ProponentePfController();
$pf = $pfObj->recuperaProponentePf($_SESSION['usuario_id_p']);
?>

<li class="nav-header">INSCRIÇÃO</li>
<li class="nav-item">
    <a href="<?= SERVERURL ?>inicio/inicio" class="nav-link" id="inicio">
        <i class="fa fa-info nav-icon"></i>
        <p>Início</p>
    </a>
</li>
<?php if ($pf->liberado == 0 || $pf->liberado == 3): ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>inscricao/proponente_pf_cadastro" class="nav-link" id="proponente_pf_cadastro">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados pessoais</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>inscricao/anexos" class="nav-link" id="anexos">
            <i class="far fa-circle nav-icon"></i>
            <p>Documentos</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>inscricao/finalizar_pf" class="nav-link" id="finalizar_pf">
            <i class="far fa-circle nav-icon"></i>
            <p>Finalizar inscrição</p>
        </a>
    </li>
<?php endif; ?>