<?php require_once "./controllers/ProjetoController.php"; ?>
<li class="nav-item">
    <a href="<?= SERVERURL ?>fomentos/inicio" class="nav-link" id="fomentos_inicio">
        <i class="fa fa-info nav-icon"></i>
        <p>Lista Projetos</p>
    </a>
</li>
<hr/>
<?php
    if (isset($_SESSION['projeto_c'])):
    $objProjeto = new ProjetoController();
    $projeto = $objProjeto->recuperaProjeto($_SESSION['projeto_c']);
?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>fomentos/projeto_cadastro" class="nav-link" id="projeto">
            <i class="far fa-circle nav-icon"></i>
            <p>Projeto</p>
        </a>
    </li>

    <?php if ($projeto['representante_nucleo'] != "Não se aplica"): ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>fomentos/nucleo_artistico_lista" class="nav-link" id="nucleo_artistico">
                <i class="far fa-circle nav-icon"></i>
                <p>Núcleo artístico</p>
            </a>
        </li>
    <?php endif ?>
    <?php if (!isset($_SESSION['origem_id_c']) && $_SESSION['tipo_pessoa'] == 2): ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>fomentos/proponentePj" class="nav-link" id="buscaProponente">
                <i class="fas fa-search-plus nav-icon"></i>
                <p>Buscar empresa</p>
            </a>
        </li>
    <?php endif; ?>
    <?php if (isset($_SESSION['origem_id_c']) && $_SESSION['tipo_pessoa'] == 2): ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>fomentos/pj_cadastro&id=<?= $_SESSION['origem_id_c'] ?>" class="nav-link"
               id="proponente">
                <i class="far fa-circle nav-icon"></i>
                <p>Empresa</p>
            </a>
        </li>
    <?php endif ?>
    <?php if (!isset($_SESSION['origem_id_c']) && $_SESSION['tipo_pessoa'] == 1): ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>fomentos/proponentePf" class="nav-link" id="buscaProponente">
                <i class="fas fa-search-plus nav-icon"></i>
                <p>Buscar pessoa física</p>
            </a>
        </li>
    <?php endif; ?>
    <?php if (isset($_SESSION['origem_id_c']) && $_SESSION['tipo_pessoa'] == 1): ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>fomentos/pf_cadastro&id=<?= $_SESSION['origem_id_c'] ?>" class="nav-link"
               id="proponente">
                <i class="far fa-circle nav-icon"></i>
                <p>Pessoa Física</p>
            </a>
        </li>
    <?php endif ?>
    <?php if (isset($_SESSION['origem_id_c'])): ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>fomentos/anexos" class="nav-link" id="anexos">
                <i class="far fa-circle nav-icon"></i>
                <p>Anexos</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>fomentos/finalizar" class="nav-link" id="finalizar">
                <i class="far fa-circle nav-icon"></i>
                <p>Finalizar</p>
            </a>
        </li>
    <?php endif; ?>
<?php endif; ?>
