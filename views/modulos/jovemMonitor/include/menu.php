<li class="nav-item">
    <a href="<?= SERVERURL ?>jovemMonitor/inicio" class="nav-link" id="evento_cc_inicio">
        <i class="fa fa-info nav-icon"></i>
        <p>Dados necessários</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= SERVERURL ?>jovemMonitor/proponente" class="nav-link" id="proponente">
        <i class="far fa-circle nav-icon"></i>
        <p>Busca</p>
    </a>
</li>
<?php if (isset($_SESSION['origem_id_c'])){
    ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>jovemMonitor/pf_cadastro&id=<?=$_SESSION['origem_id_c']?>" class="nav-link" id="proponente">
            <i class="far fa-circle nav-icon"></i>
            <p>Cadastro</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>jovemMonitor/anexos_proponente" class="nav-link" id="anexos-proponente">
            <i class="far fa-circle nav-icon"></i>
            <p>Anexos</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>jovemMonitor/finalizar" class="nav-link" id="finalizar">
            <i class="far fa-circle nav-icon"></i>
            <p>Finalizar</p>
        </a>
    </li>
<?php } ?>
