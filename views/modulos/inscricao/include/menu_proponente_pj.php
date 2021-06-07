<?php
require_once "./controllers/ProponentePjController.php";
$pjObj = new ProponentePjController();
$pj = $pjObj->recuperaProponentePj($_SESSION['usuario_id_p']);

if (isset($pj->representante_legal_id)){
    $link_rep = SERVERURL . "inscricao/representante_cadastro?idPj=".$_SESSION['usuario_id_p']."&id=" . (new MainModel)->encryption($pj->representante_legal_id);
} else{
    $link_rep = SERVERURL . "inscricao/representante?idPj=".$_SESSION['usuario_id_p'];
}
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
        <a href="<?= $link_rep ?>" class="nav-link" id="representante_cadastro">
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