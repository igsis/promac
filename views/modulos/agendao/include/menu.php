<li class="nav-item">
    <a href="<?= SERVERURL ?>agendao/inicio" class="nav-link" id="evento_cc_inicio">
        <i class="fa fa-info nav-icon"></i>
        <p>Dados necessários</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= SERVERURL ?>agendao/evento_lista" class="nav-link" id="evento_lista">
        <i class="far fa-circle nav-icon"></i>
        <p>Eventos</p>
    </a>
</li>
<?php if (isset($_SESSION['origem_id_c'])): ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>agendao/evento_cadastro" class="nav-link" id="evento_cc_cadastro">
            <i class="far fa-circle nav-icon"></i>
            <p>Informações Iniciais</p>
        </a>
    </li>
<?php endif; ?>